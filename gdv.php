<?php

	session_start();
	include 'database_of.php';
	$id = $_SESSION['user_id'];
	include 'calls.php';

	$topic_id = $_POST['cid'];
	$current_timestamp = date('Y-m-d H:i:s');

	$sql = "SELECT * FROM vote WHERE id = ?";
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
	$output .= '<span id="vus'.$topic_id.'"></span>';

	if($row = mysqli_fetch_assoc($result))
	{
		if($row['countdown'] > $current_timestamp && $row['status'] == 'inactive')
		{
			echo "0";
			exit();
		}

		$on = '0';
		if($row['status'] != 'inactive')
		{
			$on = '1';
		}

		$cont = $row['contest_type'];

		$overall = $row['alternatives'];
	}

	$color = array('#E15330', '#F7D220' , '#226193', '#2E9758');
	$r_color = $color[array_rand($color)];

	$alt = "SELECT * FROM vote_alternatives WHERE contest_id = '$topic_id'";
	$altq = mysqli_query($connect, $alt);
	$altqs = mysqli_query($connect, $alt);
	$reply = mysqli_num_rows($altq);

	$csqr = "SELECT * FROM vote_choice WHERE contest_id = '$topic_id'";
	$sqcr = mysqli_query($connect, $csqr);
	$repliesr = mysqli_num_rows($sqcr);

	if($cont == '10')
	{
		$output .= '<span style="width: 100%; float: left; margin-top: 5px;">';
		while($rop = mysqli_fetch_assoc($altqs))
		{
			$option_nums = $rop['option_number'];

			$csqs = "SELECT * FROM vote_choice WHERE choice_num = '$option_nums' AND contest_id = '$topic_id'";
			$sqcs = mysqli_query($connect, $csqs);
			$repliess = mysqli_num_rows($sqcs);

			if($repliess == '0')
			{
				$total = 0;
				$style = 'width: 7%;';
				$col = 'gray';
				$tot = 3;
				$repliess = 0;
			}
			else
			{
				$total = (($repliess/$repliesr)*100);

				if($total <= 25 && $total >= 0)
				{
					$tot = 0;
					$style = 'width: '.$total.'%; background-color:'.$color[0].';';
					$col = 'white';
				}
				elseif($total < 50 && $total > 25)
				{
					$tot = 1;
					$style = 'width: '.$total.'%; background-color:'.$color[1].';';
					$col = 'white';
				}
				elseif($total < 75 && $total >= 50)
				{
					$tot = 2;
					$style = 'width: '.$total.'%; background-color:'.$color[2].';';
					$col = 'white';
				}
				elseif($total <= 100 && $total >= 75)
				{
					$tot = 3;
					$style = 'width: '.$total.'%; background-color:'.$color[3].';';
					$col = 'white';
				}
			}

			if($repliess < '2')
			{
				$repliess = '<span style="font-size: 12px; font-family: Calibri;">'.$repliess.' vote - '.round($total).'% overall</span>';
			}
			else
			{
				$repliess = '<span style="font-size: 12px; font-family: Calibri;">'.$repliess.' votes - '.round($total).'% overall</span>';
			}

			$output .= '<span style="width: 50%; float: left; height: 39px; margin-bottom: 2px;">
							<span style="width: 80%; float: left; height: 100%;">
								<span style="width: 15%; float: ; left; height: 100%;">
									<img class="pic" src="Files/Profile/profile'.name_to_id($rop['choice']).'.jpg" title='.$rop['choice'].' height = 30 width = 30>
								</span>
								<span style="font-size: 14px; color: gray; vertical-align: top; width: 85%; float: right;">
									<span style="width: 100%; float: left;">
										'.$rop['choice'].'
									</span>
									<span style="width: 100%; float: left; color: '.$color[$tot].'; font-size: 13px;">
										'.$repliess.'
									</span>
								</span>
							</span>
							<span style="width: 20%; float: right; height: 100%;">
							</span>
						</span>';
		}
		$output .= '</span>';
	}
	else
	{
		$output .= '<span style="width: 100%; float: left; margin-top: 5px;">';
		while($rop = mysqli_fetch_assoc($altqs))
		{
			$option_num = $rop['option_number'];

			$csqs = "SELECT * FROM vote_choice WHERE choice_num = '$option_num' AND contest_id = '$topic_id'";
			$sqcs = mysqli_query($connect, $csqs);
			$repliess = mysqli_num_rows($sqcs);

			if($repliess == '0')
			{
				$total = 0;
				$style = 'width: 7%;';
				$col = 'gray';
				$tot = 4;
			}
			else
			{
				$total = (($repliess/$repliesr)*100);

				if($total <= 25 && $total >= 0)
				{
					$tot = 0;
					$style = 'width: '.$total.'%; background-color:'.$color[0].';';
					$col = 'white';
				}
				elseif($total <= 50 && $total > 25)
				{
					$tot = 1;
					$style = 'width: '.$total.'%; background-color:'.$color[1].';';
					$col = 'white';
				}
				elseif($total <= 75 && $total > 50)
				{
					$tot = 2;
					$style = 'width: '.$total.'%; background-color:'.$color[2].';';
					$col = 'white';
				}
				elseif($total <= 100 && $total > 75)
				{
					$tot = 3;
					$style = 'width: '.$total.'%; background-color:'.$color[3].';';
					$col = 'white';
				}
			}

			if($repliess < '2')
			{
				$repliess = '<span style="font-family: Calibri;">'.$repliess.' vote - '.round($total).'% overall</span>';
			}
			else
			{
				$repliess = '<span style="font-family: Calibri;">'.$repliess.' votes - '.round($total).'% overall</span>';
			}

			$output .= '<span style="width: 50%; float: left; height: 39px; margin-bottom: 2px;">
							<span style="width: 80%; float: left; height: 100%;">
								<span style="width: 12%; float: ; left; height: 100%;">
									<span style="width: 30px; height: 30px; padding: 5px 6px; background-color: '.$color[$tot].'; color: white; border-radius: 50%;" title="Choice '.$option_num.'">C'.$option_num.'</span>
								</span>
								<span style="font-size: 14px; color: gray; height: 100%; width: 88%; float: right;">
									<span style="width: 100%; float: left; color: '.$color[$tot].'; font-size: 14px; ">
										'.$repliess.'
									</span>
								</span>
							</span>
							<span style="width: 20%; float: right; height: 100%;">
							</span>
						</span>';
		}
		$output .= '</span>';		
	}

	$output .= '<span style="width: 100%; float left;">
					<span style="width: 6.8%; float: left; height: 2.5%; margin: 1% 0%; border-right: 1px solid #E1E1E1; border-bottom: 1px solid #999999;">
					CHOICE
					</span>
					<span style="width: 93%; float: right; height: 2.5%; margin: 1% 0%; border-bottom: 1px solid #999999; text-align: right;">
					PERCENTAGE %
					</span>
				</span>';
	$output .= '<span style="float: left; width: 100%; border-bottom: 1px solid #999999;">';

	while($rowa = mysqli_fetch_assoc($altq))
	{

		$option_num = $rowa['option_number'];

		$csq = "SELECT * FROM vote_choice WHERE choice_num = '$option_num' AND contest_id = '$topic_id'";
		$sqc = mysqli_query($connect, $csq);
		$replies = mysqli_num_rows($sqc);

		if($replies == '0')
		{
			$total = 0;
			$style = 'width: 7%;';
			$col = 'gray';
			$tot = 3;
		}
		else
		{
			$total = (($replies/$repliesr)*100);

			if($total <= 25 && $total >= 0)
			{
				$tot = 0;
				$style = 'width: '.$total.'%; background-color:'.$color[0].';';
				$col = 'white';
			}
			elseif($total <= 50 && $total > 25)
			{
				$tot = 1;
				$style = 'width: '.$total.'%; background-color:'.$color[1].';';
				$col = 'white';
			}
			elseif($total <= 75 && $total > 50)
			{
				$tot = 2;
				$style = 'width: '.$total.'%; background-color:'.$color[2].';';
				$col = 'white';
			}
			elseif($total <= 100 && $total > 75)
			{
				$tot = 3;
				$style = 'width: '.$total.'%; background-color:'.$color[3].';';
				$col = 'white';
			}
		}

		$name = '<span style="width: 30px; height: 30px; padding: 5px 6px; background-color: '.$color[$tot].'; color: white; border-radius: 50%;">C'.$option_num.'</span>';
		if($cont == '10')
		{
			$name = '<img class="pic" src="Files/Profile/profile'.name_to_id($rowa['choice']).'.jpg" title='.$rowa['choice'].' height = 30 width = 30>';
		}

		$output .= '<span style="float: left; width: 100%; height: 40px;">
						<span style="width: 6.8%; float: left; height: 100%; border-right: 1px solid #999999; font-family: Calibri;  font-size: 14px; font-weight: bold; color: '.$color[$tot].';">
							<span style="height: 80%; width: 100%; float: left; margin: 14% 0%;">'.$name.'</span>
						</span>
						<span style="width: 93%; float: right; height: 100%; background-image: url(graph_background.jpg); background-size: cover; background-repeat: no-repeat;">
							<span style="float: left; '.$style.' height: 80%; border-radius: 0px 2px 2px 0px;">
								<span style=" float: right; border-radius: 50%; padding: 5px; color: '.$col.'; font-family: verdana; font-size: 15px;">
								'.round($total).'%
								</span>
							</span>
						</span>
					</span>';

	}

	$output .= '</span>
				<span style="float: right; font-size: 13px; color: gray;">'.$repliesr.' votes</span>';

	echo $output;

?>