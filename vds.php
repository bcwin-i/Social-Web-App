<?php

session_start();
include 'database_of.php';
$id = $_SESSION['user_id'];

$contest_name = mysqli_real_escape_string($connect, $_POST['contest_name']);
$vote_desc = mysqli_real_escape_string($connect, $_POST['vote_desc']);
$contest_type = mysqli_real_escape_string($connect, $_POST['contest_type']);
$security = mysqli_real_escape_string($connect, $_POST['security']);
$hours = mysqli_real_escape_string($connect, $_POST['hours']);
$minutes = mysqli_real_escape_string($connect, $_POST['minutes']);
$total = mysqli_real_escape_string($connect, $_POST['total']);

$output = '';

if(empty($contest_name) || empty($vote_desc) || empty($contest_type) || empty($security) || empty($hours) || empty($minutes) || $total == '0')
{
		echo "Fill out all fields!";
		exit();
}
else
{
	$conq = "SELECT * FROM vote WHERE contest_name = ?";										
	//$result = mysqli_query($connect, $sql);

	$con = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($con, $conq))
	{
		exit();
	}
	mysqli_stmt_prepare($con, $conq);
	mysqli_stmt_bind_param($con, "s", $contest_name);
	mysqli_stmt_execute($con);

	$resultcon = mysqli_stmt_get_result($con);
	$concheck = mysqli_num_rows($resultcon);
													
	if($concheck > 0){
		echo "Contest name already exist!";
		exit();
	}

	if($hours < 0 || $hours > 24)
	{
		echo "Incrorect hour lenght (24 hrs maximum)";
		exit();
	}
	if($minutes < 0 || $minutes > 60)
	{
		echo "Incrorect minutes lenght (60 mins maximum)";
		exit();
	}
	if($hours == 24 && $minutes > 0)
	{
		echo "Contest duration can have a maximum duration of 24 hours (1 day)!";
		exit();
	}

	$code = '';
	if($security == 'closed')
	{
		$code = mysqli_real_escape_string($connect, $_POST['code']);
		if(empty($code))
		{
			echo "Fill contest code!";
			exit();
		}
		else
		{
			if(strlen($code) < 4 || strlen($code) > 10)
			{
				echo "Contest code must be between 4-10 characters!";
				exit();
			}
			else{
				$code = password_hash($code, PASSWORD_DEFAULT);
			}	
		}
	}

	$option_file = '';

	$num = 0; 

	for($i=1; $i <= $total; $i++)
	{
		$option = mysqli_real_escape_string($connect, $_POST['c_'.$i]);
		if($contest_type == '4' && !empty($_FILES['via_'.$i]))
		{
			$option_file = $_FILES['via_'.$i];
		}

		if($contest_type == '10')
		{
			$contestant = mysqli_real_escape_string($connect, $_POST['c_'.$i]);
			$cv = "SELECT * FROM log WHERE uid=?";										
			//$result = mysqli_query($connect, $sql);

			$cvq = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($cvq, $cv))
			{
				exit();
			}
			mysqli_stmt_prepare($cvq, $cv);
			mysqli_stmt_bind_param($cvq, "s", $contestant);
			mysqli_stmt_execute($cvq);

			$resultcv = mysqli_stmt_get_result($cvq);
			$reultcheck = mysqli_num_rows($resultcv);
													
			if($reultcheck < 1)
			{
				echo "Contestant ".$i." name unkown!";
				exit();
			}
		}

		$repc = 0;
		for($c = 1; $c <= $total; $c++)
		{
			$alt =  mysqli_real_escape_string($connect, $_POST['c_'.$i]);
			$alt2 =  mysqli_real_escape_string($connect, $_POST['c_'.$c]);
			if($alt == $alt2)
			{
				$repc += 1;
			}
		}

		if($repc > 1)
		{
			echo "Repeated alternative!";
			exit();
		}

		if(!empty($option) || !empty($option_file))
		{
			$num += 1;
		}
	}

	if($num != $total)
	{
		echo "Fill out all alternative fields!";
		exit();
	}

	if(strlen($contest_name) < 3)
	{
		echo "Contest name too short!";
		exit();
	}

	if(strlen($contest_name) > 70)
	{
		echo "Contest name too long!";
		exit();
	}

	if(strlen($vote_desc) < 5)
	{
		echo "Contest description too short!";
		exit();
	}	

	$duration = $hours.':'.$minutes;
	$status = 'inactive';

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

	$countdown = '';

	if($contest_type == '4')
	{
		$status = 'active';
		$countdown = $year.'-'.$month.'-'.$day.' '.$added_hour.':'.$added_min.':'.$second;
	}

	$sql = "INSERT INTO vote (user_id,contest_name, contest_desc, contest_type, alternatives, security, contest_code, duration, countdown ,status) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	//$insert = mysqli_query($connect, $sql);

	$sti = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sti, $sql))
	{
		echo "Error!";
		exit();
	}
	mysqli_stmt_prepare($sti, $sql);
	mysqli_stmt_bind_param($sti, "issiisssss", $id, $contest_name, $vote_desc, $contest_type, $total, $security, $code, $duration, $countdown, $status);

	if(mysqli_stmt_execute($sti))
	{
		$rsq = "SELECT * FROM vote WHERE contest_name = ?";										
		//$result = mysqli_query($connect, $sql);

		$rs = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($rs, $rsq))
		{
			exit();
		}
		mysqli_stmt_prepare($rs, $rsq);
		mysqli_stmt_bind_param($rs, "s", $contest_name);
		mysqli_stmt_execute($rs);

		$rsr = mysqli_stmt_get_result($rs);
		$rsc = mysqli_num_rows($rsr);

		if($rsc > 0)
		{
			if($row = mysqli_fetch_assoc($rsr))
			{
				$contest_id = $row['id'];
				$file = '';

				for($s = 1; $s <= $total; $s++)
				{
					$file = '';
					if($contest_type == '4' && !empty($_FILES['via_'.$s]))
					{
						$_source_path = $_FILES['via_'.$s]['tmp_name'];
				  		$temp =  $_FILES['via_'.$s]['name'];
				  		$fileExt = explode('.', $temp);
				  		$fileActualExt = strtolower(end($fileExt));

				  		$fileNameNew = $row['id'].$s.".".$fileActualExt;

				  		$target_path = 'Files/Forum_uploads/Vote/' . $fileNameNew;

				  		if(move_uploaded_file($_source_path, $target_path))
						{
							$file = $fileNameNew;
						}
					}

					$choice = mysqli_real_escape_string($connect, $_POST['c_'.$s]);
					$min = "INSERT INTO vote_alternatives ( contest_id, option_number, choice, file) VALUES ( ?, ?, ?, ?);";
					//$insert = mysqli_query($connect, $sql);

					$mi = mysqli_stmt_init($connect);

					if(!mysqli_stmt_prepare($mi, $min))
					{
						echo "Error!";
						exit();
					}
					mysqli_stmt_prepare($mi, $min);
					mysqli_stmt_bind_param($mi, "iiss", $contest_id, $s, $choice, $file);
					mysqli_stmt_execute($mi);				
				}

			}
		}										
	}
}


echo $output;
?>