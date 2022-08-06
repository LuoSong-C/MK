<?php
    include 'connect.php';

    if(! $conn){
        die("connect error: " . mysqli_error($conn));
    } else {
        $email = $_GET["email"];
        $sql = "SELECT username,email,tel,intro From register WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo json_encode($row);
            }
        }
    };
?>