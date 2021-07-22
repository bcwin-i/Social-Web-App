<?php
session_start();
include 'database_of.php';

$name = mysqli_real_escape_string($connect, $_POST['name']);
$email = mysqli_real_escape_string($connect, $_POST['email']);
$mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
$reason = $_POST['desc'];

$desc = mysqli_real_escape_string($connect, nl2br($reason));

if(empty($name) || empty($email) || empty($mobile) || empty($desc))
{
	echo "Fill out all forms!";
}
else
{
	$sql = "INSERT INTO help_message (name, email, mobile, description)
		VALUES ( ?, ?, ?, ?);";
	//$result = mysqli_query($connect, $sql);

	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "ssss", $name, $email, $mobile, $desc);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);

	if($result)
	{
		echo "<img class='help_icon' src='iconfinder_correct_3855625.png' height='70' width='70' style='opacity: 0.5; padding-top: 5px;'><div style='color: #0A5223; opacity: 0.5; font-size: 12.5px;'>Message delivered, patiently wait for the response of the support team..</div>";
	}
}


?>