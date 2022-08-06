<?php
    $file = $_FILES['track']['tmp_name'];
    $filename = $_FILES['track']['name'];
    $path = 'test/';
    move_uploaded_file($file,$path.$filename);

?>