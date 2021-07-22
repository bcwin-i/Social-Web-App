<?php

session_start();
include 'database_of.php';
include 'calls.php';

$choice_id = $_POST['cn'];
$topic_id = $_POST['cid'];
$id = $_SESSION['user_id'];
$output = '';
$s1 = '1';
$s2 = '2';
$inactive = 'inactive';
$approved = 'approved';

$sqz = "SELECT * FROM vote WHERE id = ? AND status = ?;";
//$result = mysqli_query($connect, $sql);
$stz = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stz, $sqz))
{
	echo "Nai1";
	exit();
}
mysqli_stmt_prepare($stz, $sqz);
mysqli_stmt_bind_param($stz, "is", $topic_id, $inactive);
mysqli_stmt_execute($stz);

$resultz = mysqli_stmt_get_result($stz);
$rowcountz = mysqli_num_rows($resultz);

if($rowcountz > 0)
{
	if($rowz = mysqli_fetch_assoc($resultz))
	{
		if($rowz['contest_type'] == '10')
		{
			$id = user_name($id);
			$sqs = "UPDATE vote_alternatives SET approval = ? WHERE choice = ? AND contest_id = ?;";
			//$result = mysqli_query($connect, $sql);
			$sts = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($sts, $sqs))
			{
				echo "Nai";
				exit();
			}
			mysqli_stmt_prepare($sts, $sqs);
			mysqli_stmt_bind_param($sts, "ssi", $approved, $id, $topic_id);
			
			if(mysqli_stmt_execute($sts))
			{

				$output .= '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
							<img id="snh" src="show_tray.png" height="12" width="12" />
							</span>
							<span style="width: 96%; max-height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
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

				$sqs = "SELECT * FROM vote_alternatives WHERE contest_id = ? AND approval = ?;";
				//$result = mysqli_query($connect, $sql);
				$sts = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sts, $sqs))
				{
					exit();
				}
				mysqli_stmt_prepare($sts, $sqs);
				mysqli_stmt_bind_param($sts, "is", $topic_id, $approved);
				mysqli_stmt_execute($sts);
				$results = mysqli_stmt_get_result($sts);
				$rowcounts = mysqli_num_rows($results);

				if($rowcounts == $rowz['alternatives'])
				{
					list($hours, $minutes) = explode(":", $rowz['duration']);
					date_default_timezone_set('Africa/Accra');
					$current_timestamp = date('Y-m-d H:i:s');

					list($date, $time) = explode(" ", $current_timestamp);
					list($year, $month, $day) = explode("-", $date);
					list($hour, $min, $second) = explode(":", $time);

					$added_min = $min + $minutes;
					$added_hour = $hour + $hours;

					if($added_min > 60)
					{
						$added_min = $added_min - 60;
						$added_hour += 1;
					}
					if($added_hour > 24)
					{
						$added_hour -= 24;
						$day += 1;

						if($month == 2 && $day > 28)
						{
							$day -= 28;
							$month += 1;
						}

						$tdm = array('4', '6', '9', '11');
						if(in_array($month, $tdm) && $day > 30)
						{
							$day -= 30;
							$month += 1;
						}

						$todm = array('1', '3', '5', '7', '8' ,'10' ,'12');
						if(in_array($month, $todm) && $day > 31)
						{
							$day -= 31;
							if($month == '12' && $day > 32)
							{
								$year += 1;
								$month = 1;
							}
							else{
								$month += 1;
							}
						}
					}

					$countdown = $year.'-'.$month.'-'.$day.' '.$added_hour.':'.$added_min.':'.$second;

					$sqa = "UPDATE vote SET status = 'active', countdown = '$countdown' WHERE id = '$topic_id'";
					$resulta = mysqli_query($connect, $sqa);
				}

				echo $output;
				exit();
			}
		}
	}
}


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

$result = mysqli_stmt_get_result($sts);
$rowcount = mysqli_num_rows($result);

if($rowcount < 1)
{
	$sql = "INSERT INTO vote_choice (user_id, contest_id, tries, choice_num) VALUES ( ?, ?, ?, ?);";
	//$result = mysqli_query($connect, $sql);

	$sl = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sl, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($sl, $sql);
	mysqli_stmt_bind_param($sl, "iiii", $id, $topic_id, $s1, $choice_id);
}
else
{
	if($row = mysqli_fetch_assoc($result))
	{
		if($row['choice_num'] != $choice_id)
		{
			if($row['tries'] != '2')
			{
				$sql = "UPDATE vote_choice SET tries = ?, choice_num = ? WHERE user_id = ? AND contest_id = ?;";

				$sl = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sl, $sql))
				{
					exit();
				}
				mysqli_stmt_prepare($sl, $sql);
				mysqli_stmt_bind_param($sl, "iiii", $s2, $choice_id, $id, $topic_id);
			}
			else
			{
				echo "0";
				exit();
			}	
		}
		else
		{
			echo "0";
			exit();
		}

	}
}

if(mysqli_stmt_execute($sl))
{
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
							'.vo_re($topic_id).'
						</span>';
}
else{
	echo "0";
	exit();
}

echo $output;

?>