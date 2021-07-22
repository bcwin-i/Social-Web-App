<?php

session_start();
include 'database_of.php';
$id = $_SESSION['user_id'];
$s1 = '2';

$reply = $_POST['event_reply'];
if($reply == '' && empty($_FILES))
{
	echo "Fill empty fields!";
	exit();
}

$cat_id = $_POST['id'];
$reply = str_replace("<", "", $reply);
$reply = str_replace(">", "", $reply);


$desc = mysqli_real_escape_string($connect, $reply);

if(!empty($_FILES))
{	
	$file = $_FILES['file'];
	$time = time();
	$name =  $_FILES['file']['name'];
	$fileExt = explode('.', $name);
	 //Lowering capital file extensions
	$fileActualExt = strtolower(end($fileExt));

	$size = $_FILES['file']['size'];
	if($size > 50000000)
	{
		echo "File size too large! preferred range 0 - 50MB";
		exit();				  		
	}

	if(is_uploaded_file($_FILES['file']['tmp_name']))
	{
		$_source_path = $_FILES['file']['tmp_name'];
		$temp =  $_FILES['file']['name'];
		$fileNameNew = $id.$time."_".$temp;

		$target_path = 'Files/Forum_uploads/Events/' . $fileNameNew;
		if(move_uploaded_file($_source_path, $target_path))
		{
			if($fileActualExt == 'jpg' || $fileActualExt == 'png' || $fileActualExt == 'gif')
			{
				$file = '<img class="upie" id="'.$fileNameNew.'" style="max-height: 100%; max-width: 100%;" src="'.$target_path.'?'.mt_rand().'" />';

				$sql = "INSERT INTO replies (category_id, topic_id, user_id, comment, file_loc, file) VALUES ( ?, ?, ?, ?, ?, ?);";
				//$insert = mysqli_query($connect, $sql);

				$sti = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sti, $sql))
				{
					exit();
				}
				mysqli_stmt_prepare($sti, $sql);
				mysqli_stmt_bind_param($sti, "iiisss", $s1, $cat_id, $id, $desc, $target_path, $file);
				mysqli_stmt_execute($sti);

			}
			elseif($fileActualExt == 'mp4')
			{
				$file = '<video id="vid" src="'.$target_path.'?'.mt_rand().'" class="e_vid" />
								<img class="play_video" src="play_icon.png" class="e_play" />';

				$sql = "INSERT INTO replies (category_id, topic_id, user_id, comment, file_loc, file) VALUES ( ?, ?, ?, ?, ?, ?);";
				//$insert = mysqli_query($connect, $sql);

				$sti = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sti, $sql))
				{
					exit();
				}
				mysqli_stmt_prepare($sti, $sql);
				mysqli_stmt_bind_param($sti, "iiisss", $s1, $cat_id, $id, $desc, $target_path, $file);
				mysqli_stmt_execute($sti);

			}

			$query = "SELECT * FROM replies WHERE category_id = ? AND topic_id = ?;";
			//$submit = mysqli_query($connect, $query); 
			$stq = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($stq, $query))
			{
				exit();
			}
			mysqli_stmt_prepare($stq, $query);
			mysqli_stmt_bind_param($stq, "ii", $s1, $cat_id);
			mysqli_stmt_execute($stq);
			$submit = mysqli_stmt_get_result($stq);
			$replies = mysqli_num_rows($submit);

			$querys = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ?;";
			//$submits = mysqli_query($connect, $querys); 
			$stqs = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($stqs, $querys))
			{
				exit();
			}
			mysqli_stmt_prepare($stqs, $querys);
			mysqli_stmt_bind_param($stqs, "ii", $s1, $cat_id);
			mysqli_stmt_execute($stqs);
			$submits = mysqli_stmt_get_result($stqs);

			if($replies > 0)
			{
				while($row = mysqli_fetch_assoc($submits))
				{
						$sqli = "UPDATE forum_notification_request SET current = '$replies' WHERE id = ".$row['id']."";
						$inserti = mysqli_query($connect, $sqli);
				}
			}

		}	
	}

}
else{
	$sql = "INSERT INTO replies (category_id, topic_id, user_id, comment) VALUES ( ?, ?, ?, ?);";
	//$insert = mysqli_query($connect, $sql);

	$sti = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sti, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($sti, $sql);
	mysqli_stmt_bind_param($sti, "iiis", $s1, $cat_id, $id, $desc);
	mysqli_stmt_execute($sti);

	$query = "SELECT * FROM replies WHERE category_id = ? AND topic_id = ?;";
	//$submit = mysqli_query($connect, $query); 
	$stq = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stq, $query))
	{
		exit();
	}
	mysqli_stmt_prepare($stq, $query);
	mysqli_stmt_bind_param($stq, "ii", $s1, $cat_id);
	mysqli_stmt_execute($stq);
	$submit = mysqli_stmt_get_result($stq);
	$replies = mysqli_num_rows($submit);

	$querys = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ?;";
	//$submits = mysqli_query($connect, $querys); 
	$stqs = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stqs, $querys))
	{
		exit();
	}
	mysqli_stmt_prepare($stqs, $querys);
	mysqli_stmt_bind_param($stqs, "ii", $s1, $cat_id);
	mysqli_stmt_execute($stqs);
	$submits = mysqli_stmt_get_result($stqs);

	if($replies > 0){
		while($row = mysqli_fetch_assoc($submits)){
			$sqli = "UPDATE forum_notification_request SET current = '$replies' WHERE id = ".$row['id']."";
			$inserti = mysqli_query($connect, $sqli);
		}
	}
}


$queryss = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ? AND user_id = ?;";
//$submitss = mysqli_query($connect, $queryss); 
$stqss = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stqss, $queryss))
{
	exit();
}
mysqli_stmt_prepare($stqss, $queryss);
mysqli_stmt_bind_param($stqss, "iii", $s1, $cat_id, $id);
mysqli_stmt_execute($stqss);
$submitss = mysqli_stmt_get_result($stqss);

while($row = mysqli_fetch_assoc($submitss)){
	$sqlis = "UPDATE forum_notification_request SET previous = '$replies' WHERE id = ".$row['id']."";
	$insertis = mysqli_query($connect, $sqlis);
}



?>