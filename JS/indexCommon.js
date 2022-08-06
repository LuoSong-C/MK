// --顶部时钟
let timer = document.querySelector('.timer').querySelectorAll('.clock');
let second = document.querySelector('.timer').querySelector('.second');
let ges = document.querySelector('.timer').querySelectorAll('.Ge');
timer_count(timer, second);
setInterval(() => {
    timer_count(timer, second);
}, 1000);
/* 顶部时钟分隔符 */
let ge_flash_flag = true;
setInterval(() => {
    ge_flash_flag = ge_flash(ges, ge_flash_flag);
}, 1000);

// --顶部头像
if (checkCookie('headurl')) {
    document.querySelector('.info').querySelector('img').src = getCookie('headurl');
};

// 广告资讯关闭
let ad = document.querySelector('.ad');
let ad_close = ad.querySelector('.close');
ad_close.addEventListener('click', () => {
    ad.style.display = 'none';
});