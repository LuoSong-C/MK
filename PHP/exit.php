<?php

    session_start();
    include 'connect.php';
    header('Content-Type:text/html;charset=utf8');
    if (isset($_SESSION['email']) || !empty($_COOKIE['email'])) {
        setcookie('email', '', time() - 3600, '/', 'www.soting.fun');
        setcookie('username', '', time() - 3600, '/', 'www.soting.fun');
        setcookie('tel', '', time() - 3600, '/', 'www.soting.fun');
        setcookie('sex', '', time() - 3600, '/', 'www.soting.fun');
        setcookie('intro', '', time() - 3600, '/', 'www.soting.fun');
        setcookie('headurl', '', time() - 3600, '/', 'www.soting.fun');
        setcookie('PHPSESSID', '', time() - 3600, '/', 'www.soting.fun');
        unset($_SESSION['email']);
        $url = '../index.html';
        echo "<script>location.href='$url'</script>";
    } else {
        $url_login = '../login.html';
        echo "<script>alert('主人都还没有登录呢，怎么退出呀...')</script>";
        echo "<script>location.href='$url_login'</script>";
    }
    session_destroy();
