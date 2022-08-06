<?php

    header('Content-Type:text/html;charset=utf8');
    $conn = mysqli_connect('localhost', 'mysql', 'wacyty3y4310918');
    mysqli_select_db($conn, 'opinion');
    mysqli_set_charset($conn, 'utf8');

    class User
    {
        public $id;
        public $time;
        public $title;
        public $openid;
        public $done;
    }
    if (!$conn) {
        exit('connect error: '.mysqli_error($conn));
    } else {
        $type = $_GET['type'];
        switch ($type) {
            case 'add':
                $openid = $_GET['openid'];
                $openid = str_replace(PHP_EOL, '', $openid);
                $title = $_GET['text'];
                $time = $_GET['time'];
                $done = 'NO';
                // 向数据库写入数据
                $sql = "INSERT INTO opinion_details(time,title,openid,done)VALUES('$time','$title','$openid','$done')";
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
                $order = $_GET['order'];
                if ($order) {
                    $sql = 'SELECT * From opinion_details ORDER BY time DESC LIMIT 100';
                } else {
                    $sql = 'SELECT * From opinion_details LIMIT 100';
                }
                $result = $conn->query($sql);
                if ($result) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $user = new User();
                        $user->id = $row['id'];
                        $user->time = $row['time'];
                        $user->title = $row['title'];
                        $user->openid = $row['openid'];
                        $user->done = $row['done'];
                        $data[] = $user;
                    }
                    if ($data) {
                        echo json_encode($data);
                    } else {
                        exit('NULL');
                    }
                } else {
                    exit('SEARCH_ERROR');
                }
                break;
            case 'delete':
                $id = $_GET['id'];
                $sql = "DELETE FROM opinion_details WHERE id='$id'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    exit('DELETE_OK');
                } else {
                    exit('DELETE_ERROR');
                }
                break;
            default:
                exit('执行类型错误，请检查执行类型');
        }
    }
