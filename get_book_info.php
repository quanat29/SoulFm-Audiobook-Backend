<?php
// Kết nối đến cơ sở dữ liệu
require "connect.php";

// Kiểm tra xem có dữ liệu được gửi từ client không
    // Lấy từ khóa tìm kiếm từ client (ở đây là từ khóa được gửi từ Android Retrofit)
    $keyword = $_GET['keyword'];

    // Câu truy vấn SQL để lấy danh sách các cuốn sách
    // Sử dụng prepared statement để tránh lỗi SQL Injection
    $query = "SELECT `book`.`Id_book` as id, `book`.`Tensach` as 'title', `book`.`Tacgia` as 'authors', `book`.`Anhbia` as 'image_url' 
              FROM `book` 
              WHERE `book`.`Tensach` LIKE ?";
    
    // Thêm dấu % vào trước và sau từ khóa để tìm kiếm tương tự
    $searchKeyword = '%' . $keyword . '%';

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $searchKeyword);
    $stmt->execute();

    // Lấy kết quả từ câu lệnh SQL
    $result = $stmt->get_result();

    // Mảng để lưu trữ các cuốn sách
    $books = array();

    // Lặp qua các dòng kết quả và thêm vào mảng books
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    // Đóng kết nối cơ sở dữ liệu
    $stmt->close();

    // Trả về JSON response chứa danh sách các cuốn sách
    header('Content-Type: application/json');
    echo json_encode($books);

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
