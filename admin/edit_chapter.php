<?php 
    include('includes/header.php');
    include('includes/navbar.php'); 

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Lấy ID chương từ URL
    $id_chapter = $_GET['id'];

    // Truy vấn thông tin chương sách
    $chapter_query = "SELECT * FROM bookchapter WHERE Id_bookchapter = $id_chapter";
    $chapter_result = mysqli_query($conn, $chapter_query);

    // Kiểm tra xem có dữ liệu chương sách không
    if ($chapter_row = mysqli_fetch_assoc($chapter_result)) {
        // Kiểm tra xem form đã được submit chưa
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $Tenchapter = $_POST['Tenchapter'];
            $Audiofile = $_POST['Audiofile'];
            $Duration = $_POST['Duration'];
            $episode = $_POST['episode'];
            $num_sections = $_POST['num_sections'];

            // Truy vấn cập nhật thông tin chương
            $update_query = "UPDATE bookchapter SET Tenchapter = '$Tenchapter', Audiofile = '$Audiofile', Duration = '$Duration', episode = '$episode', num_sections = '$num_sections' WHERE Id_bookchapter = $id_chapter";

            // Thực hiện truy vấn
            if (mysqli_query($conn, $update_query)) {
                echo "<div class='alert alert-success'>Cập nhật thông tin chương sách thành công</div>";
                // Chuyển hướng về trang view_book.php
                echo "<script>window.location.href = 'view_book.php?id={$chapter_row['Id_book']}';</script>";
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
                    <h5 class="card-header">Sửa thông tin chương sách</h5>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Tenchapter">Tên chương</label>
                                <input type="text" class="form-control" id="Tenchapter" name="Tenchapter" value="<?php echo $chapter_row['Tenchapter']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Audiofile">File âm thanh (URL)</label>
                                <input type="text" class="form-control" id="Audiofile" name="Audiofile" value="<?php echo $chapter_row['Audiofile']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Duration">Thời lượng</label>
                                <input type="text" class="form-control" id="Duration" name="Duration" value="<?php echo $chapter_row['Duration']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="episode">Tập</label>
                                <input type="number" class="form-control" id="episode" name="episode" value="<?php echo $chapter_row['episode']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="num_sections">Số phần</label>
                                <input type="number" class="form-control" id="num_sections" name="num_sections" value="<?php echo $chapter_row['num_sections']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật thông tin chương</button>
                        </form>
                        <a href="view_book.php?id=<?php echo $chapter_row['Id_book']; ?>" class="btn btn-secondary mt-3">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    } else {
        echo "<div class='container'><h4>Không tìm thấy thông tin chương sách</h4></div>";
    }

    include('includes/footer.php');
?>
