<?php

include 'database_of.php';
include 'calls.php';

session_start();

$uid = $_SESSION['user_id'];
$from_user_id = $_SESSION['user_id'];
$s1 = '1';
$s0 = '0';

$sql = "SELECT * FROM chat_message WHERE to_user_id = ? AND status = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "ii", $uid, $s1);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

$output = '';
$output .= '<img src="dropped_message.png" style="position: absolute; top: 0px; right: 0px; opacity: 0.2; margin: 2px;" height=12 width=12>';
$output1 = '';

if($rowcount < 1)
{
	
}
else{

	$output .= '<table id="mesf" class="ml-space" style="margin: 5px; margin-top: 0px; margin-bottom: 0px;">
					<tr><td class="m_title"><span style="color: gray; font-family: Calibri; font-size: 13px;">Messages</span></td></tr>';

	$usm = "SELECT * FROM log WHERE id != ?;";
	//$query = mysqli_query($connect, $usm);
	$sm = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sm, $usm))
	{
		exit();
	}
	mysqli_stmt_prepare($sm, $usm);
	mysqli_stmt_bind_param($sm, "i", $uid);
	mysqli_stmt_execute($sm);

	$query = mysqli_stmt_get_result($sm);

	while($row = mysqli_fetch_assoc($query)){

		$id = $row['id'];

		if(adding($id, $uid) == 0)
		{

		}
		else{

			$ui = $row['name'];
			$uinq = $row['uid'];

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


			$output .= '<tr>
							<td class="rule_m" width="100%">
								<span style="width:10%; float: left">'.$profile.'</span>
								<span style="width:76%; float: left; margin-left: 10px; position: relative; overflow: hidden; height: 21px;"><p class="mn" data-id="'.$id.'" data-name="'.$ui.'">'.$ui.'</p>
								</span>
								<span style="width:5%; margin-top: 3%; float: right; font-family: monospace; color: gray; font-weight: bold; font-size:12px;">
									'.count_num_unseen_message($uid, $id).' 
								</span>
							</td>
						</tr>';
		}

	}
	$output .='</table>';
}

function adding($id, $uid){

	$s1 = '1';
	include 'database_of.php';
	$s1 = '1';
	$sql = "SELECT * FROM chat_message WHERE to_user_id = ? AND from_user_id = ? AND status = ?;";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "iii", $uid, $id, $s1);
	mysqli_stmt_execute($st);
	$result = mysqli_stmt_get_result($st);

	$rowcount = mysqli_num_rows($result);

	return $rowcount;

}

$check = "SELECT * FROM message_request WHERE to_user_id = ? AND status = ?;";
//$query1 = mysqli_query($connect, $check);
$ct = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($ct, $check))
{
	exit();
}
mysqli_stmt_prepare($ct, $check);
mysqli_stmt_bind_param($ct, "ii", $from_user_id, $s0);
mysqli_stmt_execute($ct);

$query1 = mysqli_stmt_get_result($ct);

$queryc = mysqli_num_rows($query1);

if($queryc < 1){

	
}
else{
	$usm = "SELECT * FROM log WHERE id != ?;";
	//$query2 = mysqli_query($connect, $usm);
	$sum = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sum, $usm))
	{
		exit();
	}
	mysqli_stmt_prepare($sum, $usm);
	mysqli_stmt_bind_param($sum, "i", $uid);
	mysqli_stmt_execute($sum);

	$query2 = mysqli_stmt_get_result($sum);

	$output1 .= '<table id="unm" class="ml-space" style="margin: 5px; margin-top: 0px; margin-bottom: 0px;">
					<tr><td class="m_title"><span style="color: gray; font-family: Calibri; font-size: 13px;">Messages request</span></td></tr>';

	while($row2 = mysqli_fetch_assoc($query2)){
		$fuid = $row2['id'];

		if(look($fuid, $uid) < 1){

		}
		else
		{
			$ui = $row2['name'];
			$uinq = $row2['uid'];


			if($row2['status'] == 0){
				$profile = '<img class="pic" src="Files/Profile/profile'.$fuid.'.jpg" height = 30 width = 30>';
			}

			if($row2['status'] == 1){
				$profile = '<img class="pic" src="user.PNG" height = 31 width = 31>';
			}

			if(empty($uinq)){
				$ui;
			}
			else{
				$ui = $uinq;
			}
			
			$output1 .= '<tr><td class="rule_m" width="100%">
						<span style="width:10%; float: left">'.$profile.'</span>
						<span style="width:70%; float: left; margin-left: 10px; position: relative; overflow: hidden; height: 21px;"><p class="mn" data-id="'.$fuid.'" data-name="'.$ui.'">'.$ui.'</p></span>
						<span style="width:20%; float: right; margin:0px; background-color: gray;">
						<img class="approve" id="'.$fuid.'" src="approve.png" title="approve request" height= 8 width = 8 />
						<img class="decline" id="'.$fuid.'" src="decline.png" title="decline request" height= 8 width = 8 />
						</span>
						</td></tr>';
		}
	}
	$output1 .='</table>';
}

function look($fuid, $uid){

	include 'database_of.php';
	$sql = "SELECT * FROM message_request WHERE to_user_id = ? AND from_user_id = ?  AND status = ?;";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);
	$s0 = '0';

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "iii", $uid, $fuid, $s0);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);
	$rowcount = mysqli_num_rows($result);

	return $rowcount;
}

echo $output;
echo $output1;

if($rowcount < 1 && $queryc < 1)
{
	echo $output2 = '<table id="unm" class="ml-space" style="margin: 5px; margin-bottom: 0px;">
					<tr><td class="m_title"><span style="color: gray; font-family: Calibri;">empty!</td></tr></table>';
}

?>