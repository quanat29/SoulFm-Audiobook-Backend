<?php 
    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem có ID thể loại được gửi từ URL không
    if (isset($_GET['id'])) {
        // Lấy ID thể loại từ URL
        $id_category = $_GET['id'];

        // Truy vấn xóa thể loại
        $delete_query = "DELETE FROM category WHERE Id_category = $id_category";

        // Thực hiện truy vấn
        if (mysqli_query($conn, $delete_query)) {
            // Chuyển hướng về trang category.php
            header("Location: category.php");
            exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
        } else {
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    } else {
        // Nếu không có đủ thông tin ID thể loại, hiển thị thông báo lỗi
        echo "<div class='container'><h4>Không tìm thấy thông tin thể loại</h4></div>";
    }
?>
