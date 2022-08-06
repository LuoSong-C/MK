<?php
    header("Content-Type:text/html;charset=utf8");
    $conn = mysqli_connect("localhost", "mysql", "wacyty3y4310918");
    mysqli_select_db($conn, 'dolist');
    mysqli_set_charset($conn, 'utf8');

    // $json = '';
    $data = array();
    class User
    {
        public $id;
        public $thingtext;
        public $done;
        public $ids;
        public $finaTime;
    }

    if(! $conn){
        die("connect error: " . mysqli_error($conn));
    } else {
	    $sql = "SELECT * From dothinglist LIMIT 100";
        $result = $conn->query($sql);
        if($result){
            while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
            {
                $user = new User();
                $user->id = $row["id"];
                $user->thingtext = $row["thingtext"];
                $user->done = $row["done"];
                $user->ids = $row["ids"];
                $user->finaTime = $row["finaTime"];
                $data[]=$user;
            }
            echo json_encode($data);
        } else {
            echo "²éÑ¯Ê§°Ü";
        }
    };
?>