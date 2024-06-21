<?php
require "connect.php";

// Kiểm tra nếu có tham số 'Id_user' trong yêu cầu GET
if (isset($_GET['Id_user'])) {
    $userId = $_GET['Id_user'];

    // Chuẩn bị truy vấn với điều kiện WHERE
    $query = "SELECT `bookheard`.`Id_bookheard`, `bookheard`.`Currentduration`, `bookheard`.`Id_user`,
    `bookheard`.`Id_bookchapter`, `book`.`Id_book`, `book`.`Anhbia` as 'image_url', `bookchapter`.`Tenchapter`,
    `bookchapter`.`episode`,
    `book`.`Tensach` as 'title' from `bookheard` join `bookchapter` on `bookheard`.`Id_bookchapter` = `bookchapter`.`Id_bookchapter`
    join `book` on `bookchapter`.`Id_book` = `book`.`Id_book` WHERE `Id_user` = ?";

    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($query)) {
        // Gán giá trị cho tham số
        $stmt->bind_param("i", $userId);
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
    // Trả về lỗi nếu không có tham số 'Id_user' trong yêu cầu
    echo json_encode(array("error" => "No Id_user parameter provided"));
}
?>
