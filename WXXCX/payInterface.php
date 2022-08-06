<?php

    // require_once 'weiXinPay.php';
    /* $openidc = $_POST['openid'];
    $paydo = new PayDo($openidc);
    $resault = $paydo->pay();
    $this->response($resault, 'json'); */

    /* $appid = 'wxb8eea133fec2f05a';
    $openid = $_GET['openid'];
    $mch_id = '1621044641';
    $key = 'wacyty3y4310918LsaCytx2TteotliLS';
    $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key);
    $return = $weixinpay->pay();
    $this->response($return, 'json'); */

    include 'weiXinPay.php';

    function createNoncestr($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }
    $appid = 'wxb8eea133fec2f05a'; //小程序appid
    // $openid = 'ob5Hr5KrQ8NMRUHH4_u5hZAReZEY';
    $openid = $_GET['openid'];
    $openid = str_replace(PHP_EOL, '', $openid);
    $mch_id = '1621044641'; //微信支付商户支付号
    // $key = 'sdfkhwihuc88Uycsnkyyssdxh6swefgt'; //Api密钥
    $key = 'urbayTCLSajye82jahbdwvbtuUYFH75u';
    $out_trade_no = $mch_id.time();
    $nonce_str = createNoncestr();
    $total_fee = $_GET['total_fee'];
    $body = '积分充值';
    $total_fee = floatval($total_fee * 100);
    $weixinpay = new Weixin($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $nonce_str);
    $return = $weixinpay->pay();

    echo json_encode($return);
