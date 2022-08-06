const color_list = ['#09d9ff', '#f13f84', '#a3d76e', '#c837ed', '#ff745a', '#ffcc00', '#7ac034', '#00dbc2', '#ff9e6d', '#fff'];
const dayTime_images = ['IMAGES/a.jpeg', 'IMAGES/an.jpeg', 'IMAGES/f.jpeg', 'IMAGES/h.jpeg', 'IMAGES/k.jpeg', 'IMAGES/skd.jpeg', 'IMAGES/y.jpeg'];

// --更改默认弹出框
window.alert = function (msg, callback) {
    var div = document.createElement("div");
    div.innerHTML = "<style type=\"text/css\">"
        + ".nbaMask { position: fixed; z-index: 1000; top: 0; right: 0; left: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); }                                                                                                                                                                       "
        + ".nbaMaskTransparent { position: fixed; z-index: 1000; top: 0; right: 0; left: 0; bottom: 0; }                                                                                                                                                                                            "
        + ".nbaDialog { position: fixed; z-index: 5000; width: 80%; max-width: 300px; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); background-color: rgba(255, 255, 255, 0.9); text-align: center; border-radius: 4px; overflow: hidden; opacity: 1; color: white; }"
        + ".nbaDialog .nbaDialogHd { padding: .2rem .27rem .08rem .27rem; }                                                                                                                                                                                                                         "
        + ".nbaDialog .nbaDialogHd .nbaDialogTitle { font-size: 28px; font-weight: 400; }                                                                                                                                                                                                           "
        + ".nbaDialog .nbaDialogBd { padding: .8rem .8rem .8rem .8rem; font-size: 18px; line-height: 1.3; word-wrap: break-word; word-break: break-all; color: #000000; }                                                                                                                                          "
        + ".nbaDialog .nbaDialogFt { position: relative; line-height: 48px; font-size: 17px; display: -webkit-box; display: -webkit-flex; display: flex; }                                                                                                                                          "
        + ".nbaDialog .nbaDialogFt:after { content: \" \"; position: absolute; left: 0; top: 0; right: 0; height: 1px; border-top: 1px solid #e6e6e6; color: #e6e6e6; -webkit-transform-origin: 0 0; transform-origin: 0 0; -webkit-transform: scaleY(0.5); transform: scaleY(0.5); }               "
        + ".nbaDialog .nbaDialogBtn { display: block; -webkit-box-flex: 1; -webkit-flex: 1; flex: 1; color: #1E90FF; text-decoration: none; -webkit-tap-highlight-color: transparent; position: relative; margin-bottom: 0; }                                                                       "
        + ".nbaDialog .nbaDialogBtn:after { content: \" \"; position: absolute; left: 0; top: 0; width: 1px; bottom: 0; border-left: 1px solid #e6e6e6; color: #e6e6e6; -webkit-transform-origin: 0 0; transform-origin: 0 0; -webkit-transform: scaleX(0.5); transform: scaleX(0.5); }             "
        + ".nbaDialog a { text-decoration: none; -webkit-tap-highlight-color: transparent; }"
        + "</style>"
        + "<div id=\"dialogs2\" style=\"display: none\">"
        + "<div class=\"nbaMask\"></div>"
        + "<div class=\"nbaDialog\">"
        + "    <div class=\"nbaDialogHd\">"
        + "        <strong class=\"nbaDialogTitle\"></strong>"
        + "    </div>"
        + "    <div class=\"nbaDialogBd\" id=\"dialog_msg2\">弹窗内容，告知当前状态、信息和解决方法，描述文字尽量控制在三行内</div>"
        + "    <div class=\"nbaDialogHd\">"
        + "        <strong class=\"nbaDialogTitle\"></strong>"
        + "    </div>"
        + "    <div class=\"nbaDialogFt\">"
        + "        <a href=\"javascript:;\" class=\"nbaDialogBtn nbaDialogBtnPrimary\" id=\"dialog_ok2\">确定</a>"
        + "    </div></div></div>";
    document.body.appendChild(div);

    var dialogs2 = document.getElementById("dialogs2");
    dialogs2.style.display = 'block';

    var dialog_msg2 = document.getElementById("dialog_msg2");
    dialog_msg2.innerHTML = msg;

    var dialog_ok2 = document.getElementById("dialog_ok2");
    dialog_ok2.onclick = function () {
        dialogs2.style.display = 'none';
        callback();
    };
};

// --可视窗口大小获取函数
const get_window_size = function () {
    return [window.innerWidth, window.innerHeight];
};

// --网页大小获取函数
const get_body_size = function () {
    return [document.body.scrollWidth, document.body.scrollHeight];
};

// --网页滚动距离获取
const get_web_scroll = function () {
    return window.scrollY;
};

// --随机数生成器
const new_random = function (max, min) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
};

// --动画函数
let timer_obj_temp;
let judg = false;
const Anchor_point = function (obj, target) {
    // 清除前一个计时器
    if (judg) {
        clearInterval(timer_obj_temp.timer);
    };
    timer_obj_temp = obj;
    obj.timer = setInterval(function () {
        var step = (target - window.pageYOffset) / 10;
        step = step > 0 ? Math.ceil(step) : Math.floor(step);
        if (target == window.pageYOffset) {
            clearInterval(obj.timer);
        };
        window.scroll(0, window.pageYOffset + step);
    }, 30);
    judg = true;
};

// --匀速函数（异步）
const uSpeed = function (num, operate, judg, obj) {
    const toDo = (num, operate, judg, obj) => {
        setTimeout(() => {
            if (judg === 0) {
                num += operate;
                obj.style.opacity = num;
                iterator.next();
            } else if (judg === 1) {
                num -= operate;
                obj.style.opacity = num;
                iterator.next();
            };
        }, 100);
    };
    let reNum = 0;
    const change_num = function () {
        if (judg === 0) {
            reNum += 0.1;
            return reNum;
        } else if (judg === 1) {
            reNum += 0.1;
            return -reNum;
        };
    };
    function* gen() {
        yield toDo(num, operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
        yield toDo(num + change_num(), operate, judg, obj);
    };
    let iterator = gen();
    iterator.next(); // 开启迭代
};

// --除中文以外获取cookie
const getCookie = function (name) {
    if (document.cookie.length > 0) {
        let c_start = document.cookie.indexOf(name + "=");
        if (c_start != -1) {
            c_start = c_start + name.length + 1;
            let c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
};

// --中文cookie解码
const getCookie_zhCN = function (name) {
    if (document.cookie.length > 0) {
        let c_start = document.cookie.indexOf(name + "=");
        if (c_start != -1) {
            c_start = c_start + name.length + 1;
            let c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return decodeURI(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
};

// --检查cookie
const checkCookie = function (name) {
    let isexist = getCookie(name);
    if (isexist != null && isexist != "" && isexist != undefined)
        return true;
    else
        return false;
};

// --删除cookie
const deleteCookie = function (name, value) {
    let exp = new Date();
    exp.setTime(exp.getTime() - 1);
    if (checkCookie(name)) {
        document.cookie = name + "=" + value + ";expires=" + exp.toUTCString();
    };
};

// --圆形运动轨迹(原点x,原点y,对象,角度起点,角度终点,半径, 方向,旋转方向(false为顺时针),变化角度，时间)
const circleRun = function (x_base, y_base, obj, deg_start, deg_end, R, direction, tiDi = false, amp, time) {
    clearInterval(obj.timer);
    obj.timer = setInterval(() => {
        if (deg_start == deg_end) {
            clearInterval(obj.timer);
        };
        if (tiDi) {
            obj.style.top = y_base - R * Math.sin(Math.PI * deg_start / 180) + 'px';
        } else {
            obj.style.top = y_base + R * Math.sin(Math.PI * deg_start / 180) + 'px';
        };
        if (direction === 'left') {
            obj.style.left = x_base + R * Math.cos(Math.PI * deg_start / 180) + 'px';
        } else {
            obj.style.right = x_base - R * Math.cos(Math.PI * deg_start / 180) + 'px';
        };
        if (deg_start <= deg_end)
            deg_start += amp;
        else deg_start -= amp;
    }, time);
};

// --时间显示函数
const timer_count = function (obj, second) {
    let date = new Date();
    let day = date.getDate();
    day = day > 9 ? day : '0' + day;
    let hours = date.getHours();
    hours = hours > 9 ? hours : '0' + hours;
    let minutes = date.getMinutes();
    minutes = minutes > 9 ? minutes : '0' + minutes;
    let seconds = date.getSeconds();
    seconds = seconds > 9 ? seconds : '0' + seconds;
    obj[0].innerHTML = day;
    obj[1].innerHTML = hours;
    obj[2].innerHTML = minutes;
    second.innerHTML = seconds;
};

// --分隔符闪烁函数
const ge_flash = function (obj, res) {
    if (res) {
        obj[1].innerHTML = ' ';
        obj[2].innerHTML = ' ';
        res = false;
    } else {
        obj[1].innerHTML = ':';
        obj[2].innerHTML = ':';
        res = true;
    };
    return res;
};

// --背景图改变函数
const body_imageChange = function (body) {
    let rdm = new_random(5, 0);
    body.style.background = 'url("' + dayTime_images[rdm] + '") no-repeat fixed center 0';
    body.style.backgroundSize = 'cover';
};

// 类选择器(类名,[多个1，单个0(默认)])
const class_select = function (classname, num = 0) {
    if (num === 0)
        return document.querySelector(classname);
    else
        return document.querySelectorAll(classname);
};

// 随时间变化的背景
let body = document.body;
body_imageChange(body);
setInterval(() => {
    body_imageChange(body);
}, 1000 * 60 * 10);