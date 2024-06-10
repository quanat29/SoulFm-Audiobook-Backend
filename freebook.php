<?php
    require "connect.php";

    $query = "SELECT  `Tensach`as 'title', `Tacgia` as 'authors', `Anhbia` as 'image_url' from `book` Where `Traphi` = 2";

    $check = mysqli_query($conn, $query);
    $item  = array();
    while($res = mysqli_fetch_assoc($check)){
        $item[]  = $res;
    }

    echo json_encode($item);
?>