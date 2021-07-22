<?php
include 'database_of.php';
session_start();
$id = $_SESSION['user_id'];
$event_name = $_POST['ev'];

$dir = 'Files/Forum_uploads/Events/'.$id.$event_name.'*';
$ddir = glob($dir);
if($ddir)
{
	unlink($ddir[0]);
	echo "success";
}

$sql = $pd = "DELETE FROM event_poster WHERE event_name = ? AND user_id = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "si", $event_name, $id);
mysqli_stmt_execute($st);

?>