<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Concept - Bootstrap 4 Admin Dashboard Template</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="icon" href="./assets/images/audiobook.png" type="image/x-icon">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>
<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->

<body>
    <?php
    session_start();
    ?>
    <!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <form class="splash-container" action="code.php" method="POST">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Registrations Form</h3>
                <?php
                if(isset($_SESSION['status'])){
                    echo "<div class='alert alert-warning'>".$_SESSION['status']."</div>";
                    unset($_SESSION['status']);
                }
                if(isset($_SESSION['success'])){
                    echo "<div class='alert alert-success'>".$_SESSION['success']."</div>";
                    unset($_SESSION['success']);
                }
                ?>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="username" required="" placeholder="Username" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="number" name="numberphone" required="" placeholder="phone" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" name="password" type="password" required="" placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" name="comfirmPassword" required="" placeholder="Confirm password">
                </div>
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit" name="registerBtn">Register My Account</button>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>Already member? <a href="login.php" class="text-secondary">Login Here.</a></p>
            </div>
        </div>
    </form>
</body>

 
</html>