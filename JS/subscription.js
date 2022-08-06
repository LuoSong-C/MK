// 分割条颜色
let spans = document.querySelector('.parting').querySelectorAll('span');
for (let i = 0; i < spans.length; i++) {
    let random = new_random(spans.length - 1, 0);
    spans[i].style.backgroundColor = color_list[random];
};

if (checkCookie("email")) {
    class_select(".list_content_no", 0).style.display = 'none';
    class_select(".list_content", 0).style.display = 'flex';
};