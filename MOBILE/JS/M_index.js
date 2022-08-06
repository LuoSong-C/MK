const weekdays = ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
const weekday_colors = ['#09d9ff', '#f13f84', '#a3d76e', '#c837ed', '#ff745a', '#ffcc00', '#7ac034', '#00dbc2', '#ff9e6d'];

let navbar = class_select(".navbar", 0);
let sidenav = class_select(".sidenav", 0);
let sideFlag = true;
navbar.addEventListener('click', function () {
    if (sideFlag) {
        sidemove(sidenav, "left", 0, -6, 0, 0.15, 10);
        sideFlag = false;
    } else {
        sidemove(sidenav, "left", 1, 0, -6.1, 0.15, 10);
        sideFlag = true;
    }
});

// 对应显示星期和颜色
let date = new Date();
let weekTops = class_select(".top", 1);
let weekDays_now = date.getDay();
let weekDays_count;
let num_count = 0;
for (weekDays_count = weekDays_now; weekDays_count < weekdays.length; weekDays_count++) {
    // 主内容对应头部颜色和显示，添加颜色顺序标识
    weekTops[num_count].style.backgroundImage = 'linear-gradient(to right, ' + weekday_colors[weekDays_count] + ', #fff)';
    weekTops[num_count++].innerHTML = weekdays[weekDays_count];
};
weekDays_count = 0;
for (weekDays_count; weekDays_count < weekDays_now; weekDays_count++) {
    // 主内容对应头部颜色和显示，添加颜色顺序标识
    weekTops[num_count].style.backgroundImage = 'linear-gradient(to right, ' + weekday_colors[weekDays_count] + ', #fff)';
    weekTops[num_count++].innerHTML = weekdays[weekDays_count];
};
/* 为剩下的两个子元素添加颜色顺序标识 */
for (let i = 7; i < 9; i++) {
    weekTops[i].style.backgroundImage = 'linear-gradient(to right, ' + weekday_colors[i] + ', #fff)';
};

// 密码显示
let register = class_select(".register", 0);
let login = class_select(".login", 0);
let userinfo = class_select(".userinfo", 0);
let inputs = register.querySelectorAll('input');
let inputs_login = login.querySelectorAll('input');
let eyesOne = class_select(".eyes", 0);
let eyesTwo = class_select(".eyesTwo", 0);
let eyesThree = class_select(".eyesThree", 0);
let eyes_flagOne = true;
eyesOne.addEventListener('click', function () {
    if (eyes_flagOne) {
        this.src = '../IMAGES/open.png';
        inputs[2].type = 'text';
        eyes_flagOne = false;
    } else {
        this.src = '../IMAGES/close.png';
        inputs[2].type = 'password';
        eyes_flagOne = true;
    }
});
let eyes_flagTwo = true;
eyesTwo.addEventListener('click', function () {
    if (eyes_flagTwo) {
        this.src = '../IMAGES/open.png';
        inputs[3].type = 'text';
        eyes_flagTwo = false;
    } else {
        this.src = '../IMAGES/close.png';
        inputs[3].type = 'password';
        eyes_flagTwo = true;
    }
});

let eyes_flagThree = true;
eyesThree.addEventListener('click', function () {
    if (eyes_flagThree) {
        this.src = '../IMAGES/open.png';
        inputs_login[1].type = 'text';
        eyes_flagThree = false;
    } else {
        this.src = '../IMAGES/close.png';
        inputs_login[1].type = 'password';
        eyes_flagThree = true;
    }
});

inputs_login[2].addEventListener('click', function () {
    if (inputs_login[0].value.length != 0 && inputs_login[1].value.length != 0) {
        inputs_login[0].value = inputs_login[0].value.trim();
        inputs_login[1].value = inputs_login[1].value.trim();
    };
});

// 密码提示
let more = class_select(".more", 0);
let password_more = class_select(".password_more", 0);
more.addEventListener('touchstart', function () {
    // console.log(password_more.style);
    if (password_more.style.display === '' || password_more.style.display === 'none') {
        password_more.style.display = 'block';
    } else {
        password_more.style.display = 'none';
    };
});

// 验证用户输入
// inputs[4].disabled = true;
let right_count = 0;
let nameReg = /^(?!_)(?!.*?_$)[a-zA-Z0-9_\u4e00-\u9fa5]{0,20}$/;
let emailReg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
let passwordReg = /^(?![0-9]+$)(?![a-zA-Z]+$)(?![0-9a-zA-Z]+$)(?![0-9._!?]+$)(?![a-zA-Z._!?]+$)[0-9A-Za-z._!?]{6,18}$/;
inputs[0].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (nameReg.test(this.value)) {
            this.value = this.value.trim();
            right_count++;
        } else {
            alert('用户名输入有误，请重新输入！');
            this.value = '';
        };
    };
});
inputs[1].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (emailReg.test(this.value)) {
            right_count++;
            this.value = this.value.trim();
        } else {
            alert('邮箱输入有误，请重新输入！');
            this.value = '';
        };
    };
});
inputs[2].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (passwordReg.test(this.value)) {
            right_count++;
            this.value = this.value.trim();
        } else {
            alert('密码输入有误，请重新输入！');
            this.value = '';
        };
    };
});
inputs[3].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (this.value == inputs[2].value) {
            right_count++;
            this.value = this.value.trim();
        } else {
            alert('与上次输入不匹配，请查证！');
            this.value = '';
        };
    };
});

// 注册登录互换
class_select(".toLogin", 0).addEventListener('click', function () {
    uSpeed(1, 0.1, 1, register);
    setTimeout(() => {
        register.style.display = 'none';
        login.style.display = 'flex';
        login.style.opacity = 0;
        uSpeed(0, 0.1, 0, login);
    }, 1000);
});
class_select(".toRegister", 0).addEventListener('click', function () {
    uSpeed(1, 0.1, 1, login);
    setTimeout(() => {
        login.style.display = 'none';
        register.style.display = 'flex';
        register.style.opacity = 0;
        uSpeed(0, 0.1, 0, register);
    }, 1000);
});

// 显示关闭个人信息栏
class_select(".info", 0).addEventListener('click', function () {
    if (checkCookie("email")) {
        if (userinfo.style.display == 'none' || userinfo.style.display == '') {
            userinfo.style.display = 'flex';
            userinfo.style.opacity = 0;
            uSpeed(0, 0.1, 0, userinfo);
        } else {
            uSpeed(1, 0.1, 1, userinfo);
            setTimeout(() => { userinfo.style.display = 'none'; }, 1000);
        };
    } else {
        alert("请先登录");
    }
});

// 显示关闭注册栏
class_select(".regi", 0).addEventListener('click', function () {
    if (register.style.display == 'none' || register.style.display == '') {
        register.style.display = 'flex';
        register.style.opacity = 0;
        uSpeed(0, 0.1, 0, register);
    } else {
        uSpeed(1, 0.1, 1, register);
        setTimeout(() => { register.style.display = 'none'; }, 1000);
    };
});

// 显示关闭登录栏
class_select(".logi", 0).addEventListener('click', function () {
    if (login.style.display == 'none' || login.style.display == '') {
        login.style.display = 'flex';
        login.style.opacity = 0;
        uSpeed(0, 0.1, 0, login);
    } else {
        uSpeed(1, 0.1, 1, login);
        setTimeout(() => { login.style.display = 'none'; }, 1000);
    };
});

// --顶部头像
if (checkCookie('headurl')) {
    class_select(".headimg", 0).querySelector('img').src = getCookie('headurl');
};
if (checkCookie('email')) {
    class_select(".logi", 0).innerHTML = '已登录';
    class_select(".logi", 0).disabled = true;
};

// 个人信息
let is = userinfo.querySelectorAll('i');
if (checkCookie("username")) {
    is[0].innerHTML = getCookie_zhCN('username');
};
if (checkCookie('email')) {
    is[1].innerHTML = getCookie('email');
};
if (checkCookie('tel')) {
    is[2].innerHTML = getCookie('tel');
};
if (checkCookie('sex')) {
    is[3].innerHTML = getCookie_zhCN('sex');
};
if (checkCookie('intro')) {
    is[4].innerHTML = getCookie_zhCN('intro');
};

// 关闭按钮
let close = class_select(".close", 1);
// --关闭注册栏
close[0].addEventListener('click', function () {
    uSpeed(1, 0.1, 1, register);
    setTimeout(() => { register.style.display = 'none'; }, 1000);
});
// --关闭登录栏
close[1].addEventListener('click', function () {
    uSpeed(1, 0.1, 1, login);
    setTimeout(() => { login.style.display = 'none'; }, 1000);
});
// --关闭个人信息栏
close[2].addEventListener('click', function () {
    uSpeed(1, 0.1, 1, userinfo);
    setTimeout(() => { userinfo.style.display = 'none'; }, 1000);
});
// --关闭广告资讯
close[3].addEventListener('click', function () {
    class_select(".ad", 0).style.display = 'none';
});