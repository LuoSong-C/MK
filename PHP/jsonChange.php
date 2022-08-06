<?php
    // 追加写入用户名下文件
    $text="完善demo";
    $id=42639;
    $done=false;
    $finaTime=false;
    $code="002";//动态数据
    $json_string = file_get_contents("../JSON/finList.json");// 从文件中读取数据到PHP变量
    $data = json_decode($json_string,true);// 把JSON字符串转成PHP数组
    // $data[$code]=array("text"=> '.$text.',"id"=> '.$id.',"done"=> '.$done.',"finaTime"=> '.$finaTime.');
$data[$code].text=$text;
$data[$code].id=$id;
$data[$code].done=$done;
$data[$code].finaTime=$finaTime;
    $json_strings = json_encode($data);
    file_put_contents("../JSON/finList.json",$json_strings);//写入
?>