<?php
require 'connect.php';

function fetchPage($page) {
    $url = "https://librivox.org/api/feed/audiobooks/?page=$page";

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($handle);
    curl_close($handle);

    return new SimpleXMLElement($response);
}

function fetchRSSAsync($id) {
    $url_rss = "https://librivox.org/rss/$id";
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url_rss);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);
    curl_close($handle);
    return $response;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$feed = fetchPage($page);
$items = array();

// Khởi tạo curl_multi để thực hiện các yêu cầu không đồng bộ
$multi_handle = curl_multi_init();
$multi_handles = array();

foreach ($feed->books->book as $book) {
    $id = (string)$book->id;
    $multi_handles[$id] = curl_init();
    curl_setopt($multi_handles[$id], CURLOPT_URL, "https://librivox.org/rss/$id");
    curl_setopt($multi_handles[$id], CURLOPT_RETURNTRANSFER, true);
    curl_multi_add_handle($multi_handle, $multi_handles[$id]);
}

// Thực thi các yêu cầu không đồng bộ
$running_handles = null;
do {
    curl_multi_exec($multi_handle, $running_handles);
} while ($running_handles);

// Xử lý từng phản hồi RSS
foreach ($feed->books->book as $book) {
    $id = (string)$book->id;
    $num_sections = (int)$book->num_sections;
    $rss_response = curl_multi_getcontent($multi_handles[$id]);
    curl_multi_remove_handle($multi_handle, $multi_handles[$id]);
    $feed_one = simplexml_load_string($rss_response);

    if ($feed_one !== false && isset($feed_one->channel)) {
        foreach ($feed_one->channel->item as $item) {
            $itunes = $item->children('http://www.itunes.com/dtds/podcast-1.0.dtd');

            $title = mysqli_real_escape_string($conn, (string)$item->title);
            $episode = mysqli_real_escape_string($conn, (string)$itunes->episode);
            $enclosure_url = mysqli_real_escape_string($conn, (string)$item->enclosure['url']);
            $duration = mysqli_real_escape_string($conn, (string)$itunes->duration);

            // Chuẩn bị câu lệnh SQL
            $sql = "INSERT INTO bookchapter (Tenchapter, Audiofile, Duration, Id_book, episode, num_sections) 
                    VALUES ('$title', '$enclosure_url', '$duration', '$id', '$episode',  $num_sections)";

            // Thực thi câu lệnh SQL
            if (mysqli_query($conn, $sql)) {
                echo "Dữ liệu đã được chèn thành công vào cơ sở dữ liệu.";
            } else {
                echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}

curl_multi_close($multi_handle);
mysqli_close($conn);
?>
