<?php
include 'database_of.php';
include 'calls.php';

$cat_id = $_POST['tid'];
$sql = "SELECT * FROM topics WHERE category_id = '$cat_id' ORDER BY `date` DESC";
$result = mysqli_query($connect, $sql);
$rowcount = mysqli_num_rows($result);

if($cat_id == '1')
{
	$src = 'opentw';
	$col = '#2D4157';
}
elseif ($cat_id == '2') {
	$src = 'fhw';
	$col = '#38AB26';
}
elseif ($cat_id == '3') {
	$src = 'hmjw';
	$col = '#F4C515';
}
elseif ($cat_id == '4') {
	$src = 'prw';
	$col = '#435987';
}
elseif ($cat_id == '5') {
	$src = 'pdw';
	$col = '#267CAB';
}

$output = '';

	$output = 	'<span class="shtr" style="position: absolute; left: 2px; top: 2px;">
					<img id="snh" src="show_tray.png" height="12" width="12" />
				</span>
				<span style="width: 96%; height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
						<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right; border-bottom: 2px solid #F4F4F4; overflow: hidden; position: relative;">
								<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
									<span class="topic_stat">
										<img id="add_forum" class="add_forum" src="add_forum_off.png" height=30 width=30 title="add topic">
									</span>
									<img style="float: right;" src="'.$src.'.png" height=58 width=58>
									</span>
						</span>
						<span class="aff" style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 29%; width: 100%; float: right;" hidden>
							<form method="POST" id="submitfac" action="upfa.php" onsubmit="return false;">
								<input class="topic_title" name="topic_title" placeholder="Topic title:" required>
								<span style="width: 28%; float: right; overflow: hidden; cursor: pointer;  display: inline; margin-top: -20px;">
									<select name="type_selecta" class="type_selecta" hidden>
										<option value= "'.$cat_id.'">Category..</option>
									</select>
									<label class="isset" for="ff">
										<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />
									</label>
									<input type="file" style="display: none;" name="file" id="ff" accept=".pdf, .zip" />
								</span>
								<textarea class="topic_desc" id="txta" name="topic_desc" placeholder="Topic description:" required></textarea>
							</form>
						</span>
						<span style="float: left; width: 70%; height: 26px; border-radius: 2px; border: 1px solid #D8D8D8; margin: 15px 0px;">
										<select id="cate" class="type_select" hidden>
												<option value= "'.$cat_id.'">Category..</option>
										</select>
										<span style="width: 94%; height: 100%; float: left;">
												<span style="width: 96%; float: right; height: 100%;">
													<input class="topic_search" name="title" placeholder="Enter topic title..">
													<span style="color: #D8D8D8; font-family: verdana; font-size: 13px; font-weight: bold;" hidden>
														x
													</span>
												</span>
										</span>
										<span style="width: 6%; height: 100%; float: right; background-color: '.$col.';">
											<img class="srbtn" src="search.png" height="11" width="11" style="margin: 7px 10px;">
										</span>
						</span>
						<span style="width: 13%; float: right; height: 26px; border-radius: 2px; border: 1px solid #D8D8D8; margin: 15px 0px;">
								<select name="type" class="type_select2">
									<option value="" disabled selected>Sort by..</option>
									<option value="1">Date lowest</option>
									<option value="2">Date highest</option>
									<option value="3">Fame highest</option>
									<option value="4">Fame lowest</option>
								</select>
						</span>
						<span class="faculty_view" style="max-height: 88%; width: 100%; float: right;">';
						
						
	$output .= '<span style="height: 6%; width: 100%; float: left;">
								<table style="text-align: left; font-family: Calibri; width: 100%;">
									<tr><td style="width:64.5%; color: '.$col.'; font-size: 16px; font-weight: bold;">Topics</td>
										<td style="width:15%; color: '.$col.'; font-size: 16px; font-weight: bold;">Replies</td>
										<td style="width:20.5%; color: '.$col.'; font-size: 16px; font-weight: bold;">Freshness</td>
									</tr>
								</table>
				</span>';
	$output .= 	'<table class="tabco" style="text-align: left; font-family: Calibri; width: 100%;">';
	if($rowcount < 1)
	{
		$output .= '<tr >
						<td style="width: 100%; height: 100%; ">
							<div style="font-family: monospace; font-size: 12px; font-weight: bold; color: gray;">None !</p>
						</td>
					</tr>';
	}
	while($row = mysqli_fetch_assoc($result))
	{	

		$row['topic_title'] = str_replace("\'", "'", $row['topic_title']);
		$row['topic_desc'] = str_replace("\'", "'", $row['topic_desc']);
		$row['topic_desc'] = str_replace('\n', "\n", $row['topic_desc']);
		$row['topic_desc'] = str_replace('\r', "\r", $row['topic_desc']);

		$query = "SELECT * FROM replies WHERE category_id = ".$cat_id." AND topic_id = '".$row['id']."'";
		$submit = mysqli_query($connect, $query); 
		$replies = mysqli_num_rows($submit);

		$fresh = "SELECT `date` FROM replies WHERE category_id = ".$cat_id." AND topic_id = '".$row['id']."' ORDER BY `date` DESC LIMIT 1";
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

	$output .= '</table>
			</span>';
echo $output;

?>