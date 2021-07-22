<?php

session_start();
include 'calls.php';
include 'database_of.php';
date_default_timezone_set('Africa/Accra');
$current_timestamp = date('Y-m-d H:i:s');

$sql = "SELECT * FROM vote WHERE countdown >= '$current_timestamp' OR status = 'inactive'";
$result = mysqli_query($connect, $sql);


$id = $_SESSION['user_id'];
$name =	user_name($id);

$sqle = "SELECT * FROM vote_alternatives WHERE  choice = '$name';";
$resulte = mysqli_query($connect, $sqle);
$rowcounte = mysqli_num_rows($resulte);

$sqlec = "SELECT * FROM vote_choice WHERE  user_id = '$id';";
$resultec = mysqli_query($connect, $sqlec);
$rowcountec = mysqli_num_rows($resultec);

$eng = $rowcounte + $rowcountec;

$rowcounts = mysqli_num_rows($result);
if($rowcounts == '0')
{
	$rowcounts = '';
}

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
						<span class="store_stat">
							<img id="add_store" class="add_forum" src="add_vote.png" height=30 width=30 title="add contest">
						</span>
						<img style="float: right;" src="vote_whole.png" height=59 width= 100/>
					</span>
				</span>
				<span class="vff" style="font-family: Calibri; font-size: 30px; color: #404B5C; width: 100%; float: right;" hidden>
					<form method="POST" id="submitvd" action="vds.php" onsubmit="return false;">
						<input class="contest_name" name="contest_name" placeholder="Contest name:" required>
						<span style="width: 40%; float: right; overflow: hidden; cursor: pointer;  display: inline; margin-top: -20px;">
							<select name="contest_type" class="c_type">
								<option value="" disabled selected>Contest type..</option>
								<option value="4">Choice ballot</option>
								<option value="10">Contestant ballot</option>
							</select>
							<span class="c_num_re">
							
							</span>
						</span>
						<textarea class="vote_desc" name="vote_desc" placeholder="Contest description:" required></textarea>
						<span style="width: 50%; float: left; margin: 10px 0px;">
							<span style="width: 100%; float: left; font-size: 15px; margin-top: 10px; margin-bottom: 5px; font-family: Calibri;">
								Security
							</span>
							<select name="security" class="v_opt">
								<option value="" disabled selected>Security option..</option>
								<option value="opened">Opened contest</option>
								<option value="closed">Closed contest</option>
							</select>
							<span class="con_code" style="width: 50%; float: right; margin: 10px 0px;" hidden>
								<input class="con_co" name="code" type="text" placeholder="Contest code" />
							</span>
						</span>
						<span style="width: 50%; float: right; margin: 10px 0px; font-size: 15px; font-family: Calibri;">
							<span style="width: 100%; float: left; font-size: 15px; margin-top: 10px;  font-family: Calibri;">
								Contest duration
							</span>
							<span style="width: 50%; float: left; margin: 10px 0px;" >
								<input class="con_do" id="v_hrs" name="hours" type="number" max="24" min="1" /> hours
							</span>
							<span style="width: 50%; float: right; margin: 10px 0px;" >
								<input class="con_do" id="m_hrs" name="minutes" type="number" max="60" min="1" /> minutes
							</span>
						</span>
						<table class="c_tab_al" style="width: 100%; float: left;">
							
						</table>
						<input class="total" type = "hidden" name = "total" />
					</form>
				</span>
				<span style="width: 100%; float: left; font-family: monospace; margin: 2px 0px; border-bottom: 1px solid #FAFAFA; font-size: 10px; color: #808080;">
					<span style="width: 50%; float: left; margin: 2px 0px;">
						<span style="width: 100%; float: left;" >
							<p class="conte" style="margin: 0px; margin-right: auto; margin-left: auto; width: 30%;">
								'.$rowcounts.' CONTEST
							</p>
						</span>
					</span>
					<span style="width: 49%; border-left: 1px solid #F4F4F4; float: right; margin: 2px 0px;">
						<span style="width: 100%; float: left;" >
							<p class="enga" style="margin: 0px; margin-right: auto; margin-left: auto; width: 25%;">
								'.$eng.' ENGAGED
							</p>
						</span>
					</span>
				</span>
				<span class="onvote" style="max-height: 87.5%; width: 100%; float: left;">'.onvote().'</span>
			</span>';

echo $output;

?>