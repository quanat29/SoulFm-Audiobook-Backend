<?php
    require "connect.php";

    $query = "SELECT  * from `category`";

    $check = mysqli_query($conn, $query);
    $item  = array();
    while($res = mysqli_fetch_assoc($check)){
        $item[]  = $res;
    }

    echo json_encode($item);
?>