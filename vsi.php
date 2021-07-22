<?php

$file = $_POST['id'];
$fl = 'Files/Chat_uploads/' . $file;

$output = '<div class="iv" style="height:100%; width: 100%; top: 0%; left: 0%; position: absolute; z-index:5;">
			<div style="height:100%; width: 100%; top: 0%; left: 0%; position: absolute; background-color: black; opacity:0.7; float: left; z-index:3;">
			</div>
			<span style="height:100%; width: 100%; top: 0%; left: 0%; position: absolute; float: left; z-index:5; overflow: scroll;">
				<img style=" max-height: 100%; max-width: 100%; margin-top: 5%; margin-right: auto; margin-left: auto; margin-bottom: 0px; display: block;" src='.$fl.' />
			</span>
			<img class="civ" style="z-index:5; position: absolute; top: 3%; right: 2%; cursor: pointer;" src="civ.png" height = 20 width = 20 />
		 </div>';

echo $output;

?>