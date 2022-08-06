// 侧边栏移动函数(对象，方向，增减(0/1)，起，终，每次增减幅度，执行间隔时间)
const sidemove = function (obj, direction, UD, st, ed, homu, time) {
    clearInterval(obj.timer);
    obj.timer = setInterval(() => {
        if (st == ed) {
            clearInterval(obj.timer);
        };
        switch (direction) {
            case "left": obj.style.left = st + 'rem';
                break;
            case "right": obj.style.right = st + 'rem';
                break;
            case "top": obj.style.top = st + 'rem';
                break;
            case "bottom": obj.style.bottom = st + 'rem';
                break;
            default:
                break;
        }
        if (UD === 0 && ed > st)
            st += homu;
        else if (UD === 1 && ed < st) st -= homu;
    }, time += 5);
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

// 类选择器(类名,[多个1，单个0(默认)])
const class_select = function (classname, num = 0) {
    if (num === 0)
        return document.querySelector(classname);
    else
        return document.querySelectorAll(classname);
};