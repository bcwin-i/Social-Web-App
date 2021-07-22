<?php
session_start();
include 'database_of.php';
include 'calls.php';

$password = mysqli_real_escape_string($connect, $_POST['password']);
$topic_id = mysqli_real_escape_string($connect, $_POST['tid']);

date_default_timezone_set('Africa/Accra');
$current_timestamp = date('Y-m-d H:i:s');

if(empty($password))
{
	echo "0";//Empty field!
	exit();
}
$sql = "SELECT * FROM vote WHERE id=?";										
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

	$hashedPwdCheck = password_verify($password, $row['contest_code']);
}
					
if($hashedPwdCheck == false){
	echo "1";//Code mismatch!
	exit();
}
else{
	if($current_timestamp > $row['countdown'])
	{
		access($topic_id);
		$output = '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
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
								'.coco($topic_id).'
							</span>';
	}
	else
	{

		$output = '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
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
								'.vo_re($topic_id).'
							</span>';
	}
}

echo $output;

?>