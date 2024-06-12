<?php
require "connect.php";

$tendangnhap = $_GET['Tendangnhap'];
$sdt = $_GET['Sdt'];

$query = mysqli_query($conn, "SELECT `Tendangnhap` FROM user_book WHERE Tendangnhap = '$tendangnhap' AND Sdt = '$sdt'");

if($query){
    if(mysqli_num_rows($query) > 0){
        echo "User exists";
    } else {
        echo "User does not exist";
    }
} else {
    echo "Failed to execute query: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
