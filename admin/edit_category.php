<?php 
    include('includes/header.php');
    include('includes/navbar.php'); 

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Lấy ID thể loại từ URL
    $id_category = $_GET['id'];

    // Truy vấn thông tin thể loại
    $category_query = "SELECT * FROM category WHERE Id_category = $id_category";
    $category_result = mysqli_query($conn, $category_query);

    // Kiểm tra xem có dữ liệu thể loại không
    if ($category_row = mysqli_fetch_assoc($category_result)) {
        // Kiểm tra xem form đã được submit chưa
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $Tentheloai = $_POST['Tentheloai'];

            // Truy vấn cập nhật thông tin thể loại
            $update_query = "UPDATE category SET Tentheloai = '$Tentheloai' WHERE Id_category = $id_category";

            // Thực hiện truy vấn
            if (mysqli_query($conn, $update_query)) {
                echo "<div class='alert alert-success'>Cập nhật thông tin thể loại thành công</div>";
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
                    <h5 class="card-header">Sửa thông tin thể loại</h5>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Tentheloai">Tên thể loại</label>
                                <input type="text" class="form-control" id="Tentheloai" name="Tentheloai" value="<?php echo $category_row['Tentheloai']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật thông tin thể loại</button>
                        </form>
                        <a href="category.php" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    } else {
        echo "<div class='container'><h4>Không tìm thấy thông tin thể loại</h4></div>";
    }

    include('includes/footer.php');
?>
