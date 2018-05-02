<?php

if ($_POST['action']==="voteUp" || $_POST['action']==="voteDown") {
    require('class.php');
    $conn = new Includes\Database();

    if (!empty($_POST['comm_id']) && !empty($_POST['conf_id'])) {
        $comm_id = $_POST['comm_id'];
        $conf_id = $_POST['conf_id'];

        if (isset($_COOKIE['comm_id'.$comm_id]) && $_COOKIE['comm_id'.$comm_id] == $comm_id) {
            header('Content-Type: application/json');
            $arr = array("status"=>'already_voted');
            echo json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } elseif ($_POST['action']==="voteUp") {
            $conn->comm_voteUp($conf_id, $comm_id);
        } elseif ($_POST['action']==="voteDown") {
            $conn->comm_voteDown($conf_id, $comm_id);
        }
    }
}
