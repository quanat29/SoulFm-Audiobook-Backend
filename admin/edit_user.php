<?php 
    include('includes/header.php');
    include('includes/navbar.php'); 

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Lấy ID người dùng từ URL
    $user_id = $_GET['id'];

    // Truy vấn thông tin người dùng
    $user_query = "SELECT * FROM user_book WHERE Id_user = $user_id";
    $user_result = mysqli_query($conn, $user_query);

    // Kiểm tra xem có dữ liệu người dùng không
    if ($user_row = mysqli_fetch_assoc($user_result)) {
        // Kiểm tra xem form đã được submit chưa
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $Tendangnhap = $_POST['Tendangnhap'];
            $Sdt = $_POST['Sdt'];
            $Matkhau = $_POST['Matkhau'];
            $User_Role = $_POST['User_Role'];
            $Trangthai = $_POST['Trangthai'];

            // Ánh xạ giá trị của User_Role và Trangthai
            if ($User_Role == 'admin') {
                $User_Role = 2;
            } else {
                $User_Role = 1;
            }

            if ($Trangthai == 'active') {
                $Trangthai = 1;
            } else {
                $Trangthai = 2;
            }

            // Truy vấn cập nhật thông tin người dùng
            $update_query = "UPDATE user_book SET Tendangnhap = '$Tendangnhap', Sdt = '$Sdt', Matkhau = '$Matkhau', User_Role = '$User_Role', Trangthai = '$Trangthai' WHERE Id_user = $user_id";

            // Thực hiện truy vấn
            if (mysqli_query($conn, $update_query)) {
                echo "<div class='alert alert-success'>Cập nhật thông tin người dùng thành công</div>";
                // Chuyển hướng về trang user.php
                echo "<script>window.location.href = 'user.php';</script>";
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
                    <h5 class="card-header">Sửa thông tin người dùng</h5>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Tendangnhap">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="Tendangnhap" name="Tendangnhap" value="<?php echo $user_row['Tendangnhap']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Sdt">Số điện thoại</label>
                                <input type="text" class="form-control" id="Sdt" name="Sdt" value="<?php echo $user_row['Sdt']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Matkhau">Mật khẩu</label>
                                <input type="text" class="form-control" id="Matkhau" name="Matkhau" value="<?php echo $user_row['Matkhau']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="User_Role">Role</label>
                                <select class="form-control" id="User_Role" name="User_Role" required>
                                    <option value="admin" <?php if ($user_row['User_Role'] == 2) echo 'selected'; ?>>Admin</option>
                                    <option value="user" <?php if ($user_row['User_Role'] == 1) echo 'selected'; ?>>User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Trangthai">Trạng thái</label>
                                <select class="form-control" id="Trangthai" name="Trangthai" required>
                                    <option value="active" <?php if ($user_row['Trangthai'] == 1) echo 'selected'; ?>>Active</option>
                                    <option value="inactive" <?php if ($user_row['Trangthai'] == 2) echo 'selected'; ?>>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật thông tin người dùng</button>
                        </form>
                        <a href="user.php" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    } else {
        echo "<div class='container'><h4>Không tìm thấy thông tin người dùng</h4></div>";
    }

    include('includes/footer.php');
?>
