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

	$approve = "UPDATE message_request SET status = '2' WHERE request_id = '$id'";
	$result = mysqli_query($connect, $approve);
	$output = $id;
}

$update = "SELECT * FROM pending_message WHERE to_user_id = ? AND from_user_id = ?;";
//$qu = mysqli_query($connect, $update);
$stu = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stu, $update))
{
	exit();
}
mysqli_stmt_prepare($stu, $update);
mysqli_stmt_bind_param($stu, "ii", $fid, $tid);
mysqli_stmt_execute($stu);

$qu = mysqli_stmt_get_result($stu);

$rowcount = mysqli_num_rows($qu);

if($rowcount > 0){
	while($row = mysqli_fetch_assoc($qu)){
		$pid = $row['pending_message_id'];
		$fud = $row['from_user_id'];
		$tud = $row['to_user_id'];
		$message = $row['message'];
		$date = $row['date'];

		$mi = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, `timestamp`,status)
				VALUES ('$tud','$fud', '$message', '$date', '1')";
		$miq = mysqli_query($connect, $mi);

		$pd = "DELETE FROM pending_message WHERE pending_message_id = '$pid'";
		$miq = mysqli_query($connect, $pd);					
	}
}
?>