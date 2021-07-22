<?php
include 'database_of.php';
include 'calls.php';
session_start();
$id = $_SESSION['user_id'];

$output = '<span class="shtr" style="position: absolute; left: 2px; top: 2px;" hidden>
				<img id="snh" src="show_tray.png" height="12" width="12" />
			</span>
			<span style="width: 96%; height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
				<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right;  overflow: ">
					<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
						<span class="event_stat">
							<img id="add_event" class="add_event" src="add_event_off.png" height=30 width=30 title="add event">
						</span>
						<img style="float: right;" src="event_whole.png" height=50 width=50>
					</span>
				</span>
				<span class="aef" id="aef" style="font-family: Calibri; font-size: 30px; color: #404B5C; width: 100%; float: right;" hidden>
					<form method="POST" id="submitfe" action="upfe.php" onsubmit="return false;">
						<span style="width:100%; float:left;">
							<span style="float:left; width: 70%;" class="trw">
								<input spellcheck="false" type="text" class="event_name" name="event_name" placeholder="Event name:" required>
							</span>
							<span style="font-weight: lighter; width: 30%; font-size: 16px; color: #D92E2B; float: right; position: relative;" class="cce">
								<input spellcheck="false" type="text" class="event_loc" name="event_loc" placeholder="location:" required>
								<img src="loc.png" style="float: right; vertical-align:bottom; margin-top: 23px; opacity: 0.5;" height=18 width=18 />
							</span>
						</span>
						<span class="edc">
							<textarea spellcheck="false" class="event_desc" id="txta" name="event_desc" placeholder="Event description:" required></textarea>
						</span>
						<span style="width: 100%; float: left; margin-top: 18px; font-size: 14px; font-family: Calibri; border: none; #F4F4F4; color: gray;">
							<span style="float:left; width: 50%;">Event date & time</span>
							<span style="float:left; width: 50%;">Event closing date & time</span>
							<div class="esd" style="float:left; width: 50%; display: inline;">
								<input type="date" class="evesd" name="evesd" style="width:40%; font-family: Calibri; color: #84B58D; margin-top: 11px; border: none; padding-bottom: 5px; border-bottom: 1px solid #84B58D">
								<input type="time" class="evest" name="evest" style="width:30%; font-family: Calibri; color: #84B58D; margin-top: 11px; margin-left: 4%; border: none; padding-bottom: 5px; border-bottom: 1px solid #84B58D; display: inline;">
							</div>
							<div class="ecd" style="float:left; width: 50%; display: inline;">
								<input type="date" class="evecd" name="evecd" style="width:40%; font-family: Calibri; color: #C46362; margin-top: 11px; border: none; padding-bottom: 5px; border-bottom: 1px solid #C46362;">
								<input type="time" class="evect" name="evect" style="width:30%; font-family: Calibri; color: #C46362; margin-top: 11px; margin-left: 4%; border: none; padding-bottom: 5px; border-bottom: 1px solid #C46362; display: inline;">
							</div>
						</span>
						<span id="issete" style="width: 100%; float: left; color: gray; font-family: Calibri; font-size: 16px; margin-top: 12px;" hidden>
							Event poster 
							<span style="font-family: monospace; font-size: 13px; color: #BFBFBF; margin-left: 5px;">(optional)</span>
							<span style="overflow: hidden; cursor: pointer; margin-top: -20px;">
								<label class="issete"  for="effs" >
									<img style="vertical-align: middle; cursor: pointer;" src="event_file.png"  height="10" width="25" title="attach file" />
								</label>
							</span>
						</span>
						<input class="fn" type = "hidden" name = "file_name" />
						<span class="selpic" style="width: 100%; max-height: 70%; margin-top: 10px; float: right; position: relative; ">
						</span>
					</form>
					<span  style="width: 100%; float: left;">
						<form method="POST" id="selpic" action="selpic.php" onsubmit="return false;">
							<input type="file" id="effs" style="display: none;" name="file" accept=".jpg, .png, .gif, .mp4" />
							<input class="hv" type = "hidden" name = "ten" />
							<input class="ha" type = "hidden" name = "ten1" />
							<input class="hb" type = "hidden" name = "ten2" />
							<input class="hc" type = "hidden" name = "ten3" />
							<input class="hd" type = "hidden" name = "ten4" />
							<input class="he" type = "hidden" name = "ten5" />
						</form>
					</span>
				</span>';

$current_timestamp = date('Y-m-d H:i:s');

$sql = "SELECT * FROM events   WHERE `end` > '$current_timestamp'  AND '$current_timestamp' < start ORDER BY `end` ASC";
$result = mysqli_query($connect, $sql);
$rowcountu = mysqli_num_rows($result);

if($rowcountu == 0){
	$rowcountu = 'UPCOMING';
}
else{
	$rowcountu = '<span style="color: #B81D1A; opacity: 0.5;">'.$rowcountu.'</span> UPCOMING';
}

$sqll = "SELECT * FROM events   WHERE `end` > '$current_timestamp' AND '$current_timestamp' > start ORDER BY `end` ASC";
$resultl = mysqli_query($connect, $sqll);
$rowcountl = mysqli_num_rows($resultl);

if($rowcountl == 0){
	$rowcountl = 'LIVE';
}
else{
	$rowcountl = '<span style="color:#95E88E;">'.$rowcountl.'</span> LIVE';
}

$sqle = "SELECT * FROM forum_notification_request WHERE user_id = '$id' AND cat_id = '2'";
$resulte = mysqli_query($connect, $sqle);
$rowcounte = mysqli_num_rows($resulte);

if($rowcounte == 0){
	$rowcounte = '';
}

$output .=		'<span style="width: 100%; float: left; font-family: monospace; margin: 2px 0px; border-top: 1px solid #FCFCFC; font-size: 10px; color: #808080;">
					<span style="width: 66.66%; float: left; margin: 2px 0px;">
						<span class="event_status_l" >
							<p class="eupcoming" style="margin: 0px; margin-right: auto; margin-left: auto; width: 30%;">
								'.$rowcountu.'
							</p>
						</span>
						<span class="event_status_r">
							<p class="elive" style="margin: 0px; margin-right: auto; margin-left: auto; width: 30%;">
								'.$rowcountl.'
							</p>
						</span>
					</span>
					<span style="width: 33.33%; float: right; margin: 2px 0px;">
						<span class="event_status_ml" >
							<p class="egoing" style="margin: 0px; margin-right: auto; margin-left: auto; width: 30%;">
								'.$rowcounte.' PINNED
							</p>
						</span>
					</span>
				</span>
				<span style="width: 100%; float: left; border-bottom: 1px solid #FAFAFA;">
				</span>';

$output .= 	'<span class="evsr" style="max-height: 82%; width: 100%; float: left; overflow: scroll;">'.stel().'</span>';
			
$output .= '</span>';			
						
echo $output;

?>