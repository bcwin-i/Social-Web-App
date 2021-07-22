<?php

include 'database_of.php';
session_start();

$id = $_SESSION['user_id'];

$query = "SELECT * FROM forum_notification_request WHERE user_id = ?;";
//$submit = mysqli_query($connect, $query); 
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $query))
{
	exit();
}
mysqli_stmt_prepare($st, $query);
mysqli_stmt_bind_param($st, "i", $id);
mysqli_stmt_execute($st);
$submit = mysqli_stmt_get_result($st);
$replies = mysqli_num_rows($submit);

if($replies < 1){
	
}
else
{
	$number = 0;
	while($row = mysqli_fetch_assoc($submit))
	{

		$output = $row['current'] - $row['previous']; 

		$number += $output;
	}

	if($number <= 0)
	{
		$number = '';	
	}
	echo $number;
}


?>