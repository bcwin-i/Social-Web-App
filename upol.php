<?php

session_start();
include 'database_of.php';
$id = $_SESSION['user_id'];
$title = mysqli_real_escape_string($connect, $_POST['book_title']);
$desc = $_POST['book_desc'];
$cate = $_POST['type_selecta'];
$rd = mysqli_real_escape_string($connect, $desc);
$s1 = mysqli_real_escape_string($connect, $cate);

if($desc == '' || $title == '' || $cate == '0' || $cate == '' || empty($_FILES['file']))
{
	echo "Fill empty fields!";
	exit();	
}

if(strlen($title) > 70)
{
	echo "Event title too long!";
	exit();
}

$sqlt = "SELECT * FROM library WHERE book_title = ?;";
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

$size = $_FILES['file']['size'];
if($size > 30000000)
{
	echo "File size too large! preferred range 0 - 30MB";
	exit();				  		
}

$time = time();

$cover = '';
if(!empty($_FILES['cover']))
{
	$_source_cover = $_FILES['cover']['tmp_name'];
	$cover = $_FILES['cover']['name'];
	$cover = $id.$time."_".$cover;
	$target_cover = 'Files/Forum_uploads/library/' . $cover;
	move_uploaded_file($_source_cover, $target_cover);
}	

	
	$file = $_FILES['file'];

	if(is_uploaded_file($_FILES['file']['tmp_name']))
	{
		$_source_path = $_FILES['file']['tmp_name'];
		$temp =  $_FILES['file']['name'];
		$fileNameNew = $id.$time."_".$temp;

		$fileExt = explode('.', $temp);
	 	//Lowering capital file extensions
		$fileActualExt = strtolower(end($fileExt));

			$target_path = 'Files/Forum_uploads/library/' . $fileNameNew;
			if(move_uploaded_file($_source_path, $target_path))
			{

				$sql = "INSERT INTO library (book_title, category_id, file, cover, book_desc, user_id) VALUES ( ?, ?, ?, ?, ?, ?);";
				//$insert = mysqli_query($connect, $sql);

				$sti = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sti, $sql))
				{
					exit();
				}
				mysqli_stmt_prepare($sti, $sql);
				mysqli_stmt_bind_param($sti, "sisssi", $title, $s1, $fileNameNew, $cover, $rd, $id);
				if(mysqli_stmt_execute($sti)){
					exit();
				}
			}
	}


?>