<?php
include 'database_of.php';
include 'calls.php';

$search = "%{$_POST['title']}%";
$title = mysqli_real_escape_string($connect, $search);
$tid = mysqli_real_escape_string($connect, $_POST['val']);
$cate = mysqli_real_escape_string($connect, $_POST['cate']);

$output = '';
$output .= 	'<span style="float: left; font-family: Calibri; width: 100%;">';	

if(empty($cate))
{
	$a = 0;
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

		$sort = "SELECT * FROM library WHERE category_id = ? AND (`book_title` LIKE ?) ORDER BY `date` DESC LIMIT 10";
		$st = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($st, $sort))
		{
			echo "";
			exit();
		}
		mysqli_stmt_prepare($st, $sort);
		mysqli_stmt_bind_param($st, "is", $i, $title);
		mysqli_stmt_execute($st);
		$result = mysqli_stmt_get_result($st);
		$rowcount = mysqli_num_rows($result);

		if($rowcount > 0)
		{
			$a++;

			$output .= '<span style="font-family: calibri; font-size: 12px; color: gray; float: left; width: 100%; margin-top: 10px; border-top: 1px solid #8F979C;">'.$col.'</span>
						<span style="float: left;  width: 100%;">';
			while($row = mysqli_fetch_assoc($result))
			{
				$target_path = 'Files/Forum_uploads/library/' . $row['file'];
				list($name, $file) = explode(".", $row['file']);

				if($file == 'pdf')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="pdf.png" height=80 width=80 />';
				}
				elseif($file == 'pptx')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="powerpoint.png" height=80 width=80 />';
				}
				elseif($file == 'docx')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="word.png" height=80 width=80 />';
				}
				elseif($file == 'xlsx')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="excel.png" height=80 width=80 />';
				}

				$cover = '';
				if(!empty($row['cover']))
				{
					if($file == 'pdf')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="pdf.png" height=20 width=20 />';
					}
					elseif($file == 'pptx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="powerpoint.png" height=20 width=20 />';
					}
					elseif($file == 'docx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="word.png" height=20 width=20 />';
					}
					elseif($file == 'xlsx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="excel.png" height=20 width=20 />';
					}

					$img = $img.'<img style="display: block; margin: 0px auto; max-height: 80; max-width: 80;" src="Files/Forum_uploads/library/'.$row['cover'].'"';
				}

				$output .= '<span style="width: 20%; display: inline-block; margin: 10px 0px;">
								<span style="width: 100%; float: left; position: relative;">'.$img.'</span>
								<span style="text-align: center; float: left; width: 100%;">'.$row['book_title'].'</span>
								<span style="text-align: center; float: left; width: 100%; font-size: 10px; margin-top: 5px;">
									<span class="ol_but">
										Read
									</span>
									<span class="ol_but">
										<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
											Download
										</a>
									</span>
								</span>
							</span>';
			}
		}

		if($i == 10 && $a == 0)
		{
			$output .= '<span style="width: 100%; float: left;">
							<div style="font-family: monospace; font-size: 12px; font-weight: bold; color: gray;">None !</p>
						</span>';
		}		
	}
}
else
{
		$sort = "SELECT * FROM library WHERE category_id = ? AND (`book_title` LIKE ?) ORDER BY `date` DESC LIMIT 10";
		$st = mysqli_stmt_init($connect);

		if(!mysqli_stmt_prepare($st, $sort))
		{
			echo "";
			exit();
		}
		mysqli_stmt_prepare($st, $sort);
		mysqli_stmt_bind_param($st, "is", $cate, $title);
		mysqli_stmt_execute($st);
		$result = mysqli_stmt_get_result($st);
		$rowcount = mysqli_num_rows($result);

		if($rowcount < 1)
		{
			$output .= '<span style="width: 100%; float: left;">
							<div style="font-family: monospace; font-size: 12px; font-weight: bold; color: gray;">None !</p>
						</span>';
		}
		else
		{
			$i = $cate;

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

			$output .= '<span style="font-family: calibri; font-size: 12px; color: gray; float: left; width: 100%; margin-top: 10px; border-top: 1px solid #8F979C;">'.$col.'</span>
						<span style="float: left;  width: 100%;">';
			while($row = mysqli_fetch_assoc($result))
			{
				$target_path = 'Files/Forum_uploads/library/' . $row['file'];
				list($name, $file) = explode(".", $row['file']);

				if($file == 'pdf')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="pdf.png" height=80 width=80 />';
				}
				elseif($file == 'pptx')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="powerpoint.png" height=80 width=80 />';
				}
				elseif($file == 'docx')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="word.png" height=80 width=80 />';
				}
				elseif($file == 'xlsx')
				{
					$img = '<img style="display: block; margin: 0px auto;" src="excel.png" height=80 width=80 />';
				}

				$cover = '';
				if(!empty($row['cover']))
				{
					if($file == 'pdf')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="pdf.png" height=20 width=20 />';
					}
					elseif($file == 'pptx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="powerpoint.png" height=20 width=20 />';
					}
					elseif($file == 'docx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="word.png" height=20 width=20 />';
					}
					elseif($file == 'xlsx')
					{
						$img = '<img style="display: block; margin: 0px auto; position: absolute; top: 0px; left: 0px;" src="excel.png" height=20 width=20 />';
					}

					$img = $img.'<img style="display: block; margin: 0px auto; max-height: 80; max-width: 80;" src="Files/Forum_uploads/library/'.$row['cover'].'"';
				}

				$output .= '<span style="width: 20%; display: inline-block; margin: 10px 0px;">
								<span style="width: 100%; float: left; position: relative;">'.$img.'</span>
								<span style="text-align: center; float: left; width: 100%;">'.$row['book_title'].'</span>
								<span style="text-align: center; float: left; width: 100%; font-size: 10px; margin-top: 5px;">
									<span class="ol_but">
										Read
									</span>
									<span class="ol_but">
										<a href="'.$target_path.'" style="color: white; text-decoration: none;" download>
											Download
										</a>
									</span>
								</span>
							</span>';
			}

		}
}
			$output .= '</span>';
			echo $output;
			exit();

?>