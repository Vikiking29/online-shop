<?php
session_start();

$URL = '';
if (array_key_exists("PATH_INFO", $_SERVER)) {
    $URL = $_SERVER["PATH_INFO"];
    $URL = str_replace("/", "", $URL);
} else if (array_key_exists("REQUEST_URI", $_SERVER)) {
    $URL = $_SERVER["REQUEST_URI"];
    $ext = pathinfo($URL, PATHINFO_EXTENSION);
    if (in_array($ext, ['css', 'jpg', 'png', 'xcf', 'mp3'])) {
        if ($ext === 'css') {
            header("Content-type: text/css", true);
        } else if ($ext === 'jpg') {
            header("Content-type: image/jpeg", true);
        }

        $content = file_get_contents(__DIR__ . $URL);
        echo $content;
        die;
    }
}

$url = $_SERVER["REQUEST_URI"];
$url = (substr($url, 1 , strpos($url, '?') - 1));

include "parts/head.php";

if($url == ""){
    include "pages/main_page.php";
}
elseif($url == "item"){
    include "pages/show_item.php";
}
elseif($url == "show-item"){
    include "pages/all_items.php";
}
elseif($url == "contac"){
    include "pages/contact.php";
}
elseif($url == "filter"){
    include "actions/filters.php";
}
elseif(file_exists(__DIR__ . "/pages/" . $url . ".php")){
    include __DIR__ . "/pages/" . $url . ".php";
}
?>