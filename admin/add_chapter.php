<?php
    include('includes/header.php');
    include('includes/navbar.php');

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem form đã được submit chưa
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $Tenchapter = $_POST['Tenchapter'];
        $Audiofile = $_POST['Audiofile'];
        $Duration = $_POST['Duration'];
        $Id_book = $_POST['Id_book'];
        $episode = $_POST['episode'];
        $num_sections = $_POST['num_sections'];

        // Truy vấn thêm chương mới
        $insert_query = "INSERT INTO bookchapter (Tenchapter, Audiofile, Duration, Id_book, episode, num_sections) VALUES ('$Tenchapter', '$Audiofile', '$Duration', '$Id_book', '$episode', '$num_sections')";

        // Thực hiện truy vấn
        if (mysqli_query($conn, $insert_query)) {
            echo "<div class='alert alert-success'>Thêm chương sách thành công</div>";
            // Chuyển hướng về trang view_book.php
            echo "<script>window.location.href = 'view_book.php?id=$Id_book';</script>";
            exit(); // Dừng script để chắc chắn không có mã HTML hoặc mã PHP được thực thi sau chuyển hướng
        } else {
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    }

    // Lấy ID sách từ URL
    $id_book = $_GET['book_id'];
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Thêm chương sách mới</h5>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Tenchapter">Tên chương</label>
                                <input type="text" class="form-control" id="Tenchapter" name="Tenchapter" required>
                            </div>
                            <div class="form-group">
                                <label for="Audiofile">File âm thanh (URL)</label>
                                <input type="text" class="form-control" id="Audiofile" name="Audiofile" required>
                            </div>
                            <div class="form-group">
                                <label for="Duration">Thời lượng</label>
                                <input type="text" class="form-control" id="Duration" name="Duration" required>
                            </div>
                            <div class="form-group">
                                <label for="episode">Tập</label>
                                <input type="number" class="form-control" id="episode" name="episode" required>
                            </div>
                            <div class="form-group">
                                <label for="num_sections">Số phần</label>
                                <input type="number" class="form-control" id="num_sections" name="num_sections" required>
                            </div>
                            <input type="hidden" name="Id_book" value="<?php echo $id_book; ?>">
                            <button type="submit" class="btn btn-primary">Thêm chương</button>
                        </form>
                        <a href="view_book.php?id=<?php echo $id_book; ?>" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include('includes/footer.php');
?>
