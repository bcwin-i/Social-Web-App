<?php

session_start();
include 'database_of.php';
include 'calls.php';

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


//........................................Active.............................................//
$num = "SELECT * FROM login_details WHERE user_id != ?;";
//$numr = mysqli_query($connect, $num);
$str = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($str, $num))
{
	exit();
}
mysqli_stmt_prepare($str, $num);
mysqli_stmt_bind_param($str, "i", $num);
mysqli_stmt_execute($str);

$numr = mysqli_stmt_get_result($str);


while($rowa = mysqli_fetch_assoc($numr)){
	date_default_timezone_set('Africa/Accra');
	$current_timestamp = strtotime(date('Y-m-d H:i:s') .'-10 seconds');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);

	$numa = "SELECT * FROM login_details WHERE user_id != ? AND last_activity >= ?;";
	//$numra = mysqli_query($connect, $numa);
	$sta = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sta, $numa))
	{
		exit();
	}
	mysqli_stmt_prepare($sta, $numa);
	mysqli_stmt_bind_param($sta, "is", $uid, $current_timestamp);
	mysqli_stmt_execute($sta);

	$numra = mysqli_stmt_get_result($sta);

	$rowcount = mysqli_num_rows($numra);

	if($rowcount > 1)
	{
		$amem = $rowcount.' Active members';
	}
	else if($rowcount == 1)
	{
		$amem = $rowcount.' Active member';
	}

	if($rowcount == 0)
	{
		$output = '';
		$output = '<table class="ml-space" style="margin: 5px; margin-top: 0px; margin-bottom: 0px;">
						<tr><td class="m_title">
							<span style="font-family: Calibri; color: #D4D4D4; font-size: 12px;">Active members pending</span>
						</td></tr>
					</table>';

		$output .= '<div class="loading" style="margin-left: 30px; margin-right: auto; width: 100%;"><img src="Double Ring-3.7s-199px.gif" height="170" width="170" style="margin-top: -15px; margin-bottom: 0px;"><span style="color: gray; display: block; font-size: 18px; margin-top: -93px; margin-left: 57px; font-family: Calibri;">waiting..</span></div>';

			echo $output;
			exit();
	}
	else{
		$output = '<span style="width: 100%; height: 7%; float: left; margin: 0px; padding-left: 7%; color: #D4D4D4; font-size: 12px; font-family: Calibri; ">'.$amem.'</span>
					<span style="width: 100%; float: left; height: 93%; overflow: hidden; overflow-y: scroll;"><table class="ml-space" style="margin: 5px; margin-top: 0px; margin-bottom: 0px; overflow-y: scroll;">';
	}
}

while($row = mysqli_fetch_assoc($result)){

	$ui = $row['name'];
	$uinq = $row['uid'];
	$id = $row['id'];

	date_default_timezone_set('Africa/Accra');
	$current_timestamp = strtotime(date('Y-m-d H:i:s') .'-10 seconds');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['id']);


	if($user_last_activity > $current_timestamp){
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

		$output .= '<tr>
						<td class="rule_m" width="100%">
							<span style="width:10%; float: left">'.$profile.'</span>
							<span style="width:80%; float: left; margin-left: 10px; position: relative; overflow: hidden; height: 21px;"><p class="mn" data-id="'.$id.'" data-name="'.$ui.'">'.$ui.'</p>
							</span>
							<span style="width:5%; margin-top: 1.5%; float: right;">
								<button type="button" class="send_message" data-touserid="'.$id.'" data-tousername="'.$ui.'">
								'.count_unseen_message($uid, $id).'
								</button>
							</span>
						</td>
					</tr>';
	}

}

$output .= '</table></span>';



echo $output;

?>