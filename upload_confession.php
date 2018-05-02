<?php

if (!empty($_POST['confession']) && strlen($_POST['confession']) <= 1000 && strlen($_POST['confession']) >= 20) {
    require('class.php');
    $conn = new Includes\Database();

    $limit_check = $conn->limit_check($_SERVER['REMOTE_ADDR']);

    if (isset($_COOKIE['perday']) && $_COOKIE['perday'] == 'true' || $limit_check >= '1') {
        header('Content-Type: application/json');
        $arr = array("status"=>'limit_reached');
        echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        $conn->insert_confession($_POST['confession'], $_SERVER['REMOTE_ADDR']);
    }
}
