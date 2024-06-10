<?php 
    include('includes/header.php');
    include('includes/navbar.php'); 

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Lấy ID thể loại từ URL
    $id = $_GET['id'];

    // Truy vấn thông tin thể loại
    $category_query = "SELECT * FROM category WHERE Id_category = $id";
    $category_result = mysqli_query($conn, $category_query);

    // Kiểm tra xem có dữ liệu thể loại không
    if ($category_row = mysqli_fetch_assoc($category_result)) {

        // Số trang hiện tại
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Số sách trên mỗi trang
        $limit = 10;

        // Tính toán offset
        $offset = ($page - 1) * $limit;

        // Truy vấn thông tin các sách trong thể loại với LIMIT và OFFSET
        $book_query = "SELECT book.Id_book, book.Tensach, book.Tacgia 
                       FROM book_category 
                       JOIN book ON book_category.Id_book = book.Id_book 
                       WHERE book_category.Id_category = $id LIMIT $offset, $limit";
        $book_result = mysqli_query($conn, $book_query);

        // Truy vấn tổng số sách trong thể loại
        $total_books_query = "SELECT COUNT(*) FROM book_category WHERE Id_category = $id";
        $total_books_result = mysqli_query($conn, $total_books_query);
        $total_books_row = mysqli_fetch_row($total_books_result);
        $total_books = $total_books_row[0];

        // Tính tổng số trang
        $total_pages = ceil($total_books / $limit);
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Sách trong thể loại <?php echo $category_row['Tentheloai']; ?></h5>
                    <div class="card-body">
                        <a href="add_category_detail.php?category_id=<?php echo $id; ?>" class="btn btn-success mb-3">Thêm sách</a> <!-- Nút thêm sách -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID sách</th>
                                        <th>Tên sách</th>
                                        <th>Tác giả</th>
                                        <th>Hành động</th> <!-- Thêm cột Hành động -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Kiểm tra xem có dữ liệu sách không
                                        if (mysqli_num_rows($book_result) > 0) {
                                            // Lặp qua mỗi hàng kết quả
                                            while ($book_row = mysqli_fetch_assoc($book_result)) {
                                                echo "<tr>";
                                                echo "<td>" . $book_row['Id_book'] . "</td>";
                                                echo "<td>" . $book_row['Tensach'] . "</td>";
                                                echo "<td>" . $book_row['Tacgia'] . "</td>";
                                                echo "<td>
                                                        <a href='delete_category_detail.php?id={$book_row['Id_book']}&category_id={$id}' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa sách này khỏi thể loại không?\")'>Xóa</a>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // Hiển thị thông báo nếu không có dữ liệu sách
                                            echo "<tr><td colspan='4'>Không tìm thấy sách trong thể loại này.</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <!-- Phân trang -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                    // Hiển thị nút Previous
                                    if ($page > 1) {
                                        echo "<li class='page-item'><a class='page-link' href='view_category.php?id=$id&page=" . ($page - 1) . "'>Previous</a></li>";
                                    }

                                    // Hiển thị các nút trang
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $active = ($i == $page) ? "active" : "";
                                        echo "<li class='page-item $active'><a class='page-link' href='view_category.php?id=$id&page=" . $i . "'>" . $i . "</a></li>";
                                    }

                                    // Hiển thị nút Next
                                    if ($page < $total_pages) {
                                        echo "<li class='page-item'><a class='page-link' href='view_category.php?id=$id&page=" . ($page + 1) . "'>Next</a></li>";
                                    }
                                ?>
                            </ul>
                        </nav>
                        <!-- Kết thúc phân trang -->

                        <a href="category.php" class="btn btn-primary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php   
    } else {
        echo "<div class='container'><h4>Không tìm thấy thể loại</h4></div>";
    }

    include('includes/footer.php');
?>
