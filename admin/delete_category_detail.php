<?php
    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem có tham số id được truyền qua không
    if(isset($_GET['id']) && isset($_GET['category_id'])) {
        // Lấy id sách và id thể loại từ URL
        $book_id = $_GET['id'];
        $category_id = $_GET['category_id'];

        // Truy vấn xóa sách khỏi thể loại
        $delete_query = "DELETE FROM book_category WHERE Id_book = '$book_id' AND Id_category = '$category_id'";

        // Thực hiện truy vấn
        if(mysqli_query($conn, $delete_query)) {
            // Chuyển hướng về trang view_category.php
            echo "<script>window.location.href = 'view_category.php?id=$category_id';</script>";
            exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
        } else {
            // Hiển thị thông báo lỗi nếu có
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    } else {
        // Hiển thị thông báo nếu không có tham số id hoặc category_id truyền qua
        echo "<div class='alert alert-danger'>Không có ID sách hoặc ID thể loại được truyền qua.</div>";
    }
?>
