<?php
session_start();
include 'database_of.php';

$id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];
$event_name = mysqli_real_escape_string($connect, $_POST['ten']);
$event_dest = mysqli_real_escape_string($connect, $_POST['ten1']);
$sd = mysqli_real_escape_string($connect, $_POST['ten2']);
$st = mysqli_real_escape_string($connect, $_POST['ten3']);
$cd = mysqli_real_escape_string($connect, $_POST['ten4']);
$ct = mysqli_real_escape_string($connect, $_POST['ten5']);

$st .= ':00';
$ct .= ':00';

date_default_timezone_set('Africa/Accra');
$current_timestamp = date('Y-m-d H:i:s');

$start = $sd." ".$st;
$close = $cd." ".$ct;


if($sd >= $cd || $start < $current_timestamp)
{
	if($sd == $cd && $st < $ct)
	{
		
	}
	else{
		echo "0";//"Invalid date range!";
		exit();
	}
}

$sql = "SELECT * FROM events WHERE event_title = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "s", $event_name);
mysqli_stmt_execute($st);
$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

if($rowcount > 0)
{
	echo "1";//"Event name already exist!";
	exit();
}

if(empty($_FILES))
{
	echo "None";
	exit();
}



if(!empty($_FILES))
{
	if(is_uploaded_file($_FILES['file']['tmp_name']))
 	{
 		$_source_path = $_FILES['file']['tmp_name'];
 		$size = $_FILES['file']['size'];
 		$temp =  $_FILES['file']['name'];
 		$fileExt = explode('.', $temp);
				  
		$fileActualExt = strtolower(end($fileExt));

		$event_name = str_replace("\'", "'", $event_name);

		$fileNameNew = $id.$event_name.'.'.$fileActualExt;

		$dir = 'Files/Forum_uploads/Events/'.$id.$event_name.'*';
		$ddir = glob($dir);
		if($ddir)
		{
			unlink($ddir[0]);
		}
		else
		{
		
		}

		/*$del = 'Files/Forum_uploads/Events/temp/'.$id.$name;
		$path = glob($del);
		if(!unlink($path)){

		}*/

		if($fileActualExt == 'jpg' || $fileActualExt == 'png' || $fileActualExt == 'gif'){

			if($size > 500000000)
			{
				echo "2";//"File size too large! preferred range 0 - 50MB!";
				exit();
			}
			else
			{
				$target_path = 'Files/Forum_uploads/Events/'.$fileNameNew;
				if(move_uploaded_file($_source_path, $target_path))
				{
					$file = '<img style="max-height: 100%; max-width: 100%;  margin: 13px auto; display: block;" src="'.$target_path.'?'.mt_rand().'" />';
					$filer = '<img style="max-height: 400px; max-width: 400px;  margin: 13px auto; display: block;" src="'.$target_path.'?'.mt_rand().'" />';
				}
			}
		}

		elseif ($fileActualExt == 'mp4') 
		{
			if($size > 100000000)
			{
				echo "3";//"File size too large! preferred range 0 - 100MB!";
				exit();
			}
			else
			{
				$target_path = 'Files/Forum_uploads/Events/' . $fileNameNew;
				if(move_uploaded_file($_source_path, $target_path))
				{
					$file = '<video id="vid" src="'.$target_path.'?'.mt_rand().'" class="e_vid" />
								<img class="play_video" src="play_icon.png" class="e_play" />';
					$filer = '<video id="vid" src="'.$target_path.'?'.mt_rand().'" style="display: block; max-width: 100%; margin: 0px auto;" height = 100% />
								<img class="play_video" src="play_icon.png" class="e_play" />';
				}
			}
		}

		$sq = "SELECT * FROM event_poster WHERE event_name = ?;";
		//$result = mysqli_query($connect, $sql);
		$stq = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($stq, $sq))
		{
			echo "None1";
			exit();
		}
		mysqli_stmt_prepare($stq, $sq);
		mysqli_stmt_bind_param($stq, "s", $event_name);
		mysqli_stmt_execute($stq);
		$resultq = mysqli_stmt_get_result($stq);
		$rowcountq = mysqli_num_rows($resultq);

		if($rowcountq < 1)
		{
			$sqli = "INSERT INTO event_poster (user_id, event_name, file, file_loc) VALUES ( ?, ?, ?, ?);";
					//$insert = mysqli_query($connect, $sql);

			$sti = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($sti, $sqli))
			{
				echo "None2";
				exit();
			}
			mysqli_stmt_prepare($sti, $sqli);
			mysqli_stmt_bind_param($sti, "isss", $id,$event_name, $file, $target_path);
			mysqli_stmt_execute($sti);
		}
		else{
			$sqli = "UPDATE event_poster SET file = ?, file_loc = ? WHERE event_name = ? AND user_id = ?;";
				//$results = mysqli_query($connect, $status);

			$sti = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($sti, $sqli))
			{
				echo "None3";
				exit();
			}
			mysqli_stmt_prepare($sti, $sqli);
			mysqli_stmt_bind_param($sti, "sssi", $file, $target_path, $event_name, $id);
			mysqli_stmt_execute($sti);
		}	

		echo $filer;
 	}
}

?>