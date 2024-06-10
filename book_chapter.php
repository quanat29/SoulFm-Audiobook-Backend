<?php
require "connect.php";

// Kiểm tra nếu có tham số 'title' trong yêu cầu GET
if (isset($_GET['Id_book'])) {
    $id = $_GET['Id_book'];

    // Chuẩn bị truy vấn với điều kiện WHERE
    $query = "SELECT `bookchapter`.`Id_bookchapter`, `bookchapter`.`Tenchapter`, `bookchapter`.`Audiofile`,
    `bookchapter`.`Duration`, `bookchapter`.`Id_book`, `bookchapter`.`episode`,
    `bookchapter`.`num_sections`,`book`.`Anhbia`, `book`.`Tensach` from `bookchapter` join `book`
    on `bookchapter`.`Id_book` = `book`.`Id_book` WHERE `book`.`Id_book` = ?";


    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($query)) {
        // Gán giá trị cho tham số
        $stmt->bind_param("s", $id);
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
