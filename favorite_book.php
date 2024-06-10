<?php
require "connect.php";

// Kiểm tra nếu có tham số 'title' trong yêu cầu GET
if (isset($_GET['Id_user'])) {
    $userId = $_GET['Id_user'];

    // Chuẩn bị truy vấn với điều kiện WHERE
    $query = "SELECT `favoritebook`.`Id_favoritebook`, `favoritebook`.`Id_user`, `favoritebook`.`Id_book`,
            `book`.`Tensach`, `book`.`Anhbia` FROM `favoritebook`
              JOIN `book` ON `favoritebook`.`Id_book` = `book`.`Id_book`
              WHERE `favoritebook`.`Id_user` = ?";

    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($query)) {
        // Gán giá trị cho tham số
        $stmt->bind_param("s", $userId);
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

// require "connect.php";

//     $query = "SELECT `book`.`Tensach` as 'title', `book`.`Tacgia` as 'authors', `book`.`Mota` as 'description',
//                `book`.`Sobinhluan` as 'num_comment', `book`.`Sosao` as 'num_star', `category`.`Tentheloai`
//                  FROM `book`
//                  JOIN `book_category` ON `book_category`.`Id_book` = `book`.`Id_book`
//                  JOIN `category` ON `book_category`.`Id_category` = `category`.`Id_category`";

//     $check = mysqli_query($conn, $query);
//     $item  = array();
//     while($res = mysqli_fetch_assoc($check)){
//         $item[]  = $res;
//     }

//     echo json_encode($item);
?>
