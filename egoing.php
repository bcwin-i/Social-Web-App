<?php
include 'database_of.php';
include 'calls.php';
session_start();

$id = $_SESSION['user_id'];
$s2 = '2';
$current_timestamp = date('Y-m-d H:i:s');
$output = '';

$sql = "SELECT * FROM forum_notification_request WHERE user_id = ? AND cat_id = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "ii", $id, $s2);
mysqli_stmt_execute($st);
$result = mysqli_stmt_get_result($st);

$output .= '<span style="height: 3.5%; width: 100%; float: left;  margin-top: 5px;">
								<table style="text-align: left; font-family: monospace; width: 100%;">
									<tr><td style="width:60%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Event</td>
										<td style="width:20%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Fame</td>
										<td style="width:20%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Status</td>
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
		$query = "SELECT * FROM replies WHERE category_id = '2' AND topic_id = '".$row['topic_id']."'";
		$submit = mysqli_query($connect, $query); 
		$replies = mysqli_num_rows($submit);	 

		$st = start($row['topic_id']);
		$fr = ending($row['topic_id']);

		if($fr > $current_timestamp && $st < $current_timestamp)
		{
			$fr = '<span style="color:#95E88E;">Live in </span>'.toTim(cut($fr));
		}
		elseif ($fr > $current_timestamp && $st > $current_timestamp) 
		{
			$fr = 'Upcoming on '.toTim(cut($fr));
		}
		elseif ($fr < $current_timestamp && $st < $current_timestamp) {
			$fr = '<span style="color: #B81D1A; opacity: 0.5; margin: 0px; width: 100%; float: left; padding: 0px; height: 17px; ">Closed at </span><span style ="width: 100%; float: left; margin: 0px;">'.ut($fr).'</span>';
		}
							
		$output .=  '<tr style="line-height: 40px;">
						<td style="border-top: 0.5px solid #F0F0F0; width: 100%; height: 100%; ">
							<span style="height: 100%; width: 60%; float: left;">
								<div class="event_link" id='.$row['topic_id'].' style="width:100%; cursor:pointer; height: 28px; margin:0px; color:gray; font-size: 17px; vertical-align: top;  overflow:hidden;">'.title($row['topic_id']).'
								</div>
							</span>
							<span style="width:20%; display:inline; float:left; color: gray; font-size: 13px;">
								'.$replies.'
							</span>
							<span style="width:20%; color: gray; float:right; display:inline; font-size: 13px;">
								'.$fr.'
							</span>
						</td>
					</tr>';
	}
	$output .= '</table>';
}
$output .= '<span>';

function title($title){
	include 'database_of.php';
	$sqlt = "SELECT * FROM events WHERE id = '$title'";
	$resultt = mysqli_query($connect, $sqlt);

	if($rowt = mysqli_fetch_assoc($resultt))
	{
		$rowt['event_title'] = str_replace("\'", "'", $rowt['event_title']);
		return $rowt['event_title'];
	}
}

function start($title){
	include 'database_of.php';
	$sqlt = "SELECT * FROM events WHERE id = '$title'";
	$resultt = mysqli_query($connect, $sqlt);

	if($rowt = mysqli_fetch_assoc($resultt))
	{
		return $rowt['start'];
	}
}

function ending($id){
	include 'database_of.php';

	$sql = "SELECT * FROM events WHERE id = '$id'";
	$result = mysqli_query($connect, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		return $row['end'];
	}

}


echo $output;

?>