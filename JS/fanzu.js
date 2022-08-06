// 分割条颜色
let spans = document.querySelector('.parting').querySelectorAll('span');
for (let i = 0; i < spans.length; i++) {
    let random = new_random(spans.length - 1, 0);
    spans[i].style.backgroundColor = color_list[random];
};