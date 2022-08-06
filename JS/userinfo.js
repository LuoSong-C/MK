let tags = document.querySelector('.tag').querySelectorAll('div');
let tag_img = document.querySelector('.tag').querySelector('img');
let userinfo = document.querySelector('.userinfo');
let subscription = document.querySelector('.subscription_out');
// 个人与订阅切换
for (let i = 0; i < tags.length; i++) {
    tags[i].addEventListener('mouseover', function () {
        this.style.boxShadow = '0px 4px 30px rgba(20, 20, 20, 0.5)';
    }, false);
    tags[i].addEventListener('mouseout', function () {
        this.style.boxShadow = '0px 0px 15px rgba(66, 132, 255, 0.5)';
    }, false);
};
let flag = false;
tags[0].addEventListener('click', function () {
    tag_img.style.top = 60 + 'px';
    if (flag) {
        subscription.style.opacity = 1;
        uSpeed(1, 0.1, 1, subscription);
        setTimeout(() => {
            userinfo.style.display = 'flex';
            subscription.style.display = 'none';
            userinfo.style.opacity = 0;
            uSpeed(0, 0.1, 0, userinfo);
        }, 1000);
        flag = false;
    };
});
tags[1].addEventListener('click', function () {
    tag_img.style.top = 220 + 'px';
    if (!flag) {
        userinfo.style.opacity = 1;
        uSpeed(1, 0.1, 1, userinfo);
        setTimeout(() => {
            userinfo.style.display = 'none';
            subscription.style.display = 'block';
            subscription.style.opacity = 0;
            uSpeed(0, 0.1, 0, subscription);
        }, 1000);
        flag = true;
    };
});

// 登陆后显示订阅
if (checkCookie("email")) {
    class_select(".nologin").style.display = 'none';
    class_select(".subscription").style.display = 'block';
};

// 图片替换
let CROPPER = null;
let sub = document.querySelector('.sub'); // 提交按钮禁用
let sure = document.querySelector('.sure'); // 操作结束确定按钮
let bigImg = document.querySelector('.bigImg'); // 图片操作栏
function previewFile() {
    sub.disabled = true;
    const file = document.querySelector('#changeHeade').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        // convert image file to base64 string
        // preview.src = reader.result;
        document.getElementById('cropImg').src = reader.result;
        const image = document.getElementById('cropImg');
        // 两个框渐渐显示
        bigImg.style.display = 'block';
        sure.style.display = 'block';
        bigImg.style.opacity = 0;
        sure.style.opacity = 0;
        uSpeed(0, 0.1, 0, bigImg);
        uSpeed(0, 0.1, 0, sure);

        //创建cropper实例-----------------------------------------
        if (!CROPPER) {
            CROPPER = new Cropper(image, {
                aspectRatio: 16 / 16,
                viewMode: 1,
                minContainerWidth: 500,
                minContainerHeight: 500,
                minCanvasWidth: 160,//canvas的最小宽高度。
                minCanvasHeight: 160,
                dragMode: 'move',
                preview: [document.querySelector('.Img')]
            });
        } else {
            // 实现图片更换
            CROPPER.reset().replace(URL.createObjectURL(file));
        };
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    };
};

// 选择好图片后确定关闭操作栏
sure.addEventListener('click', function () {
    let base64 = CROPPER.getCroppedCanvas({
        maxWidth: 4096,
        maxHeight: 4096,
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    }).toDataURL('image/jpeg');
    document.querySelector('.baseImg').value = base64;
    sub.disabled = false;
    uSpeed(1, 0.1, 1, bigImg);
    uSpeed(1, 0.1, 1, sure);
    setTimeout(() => {
        bigImg.style.display = 'none';
        sure.style.display = 'none';
    }, 1000)
});

// 开启关闭头像修改栏
let images = document.querySelector('.images').querySelector('img');
let headImg = document.querySelector('.headImg');
let close_head = headImg.querySelector('.close');
images.addEventListener('click', function () {
    if (headImg.style.display == 'none' || headImg.style.display == '') {
        headImg.style.display = 'flex';
        headImg.style.opacity = 0;
        uSpeed(0, 0.1, 0, headImg);
        sub.disabled = true;
    } else {
        uSpeed(1, 0.1, 1, bigImg);
        uSpeed(1, 0.1, 1, sure);
        uSpeed(1, 0.1, 1, headImg);
        setTimeout(() => {
            headImg.style.display = 'none';
            bigImg.style.display = 'none';
            sure.style.display = 'none';
        }, 1000);
    };
});
close_head.addEventListener('click', function () {
    uSpeed(1, 0.1, 1, bigImg);
    uSpeed(1, 0.1, 1, sure);
    uSpeed(1, 0.1, 1, headImg);
    setTimeout(() => {
        headImg.style.display = 'none';
        bigImg.style.display = 'none';
        sure.style.display = 'none';
    }, 1000);
});

// 开启显示信息修改栏
let change_btn = document.querySelector('#changeIn');
let changeInfo = document.querySelector('.changeInfo');
let close_info = changeInfo.querySelector('.close_info');
change_btn.addEventListener('click', function () {
    if (changeInfo.style.display == 'none' || changeInfo.style.display == '') {
        changeInfo.style.display = 'flex';
        changeInfo.style.opacity = 0;
        uSpeed(0, 0.1, 0, changeInfo);
    } else {
        uSpeed(1, 0.1, 1, changeInfo);
        setTimeout(() => {
            changeInfo.style.display = 'none';
        }, 1000);
    };
});
close_info.addEventListener('click', function () {
    uSpeed(1, 0.1, 1, changeInfo);
    setTimeout(() => {
        changeInfo.style.display = 'none';
    }, 1000);
});

let inputs = changeInfo.querySelectorAll('input');
let nameReg = /^(?!_)(?!.*?_$)[a-zA-Z0-9_\u4e00-\u9fa5]{0,20}$/;
let telReg = /^1[3|5|4|7|8]\d{9}$/;
let sexReg = /^男|女|不愿透露$/;
let introReg = /^[\u4e00-\u9fa5_a-zA-Z0-9\s\·\~\！\@\#\￥\%\……\&\*\（\）\——\-\+\=\【\】\{\}\、\|\；\‘\’\：\“\”\《\》\？\，\。\、\`\~\!\#\$\%\^\&\*\(\)\_\[\]{\}\\\|\;\'\'\:\"\"\,\.\/\<\>\?]+$/;
inputs[0].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (nameReg.test(this.value)) {
            this.value = this.value.trim();
        } else {
            alert('用户名输入有误，请重新输入！');
            this.value = '';
        };
    };
});
inputs[1].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (telReg.test(this.value)) {
            this.value = this.value.trim();
        } else {
            alert('手机号输入有误，请重新输入！');
            this.value = '';
        };
    };
});
inputs[2].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (sexReg.test(this.value)) {
            this.value = this.value.trim();
        } else {
            alert('性别输入有误，请按提示输入！');
            this.value = '';
        };
    };
});
inputs[3].addEventListener('blur', function () {
    if (this.value.length !== 0) {
        if (introReg.test(this.value)) {
            this.value = this.value.trim();
            this.value.replace(/中国共产党|傻逼|煞笔|操你妈|尼玛|你妈|我日|你妈卖批|草泥马|gay|日你妈|操|泥马|sb/gi, '***');
        } else {
            alert('请重新输入个人简介！');
            this.value = '';
        };
    };
});

// 选中显示
let link = document.querySelector('.link');
let link_login = document.querySelector('.link_login');
let link_register = document.querySelector('.link_register');
let run_flag = true;
link.addEventListener('mouseover', function () {
    if (run_flag) {
        circleRun(0, 495, link_login, 30, 150, 70, 'right', true, 1, 10);
        circleRun(0, 495, link_register, 30, 150, 70, 'right', false, 1, 10);
        setTimeout(() => { link.innerHTML = '⇨'; run_flag = false; }, 1300);
    } else {
        circleRun(0, 495, link_login, 150, 330, 70, 'right', true, 1, 10);
        circleRun(0, 495, link_register, 150, 330, 70, 'right', false, 1, 10);
        setTimeout(() => { link.innerHTML = '⇦'; run_flag = true; }, 1800);
    };
});

if (checkCookie('username')) {
    document.querySelector('.username').innerHTML = getCookie_zhCN('username');
}
if (checkCookie('email')) {
    document.querySelector('.email').innerHTML = getCookie('email');
};
if (checkCookie('headurl')) {
    headImg.querySelector('.showImg').src = getCookie('headurl');
    images.src = getCookie('headurl');
};
if (checkCookie('tel')) {
    document.querySelector('.tel').innerHTML = getCookie('tel');
};
if (checkCookie('sex')) {
    document.querySelector('.sex').innerHTML = getCookie_zhCN('sex');
};
if (checkCookie('intro')) {
    document.querySelector('.intro').innerHTML = getCookie_zhCN('intro');
};