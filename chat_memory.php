<?php

include 'database_of.php';
include 'calls.php';
session_start();

$from_user_id = $_SESSION['user_id'];
$to_user_id = $_POST['id'];

echo fetch_user_chat_history($_SESSION['user_id'], $_POST['id']);

?>