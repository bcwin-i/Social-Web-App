<?php

include 'database_of.php';
list($cid, $tid, $cat_id) = explode("_", $_POST['id']);

$query = "SELECT * FROM replies WHERE category_id = ? AND topic_id = ?";
//$submit = mysqli_query($connect, $query); 
$stq = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stq, $query))
{
	exit();
}
mysqli_stmt_prepare($stq, $query);
mysqli_stmt_bind_param($stq, "ii", $cat_id, $tid);
mysqli_stmt_execute($stq);
$submit = mysqli_stmt_get_result($stq);

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