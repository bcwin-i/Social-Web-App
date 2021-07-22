<?php

include 'database_of.php';
session_start();

$sql = "UPDATE login_details SET is_type = ? WHERE login_details_id = ?;";

//$result = mysqli_query($connect, $update);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "si", $_POST['is_t'], $_SESSION['login_details_id']);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

?>