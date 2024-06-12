<?php
require "connect.php";

// Kiểm tra nếu có tham số 'Id_user' và 'Tendangnhap' trong yêu cầu POST
    $userId = $_GET['Id_user'];
    $newUsername = $_GET['Tendangnhap'];

    // Chuẩn bị truy vấn với điều kiện WHERE
    $query = "UPDATE `user_book` SET `Tendangnhap` = ? WHERE `Id_user` = ?";

    // Chuẩn bị câu lệnh SQL
    if ($stmt = $conn->prepare($query)) {
        // Gán giá trị cho tham số
        $stmt->bind_param("si", $newUsername, $userId);
        // Thực thi truy vấn
        if ($stmt->execute()) {
            // Trả về kết quả thành công
            echo json_encode(array("success" => true, "message" => "Username updated successfully"));
        } else {
            // Trả về lỗi nếu không thực thi được câu lệnh
            echo json_encode(array("success" => false, "message" => "Failed to update username"));
        }
        // Đóng câu lệnh
        $stmt->close();
    } else {
        // Trả về lỗi nếu không chuẩn bị được câu lệnh
        echo json_encode(array("success" => false, "message" => "Failed to prepare statement"));
    }

// Đóng kết nối
$conn->close();
?>
