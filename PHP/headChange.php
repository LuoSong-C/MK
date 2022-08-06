<?php

    include 'connect.php';
    header('Content-Type:text/html;charset=utf8');
    $url_1 = '../login.html';
    $url_2 = '../userinfo.html';
    if (!empty($_COOKIE['email'])) {
        $base64 = $_POST['img'];
        $savename = date('YmdHis', time()).mt_rand(0, 9999);
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)) {
            $type = $result[2];
            // $new_file = $new_file.date('YmdHis', time()).mt_rand(0,9999).$type;
            $savepath = '../../UsHeIm/'.$savename.".{$type}";
            $file = file_put_contents($savepath, base64_decode(str_replace($result[1], '', $base64)));
            if ($file) {
                $url = 'http://458l647h15.goho.co/UsHeIm/'.$savename.".{$type}";
                $email = $_COOKIE['email'];
                $username = $_COOKIE['username'];
                $tel = $_COOKIE['tel'];
                $sex = $_COOKIE['sex'];
                $intro = $_COOKIE['intro'];
                $headurl = $_COOKIE['headurl'];
                $SESSID = $_COOKIE['PHPSESSID'];
                if (!$conn) {
                    exit('connect error: '.mysqli_error($conn));
                } else {
                    $sql_update = "UPDATE register SET headimg='$url' WHERE email='$email'";
                    $result = mysqli_query($conn, $sql_update);
                    if ($result) {
                        $headurlOld = substr($headurl, 26);
                        $filename = '../../'.$headurlOld;
                        if (file_exists($filename)) {
                            unlink($filename);
                            setcookie('email', $email, time() + 3600 * 24, '/', 'www.soting.fun');
                            setcookie('username', $username, time() + 3600 * 24, '/', 'www.soting.fun');
                            setcookie('tel', $tel, time() + 3600 * 24, '/', 'www.soting.fun');
                            setcookie('sex', $sex, time() + 3600 * 24, '/', 'www.soting.fun');
                            setcookie('intro', $intro, time() + 3600 * 24, '/', 'www.soting.fun');
                            setcookie('headurl', $url, time() + 3600 * 24, '/', 'www.soting.fun');
                            setcookie('PHPSESSID', $SESSID, time() + 3600 * 24, '/', 'www.soting.fun');
                            // setcookie("logintime", 1, time()+3600 * 24 * 10, '/', 'www.soting.fun');
                        }
                        // setcookie("headurl", $url, time()+3600, '/', 'www.soting.fun');
                        mysqli_close($conn);
                        echo "<script>location.href='$url_2'</script>";
                    } else {
                        echo "<script>alert('上传失败')</script>";
                        echo "<script>location.href='$url_2'</script>";
                    }
                }
            } else {
                echo "<script>alert('请重试')</script>";
                echo "<script>location.href='$url_2'</script>";
            }
        } else {
            echo "<script>alert('请先确定再提交')</script>";
            echo "<script>location.href='$url_2'</script>";
        }
    } else {
        echo "<script>alert('请先登录！')</script>";
        echo "<script>location.href='$url_1'</script>";
    }
