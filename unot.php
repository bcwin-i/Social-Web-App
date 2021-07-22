<?php

include 'database_of.php';
include 'calls.php';

list($tid, $s1) = explode("_", $_POST['id']);

$query = "SELECT * FROM replies WHERE category_id = ".$s1." AND topic_id = '$tid'";
$submit = mysqli_query($connect, $query); 
$rowcount = mysqli_num_rows($submit);

if($rowcount > 1)
{
	$rowcount = $rowcount.' comments';
}
else
{
	$rowcount = $rowcount.' comment';
}

echo $rowcount;

?>