<?php
    // ׷��д���û������ļ�
    $text="����demo";
    $id=42639;
    $done=false;
    $finaTime=false;
    $code="002";//��̬����
    $json_string = file_get_contents("../JSON/finList.json");// ���ļ��ж�ȡ���ݵ�PHP����
    $data = json_decode($json_string,true);// ��JSON�ַ���ת��PHP����
    // $data[$code]=array("text"=> '.$text.',"id"=> '.$id.',"done"=> '.$done.',"finaTime"=> '.$finaTime.');
$data[$code].text=$text;
$data[$code].id=$id;
$data[$code].done=$done;
$data[$code].finaTime=$finaTime;
    $json_strings = json_encode($data);
    file_put_contents("../JSON/finList.json",$json_strings);//д��
?>