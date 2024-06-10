<?php
require "connect.php";

    $tendangnhap = $_GET['Tendangnhap'];
    
    $query = mysqli_query($conn, "SELECT `Tendangnhap` FROM user_book WHERE Tendangnhap = '$tendangnhap'");
    
    if($query){
        if(mysqli_num_rows($query) > 0){
            echo "User already exists";
        } else {
            echo "User does not exist";
        }
    } else {
        echo "Failed to execute query: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);

?>
