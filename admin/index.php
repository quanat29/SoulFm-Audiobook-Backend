<?php 
    include('includes/header.php');
    include('includes/navbar.php');     
    
    // Check if the user is not logged in, redirect to login page
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: login.php');
        exit(); // Ensure script stops executing after redirection
    }
?>
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
            <h1>Welcome to the Soulfm admin page</h1>
            </div>
        </div>
<?php   
    include('includes/footer.php');
?>