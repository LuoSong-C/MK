<?php
    header("Content-Type:text/html;charset=utf8");
    $conn = mysqli_connect("localhost", "mysql", "wacyty3y4310918");
    mysqli_select_db($conn, 'dolist');
    mysqli_set_charset($conn, 'utf8');

    if(! $conn){
        die("connect error: " . mysqli_error($conn));
    } else {
        // ��ӳɹ�
    	$thingtext = $_GET["thingtext"];
    	$done = $_GET["done"];
    	$ids = $_GET["ids"];
    	$finaTime = $_GET["finaTime"];
		/* $sql_select = "select email from register where email ='$email'";
        // $flag = $conn->query("select email from register where username ='$username'");
		$result = mysqli_query($conn, $sql_select);
		$num = mysqli_num_rows($result);
    	if($num) {
            echo "<script>alert('�����Ѿ�����,�����ԣ�')</script>";
		    echo "<script>location.href='javascript:history.back(-1)'</script>";
        	exit;
		};
    	// �����ݿ�д������
        $code = randomkeys(16);
    	if($password == '' || $pwd == ''){
			echo "<script>alert('���벻��Ϊ�գ�')</script>";
			exit;
		}; */
    	$sql = "INSERT INTO dothinglist(thingtext,done,ids,finaTime)VALUES('$thingtext','$done','$ids','$finaTime')";
    	$res = mysqli_query($conn, $sql);
    	if(! $res){
        	die("create error" . mysqli_error($conn));
    	};
    	mysqli_close($conn);
        echo "ok";
    };
?>