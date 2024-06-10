<?php
    include('includes/header.php');
    include('includes/navbar.php');

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem form đã được submit chưa
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $Tentheloai = $_POST['Tentheloai'];

        // Truy vấn thêm thể loại mới
        $insert_query = "INSERT INTO category (Tentheloai) VALUES ('$Tentheloai')";

        // Thực hiện truy vấn
        if (mysqli_query($conn, $insert_query)) {
            echo "<div class='alert alert-success'>Thêm thể loại thành công</div>";
            // Chuyển hướng về trang category.php
            echo "<script>window.location.href = 'category.php';</script>";
            exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
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
                    <h5 class="card-header">Thêm thể loại mới</h5>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Tentheloai">Tên thể loại</label>
                                <input type="text" class="form-control" id="Tentheloai" name="Tentheloai" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm thể loại</button>
                        </form>
                        <a href="category.php" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include('includes/footer.php');
?>
