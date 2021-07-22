<?php

include 'database_of.php';
include 'calls.php';

session_start();

$to_user_id = $_POST['id'];
$from_user_id = $_SESSION['user_id'];
$s0 = '0';
$s1 = '1';
$s2 = '2';

$desc = $_POST['cm'];


$chat_message = mysqli_real_escape_string($connect, $desc);
$chat_message = htmlspecialchars($chat_message);

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
	$insert = "INSERT INTO message_request (from_user_id, to_user_id, status) VALUES ( ?, ?, ?);";
	//$ai = mysqli_query($connect, $insert);
	$sti = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sti, $insert))
	{
		exit();
	}
	mysqli_stmt_prepare($sti, $insert);
	mysqli_stmt_bind_param($sti, "iii", $from_user_id, $to_user_id, $s0);
	mysqli_stmt_execute($sti);


	$pending = "INSERT INTO pending_message (from_user_id, to_user_id, message) VALUES ( ?, ?, ?);";
	//$ip = mysqli_query($connect, $pending); 
	$stp = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stp, $pending))
	{
		exit();
	}
	mysqli_stmt_prepare($stp, $pending);
	mysqli_stmt_bind_param($stp, "iis", $from_user_id, $to_user_id, $chat_message);
	mysqli_stmt_execute($stp);

	echo fetch_user_chat_history($_SESSION['user_id'], $_POST['id']);
}
else
{
	while($row = mysqli_fetch_assoc($query)){
		if($row['to_user_id'] == $from_user_id)
		{
			$status = "UPDATE message_request SET status = ? WHERE from_user_id = ? AND to_user_id = ?;";
			//$results = mysqli_query($connect, $status); 
			$sts = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($sts, $status))
			{
				exit();
			}
			mysqli_stmt_prepare($sts, $status);
			mysqli_stmt_bind_param($sts, "iii", $s2, $to_user_id, $from_user_id);
			mysqli_stmt_execute($sts);

			$update = "SELECT * FROM pending_message WHERE to_user_id = ? AND from_user_id = ?;";
			//$qu = mysqli_query($connect, $update);
			$stu = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($stu, $update))
			{
				exit();
			}
			mysqli_stmt_prepare($stu, $update);
			mysqli_stmt_bind_param($stu, "ii", $from_user_id, $to_user_id);
			mysqli_stmt_execute($stu);

			$qu = mysqli_stmt_get_result($stu);

			$rowcount = mysqli_num_rows($qu);

			if($rowcount > 0){
				while($row = mysqli_fetch_assoc($qu)){
					$pid = $row['pending_message_id'];
					$fud = $row['from_user_id'];
					$tud = $row['to_user_id'];
					$message = $row['message'];
					$date = $row['date'];

					$mi = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, `timestamp`,status)
						VALUES ( ?, ?, ?, ?, ?);";
					//$miq = mysqli_query($connect, $mi);
					$stm = mysqli_stmt_init($connect);

					if(!mysqli_stmt_prepare($stm, $mi))
					{
						exit();
					}
					mysqli_stmt_prepare($stm, $mi);
					mysqli_stmt_bind_param($stm, "iissi", $tud, $fud, $message, $date, $s1);
					mysqli_stmt_execute($stm);

					$pd = "DELETE FROM pending_message WHERE pending_message_id = '$pid'";
					//$piq = mysqli_query($connect, $pd);

					$std = mysqli_stmt_init($connect);

					if(!mysqli_stmt_prepare($std, $pd))
					{
						exit();
					}
					mysqli_stmt_prepare($std, $pd);
					mysqli_stmt_bind_param($std, "i", $pid);
					mysqli_stmt_execute($std);					
				}
			}
			else{

			}


			$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status)
					VALUES ( ?, ?, ?, ?);";
			//$result = mysqli_query($connect, $sql);

			$stl = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($stl, $sql))
			{
				exit();
			}
			mysqli_stmt_prepare($stl, $sql);
			mysqli_stmt_bind_param($stl, "iisi", $to_user_id, $from_user_id, $chat_message, $s1);
			mysqli_stmt_execute($stl);

			//$result = mysqli_stmt_get_result($stl);

			if($stl){
				echo fetch_user_chat_history($_SESSION['user_id'], $_POST['id']);
			}
		}
		else
		{
			if($row['status'] == 2)
			{
				$update = "SELECT * FROM pending_message WHERE to_user_id = ? AND from_user_id = ?;";
				//$qu = mysqli_query($connect, $update);
				$sup = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($sup, $update))
				{
					exit();
				}
				mysqli_stmt_prepare($sup, $update);
				mysqli_stmt_bind_param($sup, "ii", $to_user_id, $from_user_id);
				mysqli_stmt_execute($sup);

				$qu = mysqli_stmt_get_result($sup);

				$rowcount = mysqli_num_rows($qu);

				if($rowcount > 0){
					while($row = mysqli_fetch_assoc($qu)){
						$pid = $row['pending_message_id'];
						$fud = $row['from_user_id'];
						$tud = $row['to_user_id'];
						$message = $row['message'];
						$date = $row['date'];

						$mi = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, `timestamp`,status)
							VALUES ( ?, ?, ?, ?, ?);";
						//$miq = mysqli_query($connect, $mi);

						$smi = mysqli_stmt_init($connect);

						if(!mysqli_stmt_prepare($smi, $mi))
						{
							exit();
						}
						mysqli_stmt_prepare($smi, $mi);
						mysqli_stmt_bind_param($smi, "iissi", $tud, $fud, $message, $date, $s1);
						mysqli_stmt_execute($smi);

						$pd = "DELETE FROM pending_message WHERE pending_message_id = ?;";
						//$miq = mysqli_query($connect, $pd);		

						$spd = mysqli_stmt_init($connect);

						if(!mysqli_stmt_prepare($spd, $pd))
						{
							exit();
						}
						mysqli_stmt_prepare($spd, $pd);
						mysqli_stmt_bind_param($spd, "i", $pid);
						mysqli_stmt_execute($spd);			
					}
				}

				$sql = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status)
					VALUES ( ?, ?, ?, ?);";
				//$result = mysqli_query($connect, $sql);

				$stl = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($stl, $sql))
				{
					exit();
				}
				mysqli_stmt_prepare($stl, $sql);
				mysqli_stmt_bind_param($stl, "iisi", $to_user_id, $from_user_id, $chat_message, $s1);
				mysqli_stmt_execute($stl);

				//$result = mysqli_stmt_get_result($stl);
				    
				if($stl){
					echo fetch_user_chat_history($_SESSION['user_id'], $_POST['id']);
				}
			}
			else{

				$pend = "INSERT INTO pending_message (from_user_id, to_user_id, message) VALUES ( ?, ?, ?);";
				//$pen = mysqli_query($connect, $pend); 

				$pnd = mysqli_stmt_init($connect);

				if(!mysqli_stmt_prepare($pnd, $pend))
				{
					exit();
				}
				mysqli_stmt_prepare($pnd, $pend);
				mysqli_stmt_bind_param($pnd, "iis", $from_user_id, $to_user_id, $chat_message);
				mysqli_stmt_execute($pnd);

				echo fetch_user_chat_history($_SESSION['user_id'], $_POST['id']);
			}
		}
	}
}

?>