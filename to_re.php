<?php
session_start();
include 'database_of.php';
include 'calls.php';
$id = $_SESSION['user_id'];

$topic_id = $_POST['tid'];
$cat_id = $_POST['cat'];
$s1 = $cat_id;

if($cat_id == '1')
{
	$src = 'opentw';
	$col = '#2D4157';
	$cn = 'Open Topic';
}
elseif ($cat_id == '2') {
	$src = 'fhw';
	$col = '#38AB26';
	$cn = 'Food & Health';
}
elseif ($cat_id == '3') {
	$src = 'hmjw';
	$col = '#F4C515';
	$cn = 'Humor & Jokes';
}
elseif ($cat_id == '4') {
	$src = 'prw';
	$col = '#435987';
	$cn = 'Politics & Religion';
}
elseif ($cat_id == '5') {
	$src = 'pdw';
	$col = '#267CAB';
	$cn = 'Programming & Design';
}

$sql = "SELECT * FROM topics WHERE id = ?";
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
$output .= '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
					<img id="snh" src="show_tray.png" height="12" width="12" />
			</span>
			<span style="width: 96%; max-height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
						<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right; border-bottom: 2px solid #F4F4F4; overflow: hidden;">
								<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
									<span >
										<span id="add_forum" style="font-size: 12px; float:left;"><span class="back_to_faculty" style="color: #429AA4; font-weight: bold; cursor:pointer;">Home</span><span style="color: #B3B3B3; font-size: 12px;"><span style="font-family: monospace; font-weight: bold; font-size: 10px; margin: 0px 3px;">-</span><span class="cat-t" id='.$cat_id.' style="color: '.$col.'; cursor: pointer;">'.$cn.'</span><span style="font-family: monospace; font-weight: bold; font-size: 10px; margin: 0px 3px;">-</span>Topics</span>
										</span>
									</span>
									<img style="float: right;" src="'.$src.'.png" height=58 width=58>
									<img style="float: right;" src="q&a_whole.png" height=22 width=22></span>
						</span>
						<span class="faculty_view" style="max-height: 88%; width: 100%; float: right;">';

while($row = mysqli_fetch_assoc($result))
{
	$query = "SELECT * FROM replies WHERE category_id = ".$cat_id." AND topic_id = '".$row['id']."' ORDER BY `date` DESC";
	$submit = mysqli_query($connect, $query); 
	$rowcount = mysqli_num_rows($submit);

	if($rowcount > 1)
	{
		$rowcount = $rowcount.' comments';
	}
	else{
		$rowcount = $rowcount.' comment';
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
		$pin = '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer;" title="pin topic" class="pin" src="pin_fac.png" height="12" width="12" />';
	}
	else
	{
		$pin = '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer;" title="upin topic" class="pin" src="unpin_fac.png" height="12" width="12" />';	
	}

	$trash = '';
	if($row['user_id'] == $id)
	{
		$trash = '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer; margin-left: 5px;" title="delete topic" class="dto" src="trash.png" height="13" width="13" />';
	}

	if(!empty($row['file']))
	{
		$file = $row['file'];
	}
	else{
		$file = '';
	}

	$row['topic_title'] = str_replace("\'", "'", $row['topic_title']);
	$row['topic_desc'] = str_replace("\'", "'", $row['topic_desc']);
	$row['topic_desc'] = str_replace('\n', "\n", $row['topic_desc']);
	$row['topic_desc'] = str_replace('\r', "\r", $row['topic_desc']);

	$output .= '<span style="float: left; width:100%; margin:0px; margin-top: 10px; max-height: 100%; overflow: scroll; margin-bottom: 0px;">
					<span ="width: 100%; float: left;">	
						<span style="font-family: verdana; font-size: 13px; font-weight: bold; color: #1A636B; vertical-align: middle; width: 68%; float:left;">
							<img style="border-radius: 50%;" src="Files/Profile/profile'.$row['user_id'].'.jpg" height="32" width="32">
							<span style="vertical-align: 70%; margin-left: 5px;">'.user_name($row['user_id']).'</span>
						</span>
						<span style="font-size: 11px; color: #CCCCCC; float: right; width: 32%;">
							<span style="float:right;">
								<span style="font-size:11px; color: #1A636B; font-family: Calibri; margin-left: 5px;">
									'.ut($row['date']).'
									<span class="pivi" hidden>'.$pin.''.$trash.'</span>
									<img class="option_pin" src="option.png" height="10" width="11" />
								</span>
							</span>
						</span>
					</span>
					<span style="width: 98%; float: left; margin: 0px 1%; margin-top: 20px; font-family: Calibri;  color: #4D4D4D;">
						<span style="font-size: 17px; font-weight: bold; width: 100%; float:left;">'.$row['topic_title'].'</span>
						<span style="font-size: 15px; width: 100%; margin-top: 10px; float:left;">'.nl2br($row['topic_desc']).'</span>
						<span style="font-size: 15px; width: 100%; margin-top: 10px; float:left;">'.$file.'</span>
					</span>
					<span id='.$row['id'].' data-cat='.$cat_id.' class="reply-link">
					<span class="num_of" style="float: left; color: #BFBFBF; font-family: monospace; font-size: 12px;">
						'.$rowcount.'
					</span>
					<span style="float: right;">comment</span></span>
					<span class="f_r_a" style="style="width: 98%; margin: 1% 1%;" hidden>
						<span id="fac_re" class="a_reply" method="POST" action="upfr.php">
								<form method="POST">
									<input type="hidden" value='.$cat_id.' name="cat">
									<textarea class="reply_desc" id="txta" name="topic_reply" placeholder="comment:" required></textarea>
									<label class="issetfr" for="ffr">
										<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />
									</label>
									<input type="file" style="display: none;" name="file" id="ffr" accept=".pdf, .jpg, .png, .gif" />
									<input type = "hidden" name = "id" value = '.$row['id'].'>
									<span class="change" style="float: left; margin-left: 2px;">comment</span>
								</form>
						</span>
					</span>
					<span class="replies_rep" style="width: 98%; margin: 0%; padding: 0% 1%; margin-bottom: 5%; border-top: 1px solid #F0F0F0; float:left; max-height: 60%; overflow-x: hidden; overflow-y: scroll;">';
						while($rowr = mysqli_fetch_assoc($submit))
						{
							$rowr['comment'] = str_replace("\'", "'", $rowr['comment']);
							$rowr['comment'] = str_replace(" ", "&nbsp", $rowr['comment']);
							$rowr['comment'] = str_replace('\n', "\n", $rowr['comment']);
							$rowr['comment'] = str_replace('\r', "\r", $rowr['comment']);
							if($rowr['user_id'] == $id)
							{
								$sid = $rowr['id']."_".$rowr['topic_id']."_".$cat_id;
								$del = '<span id= '.$sid.'  class="dlr" style="color: #CCCCCC; float:left; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana; cursor:pointer;">Delete</span>';
							}
							else{
								$del = '';
							}
							$output .= '<span style="width: 95%; float: right; border-bottom: 0.5px solid #F0F0F0;">
											<span style="width: 100%; float: right;">
												<span style="font-size: 10px; float: right; font-family: verdana; color: gray;">
													<span style="color: #CCCCCC; font-family: Calibri; padding-right: 5px; font-size: 10px;">posted by
													</span>
													'.user_name($rowr['user_id']).'
												</span>
												<span style="font-size: 14px; width: 100%; float:left; font-family: Calibri;  	color: #4D4D4D; margin-top: 8px; margin-bottom: 4px;">
													'.nl2br($rowr['comment']).'
												</span>
												<span style="width: 100%; float:left; margin-bottom: 3px;">
													'.$rowr['file'].'
												</span>
												'.$del.'
												<span style="color: #CCCCCC; float:right; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana;" title="'.ut($rowr['date']).'">
													'.ut($rowr['date']).'
												</span>
											</span>
										</span>';
						}
		$output .=	'</span>	
				</span>';
				
		$query = "SELECT * FROM replies WHERE category_id = ? AND topic_id = ?;";
		//$submit = mysqli_query($connect, $query); 
		$stqr = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($stqr, $query))
		{
			exit();
		}
		mysqli_stmt_prepare($stqr, $query);
		mysqli_stmt_bind_param($stqr, "ii", $cat_id, $topic_id);
		mysqli_stmt_execute($stqr);
		$submit = mysqli_stmt_get_result($stqr);
		$replies = mysqli_num_rows($submit);	

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
			$sqli = "UPDATE forum_notification_request SET previous = '$replies' WHERE id = ".$row['id']."";
			$inserti = mysqli_query($connect, $sqli);

			$sqlc = "UPDATE forum_notification_request SET current = '$replies' WHERE id = ".$row['id']."";
			$insertc = mysqli_query($connect, $sqlc);
		}
}


echo $output;

?>