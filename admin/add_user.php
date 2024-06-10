<?php
    // Bao gồm các file header và navbar
    include('includes/header.php');
    include('includes/navbar.php');

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

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

        // Kiểm tra xem tên đăng nhập đã tồn tại hay chưa
        $check_query = "SELECT * FROM user_book WHERE Tendangnhap = '$Tendangnhap'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<div class='alert alert-danger'>Tên đăng nhập đã tồn tại, vui lòng chọn tên đăng nhập khác</div>";
        } else {
            // Truy vấn thêm người dùng mới
            $insert_query = "INSERT INTO user_book (Tendangnhap, Sdt, Matkhau, User_Role, Trangthai) 
                            VALUES ('$Tendangnhap', '$Sdt', '$Matkhau', '$User_Role', '$Trangthai')";

            // Thực hiện truy vấn
            if (mysqli_query($conn, $insert_query)) {
                echo "<div class='alert alert-success'>Thêm người dùng thành công</div>";
                // Chuyển hướng về trang user.php
                echo "<script>window.location.href = 'user.php';</script>";
                exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
            } else {
                echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
            }
        }
    }
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Thêm người dùng mới</h5>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Tendangnhap">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="Tendangnhap" name="Tendangnhap" required>
                            </div>
                            <div class="form-group">
                                <label for="Sdt">Số điện thoại</label>
                                <input type="text" class="form-control" id="Sdt" name="Sdt" required>
                            </div>
                            <div class="form-group">
                                <label for="Matkhau">Mật khẩu</label>
                                <input type="password" class="form-control" id="Matkhau" name="Matkhau" required>
                            </div>
                            <div class="form-group">
                                <label for="User_Role">Role</label>
                                <select class="form-control" id="User_Role" name="User_Role" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Trangthai">Trạng thái</label>
                                <select class="form-control" id="Trangthai" name="Trangthai" required
                                >
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm người dùng</button>
                        </form>
                        <a href="user.php" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    // Bao gồm file footer
    include('includes/footer.php');
?>
