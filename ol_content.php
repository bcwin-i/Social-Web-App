<?php
include 'database_of.php';
include 'calls.php';


$output = '';

	$output = 	'<span class="shtr" style="position: absolute; left: 2px; top: 2px;">
					<img id="snh" src="show_tray.png" height="12" width="12" />
				</span>
				<span class="loader" style="position: absolute; right: 3px; top: 3px;" hidden>
					<img  src="load.gif" height="6" width="25" />
				</span>
				<span style="width: 96%; height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
						<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right; border-bottom: 2px solid #F4F4F4; overflow: hidden; position: relative;">
								<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
									<span class="topic_sol">
										<img id="add_forum" class="add_ol" src="add_lib.png" height=30 width=30 title="Upload file">
									</span>
									<img style="float: right;" src="faculty_whole.png" height=50 width=50>
									</span>
						</span>
						<span class="olf" style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 29%; width: 100%; float: right;" hidden>
							<form method="POST" id="submitol" action="upol.php" onsubmit="return false;">
								<input class="book_title" name="book_title" placeholder="Book title:" required>
								<span style="width: 28%; float: right; overflow: hidden; cursor: pointer;  display: inline; margin-top: -20px;">
									<select name="type_selecta" id="olse" class="type_selecta">
										<option value="0" disabled selected>Category..</option>
										<option value="1">GENERAL WORKS</option>
										<option value="2">PHYLOSOPHY & PSYCHOLOGY</option>
										<option value="3">RELIGION</option>
										<option value="4">SCOCIAL & SCIENCES</option>
										<option value="5">LANGUAGE</option>
										<option value="6">SCIENCE</option>
										<option value="7">TECHNOLOGY & APPLIED SCIENCE</option>
										<option value="8">ARTS & RECREATION</option>
										<option value="9">LITERATURE</option>
										<option value="10">HISTORY</option>
									</select>
									<label class="isset" for="ffol">
										<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />
									</label>
									<input type="file" style="display: none;" name="file" id="ffol" accept=".pdf, .pptx, .docx, .xlsx" />
								</span>
								<span style="width: 100%; float: right; font-size: 14px; color: gray; text-align: right;">
									cover page(optional) 
									<label class="issetc" for="ffolc">
										<img style="float: right; margin-left: 8px; cursor: pointer;" src="uplc.png"  height="18" width="18" title="attach file" />
									</label>
									<input type="file" style="display: none;" name="cover" id="ffolc" accept=".png, .jpg" />
								</span>
								<textarea class="book_desc" id="txta" name="book_desc" placeholder="Book description:" required></textarea>
							</form>
						</span>
						<span style="float: left; width: 70%; height: 26px; border-radius: 2px; border: 1px solid #D8D8D8; margin: 15px 0px;">
										<span style="width: 94%; height: 100%; float: left;">
												<span style="width: 25%; float: left; height: 100%; border-right: 1px solid #F4F4F4; ">
													<select id="cate" class="type_select">
														<option value="" >Category (All)</option>
														<option value="1">GENERAL WORKS</option>
														<option value="2">PHYLOSOPHY & PSYCHOLOGY</option>
														<option value="3">RELIGION</option>
														<option value="4">SCOCIAL & SCIENCES</option>
														<option value="5">LANGUAGE</option>
														<option value="6">SCIENCE</option>
														<option value="7">TECHNOLOGY & APPLIED SCIENCE</option>
														<option value="8">ARTS & RECREATION</option>
														<option value="9">LITERATURE</option>
														<option value="10">HISTORY</option>
													</select>
												</span>

												<span style="width: 72%; float: right; height: 100%;">
													<input class="topic_search" name="title" placeholder="Enter book title..">
													<span style="color: #D8D8D8; font-family: verdana; font-size: 13px; font-weight: bold;" hidden>
														x
													</span>
												</span>
										</span>
										<span style="width: 6%; height: 100%; float: right; background-color: #1E2E39;">
											<img class="srol" src="search.png" height="11" width="11" style="margin: 7px 10px;">
										</span>
						</span>
						<span style="width: 13%; float: right; height: 26px; border-radius: 2px; border: 1px solid #D8D8D8; margin: 15px 0px;">
								<select name="type" class="type_select2">
									<option value="" disabled selected>Sort by..</option>
									<option value="1">Date lowest</option>
									<option value="2">Date highest</option>
									<option value="3">Views highest</option>
									<option value="4">Download highest</option>
								</select>
						</span>
						<span class="ol_view" style="max-height: 80%; width: 100%; float: right; overflow-y: scroll;">';
						
						
	/*$output .= '<span style="height: 6%; width: 100%; float: left;">
								<table style="text-align: left; font-family: Calibri; width: 100%;">
									<tr><td style="width:64.5%; color: #429AA4; font-size: 16px; font-weight: bold;">Topics</td>
										<td style="width:15%; color: #429AA4; font-size: 16px; font-weight: bold;">Replies</td>
										<td style="width:20.5%; color: #429AA4; font-size: 16px; font-weight: bold;">Freshness</td>
									</tr>
								</table>
				</span>';*/
	$output .= 	'<span style="float: left; font-family: Calibri; width: 100%;">';
	

	for($i=1; $i<=10; $i++)
	{
		if($i == '1'){
		$col = 'GENERAL WORKS';
		}
		elseif ($i == '2') {
			$col = 'PHYLOSOPHY & PSYCHOLOGY';
		}
		elseif ($i == '3') {
			$col = 'RELIGION';
		}
		elseif ($i == '4') {
			$col = 'SCOCIAL & SCIENCES';
		}
		elseif ($i == '5') {
			$col = 'LANGUAGE';
		}
		elseif ($i == '6') {
			$col = 'SCIENCE';
		}
		elseif ($i == '7') {
			$col = 'TECHNOLOGY & APPLIED SCIENCE';
		}
		elseif ($i == '8') {
			$col = 'ARTS & RECREATION';
		}
		elseif ($i == '9') {
			$col = 'LITERATURE';
		}	
		elseif ($i == '10') {
			$col = 'HISTORY';
		}


		$sql = "SELECT * FROM library WHERE category_id = '$i' ORDER BY `date` DESC LIMIT 10";
		$result = mysqli_query($connect, $sql);
		$rowcount = mysqli_num_rows($result);

		if($rowcount > 0)
		{
			$output .= '<span style="font-family: calibri; font-size: 12px; color: gray; float: left; width: 100%; margin-top: 10px; border-top: 1px solid #CCCCCC;">'.$col.'</span>
						<span style="float: left;  width: 100%;">';
			while($row = mysqli_fetch_assoc($result))
			{
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

				$cover = '';
				if(!empty($row['cover']))
				{
					if($file == 'pdf')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="pdf.png" height=20 width=20 />';
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
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="powerpoint.png" height=20 width=20 />';
						$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
								<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
									Download
								</a>
							</span>';
					}
					elseif($file == 'docx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="word.png" height=20 width=20 />';
						$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
								<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
									Download
								</a>
							</span>';
					}
					elseif($file == 'xlsx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="excel.png" height=20 width=20 />';
						$bun = '<span class="ol_but" id="ol_bud" data-id='.$row['id'].'>
								<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
									Download
								</a>
							</span>';
					}

					$img = $img.'<img style="display: block; margin: 0px auto; max-height: 80; max-width: 80;" src="Files/Forum_uploads/library/'.$row['cover'].'"';
				}

				$output .= '<span style="width: 20%; display: inline-block; margin: 10px 0px;">
								<span class="book_c" id='.$row['id'].' data-tid='.$row['category_id'].' style="width: 100%; float: left; position: relative; cursor:pointer;">'.$img.'</span>
								<span style="text-align: center; float: left; width: 100%;">'.$row['book_title'].'</span>
								<span style="text-align: center; float: left; width: 100%; font-size: 10px; margin-top: 5px;">
									'.$bun.'
								</span>
							</span>';
			}
			$output .= '</span>';
		}
	}

	$output .= '</span>
			</span>';
echo $output;

?>