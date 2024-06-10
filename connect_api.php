<?php

    // $url = "https://librivox.org/api/feed/audiobooks/";

    // $handle = curl_init();
    // curl_setopt($handle, CURLOPT_URL, $url);
    // curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

    // $response = curl_exec($handle);

    // curl_close($handle);
    
    // $feed = new SimpleXMLElement($response);

    // // $url_rss = "https://librivox.org/rss/52";

    // // $feed_one = simplexml_load_file($url_rss);

    // // $image_url = (string)$feed_one->channel->children('http://www.itunes.com/dtds/podcast-1.0.dtd')->image->attributes()->href;



    // $books = array();
    // foreach($feed->books->book as $book){
    //     $id = (string)$book->id;
    //     $title = (string)$book->title;
    //     $description = (string)$book->description;
    //     $description = strip_tags($description);
    //     $description = str_replace(array("\r", "\n"), '', $description);
    //     $url_rss = "https://librivox.org/rss/$id";
    //     $feed_one = simplexml_load_file($url_rss);

    //     $image_url = (string)$feed_one->channel->children('http://www.itunes.com/dtds/podcast-1.0.dtd')->image->attributes()->href;
    //     // Xử lý trường hợp phần tử author chứa nhiều giá trị
    // $authors = array();
    // foreach ($book->authors->children() as $author) {
    //     $first_name = (string)$author->first_name;
    //     $last_name = (string)$author->last_name;
    //     $authors[] = "$first_name $last_name";

    // }
    
    //         $books[] = array(
    //             "id" => $id,
    //             "title" => $title,
    //             "description" => $description,
    //             "authors" => $authors,
    //             "image_url" => $image_url
    //         );
    //         }
    // $json = json_encode($books);

    // echo $json;


        $url = "https://librivox.org/api/feed/audiobooks/";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($handle);

        curl_close($handle);

        $feed = new SimpleXMLElement($response);

        $books = array();

        // được thiết kế để tải RSS feed của mỗi cuốn sách từ LibriVox một cách bất đồng bộ, 
        //tức là các yêu cầu được gửi đi mà không chờ đợi phản hồi
        function fetchRSSAsync($id) {
            $url_rss = "https://librivox.org/rss/$id";
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $url_rss);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handle);
            curl_close($handle);
            return $response;
        }

        // Asynchronously fetch RSS for all books
        $multi_handle = curl_multi_init();
        foreach($feed->books->book as $book){
            $id = (string)$book->id;
            $multi_handles[$id] = curl_init();
            curl_setopt($multi_handles[$id], CURLOPT_URL, "https://librivox.org/rss/$id");
            curl_setopt($multi_handles[$id], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($multi_handle, $multi_handles[$id]);
        }

        $running_handles = null;
        do {
            curl_multi_exec($multi_handle, $running_handles);
        } while ($running_handles);

        // Process each book's RSS
        foreach($feed->books->book as $book){
            $id = (string)$book->id;
            $description = (string)$book->description;
            $description = strip_tags($description);
            $description = str_replace(array("\r", "\n"), '', $description);
            $rss_response = curl_multi_getcontent($multi_handles[$id]);
            curl_multi_remove_handle($multi_handle, $multi_handles[$id]);
            $feed_one = simplexml_load_string($rss_response);
            if ($feed_one !== false && isset($feed_one->channel)) {
                $image_url = (string)$feed_one->channel->children('http://www.itunes.com/dtds/podcast-1.0.dtd')->image->attributes()->href;
            } else {
                $image_url = ''; // Hoặc bạn có thể đặt một URL mặc định cho hình ảnh
            }
            $authors = array();
            if (isset($book->authors)) {
                foreach ($book->authors->children() as $author) {
                    $first_name = (string)$author->first_name;
                    $last_name = (string)$author->last_name;
                    if ($first_name && $last_name) {
                        $authors[] = "$first_name $last_name";
                    } elseif ($first_name) {
                        $authors[] = $first_name;
                    } elseif ($last_name) {
                        $authors[] = $last_name;
                    }
                }
            }
            $books[] = array(
                "id" => $id,
                "title" => (string)$book->title,
                "description" => $description,
                "authors" => $authors,
                "image_url" => $image_url
            );
        }

        curl_multi_close($multi_handle);

        $json = json_encode($books);

        echo $json;
?>

