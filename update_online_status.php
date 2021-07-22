<?php

include 'database_of.php';
session_start();

$uos = $_SESSION['login_details_id'];

$sql = "UPDATE login_details SET last_activity = NOW() 
	    WHERE login_details_id = ?;";

//$result = mysqli_query($connect, $sql);

$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "i", $uos);
mysqli_stmt_execute($st);

//$result = mysqli_stmt_get_result($st);

?>