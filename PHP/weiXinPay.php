<?php

class Weixin
{
    protected $appid;
    protected $mch_id;
    protected $key;
    protected $openid;
    protected $out_trade_no;
    protected $body;
    protected $total_fee;
    protected $nonce_str;

    public function __construct($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $nonce_str)
    {
        $this->appid = $appid;
        $this->openid = $openid;
        $this->mch_id = $mch_id;
        $this->key = $key;
        $this->out_trade_no = $out_trade_no;
        $this->body = $body;
        $this->total_fee = $total_fee;
        $this->nonce_str = $nonce_str;
    }

    public function pay()
    {
        //统一下单接口
        $return = $this->weixinapp();

        return $return;
    }

    //统一下单接口
    private function unifiedorder()
    {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $parameters = [
            'appid' => $this->appid, //小程序ID
            'body' => $this->body,
            'mch_id' => $this->mch_id, //商户号
            'nonce_str' => $this->nonce_str, //随机字符串
            //            'body' => 'test', //商品描述
            'notify_url' => 'http://soting.fun:8000/PHP/notify.php', //通知地址  确保外网能正常访问
            //            'out_trade_no' => '2018013106125348', //商户订单号
            'openid' => $this->openid, //用户id
            'out_trade_no' => $this->out_trade_no,
            //            'total_fee' => floatval(0.01 * 100), //总金额 单位 分
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
            'total_fee' => $this->total_fee,

            // 'spbill_create_ip' => '192.168.0.161', //终端IP

            'trade_type' => 'JSAPI', //交易类型
        ];
        //统一下单签名

        // $parameters['sign'] = $this->getSign($parameters);
        $sign = $this->getSign($parameters);
        // print_r($parameters);
        // $xmlData = $this->ToXml($parameters);
        $uuurl = 'http://soting.fun:8000/PHP/notify.php';
        $ip = $_SERVER['REMOTE_ADDR'];
        $type = 'JSAPI';
        $post_xml = '<xml>
        <appid><![CDATA['.$this->strToUtf8($this->appid).']]></appid>
        <body><![CDATA['.$this->strToUtf8($this->body).']]></body>
        <mch_id><![CDATA['.$this->strToUtf8($this->mch_id).']]></mch_id>
        <nonce_str><![CDATA['.$this->strToUtf8($this->nonce_str).']]></nonce_str>
        <notify_url><![CDATA['.$this->strToUtf8($uuurl).']]></notify_url>
        <openid><![CDATA['.$this->strToUtf8($this->openid).']]></openid>
        <out_trade_no><![CDATA['.$this->strToUtf8($this->out_trade_no).']]></out_trade_no>
        <spbill_create_ip><![CDATA['.$this->strToUtf8($ip).']]></spbill_create_ip>
        <total_fee><![CDATA['.$this->total_fee.']]></total_fee>
        <trade_type><![CDATA['.$this->strToUtf8($type).']]></trade_type>
        <sign>'.$this->strToUtf8($sign).'</sign></xml>';
        // echo $post_xml;

        $return = $this->xmlToArray($this->postXmlCurl($post_xml, $url, 60));
        // echo $xmlData;
        // $return = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));

        /* $myfile = fopen('bug.txt', 'w');
        fwrite($myfile, $return);
        fclose($myfile); */

        // echo json_encode($return);

        return $return;
    }

    // UTF-8
    public function strToUtf8($str)
    {
        $encode = mb_detect_encoding($str, ['ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5']);

        if ('UTF-8' == $encode) {
            return $str;
        } else {
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }

    private function postXmlCurl($xml, $url, $second = 60)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, false);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        /* curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0); */
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);

            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }

    //数组转换成xml
    /* private function arrayToXml($arr)
    {
        $xml = '<xml>';
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= '<'.$key.'>'.arrayToXml($val).'</'.$key.'>';
            } else {
                $xml .= '<'.$key.'>'.$val.'</'.$key.'>';
            }
        }
        $xml .= '</xml>';

        return $xml;
    } */

    public function ToXml($arr)
    {
        if (!is_array($arr) || count($arr) <= 0) {
            throw new WxPayException('数组数据异常！');
        }

        $xml = '<xml>';
        foreach ($arr as $key => $val) {
            if ('sign' == $key) {
                $xml .= '<'.$key.'>'.$val.'</'.$key.'>';
            } else {
                $xml .= '<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
            }
        }
        $xml .= '</xml>';

        return $xml;
    }

    //xml转换成数组
    private function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);

        return $val;
    }

    //微信小程序接口
    private function weixinapp()
    {
        //统一下单接口
        $unifiedorder = $this->unifiedorder();
        //    print_r($unifiedorder);
        $parameters = [
            'appId' => $this->appid, //小程序ID
            'timeStamp' => ''.time().'', //时间戳
            'nonceStr' => $this->nonce_str, //随机串
            'package' => 'prepay_id='.$unifiedorder['prepay_id'], //数据包
            'signType' => 'MD5', //签名方式
        ];
        //签名
        $parameters['paySign'] = $this->getSign($parameters);
        $str = preg_replace('/"(\w+)"(\s*:\s*)/is', '$1$2', $parameters);
        // print_r($parameters);
        // echo $str;

        return $str;
    }

    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        for ($i = 0; $i < $length; ++$i) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    //作用：生成签名
    private function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);

        $String = $this->ToUrlParams($Parameters);
        //签名步骤二：在string后加入KEY
        $String = $String.'&key='.$this->key;

        // echo $String;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);

        return $result_;
    }

    /**
     * 生成签名.
     *
     * @param WxPayConfigInterface $config       配置对象
     * @param bool                 $needSignType 是否需要补signtype
     *
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    /* public function getSign($config, $needSignType = true)
    {
        if ($needSignType) {
            $this->SetSignType($config->GetSignType());
        }
        //签名步骤一：按字典序排序参数
        ksort($this->values);
        $string = $this->ToUrlParams();
        //签名步骤二：在string后加入KEY
        $string = $string.'&key='.$this->key;
        //签名步骤三：MD5加密或者HMAC-SHA256
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);

        return $result;
    } */

    /**
     * 格式化参数格式化成url参数.
     */
    public function ToUrlParams($paraMap)
    {
        $buff = '';
        foreach ($paraMap as $k => $v) {
            if ('sign' != $k && '' != $v && !is_array($v)) {
                $buff .= $k.'='.$v.'&';
            }
        }

        $buff = trim($buff, '&');

        return $buff;
    }

    ///作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = '';
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k.'='.$v.'&';
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }

        return $reqPar;
    }
}
