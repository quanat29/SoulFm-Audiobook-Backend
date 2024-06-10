<?php
session_start();
require '../connect.php';

if(isset($_POST['registerBtn'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sdt = $_POST['numberphone'];
    $cpassword = $_POST['comfirmPassword'];

    // Check if any field is empty
    if(empty($username) || empty($password) || empty($sdt) || empty($cpassword)) {
        $_SESSION['status'] = "All fields are required";
        header('Location: register.php');
        exit();
    }

    // Store the form data in session variables
    $_SESSION['form_data'] = $_POST;

    // Check if the username already exists
    $check_query = "SELECT * FROM `user_book` WHERE `Tendangnhap` = '$username'";
    $check_query_run = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($check_query_run) > 0){
        // Username already exists
        $_SESSION['status'] = "Username already exists";
        header('Location: register.php');
    } else {
        // Proceed with registration if passwords match
        if($password == $cpassword){
            $query = "INSERT INTO `user_book` (`Id_user`, `Tendangnhap`, `Sdt`, `Matkhau`, `User_Role`, `Trangthai`) VALUES (null, '$username', '$sdt', '$password', 2, 1)"; 
            $query_run = mysqli_query($conn, $query);
            if($query_run){
                $_SESSION['success'] = "Create Admin Account Successfully";
                unset($_SESSION['form_data']); // Clear the form data from session
                header('Location: login.php');
            } else {
                $_SESSION['status'] = "Create Admin Account Not Successfully";
                header('Location: register.php');
            }
        } else {
            $_SESSION['status'] = "Passwords do not match";
            header('Location: register.php');
        }
    }
}

if (isset($_POST['loginBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if any field is empty
    if(empty($username) || empty($password)) {
        $_SESSION['status'] = "All fields are required";
        header('Location: login.php');
        exit();
    }

    // Update query to check for User_Role = 2
    $query = "SELECT * FROM `user_book` WHERE `Tendangnhap` = '$username' AND `Matkhau` = '$password' AND `User_Role` = 2";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $user_data = mysqli_fetch_assoc($query_run);
        $_SESSION['user_id'] = $user_data['Id_user'];
        $_SESSION['username'] = $user_data['Tendangnhap'];
        $_SESSION['user_role'] = $user_data['User_Role']; // Correct capitalization
        $_SESSION['logged_in'] = true;
        header('Location: index.php'); // redirect to a protected page
        exit();
    } else {
        $_SESSION['status'] = "The account is not authorized";
        header('Location: login.php');
        exit();
    }
}
?>
