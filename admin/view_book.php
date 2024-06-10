<?php 
    include('includes/header.php');
    include('includes/navbar.php'); 

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Lấy ID sách từ URL
    $id = $_GET['id'];

    // Truy vấn thông tin sách
    $book_query = "SELECT * FROM book WHERE Id_book = $id";
    $book_result = mysqli_query($conn, $book_query);

    // Kiểm tra xem có dữ liệu sách không
    if ($book_row = mysqli_fetch_assoc($book_result)) {

        // Số trang hiện tại
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Số chương trên mỗi trang
        $limit = 10;

        // Tính toán offset
        $offset = ($page - 1) * $limit;

        // Truy vấn thông tin các chương sách với LIMIT và OFFSET
        $chapter_query = "SELECT * FROM bookchapter WHERE Id_book = $id LIMIT $offset, $limit";
        $chapter_result = mysqli_query($conn, $chapter_query);

        // Truy vấn tổng số chương sách
        $total_chapters_query = "SELECT COUNT(*) FROM bookchapter WHERE Id_book = $id";
        $total_chapters_result = mysqli_query($conn, $total_chapters_query);
        $total_chapters_row = mysqli_fetch_row($total_chapters_result);
        $total_chapters = $total_chapters_row[0];

        // Tính tổng số trang
        $total_pages = ceil($total_chapters / $limit);
?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Chương sách</h5>
                    <div class="card-body">
                        <a href="add_chapter.php?book_id=<?php echo $id; ?>" class="btn btn-success mb-3">Thêm chương</a> <!-- Nút thêm chương -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID chương</th>
                                        <th>Tên chương</th>
                                        <th>Thời lượng</th>
                                        <th>Tập</th>
                                        <th>Hành động</th> <!-- Thêm cột Hành động -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Kiểm tra xem có dữ liệu chương sách không
                                        if (mysqli_num_rows($chapter_result) > 0) {
                                            // Lặp qua mỗi hàng kết quả
                                            while ($chapter_row = mysqli_fetch_assoc($chapter_result)) {
                                                echo "<tr>";
                                                echo "<td>" . $chapter_row['Id_bookchapter'] . "</td>";
                                                echo "<td>" . $chapter_row['Tenchapter'] . "</td>";
                                                echo "<td>" . $chapter_row['Duration'] . "</td>";
                                                echo "<td>" . $chapter_row['episode'] . "</td>";
                                                echo "<td>
                                                        <a href='edit_chapter.php?id=" . $chapter_row['Id_bookchapter'] . "&book_id=" . $id . "' class='btn btn-primary'>Sửa</a>
                                                        <a href='delete_chapter.php?id=" . $chapter_row['Id_bookchapter'] . "&book_id=" . $id . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa chương này không?\")'>Delete</a>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // Hiển thị thông báo nếu không có dữ liệu chương sách
                                            echo "<tr><td colspan='8'>Không tìm thấy chương sách.</td></tr>";
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
                                        echo "<li class='page-item'><a class='page-link' href='view_book.php?id=$id&page=" . ($page - 1) . "'>Previous</a></li>";
                                    }

                                    // Hiển thị các nút trang
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $active = ($i == $page) ? "active" : "";
                                        echo "<li class='page-item $active'><a class='page-link' href='view_book.php?id=$id&page=" . $i . "'>" . $i . "</a></li>";
                                    }

                                    // Hiển thị nút Next
                                    if ($page < $total_pages) {
                                        echo "<li class='page-item'><a class='page-link' href='view_book.php?id=$id&page=" . ($page + 1) . "'>Next</a></li>";
                                    }
                                ?>
                            </ul>
                        </nav>
                        <!-- Kết thúc phân trang -->

                        <a href="audiobook.php" class="btn btn-primary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php   
    } else {
        echo "<div class='container'><h4>Không tìm thấy sách</h4></div>";
    }

    include('includes/footer.php');
?>
