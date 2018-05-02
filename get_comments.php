<?php

if (!empty($_GET['conf_id'])) {
    require('class.php');

    $conn = new Includes\Database();
    $conn->get_comments($_GET['conf_id']);
}
