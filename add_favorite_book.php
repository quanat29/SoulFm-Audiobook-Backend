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

// Kiểm tra xem Id_book đã tồn tại trong danh sách yêu thích của Id_user chưa
$sql_check = "SELECT * FROM `favoritebook` WHERE `Id_user` = ? AND `Id_book` = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $Id_user, $Id_book);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(array("error" => "Book is already in favorites."));
    $stmt_check->close();
    $conn->close();
    exit();
}

$stmt_check->close();

// Thêm hoặc cập nhật thông tin sách yêu thích vào cơ sở dữ liệu
$sql = "INSERT INTO `favoritebook` (`Id_favoritebook`, `Id_user`, `Id_book`) VALUES (null, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $Id_user, $Id_book);

if ($stmt->execute()) {
    echo json_encode(array("success" => "Book added to favorites successfully."));
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
