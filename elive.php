<?php
include 'database_of.php';
include 'calls.php';
$current_timestamp = date('Y-m-d H:i:s');
$output = '';

$sql = "SELECT * FROM events WHERE  start <= '$current_timestamp' AND `end` > '$current_timestamp' ORDER BY `end` ASC";
$result = mysqli_query($connect, $sql);
$output .= '<span style="height: 3.5%; width: 100%; float: left;  margin-top: 5px;">
								<table style="text-align: left; font-family: monospace; width: 100%;">
									<tr><td style="width:60%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Event</td>
										<td style="width:20%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Started</td>
										<td style="width:20%; color: #B81D1A; opacity: 0.5; font-size: 13px; font-weight: bold;">Closing</td>
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
		/*$query = "SELECT * FROM replies WHERE category_id = '1' AND topic_id = '".$row['id']."'";
		$submit = mysqli_query($connect, $query); 
		$replies = mysqli_num_rows($submit);*/	 
		$row['event_title'] = str_replace("\'", "'", $row['event_title']);

		$fresh = "SELECT `start` FROM events WHERE id = '".$row['id']."'";
		$submitf = mysqli_query($connect, $fresh);

		if($rows = mysqli_fetch_assoc($submitf))
		{
			$st = $rows['start'];
		}

		$end = "SELECT `end` FROM events WHERE id = '".$row['id']."'";
		$submite = mysqli_query($connect, $end); 	

		if($rowf = mysqli_fetch_assoc($submite))
		{
			$fr = $rowf['end'];
		}
							
		$output .=  '<tr style="line-height: 40px;">
						<td style="border-top: 0.5px solid #F0F0F0; width: 100%; height: 100%; ">
							<span style="height: 100%; width: 60%; float: left;">
								<div class="event_link" id='.$row['id'].' style="width:100%; cursor:pointer; height: 28px; margin:0px; color:gray; font-size: 16px; vertical-align: top;  overflow:hidden;">'.$row['event_title'].'
								</div>
							</span>
							<span style="width:20%; display:inline; float:left; color: gray; font-size: 13px;">
								'.agoTime(cut($st)).'
							</span>
							<span style="width:20%; color: gray; float:right; display:inline; font-size: 13px;">
								'.toTime(cut($fr)).'
							</span>
						</td>
					</tr>';
	}
	$output .= '</table>';
}
$output .= '<span>';

echo $output;

?>