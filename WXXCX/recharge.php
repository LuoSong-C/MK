<?php

    header('Content-Type:text/html;charset=utf8');
    $conn = mysqli_connect('localhost', 'mysql', 'wacyty3y4310918');
    mysqli_select_db($conn, 'wxxcx_user');
    mysqli_set_charset($conn, 'utf8');

    $user_openid = $_GET['openid'];
    $user_openid = str_replace(PHP_EOL, '', $user_openid);
    $fee = $_GET['fee'];
    if (!$conn) {
        exit('connect error: '.mysqli_error($conn));
    }
    $sql = "SELECT * From userinfo where user_openid ='$user_openid'";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $integral = $row['user_integral'];
            $integral = $integral + $fee;
            $sql_update = "UPDATE userinfo SET user_integral='$integral' WHERE user_openid ='$user_openid'";
            $res = mysqli_query($conn, $sql_update);
            if ($res) {
                exit('RECHARGE_OK');
            } else {
                exit('RECHARGE_ERROR'.mysqli_error($conn));
            }
        }
    } else {
        exit('USER_ERROR');
    }
