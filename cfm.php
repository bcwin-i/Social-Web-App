<?php

include 'database_of.php';
session_start();

$to_user_id = $_POST['id'];
$from_user_id = $_SESSION['user_id'];
$s1 = '1';

$sql = "SELECT * FROM chat_message WHERE from_user_id = ? AND to_user_id = ? AND fstat = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "iii", $from_user_id, $to_user_id, $s1);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

$rowcount = mysqli_num_rows($result);

		
if($rowcount > 0)
{
	echo $rowcount;
}	

else
{
	echo "0";	
}
?>