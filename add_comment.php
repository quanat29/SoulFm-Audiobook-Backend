<?php
header("Content-Type: application/json");

// Thông tin kết nối cơ sở dữ liệu
require 'connect.php';

// Nhận dữ liệu từ yêu cầu POST
$Id_user = $_GET['Id_user'];
$Id_book = $_GET['Id_book'];
$binhluan = $_GET['Binhluan'];
$comment_star = $_GET['comment_star'];

// Thêm hoặc cập nhật thông tin sách yêu thích vào cơ sở dữ liệu
$sql = "INSERT INTO `comment` (`Id_comment`, `Binhluan`, `Thoigianbinhluan`, `comment_star`, `Id_book`, `Id_user`) VALUES (NULL, ?, NOW(), ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Kiểm tra nếu chuẩn bị câu truy vấn thất bại
if ($stmt === false) {
    echo json_encode(array("error" => "Error preparing statement: " . $conn->error));
    exit();
}

$stmt->bind_param("siii", $binhluan, $comment_star, $Id_book, $Id_user);

if ($stmt->execute()) {
    // Lấy thông tin hiện tại của sách từ bảng book
    $sql_get_book = "SELECT Sobinhluan, Sosao FROM book WHERE Id_book = ?";
    $stmt_get_book = $conn->prepare($sql_get_book);
    $stmt_get_book->bind_param("i", $Id_book);
    $stmt_get_book->execute();
    $result = $stmt_get_book->get_result();
    $book = $result->fetch_assoc();
    
    if ($book) {
        $Sobinhluan = $book['Sobinhluan'];
        $Sosao = $book['Sosao'];

        // Tính toán số sao mới
        $new_Sosao = (($Sosao * $Sobinhluan) + $comment_star) / ($Sobinhluan + 1);

        // Cập nhật thông tin sách
        $sql_update_book = "UPDATE book SET Sobinhluan = Sobinhluan + 1, Sosao = ? WHERE Id_book = ?";
        $stmt_update_book = $conn->prepare($sql_update_book);
        $stmt_update_book->bind_param("di", $new_Sosao, $Id_book);

        if ($stmt_update_book->execute()) {
            echo json_encode(array("success" => "Comment added and book updated successfully."));
        } else {
            echo json_encode(array("error" => "Error updating book: " . $stmt_update_book->error));
        }
        $stmt_update_book->close();
    } else {
        echo json_encode(array("error" => "Book not found."));
    }
    $stmt_get_book->close();
} else {
    echo json_encode(array("error" => "Error: " . $stmt->error));
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
