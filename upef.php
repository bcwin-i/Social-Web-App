<?php

session_start();
$id = $_SESSION['user_id'];
date_default_timezone_set('Africa/Accra');

$event_name = $_POST['even'];
$event_desc = $_POST['eved'];
$event_sd = $_POST['evesd'];
$event_st = $_POST['evest'];
$event_cd = $_POST['evecd'];
$event_ct = $_POST['evect'];
$file_status = $_POST['aevep'];
$current_timestamp = date('Y-m-d H:i:s');

$event_st .= ':00';
$event_ct .= ':00';

if($file_status == 0)
{
	//Waiting
}
else
{
	//Waiting
}

$start = $event_sd." ".$event_st;
$close = $event_cd." ".$event_ct;


if($start <= $close || $start < $current_timestamp)
{
	echo "Invalid date range!";
	exit();
}
else
{
	echo $start." / ".$close;
}


?>