<?php
    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem id của sách có tồn tại không
    if(isset($_POST['id'])) {
        $book_id = $_POST['id'];
        
        // Lấy dữ liệu từ form
        $title = $_POST['title'];
        $author = $_POST['author'];
        
        // Kiểm tra xem có tập tin ảnh mới được tải lên không
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            
            // Di chuyển tập tin ảnh vào thư mục lưu trữ
            move_uploaded_file($image_tmp_name, "uploads/" . $image_name);
            
            // Cập nhật đường dẫn ảnh mới vào cơ sở dữ liệu
            $image_path = "uploads/" . $image_name;
            $query = "UPDATE book SET Tensach='$title', Tacgia='$author', Anhbia='$image_path' WHERE Id_book = $book_id";
        } else {
            // Nếu không có tập tin ảnh mới, chỉ cập nhật thông tin sách
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
