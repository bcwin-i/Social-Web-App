<?php

include 'database_of.php';
include 'calls.php';

session_start();

$id = $_SESSION['user_id'];
$s1 = '1';
$s2 = '2';

$output = '<img src="rater_not_off.png" style="position: absolute; top: 0px; right: 0px; opacity: 0.5; margin: 2px;" height=12 width=12>';
$output .= '<table id="frmf" class="ml-space" style="margin: 5px; margin-bottom: 0px;">';

$sql = "SELECT * FROM forum_notification_request WHERE current > previous AND user_id = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "i", $id);
mysqli_stmt_execute($st);
$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

$sqlf = "SELECT * FROM forum_notification_request WHERE current > previous AND user_id = ?;";
//$result = mysqli_query($connect, $sql);
$stf = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sqlf))
{
	exit();
}
mysqli_stmt_prepare($stf, $sqlf);
mysqli_stmt_bind_param($stf, "i", $id);
mysqli_stmt_execute($stf);
$resultf = mysqli_stmt_get_result($stf);
$rowcountf = mysqli_num_rows($resultf);

/*$sqle = "SELECT * FROM forum_notification_request WHERE current > previous AND user_id = ?;";
//$result = mysqli_query($connect, $sql);
$ste = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($ste, $sqle))
{
	exit();
}
mysqli_stmt_prepare($ste, $sqle);
mysqli_stmt_bind_param($ste, "i", $id);
mysqli_stmt_execute($ste);
$resulte = mysqli_stmt_get_result($ste);
$rowcounte = mysqli_num_rows($resulte);*/

if($rowcount < 1)
{
	$output .= '<tr>
					<td class="m_title"><span style="color: gray; font-family: Calibri;">
						empty!
					</td>
				</tr>';
}
else
{

	if($rowcountf != 0)
	{
		$output .= '<tr>
						<td class="m_title">
							<span style="color: gray; font-family: Calibri; font-size: 12px;">
								Faculty notification
							</span>
						</td>
					</tr>';
		while($row = mysqli_fetch_assoc($resultf))
		{
			$topic_id = $row['topic_id'];
			if(col($topic_id) == '1'){
				$col = '#2D4157';
			}
			elseif (col($topic_id) == '2') {
				$col = '#38AB26';
			}
			elseif (col($topic_id) == '3') {
				$col = '#F4C515';
			}
			elseif (col($topic_id) == '4') {
				$col = '#435987';
			}
			elseif (col($topic_id) == '5') {
				$col = '#267CAB';
			}

			$unseen = $row['current'] - $row['previous'];
			$output .= '<tr>
							<td id="'.$topic_id.'" class="rule_m" width="100%">
								<span class="topic_link" id='.$topic_id.' data-cat= "'.col($topic_id).'" style="width: 90%; float: left; color: '.$col.'; cursor:pointer; font-size: 15px;">
									'.topic_t($topic_id).'
								</span>
								<span style="width: 10%; float: right; font-family: monospace; color: gray; font-weight: bold; font-size:12px; margin-top: 2px;">
									<span style="float: right;">
										'.$unseen.'
									</span>
								</span>
							</td>
						</tr>';
		}
	}
	/*if($rowcounte != 0)
	{
		$output .= '<tr>
					<td class="m_title">
						<span style="color: gray; font-family: Calibri; font-size: 12px;">
							Events notification
						</span>
					</td>
				</tr>';
		while($row = mysqli_fetch_assoc($resulte))
		{
			$topic_id = $row['topic_id'];
			$unseen = $row['current'] - $row['previous'];
			$output .= '<tr>
							<td id="'.$topic_id.'" class="rule_m" width="100%">
								<span class="event_link" id='.$topic_id.' style="width: 90%; float: left; color: #B81D1A; opacity: 0.5; cursor:pointer; font-size: 15px;">
									'.topic_e($topic_id).'
								</span>
								<span style="width: 10%; float: right; font-family: monospace; color: gray; font-style: italic; font-weight: bold; font-size:12px; margin-top: 2px;">
									<span style="float: right;">
										'.$unseen.'
									</span>
								</span>
							</td>
						</tr>';
		}
	}*/
}


$output .= '</table>';
echo $output;

function topic_t($title)
{
	include 'database_of.php';
	$sql = "SELECT * FROM topics WHERE id = ?;";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);
	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $title);
	mysqli_stmt_execute($st);
	$result = mysqli_stmt_get_result($st);

	while($row = mysqli_fetch_assoc($result)){
		$row['topic_title'] = str_replace("\'", "'", $row['topic_title']);
		return $row['topic_title'];
	}
}


function col($title)
{
	include 'database_of.php';
	$sql = "SELECT * FROM topics WHERE id = ?;";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);
	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $title);
	mysqli_stmt_execute($st);
	$result = mysqli_stmt_get_result($st);

	while($row = mysqli_fetch_assoc($result)){
		return $row['category_id'];
	}
}

function topic_e($title)
{
	include 'database_of.php';
	$sql = "SELECT * FROM events WHERE id = ?;";
	//$result = mysqli_query($connect, $sql);
	$st = mysqli_stmt_init($connect);
	if(!mysqli_stmt_prepare($st, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sql);
	mysqli_stmt_bind_param($st, "i", $title);
	mysqli_stmt_execute($st);
	$result = mysqli_stmt_get_result($st);

	while($row = mysqli_fetch_assoc($result)){
		$row['event_title'] = str_replace("\'", "'", $row['event_title']);
		return $row['event_title'];
	}
}

?>