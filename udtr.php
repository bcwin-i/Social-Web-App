<?php
session_start();
include 'database_of.php';
include 'calls.php';
$id = $_SESSION['user_id'];
list($tid, $s1) = explode("_", $_POST['id']);

$query = "SELECT * FROM replies WHERE category_id = ? AND topic_id = ? ORDER BY `date` DESC";
//$submit = mysqli_query($connect, $query); 

$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $query))
{
	exit();
}
mysqli_stmt_prepare($st, $query);
mysqli_stmt_bind_param($st, "ii", $s1, $tid);
mysqli_stmt_execute($st);

$submit = mysqli_stmt_get_result($st);

$output = '';

while($row = mysqli_fetch_assoc($submit))
{
	$row['comment'] = str_replace("\'", "'", $row['comment']);
	$row['comment'] = str_replace(" ", "&nbsp", $row['comment']);
	$row['comment'] = str_replace('\n', "\n", $row['comment']);
	$row['comment'] = str_replace('\r', "\r", $row['comment']);
	if($row['user_id'] == $id)
	{
		$sid = $row['id']."_".$tid;
		$del = '<span id= '.$sid.'  class="dlr" style="color: #CCCCCC; float:left; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana; cursor:pointer;">Delete</span>';
	}
	else
	{
		$del = '';
	}
	$output .= '<span style="width: 95%; float: right; border-bottom: 0.5px solid #F0F0F0;">
					<span style="width: 100%; float: right;">
						<span style="font-size: 10px; float: right; font-family: verdana; color: gray;">
							<span style="color: #CCCCCC; font-family: Calibri; padding-right: 5px; font-size: 10px;">
								posted by
								</span>
								'.user_name($row['user_id']).'
							</span>
							<span style="font-size: 14px; width: 100%; float:left; font-family: Calibri;  	color: #4D4D4D; margin-top: 8px; margin-bottom: 4px;">
								'.nl2br($row['comment']).'
							</span>
							<span style="width: 100%; float:left; margin-bottom: 3px;">
								'.$row['file'].'
							</span>
							'.$del.'
							<span style="color: #CCCCCC; float:right; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana;" title="'.ut($row['date']).'">
								'.ut($row['date']).'
							</span>
						</span>
					</span>';
}

echo $output;

?>