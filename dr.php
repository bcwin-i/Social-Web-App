<?php

include 'database_of.php';
session_start();

$tid = $_POST['tid'];
$fid = $_SESSION['user_id'];

$sql = "SELECT * FROM message_request WHERE from_user_id = ? AND to_user_id = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "ii", $tid, $fid);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

while($row = mysqli_fetch_assoc($result)){
	$status = $row['status'];
	$id = $row['request_id'];

	$approve = "UPDATE message_request SET status = '1' WHERE request_id = '$id'";
	$result = mysqli_query($connect, $approve);
	echo $id;
}

?>