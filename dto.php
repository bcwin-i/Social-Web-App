<?php
include 'database_of.php';
list($tid, $cid) = explode("_", $_POST['id']);
$empty = '';

$sqlr = "SELECT * FROM replies WHERE topic_id = ? AND category_id = ?;";
//$submit = mysqli_query($connect, $sqlr);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sqlr))
{
	exit();
}
mysqli_stmt_prepare($st, $sqlr);
mysqli_stmt_bind_param($st, "ii", $tid, $cid);
mysqli_stmt_execute($st);
$submit = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($submit);

if($rowcount > 0)
{
	while($row = mysqli_fetch_assoc($submit)){
		$rid = $row['id'];
		if($row['file'] != '')
		{
			if(unlink($row['file_loc']))
			{
				$pd = "DELETE FROM replies WHERE id = '$rid'";
				$piq = mysqli_query($connect, $pd);
			}	
		}
		else
		{
			$pd = "DELETE FROM replies WHERE id = '$rid'";
			$piq = mysqli_query($connect, $pd);
		}
	}
}

$sqlt = "SELECT * FROM topics WHERE id = ? AND category_id = ?;";
//$resultt = mysqli_query($connect, $sqlt);
$stt = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stt, $sqlt))
{
	exit();
}
mysqli_stmt_prepare($stt, $sqlt);
mysqli_stmt_bind_param($stt, "ii", $tid, $cid);
mysqli_stmt_execute($stt);
$resultt = mysqli_stmt_get_result($stt);

while($rowf = mysqli_fetch_assoc($resultt))
{
	$rid = $rowf['id'];
	if($rowf['file'] != '')
	{
		if(unlink($rowf['file_loc']))
		{
			$pd = "DELETE FROM topics WHERE id = '$rid'";
			$piq = mysqli_query($connect, $pd);
		}	
	}
	else
	{
		$pd = "DELETE FROM topics WHERE id = '$rid'";
		$piq = mysqli_query($connect, $pd);
	}
}


//........................Events.....................................
$sqlte = "SELECT * FROM events WHERE id = ?;";
//$resultt = mysqli_query($connect, $sqlt);
$stte = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stte, $sqlte))
{
	exit();
}
mysqli_stmt_prepare($stte, $sqlte);
mysqli_stmt_bind_param($stte, "i", $tid);
mysqli_stmt_execute($stte);
$resultte = mysqli_stmt_get_result($stte);

while($rowfe = mysqli_fetch_assoc($resultte))
{
	$rid = $rowfe['event_title'];
	$eid = $rowfe['id'];

	if($rowf['file'] != '0')
	{
		$sqle = "SELECT * FROM event_poster WHERE event_name = '$rid'";
		$resulte = mysqli_query($connect, $sqle);
		if($rowf = mysqli_fetch_assoc($resulte))
		{
			$file = $rowf['file_loc'];
			if(!unlink($file))
			{
				exit();
			}
			$pde = "DELETE FROM events WHERE id = '$eid'";
			$piqe = mysqli_query($connect, $pde);
		}
	}
	else{
		$pde = "DELETE FROM events WHERE id = '$eid'";
		$piqe = mysqli_query($connect, $pde);
	}
}

$sqld = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ?;";
$std = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($std, $sqld))
{
	exit();
}
mysqli_stmt_prepare($std, $sqld);
mysqli_stmt_bind_param($std, "ii", $cid, $tid);
mysqli_stmt_execute($std);
$resultd = mysqli_stmt_get_result($std);

while($rowd = mysqli_fetch_assoc($resultd))
{
	$dfr = $rowd['id'];
	$df = "DELETE FROM forum_notification_request WHERE id = '$dfr'";
	$dfe = mysqli_query($connect, $df);
}

echo $cid;
?>