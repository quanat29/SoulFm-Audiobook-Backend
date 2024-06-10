<?php 
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $database = "soulfm";

    //tạo kết nối đến cơ sở dữ liệu
    $conn = new mysqli($serverName, $userName, $password, $database);

    //kiểm tra kết nối
    if($conn -> connect_error){
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }   
?>