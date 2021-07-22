<?php

session_start();
include 'database_of.php';
$id = $_SESSION['user_id'];
$title = mysqli_real_escape_string($connect, $_POST['topic_title']);
$desc = $_POST['topic_desc'];
$cate = $_POST['type_selecta'];
$desc = str_replace("<", "", $desc);
$desc = str_replace(">", "", $desc);
$rd = mysqli_real_escape_string($connect, $desc);
$s1 = mysqli_real_escape_string($connect, $cate);

if($desc == '' || $title == '' || $cate == '0' || $cate == '')
{
	echo "Fill empty fields!";
	exit();	
}

if(strlen($title) > 70)
{
	echo "Event title too long!";
	exit();
}

$sqlt = "SELECT * FROM topics WHERE topic_title = ?;";
//$resultt = mysqli_query($connect, $sqlt);
$stt = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stt, $sqlt))
{
	exit();
}
mysqli_stmt_prepare($stt, $sqlt);
mysqli_stmt_bind_param($stt, "s", $title);
mysqli_stmt_execute($stt);

$resultt = mysqli_stmt_get_result($stt);

$rowcountt = mysqli_num_rows($resultt);

if($rowcountt > 0)
{
	echo "Topic title already exist!";
	exit();
}


if(!empty($_FILES))
{	
	$size = $_FILES['file']['size'];
	if($size > 30000000)
	{
		echo "File size too large! preferred range 0 - 30MB";
		exit();				  		
	}
	
	$file = $_FILES['file'];
	$time = time();

	if(is_uploaded_file($_FILES['file']['tmp_name']))
	{
		$_source_path = $_FILES['file']['tmp_name'];
		$temp =  $_FILES['file']['name'];
		$fileNameNew = $id.$time."_".$temp;

		$fileExt = explode('.', $temp);
	 	//Lowering capital file extensions
		$fileActualExt = strtolower(end($fileExt));

		if($fileActualExt == 'pdf')
		{

			$target_path = 'Files/Forum_uploads/Faculty/' . $fileNameNew;
			if(move_uploaded_file($_source_path, $target_path))
			{
				$pdf = '<span style="overflow: hidden; width: 100mvw; height: auto; float: left; border-radius: 4px; background-color: white; border: 0.5px solid #F0F0F0;"><a href="'.$target_path.'" class="pdf" style="font-weight:bold; color: #324A60; text-decoration: none; font-size: 13px; " download><img src="iconfinder_pdf_3745.png" width="17" height="17" style="margin-bottom: -3px; margin-right: 0px;"><span style="margin: 0px 5px; margin-top: -10px; float right; margin-bottom: 3px;">'.$temp.'</span></a></span>';

				$sql = "INSERT INTO topics (category_id, user_id, topic_title, topic_desc, file_loc, file) VALUES ( ?, ?, ?, ?, ?, ?);";
				//$insert = mysqli_query($connect, $sql);

				$sti = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sti, $sql))
				{
					exit();
				}
				mysqli_stmt_prepare($sti, $sql);
				mysqli_stmt_bind_param($sti, "iissss", $s1, $id, $title, $rd, $target_path, $pdf);
				mysqli_stmt_execute($sti);
			}
		}

		elseif($fileActualExt == 'zip')
		{

			$target_path = 'Files/Forum_uploads/Faculty/' . $fileNameNew;
			if(move_uploaded_file($_source_path, $target_path))
			{
				$pdf = '<span style="overflow: hidden; width: 100mvw; height: auto; float: left; border-radius: 4px; background-color: white; border: 0.5px solid #F0F0F0;"><a href="'.$target_path.'" class="pdf" style="font-weight:bold; color: #324A60; text-decoration: none; font-size: 13px; " download><img src="zip_file.png" width="17" height="17" style="margin-bottom: -3px; margin-right: 0px;"><span style="margin: 0px 5px; margin-top: -10px; float right; margin-bottom: 3px;">'.$temp.'</span></a></span>';

				$sql = "INSERT INTO topics (category_id, user_id, topic_title, topic_desc, file_loc, file) VALUES ( ?, ?, ?, ?, ?, ?);";
				//$insert = mysqli_query($connect, $sql);

				$sti = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sti, $sql))
				{
					exit();
				}
				mysqli_stmt_prepare($sti, $sql);
				mysqli_stmt_bind_param($sti, "iissss", $s1, $id, $title, $rd, $target_path, $pdf);
				mysqli_stmt_execute($sti);
			}
		}

	}
}
else{
	$sql = "INSERT INTO topics (category_id, user_id, topic_title, topic_desc) VALUES ( ?, ?, ?, ?);";
	//$insert = mysqli_query($connect, $sql);

	$sti = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sti, $sql))
	{
		exit();
	}
	mysqli_stmt_prepare($sti, $sql);
	mysqli_stmt_bind_param($sti, "iiss", $s1, $id, $title, $rd);
	mysqli_stmt_execute($sti);
}

$sqls = "SELECT * FROM topics WHERE topic_title = ? AND topic_desc = ? AND user_id = ? LIMIT 1";
//$results = mysqli_query($connect, $sqls);

$sts = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($sts, $sqls))
{
	echo "error";
	exit();
}
mysqli_stmt_prepare($sts, $sqls);
mysqli_stmt_bind_param($sts, "ssi", $title, $rd, $id);
mysqli_stmt_execute($sts);

$results = mysqli_stmt_get_result($sts);
$rowcounts = mysqli_num_rows($results);

if($rowcounts < 1)
{
	echo "None";
	exit();
}

if($row = mysqli_fetch_assoc($results))
{
	$inserts = "INSERT INTO forum_notification_request (cat_id, topic_id, user_id) VALUES ( ?, ?, ?);";
	//$done = mysqli_query($connect, $inserts);

	$stis = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stis, $inserts))
	{
		exit();
	}
	mysqli_stmt_prepare($stis, $inserts);
	mysqli_stmt_bind_param($stis, "iii", $s1, $row['id'], $id);
	if(!mysqli_stmt_execute($stis))
	{
		echo "Error!";
		exit();
	}
}
?>