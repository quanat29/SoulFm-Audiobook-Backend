<?php
header("Content-Type: application/json");

// Thông tin kết nối cơ sở dữ liệu
require 'connect.php';

// Nhận dữ liệu từ yêu cầu POST
$username = $_POST['Tendangnhap'];
$phone = $_POST['Sdt'];
$new_password = $_POST['new_password'];

// Kiểm tra dữ liệu đầu vào
if (empty($username) || empty($phone) || empty($new_password)) {
    echo json_encode(array("error" => "Missing required parameters."));
    $conn->close();
    exit();
}

// Kiểm tra thông tin người dùng
$sql_check = "SELECT `Id_user` FROM `user_book` WHERE `Tendangnhap` = ? AND `Sdt` = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $username, $phone);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows == 0) {
    echo json_encode(array("error" => "User not found."));
    $stmt_check->close();
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();
$Id_user = $row['Id_user'];
$stmt_check->close();

// Cập nhật mật khẩu mới
$sql_update = "UPDATE `user_book` SET `Matkhau` = ? WHERE `Id_user` = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $new_password, $Id_user);

if ($stmt_update->execute()) {
    echo json_encode(array("success" => "Password updated successfully."));
} else {
    echo json_encode(array("error" => "Error: " . $sql_update . "<br>" . $conn->error));
}

// Đóng kết nối
$stmt_update->close();
$conn->close();
?>
