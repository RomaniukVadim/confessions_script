<?php

if ($_POST['action']==="voteUp" || $_POST['action']==="voteDown") {
    require('class.php');
    $conn = new Includes\Database();

    if (!empty($_POST['conf_id'])) {
        $my_id = $_POST['conf_id'];

        if (isset($_COOKIE[$my_id]) && $_COOKIE[$my_id] === 'true') {
            header('Content-Type: application/json');
            $arr = array("status"=>'already_voted');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } elseif ($_POST['action']==="voteUp") {
            $conn->voteUp($my_id);
        } elseif ($_POST['action']==="voteDown") {
            $conn->voteDown($my_id);
        }
    }
}
