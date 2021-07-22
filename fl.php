<?php

include 'database_of.php';
include 'calls.php';

$sql = "SELECT * FROM topics WHERE category_id = '1'";
$result = mysqli_query($connect, $sql);
$rowcount = mysqli_num_rows($result);

$sqlf = "SELECT * FROM replies WHERE category_id = '1' ORDER BY 'date' DESC LIMIT 1";
$resultf = mysqli_query($connect, $sqlf);

$fr = 'None';
if($row = mysqli_fetch_assoc($resultf)){
	$fr = ut($row['date']);
}

$sql2 = "SELECT * FROM topics WHERE category_id = '2'";
$result2 = mysqli_query($connect, $sql2);
$rowcount2 = mysqli_num_rows($result2);

$sqlf2 = "SELECT * FROM replies WHERE category_id = '2' ORDER BY 'date' DESC LIMIT 1";
$resultf2 = mysqli_query($connect, $sqlf2);

$fr2 = 'None';
if($row2 = mysqli_fetch_assoc($resultf2)){
	$fr2 = ut($row2['date']);
}

$sql3 = "SELECT * FROM topics WHERE category_id = '3'";
$result3 = mysqli_query($connect, $sql3);
$rowcount3 = mysqli_num_rows($result3);

$sqlf3 = "SELECT * FROM replies WHERE category_id = '3' ORDER BY 'date' DESC LIMIT 1";
$resultf3 = mysqli_query($connect, $sqlf3);

$fr3 = 'None';
if($row3 = mysqli_fetch_assoc($resultf3)){
	$fr3 = ut($row3['date']);
}

$sql4 = "SELECT * FROM topics WHERE category_id = '4'";
$result4 = mysqli_query($connect, $sql4);
$rowcount4 = mysqli_num_rows($result4);

$sqlf4 = "SELECT * FROM replies WHERE category_id = '4' ORDER BY 'date' DESC LIMIT 1";
$resultf4 = mysqli_query($connect, $sqlf4);

$fr4 = 'None';
if($row4 = mysqli_fetch_assoc($resultf4)){
	$fr4 = ut($row4['date']);
}

$sql5 = "SELECT * FROM topics WHERE category_id = '5'";
$result5 = mysqli_query($connect, $sql5);
$rowcount5 = mysqli_num_rows($result5);

$sqlf5 = "SELECT * FROM replies WHERE category_id = '5' ORDER BY 'date' DESC LIMIT 1";
$resultf5 = mysqli_query($connect, $sqlf5);

$fr5 = 'None';
if($row5 = mysqli_fetch_assoc($resultf5)){
	$fr5 = ut($row5['date']);
}

$output = '<div style="width: 100%; background-color: white; height: 30%; border-bottom: 1px solid #F0F0F0; float: left; overflow: scroll;">
			<table width="100%" style="margin-top:0px;">
				<tr><td style="width: 100%;"><img id="snh" class="hfrt" src="hide_tray.png" height="15" width="15" />
					</td>
					</tr>
				<tr >
					<td id="cat1" class="cat1" width="100%" title="Discussions">
						<span style="width:20%; float:left;">
							<img src="others_on.png" height=36 width=36>
						</span>
						<span style="overflow: hidden; color: gray; font-family: calibri; float:right; width: 80%; font-size: 14px; padding-top: 9px;">
							<span style="margin-left:5px;">Discussions</span>
						</span>
					</td>
				</tr>

				<tr ><td id="cat3" class="cat" width="100%" title="Vote"><span style="width:20%; float:left;"><img src="vote.png" height=36 width=36></span><span style="overflow: hidden; color: gray; font-family: calibri; float:right; width: 80%; font-size: 14px; padding-top: 9px;"><span style="margin-left:5px;">Vote</span></span></td></tr>
				<tr ><td id="cat4" class="cat" width="100%" title="Library"><span style="width:20%; float:left;"><img src="faculty_on.png" height=36 width=36></span><span style="overflow: hidden; color: gray; font-family: calibri; float:right; width: 80%; font-size: 14px; padding-top: 9px;"><span style="margin-left:5px;">Library</span></span></td></tr>
				<tr ><td id="cat5" class="cat" width="100%" title="Institution"><span style="width:20%; float:left;"><img src="inst_whole.png" height=36 width=36></span><span style="overflow: hidden; color: gray; font-family: calibri; float:right; width: 80%; font-size: 14px; padding-top: 9px;"><span style="margin-left:5px;">Institution</span></span></td></tr>
			</table>
		   </div>';
$output .= '<div id="fls" style="width: 100%; background-color: white; height: 70%; float: left; overflow-x:hidden; overflow-y:scroll;">
				<span class="fa_ti" style="width: 100%; background-color: none; height: 20%; overflow-x:hidden; overflow-y:scroll; margin: 0px; float: left; position: relative; font-family: calibri; cursor: pointer;">
					<img id="sl" style="opacity: 0.1; margin-top: -50px; margin-left: -60px; position: absolute;" src="opent.png" height="150" width="150" />
					<span id="1" class="cat-t" style="color: #152B44; font-size: 16px; width: 95%; float: right; margin-top: 2px; cursor: pointer; position: relative;">Open topic</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$rowcount.' topics</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 3px;">Updated</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$fr.'</span>
				</span>
				<span class="fa_ti" style="width: 100%; background-color: none; height: 20%; overflow-x:hidden; overflow-y:scroll; margin: 0px; float: left; position: relative; font-family: calibri;">
					<img id="sl" style="opacity: 0.1;  margin-top: -50px; margin-left: -60px; position: absolute;" src="fh.png" height="300" width="300" />
					<span id="2" class="cat-t" style="color: #38AB26; font-size: 16px; width: 95%; float: right; margin-top: 2px;  cursor: pointer; position: relative; z-index: 1;">Food and Health</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$rowcount2.' topics</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 3px;">Updated</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$fr2.'</span>
				</span>
				<span class="fa_ti" style="width: 100%; background-color: none; height: 20%; overflow-x:hidden; overflow-y:scroll; margin: 0px; float: left; position: relative; font-family: calibri; ">
					<img id="sl" style="opacity: 0.1;  margin-top: -100px; margin-left: -40px; position: absolute;" src="hmj.png" height="250" width="250" />
					<span id="3" class="cat-t" style="color: #F4C515; font-size: 16px; width: 95%; float: right; margin-top: 2px; cursor: pointer; position: relative;">Humor and Jokes</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$rowcount3.' topics</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 3px;">Updated</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$fr3.'</span>
				</span>
				<span class="fa_ti" style="width: 100%; background-color: none; height: 20%; overflow-x:hidden; overflow-y:scroll; margin: 0px; float: left; position: relative; font-family: calibri; text-align: middle;">
					<img id="sl" style="opacity: 0.1;  margin-top: -30px; margin-left: -60px; position: absolute;" src="pr.png" height="150" width="150" />
					<span id="4" class="cat-t" style="color: #1E1E52; font-size: 16px; width: 95%; float: right; margin-top: 2px; cursor: pointer; position: relative;">Politics and Religion</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$rowcount4.' topics</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 3px;">Updated</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$fr4.'</span>
				</span>
				<span class="fa_ti" style="width: 100%; background-color: none; height: 20%; overflow-x:hidden; overflow-y:scroll; margin: 0px; float: left; position: relative; font-family: calibri; ">
					<img id="sl" style="opacity: 0.1;  margin-top: -30px; margin-left: 10px; position: absolute;" src="pd.png" height="150" width="150" />
					<span id="5" class="cat-t" style="color: #267CAB; font-size: 16px; width: 95%; float: right; margin-top: 2px;  cursor: pointer; position: relative;">Programming and Design</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$rowcount5.' topics</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 3px;">Updated</span>
					<span style="color: gray; font-size: 12px; width: 95%; float: right; margin-top: 1px;">'.$fr5.'</span>
				</span>
			</div>';

echo $output;


/*
				<tr ><td id="cat2" class="cat" width="100%" title="Events"><span style="width:20%; float:left;"><img src="events_on.png" height=34 width=34></span><span style="overflow: hidden; color: gray; font-family: monospace; font-weight: bold; float:right; width: 80%; font-size: 11px; padding-top: 10px;"><span style="margin-left:5px;">Events</span></span></td></tr>
*/
?>