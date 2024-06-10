<?php
require "connect.php";

// Kiểm tra nếu có tham số 'title' trong yêu cầu GET
if (isset($_GET['Id_book'])) {
    $id_book = $_GET['Id_book'];

    // Chuẩn bị truy vấn với điều kiện WHERE
    $query = "SELECT `comment`.`Id_comment`, `comment`.`Binhluan` as 'content', `comment`.`Thoigianbinhluan` 
    as 'comment_time', `comment`.`Id_book`, `user_book`.`Id_user` , `user_book`.`Tendangnhap` as 'user_name', 
    `book`. `Sosao` as 'num_star' , `book`. `Sobinhluan` as 'num_comment'
    from `comment` join `book` 
    on `comment`.`Id_book` = `book`.`Id_book` join `user_book` on `comment`.`Id_user` = `user_book`.`Id_user`
    WHERE `comment`.`Id_book` = ?";

    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($query)) {
        // Gán giá trị cho tham số
        $stmt->bind_param("s", $id_book);
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
