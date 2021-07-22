<?php
session_start();
include 'database_of.php';
include 'calls.php';
$id = $_SESSION['user_id'];
date_default_timezone_set('Africa/Accra');
$current_timestamp = date('Y-m-d H:i:s');

$topic_id = $_POST['tid'];

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

if($row = mysqli_fetch_assoc($result)){
	if($row['security'] == 'closed')
	{
		$security = '<span style="float: left; width:100%; margin:0px; margin-top: 10px; height: 100%; overflow: scroll; margin-bottom: 0px; font-family: Calibri; color: #1E2D38">		
						<span style="width: 100%; float: left;">
							Enter contest code ..
						</span>
						<form method="POST" id="vot_cv" action="vot_cv.php" onsubmit="return false;">
							<span style="width: 70%; float: left; margin-top: 3px;">
								<input type="password" name="password" class="contest_code" id="contest_code" placeholder="code..">
							</span>
							<span style="width: 30%; float: right; margin-top: 12px; ">
								<button class="code_sub">submit</button>
							</span>
							<span style="width: 56%; float: left; margin-top: 10px; font-size: 13px;">
								<input id="view" type="checkbox" style="margin: 0px;">
								<input name="tid" type="hidden" value = '.$topic_id.'>
								<label id="view2" for="view" style="padding-top: -25px;">view code</label>
								<span class="error" style="float: right;" hidden>code mismatch</span>
							</span>
						</form>
					</span>';
	}
	else{
		if($current_timestamp > $row['countdown'] && $row['status'] == 'Active' || $row['status'] == 'Complete')
		{
			access($topic_id);
			$security = coco($topic_id);
		}
		else
		{
			$security = vo_re($topic_id);
		}
	}
}

$output = '';
$output .= '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
					<img id="snh" src="show_tray.png" height="12" width="12" />
			</span>
			<span style="width: 96%; height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
						<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right; border-bottom: 2px solid #F4F4F4; overflow: hidden;">
								<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
									<span >
										<span id="add_forum" style="font-size: 12px; float:left;"><span class="back_to_vo" style="color: #1E2D38; font-weight: bold; cursor:pointer; font-family: verdana; font-size: 10px;">VOTE</span><span style="color: #B3B3B3; font-size: 12px;"><span style="font-family: monospace; font-weight: bold; font-size: 10px; margin: 0px 3px;">-</span>Contest</span>
										</span>
									</span>
									<img style="float: right;" src="vote_whole.png" height=59 width= 100/>
								</span>
						</span>
						<span class="faculty_view" style="height: 88%; width: 100%; float: right;">
							'.$security.'
						</span>';

echo $output;