<?php
// Kết nối cơ sở dữ liệu
require '../connect.php';

// Kiểm tra xem id của sách đã được truyền qua URL chưa
if(isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Xóa tất cả các chương của cuốn sách trước khi xóa cuốn sách
    $delete_chapters_query = "DELETE FROM bookchapter WHERE Id_book = $book_id";

    // Thực hiện truy vấn xóa tất cả các chương
    if(mysqli_query($conn, $delete_chapters_query)) {
        // Tiếp tục xóa cuốn sách sau khi đã xóa tất cả các chương thành công
        $delete_book_query = "DELETE FROM book WHERE Id_book = $book_id";

        // Thực hiện truy vấn xóa cuốn sách
        if(mysqli_query($conn, $delete_book_query)) {
            // Chuyển hướng người dùng trở lại trang audiobook.php sau khi xóa thành công
            header("Location: audiobook.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting chapters: " . mysqli_error($conn);
    }
} else {
    echo "Book ID not provided!";
}
?>
