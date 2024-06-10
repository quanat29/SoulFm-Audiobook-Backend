<?php
    require "connect.php";

    $query = "SELECT `trendybook`.`Id_trendybook` as id, `book`.`Tensach`as 'title', `book`.`Tacgia` as 'authors', `book`.`Anhbia` as 'image_url' from `trendybook` join `book` on `trendybook`.`Id_book` = `book`.`Id_book`";

    $check = mysqli_query($conn, $query);
    $item  = array();
    while($res = mysqli_fetch_assoc($check)){
        $item[]  = $res;
    }

    echo json_encode($item);
?>