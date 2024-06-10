<?php 
    // Kết nối cơ sở dữ liệu
    require '../connect.php';
    include('includes/header.php');
    include('includes/navbar.php'); 
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="add_user.php" class="btn btn-success mb-3">Thêm mới</a> <!-- Nút thêm dữ liệu -->
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>ID User</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Số điện thoại</th>
                                        <th>Mật khẩu</th>
                                        <th>Role</th>
                                        <th>Trạng thái</th>
                                        <th>Action</th> <!-- Thêm cột Action -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Số trang hiện tại
                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        
                                        // Số user trên mỗi trang
                                        $limit = 10;
                                        
                                        // Tính toán offset
                                        $offset = ($page - 1) * $limit;

                                        // Truy vấn dữ liệu user từ bảng user_book với LIMIT và OFFSET
                                        $query = "SELECT * FROM user_book LIMIT $offset, $limit";
                                        $result = mysqli_query($conn, $query);

                                        // Kiểm tra xem có dữ liệu không
                                        if (mysqli_num_rows($result) > 0) {
                                            // Lặp qua mỗi hàng kết quả
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['Id_user'] . "</td>";
                                                echo "<td>" . $row['Tendangnhap'] . "</td>";
                                                echo "<td>" . $row['Sdt'] . "</td>";
                                                echo "<td>" . $row['Matkhau'] . "</td>";
                                                echo "<td>" . $row['User_Role'] . "</td>";
                                                echo "<td>" . $row['Trangthai'] . "</td>";
                                                echo "<td>
                                                        <a href='edit_user.php?id={$row['Id_user']}' class='btn btn-primary'>Sửa</a>
                                                        <a href='delete_user.php?id={$row['Id_user']}' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này không?\")'>Xóa</a>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // Hiển thị thông báo nếu không có dữ liệu
                                            echo "<tr><td colspan='7'>Không có người dùng.</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        <!-- Phân trang -->
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                            // Số lượng user
                            $total_users_query = "SELECT COUNT(*) FROM user_book";
                            $total_users_result = mysqli_query($conn, $total_users_query);
                            $total_users_row = mysqli_fetch_row($total_users_result);
                            $total_users = $total_users_row[0];

                            // Tính tổng số trang
                            $total_pages = ceil($total_users / $limit);

                            // Hiển thị nút Previous
                            if ($page > 1) {
                                echo "<li class='page-item'><a class='page-link' href='?page=".($page - 1)."'>Previous</a></li>";
                            }

                            // Hiển thị các nút trang
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $active = ($i == $page) ? "active" : "";
                                echo "<li class='page-item $active'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
                            }

                            // Hiển thị nút Next
                            if ($page < $total_pages) {
                                echo "<li class='page-item'><a class='page-link' href='?page=".($page + 1)."'>Next</a></li>";
                            }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Kết thúc phân trang -->
    </div>
</div>

<?php   
    include('includes/footer.php');
?>
