<?php
session_start();
include 'database_of.php';
include 'calls.php';
$id = $_SESSION['user_id'];
$s1 = 1;

list($cid, $tid, $cat_id) = explode("_", $_POST['id']);

$sql = "SELECT * FROM replies WHERE id = ?;";
//$result = mysqli_query($connect, $sql);

$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "i", $cid);
mysqli_stmt_execute($st);
$result = mysqli_stmt_get_result($st);

while($rowf = mysqli_fetch_assoc($result))
{
	if($rowf['file'] != '')
	{
		$rid = $rowf['id'];
		if(unlink($rowf['file_loc']))
		{
			$pd = "DELETE FROM replies WHERE id = '$rid'";
			$piq = mysqli_query($connect, $pd);
		}	
	}
}

$sqlr = "DELETE FROM replies WHERE id = ?;";
//$resultr = mysqli_query($connect, $sqlr);
$str = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($str, $sqlr))
{
	exit();
}
mysqli_stmt_prepare($str, $sqlr);
mysqli_stmt_bind_param($str, "i", $cid);
mysqli_stmt_execute($str);

$query = "SELECT * FROM replies WHERE topic_id = ?  AND category_id = ? ORDER BY `date` DESC";
//$submit = mysqli_query($connect, $query); 
$stq = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($stq, $query))
{
	exit();
}
mysqli_stmt_prepare($stq, $query);
mysqli_stmt_bind_param($stq, "ii", $tid, $cat_id);
mysqli_stmt_execute($stq);
$submit = mysqli_stmt_get_result($stq);

$output = '';

while($rowr = mysqli_fetch_assoc($submit))
						{
							$rowr['comment'] = str_replace("\'", "'", $rowr['comment']);
							$rowr['comment'] = str_replace(" ", "&nbsp", $rowr['comment']);
							$rowr['comment'] = str_replace('\n', "\n", $rowr['comment']);
							$rowr['comment'] = str_replace('\r', "\r", $rowr['comment']);
							if($rowr['user_id'] == $id)
							{
								$sid = $rowr['id']."_".$rowr['topic_id'];
								$del = '<span id= '.$sid.'  class="dlr" style="color: #CCCCCC; float:left; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana; cursor:pointer;">Delete</span>';
							}
							else{
								$del = '';
							}
							$output .= '<span style="width: 95%; float: right; border-bottom: 0.5px solid #F0F0F0;">
											<span style="width: 100%; float: right;">
												<span style="font-size: 10px; float: right; font-family: verdana; color: gray;">
													<span style="color: #CCCCCC; font-family: Calibri; padding-right: 5px; font-size: 10px;">posted by
													</span>
													'.user_name($rowr['user_id']).'
												</span>
												<span style="font-size: 14px; width: 100%; float:left; font-family: Calibri;  	color: #4D4D4D; margin-top: 8px; margin-bottom: 4px;">
													'.nl2br($rowr['comment']).'
												</span>
												<span style="width: 100%; float:left; margin-bottom: 3px;">
													'.$rowr['file'].'
												</span>
												<span style="color: #2D4157; float:left; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana; cursor:pointer;">Reply</span>
												'.$del.'
												<span style="color: #CCCCCC; float:right; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana;" title="'.ut($rowr['date']).'">
													'.ut($rowr['date']).'
												</span>
											</span>
										</span>';
			}

echo $output;

?>