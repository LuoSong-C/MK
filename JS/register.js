// 冒泡绑定大事件
let section = document.querySelector('section');
section.addEventListener('mouseover', function () {
    this.style.transform = 'translate(-10px, -10px)';
    this.style.boxShadow = '20px 20px 2px rgba(87, 244, 255, .5)';
}, false);
/* section.addEventListener('mouseout', function () {
    this.style.transform = 'translate(10px, 10px)';
    this.style.boxShadow = '';
}, false); */

// 密码显示
let inputs = section.querySelectorAll('input');
let eyesOne = document.querySelector('.eyes');
let eyesTwo = document.querySelector('.eyesTwo');
let eyes_flagOne = true;
eyesOne.addEventListener('click', function () {
    if (eyes_flagOne) {
        this.src = 'IMAGES/open.png';
        inputs[2].type = 'text';
        eyes_flagOne = false;
    } else {
        this.src = 'IMAGES/close.png';
        inputs[2].type = 'password';
        eyes_flagOne = true;
    }
});
let eyes_flagTwo = true;
eyesTwo.addEventListener('click', function () {
    if (eyes_flagTwo) {
        this.src = 'IMAGES/open.png';
        inputs[3].type = 'text';
        eyes_flagTwo = false;
    } else {
        this.src = 'IMAGES/close.png';
        inputs[3].type = 'password';
        eyes_flagTwo = true;
    }
});

// 密码提示
let more = document.querySelector('.more');
let password_more = document.querySelector('.password_more');
more.addEventListener('mouseover', function () {
    // console.log(password_more.style);
    if (password_more.style.display === '' || password_more.style.display === 'none') {
        password_more.style.display = 'block';
    };
});
more.addEventListener('mouseout', function () {
    if (password_more.style.display === 'block') {
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