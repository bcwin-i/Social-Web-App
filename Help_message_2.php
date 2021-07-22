<?php

	$output = '';
	$output ='<div class="new_i" style="margin-left: auto; margin-right: auto;"><img class="help_icon" src="iconfinder_Info01_928433.png" height="100" width="100" style="opacity: 0.1;"></div>';
	$output .= '<input class="topic_t" id="user_name" placeholder="Name:" ><br>';
	$output .= '<input class="topic_t" type="email" id="Email" placeholder="Email:" ><br>';
	$output .= '<input class="topic_t" type="number" id="Mobile" placeholder="Mobile number:">';
	$output .= '<textarea class="topic_desc" id="desc" placeholder="Problem description:" ></textarea>';
	$output .= '<button class="send" id="button">SUBMIT</button>';
	$output .= '<div class="loading" style="position: absolute; top: 0%; left: 80%;" hidden><img src="Double Ring-3.7s-199px.gif" height="90" width="90" style="margin-top: -15px; margin-bottom: 0px;"><span style="color: gray; display: block; font-size: 7px; margin-top: -51px;">loading..</span></div>';
	$output .= '<div class = "prompt2"></div>';


	echo $output;
?>