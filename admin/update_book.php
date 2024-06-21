<?php
    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem id của sách có tồn tại không
    if(isset($_POST['id'])) {
        $book_id = $_POST['id'];
        
        // Lấy dữ liệu từ form
        $title = $_POST['title'];
        $author = $_POST['author'];
        $image_url = $_POST['image']; // Lấy URL ảnh từ form

        // Kiểm tra nếu URL ảnh không rỗng, cập nhật đường dẫn ảnh mới vào cơ sở dữ liệu
        if(!empty($image_url)) {
            $query = "UPDATE book SET Tensach='$title', Tacgia='$author', Anhbia='$image_url' WHERE Id_book = $book_id";
        } else {
            // Nếu không có URL ảnh, chỉ cập nhật thông tin sách
            $query = "UPDATE book SET Tensach='$title', Tacgia='$author' WHERE Id_book = $book_id";
        }
        
        // Thực hiện truy vấn cập nhật
        if(mysqli_query($conn, $query)) {
            // Chuyển hướng người dùng trở lại trang audiobook.php sau khi cập nhật thành công
            header("Location: audiobook.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Book ID not provided!";
    }
?>
