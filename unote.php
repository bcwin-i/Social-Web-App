<?php

include 'database_of.php';
include 'calls.php';

$tid = $_POST['id'];

$query = "SELECT * FROM replies WHERE category_id = '2' AND topic_id = '$tid'";
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