<?php

    include 'connect.php';
    header('Content-Type:text/html;charset=utf8');
    $url_1 = '../login.html';
    $url_2 = '../userinfo.html';
    if (!empty($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
        $username = $_POST['username'];
        $tel = $_POST['tel'];
        $sex = $_POST['sex'];
        $intro = $_POST['intro'];
        $headurl = $_COOKIE['headurl'];
        $SESSID = $_COOKIE['PHPSESSID'];
        if (!$conn) {
            exit('connect error: '.mysqli_error($conn));
        } else {
            $sql_update = "UPDATE register SET username='$username', tel='$tel', sex='$sex', intro='$intro' WHERE email='$email'";
            $result = mysqli_query($conn, $sql_update);
            if ($result) {
                setcookie('email', $email, time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('username', $username, time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('tel', $tel, time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('sex', $sex, time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('intro', $intro, time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('headurl', $headurl, time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('PHPSESSID', $SESSID, time() + 3600 * 24, '/', 'www.soting.fun');
                // setcookie("logintime", 1, time()+3600 * 24 * 10, '/', 'www.soting.fun');
                echo "<script>location.href='$url_2'</script>";
            }
        }
    } else {
        echo "<script>alert('请先登录！')</script>";
        echo "<script>location.href='$url_1'</script>";
    }
