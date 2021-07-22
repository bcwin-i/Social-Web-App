<?php

include 'database_of.php';
include 'calls.php';

session_start();

$uid = $_SESSION['user_id'];

$output = '';

$sql = "SELECT * FROM log WHERE id != ? ORDER BY name ASC";
//$result = mysqli_query($connect, $sql);

$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "i", $uid);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

$output = '<span id="am" style="width: 100%; height: 6%; font-size: 14px; float: left; margin: 0px; padding-left: 7%; padding-bottom:-4%; padding-top: 2%; color: gray; font-family: Calibri;">Members</span>
					<span style="width: 100%; float: left; height: 94%; overflow: hidden; overflow-y: scroll;">
			<table class="ml-space" style="margin: 5px; margin-top: 0px; margin-bottom: 0px; ">';
$i = 1;
while($row = mysqli_fetch_assoc($result)){
	$ui = $row['name'];
	$uinq = $row['uid'];
	$id = $row['id'];

	$status = '';
	date_default_timezone_set('Africa/Accra');
	$current_timestamp = strtotime(date('Y-m-d H:i:s') .'-10 seconds');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['id']);

	if($user_last_activity > $current_timestamp)
	{
		$online = '';
		$online = '<img class="chat_o" src="chat-o.png" title="user active" height = 7 width = 7>';
	}
	
	else
	{
		$online = '';
	}

	if($row['status'] == 0){
		$profile = '<img class="pic" src="Files/Profile/profile'.$id.'.jpg" height = 30 width = 30>';
	}

	if($row['status'] == 1){
		$profile = '<img class="pic" src="user.PNG" height = 31 width = 31>';
	}

	if(empty($uinq)){
		$ui;
	}
	else{
		$ui = $uinq;
	}
	
	$output .= '<tr><td class="rule_m" width="100%">
				<span style="width:10%; float: left">'.$profile.'</span>
				<span style="width:80%; float: left; margin-left: 10px; position: relative; overflow: hidden; height: 21px;"><p class="mn" data-id="'.$id.'" data-name="'.$ui.'">'.$ui.'</p>
				<span style="width:10%; float: right;">
				<button type="button" class="send_message" data-touserid="'.$id.'" data-tousername="'.$ui.'">
				'.$online.'</button></span>
				</td></tr>';
}


$output .='</table></span>';

echo $output;
?>