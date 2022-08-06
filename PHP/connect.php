<?php
    header("Content-Type:text/html;charset=utf8");
    $conn = mysqli_connect("localhost", "mysql", "wacyty3y4310918");
    mysqli_select_db($conn, 'soting_cartoon_user');
    mysqli_set_charset($conn, 'utf8');

    // 生成随机数
    function randomkeys($length)
    {
	// 不能出现预留的关键字，不然会有卡顿，但程序不会错
	$random_code = '';
        $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for($i=0;$i<$length;$i++)
        {
            $index = rand(0, strlen($pattern) - 1);
            $random_code .= $pattern[$index];
        }
        return $random_code;
    };
?>