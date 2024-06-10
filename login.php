<?php
require "connect.php";

$tendangnhap = $_GET['Tendangnhap'];
$matkhau = $_GET['Matkhau'];

$query = mysqli_query($conn, "SELECT `Tendangnhap`, `Matkhau`, `Id_user` FROM user_book WHERE Tendangnhap = '$tendangnhap' and Matkhau = '$matkhau'");

if($query){
    if(mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $response = array(
            "success" => true,
            "Id_user" => $row['Id_user']
        );
        echo json_encode($response);
    } else {
        echo json_encode(array("success" => false, "message" => "User does not exist"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Failed to execute query: " . mysqli_error($conn)));
}

mysqli_close($conn);
?>
