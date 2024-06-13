<?php
require "connect.php";

// Kiểm tra nếu có tham số 'title' trong yêu cầu GET
if (isset($_GET['Id_category'])) {
    $categoryId = $_GET['Id_category'];

    // Chuẩn bị truy vấn với điều kiện WHERE
    $query = "SELECT  `book`.`Tensach`as 'title', `book`.`Tacgia` as 'authors', `book`.`Anhbia` as 'image_url', `book`.`Id_book`,
    `category`.`Tentheloai` from `book_category` join `book` on `book_category`.`Id_book` = `book`.`Id_book`
    join `category` on `book_category`.`Id_category` = `category`.`Id_category`
    Where `book_category`.`Id_category` = ?";

    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($query)) {
        // Gán giá trị cho tham số
        $stmt->bind_param("s", $categoryId);
        // Thực thi truy vấn
        $stmt->execute();
        // Lấy kết quả
        $result = $stmt->get_result();
        $item = array();
        while ($res = $result->fetch_assoc()) {
            $item[] = $res;
        }
        // Đóng câu lệnh
        $stmt->close();
        // Trả kết quả dưới dạng JSON
        echo json_encode($item);
    } else {
        // Trả về lỗi nếu không chuẩn bị được câu lệnh
        echo json_encode(array("error" => "Failed to prepare statement"));
    }
} else {
    // Trả về lỗi nếu không có tham số 'title' trong yêu cầu
    echo json_encode(array("error" => "No title parameter provided"));
}

?>
