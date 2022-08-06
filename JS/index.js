const weekdays = ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
const weekday_colors = ['#09d9ff', '#f13f84', '#a3d76e', '#c837ed', '#ff745a', '#ffcc00', '#7ac034', '#00dbc2', '#ff9e6d'];

// --消除其他元素颜色（排他）
const remove_color = function (obj, seal, which, distance) {
    for (let i = 0; i < 9; i++) {
        if (which === i) {
            obj[which].style.color = '#fff';
            obj[which].style.backgroundColor = weekday_colors[obj[which].getAttribute('date-colorIndex')];
        } else {
            obj[i].style.color = weekday_colors[obj[i].getAttribute('date-colorIndex')];
            obj[i].style.backgroundColor = '#fff';
        }
    };
    seal.style.left = distance + 'px';
};

// --滚动应激函数
const scroll_do = function (scroll) {
    /* 30是nav高度70减去星期格高度30和间距10的结果 */
    if (scroll + 30 <= main_content_tops[0].offsetTop) {
        remove_color(nav_weekDays, seal, 0, 110);
    } else if (scroll + 30 <= main_content_tops[1].offsetTop) {
        remove_color(nav_weekDays, seal, 1, 260);
    } else if (scroll + 30 <= main_content_tops[2].offsetTop) {
        remove_color(nav_weekDays, seal, 2, 410);
    } else if (scroll + 30 <= main_content_tops[3].offsetTop) {
        remove_color(nav_weekDays, seal, 3, 560);
    } else if (scroll + 30 <= main_content_tops[4].offsetTop) {
        remove_color(nav_weekDays, seal, 4, 710);
    } else if (scroll + 30 <= main_content_tops[5].offsetTop) {
        remove_color(nav_weekDays, seal, 5, 860);
    } else if (scroll + 30 <= main_content_tops[6].offsetTop) {
        remove_color(nav_weekDays, seal, 6, 1010);
    } else if (scroll + 30 <= main_content_tops[7].offsetTop) {
        remove_color(nav_weekDays, seal, 7, 1160);
    } else if (scroll + 30 <= main_content_tops[8].offsetTop) {
        remove_color(nav_weekDays, seal, 8, 1310);
    };
};

// 导航栏，主体内容头部，分割条随时间变化的排序
let date = new Date();
let nav = document.querySelector('nav');
let seal = nav.querySelector('.seal');
let nav_weekDays = nav.querySelectorAll('li');
let parting = document.querySelector('.parting');
let parting_span = parting.querySelectorAll('span');
let main_content = document.querySelector('.main_content');
let main_content_tops = main_content.querySelectorAll('.top');
/* 添加自定义索引 9的数量是导航栏的小框个数*/
for (let i = 0; i < 9; i++) {
    nav_weekDays[i].setAttribute('date-index', i);
    main_content_tops[i].setAttribute('date-index', i);
};
/* 默认第一个nav子项为选中变色 */
nav_weekDays[0].style.backgroundColor = 'pink';
/* nav栏和内容栏显示对应的星期 */
let weekDays_now = date.getDay();
let weekDays_count;
let num_count = 0;
for (weekDays_count = weekDays_now; weekDays_count < weekdays.length; weekDays_count++) {
    // 分割条颜色，颜色数组放入数据
    parting_span[num_count].style.backgroundColor = weekday_colors[weekDays_count];
    // 主内容对应头部颜色和显示，添加颜色顺序标识
    main_content_tops[num_count].style.backgroundImage = 'linear-gradient(to right, ' + weekday_colors[weekDays_count] + ', #fff)';
    main_content_tops[num_count].innerHTML = weekdays[weekDays_count];
    main_content_tops[num_count].setAttribute('date-colorIndex', weekDays_count);
    // 导航栏对应颜色和显示，添加颜色顺序标识
    nav_weekDays[num_count].style.color = weekday_colors[weekDays_count];
    nav_weekDays[num_count].style.borderBottom = '2px solid ' + weekday_colors[weekDays_count];
    nav_weekDays[num_count].setAttribute('date-colorIndex', weekDays_count);
    nav_weekDays[num_count++].innerHTML = weekdays[weekDays_count];
};
weekDays_count = 0;
for (weekDays_count; weekDays_count < weekDays_now; weekDays_count++) {
    // 分割条颜色
    parting_span[num_count].style.backgroundColor = weekday_colors[weekDays_count];
    // 主内容对应头部颜色和显示，添加颜色顺序标识
    main_content_tops[num_count].style.backgroundImage = 'linear-gradient(to right, ' + weekday_colors[weekDays_count] + ', #fff)';
    main_content_tops[num_count].innerHTML = weekdays[weekDays_count];
    main_content_tops[num_count].setAttribute('date-colorIndex', weekDays_count);
    // 导航栏对应颜色和显示，添加颜色顺序标识
    nav_weekDays[num_count].style.color = weekday_colors[weekDays_count];
    nav_weekDays[num_count].style.borderBottom = '2px solid ' + weekday_colors[weekDays_count];
    nav_weekDays[num_count].setAttribute('date-colorIndex', weekDays_count);
    nav_weekDays[num_count++].innerHTML = weekdays[weekDays_count];
};
/* 为剩下的两个子元素添加颜色顺序标识 */
for (let i = 7; i < 9; i++) {
    main_content_tops[i].setAttribute('date-colorIndex', i);
    nav_weekDays[i].setAttribute('date-colorIndex', i);
    nav_weekDays[i].style.borderBottom = '2px solid ' + weekday_colors[i];
    main_content_tops[i].style.backgroundImage = 'linear-gradient(to right, ' + weekday_colors[i] + ', #fff)';
    parting_span[i].style.backgroundColor = weekday_colors[i];
};
parting_span[9].style.backgroundColor = '#fff'; // 落下的最后一个分割条
/* 利用事件冒泡实现锚点以及点击变色 */
nav.addEventListener('click', function (e) {
    let index = e.target.getAttribute('date-index');
    // 获取可视窗口范围
    let window_size = get_window_size();
    let body_size = get_body_size();
    let distance = main_content_tops[index].offsetTop;
    // 消除锚点触发时bug(有可能锚点坐标永远到不了)
    if (body_size[1] - distance + 80 >= window_size[1]) {
        // 减去70的原因是导航栏有70的高
        Anchor_point(main_content_tops[index], distance - 80);
    } else {
        Anchor_point(main_content_tops[index], body_size[1] - window_size[1]);
    }
}, false);

// 鼠标放上边框变化
for (let i = 0; i < 9; i++) {
    nav_weekDays[i].addEventListener('mouseover', function () {
        this.style.borderTopColor = weekday_colors[this.getAttribute('date-colorIndex')];
    });
    nav_weekDays[i].addEventListener('mouseout', function () {
        // this.style.border = 'none';
        this.style.borderTopColor = 'transparent';
    });
};

// 滚动显示对应星期几
scroll_do(get_web_scroll());
document.addEventListener('scroll', () => {
    let scroll = get_web_scroll();
    scroll_do(scroll);
});

// 回到顶部
let toTop = document.querySelector('.toTop');
toTop.addEventListener('click', () => {
    Anchor_point(this, 0);
});