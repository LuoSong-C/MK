<?php
    header("Content-Type:text/html;charset=utf8");
    $conn = mysqli_connect("localhost", "mysql", "wacyty3y4310918");
    mysqli_select_db($conn, 'goodscategory');
    mysqli_set_charset($conn, 'utf8');

    // $json = '';
    $data = array();
    class User
    {
        public $id;
        public $id_title;
        public $goods_category;
        public $goods_icon;
    }

    if(! $conn){
        die("connect error: " . mysqli_error($conn));
    } else {
	    $sql = "SELECT * From category_details LIMIT 100";
        $result = $conn->query($sql);
        if($result){
            while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
            {
                $user = new User();
                $user->id = $row["id"];
                $user->id_title = $row["id_title"];
                $user->goods_category = $row["goods_category"];
                $user->goods_icon = $row["goods_icon"];
                $data[]=$user;
            }
            echo json_encode($data);
        } else {
            echo "²éÑ¯Ê§°Ü";
        }
    };
?>