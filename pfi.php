<?php

function pfi()
{
	include 'database_of.php';
	include 'calls.php';
	$id = $_SESSION['user_id'];

	$sqlImg = "SELECT * FROM profileimage WHERE userid= ?;";
	//$resultImg = mysqli_query($connect, $sqlImg);

	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sqlImg))
	{
		exit();
	}
	mysqli_stmt_prepare($st, $sqlImg);
	mysqli_stmt_bind_param($st, "i", $id);
	mysqli_stmt_execute($st);
	$resultImg = mysqli_stmt_get_result($st);

	$output = '';	

	while($rowImg = mysqli_fetch_assoc($resultImg)){
		$output = "<table style='width: 100%; margin:0px; padding: 0px;'><tr style='line-height: 10px;  margin: 0px; padding: 0px;'>";
		if($rowImg['status'] == 0){
			$output .= "<td style='width:16%; margin:0px;'><img id='user' src='Files/Profile/profile".$id.".jpg' height = 30 width = 30></td>";
		}
		else
		{
			$output .= "<td style='width:16%; margin:0px;'><img id='user' src='user.PNG' height = 30 width = 30></td>";
		}
		$output .= "<td style='width:54%; margin:0px;'><span class='un'>".user_name($rowImg['userid'])."</span></td>";
		$output .= "<td style='width:30%; margin:0px; '><span class='p2' title='logout'>Log out</span></td>";
		$output .= "</tr></table>";
	}
	echo $output;
}


?>