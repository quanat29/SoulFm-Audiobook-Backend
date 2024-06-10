<?php 
    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem có ID chương và ID sách được gửi từ URL không
    if(isset($_GET['id']) && isset($_GET['book_id'])){
        // Lấy ID chương và ID sách từ URL
        $id_chapter = $_GET['id'];
        $id_book = $_GET['book_id'];

        // Truy vấn xóa chương sách
        $delete_query = "DELETE FROM bookchapter WHERE Id_bookchapter = $id_chapter";

        // Thực hiện truy vấn
        if (mysqli_query($conn, $delete_query)) {
            // Chuyển hướng về trang view_book.php với tham số 'id' của sách
            header("Location: view_book.php?id=" . $id_book);
            exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
        } else {
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    } else {
        // Nếu không có đủ thông tin ID chương và ID sách, hiển thị thông báo lỗi
        echo "<div class='container'><h4>Không tìm thấy thông tin chương hoặc sách</h4></div>";
    }
?>
