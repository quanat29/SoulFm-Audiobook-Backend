<?php
    require "connect.php";

    $url = "data.json";
    $data = file_get_contents($url);
    $array = json_decode($data, true);

    $stmt = $conn->prepare("INSERT INTO `book` (`Id_book`, `Tensach`, `Tacgia`, `Mota`, `Traphi`, `Sosao`, `Sobinhluan`, `Anhbia`)
    VALUES (?, ?, ?, ?, 1, 5, 0, ?)");

    foreach($array as $item){
        $id_book =(int)$item['id'];
        $tensach = $item['title'];
        $tacgia = implode(", ", $item['authors']);
        $mota = $item['description'];
        $anhbia = $item['image_url'];

        
        $stmt->bind_param("issss", $id_book, $tensach, $tacgia, $mota, $anhbia);

    // Execute the statement
        if (!$stmt->execute()) {
            echo "Error inserting record: " . $stmt->error;
        }
    }
    echo "Insert successfully";
    $stmt->close();
    mysqli_close($conn);
?>