<?php
    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem có tham số id được truyền qua không
    if(isset($_GET['id'])) {
        // Lấy id bình luận từ URL
        $comment_id = $_GET['id'];

        // Truy vấn xóa bình luận
        $delete_query = "DELETE FROM comment WHERE Id_comment = '$comment_id'";

        // Thực hiện truy vấn
        if(mysqli_query($conn, $delete_query)) {
            // Chuyển hướng về trang danh sách bình luận
            echo "<script>window.location.href = 'comment.php';</script>";
            exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
        } else {
            // Hiển thị thông báo lỗi nếu có
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    } else {
        // Hiển thị thông báo nếu không có tham số id truyền qua
        echo "<div class='alert alert-danger'>Không có ID bình luận được truyền qua.</div>";
    }
?>
