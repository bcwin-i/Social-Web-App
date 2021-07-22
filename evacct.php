<?php

	include 'database_of.php';
	include 'calls.php';
	session_start();
	$id = $_SESSION['user_id'];
	$name =	user_name($id);
	$current_timestamp = date('Y-m-d H:i:s');
	$output = '';

	$sql = "SELECT * FROM vote_alternatives WHERE choice = '$name';";
	$result = mysqli_query($connect, $sql);
	$rowcounts = mysqli_num_rows($result);

	$sqlec = "SELECT * FROM vote_choice WHERE  user_id = '$id';";
	$resultec = mysqli_query($connect, $sqlec);
	$rowcountec = mysqli_num_rows($resultec);

	$rowcounts = mysqli_num_rows($result);
	if($rowcounts + $rowcountec < 1)
	{
			$output.= '<table style="text-align: left; font-family: Calibri; width: 100%;">
					<tr >
						<td style="width: 100%; height: 100%; ">
							<div style="font-family: monospace; font-size: 12px; font-weight: bold; color: gray;">None !</p>
						</td>
					</tr>
				</table>';
	}
	else
	{
		
		if($rowcounts > 0)
		{
			$output .= 	'<table style="text-align: left; font-family: Calibri; width: 100%;">
					<tr>
						<td style="color: #808080; font-size: 13px; ">
							Contesting
						</td>
					<tr>';
			while($row = mysqli_fetch_assoc($result))
			{
				$contest_name = cn($row['contest_id']);
				$contest_name = str_replace("\'", "'", $contest_name);
				$contest_status = cs($row['contest_id']);
				$contest_type = ct($row['contest_id']);

				if($contest_status == 'inactive')
				{
					$contest_status = 'Pending';
					if($contest_type == '10')
					{
						$contest_status = '<span style="color: #1E2D38;">Pending</span>';
					}
				}
				if($contest_status == 'active')
				{
					$contest_status = '<span >Active</span>';
				}
				if($contest_type  == '4')
				{
					$table_data = '<td class="vact_na" id="'.$row['contest_id'].'" style="float: left; width: 96%; height: 96%; margin: 2%; background-image: url(choice_con.png); background-size: cover; background-repeat: no-repeat;  overflow: hidden; border: 1px solid #F0F0F0; position: relative; cursor: pointer;">';
	 			}
	 			elseif ($contest_type  == '10')
	 			{
	 				$table_data = '<td class="vact_na" id="'.$row['contest_id'].'" style="float: left; width: 96%; height: 96%; margin: 2%; background-image: url(con_con.png); background-size: cover; background-repeat: no-repeat;  overflow: hidden; border: 1px solid #F0F0F0; position: relative; cursor: pointer;">';
	 			}

				$output .=  '<tr style="width: 33%; display: inline-block; height: 220px;">
								'.$table_data.'
									<span style="position: absolute; top: 0px; left: 0px; width: 100%; height: 10%; float: left;">
										<span style="float: right; margin: 3px; font-family: monospace;  font-size: 10px;">
											'.$contest_status.'
										</span>
									</span>
									<span class="contest_n">
										<span style="float: left; width: 100%; margin: 5px; color: #1E2D38; font-size: 16px; font-family: Calibri; text-align: middle; font-weight: bold;">
											'.$contest_name.'
										</span>
									</span>
								</td>
							</tr>';
			}
		}

		if($rowcountec > 0)
		{
			$output .= '</table>';
			$output .= 	'<table style="text-align: left; font-family: Calibri; width: 100%; margin-top: 17px;">
						<tr>
							<td style="border-top: 1px solid #C4C4C4; color: #808080; font-size: 14px;">
								Participating
							</td>
						<tr>';

			while($rowe = mysqli_fetch_assoc($resultec))
			{
				$contest_name = cn($rowe['contest_id']);
				$contest_name = str_replace("\'", "'", $contest_name);
				$contest_status = cs($rowe['contest_id']);
				$contest_type = ct($rowe['contest_id']);

				if($contest_status == 'inactive')
				{
					$contest_status = 'Pending';
					if($contest_type == '10')
					{
						$contest_status = '<span style="color: #1E2D38;">Pending</span>';
					}
				}
				if($contest_status == 'active')
				{
					$contest_status = '<span >Active</span>';
				}
				if($contest_type  == '4')
				{
					$table_data = '<td class="vact_na" id="'.$rowe['contest_id'].'" style="float: left; width: 96%; height: 96%; margin: 2%; background-image: url(choice_con.png); background-size: cover; background-repeat: no-repeat;  overflow: hidden; border: 1px solid #F0F0F0; position: relative; cursor: pointer;">';
	 			}
	 			elseif ($contest_type  == '10')
	 			{
	 				$table_data = '<td class="vact_na" id="'.$rowe['contest_id'].'" style="float: left; width: 96%; height: 96%; margin: 2%; background-image: url(con_con.png); background-size: cover; background-repeat: no-repeat;  overflow: hidden; border: 1px solid #F0F0F0; position: relative; cursor: pointer;">';
	 			}

				$output .=  '<tr style="width: 33%; display: inline-block; height: 220px;">
								'.$table_data.'
									<span style="position: absolute; top: 0px; left: 0px; width: 100%; height: 10%; float: left;">
										<span style="float: right; margin: 3px; font-family: monospace;  font-size: 10px;">
											'.$contest_status.'
										</span>
									</span>
									<span class="contest_n">
										<span style="float: left; width: 100%; margin: 5px; color: #1E2D38; font-size: 16px; font-family: Calibri; text-align: middle; font-weight: bold;">
											'.$contest_name.'
										</span>
									</span>
								</td>
							</tr>';
			}
			$output .= '</table>';
		}
	}	

	echo $output;

	function cn($con_id){
		include 'database_of.php';
		$sqln = "SELECT * FROM vote WHERE id = '$con_id'";
		$resultn = mysqli_query($connect, $sqln);

		if($row = mysqli_fetch_assoc($resultn))
		{
			return $row['contest_name'];
		}
	}

	function ct($con_id){
		include 'database_of.php';
		$sqln = "SELECT * FROM vote WHERE id = '$con_id'";
		$resultn = mysqli_query($connect, $sqln);

		if($row = mysqli_fetch_assoc($resultn))
		{
			return $row['contest_type'];
		}
	}

	function cs($con_id){
		include 'database_of.php';
		$sqln = "SELECT * FROM vote WHERE id = '$con_id'";
		$resultn = mysqli_query($connect, $sqln);

		if($row = mysqli_fetch_assoc($resultn))
		{
			return $row['status'];
		}
	}

?>