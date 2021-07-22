<?php

include 'database_of.php';

if(isset($_POST["cmid"]))
{	
	$cid = $_POST["cmid"];

	$sqls = "SELECT * FROM chat_message WHERE chat_message_id = ?;";
	//$results = mysqli_query($connect, $sqls);
	$sts = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($sts, $sqls))
	{
		exit();
	}
	mysqli_stmt_prepare($sts, $sqls);
	mysqli_stmt_bind_param($sts, "i", $cid);
	mysqli_stmt_execute($sts);

	$results = mysqli_stmt_get_result($sts);

	while($row = mysqli_fetch_assoc($results))
	{ 
		$directory = $row['file_name'];
		if(!empty($directory))
	 	{
		  	$file = 'Files/Chat_uploads/' . $row['file_name'];
		  	if(!unlink($file)){

		  	}
		  	else{
		  		$sql = "UPDATE chat_message SET status = '2' WHERE chat_message_id = '".$_POST["cmid"]."'";
				$result = mysqli_query($connect, $sql);

				$sq = "SELECT to_user_id FROM chat_message WHERE chat_message_id = '".$_POST["cmid"]."'";
				$query = mysqli_query($connect, $sq);

				while($row = mysqli_fetch_assoc($query))
				{
					echo $row['to_user_id'];
				}
		  	}
	  	}
		else
	  	{
		 	$sql = "UPDATE chat_message SET status = '2' WHERE chat_message_id = '".$_POST["cmid"]."'";
			$result = mysqli_query($connect, $sql);

			$sq = "SELECT to_user_id FROM chat_message WHERE chat_message_id = '".$_POST["cmid"]."'";
			$query = mysqli_query($connect, $sq);

			while($row = mysqli_fetch_assoc($query))
			{
				echo $row['to_user_id'];
			}
		}
	}
}

?>