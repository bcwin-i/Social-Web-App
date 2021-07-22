<?php
session_start();
include 'database_of.php';
include 'calls.php';
$id = $_SESSION['user_id'];

$topic_id = $_POST['tid'];
$s1 = '2';

$sql = "SELECT * FROM events WHERE id = ?";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	echo "None";
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "i", $topic_id);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

$output = '';

$output .= '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
				<img id="snh" src="show_tray.png" height="12" width="12" />
			</span>
			<span style="width: 96%; height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
				<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right; border-bottom: 1px solid #F4F4F4; overflow: ">
					<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
						<span >
							<span id="add_forum" style="font-size: 12px; float:left;"><span class="back_to_event" style="color: #B81D1A; opacity: 0.5; font-weight: bold; cursor:pointer;">
								Events
							</span>
							<span style="color: #B3B3B3; font-size: 12px;"><span style="font-family: monospace; font-weight: bold; font-size: 10px; margin: 0px 3px;">-</span>Title</span>
							</span>
						</span>
						<img style="float: right;" src="event_whole.png" height=50 width=50>
					</span>
				</span>';

while($row = mysqli_fetch_assoc($result))
{
	//<span class="pivi" hidden>'.$pin.''.$trash.'</span>
	//<span style="font-size: 15px; width: 100%; margin-top: 10px; float:left;">'.$file.'</span>
	$query = "SELECT * FROM replies WHERE category_id = '2' AND topic_id = '".$row['id']."' ORDER BY `date` DESC";
	$submit = mysqli_query($connect, $query); 
	$rowcount = mysqli_num_rows($submit);

	if($rowcount > 1)
	{
		$rowcount = $rowcount.' comments';
	}
	else{
		$rowcount = $rowcount.' comment';
	}

	$row['event_title'] = str_replace("\'", "'", $row['event_title']);
	$row['event_desc'] = str_replace("\'", "'", $row['event_desc']);
	$row['event_desc'] = str_replace(" ", "&nbsp", $row['event_desc']);
	$row['event_desc'] = str_replace('\n', "\n", $row['event_desc']);
	$row['event_desc'] = str_replace('\r', "\r", $row['event_desc']);

	if($row['file'] == 0)
	{
		$file = '';
	}
	else
	{

		$sqf = "SELECT * FROM event_poster WHERE user_id = '".$row['user_id']."' AND event_name = '".$row['event_title']."'";
		$resultf = mysqli_query($connect, $sqf);

		if($rowf = mysqli_fetch_assoc($resultf))
		{
			$file = $rowf['file'];
		}
			
	}

	$pin = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ? AND user_id = ?;";
	//$qp = mysqli_query($connect, $pin);
 	$stq = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stq, $pin))
	{
		exit();
	}
	mysqli_stmt_prepare($stq, $pin);
	mysqli_stmt_bind_param($stq, "iii", $s1, $topic_id, $id);
	mysqli_stmt_execute($stq);
	$qp = mysqli_stmt_get_result($stq);

	$rqp = mysqli_num_rows($qp);

	if($rqp < 1)
	{
		$pin = '<img id="'.$row['id'].'_2" style="cursor: pointer;" title="pin topic" class="pin" src="pin_fac.png" height="12" width="12" />';
	}
	else
	{
		$pin = '<img id="'.$row['id'].'_2" style="cursor: pointer;" title="upin topic" class="pin" src="unpin_fac.png" height="12" width="12" />';	
	}

	$trash = '';
	if($row['user_id'] == $id)
	{
		$trash = '<img id="'.$row['id'].'_2" style="cursor: pointer; margin-left: 5px;" title="delete topic" class="dto" src="trash.png" height="13" width="13" />';
	}

	$current_timestamp = date('Y-m-d H:i:s');
	$status = '';

	if($row['end'] > $current_timestamp AND $current_timestamp < $row['start'])
	{
		$status = '<span style="position: absolute; right: 0%; top: 0%; color: #95E88E; font-family: monospace; font-weight: bold; font-size: 15px; cursor: pointer;" title="'.ut($row['start']).'">
						<span style="font-style: italic;"><img src="upcoming.png" height=29 width=68 title="'.toTime(cut($row['start'])).'"></span> 
					</span>';
	}
	
	elseif ($row['end'] > $current_timestamp AND $current_timestamp > $row['start'])
	{
		$status = '<span style="position: absolute; right: 0%; top: 0%; color: #95E88E; font-family: monospace; font-weight: bold; font-size: 15px; cursor: pointer;" title="'.ut($row['end']).'">
						<span style="font-style: italic;"><img src="live.png" height=20 width=50 title="'.toTime(cut($row['end'])).'"></span> 
					</span>';
	}
	elseif ($row['end'] < $current_timestamp) 
	{
		$status = '<span style="position: absolute; right: 0%; top: 0%; color: #95E88E; font-family: monospace; font-weight: bold; font-size: 15px; cursor: pointer;" title= "'.ut($row['end']).'">
						<span style="font-style: italic;"><img src="past.png" height=20 width=45 title="'.agoTime(cut($row['end'])).'"></span> 
					</span>';
	}

	$output .= '<span style="float: left; width:100%; margin:0px; margin-top: 10px; max-height: 88%; overflow: scroll; margin-bottom: 0px;">
					<span ="width: 100%; float: left;">	
						<span style="font-family: verdana; font-size: 13px; font-weight: bold; color: #4D4D4D; vertical-align: middle; width: 75%; float:left;">
							<img style="border-radius: 50%;" src="Files/Profile/profile'.$row['user_id'].'.jpg" height="32" width="32">
							<span style="vertical-align: 70%; margin-left: 5px;">'.user_name($row['user_id']).'</span>
						</span>
						<span style="font-size: 8px; color: #CCCCCC; float: right; width: 25%;">
							<span style="float:right;">
								<span style="font-size: 11px; color: gray; font-family: Calibri; margin-left: 5px;">
									'.ut($row['date']).'
									<span class="pivi" hidden>'.$pin.''.$trash.'</span>
									<img class="option_pin" src="option.png" height="10" width="11" />
								</span>
							</span>
						</span>
					</span>
					<span style="width: 98%; float: left; margin: 0px 1%; margin-top: 20px; font-family: Calibri;  color: #4D4D4D;">
						<span style="font-size: 17px; font-weight: bold; width: 100%; float:left;">
							<span style="width: 70%; float: left;">
								'.$row['event_title'].'
							</span>
							<span style="width: 30%; float: right;">
								<span style="max-width: 100%; margin-top: 2px; float: right; color: gray; font-size: 12px; font-weight: lighter;">
									'.$row['location'].'
									<img src="loc.png" style=" opacity: 0.5; margin-bottom: -2px; margin-left: 3px;" height=14 width=14 />
								</span>
							</span>
						</span>
						<span style="font-size: 15px; width: 100%; margin-top: 10px; float:left;">'.nl2br($row['event_desc']).'</span>
						<span style="width: 100%; max-height: 100%; margin: 10px 0px; margin-bottom: 15px; float: right; position: relative;">
							'.$file.'
							'.$status.'
						</span>
						<span id='.$row['id'].'  class="reply-link_e">
							<span class="num_of_e" style="float: left; color: #BFBFBF; font-family: monospace; font-size: 12px;">
								'.$rowcount.'
							</span>
							<span style="float: right;">comment</span>
						</span>
						<span class="f_r_e" style="style="width: 98%; margin: 1% 1%;" hidden>
							<span id="fac_ee" class="a_reply" method="POST" action="upfre.php">
									<form method="POST">
										<textarea class="reply_desc_e" id="txta" name="event_reply" placeholder="comment:" required></textarea>
										<label class="issetfr" for="ffre">
											<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />
										</label>
										<input type="file" style="display: none;" name="file" id="ffre" accept=".jpg, .gif, .mp4" />
										<input type = "hidden" name = "id" value = '.$row['id'].'>
										<span class="changee" style="float: left; margin-left: 2px;"></span>
									</form>
							</span>
						</span>
						<span class="replies_repe" style="width: 98%; margin: 0%; padding: 0% 1%; margin-bottom: 0%; border-top: 1px solid #F0F0F0; float:left; max-height: 60%; overflow-x: hidden; overflow-y: scroll;">';
							while($rowr = mysqli_fetch_assoc($submit))
							{
								$rowr['comment'] = str_replace("\'", "'", $rowr['comment']);
								$rowr['comment'] = str_replace('\n', "\n", $rowr['comment']);
								$rowr['comment'] = str_replace('\r', "\r", $rowr['comment']);

								if($rowr['user_id'] == $id)
								{
									$sid = $rowr['id']."_".$rowr['topic_id'];
									$del = '<span id= '.$sid.'  class="dlre" style="color: #CCCCCC; float:left; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana; cursor:pointer;">Delete</span>';
								}
								else{
									$del = '';
								}
								$output .= '<span style="width: 95%; float: right; border-bottom: 0.5px solid #F0F0F0;">
												<span style="width: 100%; float: right;">
													<span style="font-size: 10px; float: right; font-family: verdana; color: gray;">
														<span style="color: #CCCCCC; font-family: Calibri; padding-right: 5px; font-size: 10px; font-style: italic;">posted by
														</span>
														'.user_name($rowr['user_id']).'
													</span>
													<span style="font-size: 14px; width: 100%; float:left; font-family: Calibri;  	color: #4D4D4D; margin-top: 8px; margin-bottom: 4px;">
														'.nl2br($rowr['comment']).'
													</span>
													<span style="width: 100%; float:left; margin-bottom: 3px;">
														'.$rowr['file'].'
													</span>
													<span style="width: 100%; float: left;">
														'.$del.'
														<span style="color: #CCCCCC; float:right; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana;" title="'.ut($rowr['date']).'">
															'.ut($rowr['date']).'
														</span>
													</span>
												</span>
											</span>';
							}
		$output.=		'</span>	
						</span>
				</span>';
}

		$queryr = "SELECT * FROM replies WHERE category_id = ? AND topic_id = ?;";
		//$submit = mysqli_query($connect, $query); 
		$stqrr = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($stqrr, $queryr))
		{
			exit();
		}
		mysqli_stmt_prepare($stqrr, $queryr);
		mysqli_stmt_bind_param($stqrr, "ii", $s1, $topic_id);
		mysqli_stmt_execute($stqrr);
		$submitr = mysqli_stmt_get_result($stqrr);
		$repliesr = mysqli_num_rows($submitr);	

		$querys = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ? AND user_id = ?;";
		//$submits = mysqli_query($connect, $querys); 
		$stqrs = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($stqrs, $querys))
		{
			exit();
		}
		mysqli_stmt_prepare($stqrs, $querys);
		mysqli_stmt_bind_param($stqrs, "iii", $s1, $topic_id, $id);
		mysqli_stmt_execute($stqrs);
		$submits = mysqli_stmt_get_result($stqrs);

		while($row = mysqli_fetch_assoc($submits)){
			$sqli = "UPDATE forum_notification_request SET previous = '$repliesr' WHERE id = ".$row['id']."";
			$inserti = mysqli_query($connect, $sqli);

			$sqlc = "UPDATE forum_notification_request SET current = '$repliesr' WHERE id = ".$row['id']."";
			$insertc = mysqli_query($connect, $sqlc);
		}

$output .= '</span>';

echo $output;

?>