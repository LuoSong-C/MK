<?php

    header('Content-Type:text/html;charset=utf8');
    $conn = mysqli_connect('localhost', 'mysql', 'wacyty3y4310918');
    mysqli_select_db($conn, 'goodslists');
    mysqli_set_charset($conn, 'utf8');

    if (!$conn) {
        exit('CONNECT_ERROR'.mysqli_error($conn));
    }
    class Goods
    {
        public $sub_openid;
        public $goods_name;
        public $goods_price;
        public $goods_has;
        public $goods_category;
        public $goods_image;
        public $goods_subtime;
        public $goods_details;
        public $buy_openid;
        public $goods_id;
        public $goods_BASStatus;
        public $goods_nowHas;
        public $goods_freight;
    }
    $sub_openid = $_GET['openid'];
    $sub_openid = str_replace(PHP_EOL, '', $sub_openid);
    $type = $_GET['type'];
    switch ($type) {
        case 'add':
            $base64 = $_GET['img'];
            $goods_name = $_GET['commName'];
            // $goods_name = substr($goods_name, 0, 20);
            $goods_price = $_GET['price'];
            $goods_has = $_GET['hasNumber'];
            $goods_category = $_GET['category'];
            $goods_subtime = $_GET['time'];
            $goods_details = $_GET['details'];
            // $goods_details = substr($goods_details, 0, 80);
            $goods_id = substr($sub_openid, 0, 12).$goods_subtime;
            $goods_BASStatus = 'on_sale';
            $goods_nowHas = $_GET['hasNumber'];
            $goods_freight = $_GET['freight'];
            $savename = date('YmdHis', time()).mt_rand(0, 9999);
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)) {
                $type = $result[2];
                // $new_file = $new_file.date('YmdHis', time()).mt_rand(0,9999).$type;
                $savepath = '../../goods_images/'.$savename.".{$type}";
                $file = file_put_contents($savepath, base64_decode(str_replace($result[1], '', $base64)));
            }
            $goods_image = 'http://458l647h15.goho.co/goods_images/'.$savename.".{$type}";
            $sql = "INSERT INTO lists(sub_openid,goods_name,goods_price,goods_has,goods_category,goods_image,goods_details,goods_subtime,goods_id,goods_BASStatus,goods_nowHas,goods_freight)VALUES('$sub_openid','$goods_name','$goods_price','$goods_has','$goods_category','$goods_image','$goods_details','$goods_subtime','$goods_id','$goods_BASStatus','$goods_nowHas','$goods_freight')";
            $res = mysqli_query($conn, $sql);
            if (!$res) {
                exit('ADD_ERROR'.mysqli_error($conn));
            } else {
                mysqli_close($conn);
                exit('ADD_OK');
            }
            break;
        case 'search':
            $data = [];
            $user = $_GET['user'];
            if ($user) {
                $sql = "SELECT * From lists WHERE sub_openid='$sub_openid' ORDER BY goods_subtime DESC LIMIT 100";
            } else {
                $dataType = $_GET['dataType'];
                if ('all' === $dataType) {
                    $sql = 'SELECT * From lists ORDER BY goods_subtime DESC LIMIT 100';
                } else {
                    $sql = "SELECT * From lists WHERE goods_category='$dataType' ORDER BY goods_subtime DESC LIMIT 100";
                }
            }
            $result = $conn->query($sql);
            if ($result) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $goods = new Goods();
                    $goods->sub_openid = $row['sub_openid'];
                    $goods->goods_name = $row['goods_name'];
                    $goods->goods_price = $row['goods_price'];
                    $goods->goods_has = $row['goods_has'];
                    $goods->goods_category = $row['goods_category'];
                    $goods->goods_image = $row['goods_image'];
                    $goods->goods_subtime = $row['goods_subtime'];
                    $goods->goods_details = $row['goods_details'];
                    $goods->buy_openid = $row['buy_openid'];
                    $goods->goods_id = $row['goods_id'];
                    $goods->goods_BASStatus = $row['goods_BASStatus'];
                    $goods->goods_nowHas = $row['goods_nowHas'];
                    $goods->goods_freight = $row['goods_freight'];
                    $data[] = $goods;
                }
                if ($data) {
                    echo json_encode($data);
                } else {
                    echo json_encode($data);
                }
            } else {
                exit('SEARCH_ERROR');
            }
            break;
        case 'kwsearch':
            $data = [];
            $key = $_GET['dataType'];
            $sql = "SELECT * From lists WHERE goods_name LIKE '%$key%' OR goods_details LIKE '%$key%' ORDER BY goods_subtime DESC LIMIT 100";
            $result = $conn->query($sql);
            if ($result) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $goods = new Goods();
                    $goods->sub_openid = $row['sub_openid'];
                    $goods->goods_name = $row['goods_name'];
                    $goods->goods_price = $row['goods_price'];
                    $goods->goods_has = $row['goods_has'];
                    $goods->goods_category = $row['goods_category'];
                    $goods->goods_image = $row['goods_image'];
                    $goods->goods_subtime = $row['goods_subtime'];
                    $goods->goods_details = $row['goods_details'];
                    $goods->buy_openid = $row['buy_openid'];
                    $goods->goods_id = $row['goods_id'];
                    $goods->goods_BASStatus = $row['goods_BASStatus'];
                    $goods->goods_nowHas = $row['goods_nowHas'];
                    $goods->goods_freight = $row['goods_freight'];
                    $data[] = $goods;
                }
                if ($data) {
                    echo json_encode($data);
                } else {
                    echo json_encode($data);
                }
            } else {
                exit('SEARCH_ERROR');
            }
            break;
        case 'delete':
            $goods_id = $_GET['goods_id'];
            $goods_image = $_GET['image'];
            $headurlOld = substr($goods_image, 26);
            $filename = '../../'.$headurlOld;
            if (file_exists($filename)) {
                unlink($filename);
            }
            $sql = "DELETE FROM lists WHERE sub_openid='$sub_openid' AND goods_id='$goods_id'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                exit('DELETE_OK');
            } else {
                exit('DELETE_ERROR');
            }
            break;
        case 'assearch':
            $data = [];
            $goods_id = $_GET['goods_id'];
            $sql = "SELECT * From lists WHERE goods_id='$goods_id'";
            $result = $conn->query($sql);
            if ($result) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $goods = new Goods();
                    $goods->sub_openid = $row['sub_openid'];
                    $goods->goods_name = $row['goods_name'];
                    $goods->goods_price = $row['goods_price'];
                    $goods->goods_has = $row['goods_has'];
                    $goods->goods_category = $row['goods_category'];
                    $goods->goods_image = $row['goods_image'];
                    $goods->goods_subtime = $row['goods_subtime'];
                    $goods->goods_details = $row['goods_details'];
                    $goods->buy_openid = $row['buy_openid'];
                    $goods->goods_id = $row['goods_id'];
                    $goods->goods_BASStatus = $row['goods_BASStatus'];
                    $goods->goods_nowHas = $row['goods_nowHas'];
                    $goods->goods_freight = $row['goods_freight'];
                    $data[] = $goods;
                }
                if ($data) {
                    echo json_encode($data);
                } else {
                    echo json_encode($data);
                }
            } else {
                exit('SEARCH_ERROR');
            }
            break;
        case 'update':
            $goods_id = $_GET['goods_id'];
            $goods_name = $_GET['commName'];
            $goods_price = $_GET['price'];
            $goods_has = $_GET['hasNumber'];
            $goods_details = $_GET['details'];
            $goods_nowHas = $_GET['nowHas'];
            $goods_freight = $_GET['freight'];
            if ((int) $goods_nowHas) {
                $goods_BASStatus = 'on_sale';
            } else {
                $goods_BASStatus = 'sold_out';
            }
            $sql_update = "UPDATE lists SET goods_name='$goods_name',goods_price='$goods_price',goods_has='$goods_has',goods_details='$goods_details',goods_nowHas='$goods_nowHas',goods_freight='$goods_freight',goods_BASStatus='$goods_BASStatus' WHERE goods_id ='$goods_id'";
            $res = mysqli_query($conn, $sql_update);
            if ($res) {
                exit('UPDATE_OK');
            } else {
                exit('UPDATE_ERROR'.mysqli_error($conn));
            }
            break;
        default:
            echo '执行类型错误，请重试';
    }
