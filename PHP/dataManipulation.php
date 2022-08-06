<?php
    header("Content-Type:text/html;charset=utf8");
    $conn = mysqli_connect("localhost", "mysql", "wacyty3y4310918");
    mysqli_select_db($conn, 'dolist');
    mysqli_set_charset($conn, 'utf8');

    if(! $conn){
        die("connect error: " . mysqli_error($conn));
    } else {
        $type = $_GET["type"];
        $ids = $_GET["ids"];
        switch($type){
            case "add":
                $thingtext=$_GET["thingtext"];
                $done=$_GET["done"];
                $finaTime=$_GET["finaTime"];
                $sql_add = "INSERT INTO dothinglist(thingtext,done,ids,finaTime)VALUES('$thingtext','$done','$ids','$finaTime')";
                $result_add = mysqli_query($conn, $sql_add);
                if(! $result_add){
                    die("create error" . mysqli_error($conn));
                };
                mysqli_close($conn);
                echo "...添加成功...";
                break;
            case "update":
                $thingtext=$_GET["thingtext"];
                $done=$_GET["done"];
                $finaTime=$_GET["finaTime"];
                $sql_update = "UPDATE dothinglist SET thingtext='$thingtext', done='$done', finaTime='$finaTime' WHERE ids='$ids'";
                $result_update = mysqli_query($conn, $sql_update);
                if(!$result_update){
                    die("update error" . mysqli_error($conn));
                };
                mysqli_close($conn);
                echo "...更新成功...";
                break;
            case "delete":
                $sql_delete = "DELETE FROM dothinglist WHERE ids='$ids'";
                $result_delete = mysqli_query($conn, $sql_delete);
                if(!$result_delete){
                    die("delete error" . mysqli_error($conn));
                };
                mysqli_close($conn);
                echo "...删除成功...";
                break;
            case "deleteall":
                $sql_delete = "DELETE FROM dothinglist WHERE ";
                $result_delete = mysqli_query($conn, $sql_delete);
                if(!$result_delete){
                    die("delete error" . mysqli_error($conn));
                };
                mysqli_close($conn);
                echo "...删除成功...";
                break;
            default:
                echo "执行类型错误，请检查执行类型";
        };
    };
?>