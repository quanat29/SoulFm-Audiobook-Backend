<?php
require "connect.php";

// // Kiểm tra các biến được truyền từ URL
//     // Lấy giá trị từ URL
//     $tendangnhap = $_GET['Tendangnhap'];
//     $sdt = $_GET['Sdt'];
//     $matkhau = $_GET['Matkhau'];
//     // Kiểm tra kết nối đến cơ sở dữ liệu
//         // Kiểm tra người dùng đã tồn tại hay chưa
//         $check_query = mysqli_query($conn, "SELECT `Tendangnhap` FROM `user_book` WHERE `Tendangnhap` = '$tendangnhap'");
//         if(mysqli_num_rows($check_query) > 0){
//             // Người dùng đã tồn tại
//             $response['code'] = 400;
//             $response['status'] = false;
//             $response['message'] = "User Already Exists";
//         } else {
//             // Thêm người dùng mới vào cơ sở dữ liệu
//             $insert_query = "INSERT into `user_book` (`Id_user`, `Tendangnhap`, `Sdt`, `Matkhau`,`User_Role`, `Trangthai`) Values (null, '$tendangnhap', '$sdt', '$matkhau',1,1)";
//             if (mysqli_query($conn, $insert_query)) {
//                 // Người dùng được thêm thành công
//                 $response['code'] = 200;
//                 $response['status'] = true;
//                 $response['message'] = "User Added Successfully";
//             } else {
//                 // Lỗi khi thêm người dùng
//                 $response['code'] = 500;
//                 $response['status'] = false;
//                 $response['message'] = "Failed to Add User: " . mysqli_error($conn);
//             }
//         }

// // Trả về thông điệp kết quả
// echo json_encode($response);

// // Đóng kết nối
// mysqli_close($conn);

require 'connect.php';

    $tendangnhap = $_POST['Tendangnhap'];
    $sdt = $_POST['Sdt'];
    $matkhau = $_POST['Matkhau'];

    $query = "INSERT into `user_book` (`Id_user`, `Tendangnhap`, `Sdt`, `Matkhau`,`User_Role`, `Trangthai`) Values (null, '$tendangnhap', '$sdt', '$matkhau',1,1)"; 
    mysqli_query($conn, $query);

    echo json_encode(array('response'=>"Inserted Successfully"));

    mysqli_close($conn);
?>
