<?php

include 'database_of.php';
$tid = mysqli_real_escape_string($connect, $_POST['id']);

$queryss = "SELECT * FROM library WHERE id = '$tid';";
$submitss = mysqli_query($connect, $queryss); 

if($row = mysqli_fetch_assoc($submitss)){

	$replies = 1 + $row['downloads'];
	$sqlis = "UPDATE library SET downloads = '$replies' WHERE id = ".$row['id']."";
	if(mysqli_query($connect, $sqlis))
	{
		exit();
	}
}

?>