<?php

if (!empty($_GET['id'])) {
    require('class.php');

    $conn = new Includes\Database();
    $conn->get_single_confession($_GET['id']);
}
