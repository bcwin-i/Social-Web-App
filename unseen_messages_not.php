<?php

include 'database_of.php';
session_start();

$uid = $_SESSION['user_id'];
$status1 = '1';
$status = '0';

$sql = "SELECT * FROM chat_message WHERE to_user_id = ? AND status = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "ii", $uid, $status1);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

$check = "SELECT * FROM message_request WHERE to_user_id = ? AND status = ?;";
//$query1 = mysqli_query($connect, $check);
$stq = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stq, $check))
{
	exit();
}
mysqli_stmt_prepare($stq, $check);
mysqli_stmt_bind_param($stq, "ii", $uid, $status);
mysqli_stmt_execute($stq);

$query1 = mysqli_stmt_get_result($stq);
$queryc = mysqli_num_rows($query1);


if($rowcount < 1 && $queryc < 1)
{

}
else
{

	$output = $rowcount + $queryc;
	echo $output;
}

?>