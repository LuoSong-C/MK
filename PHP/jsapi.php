﻿<?php
/**
* example目录下为简单的支付样例，仅能用于搭建快速体验微信支付使用
* 样例的作用仅限于指导如何使用sdk，在安全上面仅做了简单处理， 复制使用样例代码时请慎重
* 请勿直接直接使用样例对外提供服务
*
**/
require_once '../lib/WxPay.Api.php';
require_once 'WxPay.JsApiPay.php';
require_once 'WxPay.Config.php';
require_once 'log.php';

//初始化日志
/* $logHandler = new CLogFileHandler('../logs/'.date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach ($data as $key => $value) {
        echo "<font color='#00ff55;'>$key</font> :  ".htmlspecialchars($value, ENT_QUOTES).' <br/>';
    }
} */
    // $openId = $_POST['openid'];
    // $code = $_POST["code"];
    $tools = new JsApiPay();
    // $openId = $tools->GetOpenid();
    // $openId = $_GET['openid'];
    // echo $openId;
    $appid = 'wxb8eea133fec2f05a'; // 小程序appid
    $secret = 'cebf0c49c7c836c613292dc13ccbb785'; // 小程序secret
    $code = $_GET['code'];
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
    function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
    $str = file_get_contents($url);
    // $str = httpGet($url);
    $json = json_decode($str);
    $res = get_object_vars($json);
    // echo json_encode($res);
    $openId = $res['openid']; //这是openid

    //②、统一下单
    $input = new WxPayUnifiedOrder();
    $input->SetBody('test');
    $input->SetAttach('test');
    $input->SetOut_trade_no('sdkphp'.date('YmdHis'));
    $input->SetTotal_fee('1');
    $input->SetTime_start(date('YmdHis'));
    $input->SetTime_expire(date('YmdHis', time() + 600));
    $input->SetGoods_tag('test');
    $input->SetNotify_url('https://soting.fun:8000/PHP/notify.php');
    $input->SetTrade_type('JSAPI');
    $input->SetOpenid($openId);
    // $input['openid'] = $openId;
    // $temp = $input->GetValues();
    $config = new WxPayConfig();
    $order = WxPayApi::unifiedOrder($config, $input);
echo json_encode($order);
    // echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
    // printf_info($order);
    $jsApiParameters = $tools->GetJsApiParameters($order);

    return $jsApiParameters;

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/*
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */

 /* <html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信支付样例-支付</title>
    <script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall()
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function(res){
                WeixinJSBridge.log(res.err_msg);
                alert(res.err_code+res.err_desc+res.err_msg);
            }
        );
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }
    </script>
    <script type="text/javascript">
    //获取共享地址
    function editAddress()
    {
        WeixinJSBridge.invoke(
            'editAddress',
            <?php echo $editAddress; ?>,
            function(res){
                var value1 = res.proviceFirstStageName;
                var value2 = res.addressCitySecondStageName;
                var value3 = res.addressCountiesThirdStageName;
                var value4 = res.addressDetailInfo;
                var tel = res.telNumber;

                alert(value1 + value2 + value3 + value4 + ":" + tel);
            }
        );
    }

    window.onload = function(){
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', editAddress, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', editAddress);
                document.attachEvent('onWeixinJSBridgeReady', editAddress);
            }
        }else{
            editAddress();
        }
    };

    </script>
</head>
<body>
    <br/>
    <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>
    <div align="center">
        <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
    </div>
</body>
</html>  */
