<?php

session_start();
include 'database_of.php';
$id = $_SESSION['user_id'];

$div = $_POST['id'];
list($topic_id, $cat_id) = explode("_", $div);

$sql = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ? AND user_id = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "iii", $cat_id, $topic_id, $id);
mysqli_stmt_execute($st);
$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

$query = "SELECT * FROM replies WHERE category_id = ? AND topic_id = ?;";
//$submit = mysqli_query($connect, $query); 
$stq = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stq, $query))
{
	exit();
}
mysqli_stmt_prepare($stq, $query);
mysqli_stmt_bind_param($stq, "ii", $cat_id, $topic_id);
mysqli_stmt_execute($stq);
$submit = mysqli_stmt_get_result($stq);
$replies = mysqli_num_rows($submit);

if($rowcount < 1)
{
	$insert = "INSERT INTO forum_notification_request (cat_id, topic_id, user_id, previous, current) VALUES ( ?, ?, ?, ?, ?);";
	//$done = mysqli_query($connect, $insert);
	$sti = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sti, $insert))
	{
		exit();
	}
	mysqli_stmt_prepare($sti, $insert);
	mysqli_stmt_bind_param($sti, "iiiii", $cat_id, $topic_id, $id, $replies, $replies);
	mysqli_stmt_execute($sti);

	if($sti){
		exit();
	}
}
else{
	$delete = "DELETE FROM forum_notification_request WHERE cat_id = '$cat_id' AND topic_id = '$topic_id' AND user_id = '$id'";
	//$done = mysqli_query($connect, $delete);
	$sti = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sti, $delete))
	{
		exit();
	}
	mysqli_stmt_prepare($sti, $delete);
	mysqli_stmt_bind_param($sti, "iii", $cat_id, $topic_id, $id);
	mysqli_stmt_execute($sti);

	if($sti){
		exit();
	}
}

?>