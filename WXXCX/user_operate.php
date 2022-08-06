<?php

    header('Content-Type:text/html;charset=utf8');
    $conn = mysqli_connect('localhost', 'mysql', 'wacyty3y4310918');
    mysqli_select_db($conn, 'wxxcx_user');
    mysqli_set_charset($conn, 'utf8');

    if (!$conn) {
        exit('connect error: '.mysqli_error($conn));
    }
    class User
    {
        public $id;
        public $openid;
        public $nickName;
        public $avatarUrl;
        public $integral;
        public $payPwd;
        public $jurisdiction;
    }
    $type = $_GET['type'];
    $user_openid = $_GET['openid'];
    $user_openid = str_replace(PHP_EOL, '', $user_openid);
    switch ($type) {
        case 'login':
            // 注册成功
            $user_name = $_GET['username'];
            $user_headURL = $_GET['headurl'];
            $user_timeRecord = $_GET['logintime'];
            $user_jurisdiction = 'user';
            $user_cascade = substr($user_openid, 0, 12);
            $user_integral = 0;
            $user_paypwd = 'no';
            $sql_select = "select user_openid from userinfo where user_openid ='$user_openid'";
            // $flag = $conn->query("select email from register where username ='$username'");
            $result = mysqli_query($conn, $sql_select);
            $num = mysqli_num_rows($result);
            if ($num) {
                $sql_update = "UPDATE userinfo SET user_timeRecord='$user_timeRecord', user_name='$user_name', user_headURL='$user_headURL' WHERE user_openid ='$user_openid'";
                $result = mysqli_query($conn, $sql_update);
                if ($result) {
                    exit('UPDATE_OK');
                } else {
                    exit('UPDATE_ERROR'.mysqli_error($conn));
                }
            } else {
                // 向数据库写入数据
                $sql = "INSERT INTO userinfo(user_openid,user_name,user_headURL,user_timeRecord,user_jurisdiction,user_cascade,user_integral,user_paypwd)VALUES('$user_openid','$user_name','$user_headURL','$user_timeRecord','$user_jurisdiction','$user_cascade','$user_integral','$user_paypwd')";
                $res = mysqli_query($conn, $sql);
                if (!$res) {
                    exit('CREATE_ERROR'.mysqli_error($conn));
                } else {
                    mysqli_close($conn);
                    exit('CREATE_OK');
                }
            }
            break;
        case 'exit':
            $time = 0;
            $sql_select = "select user_openid from userinfo where user_openid ='$user_openid'";
            // $flag = $conn->query("select email from register where username ='$username'");
            $result = mysqli_query($conn, $sql_select);
            $num = mysqli_num_rows($result);
            if ($num) {
                $sql_update = "UPDATE userinfo SET user_timeRecord='$time' WHERE user_openid ='$user_openid'";
                $result = mysqli_query($conn, $sql_update);
                if ($result) {
                    exit('EXIT_OK');
                } else {
                    exit('EXIT_ERROR'.mysqli_error($conn));
                }
            }
            break;
        case 'search':
            $nowTime = $_GET['nowTime'];
            $sql_select = "select user_openid from userinfo where user_openid ='$user_openid'";
            // $flag = $conn->query("select email from register where username ='$username'");
            $result = mysqli_query($conn, $sql_select);
            $num = mysqli_num_rows($result);
            if ($num) {
                $data = [];
                $sql = "SELECT * From userinfo where user_openid ='$user_openid'";
                $result = $conn->query($sql);
                if ($result) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        if ($nowTime - $row['user_timeRecord'] > 2592000000) {
                            exit('TIME_OUT');
                        } else {
                            $user = new User();
                            $user->id = $row['id'];
                            $user->openid = $row['user_openid'];
                            $user->nickName = $row['user_name'];
                            $user->avatarUrl = $row['user_headURL'];
                            $user->integral = $row['user_integral'];
                            $user->payPwd = $row['user_paypwd'];
                            $user->jurisdiction = $row['user_jurisdiction'];
                            $data[] = $user;
                        }
                    }
                    echo json_encode($data);
                } else {
                    exit('SEARCH_ERROR');
                }
            }
            break;
        case 'pwdchange':
            $pwd = $_GET['pwd'];
            $pwd = md5($pwd);
            $sql_select = "select user_openid from userinfo where user_openid ='$user_openid'";
            // $flag = $conn->query("select email from register where username ='$username'");
            $result = mysqli_query($conn, $sql_select);
            $num = mysqli_num_rows($result);
            if ($num) {
                $sql_update = "UPDATE userinfo SET user_paypwd='$pwd' WHERE user_openid ='$user_openid'";
                $result = mysqli_query($conn, $sql_update);
                if ($result) {
                    exit('UPDATEPWD_OK');
                } else {
                    exit('UPDATEPWD_ERROR'.mysqli_error($conn));
                }
            }
            // no break
        default:
            exit('执行类型错误，请检查执行类型');
    }
