<?php

include 'database_of.php';

$search = "%{$_POST['chser']}%";
$title = mysqli_real_escape_string($connect, $search);
$output = '';

$sql = "SELECT * FROM log WHERE (`uid` LIKE ?);";
//$result = mysqli_query($connect, $sql);
$st = mysqli_stmt_init($connect);

if(!mysqli_stmt_prepare($st, $sql))
{
	exit();
}
mysqli_stmt_prepare($st, $sql);
mysqli_stmt_bind_param($st, "s", $title);
mysqli_stmt_execute($st);

$result = mysqli_stmt_get_result($st);
$rowcount = mysqli_num_rows($result);

if($title == '')
{
	$output = '';
	exit();
}

if(mysqli_num_rows($result) < 1)
{
	$output = '<table style="margin: 2px; margin-left:0px; margin-top:5px; width: 100%;  margin-bottom: 0px;">
				<tr><td ><span style="color: gray; font-size: 14px; font-family: Calibri; text-align: center; width:100% ">Unknown user!</span></td></tr></table>';
	echo $output;
	exit();
}

if($rowcount > 1){
	$rowcount = $rowcount.' results';
}
elseif ($rowcount == 1) {
	$rowcount = $rowcount.' result';
}

$output = '<table class="vl-space" >
				<tr><td class="m_title"><span style="color: gray; font-family: Calibri; font-size: 12px;">'.$rowcount.'</td></tr>';
//$output .= '<table >
//				<tr><td class="m_title"><span style="color: gray; font-family: Calibri; width: 100%; float: left;"></td></tr>';

while($row = mysqli_fetch_assoc($result)){

	$uinq = $row['uid'];
	$id = $row['id'];

	if($row['status'] == 0){
		$profile = '<img class="pic" src="Files/Profile/profile'.$id.'.jpg" height = 26 width = 26>';
	}

	if($row['status'] == 1){
		$profile = '<img class="pic" src="user.PNG" height = 27 width = 27>';
	}
	
	$output .= '<tr id="scon" data-name="'.$uinq.'">
					<td class="rule_m" width="100%">
						<span style="width:10%; float: left;">'.$profile.'</span>
						<span style="width:88%; float: right;  position: relative; overflow: hidden; height: 21px;">
							<p class="c_sel">
								'.$uinq.'
							</p>
						</span>
					</td>
				</tr>';
}

$output .= '</table>';
echo $output;

?>