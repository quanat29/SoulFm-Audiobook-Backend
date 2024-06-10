    <?php 
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
                        <!-- <h5 class="card-header">Thêm Dữ Liệu</h5> Thêm tiêu đề cho phần thêm dữ liệu -->
                        <div class="card-body">
                            <a href="add_book.php" class="btn btn-success mb-3">Thêm mới</a> <!-- Nút thêm dữ liệu -->
                            <form action="" method="GET">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên sách">
                                </div>
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </form>
                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-bordered first">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Kết nối cơ sở dữ liệu
                                            require '../connect.php';

                                            // Số trang hiện tại
                                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                            
                                            // Số sách trên mỗi trang
                                            $limit = 10;
                                            
                                            // Tính toán offset
                                            $offset = ($page - 1) * $limit;

                                            // Truy vấn dữ liệu sách với LIMIT và OFFSET
                                            $query = "SELECT * FROM book";
                                            
                                            // Kiểm tra xem có yêu cầu tìm kiếm không
                                            if(isset($_GET['search']) && !empty($_GET['search'])){
                                                $search = $_GET['search'];
                                                $query .= " WHERE Tensach LIKE '%$search%'";
                                            }

                                            $query .= " LIMIT $offset, $limit";
                                            
                                            $result = mysqli_query($conn, $query);

                                            // Kiểm tra xem có dữ liệu không
                                            if (mysqli_num_rows($result) > 0) {
                                                // Lặp qua mỗi hàng kết quả
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['Id_book'] . "</td>";
                                                    echo "<td>" . $row['Tensach'] . "</td>";
                                                    echo "<td>" . $row['Tacgia'] . "</td>";
                                                    echo "<td><img src='{$row['Anhbia']}' alt='Book Cover' style='max-width: 100px;'></td>";
                                                    echo "<td>
                                                            <a href='view_book.php?id={$row['Id_book']}' class='btn btn-secondary'>View</a>
                                                            <a href='edit_book.php?id={$row['Id_book']}' class='btn btn-primary'>Edit</a>
                                                            <a href='delete_book.php?id={$row['Id_book']}' class='btn btn-danger'>Delete</a> 
                                                        </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                // Hiển thị thông báo nếu không có dữ liệu
                                                echo "<tr><td colspan='8'>Không tìm thấy sách.</td></tr>";
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
                                // Số lượng sách
                                $total_books_query = "SELECT COUNT(*) FROM book";
                                $total_books_result = mysqli_query($conn, $total_books_query);
                                $total_books_row = mysqli_fetch_row($total_books_result);
                                $total_books = $total_books_row[0];

                                // Tính tổng số trang
                                $total_pages = ceil($total_books / $limit);

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
