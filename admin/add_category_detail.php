<?php
    include('includes/header.php');
    include('includes/navbar.php');

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Lấy ID thể loại từ URL
    $category_id = $_GET['category_id'];

    // Kiểm tra xem form đã được submit chưa
    // Kiểm tra xem form đã được submit chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $Id_book = $_POST['Id_book'];

    // Truy vấn kiểm tra xem cuốn sách đã tồn tại trong thể loại chưa
    $check_query = "SELECT * FROM book_category WHERE Id_book = '$Id_book' AND Id_category = '$category_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Nếu sách đã tồn tại trong thể loại, hiển thị thông báo lỗi
        echo "<div class='alert alert-danger'>Cuốn sách đã tồn tại trong thể loại này.</div>";
    } else {
        // Nếu sách chưa tồn tại trong thể loại, thực hiện thêm sách vào thể loại
        $insert_query = "INSERT INTO book_category (Id_book, Id_category) VALUES ('$Id_book', '$category_id')";
        
        // Thực hiện truy vấn
        if (mysqli_query($conn, $insert_query)) {
            echo "<div class='alert alert-success'>Thêm sách vào thể loại thành công</div>";
            // Chuyển hướng về trang view_category.php
            echo "<script>window.location.href = 'view_category.php?id=$category_id';</script>";
            exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
        } else {
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    }
}


    // Truy vấn danh sách sách
    $book_query = "SELECT Id_book, Tensach FROM book";
    $book_result = mysqli_query($conn, $book_query);
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Thêm sách vào thể loại</h5>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Id_book">Chọn sách</label>
                                <select class="form-control" id="Id_book" name="Id_book" required>
                                    <?php
                                        if (mysqli_num_rows($book_result) > 0) {
                                            while ($book_row = mysqli_fetch_assoc($book_result)) {
                                                echo "<option value='" . $book_row['Id_book'] . "'>" . $book_row['Tensach'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Không có sách nào</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm sách</button>
                        </form>
                        <a href="view_category.php?id=<?php echo $category_id; ?>" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include('includes/footer.php');
?>
