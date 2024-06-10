<?php
header("Content-Type: application/json");

// Thông tin kết nối cơ sở dữ liệu
require 'connect.php';

// Nhận dữ liệu từ yêu cầu POST
$Id_user = $_GET['Id_user'];
$Id_book = $_GET['Id_book'];

// Kiểm tra dữ liệu đầu vào
if (empty($Id_user) || empty($Id_book)) {
    echo json_encode(array("error" => "Missing required parameters."));
    $conn->close();
    exit();
}

// Xóa thông tin sách khỏi danh sách yêu thích trong cơ sở dữ liệu
$sql = "DELETE FROM `favoritebook` WHERE `Id_user` = ? AND `Id_book` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $Id_user, $Id_book);

if ($stmt->execute()) {
    echo json_encode(array("success" => "Book removed from favorites successfully."));
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
