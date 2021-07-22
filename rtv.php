<?php

	session_start();
	include 'calls.php';
	$topic_id = $_POST['cid'];

	echo return_vote($topic_id);
?>