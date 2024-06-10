<?php
    include('includes/header.php');
    include('includes/navbar.php');

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Hàm để tạo ID sách ngẫu nhiên
    function generateRandomBookId($conn) {
        $randomId = mt_rand(1, 9999); // Tạo một số ngẫu nhiên từ 100000 đến 999999

        // Kiểm tra xem số ngẫu nhiên đã tồn tại trong cơ sở dữ liệu chưa
        $query = "SELECT Id_book FROM book WHERE Id_book = $randomId";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            // Nếu số đã tồn tại, thử lại với một số khác
            return generateRandomBookId($conn);
        } else {
            // Nếu số chưa tồn tại, trả về số ngẫu nhiên
            return $randomId;
        }
    }

    // Kiểm tra xem form đã được submit chưa
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $title = $_POST['title'];
        $author = $_POST['author'];
        // Đặt mặc định cho rating và reviews là 0.0 và 0
        $rating = 0.0;
        $reviews = 0;
        $image = $_POST['image'];

        // Tạo ID sách mới
        $bookId = generateRandomBookId($conn);

        // Query để thêm sách mới vào cơ sở dữ liệu với ID mới
        $query = "INSERT INTO book (Id_book, Tensach, Tacgia, Sosao, Sobinhluan, Anhbia) VALUES ('$bookId', '$title', '$author', $rating, $reviews, '$image')";

        if (mysqli_query($conn, $query)) {
            // Nếu thêm thành công, chuyển hướng người dùng về trang audiobook.php
            echo "<div class='alert alert-success'>Thêm sách thành công</div>";
            // Chuyển hướng về trang audiobook.php
            echo "<script>window.location.href = 'audiobook.php';</script>";
            exit();
        } else {
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    }
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Thêm sách mới</h5>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Tác giả</label>
                                <input type="text" class="form-control" id="author" name="author" required>
                            </div>
                            <!-- Đặt mặc định cho rating và reviews là 0.0 và 0 -->
                            <input type="hidden" name="rating" value="0.0">
                            <input type="hidden" name="reviews" value="0">
                            <div class="form-group">
                                <label for="image">Link ảnh</label>
                                <input type="text" class="form-control" id="image" name="image" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm sách</button>
                        </form>
                        <a href="audiobook.php" class="btn btn-secondary mt-3">Quay lại</a>
                   
