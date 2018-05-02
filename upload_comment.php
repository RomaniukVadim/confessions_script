<?php

if (!empty($_POST['comment']) && strlen($_POST['comment']) <= 1000 && strlen($_POST['comment']) >= 20) {
    require('class.php');
    
    $conn = new Includes\Database();
    $conn->insert_comment($_POST['comment'], $_SERVER['REMOTE_ADDR'], $_POST['conf_id']);
}
