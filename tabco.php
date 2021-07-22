<?php

include 'database_of.php';
include 'calls.php';

$search = "%{$_POST['title']}%";
$title = mysqli_real_escape_string($connect, $search);
$tid = mysqli_real_escape_string($connect, $_POST['val']);
$cate = mysqli_real_escape_string($connect, $_POST['cate']);
$s1 = $cate;

$output = '';

if(!empty($cate))
{
	if($tid == '')
	{
		$sort =  "SELECT * FROM topics WHERE category_id = ? AND (`topic_title` LIKE ?) ORDER BY `date` DESC";
	}
	elseif($tid == '1')
	{
		$sort =  "SELECT * FROM topics WHERE category_id = ? AND (`topic_title` LIKE ?) ORDER BY `date` ASC";
	}
	elseif ($tid == '2') {
		$sort =  "SELECT * FROM topics WHERE category_id = ? AND (`topic_title` LIKE ?) ORDER BY `date` DESC";
	}
	elseif($tid == '3')
	{
		sorted();
		$sort =  "SELECT * FROM topics WHERE category_id = ? AND (`topic_title` LIKE ?) ORDER BY `replies` DESC";
	}
	elseif($tid == '4')
	{
		sorted();
		$sort =  "SELECT * FROM topics WHERE category_id = ? AND (`topic_title` LIKE ?) ORDER BY `replies` ASC";
	}

	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sort))
	{
		echo "";
		exit();
	}
	mysqli_stmt_prepare($st, $sort);
	if(!empty($cate))
	{
		mysqli_stmt_bind_param($st, "is", $cate, $title);
	}
	else{
		mysqli_stmt_bind_param($st, "is", $s1, $title);
	}
}
else{

	if($tid == '')
	{
		$sort =  "SELECT * FROM topics WHERE (`topic_title` LIKE ?) ORDER BY `date` DESC";
	}
	elseif($tid == '1')
	{
		$sort =  "SELECT * FROM topics WHERE (`topic_title` LIKE ?) ORDER BY `date` ASC";
	}
	elseif ($tid == '2') {
		$sort =  "SELECT * FROM topics WHERE (`topic_title` LIKE ?) ORDER BY `date` DESC";
	}
	elseif($tid == '3')
	{
		sorted();
		$sort =  "SELECT * FROM topics WHERE (`topic_title` LIKE ?) ORDER BY `replies` DESC";
	}
	elseif($tid == '4')
	{
		sorted();
		$sort =  "SELECT * FROM topics WHERE (`topic_title` LIKE ?) ORDER BY `replies` ASC";
	}

	$st = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($st, $sort))
	{
		echo "";
		exit();
	}
	mysqli_stmt_prepare($st, $sort);
	mysqli_stmt_bind_param($st, "s", $title);
}
	
	mysqli_stmt_execute($st);

	$result = mysqli_stmt_get_result($st);

$rowcount = mysqli_num_rows($result);

if(mysqli_num_rows($result) < 1)
{
	$output = '<tr >
						<td style="width: 100%; height: 100%; ">
							<div style="font-family: monospace; font-size: 12px; font-weight: bold; color: gray;">None !</p>
						</td>
					</tr>';
	echo $output;
	exit();
}

if($rowcount > 1)
{
	$rowcount = $rowcount.' results';
}
else{
	$rowcount = $rowcount.' result';
}
	
	$output = '<span style="width: 100%; font-size: 12px; color: gray; margin-top: -15px;">'.$rowcount.'</span>';
	while($row = mysqli_fetch_assoc($result))
	{	
		if($row['category_id'] == '1'){
			$col = '#2D4157';
		}
		elseif ($row['category_id'] == '2') {
			$col = '#38AB26';
		}
		elseif ($row['category_id'] == '3') {
			$col = '#F4C515';
		}
		elseif ($row['category_id'] == '4') {
			$col = '#435987';
		}
		elseif ($row['category_id'] == '5') {
			$col = '#267CAB';
		}

		$row['topic_title'] = str_replace("\'", "'", $row['topic_title']);
		$row['topic_desc'] = str_replace("\'", "'", $row['topic_desc']);
		$row['topic_desc'] = str_replace('\n', "\n", $row['topic_desc']);
		$row['topic_desc'] = str_replace('\r', "\r", $row['topic_desc']);

		$query = "SELECT * FROM replies WHERE category_id = '1' AND topic_id = '".$row['id']."'";
		$submit = mysqli_query($connect, $query); 
		$replies = mysqli_num_rows($submit);

		$fresh = "SELECT `date` FROM replies WHERE category_id = '1' AND topic_id = '".$row['id']."' ORDER BY `date` DESC LIMIT 1";
		$submitf = mysqli_query($connect, $fresh); 		 
							
			$output .=  '<tr style="line-height: 40px;">
							<td style="border-top: 0.5px solid #F0F0F0; width: 100%; height: 100%; ">
								<span style="height: 100%; width: 65%; float: left;">
									<div class="topic_link" id='.$row['id'].' data-cat = '.$row['category_id'].' style="width:100%; cursor:pointer; height: 28px; margin:0px; color: '.$col.'; font-size: 16px; vertical-align: top;  overflow:hidden;">'.$row['topic_title'].'
									</div>
									<div style="width:100%; height:26px; display:block; color: #B3B3B3; font-size: 13px; vertical-align: top; margin: 0px; padding:0px; overflow:hidden;">'.nl2br($row['topic_desc']).'
									</div>
								</span>
								<span style="width:15%; display:inline; float:left; color: gray; font-size: 14px; ">'.$replies.'</span>';
								while($rowf = mysqli_fetch_assoc($submitf))
								{	
									$fr = $rowf['date'];
									$output .= '<span style="width:20%; color: gray; float:right; display:inline; font-size: 14px;">'.agoTime(cut($fr)).'</span>';
								}
					$output	.= '</td>
						</tr>';
	}

echo $output;

	function sorted()
	{
		include 'database_of.php';

		$up = "SELECT * FROM topics WHERE category_id = '1'";
		$upts = mysqli_query($connect, $up);

		while($row = mysqli_fetch_assoc($upts))
		{
			$topic_id = $row['id'];
			$category_id = $row['category_id'];

			$sqs = "SELECT * FROM replies WHERE topic_id = ? AND category_id = ?;";
			//$result = mysqli_query($connect, $sql);
			$sts = mysqli_stmt_init($connect);

			if(!mysqli_stmt_prepare($sts, $sqs))
			{
				exit();
			}
			mysqli_stmt_prepare($sts, $sqs);
			mysqli_stmt_bind_param($sts, "ii", $topic_id, $category_id);
			mysqli_stmt_execute($sts);

			$resultsq = mysqli_stmt_get_result($sts);
			$rowcountsq = mysqli_num_rows($resultsq);

			$status = "UPDATE topics SET replies = '$rowcountsq' WHERE id = '".$row['id']."'";
			$results = mysqli_query($connect, $status);
		}	
	}

//<tr><td style="border-bottom: 0.5px solid #F0F0F0; width:100%;"><span style="color: #429AA4; font-size: 14px; font-weight:bold; font-family: Calibri;">Results</td></tr>
?>