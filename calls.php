<?php
date_default_timezone_set('Africa/Accra');

function fetch_user_chat_history($from_user_id, $to_user_id){

	include 'database_of.php';
	$s0 = '0';
	$s1 = '1';
	$output = '';

	$sql = "SELECT * FROM chat_message WHERE from_user_id = ? AND to_user_id = ? OR from_user_id = ? AND to_user_id = ? ORDER BY timestamp ASC";
	//$result = mysqli_query($connect, $sql);

	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);

	$rowcount = mysqli_num_rows($result);

	if($rowcount < 1)
	{
		$output = '<p style="text-align: center; font-size: 13px; margin:40px 40px; border: 1px solid #F2CECE; padding: 2px; background-color: #F2CECE; font-family: Calibri; color: white; border-radius: 10px; font-weight: bolder;">No chat history with user !</p>';
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$sign = "<img src='minimize-icon-28.png' style='margin: 1px; vertical-align: bottom;' height =14 width = 14>";
		
			$row['chat_message'] = str_replace('\n', "\n", $row['chat_message']);
			$row['chat_message'] = str_replace("\'", "'", $row['chat_message']);

			$user_name = '';
			if($row["from_user_id"] == $from_user_id)
			{
				if($row["status"] == '2')
				{
					$user_name = '<span style="width: 80%; float: right; margin-bottom: 10px;">
											<span style=" float: right; border-radius: 14px 0px 0px 14px; background-color: #EFF0BD; font-size: 11px; color: #707070; font-family: monospace;">
												<span style="margin: 5px 10px; margin-left: 0px;">'.$sign.' deleted message</span>
											</span>
										</span>';
				}
				else
				{
					$user_name = '<span style="width: 80%; float: right; margin-bottom: 10px; overflow:hidden; position: relative;">
										<span  id= '.$row["chat_message_id"].' class="del" style="position: absolute; right:0px; top:0px; width: 10px; height: 10px;">
										</span>
										<span style="float: right; border-radius: 14px 0px 0px 14px; background-color: #F0F0F0; overflow:hidden; max-width: 100%;">
											<span style="float:right; margin: 5px 10px; font-size: 13px; color: #525252; font-family: monospace;" title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
											</span>
										</span>
									</span>';
					if(!empty($row['file_name']))
					{
						$user_name = '<span style="width: 80%; float: right; margin-bottom: 10px; overflow:hidden; position: relative;">
											<span  id= '.$row["chat_message_id"].' class="del" style="position: absolute; right:0px; top:0px; width: 10px; height: 10px;">
											</span>
											<span style="float: right; border-radius: 14px 0px 0px 14px; background-color: none; overflow:hidden; max-width: 100%;">
												<span style="float:right; margin: 5px 5px; font-size: 13px; color: white; font-family: monospace;" title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
												</span>
											</span>
										</span>';
					}
				}
			}
			else
			{
				if($row["status"] == '2')
				{
					$user_name = '<span style="width: 80%; float: left; margin-bottom: 10px;">
											<span style=" float: left; border-radius: 0px 14px 14px 0px; background-color: #EFF0BD; font-size: 11px; color: #707070; font-family: monospace;">
													<span style="margin: 5px 10px; margin-right: 0px;">deleted message '.$sign.'</span>
												</span>
											</span>';
				}
				else
				{
					$user_name = '<span style="width: 80%; float: left; margin-bottom: 10px; overflow:hidden;">
											<span style="float: left; border-radius: 0px 14px 14px 0px; background-color: white; border-top: 1px solid #F0F0F0; border-bottom: 1px solid #F0F0F0; border-right: 1px solid #F0F0F0; overflow:hidden; max-width: 100%;">
												<span style="float:left; margin: 5px 10px; font-size: 13px; color: #707070; font-family: monospace;" title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
												</span>
											</span>
										</span>';
					if(!empty($row['file_name']))
					{
						$user_name = '<span style="width: 80%; float: left; margin-bottom: 10px; overflow:hidden; position: relative;">
											<span  id= '.$row["chat_message_id"].' class="del" style="position: absolute; right:0px; top:0px; width: 10px; height: 10px;">
											</span>
											<span style="float: left; border-radius: 14px 0px 0px 14px; background-color: none; overflow:hidden; max-width: 100%;">
												<span style="float:right; margin: 5px 5px; font-size: 13px; color: white; font-family: monospace;" title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
												</span>
											</span>
										</span>';
					}
				}
			}
			$output .= '<p> '.$user_name.' </p>';
		}
	}

	$output .= '<span id="mestus_'.$to_user_id.'">'.message_status($from_user_id, $to_user_id).'</span>';


	$check = "SELECT * FROM message_request WHERE from_user_id = ? AND to_user_id = ? OR from_user_id = ? AND to_user_id = ?;";
		//$query = mysqli_query($connect, $check);

	$stc = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stc, $check))
	{
		exit();
	}
	mysqli_stmt_prepare($stc, $check);
	mysqli_stmt_bind_param($stc, "iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
	mysqli_stmt_execute($stc);

	$query = mysqli_stmt_get_result($stc);

	while($rowq = mysqli_fetch_assoc($query))
	{
		if($rowq['status'] != 2)
		{
			if($rowq['from_user_id'] == $from_user_id)
			{
				$output .= '<p style="text-align: center; font-size: 12px; margin: 10px 10px; margin-left: 3px; opacity: 0.5;  float:right; padding: 2px; background-color: none; monospace; color: gray; font-style: italic;">request pending...</p>';
			}
			else
			{
				$output .= '<p style="text-align: center; font-size: 12px; margin: 10px 10px; margin-left: 3px; opacity: 0.5; float:left; padding: 2px; background-color: none; monospace; color: gray; font-style: italic;">approval pending...</p>';
			}
		}
		else
		{
			$status = "UPDATE chat_message SET status = ? WHERE from_user_id = ?
				   AND to_user_id = ? AND status = ?;";
				//$results = mysqli_query($connect, $status);

			$stu = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($stu, $status))
			{
				exit();
			}
			mysqli_stmt_prepare($stu, $status);
			mysqli_stmt_bind_param($stu, "iiii", $s0, $to_user_id, $from_user_id, $s1);
			mysqli_stmt_execute($stu);

			$results = mysqli_stmt_get_result($stu);
		}
	}
		

		return $output;
}


function fetch_user_chat_history_f($from_user_id, $to_user_id){

	include 'database_of.php';
		$output = '';
		$sql = "SELECT * FROM chat_message WHERE from_user_id = ? AND to_user_id = ? OR from_user_id = ? AND to_user_id = ? ORDER BY timestamp ASC";
		//$result = mysqli_query($connect, $sql);

		$st = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($st, $sql))
		{
			exit();
		}
		mysqli_stmt_prepare($st, $sql);
		mysqli_stmt_bind_param($st, "iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
		mysqli_stmt_execute($st);

		$result = mysqli_stmt_get_result($st);

		$rowcount = mysqli_num_rows($result);

		if($rowcount < 1)
		{
			$output = '<p style="text-align: center; font-size: 13px; margin:40px 40px; border: 1px solid #F2CECE; padding: 2px; background-color: #F2CECE; font-family: Calibri; color: white; border-radius: 10px; font-weight: bolder;">No chat history with user !</p>';
		}
		else{
		while($row = mysqli_fetch_assoc($result))
		{
			$sign = "<img src='minimize-icon-28.png' style='margin: 1px; vertical-align: bottom;' height =14 width = 14>";
			$user_name = '';

			$row['chat_message'] = str_replace('\n', "\n", $row['chat_message']);
			$row['chat_message'] = str_replace("\'", "'", $row['chat_message']);

			if($row["from_user_id"] == $from_user_id)
			{
				if($row["status"] == '2')
				{
					$user_name = '<span style="width: 80%; float: right; margin-bottom: 10px;">
										<span style=" float: right; border-radius: 14px 0px 0px 14px; background-color: #EFF0BD; font-size: 11px; color: #707070; font-family: monospace;">
											<span style="margin: 5px 10px; margin-left: 0px;">'.$sign.' deleted message</span>
										</span>
									</span>';
				}
				else
				{
					$user_name = '<span style="width: 80%; float: right; margin-bottom: 10px; overflow:hidden; position: relative;">
										<span  id= '.$row["chat_message_id"].' class="del" style="position: absolute; right:0px; top:0px; width: 10px; height: 10px;">
										</span>
										<span style="float: right; border-radius: 14px 0px 0px 14px; background-color: #49A0EC; overflow:hidden; max-width: 100%;">
											<span style="float:right; margin: 5px 10px; font-size: 13px; color: white; font-family: monospace;" title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
											</span>
										</span>
									</span>';

					if(!empty($row['file_name']))
					{
						$user_name = '<span style="width: 80%; float: right; margin-bottom: 10px; overflow:hidden; position: relative;">
											<span  id= '.$row["chat_message_id"].' class="del" style="position: absolute; right:0px; top:0px; width: 10px; height: 10px;">
											</span>
											<span style="float: right; border-radius: 14px 0px 0px 14px; background-color: none; overflow:hidden; max-width: 100%;">
												<span style="float:right; margin: 5px 5px; font-size: 13px; color: white; font-family: monospace;" title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
												</span>
											</span>
										</span>';
					}
				}
			}
			else
			{
				if($row["status"] == '2')
				{
					$user_name = '<span style="width: 80%; float: left; margin-bottom: 10px;">
										<span style=" float: left; border-radius: 0px 14px 14px 0px; background-color: #EFF0BD; font-size: 11px; color: #707070; font-family: monospace;">
											<span style="margin: 5px 10px; margin-right: 0px;">deleted message '.$sign.'</span>
										</span>
									</span>';
				}
				else
				{
					$user_name = '<span style="width: 80%; float: left; margin-bottom: 10px; overflow:hidden;">
									<span style="float: left; border-radius: 0px 14px 14px 0px; background-color: white; overflow:hidden; max-width: 100%;">
										<span style="float:left; margin: 5px 10px; font-size: 13px; color: #707070; font-family: monospace; " title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
										</span>
									</span>
								</span>';

					if(!empty($row['file_name']))
					{
						$user_name = '<span style="width: 80%; float: left; margin-bottom: 10px; overflow:hidden; position: relative;">
											<span  id= '.$row["chat_message_id"].' class="del" style="position: absolute; right:0px; top:0px; width: 10px; height: 10px;">
											</span>
											<span style="float: left; border-radius: 14px 0px 0px 14px; background-color: none; overflow:hidden; max-width: 100%;">
												<span style="float:right; margin: 5px 5px; font-size: 13px; color: white; font-family: monospace;" title="'.ut($row['timestamp']).'">'.nl2br($row["chat_message"]).'
												</span>
											</span>
										</span>';
					}
				}
			}

			$output .= '<p> '.$user_name.' </p>';
		}

	} 

	$output .= '<span id="mestus_'.$to_user_id.'">'.message_status($from_user_id, $to_user_id).'</span>';
		$check = "SELECT * FROM message_request WHERE from_user_id = ? AND to_user_id = ? OR from_user_id = ? AND to_user_id = ?;";
		//$query = mysqli_query($connect, $check);

		$stc = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($stc, $check))
		{
			exit();
		}
		mysqli_stmt_prepare($stc, $check);
		mysqli_stmt_bind_param($stc, "iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
		mysqli_stmt_execute($stc);

		$query = mysqli_stmt_get_result($stc);

		while($rowq = mysqli_fetch_assoc($query)){
			if($rowq['status'] != 2){
				if($rowq['from_user_id'] == $from_user_id){
					$output .= '<p style="text-align: center; font-size: 11px; margin: 10px 10px; float:right;  padding: 2px; background-color: none; font-family: Calibri; color: #729CE0; font-weight: bolder; font-style: italic; opacity: 0.5;">request pending...</p>';
				}
				else{
					$output .= '<p style="text-align: center; font-size: 11px; margin: 10px 10px; margin-left: 3px; opacity: 0.5; font-weight: bold; float:left; padding: 2px; background-color: none; font-family: Calibri; color: #729CE0; font-style: italic;">approval pending...</p>';
				}
			}
			else{

			}
		}

		$statusf = "UPDATE chat_message SET fstat = ? WHERE from_user_id = ? AND to_user_id = ?;";
		//$resultsf = mysqli_query($connect, $statusf); 
		//$results = mysqli_query($connect, $status);

		$stu = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($stu, $statusf))
		{
			exit();
		}
		mysqli_stmt_prepare($stu, $statusf);
		mysqli_stmt_bind_param($stu, "iii", $s0, $from_user_id, $to_user_id);
		mysqli_stmt_execute($stu);

		$resultsf = mysqli_stmt_get_result($stu);

		return $output;
}

function fetch_user_last_activity($user_id)
{
	include 'database_of.php';

	$sql = "SELECT * FROM login_details WHERE user_id = '$user_id'";
	$result = mysqli_query($connect, $sql);

	if($row = mysqli_fetch_assoc($result)){
		return $row['last_activity'];
	}
}

function count_unseen_message($from_user_id, $to_user_id)
{
	include 'database_of.php';

	$sqlt = "SELECT is_type FROM login_details WHERE user_id = ?;";
	//$result = mysqli_query($connect, $sql);
	$stt = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stt, $sqlt))
	{
		exit();
	}
	mysqli_stmt_prepare($stt, $sqlt);
	mysqli_stmt_bind_param($stt, "i", $to_user_id);
	mysqli_stmt_execute($stt);

	$resultt = mysqli_stmt_get_result($stt);

	$output = '';

	while($row = mysqli_fetch_assoc($resultt))
	{
		if($row['is_type'] == 'yes')
		{
			$output = '<img class="chat_o" src="typing.gif" title="typing" height = 7 width = 7>';

			return $output;
			exit();
		}
	}

	$online = '';
	$online_msg = '';
	$online = '<img class="chat_o" src="chat-o.png" title="user active" height = 7 width = 7>';
	$online_msg = '<img class="chat_o" src="chat-o-msg.png" title="user active" height = 7 width = 7>';

	$sql = "SELECT * FROM chat_message WHERE from_user_id = '$to_user_id' AND to_user_id = '$from_user_id' AND status = '1'";
	$result = mysqli_query($connect, $sql);
	$rowcount = mysqli_num_rows($result);

	$output = '';
	if($rowcount > 0)
	{
		$output = $online_msg;
	}
	else
	{
		$output = $online;
	}

	return $output;
}

function count_num_unseen_message($from_user_id, $to_user_id)
{
	include 'database_of.php';

	$sql = "SELECT * FROM chat_message WHERE from_user_id = '$to_user_id' AND to_user_id = '$from_user_id' AND status = '1'";
	$result = mysqli_query($connect, $sql);
	$rowcount = mysqli_num_rows($result);

	return $rowcount;
}

function user_name($id){
	include 'database_of.php';

	$sql = "SELECT * FROM log WHERE id = '$id'";
	$result = mysqli_query($connect, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		return $row['uid'];
	}

}

function name_to_id($name){
	include 'database_of.php';

	$sql = "SELECT * FROM log WHERE uid = '$name'";
	$result = mysqli_query($connect, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		return $row['id'];
	}

}

function profile_status($id){
	include 'database_of.php';

	$sql = "SELECT * FROM profileimage WHERE userid = '$id'";
	$result = mysqli_query($connect, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		return $row['status'];
	}

}

function online_pin($from_user_id, $to_user_id)
{
	date_default_timezone_set('Africa/Accra');
	$current_timestamp = strtotime(date('Y-m-d H:i:s') .'-10 seconds');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($to_user_id);


	if($user_last_activity > $current_timestamp){

		$output = count_unseen_message($from_user_id, $to_user_id);
	}
	else
	{
		$output = "";
	}

	return $output;
}


function cut($timestamp){
	date_default_timezone_set('Africa/Accra');
	list($date, $time) = explode(" ", $timestamp);
	list($year, $month, $day) = explode("-", $date);
	list($hour, $min, $second) = explode(":", $time);

	$time_string = mktime($hour, $min, $second, $month, $day, $year);

	return $time_string;
}

function ut($timestamp){
	date_default_timezone_set('Africa/Accra');
	list($date, $time) = explode(" ", $timestamp);
	list($year, $month, $day) = explode("-", $date);
	list($hour, $min, $second) = explode(":", $time);

	$current_timestamp = date('Y-m-d H:i:s');
	list($datec, $timec) = explode(" ", $current_timestamp);
	list($yearc, $monthc, $dayc) = explode("-", $datec);

	if($month == "01")
	{
		$month = "January";
	}
	elseif ($month == "02") {
		$month = "February";
	}
	elseif ($month == "03") {
		$month = "March";
	}
	elseif ($month == "04") {
		$month = "April";
	}
	elseif ($month == "05") {
		$month = "May";
	}
	elseif ($month == "06") {
		$month = "June";
	}
	elseif ($month == "07") {
		$month = "July";
	}
	elseif ($month == "08") {
		$month = "August";
	}
	elseif ($month == "09") {
		$month = "September";
	}
	elseif ($month == "10") {
		$month = "October";
	}
	elseif ($month == "11") {
		$month = "November";
	}
	elseif ($month == "12") {
		$month = "December";
	}


	if($year == $yearc) $year = '';

	$act = $hour - 12;
	if($act < 1)
	{
		$hour = $hour.":".$min." AM";
	}
	elseif($act == 0) {
		$hour = '12'.":".$min." AM";
	}
	else{
		$hour = $act.":".$min." PM";
	}

	if(substr($day, -2) == '01')
	{
		$day = '1st';
	}
	elseif (substr($day, -2) == '02') {
		$day = '2nd';
	}
	elseif (substr($day, -1) != '1' || substr($day, -1) != '2' || substr($day, -2) == '11' || substr($day, -2) == '12') {
		$day = $day.'th';
	}


	$time_string = $hour." - ".$day." ".$month." ".$year;

	return $time_string;
}

function agoTime($time){
	$time_diff = time() - $time;
	$period = ["second", "minute", "hour", "day", "week", "month", "year", "decade"];
	$period_length = ["60", "60", "24", "7", "4.35", "12", "10"];

	for($i=0; $time_diff >= $period_length[$i]; $i++)
	$time_diff /= $period_length[$i];

	$time_diff = round($time_diff);

	if($time_diff != 1) $period[$i] .= "s";

	$output = $time_diff." ".$period[$i]." ago";

	return $output;	
}

function toTime($time){
	$time_diff = $time - time();
	$period = ["second", "minute", "hour", "day", "week", "month", "year", "decade"];
	$period_length = ["60", "60", "24", "7", "4.35", "12", "10"];

	for($i=0; $time_diff >= $period_length[$i]; $i++)
	$time_diff /= $period_length[$i];

	$time_diff = round($time_diff);

	if($time_diff != 1) $period[$i] .= "s";

	$output = $time_diff." ".$period[$i]." more";

	return $output;	
}

function toTim($time){
	$time_diff = $time - time();
	$period = ["second", "minute", "hour", "day", "week", "month", "year", "decade"];
	$period_length = ["60", "60", "24", "7", "4.35", "12", "10"];

	for($i=0; $time_diff >= $period_length[$i]; $i++)
	$time_diff /= $period_length[$i];

	$time_diff = round($time_diff);

	if($time_diff != 1) $period[$i] .= "s";

	$output = $time_diff." ".$period[$i];

	return $output;	
}
function message_status($from_user_id, $to_user_id){
	include 'database_of.php';
	$s0 = '0';
	$s2 = '2';
	$output = '';

	$sqs = "SELECT * FROM chat_message WHERE from_user_id = ? AND to_user_id = ? OR from_user_id = ? AND to_user_id = ? ORDER BY timestamp DESC LIMIT 1";
					//$result = mysqli_query($connect, $sql);

	$sts = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sts, $sqs))
	{
		echo "None1";
		exit();
	}
	mysqli_stmt_prepare($sts, $sqs);
	mysqli_stmt_bind_param($sts, "iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
	mysqli_stmt_execute($sts);

	$s_al = mysqli_stmt_get_result($sts);

	while($ros = mysqli_fetch_assoc($s_al))
	{
		$sqr = "SELECT * FROM login_details WHERE user_id = ?;";
		//$result = mysqli_query($connect, $sql);

		$str = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($str, $sqr))
		{
			echo "None2";
			exit();
		}
		mysqli_stmt_prepare($str, $sqr);
		mysqli_stmt_bind_param($str, "i", $to_user_id);
		mysqli_stmt_execute($str);
		$s_ar = mysqli_stmt_get_result($str);

		while($ror = mysqli_fetch_assoc($s_ar))
		{
			$last_activity = $ror['last_activity'];
		}

		if($ros['from_user_id'] == $from_user_id && $ros['status'] != $s2)
		{
			if($ros['timestamp'] > $last_activity)
			{
				$output .='<span style="width: 100%; float: left; margin-bottom: 5px; overflow:hidden;">
											<img style="float: left; margin-left: 4px; opacity: 0.7;" src="delivered.png" height="12" width="12" title="delivered">
										</span>';
			}
			elseif ($ros['timestamp'] <= $last_activity && $ros['status'] != $s0) 
			{
				$output .='<span style="width: 100%; float: left; margin-bottom: 5px; overflow:hidden;">
											<img style="float: left; margin-left: 4px; opacity: 0.7;" src="rcv.png" height="15" width="15" title="received">
										</span>';
			}
			elseif ($ros['status'] == $s0) 
			{
				$output .='<span style="width: 100%; float: left; margin-bottom: 5px; overflow:hidden;">
											<img style="float: left; margin-left: 4px;" src="seen.png" height="15" width="17" title="seen">
										</span>';
			}
		}
	}
	return $output;
}

function stel(){
	include 'database_of.php';
	$current_timestamp = date('Y-m-d H:i:s');
	$output = '';

	$sql = "SELECT * FROM events   WHERE `end` > '$current_timestamp'  AND '$current_timestamp' < start ORDER BY `end` ASC";
	$result = mysqli_query($connect, $sql);
	$output .= '<span style="height: 3.5%; width: 100%; float: left;  margin-top: 5px;">
									<table style="text-align: left; font-family: monospace; width: 100%;">
										<tr><td style="width:60%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Event</td>
											<td style="width:20%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Fame</td>
											<td style="width:20%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">CountDown</td>
										</tr>
									</table>
					</span>';

	$rowcounts = mysqli_num_rows($result);
	if($rowcounts < 1)
	{
			$output.= '<table style="text-align: left; font-family: Calibri; width: 100%;">
					<tr style="line-height: 40px;">
						<td style="border-top: 0.5px solid #F0F0F0; width: 100%; height: 100%; ">
							<div style="font-family: monospace; font-size: 12px; font-weight: bold; color: gray;">None !</p>
						</td>
					</tr>
				</table>';
	}
	else
	{
		
		$output .= 	'<table style="text-align: left; font-family: Calibri; width: 100%;">';
		while($row = mysqli_fetch_assoc($result))
		{	
			$query = "SELECT * FROM replies WHERE category_id = '2' AND topic_id = '".$row['id']."'";
			$submit = mysqli_query($connect, $query); 
			$replies = mysqli_num_rows($submit);

			$row['event_title'] = str_replace("\'", "'", $row['event_title']);

			$fresh = "SELECT `end` FROM events WHERE id = '".$row['id']."' ORDER BY `end` ASC LIMIT 1";
			$submitf = mysqli_query($connect, $fresh); 	
								
			$output .=  '<tr style="line-height: 40px;">
							<td style="border-top: 0.5px solid #F0F0F0; width: 100%; height: 100%; ">
								<span style="height: 100%; width: 60%; float: left;">
									<div class="event_link" id='.$row['id'].' style="width:100%; cursor:pointer; height: 28px; margin:0px; color:gray; font-size: 16px; vertical-align: top;  overflow:hidden;">'.$row['event_title'].'
									</div>
								</span>
								<span style="width:20%; display:inline; float:left; color: gray; font-size: 13px; ">
									'.$replies.'
								</span>';
								while($rowf = mysqli_fetch_assoc($submitf))
								{	
									$fr = $rowf['end'];
									$output .= '<span style="width:20%; color: gray; float:right; display:inline; font-size: 13px;">'.toTime(cut($fr)).'</span>';
								}
			$output	.= 	'	</td>
						</tr>';
		}
		$output .= '</table>';
	}
	$output .= '<span>';

	return $output;
}

function onvote()
{
	include 'database_of.php';
	$current_timestamp = date('Y-m-d H:i:s');
	$output = '';

	$sql = "SELECT * FROM vote WHERE countdown >= '$current_timestamp' OR status = 'inactive'";
	$result = mysqli_query($connect, $sql);

	$rowcounts = mysqli_num_rows($result);
	if($rowcounts < 1)
	{
			$output.= '<table style="text-align: left; font-family: Calibri; width: 100%;">
					<tr >
						<td style="width: 100%; height: 100%; ">
							<div style="font-family: monospace; font-size: 12px; font-weight: bold; color: gray;">None !</p>
						</td>
					</tr>
				</table>';
	}
	else{
		
		$output .= 	'<table style="text-align: left; font-family: Calibri; width: 100%;">';
		while($row = mysqli_fetch_assoc($result))
		{
			$row['contest_name'] = str_replace("\'", "'", $row['contest_name']);
			$first = $row['contest_name'][0];
			if($row['status'] == 'inactive')
			{
				$row['status'] = 'Pending';
				if($row['contest_type'] == '10')
				{
					$row['status'] = '<span style="color: #1E2D38;">Pending</span>';
				}
			}
			if($row['status'] == 'active')
			{
				$row['status'] = '<span >Active</span>';
			}
			if($row['contest_type']  == '4')
			{
				$table_data = '<td class="vact_na" id="'.$row['id'].'" style="float: left; width: 96%; height: 96%; margin: 2%; background-image: url(choice_con.png); background-size: cover; background-repeat: no-repeat;  overflow: hidden; border: 1px solid #F0F0F0; position: relative; cursor: pointer;">';
 			}
 			elseif ($row['contest_type']  == '10')
 			{
 				$table_data = '<td class="vact_na" id="'.$row['id'].'" style="float: left; width: 96%; height: 96%; margin: 2%; background-image: url(con_con.png); background-size: cover; background-repeat: no-repeat;  overflow: hidden; border: 1px solid #F0F0F0; position: relative; cursor: pointer;">';
 			}

			$output .=  '<tr style="width: 33%; display: inline-block; height: 220px;">
							'.$table_data.'
								<span style="position: absolute; top: 0px; left: 0px; width: 100%; height: 10%; float: left;">
									<span style="float: right; margin: 3px; font-family: monospace;  font-size: 10px;">
										'.$row['status'].'
									</span>
								</span>
								<span class="contest_n">
									<span style="float: left; width: 100%; margin: 5px; color: #1E2D38; font-size: 16px; font-family: Calibri; text-align: middle; font-weight: bold;">
										'.$row['contest_name'].'
									</span>
								</span>
							</td>
						</tr>';
		}

		$output .= '</table>';
	}	

	return $output;
}

function vo_re($topic_id)
{
	include 'database_of.php';
	$id = $_SESSION['user_id'];
	date_default_timezone_set('Africa/Accra');
	$current_timestamp = date('Y-m-d H:i:s');

	$sql = "SELECT * FROM vote WHERE id = ?";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $topic_id);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);
	$output = '';

	while($row = mysqli_fetch_assoc($result))
	{

		$row['contest_name'] = str_replace("\'", "'", $row['contest_name']);
		$row['contest_desc'] = str_replace(" ", "&nbsp", $row['contest_desc']);
		$row['contest_desc'] = str_replace("\'", "'", $row['contest_desc']);
		$row['contest_desc'] = str_replace('\n', "\n", $row['contest_desc']);
		$row['contest_desc'] = str_replace('\r', "\r", $row['contest_desc']);

		$con_type = $row['contest_type'];
		$con_id = $row['id'];

		$alt = "SELECT * FROM vote_alternatives WHERE contest_id = '$con_id'";
		$altq = mysqli_query($connect, $alt);

		$rowcount = mysqli_num_rows($altq);

		$sqs = "SELECT * FROM vote_choice WHERE user_id = ? AND contest_id = ?;";
		//$result = mysqli_query($connect, $sql);
		$sts = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($sts, $sqs))
		{
			exit();
		}
		mysqli_stmt_prepare($sts, $sqs);
		mysqli_stmt_bind_param($sts, "ii", $id, $topic_id);
		mysqli_stmt_execute($sts);

		$results = mysqli_stmt_get_result($sts);
		$rowcounts = mysqli_num_rows($results);

		$atr = 'None';
		if($rowcounts > 0)
		{
			if($ratr = mysqli_fetch_assoc($results))
			{
				$atr = $ratr['tries'];
				if($atr == '2')
				{
					$atr = ' | 0 tries';
				}
				else
				{
					$atr = ' | '.$atr.' try';
				}
			}
		}
		else
		{
			$atr = ' | 2 tries';
		}

		$ap = "SELECT * FROM vote_alternatives WHERE contest_id = '$con_id' AND approval != 'approved'";
		$pa = mysqli_query($connect, $ap);
		$pending = mysqli_num_rows($pa);

		$tries = '';
		$on = '';

		if($row['status'] == 'inactive' && $row['contest_type'] == '10')
		{
			$on = '0';
			$tries = $pending.' pending approval';
			if($pending > 1)
			{
				$tries = $pending.' pending approvals';
			}
		}
		if($row['status'] == 'active' && $row['contest_type'] == '10')
		{
			if($row['countdown'] < $current_timestamp)
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">Closed at '.ut($row['countdown']).'</span>';
			}
			else
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">'.toTime(cut($row['countdown'])).'</span>';
			}
		}
		if($row['contest_type'] == '4')
		{
			if($row['countdown'] < $current_timestamp)
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">Closed at '.ut($row['countdown']).'</span>';
			}
			else
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">'.toTime(cut($row['countdown'])).'</span>';
			}
		}

		$del = '';
		if($row['user_id'] == $id && $row['status'] == 'inactive')
		{
			$trash = '<img id="'.$row['id'].'" style="cursor: pointer; margin-left: 5px;" title="delete topic" class="dto" src="trash.png" height="13" width="13" />';
			$del = '<span class="pivi" hidden>'.$trash.'</span>
				<img class="option_pin" src="option.png" height="10" width="11" />';
		}

		$output .= '<span style="float: left; width:100%; margin:0px; margin-top: 10px; max-height: 100%; overflow: scroll; margin-bottom: 0px;">
						<span ="width: 100%; float: left;">	
							<span style="font-family: verdana; font-size: 13px; font-weight: bold; color: #1E2D38; vertical-align: middle; width: 75%; float:left;">
								<img style="border-radius: 50%;" src="Files/Profile/profile'.$row['user_id'].'.jpg" height="32" width="32">
								<span style="vertical-align: 70%; margin-left: 5px;">
									'.user_name($row['user_id']).'
									<span style="color: #CCCCCC; font-family: Calibri; padding-right: 5px; font-size: 10px; font-style: italic;">
										(Organiser)
									</span>
								</span>
							</span>
							<span style="font-size: 11px; color: #CCCCCC; float: right; width: 25%;">
								<span style="float:right;">
									<span style="font-size:11px; color: #1A636B; font-family: Calibri; margin-left: 5px;">
										'.ut($row['date']).'
										'.$del.'
									</span>
								</span>
							</span>
						</span>
						<span style="width: 98%; float: left; margin: 0px 1%; margin-top: 20px; font-family: Calibri;  color: #4D4D4D;">
							<span style="font-size: 17px; font-weight: bold; width: 100%; float:left;">'.$row['contest_name'].'</span>
							<span style="font-size: 15px; width: 100%; margin-top: 10px; float:left; padding-bottom: 5px;">'.nl2br($row['contest_desc']).'</span>
							<span style="width: 98%; float: right; margin: 0px 1%; color: #CCCCCC; font-family: Calibri; font-size: 11px; border-top: 0.5px solid #F0F0F0;">
								<span style="float: left;">'.$rowcount.' Alternatives'.$atr.'</span>
								<span style="float: right;">
									<span class="vote_status">
										<img src="vote_graph.png" class="view_graph" data-cid='.$topic_id.' style="margin: 2px; margin-bottom: -5px; cursor: pointer;" title="View graph" height="17" width="17">
									</span> 
									| '.$tries.'
								</span>
								<span style="float: left; width: 100%; position: relative;" class="ctv">
									<table style="text-align: left; font-family: Calibri; width: 100%;">';

	while($rowa = mysqli_fetch_assoc($altq))
	{
			$but = '';
			if($on != '0' && $row['contest_type'] == '10')
			{
				$but = '<span style="width: 100%; float: right; text-align: right; margin: 3px;">
							<button class="vote_but" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';

				$sqs = "SELECT * FROM vote_choice WHERE user_id = ? AND contest_id = ? AND choice_num = ?;";
				//$result = mysqli_query($connect, $sql);
				$sts = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sts, $sqs))
				{
					exit();
				}
				mysqli_stmt_prepare($sts, $sqs);
				mysqli_stmt_bind_param($sts, "iii", $id, $rowa['contest_id'], $rowa['option_number']);
				mysqli_stmt_execute($sts);

				$results = mysqli_stmt_get_result($sts);
				$rowcounts = mysqli_num_rows($results);

				if($rowcounts == '1')
				{
					$but = '<span style="width: 100%; float: right; text-align: right; margin: 3px;">
							<button class="vote_but" id="vote_on" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';
				}
			}

			if($row['status'] == 'inactive')
			{	
				if($rowa['choice'] == user_name($id))
				{	
					$ch = $rowa['choice'];

					$csq = "SELECT * FROM vote_alternatives WHERE choice = '$ch' AND contest_id = '$con_id'";
					$sqc = mysqli_query($connect, $csq);

					if($rowc = mysqli_fetch_assoc($sqc)){

						if($rowc['approval'] != 'approved')
						{
							$but = '<span style="width: 100%; float: right; text-align: right; margin: 3px;">
								<button class="vote_but" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Approve contest">Approve</button>
							</span>';
						}
						else
						{
							$but = '';
						}
					}
				}
			}

			if($con_type == '10')
			{
				$display = '<td style="float: left; width: 180px; height: 180px; margin: 8px 0px; position: relative; ">
								<span style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; float: left; 
								border: 1px solid #F0F0F0;">
									<img style="width: 96%; height: 96%; margin: 2%;" src="Files/Profile/profile'.name_to_id($rowa['choice']).'.jpg">
								</span>
								<span style="position: absolute; bottom: 0px; left: 1%; width: 99%; max-height: 50%; float: left; background-color: white;">
									<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px; text-align: center;">
										'.$rowa['choice'].'
									</span>
									'.$but.'
								</span>
							</td>';

				$output .=  '<tr style="width: 33.33%; display: inline-block;">
								'.$display.'
							</tr>';
			}
			elseif ($con_type == '4') 
			{
				$but = '<span style="width: 100%; margin: 3px; float: left; text-align: left;">
							<button class="vote_but" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';

				$sqs = "SELECT * FROM vote_choice WHERE user_id = ? AND contest_id = ? AND choice_num = ?;";
				//$result = mysqli_query($connect, $sql);
				$sts = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sts, $sqs))
				{
					exit();
				}
				mysqli_stmt_prepare($sts, $sqs);
				mysqli_stmt_bind_param($sts, "iii", $id, $rowa['contest_id'], $rowa['option_number']);
				mysqli_stmt_execute($sts);

				$results = mysqli_stmt_get_result($sts);
				$rowcounts = mysqli_num_rows($results);

				if($rowcounts == '1')
				{
					$but = '<span style="width: 100%; float: left; text-align: left; margin: 3px;">
							<button class="vote_but" id="vote_on" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';
				}

				$alim = '';
				if($rowa['file'] != '')
				{
					$alim = '<td style="float: left; width: 75%; max-height: 230px; margin: 8px 0px; margin-top: 25px; position: relative;  scroll-y: scroll;">
								<span style="width: 100%; height: 100%; float: left; 
									border: 1px solid #F0F0F0;">
									<img class="vcp" data-id="'.$rowa['file'].'" style="max-width: 96%; max-height: 96%; margin: 2% auto; display: block; " src="Files/Forum_uploads/Vote/'.$rowa['file'].'">
								</span>
								<span style=" bottom: 0px; width: 100%; max-height: 50%; float: left; background-color: white;">
									<span style="position: absolute; bottom: 2px; left: 1%; width: 99%; max-height: 50%; float: left; background-color: white;">
										<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px;">
											<span style="color: gray; font-weight: bold;">C'.$rowa['option_number'].'.' .nl2br('&nbsp&nbsp').'</span>'.$rowa['choice'].'
										</span>
										'.$but.'
									</span>
								</span>
							</td>';
				}
				else
				{
					$alim = '<td style="float: left; width: 75%; max-height: 230px; margin: 8px 0px; margin-top: 25px; scroll-y: scroll; border: 1px solid #F0F0F0;;">
								<span style=" bottom: 0px; width: 100%; max-height: 50%; float: left; background-color: white;">
									<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px;">
										<span style="color: gray; font-weight: bold;">C'.$rowa['option_number'].'.' .nl2br('&nbsp&nbsp').'</span>'.$rowa['choice'].'
									</span>
									'.$but.'
								</span>
								</td>';
				}
				$display = $alim;

				$output .=  '<tr style="width: 50%; display: inline-block;">
								'.$display.'
							</tr>';
			}
	}
	$output .=						'</table>
								</span>
							</span>
						</span>
					</span>';
	}

	return $output;
}

function return_vote($con_id)
{
	include 'database_of.php';
	$id = $_SESSION['user_id'];

	$sql = "SELECT * FROM vote WHERE id = ?";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $con_id);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);
	$output = '';
	$on = '';

	while($row = mysqli_fetch_assoc($result))
	{
		$con_type = $row['contest_type'];

		if($row['status'] == 'inactive' && $row['contest_type'] == '10')
		{
			$on = '0';
		}
	}

	$alt = "SELECT * FROM vote_alternatives WHERE contest_id = '$con_id'";
	$altq = mysqli_query($connect, $alt);

	$output = '';
	$output .= '<table style="text-align: left; font-family: Calibri; width: 100%;">';

	while($rowa = mysqli_fetch_assoc($altq))
	{
			$but = '';
			if($on != '0' && $con_type == '10')
			{
				$but = '<span style="width: 100%; float: right; text-align: right; margin: 3px;">
							<button class="vote_but" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';

				$sqs = "SELECT * FROM vote_choice WHERE user_id = ? AND contest_id = ? AND choice_num = ?;";
				//$result = mysqli_query($connect, $sql);
				$sts = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sts, $sqs))
				{
					exit();
				}
				mysqli_stmt_prepare($sts, $sqs);
				mysqli_stmt_bind_param($sts, "iii", $id, $rowa['contest_id'], $rowa['option_number']);
				mysqli_stmt_execute($sts);

				$results = mysqli_stmt_get_result($sts);
				$rowcounts = mysqli_num_rows($results);

				if($rowcounts == '1')
				{
					$but = '<span style="width: 100%; float: right; text-align: right; margin: 3px;">
							<button class="vote_but" id="vote_on" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';
				}
			}

			if($row['status'] == 'inactive')
			{	
				if($rowa['choice'] == user_name($id))
				{	
					$ch = $rowa['choice'];

					$csq = "SELECT * FROM vote_alternatives WHERE choice = '$ch' AND contest_id = '$con_id'";
					$sqc = mysqli_query($connect, $csq);

					if($rowc = mysqli_fetch_assoc($sqc)){

						if($rowc['approval'] != 'approved')
						{
							$but = '<span style="width: 100%; float: right; text-align: right; margin: 3px;">
								<button class="vote_but" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Approve contest">Approve</button>
							</span>';
						}
						else
						{
							$but = '';
						}
					}
				}
			}

			if($con_type == '10')
			{
				$display = '<td style="float: left; width: 180px; height: 180px; margin: 8px 0px; position: relative; ">
								<span style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; float: left; 
								border: 1px solid #F0F0F0;">
									<img style="width: 96%; height: 96%; margin: 2%;" src="Files/Profile/profile'.name_to_id($rowa['choice']).'.jpg">
								</span>
								<span style="position: absolute; bottom: 0px; left: 1%; width: 99%; max-height: 50%; float: left; background-color: white;">
									<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px; text-align: center;">
										'.$rowa['choice'].'
									</span>
									'.$but.'
								</span>
							</td>';

				$output .=  '<tr style="width: 33.33%; display: inline-block;">
								'.$display.'
							</tr>';
			}
			elseif ($con_type == '4') 
			{
				$but = '<span style="width: 100%; margin: 3px; float: right; text-align: right;">
							<button class="vote_but" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';

				$sqs = "SELECT * FROM vote_choice WHERE user_id = ? AND contest_id = ? AND choice_num = ?;";
				//$result = mysqli_query($connect, $sql);
				$sts = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sts, $sqs))
				{
					exit();
				}
				mysqli_stmt_prepare($sts, $sqs);
				mysqli_stmt_bind_param($sts, "iii", $id, $rowa['contest_id'], $rowa['option_number']);
				mysqli_stmt_execute($sts);

				$results = mysqli_stmt_get_result($sts);
				$rowcounts = mysqli_num_rows($results);

				if($rowcounts == '1')
				{
					$but = '<span style="width: 100%; float: right; text-align: right; margin: 3px;">
							<button class="vote_but" id="vote_on" data-cn="'.$rowa['option_number'].'" data-cid="'.$rowa['contest_id'].'" title="Alternative '.$rowa['option_number'].'">vote</button>
						</span>';
				}

				$alim = '';
				if($rowa['file'] != '')
				{
					$alim = '<td style="float: left; width: 75%; max-height: 230px; margin: 8px 0px; margin-top: 25px; position: relative;  scroll-y: scroll;">
								<span style="width: 100%; height: 100%; float: left; 
									border: 1px solid #F0F0F0;">
									<img class="vcp" data-id="'.$rowa['file'].'" style="max-width: 96%; max-height: 96%;  margin: 2% auto; display: block; " src="Files/Forum_uploads/Vote/'.$rowa['file'].'">
								</span>
								<span style=" bottom: 0px; width: 100%; max-height: 50%; float: left; background-color: white;">
									<span style="position: absolute; bottom: 2px; left: 1%; width: 99%; max-height: 50%; float: left; background-color: white;">
										<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px;">
											<span style="color: gray; font-weight: bold;">C'.$rowa['option_number'].'.' .nl2br('&nbsp&nbsp').'</span>'.$rowa['choice'].'
										</span>
										'.$but.'
									</span>
								</span>
							</td>';
				}
				else
				{
					$alim = '<td style="float: left; width: 75%; max-height: 230px; margin: 8px 0px; margin-top: 25px; scroll-y: scroll; border: 1px solid #F0F0F0;;">
								<span style=" bottom: 0px; width: 100%; max-height: 50%; float: left; background-color: white;">
									<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px;">
										<span style="color: gray; font-weight: bold;">C'.$rowa['option_number'].'.' .nl2br('&nbsp&nbsp').'</span>'.$rowa['choice'].'
									</span>
									'.$but.'
								</span>
								</td>';
				}
				$display = $alim;

				$output .=  '<tr style="width: 50%; display: inline-block;">
								'.$display.'
							</tr>';
			}
	}
	$output .=						'</table>';

	return $output;
}

function coco($topic_id)
{
	include 'database_of.php';
	$id = $_SESSION['user_id'];
	date_default_timezone_set('Africa/Accra');
	$current_timestamp = date('Y-m-d H:i:s');

	$sql = "SELECT * FROM vote WHERE id = ?";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $topic_id);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);
	$output = '';

	while($row = mysqli_fetch_assoc($result))
	{

		$row['contest_name'] = str_replace("\'", "'", $row['contest_name']);
		$row['contest_desc'] = str_replace(" ", "&nbsp", $row['contest_desc']);
		$row['contest_desc'] = str_replace("\'", "'", $row['contest_desc']);
		$row['contest_desc'] = str_replace('\n', "\n", $row['contest_desc']);
		$row['contest_desc'] = str_replace('\r', "\r", $row['contest_desc']);

		$con_type = $row['contest_type'];
		$con_id = $row['id'];

		$alt = "SELECT * FROM vote_alternatives WHERE contest_id = '$con_id'";
		$altq = mysqli_query($connect, $alt);

		$rowcount = mysqli_num_rows($altq);

		$sqs = "SELECT * FROM vote_choice WHERE user_id = ? AND contest_id = ?;";
		//$result = mysqli_query($connect, $sql);
		$sts = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($sts, $sqs))
		{
			exit();
		}
		mysqli_stmt_prepare($sts, $sqs);
		mysqli_stmt_bind_param($sts, "ii", $id, $topic_id);
		mysqli_stmt_execute($sts);

		$results = mysqli_stmt_get_result($sts);
		$rowcounts = mysqli_num_rows($results);

		$atr = 'None';
		if($rowcounts > 0)
		{
			if($ratr = mysqli_fetch_assoc($results))
			{
				$atr = $ratr['tries'];
				if($atr == '2')
				{
					$atr = ' | 0 tries';
				}
				else
				{
					$atr = ' | '.$atr.' try';
				}
			}
		}
		else
		{
			$atr = ' | 2 tries';
		}

		$ap = "SELECT * FROM vote_alternatives WHERE contest_id = '$con_id' AND approval != 'approved'";
		$pa = mysqli_query($connect, $ap);
		$pending = mysqli_num_rows($pa);

		$tries = '';
		$on = '';

		if($row['status'] == 'inactive' && $row['contest_type'] == '10')
		{
			$on = '0';
			$tries = $pending.' pending approval';
			if($pending > 1)
			{
				$tries = $pending.' pending approvals';
			}
		}
		if($row['status'] != 'inactive' && $row['contest_type'] == '10')
		{
			if($row['countdown'] < $current_timestamp)
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">Closed at '.ut($row['countdown']).'</span>';
			}
			else
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">'.toTime(cut($row['countdown'])).'</span>';
			}
		}
		if($row['contest_type'] == '4')
		{
			if($row['countdown'] < $current_timestamp)
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">Closed at '.ut($row['countdown']).'</span>';
			}
			else
			{
				$tries = '<img src="timer.png" style="margin: 2px; margin-bottom: -3px;" height="15" width="15">
							<span style="color: gray; font-size: 13px;">'.toTime(cut($row['countdown'])).'</span>';
			}
		}

		$del = '';
		if($row['user_id'] == $id && $row['status'] == 'inactive')
		{
			$trash = '<img id="'.$row['id'].'" style="cursor: pointer; margin-left: 5px;" title="delete topic" class="dto" src="trash.png" height="13" width="13" />';
			$del = '<span class="pivi" hidden>'.$trash.'</span>
				<img class="option_pin" src="option.png" height="10" width="11" />';
		}

		$output .= '<span style="float: left; width:100%; margin:0px; margin-top: 10px; max-height: 100%; overflow: scroll; margin-bottom: 0px;">
						<span ="width: 100%; float: left;">	
							<span style="font-family: verdana; font-size: 13px; font-weight: bold; color: #1E2D38; vertical-align: middle; width: 75%; float:left;">
								<img style="border-radius: 50%;" src="Files/Profile/profile'.$row['user_id'].'.jpg" height="32" width="32">
								<span style="vertical-align: 70%; margin-left: 5px;">
									'.user_name($row['user_id']).'
									<span style="color: #CCCCCC; font-family: Calibri; padding-right: 5px; font-size: 10px; font-style: italic;">
										(Organiser)
									</span>
								</span>
							</span>
							<span style="font-size: 11px; color: #CCCCCC; float: right; width: 25%;">
								<span style="float:right;">
									<span style="font-size:11px; color: #1A636B; font-family: Calibri; margin-left: 5px;">
										'.ut($row['date']).'
										'.$del.'
									</span>
								</span>
							</span>
						</span>
						<span style="width: 98%; float: left; margin: 0px 1%; margin-top: 20px; font-family: Calibri;  color: #4D4D4D;">
							<span style="font-size: 17px; font-weight: bold; width: 100%; float:left;">'.$row['contest_name'].'</span>
							<span style="font-size: 15px; width: 100%; margin-top: 10px; float:left; padding-bottom: 5px;">'.nl2br($row['contest_desc']).'</span>
							<span style="width: 98%; float: right; margin: 0px 1%; color: #CCCCCC; font-family: Calibri; font-size: 11px; border-top: 0.5px solid #F0F0F0;">
								<span style="float: left;">'.$rowcount.' Alternatives</span>
								<span style="float: right;">
									'.$tries.'
								</span>
								<span style="float: left; width: 100%; position: relative;" class="ctv">
									<table style="text-align: left; font-family: Calibri; width: 100%; font-size: 14px; margin-top: 4px;">
										'.position($topic_id).'';
	$output .=						'</table>
									'.vote_graph($topic_id).'
								</span>
							</span>
						</span>';
		}
	return $output;
}

function access($topic_id)
{
	include 'database_of.php';

	$up = "SELECT * FROM vote_alternatives WHERE contest_id = '$topic_id'";
	$upts = mysqli_query($connect, $up);

	while($row = mysqli_fetch_assoc($upts))
	{
		$sqs = "SELECT * FROM vote_choice WHERE contest_id = ? AND choice_num = ?;";
		//$result = mysqli_query($connect, $sql);
		$sts = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($sts, $sqs))
		{
			exit();
		}
		mysqli_stmt_prepare($sts, $sqs);
		mysqli_stmt_bind_param($sts, "ii", $topic_id, $row['option_number']);
		mysqli_stmt_execute($sts);

		$resultsq = mysqli_stmt_get_result($sts);
		$rowcountsq = mysqli_num_rows($resultsq);

		$status = "UPDATE vote_alternatives SET votes = '$rowcountsq' WHERE id = '".$row['id']."'";
		$results = mysqli_query($connect, $status);
	}	

	$statuc = "UPDATE vote SET status = 'Complete' WHERE id = '".$topic_id."'";
	$resultc = mysqli_query($connect, $statuc);
}

function position($topic_id)
{
	include 'database_of.php';
	$alt = "SELECT * FROM vote_alternatives WHERE contest_id = '$topic_id' ORDER BY votes DESC";
	$altq = mysqli_query($connect, $alt);

	$sql = "SELECT * FROM vote WHERE id = ?";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $topic_id);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);
	$output = '';

	while($row = mysqli_fetch_assoc($result))
	{
		$con_type = $row['contest_type'];
	}

	$position = 1;
	$compare = array('none', $position);
	while($rowa = mysqli_fetch_assoc($altq))
	{
		if($compare[0] == $rowa['votes'])
		{
			$position--;
		}

		$unknown = array(1,2,3);
		if($position == 1)
		{
			$positions = '<span style="font-size: 15px; color: gray;"><span style="font-weight: bold; color: #424B52; font-size: 19px; font-family: Calibri;">'.$position.'</span>st</span></span>';
		}
		if ($position == 2) {
			$positions = '<span style="font-size: 15px; color: gray;"><span style="font-weight: bold; color: #424B52; font-size: 18px; font-family: Calibri;">'.$position.'</span>nd</span></span>';
		}
		if ($position == 3) {
			$positions = '<span style="font-size: 15px; color: gray;"><span style="font-weight: bold; color: #424B52; font-size: 18px; font-family: Calibri;">'.$position.'</span>rd</span></span>';
		}
		if(!in_array($position, $unknown)){
			'<span style="font-size: 15px; color: gray;"><span style="font-weight: bold; color: #424B52; font-size: 18px; font-family: Calibri;">'.$position.'</span>th</span></span>';
		}
			
			if($con_type == '10')
			{
				$display = '<td style="float: left; width: 180px; height: 180px; margin: 8px 0px; position: relative; ">
								<span style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; float: left; 
								border: 1px solid #F0F0F0;">
									<img style="width: 96%; height: 96%; margin: 2%;" src="Files/Profile/profile'.name_to_id($rowa['choice']).'.jpg">
								</span>
								<span style="position: absolute; top: 0px; left: 0px; width: 20%; height: 20%; float: left; 
								background-color: white; border-radius: 0px 0px 100% 0px;">
									'.$positions.'
								</span>
								<span style="position: absolute; bottom: 0px; left: 1%; width: 99%; max-height: 50%; float: left; background-color: white;">
									<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px; text-align: center;">
										'.$rowa['choice'].'
									</span>
								</span>
							</td>';

				$output .=  '<tr style="width: 33.33%; display: inline-block;">
								'.$display.'
							</tr>';
			}
			elseif ($con_type == '4') 
			{

				$sqs = "SELECT * FROM vote_choice WHERE user_id = ? AND contest_id = ? AND choice_num = ?;";
				//$result = mysqli_query($connect, $sql);
				$sts = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sts, $sqs))
				{
					exit();
				}
				mysqli_stmt_prepare($sts, $sqs);
				mysqli_stmt_bind_param($sts, "iii", $id, $rowa['contest_id'], $rowa['option_number']);
				mysqli_stmt_execute($sts);

				$results = mysqli_stmt_get_result($sts);
				$rowcounts = mysqli_num_rows($results);


				$alim = '';
				if($rowa['file'] != '')
				{
					$alim = '<td style="float: left; width: 75%; max-height: 230px; margin: 8px 0px; margin-top: 25px; position: relative;  scroll-y: scroll;">
								<span style="width: 100%; height: 100%; float: left; 
									border: 1px solid #F0F0F0;">
									<img class="vcp" data-id="'.$rowa['file'].'" style="max-width: 96%; max-height: 96%; margin: 2% auto; display: block; " src="Files/Forum_uploads/Vote/'.$rowa['file'].'">
								</span>
								<span style="position: absolute; top: 0px; left: 0px; width: 20%; height: 20%; float: left; 
								background-color: white; border-radius: 0px 0px 100% 0px;">
									'.$positions.'
								</span>
								<span style=" bottom: 0px; width: 100%; max-height: 50%; float: left; background-color: white;">
									<span style="position: absolute; bottom: 2px; left: 1%; width: 99%; max-height: 50%; float: left; background-color: white;">
										<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px;">
											<span style="color: gray; font-weight: bold;">C'.$rowa['option_number'].'.' .nl2br('&nbsp&nbsp').'</span>'.$rowa['choice'].'
										</span>
									</span>
								</span>
							</td>';
				}
				else
				{
					$alim = '<td style="float: left; width: 75%; max-height: 230px; margin: 8px 0px; margin-top: 25px; scroll-y: scroll; border: 1px solid #F0F0F0;;">
								<span style="float: left; width: 100%; float: left; 
								background-color: white;">
									'.$positions.'
								</span>
								<span style=" bottom: 0px; width: 100%; max-height: 50%; float: left; background-color: white;">
									<span style="float: left; margin: 3px; font-family: Calibri;  font-size: 15px;">
										<span style="color: gray; font-weight: bold;">C'.$rowa['option_number'].'.' .nl2br('&nbsp&nbsp').'</span>'.$rowa['choice'].'
									</span>
								</span>
								</td>';
				}
				$display = $alim;

				$output .=  '<tr style="width: 50%; display: inline-block;">
								'.$display.'
							</tr>';
			}

			$position++;
			$compare[0] = $rowa['votes'];
	}
	return $output;
}

function vote_graph($topic_id){

	include 'database_of.php';

	$current_timestamp = date('Y-m-d H:i:s');

	$sql = "SELECT * FROM vote WHERE id = ?";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $topic_id);
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);
	$output = '';

	while($row = mysqli_fetch_assoc($result))
	{
		$on = '0';
		if($row['status'] != 'inactive')
		{
			$on = '1';
		}

		$cont = $row['contest_type'];

		$overall = $row['alternatives'];
	}

	$color = array('#E15330', '#F7D220' , '#226193', '#2E9758');
	$r_color = $color[array_rand($color)];

	$alt = "SELECT * FROM vote_alternatives WHERE contest_id = '$topic_id' ORDER BY votes DESC";
	$altq = mysqli_query($connect, $alt);
	$altqs = mysqli_query($connect, $alt);
	$reply = mysqli_num_rows($altq);

	$csqr = "SELECT * FROM vote_choice WHERE contest_id = '$topic_id'";
	$sqcr = mysqli_query($connect, $csqr);
	$repliesr = mysqli_num_rows($sqcr);

	if($cont == '10')
	{
		$output .= '<span style="width: 100%; float: left; margin-top: 5px;">';
		while($rop = mysqli_fetch_assoc($altqs))
		{
			$option_nums = $rop['option_number'];

			$csqs = "SELECT * FROM vote_choice WHERE choice_num = '$option_nums' AND contest_id = '$topic_id'";
			$sqcs = mysqli_query($connect, $csqs);
			$repliess = mysqli_num_rows($sqcs);

			if($repliess == '0')
			{
				$total = 0;
				$style = 'width: 7%;';
				$col = 'gray';
				$tot = 3;
			}
			else
			{
				$total = (($repliess/$repliesr)*100);

				if($total <= 25 && $total >= 0)
				{
					$tot = 0;
					$style = 'width: '.$total.'%; background-color:'.$color[0].';';
					$col = 'white';
				}
				elseif($total < 50 && $total > 25)
				{
					$tot = 1;
					$style = 'width: '.$total.'%; background-color:'.$color[1].';';
					$col = 'white';
				}
				elseif($total < 75 && $total >= 50)
				{
					$tot = 2;
					$style = 'width: '.$total.'%; background-color:'.$color[2].';';
					$col = 'white';
				}
				elseif($total <= 100 && $total >= 75)
				{
					$tot = 3;
					$style = 'width: '.$total.'%; background-color:'.$color[3].';';
					$col = 'white';
				}
			}

			if($repliess < '2')
			{
				$repliess = '<span style="font-size: 12px; font-family: Calibri;">'.$repliess.' vote - '.round($total).'% overall</span>';
			}
			else
			{
				$repliess = '<span style="font-size: 12px; font-family: Calibri;">'.$repliess.' votes - '.round($total).'% overall</span>';
			}

			$output .= '<span style="width: 50%; float: left; height: 39px; margin-bottom: 2px;">
							<span style="width: 80%; float: left; height: 100%;">
								<span style="width: 15%; float: ; left; height: 100%;">
									<img class="pic" src="Files/Profile/profile'.name_to_id($rop['choice']).'.jpg" title='.$rop['choice'].' height = 30 width = 30>
								</span>
								<span style="font-size: 14px; color: gray; vertical-align: top; width: 85%; float: right;">
									<span style="width: 100%; float: left;">
										'.$rop['choice'].'
									</span>
									<span style="width: 100%; float: left; color: '.$color[$tot].'; font-size: 13px;">
										'.$repliess.'
									</span>
								</span>
							</span>
							<span style="width: 20%; float: right; height: 100%;">
							</span>
						</span>';
		}
		$output .= '</span>';
	}
	else
	{
		$output .= '<span style="width: 100%; float: left; margin-top: 5px;">';
		while($rop = mysqli_fetch_assoc($altqs))
		{
			$option_num = $rop['option_number'];

			$csqs = "SELECT * FROM vote_choice WHERE choice_num = '$option_num' AND contest_id = '$topic_id'";
			$sqcs = mysqli_query($connect, $csqs);
			$repliess = mysqli_num_rows($sqcs);

			if($repliess == '0')
			{
				$total = 0;
				$style = 'width: 7%;';
				$col = 'gray';
				$tot = 4;
			}
			else
			{
				$total = (($repliess/$repliesr)*100);

				if($total <= 25 && $total >= 0)
				{
					$tot = 0;
					$style = 'width: '.$total.'%; background-color:'.$color[0].';';
					$col = 'white';
				}
				elseif($total < 50 && $total > 25)
				{
					$tot = 1;
					$style = 'width: '.$total.'%; background-color:'.$color[1].';';
					$col = 'white';
				}
				elseif($total < 75 && $total >= 50)
				{
					$tot = 2;
					$style = 'width: '.$total.'%; background-color:'.$color[2].';';
					$col = 'white';
				}
				elseif($total <= 100 && $total >= 75)
				{
					$tot = 3;
					$style = 'width: '.$total.'%; background-color:'.$color[3].';';
					$col = 'white';
				}
			}

			if($repliess < '2')
			{
				$repliess = '<span style="font-family: Calibri;">'.$repliess.' vote - '.round($total).'% overall</span>';
			}
			else
			{
				$repliess = '<span style="font-family: Calibri;">'.$repliess.' votes - '.round($total).'% overall</span>';
			}

			$output .= '<span style="width: 50%; float: left; height: 39px;">
							<span style="width: 80%; float: left; height: 100%;">
								<span style="width: 12%; float: ; left; height: 100%;">
									<span style="width: 30px; height: 30px; padding: 5px 6px; background-color: '.$color[$tot].'; color: white; border-radius: 50%;" title="Choice '.$option_num.'">C'.$option_num.'</span>
								</span>
								<span style="font-size: 14px; color: gray; height: 100%; width: 88%; float: right;">
									<span style="width: 100%; float: left; color: '.$color[$tot].'; font-size: 14px; ">
										'.$repliess.'
									</span>
								</span>
							</span>
							<span style="width: 20%; float: right; height: 100%;">
							</span>
						</span>';
		}
		$output .= '</span>';		
	}

	$output .= '<span style="width: 100%; float left;">
					<span style="width: 6.8%; float: left; height: 2.5%; margin: 1% 0%; border-right: 1px solid #E1E1E1; border-bottom: 1px solid #999999;">
					CHOICE
					</span>
					<span style="width: 93%; float: right; height: 2.5%; margin: 1% 0%; border-bottom: 1px solid #999999; text-align: right;">
					PERCENTAGE %
					</span>
				</span>';
	$output .= '<span style="float: left; width: 100%; border-bottom: 1px solid #999999;">';

	while($rowa = mysqli_fetch_assoc($altq))
	{

		$option_num = $rowa['option_number'];

		$csq = "SELECT * FROM vote_choice WHERE choice_num = '$option_num' AND contest_id = '$topic_id'";
		$sqc = mysqli_query($connect, $csq);
		$replies = mysqli_num_rows($sqc);

		if($replies == '0')
		{
			$total = 0;
			$style = 'width: 7%;';
			$col = 'gray';
			$tot = 3;
		}
		else
		{
			$total = (($replies/$repliesr)*100);

			if($total <= 25 && $total >= 0)
			{
				$tot = 0;
				$style = 'width: '.$total.'%; background-color:'.$color[0].';';
				$col = 'white';
			}
			elseif($total < 50 && $total > 25)
			{
				$tot = 1;
				$style = 'width: '.$total.'%; background-color:'.$color[1].';';
				$col = 'white';
			}
			elseif($total < 75 && $total >= 50)
			{
				$tot = 2;
				$style = 'width: '.$total.'%; background-color:'.$color[2].';';
				$col = 'white';
			}
			elseif($total <= 100 && $total >= 75)
			{
				$tot = 3;
				$style = 'width: '.$total.'%; background-color:'.$color[3].';';
				$col = 'white';
			}
		}

		$name = '<span style="width: 30px; height: 30px; padding: 5px 6px; background-color: '.$color[$tot].'; color: white; border-radius: 50%;">C'.$option_num.'</span>';
		if($cont == '10')
		{
			$name = '<img class="pic" src="Files/Profile/profile'.name_to_id($rowa['choice']).'.jpg" title='.$rowa['choice'].' height = 30 width = 30>';
		}

		$output .= '<span style="float: left; width: 100%; height: 40px;">
						<span style="width: 6.8%; float: left; height: 100%; border-right: 1px solid #999999; font-family: Calibri;  font-size: 14px; font-weight: bold; color: '.$color[$tot].';">
							<span style="height: 80%; width: 100%; float: left; margin: 14% 0%;">'.$name.'</span>
						</span>
						<span style="width: 93%; float: right; height: 100%; background-image: url(graph_background.jpg); background-size: cover; background-repeat: no-repeat;">
							<span style="float: left; '.$style.' height: 80%; border-radius: 0px 2px 2px 0px;">
								<span style=" float: right; border-radius: 50%; padding: 5px; color: '.$col.'; font-family: verdana; font-size: 15px;">
								'.round($total).'%
								</span>
							</span>
						</span>
					</span>';

	}

	$output .= '</span>
				<span style="float: right; font-size: 13px; color: gray;">'.$repliesr.' votes</span>';
	return $output;
}


?>