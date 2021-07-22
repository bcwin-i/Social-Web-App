<?php
session_start();
include 'database_of.php';
include 'calls.php';

$search = "%{$_POST['name']}%";
$name = mysqli_real_escape_string($connect, $search);
$user_name = $_SESSION['user_name'];
             

$sql = "SELECT * FROM log WHERE uid LIKE ? AND name != ?;";
//$result = mysqli_query($connect, $sql);
			
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "ss", $name, $user_name);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

$output = '<table class="ml-space" style="margin: 5px; margin-top: 0px; margin-bottom: 0px;">
				<tr><td class="m_title"><span style="color: gray; font-family: Calibri; font-weight: bold;">Members</td></tr>';

if(mysqli_num_rows($result) < 1)
{
	$output = '<table class="ml-space" style="margin: 5px; margin-top: 0px; margin-bottom: 0px;">
				<tr><td class="m_title"><span style="color: gray; font-family: Calibri; font-weight: bold;">Members</td></tr>
				<tr><td class="m_title"><span style="color: gray; font-family: Calibri; text-align: center; width:100% ">Unknown member!</span></td></tr></table>';
	echo $output;
	exit();
}

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
				<span style="width:80%; float: left; margin-left: 10px; position: relative; overflow: hidden; height: 21px;"><p class="mn">'.$ui.'</p>
				<span style="width:10%; float: right;">
				<button type="button" class="send_message" data-touserid="'.$id.'" data-tousername="'.$ui.'">
				'.$online.'</button></span>
				</td></tr>';
}


$output .='</table>';

echo $output;
?>