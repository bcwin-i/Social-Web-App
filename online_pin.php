<?php

include 'database_of.php';
include 'calls.php';
session_start();


echo online_pin($_SESSION['user_id'], $_POST['id']);

?>