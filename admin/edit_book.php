<?php
    include('includes/header.php');
    include('includes/navbar.php'); 

    // Kết nối cơ sở dữ liệu
    require '../connect.php';

    // Kiểm tra xem id của sách đã được truyền qua URL chưa
    if(isset($_GET['id'])) {
        $book_id = $_GET['id'];

        // Truy vấn dữ liệu của sách dựa trên id
        $query = "SELECT * FROM book WHERE Id_book = $book_id";
        $result = mysqli_query($conn, $query);

        // Kiểm tra xem có dữ liệu không
        if(mysqli_num_rows($result) > 0) {
            $book = mysqli_fetch_assoc($result);
        } else {
            echo "Book not found!";
            exit(); // Kết thúc kịch bản nếu không tìm thấy sách
        }
    } else {
        echo "Book ID not provided!";
        exit(); // Kết thúc kịch bản nếu không có id sách được cung cấp
    }
?>

<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block" id="basicform">
                    <h3 class="section-title">Edit Book Information</h3>
                    <p>Use the form below to edit book information.</p>
                </div>
                <div class="card">
                    <h5 class="card-header">Book Details</h5>
                    <div class="card-body">
                        <form action="update_book.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputTitle" class="col-form-label">Title</label>
                                <input id="inputTitle" type="text" name="title" class="form-control" value="<?php echo $book['Tensach']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="inputAuthor" class="col-form-label">Author</label>
                                <input id="inputAuthor" type="text" name="author" class="form-control" value="<?php echo $book['Tacgia']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="inputRating" class="col-form-label">Rating</label>
                                <input id="inputRating" type="number" name="rating" min="1" max="5" step="any" class="form-control" value="<?php echo $book['Sosao']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="inputReviews" class="col-form-label">Reviews</label>
                                <input id="inputReviews" type="number" name="reviews" class="form-control" value="<?php echo $book['Sobinhluan']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="inputImage" class="col-form-label">Select Image</label>
                                <input id="inputImage" type="file" name="image" class="form-control-file">
                                <?php if(!empty($book['Anhbia'])): ?>
                                    <img src="<?php echo $book['Anhbia']; ?>" alt="Book Cover" style="max-width: 100px;">
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $book['Id_book']; ?>">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php   
    include('includes/footer.php');
?>
