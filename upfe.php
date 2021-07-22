<?php
session_start();
include 'database_of.php';
date_default_timezone_set('Africa/Accra');
$current_timestamp = date('Y-m-d H:i:s');
$s2 = '2';
$id = $_SESSION['user_id'];

$event_name = mysqli_real_escape_string($connect, $_POST['event_name']);
$event_loc = mysqli_real_escape_string($connect, $_POST['event_loc']);
$event_desc = mysqli_real_escape_string($connect, $_POST['event_desc']);
$evesd = mysqli_real_escape_string($connect, $_POST['evesd']);
$evest = mysqli_real_escape_string($connect, $_POST['evest']);
$evecd = mysqli_real_escape_string($connect, $_POST['evecd']);
$evect = mysqli_real_escape_string($connect, $_POST['evect']);
$file_name = mysqli_real_escape_string($connect, $_POST['file_name']);

if(empty($event_name) || empty($event_loc) || empty($event_desc) || empty($evesd) || empty($evest) || empty($evecd) || empty($evect))
{
	echo "0";//Fill out all empty spaces!
	exit();
}

if(strlen($event_name) < 3)
{
	echo "3";//Event name too short!
	exit();
}

if(strlen($event_desc) < 10)
{
	echo "4";//Event description too short!
	exit();
}

$evest .= ':00';
$evect .= ':00';

$start = $evesd." ".$evest;
$close = $evecd." ".$evect;

if($evesd >= $evecd || $start < $current_timestamp)
{
	if($evesd == $evecd && $evest < $evecd)
	{
		
	}
	else{
		echo "1";//"Invalid date range!";
		exit();
	}
}

$sql = "SELECT * FROM events WHERE event_title = ? AND `end` > '".$current_timestamp."'";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{	
	echo "2";
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "s", $event_name);
mysqli_stmt_execute($st);
$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

if($rowcount > 0)
{
	echo "2";//"Event name already exist!";
	exit();
}

if(!empty($file_name))
{
	$file_name = '1';
}
else{
	$file_name = '0';
}

$sqli = "INSERT INTO events (user_id, event_title, location, event_desc, file, start, `end`) VALUES ( ?, ?, ?, ?, ?, ?, ?);";
//$insert = mysqli_query($connect, $sql);

$sti = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($sti, $sqli))
{
	echo "None2";
	exit();
}
mysqli_stmt_prepare($sti, $sqli);
mysqli_stmt_bind_param($sti, "isssiss", $id, $event_name, $event_loc, $event_desc, $file_name, $start, $close);
mysqli_stmt_execute($sti);

$sqls = "SELECT * FROM events WHERE event_title = ? AND event_desc = ? AND user_id = ? LIMIT 1";
//$results = mysqli_query($connect, $sqls);

$sts = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($sts, $sqls))
{
	exit();
}
mysqli_stmt_prepare($sts, $sqls);
mysqli_stmt_bind_param($sts, "ssi", $event_name, $event_desc, $id);
mysqli_stmt_execute($sts);

$results = mysqli_stmt_get_result($sts);

while($row = mysqli_fetch_assoc($results))
{
	$inserts = "INSERT INTO forum_notification_request (cat_id, topic_id, user_id) VALUES ( ?, ?, ?);";
	//$done = mysqli_query($connect, $inserts);

	$stis = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stis, $inserts))
	{
		exit();
	}
	mysqli_stmt_prepare($stis, $inserts);
	mysqli_stmt_bind_param($stis, "iii", $s2, $row['id'], $id);
	mysqli_stmt_execute($stis);
}
?>