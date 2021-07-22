<?php
session_start();
include 'database_of.php';
include 'calls.php';
$id = $_SESSION['user_id'];

$topic_id = $_POST['id'];
$cat_id = $_POST['tid'];
$s1 = $cat_id;
$i = $cat_id;

if($i == '1'){
	$col = 'GENERAL WORKS';
	$src = 'GW';
}
elseif ($i == '2') 
{
	$col = 'PHYLOSOPHY & PSYCHOLOGY';
	$src = 'PP';
}
elseif ($i == '3') 
{
	$col = 'RELIGION';
	$src = 'RL';
}
elseif ($i == '4') 
{
	$col = 'SCOCIAL & SCIENCES';
	$src = 'SS';
}
elseif ($i == '5') 
{
	$col = 'LANGUAGE';
	$src = 'LN';
}
elseif ($i == '6') 
{
	$col = 'SCIENCE';
	$src = 'SC';
}
elseif ($i == '7') 
{
	$col = 'TECHNOLOGY & APPLIED SCIENCE';
	$src = 'TS';
}
elseif ($i == '8') 
{
	$col = 'ARTS & RECREATION';
	$src = 'AR';
}
elseif ($i == '9') 
{
	$col = 'LITERATURE';
	$src = 'LT';
}	
elseif ($i == '10') 
{
	$col = 'HISTORY';
	$src = 'HG';
}

$sql = "SELECT * FROM library WHERE id = ?";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "i", $topic_id);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);

$output = '';
$output .= '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
					<img id="snh" src="show_tray.png" height="12" width="12" />
			</span>
			<span style="width: 96%; max-height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
						<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right; border-bottom: 2px solid #F4F4F4; overflow: hidden;">
								<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
									<span >
										<span id="add_forum" style="font-size: 12px; float:left;"><span class="back_to_faculty" style="color: #404B5C; font-weight: bold; cursor:pointer;">Home</span><span style="color: #B3B3B3; font-size: 12px;"><span style="font-family: monospace; font-weight: bold; font-size: 10px; margin: 0px 3px;">-</span><span class="ol_op" id='.$cat_id.' style="color: '.$col.'; cursor: pointer;">'.$col.'</span><span style="font-family: monospace; font-weight: bold; font-size: 10px; margin: 0px 3px;">-</span>Topics</span>
										</span>
									</span>
									<span style="float: right; width: 15%; height: 100%; position: relative; color: #1E2E39;">
										<span style="position: absolute; width: 100%; top: 0px; text-align: center; font-size: 40px; font-family: calibri; font-weight: bold; margin-top: -5px;">'.$src.'
											<span style="font-size: 10px; float: left; width: 100%; margin-top: -10px;">'.$col.'</span>
										</span>
									</span>
								</span>
						</span>
						<span class="faculty_view" style="max-height: 88%; width: 100%; float: right;">';

while($row = mysqli_fetch_assoc($result))
{
	$query = "SELECT * FROM reviews WHERE cat_id = ".$cat_id." AND book_id = '".$row['id']."' ORDER BY `date` DESC";
	$submit = mysqli_query($connect, $query); 
	$rowcount = mysqli_num_rows($submit);

	if($rowcount > 1)
	{
		$rowcount = $rowcount.' comments';
	}
	else{
		$rowcount = $rowcount.' comment';
	}
	
 	$pin = "SELECT * FROM forum_notification_request WHERE cat_id = ? AND topic_id = ? AND user_id = ?;";
	//$qp = mysqli_query($connect, $pin);
 	$stq = mysqli_stmt_init($connect);

	if(!mysqli_stmt_prepare($stq, $pin))
	{
		exit();
	}
	mysqli_stmt_prepare($stq, $pin);
	mysqli_stmt_bind_param($stq, "iii", $s1, $topic_id, $id);
	mysqli_stmt_execute($stq);
	$qp = mysqli_stmt_get_result($stq);

	$rqp = mysqli_num_rows($qp);

	if($rqp < 1)
	{
		$pin = '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer;" title="pin topic" class="pin" src="pin_fac.png" height="12" width="12" />';
	}
	else
	{
		$pin = '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer;" title="upin topic" class="pin" src="unpin_fac.png" height="12" width="12" />';	
	}

	$trash = '';
	if($row['user_id'] == $id)
	{
		$trash = '<img id="'.$row['id'].'_'.$row['category_id'].'" style="cursor: pointer; margin-left: 5px;" title="delete topic" class="dto" src="trash.png" height="13" width="13" />';
	}

	$target_path = 'Files/Forum_uploads/library/' . $row['file'];
	list($name, $file) = explode(".", $row['file']);

	if($file == 'pdf')
	{
		$img = '<img style="display: block; margin: 0px auto;" src="pdf.png" height=80 width=80 />';
		$bun = '<span class="ol_but" id="ol_bur" data-id='.$row['id'].'>
					Read
				</span>
				<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
					<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
						Download
					</a>
				</span>';
	}
	elseif($file == 'pptx')
	{
		$img = '<img style="display: block; margin: 0px auto;" src="powerpoint.png" height=80 width=80 />';
		$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
					<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
						Download
					</a>
				</span>';

	}
	elseif($file == 'docx')
	{
		$img = '<img style="display: block; margin: 0px auto;" src="word.png" height=80 width=80 />';
		$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
					<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
						Download
					</a>
				</span>';
	}
	elseif($file == 'xlsx')
	{
		$img = '<img style="display: block; margin: 0px auto;" src="excel.png" height=80 width=80 />';
		$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
					<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
						Download
					</a>
				</span>';
	}
	if(!empty($row['cover']))
	{
			if($file == 'pdf')
					{
						$img = '<img style="display: block; position: absolute; top: 0px; left: 0px;" src="pdf.png" height=20 width=20 />';
						$bun = '<span class="ol_but" id="ol_bur" data-id='.$row['id'].'>
									Read
								</span>
							<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
								<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
									Download
								</a>
							</span>';

					}
					elseif($file == 'pptx')
					{
						$img = '<img style="display: block; position: absolute; top: 0px; left: 0px;" src="powerpoint.png" height=20 width=20 />';
						$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
								<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
									Download
								</a>
							</span>';
					}
					elseif($file == 'docx')
					{
						$img = '<img style="display: block; position: absolute; top: 0px; left: 0px;" src="word.png" height=20 width=20 />';
						$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
								<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
									Download
								</a>
							</span>';
					}
					elseif($file == 'xlsx')
					{
						$img = '<img style="display: block; position: absolute; top: 0px; left: 0px;" src="excel.png" height=20 width=20 />';
						$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
								<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
									Download
								</a>
							</span>';
					}

					$img = $img.'<img style="display: block; margin: 0px auto; max-height: 80; max-width: 80;" src="Files/Forum_uploads/library/'.$row['cover'].'"/>';
	}

	$row['topic_title'] = str_replace("\'", "'", $row['book_title']);
	$row['topic_desc'] = str_replace("\'", "'", $row['book_desc']);
	$row['topic_desc'] = str_replace('\n', "\n", $row['book_desc']);
	$row['topic_desc'] = str_replace('\r', "\r", $row['book_desc']);

	$output .= '<span style="float: left; width:100%; margin:0px; margin-top: 10px; max-height: 100%; overflow: scroll; margin-bottom: 0px;">
					<span ="width: 100%; float: left;">	
						<span style="font-family: verdana; font-size: 13px; font-weight: bold; color: #1E2E39; vertical-align: middle; width: 68%; float:left;">
							<img style="border-radius: 50%;" src="Files/Profile/profile'.$row['user_id'].'.jpg" height="32" width="32">
							<span style="vertical-align: 70%; margin-left: 5px;">'.user_name($row['user_id']).'</span>
						</span>
						<span style="font-size: 11px; color: #CCCCCC; float: right; width: 32%;">
							<span style="float:right;">
								<span style="font-size:11px; color: #1A636B; font-family: Calibri; margin-left: 5px;">
									'.ut($row['date']).'
									<span class="pivi" hidden>'.$pin.''.$trash.'</span>
									<img class="option_pin" src="option.png" height="10" width="11" />
								</span>
							</span>
						</span>
					</span>
					<span style="width: 98%; float: left; margin: 0px 1%; margin-top: 20px; font-family: Calibri;  color: #4D4D4D;">
						<span style="font-size: 17px; font-weight: bold; width: 100%; float:left;">'.$row['book_title'].'</span>
						<span style="font-size: 15px; width: 100%; margin-top: 10px; float:left;">'.nl2br($row['book_desc']).'</span>
						<span style="width: 20%; display: inline-block; margin: 10px 0px; border-radius: 3px; border: 1px solid #D8D8D8; padding: 5px;">
							<span style="width: 100%; float: left; position: relative; cursor:pointer;">'.$img.'</span>
							<span style="text-align: center; float: left; width: 100%; font-size: 10px; margin-top: 5px;">
								'.$bun.'
							</span>
						</span>';
			if($row['user_id'] == $id)
			{			
			$output .= '<span class="add_book">
							<span style="float: left;">Add book</span>
							<img style="float: right;" src="alib.png" height=20 width=20 />
						</span>';
			}
	$output .= '</span>
					<span id='.$row['id'].' data-cat='.$cat_id.' class="reply-link">
					<span class="num_of" style="float: left; color: #BFBFBF; font-family: monospace; font-size: 12px;">
						'.$rowcount.'
					</span>
					<span style="float: right; color:#1E2E39;">comment</span></span>
					<span class="f_r_a" style="style="width: 98%; margin: 1% 1%;" hidden>
						<span id="fac_re" class="a_reply" method="POST" action="upfr.php">
								<form method="POST">
									<input type="hidden" value='.$cat_id.' name="cat">
									<textarea class="reply_desc" id="txta" name="topic_reply" placeholder="comment:" required></textarea>
									<label class="issetfr" for="ffr">
										<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />
									</label>
									<input type="file" style="display: none;" name="file" id="ffr" accept=".pdf, .jpg, .png, .gif" />
									<input type = "hidden" name = "id" value = '.$row['id'].'>
									<span class="change" style="float: left; margin-left: 2px;">comment</span>
								</form>
						</span>
					</span>
					<span class="replies_rep" style="width: 98%; margin: 0%; padding: 0% 1%; margin-bottom: 5%; border-top: 1px solid #F0F0F0; float:left; max-height: 60%; overflow-x: hidden; overflow-y: scroll;">';
						while($rowr = mysqli_fetch_assoc($submit))
						{
							$rowr['comment'] = str_replace("\'", "'", $rowr['comment']);
							$rowr['comment'] = str_replace(" ", "&nbsp", $rowr['comment']);
							$rowr['comment'] = str_replace('\n', "\n", $rowr['comment']);
							$rowr['comment'] = str_replace('\r', "\r", $rowr['comment']);
							if($rowr['user_id'] == $id)
							{
								$sid = $rowr['id']."_".$rowr['topic_id']."_".$cat_id;
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
												'.$del.'
												<span style="color: #CCCCCC; float:right; padding-right: 5px; font-size: 7px; margin: 3px 0px; font-family: verdana;" title="'.ut($rowr['date']).'">
													'.ut($rowr['date']).'
												</span>
											</span>
										</span>';
						}
		$output .=	'</span>	
				</span>';
				
		
}


echo $output;

?>