<?php

session_start();
include 'database_of.php';
$id = $_SESSION['user_id'];

$div = $_POST['id'];
list($topic_id, $cat_id) = explode("_", $div);

$sql = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ? AND user_id = ?;";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "iii", $cat_id, $topic_id, $id);
mysqli_stmt_execute($st);
$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

if($rowcount < 1)
{
	$pin = '<img id="'.$topic_id.'_'.$cat_id.'" style="cursor: pointer;" title="pin topic" class="pin" src="pin_fac.png" height="12" width="12" />';
}
else
{
	$pin = '<img id="'.$topic_id.'_'.$cat_id.'" style="cursor: pointer;" title="upin topic" class="pin" src="unpin_fac.png" height="12" width="12" />';	
}

$sqll = "SELECT * FROM topics WHERE id = ?;";
//$result = mysqli_query($connect, $sql);

$stl = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stl, $sqll))
{
	exit();
}
mysqli_stmt_prepare($stl, $sqll);
mysqli_stmt_bind_param($stl, "i", $topic_id);
mysqli_stmt_execute($stl);
$resultl = mysqli_stmt_get_result($stl);

while($row = mysqli_fetch_assoc($resultl))
{
	if($row['user_id'] == $id)
	{
		$pin .= '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer; margin-left: 5px;" title="delete topic" class="dto" src="trash.png" height="13" width="13" />';
	}
}

$sqlle = "SELECT * FROM events WHERE id = ?;";
//$result = mysqli_query($connect, $sql);

$stle = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stle, $sqlle))
{
	exit();
}
mysqli_stmt_prepare($stle, $sqlle);
mysqli_stmt_bind_param($stle, "i", $topic_id);
mysqli_stmt_execute($stle);
$resultle = mysqli_stmt_get_result($stle);

while($rowe = mysqli_fetch_assoc($resultle))
{
	if($rowe['user_id'] == $id)
	{
		$pin .= '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer; margin-left: 5px;" title="delete topic" class="dto" src="trash.png" height="13" width="13" />';
	}
}

echo $pin;

?>