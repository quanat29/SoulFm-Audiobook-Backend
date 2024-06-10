<?php 
    // Kết nối cơ sở dữ liệu
    require '../connect.php';
    include('includes/header.php');
    include('includes/navbar.php');     
?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>Tên đăng nhập</th>
                                        <th>Bình luận</th>
                                        <th>Thời gian bình luận</th>
                                        <th>Số sao</th>
                                        <th>Tên sách</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Số lượng bình luận trên mỗi trang
                                        $limit = 10;
                                        
                                        // Số trang hiện tại
                                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        
                                        // Tính toán offset
                                        $offset = ($page - 1) * $limit;

                                        // Truy vấn dữ liệu từ bảng comment, user_book và book
                                        $query = "SELECT comment.Id_comment, user_book.Tendangnhap, comment.Binhluan, comment.Thoigianbinhluan, comment.comment_star, book.Tensach 
                                                  FROM comment 
                                                  JOIN user_book ON comment.Id_user = user_book.Id_user
                                                  JOIN book ON comment.Id_book = book.Id_book
                                                  LIMIT $offset, $limit";
                                        $result = mysqli_query($conn, $query);

                                        // Kiểm tra xem có dữ liệu không
                                        if (mysqli_num_rows($result) > 0) {
                                            // Lặp qua mỗi hàng kết quả
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['Tendangnhap'] . "</td>";
                                                echo "<td>" . $row['Binhluan'] . "</td>";
                                                echo "<td>" . $row['Thoigianbinhluan'] . "</td>";
                                                echo "<td>" . $row['comment_star'] . "</td>";
                                                echo "<td>" . $row['Tensach'] . "</td>";
                                                echo "<td>
                                                        <a href='delete_comment.php?id={$row['Id_comment']}' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa bình luận này không?\")'>Xóa</a>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // Hiển thị thông báo nếu không có dữ liệu
                                            echo "<tr><td colspan='6'>Không có bình luận nào.</td></tr>";
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
                            // Truy vấn dữ liệu số lượng bình luận
                            $total_comments_query = "SELECT COUNT(*) FROM comment";
                            $total_comments_result = mysqli_query($conn, $total_comments_query);
                            $total_comments_row = mysqli_fetch_row($total_comments_result);
                            $total_comments = $total_comments_row[0];

                            // Tính tổng số trang
                            $total_pages = ceil($total_comments / $limit);

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
