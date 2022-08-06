<?php
    include 'connect.php';

    if(! $conn){
        die("connect error: " . mysqli_error($conn));
    } else {
        // 注册成功
    	$username = $_POST['username'];
    	$email = $_POST['email'];
    	$password = $_POST['password'];
    	$pwd = $_POST['pwd'];
		$sql_select = "select email from register where email ='$email'";
        // $flag = $conn->query("select email from register where username ='$username'");
		$result = mysqli_query($conn, $sql_select);
		$num = mysqli_num_rows($result);
    	if($num) {
            echo "<script>alert('邮箱已经存在,请重试！')</script>";
		    echo "<script>location.href='javascript:history.back(-1)'</script>";
        	exit;
		};
    	// 向数据库写入数据
        $code = randomkeys(16);
    	if($password == '' || $pwd == ''){
			echo "<script>alert('密码不能为空！')</script>";
			exit;
		};
    	$sql = "INSERT INTO register(username,email,password,pwd,code)VALUES('$username','$email',HEX(AES_ENCRYPT('$password', '$code')),HEX(AES_ENCRYPT('$pwd', '$code')),'$code')";
    	$res = mysqli_query($conn, $sql);
    	if(! $res){
        	die("create error" . mysqli_error($conn));
    	};
    	mysqli_close($conn);
        $url='../login.html';
        echo "<script>location.href='$url'</script>";
    };
?>

