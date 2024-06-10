<?php
    require "connect.php";

    $query = "SELECT  `book`.`Tensach`as 'title', `book`.`Tacgia` as 'authors', `book`.`Anhbia` as 'image_url' from `book_category` join `book` on `book_category`.`Id_book` = `book`.`Id_book`
     Where `book_category`.`Id_category` = 1";

    $check = mysqli_query($conn, $query);
    $item  = array();
    while($res = mysqli_fetch_assoc($check)){
        $item[]  = $res;
    }

    echo json_encode($item);
?>