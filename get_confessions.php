<?php
 
if (isset($_POST['value'])) {
    require('class.php');

    $conn = new Includes\Database();
    $conn->get_confessions($_POST['value']);
}
