<?php

    header('Content-Type:text/html;charset=utf8');
    $conn = mysqli_connect('121.43.111.97', 'admin', 'wacyty3y4310918');
    $conn_withdraw = mysqli_connect('121.43.111.97', 'admin', 'wacyty3y4310918');
    mysqli_select_db($conn, 'wxxcx_user');
    mysqli_set_charset($conn, 'utf8');
    mysqli_select_db($conn_withdraw, 'withdraw');
    mysqli_set_charset($conn_withdraw, 'utf8');

    if (!$conn) {
        exit('connect error: '.mysqli_error($conn));
    }
    if (!$conn_withdraw) {
        exit('connect error: '.mysqli_error($conn_withdraw));
    }
    class User
    {
        public $id;
        public $apply_openid;
        public $user_name;
        public $actual_name;
        public $amount;
        public $receipt_code_url;
    }
    function createNoncestr($length)
    {
        $chars = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }
    $type = $_GET['type'];
    $apply_openid = $_GET['openid'];
    $apply_openid = str_replace(PHP_EOL, '', $apply_openid);
    switch ($type) {
        case 'apply':
            $password = $_GET['password'];
            $user_name = $_GET['user_name'];
            $actual_name = $_GET['actual_name'];
            $amount = $_GET['amount'];
            $receipt_code_img = $_GET['img'];
            $withdraw_status = 'APPLYING';
            $savename = $actual_name.createNoncestr(8);
            if ($amount > 1000) {
                $amount = $amount - 10;
            } else {
                $amount = $amount * 0.99;
            }
            $sql_select = "select * from userinfo where user_openid ='$apply_openid'";
            $result = $conn->query($sql_select);
            if ($result) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    if ($row['user_paypwd'] === md5($password)) {
                        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $receipt_code_img, $result)) {
                            $type = $result[2];
                            $savepath = '../user_receipt_code/'.$savename.".{$type}";
                            $file = file_put_contents($savepath, base64_decode(str_replace($result[1], '', $receipt_code_img)));
                        }
                        $receipt_code_url = 'https://www.unibs.xyz/user_receipt_code/'.$savename.".{$type}";
                        $integral = $row['user_integral'] - $amount;
                        $sql_update = "UPDATE userinfo SET user_integral='$integral' WHERE user_openid='$apply_openid'";
                        mysqli_query($conn, $sql_update);
                        $sql_insert = "INSERT INTO applylists(apply_openid,user_name,actual_name,amount,receipt_code_url,withdraw_status)VALUES('$apply_openid','$user_name','$actual_name','$amount','$receipt_code_url','$withdraw_status')";
                        $res = mysqli_query($conn_withdraw, $sql_insert);
                        if (!$res) {
                            exit('APPLY_ERROR'.mysqli_error($conn));
                        } else {
                            mysqli_close($conn);
                            exit('APPLY_OK');
                        }
                    } else {
                        exit('PWD_ERROR');
                    }
                }
            } else {
                exit('USER_ERROR');
            }
            break;
        case 'search':
            break;
        default:
            break;
    }
