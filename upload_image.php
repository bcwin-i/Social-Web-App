<?php

//upload.php
include 'database_of.php';
session_start();
$id = $_SESSION['user_id'];
$from_user_id = $_SESSION['user_id'];
$to_user_id = $_POST['tuid'];
$uid = '';
$s0 = '0';
$s1 = '1';
$s2 = '2';

$check = "SELECT * FROM message_request WHERE from_user_id = ? AND to_user_id = ? OR from_user_id = ? AND to_user_id = ?;";
//$query = mysqli_query($connect, $check);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $check))
{
	exit();
}
mysqli_stmt_prepare($st, $check);
mysqli_stmt_bind_param($st, "iiii", $from_user_id, $to_user_id, $to_user_id, $from_user_id);
mysqli_stmt_execute($st);

$query = mysqli_stmt_get_result($st);

$rowcount = mysqli_num_rows($query);

if($rowcount < 1)
{
	$insert = "INSERT INTO message_request (from_user_id, to_user_id, status) VALUES (?, ?, ?);";
	//$ai = mysqli_query($connect, $insert);
	$sti = mysqli_stmt_init($connect);
	if(!mysqli_stmt_prepare($sti, $insert))
	{
		exit();
	}
	mysqli_stmt_prepare($sti, $insert);
	mysqli_stmt_bind_param($sti, "iii", $from_user_id, $to_user_id, $s0);
	mysqli_stmt_execute($sti);

	exit();
}
else
{
	while($row = mysqli_fetch_assoc($query)){
		if($row['to_user_id'] == $from_user_id)
		{
			$status = "UPDATE message_request SET status = ? WHERE from_user_id = ?
				   AND to_user_id = ?;";
			//$results = mysqli_query($connect, $status); 
			$stu = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($stu, $status))
			{
				exit();
			}
			mysqli_stmt_prepare($stu, $status);
			mysqli_stmt_bind_param($stu, "iii", $s2, $to_user_id, $from_user_id);
			mysqli_stmt_execute($stu);

			$results = mysqli_stmt_get_result($stu);

			if(!empty($_FILES))
			{
			 if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
			 {
			 	  date_default_timezone_set('Africa/Accra');
				  $current_timestamp = strtotime(date('Y-m-d H:i:s') .'-10 seconds');
				  $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
				  $time = time();

			 	  $uid = $_POST['tuid'];

				  $_source_path = $_FILES['uploadFile']['tmp_name'];
				  $temp =  $_FILES['uploadFile']['name'];
				  $fileNameNew = $id.$uid.$time."_".$temp;
				  $size = $_FILES['uploadFile']['size'];

				  $fileExt = explode('.', $temp);
				  //Lowering capital file extensions
				  $fileActualExt = strtolower(end($fileExt));

				  if($fileActualExt == 'mp3')
				  {
				  	if($size > 10000000)
				  	{
				  		echo "File size too large! preferred range 0 - 10MB";
						exit();
				  	}
				  	else
				  	{
					  	$target_path = 'Files/Chat_uploads/' . $fileNameNew;
						if(move_uploaded_file($_source_path, $target_path))
						{
							$file = '<span class="wmp">
											<img class="m_p" src ="m_p.png" />
										   	<img src="play_music.png" class="play_mus" data-tou = "'.$to_user_id.'" data-fru="'.$id.'" data-target="'.$target_path.'" data-file="'.$id.$uid.$current_timestamp.'" id="play_'.$id.$uid.$current_timestamp.'">
										   	<a href="'.$target_path.'" style="font-weight:bold; color: gray; text-decoration: none; font-size: 11px; " download>
										   		<img class="down_mus" src="download_music.png" />
										   	</a>
									 	</span>';

						   	$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
							VALUES ( ?, ?, ?, ?, ?, ?);";
							//$result = mysqli_query($connect, $sql);

							$sl = mysqli_stmt_init($connect);

							if(!mysqli_stmt_prepare($sl, $sql))
							{
								exit();
							}
							mysqli_stmt_prepare($sl, $sql);
							mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
							mysqli_stmt_execute($sl);

							$result = mysqli_stmt_get_result($st);
						}
					}
				  }
				else if($fileActualExt == 'jpg' || $fileActualExt == 'png' || $fileActualExt == 'gif')
				{

				  	if($size > 5000000)
				  	{
				  		echo "File size too large! preferred range 0 - 5MB";
						exit();
				  	}
				  	else
				  	{
						$target_path = 'Files/Chat_uploads/' . $fileNameNew;
						if(move_uploaded_file($_source_path, $target_path))
						{
							$file = '<span class="upi" id="'.$fileNameNew.'"><img src="'.$target_path.'" class="uploaded_img"/></span>';
							
							$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
							VALUES ( ?, ?, ?, ?, ?, ?);";
							//$result = mysqli_query($connect, $sql);

							$sl = mysqli_stmt_init($connect);

							if(!mysqli_stmt_prepare($sl, $sql))
							{
								exit();
							}
							mysqli_stmt_prepare($sl, $sql);
							mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
							mysqli_stmt_execute($sl);

							$result = mysqli_stmt_get_result($st);
						}
					}
				}
				  else if($fileActualExt == 'mp4')
				  {
				  	if($size > 30000000)
				  	{
				  		echo "File size too large! preferred range 0 - 30MB";
						exit();
				  	}
				  	else
				  	{
					  	$target_path = 'Files/Chat_uploads/' . $fileNameNew;

				  		if(move_uploaded_file($_source_path, $target_path))
				  		{
				   			$file = '<span><video class="uplcv" src="'.$target_path.'" width="170" height="170" controls></video></span>';
				   			
				   			$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
							VALUES ( ?, ?, ?, ?, ?, ?);";
							//$result = mysqli_query($connect, $sql);

							$sl = mysqli_stmt_init($connect);

							if(!mysqli_stmt_prepare($sl, $sql))
							{
								exit();
							}
							mysqli_stmt_prepare($sl, $sql);
							mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
							mysqli_stmt_execute($sl);

							$result = mysqli_stmt_get_result($st);
				  		}
			  		}
				  }
				  else if($fileActualExt == 'pdf')
				  {
				  	if($size > 5000000)
				  	{
				  		echo "File size too large! preferred range 0 - 5MB";
						exit();
				  	}
				  	else
				  	{
					  	$target_path = 'Files/Chat_uploads/' . $fileNameNew;

				  		if(move_uploaded_file($_source_path, $target_path))
				  		{
				   			$file = '<span style="overflow: hidden; width: 175px; height: auto; border-radius: 7px; background-color: white; border: 0.5px solid #F0F0F0;"><a href="'.$target_path.'" class="pdf" style="font-weight:bold; color: gray; text-decoration: none; font-size: 11px; " download><img src="iconfinder_pdf_3745.png" width="17" height="17" style="margin: 5px; margin-bottom: -3px; margin-right: 0px;"><span style="margin: 0px 5px; margin-top: -10px; float right; margin-bottom: 3px;">'.$temp.'</span></a></span>';
				   			$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
							VALUES ( ?, ?, ?, ?, ?, ?);";
							//$result = mysqli_query($connect, $sql);

							$sl = mysqli_stmt_init($connect);

							if(!mysqli_stmt_prepare($sl, $sql))
							{
								exit();
							}
							mysqli_stmt_prepare($sl, $sql);
							mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
							mysqli_stmt_execute($sl);

							$result = mysqli_stmt_get_result($st);
				  		}
			  		}
				  }
			 }
			}
		}
		else{
			if($row['status'] == 2)
			{
				if(!empty($_FILES))
				{
				 if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
				 {
				 	  date_default_timezone_set('Africa/Accra');
					  $current_timestamp = strtotime(date('Y-m-d H:i:s') .'-10 seconds');
					  $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
					  $current_timestamp = str_replace(':', '_', $current_timestamp);
					  $current_timestamp = str_replace(' ', '-', $current_timestamp);

				 	  $uid = $_POST['tuid'];

					  $_source_path = $_FILES['uploadFile']['tmp_name'];
					  $temp =  $_FILES['uploadFile']['name'];
					  $fileNameNew = $id.$uid.$current_timestamp."_".$temp;
					  $size = $_FILES['uploadFile']['size'];

					  $fileExt = explode('.', $temp);
					  //Lowering capital file extensions
					  $fileActualExt = strtolower(end($fileExt));

					  if($fileActualExt == 'mp3')
					  {
					  	if($size > 10000000)
					  	{
					  		echo "File size too large! preferred range 0 - 10MB";
							exit();
					  	}
					  	else
					  	{
						  	$target_path = 'Files/Chat_uploads/' . $fileNameNew;
							if(move_uploaded_file($_source_path, $target_path))
							{
								$file = '<span class="wmp">
											<img class="m_p" src ="m_p.png" />
										   	<img src="play_music.png" class="play_mus" data-tou="'.$from_user_id.'" data-fru="'.$id.'" data-target="'.$target_path.'" data-file="'.$id.$uid.$current_timestamp.'" id="play_'.$id.$uid.$current_timestamp.'">
										   	<a href="'.$target_path.'" style="font-weight:bold; color: gray; text-decoration: none; font-size: 11px; " download>
										   		<img class="down_mus" src="download_music.png" />
										   	</a>
									 	</span>';

							  	$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
								VALUES ( ?, ?, ?, ?, ?, ?);";
								//$result = mysqli_query($connect, $sql);

								$sl = mysqli_stmt_init($connect);

								if(!mysqli_stmt_prepare($sl, $sql))
								{
									exit();
								}
								mysqli_stmt_prepare($sl, $sql);
								mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
								mysqli_stmt_execute($sl);

								$result = mysqli_stmt_get_result($st);
							}
						}
					  }
					  else if($fileActualExt == 'jpg' || $fileActualExt == 'png' || $fileActualExt == 'gif'){

					  	if($size > 5000000)
					  	{
					  		echo "File size too large! preferred range 0 - 5MB";
							exit();
					  	}
					  	else
					  	{
							$target_path = 'Files/Chat_uploads/' . $fileNameNew;
							if(move_uploaded_file($_source_path, $target_path))
							{
								$file = '<span class="upi" id="'.$fileNameNew.'"><img src="'.$target_path.'" class="uploaded_img"/></span>';
								
								$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
								VALUES ( ?, ?, ?, ?, ?, ?);";
								//$result = mysqli_query($connect, $sql);

								$sl = mysqli_stmt_init($connect);

								if(!mysqli_stmt_prepare($sl, $sql))
								{
									exit();
								}
								mysqli_stmt_prepare($sl, $sql);
								mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
								mysqli_stmt_execute($sl);

								$result = mysqli_stmt_get_result($st);
							}
						}
					  }
					  else if($fileActualExt == 'mp4')
					  {
					  	if($size > 30000000)
					  	{
					  		echo "File size too large! preferred range 0 - 30MB";
							exit();
					  	}
					  	else
					  	{
						  	$target_path = 'Files/Chat_uploads/' . $fileNameNew;

					  		if(move_uploaded_file($_source_path, $target_path))
					  		{
					   			$file = '<span><video src="'.$target_path.'" width="170" height="170" controls></video></span><br>';
					   			$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
								VALUES ( ?, ?, ?, ?, ?, ?);";
								//$result = mysqli_query($connect, $sql);

								$sl = mysqli_stmt_init($connect);

								if(!mysqli_stmt_prepare($sl, $sql))
								{
									exit();
								}
								mysqli_stmt_prepare($sl, $sql);
								mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
								mysqli_stmt_execute($sl);

								$result = mysqli_stmt_get_result($st);
					  		}
				  		}
					  }
					  else if($fileActualExt == 'pdf')
					  {
					  	if($size > 5000000)
					  	{
					  		echo "File size too large! preferred range 0 - 10MB";
							exit();
					  	}
					  	else
					  	{
						  	$target_path = 'Files/Chat_uploads/' . $fileNameNew;

					  		if(move_uploaded_file($_source_path, $target_path))
					  		{
					   			$file = '<table style="overflow: hidden; width: 175px; float: left; border-radius: 7px; background-color: white; border: 0.5px solid #F0F0F0;"><tr><td style="width: 15%; float: left;"><img src="iconfinder_pdf_3745.png" width="17" height="17" style="margin: 5px; margin-bottom: -3px; margin-right: 0px;"></td><td style="margin: 0px 5px; float right; margin-bottom: 3px; width:85%; "><a href="'.$target_path.'" class="pdf" style="font-weight:bold; color: gray; text-decoration: none; font-size: 11px;" download>'.$temp.'</a></td></tr></table>';
					   			$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status, fstat, file_name)
								VALUES ( ?, ?, ?, ?, ?, ?);";
								//$result = mysqli_query($connect, $sql);

								$sl = mysqli_stmt_init($connect);

								if(!mysqli_stmt_prepare($sl, $sql))
								{
									exit();
								}
								mysqli_stmt_prepare($sl, $sql);
								mysqli_stmt_bind_param($sl, "iisiis", $uid, $id, $file, $s1, $s1, $fileNameNew);
								mysqli_stmt_execute($sl);

								$result = mysqli_stmt_get_result($st);
					  		}
				  		}
					  }
				 }
				}
			}
			else{
			}
		}
	}
}




?>