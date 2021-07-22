<?php

include 'database_of.php';
$tid = mysqli_real_escape_string($connect, $_POST['id']);

$queryss = "SELECT * FROM library WHERE id = '$tid';";
$submitss = mysqli_query($connect, $queryss); 

if($row = mysqli_fetch_assoc($submitss)){

	$replies = 1 + $row['views'];
	$sqlis = "UPDATE library SET views = '$replies' WHERE id = ".$row['id']."";
	if(mysqli_query($connect, $sqlis))
	{
		$filename = "Files/Forum_uploads/library/".$row['file']."";
		list($name, $file) = explode(".", $row['file']);
		if($file == 'pdf')
		{
			echo $filename;
			exit();	
		}
		elseif($file == 'pptx')
		{
			echo "http://docs.google.com/gview?url=http//".$filename."&embedded=true";
			exit();
		}
		elseif($file == 'docx')
		{
			echo "https://docs.google.com/gview?url=http://remote.url.tld/".$filename."&embedded=true";
			exit();
		}
		elseif($file == 'xlsx')
		{
			echo "http://docs.google.com/gview?url=http//".$filename."&embedded=true";
			exit();
		}

	}
}

?>