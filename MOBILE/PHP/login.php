<?php

    session_start();
    include 'connect.php';
    header('Content-Type:text/html;charset=utf8');
    if (!$conn) {
        exit('connect error: '.mysqli_error($conn));
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = md5($password);
        $sql_select = "select username,email,pwd,code,tel,sex,intro,headimg from register where email ='$email' and md5(AES_DECRYPT(UNHEX(pwd), code)) = '$password'";
        $result = mysqli_query($conn, $sql_select);
        mysqli_query($conn, 'set names utf8');
        $num = mysqli_num_rows($result);
        if ($num) {
            $url = '../M_index.html';
            $_SESSION['email'] = $email;
            echo "<script>location.href='$url'</script>";
            while ($row = mysqli_fetch_array($result)) {
                setcookie('email', $row['email'], time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('username', $row['username'], time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('tel', $row['tel'], time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('sex', $row['sex'], time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('intro', $row['intro'], time() + 3600 * 24, '/', 'www.soting.fun');
                setcookie('headurl', $row['headimg'], time() + 3600 * 24, '/', 'www.soting.fun');
                // setcookie("logintime", 1, time()+3600 * 24 * 10, '/', 'www.soting.fun');
            }
        } else {
            $url_re = '../M_index.html';
            echo "<script>alert('用户未注册或密码错误！')</script>";
            echo "<script>location.href='$url_re'</script>";
            exit;
        }
    }
    mysqli_close($conn);
