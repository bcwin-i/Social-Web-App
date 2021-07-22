<?php

include 'database_of.php';

$search = "%{$_POST['title']}%";
$title = mysqli_real_escape_string($connect, $search);

$sql = "SELECT * FROM vote WHERE (`contest_name` LIKE ?);";
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

if(mysqli_num_rows($result) < 1)
{
	$output = '<table style="margin: 2px; margin-left:0px; margin-top:5px; width: 100%;  margin-bottom: 0px;">
				<tr><td ><span style="color: #1E2D38; font-size: 14px; font-family: Calibri; text-align: center; width:100% ">Unknown contest name!</span></td></tr></table>';
	echo $output;
	exit();
}

if($rowcount > 1)
{
	$rowcount = $rowcount.' results';
}
else{
	$rowcount = $rowcount.' result';
}

$output = '<table style="margin: 2px; margin-left:0px; margin-top:5px; width: 100%;  margin-bottom: 0px;">
			<tr><td style="padding-bottom: 9px; border-bottom: 0.5px solid #F0F0F0;"><span style="color: #BFBFBF; font-family: monospace; font-size: 12px; width:100% ">'.$rowcount.'</span></td></tr>';
while($row = mysqli_fetch_assoc($result)){
	$output .= '<tr><td style="border-bottom: 0.5px solid #F0F0F0; height: 25px;"><span class="vact_na" id="'.$row['id'].'" style="color: #1E2D38; cursor:pointer; overflow:hidden; font-size: 14px; font-family: Calibri; text-align: center; width:100% ">'.$row['contest_name'].'</span></td></tr>';
}

$output .= '</table>';

echo $output;

//<tr><td style="border-bottom: 0.5px solid #F0F0F0; width:100%;"><span style="color: #429AA4; font-size: 14px; font-weight:bold; font-family: Calibri;">Results</td></tr>
?>