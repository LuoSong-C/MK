<?php
    $appid = 'wxb8eea133fec2f05a'; // 小程序appid
    $secret = '9e91e8a3ff134b9a611789c1ce954c12'; // 小程序secret
    $code = $_GET['code'];
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
    $str = file_get_contents($url);
    $json = json_decode($str);
    $res = get_object_vars($json);
    // echo json_encode($res);
    echo $res['openid']; //这是openid
    // $res = get_object_vars($json);
    // echo $openid = $arr['openid']; //这是openid
    // echo $session_key = $arr['session_key']; //这是session_key
?>

