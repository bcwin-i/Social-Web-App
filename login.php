<?php
	session_start();
?>
<html>
	<head>
		<link rel="icon" type="image/ico" href="logon.png">
		<title>
			bcwin - log in
		</title>
		
		<!-- Adding styles to text -->
		<!-- connecting stylesheet -->
		<link rel="stylesheet" type="text/css" href="login2.css">
		<link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.structure.css">
		<link rel="stylesheet" type="text/css" href="jquery-ui/jquery-ui.theme.css">
		<script src="jquery-3.3.1.js"></script>
		<script src="jquery-ui/jquery-ui.js"></script>
	<head>
	
<body>
	<div id="nav">
	<img id="ofr" src="bcwin2.png" alt="" height = 32 width = 80>
	<p1><img class="imageh" src="information-button.png" alt="" height = 17 width = 17 title="Help ?"></p1>
	</div>
	
	
	<div id="parent">
		<div id="l-space">
			<img src="u.png" alt="" height = 130 width = 150>
			<h1> Welcome </h1>
			<p1>Exhibit your emotions....Enter!</p1>
			<p2>
				<ul>
					<li class="1">Simply Log in using,</li>
					<li class="2">Registered GTUC name <span class="ed">eg..Edward Tyler</span></li>
					<li class="3">Student ID.</li>
				</ul>
			</p1>
		
		</div>
		<div class="field" id="r-space">
			<h5>Login</h5>
			<img id="back" class="an" src="704234.png" alt="" height = 20 width = 20 title="anonymous login">
			<div id="n">User name <img class="imageu" src="user.png" height = 17 width = 18></div> 
				<input type="text" id="name" class="name"> </br>
					
			<div id="n">Index number <img class="imageu" src="id-card.png" height = 17 width = 18></div>
			<input type="text" id="dob" class="name1" > </br> </br>
			<button id="button" class="submit">LOGIN</button>
			<div class = "prompt"></div><br>
			<div class="loading" style="padding-left: auto; padding-right: auto; width: 100%;" hidden><img src="Double Ring-3.7s-199px.gif" height="90" width="90" style=" margin-bottom: 0px;"><span style="color: gray; display: block; font-size: 7px; margin-left: 3px;  margin-top: -51px;">loading..</span></div>
			
		</div>
	</div>
	
	
	<div id="footer">
	&copy; 2019 iziqbek@gmail.com .All Rights Reserved
	</div>
	<script>
		function myfunction(){
		var x = document.getElementById("dob");
		if(x.type === "password"){
			x.type = "text";
		}
		else{
			x.type = "password";
		}
		}
	</script>>
	</body>
</html>
<script>
$(document).ready(function(){

	$(document).on('click', '.submit', function(){
		var name = $('.name').val();
		var index = $('.name1').val();
		$('.loading').show();
		$.ajax({
			url:"login_confrimation.php",
			method:"POST",
			data:{name:name, index:index},
			success:function(data)
			{
				$('.loading').hide(2000);
				if(data == "login error!" || data == "empty user input!")
				{
					$('.prompt').html(data);
				}
				else if(data == 'rep')
				{
					var ls = '<img src="704232.png" alt="" height = 150 width = 150><h1> Anonymous </h1><p1>Exhibit your emotions....Enter!</p1><p2><ul><li class="1">Simply Log in using,</li><li class="2">Unique ID eg..<span class="ed">Bcwin iVar</span></li><li class="3">Password.</li></ul></p1>';
					var rs = '<h5>Login</h5><img id="back" src="none.png" alt="" height = 15 width = 17 title="None anonymous login"><div id="n">Unique ID <img class="imageu" src="iconfinder___entertainment_theater_drama_mask_3668858.png" height = 20 width = 20></div> <input type="text" id="name" class="name"> </br><div id="n">Password <img class="imageu" src="iconfinder_icons_password_1564520.png" height = 20 width = 20></div><input type="password" id="dob" class="name1"> </br> </br><input id="view" type="checkbox" onclick="myfunction()"><label id="view2" for="view">view password</label><button id="button" class="submit2">LOGIN</button><div class = "prompt"></div><br><div class="loading" style="padding-left: auto; padding-right: auto; width: 100%;" hidden><img src="Double Ring-3.7s-199px.gif" height="90" width="90" style=" margin-bottom: 0px;"><span style="color: gray; display: block; font-size: 7px; margin-left: 30px;  margin-top: -51px;">loading..</span></div>';
					$('#l-space').html(ls);
					$('#r-space').html(rs);
				}
				else{
					window.location.href = data;
				}
			}
		})
	});

	$(document).on('click', '#back', function(){
		var ls = '<img src="u.png" alt="" height = 130 width = 150><h1> Welcome </h1><p1>Exhibit your emotions....Enter!</p1><p2><ul><li class="1">Simply Log in using,</li><li class="2">Registered GTUC name <span class="ed">eg..Edward Tyler</span></li><li class="3">Student ID.</li></ul></p1>';
			var rs = '<h5>Login</h5><img id="back" class="an" src="704234.png" alt="" height = 20 width = 20 title="anonymous login"><div id="n">User name <img class="imageu" src="user.png" height = 17 width = 18></div><input type="text" id="name" class="name"> </br><div id="n">Index number <img class="imageu" src="id-card.png" height = 17 width = 18></div><input type="text" id="dob" class="name1"> </br></br><button id="button" class="submit">LOGIN</button><div class = "prompt"></div><br><div class="loading" style="padding-left: auto; padding-right: auto; width: 100%;" hidden><img src="Double Ring-3.7s-199px.gif" height="90" width="90" style=" margin-bottom: 0px;"><span style="color: gray; display: block; font-size: 7px; margin-left: 30px;  margin-top: -51px;">loading..</span></div>';
			
			$('#l-space').html(ls);
			$('#r-space').html(rs);
	});

	$(document).on('click', '.an', function(){
		var ls = '<img src="704232.png" alt="" height = 150 width = 150><h1> Anonymous </h1><p1>Exhibit your emotions....Enter!</p1><p2><ul><li class="1">Simply Log in using,</li><li class="2">Unique ID eg..<span class="ed">Bcwin iVar</span></li><li class="3">Password.</li></ul></p1>';
		var rs = '<h5>Login</h5><img id="back" src="none.png" alt="" height = 15 width = 17 title="None anonymous login"><div id="n">Unique ID <img class="imageu" src="iconfinder___entertainment_theater_drama_mask_3668858.png" height = 20 width = 20></div> <input type="text" id="name" class="name"> </br><div id="n">Password <img class="imageu" src="iconfinder_icons_password_1564520.png" height = 20 width = 20></div><input type="password" id="dob" class="name1"> </br> </br><input id="view" type="checkbox" onclick="myfunction()"><label id="view2" for="view">view password</label><button id="button" class="submit2">LOGIN</button><div class = "prompt"></div><br><div class="loading" style="padding-left: auto; padding-right: auto; width: 100%;" hidden><img src="Double Ring-3.7s-199px.gif" height="90" width="90" style=" margin-bottom: 0px;"><span style="color: gray; display: block; font-size: 7px; margin-left: 30px;  margin-top: -51px;">loading..</span></div>';
		$('#l-space').html(ls);
		$('#r-space').html(rs);
	});

	$(document).on('click', '.submit2', function(){
		var uid = $('.name').val();
		var password = $('.name1').val();
		$('.loading').show();
		$.ajax({
			url:"anonymous_confrimation.php",
			method:"POST",
			data:{uid:uid, password:password},
			success:function(data)
			{
				$('.loading').hide(2000);
				if(data == "login error!" || data == "empty user input!" || data == "wrong password!")
				{
					$('.prompt').html(data);
					$('.name1').val('');
				}
				else{
					window.location.href = data;
				}
			}
		})
	});

	$(document).on('click', '.imageh', function(){
		$('.loading').show();
		$('.imageh').hide();
		$.ajax({
			url:"Help_message_2.php",
			success:function(data)
			{
				$('.loading').hide(2000);
				$('.field').html(data);
				$('.1').html("Fill the form with your personal details,")
				$('.2').html("& give a description of your problem.")
				$('.3').html("response will contact you within 24 hours.")
			}
		})

	});

	$(document).on('click', '.send', function(){
		var name = $('#user_name').val();
		var email = $('#Email').val();
		var mobile = $('#Mobile').val();
		var desc = $('#desc').val();
		$('.loading').show();
		$.ajax({
			url:"input_help_message.php",
			method:"POST",
			data:{name:name, email:email, mobile:mobile, desc:desc},
			success:function(data)
			{
				if(data == "Fill out all forms!")
				{
					$('.loading').hide(2000);
					$('.prompt2').html(data);
				}
				else
				{
				$('.loading').hide();
				$('#user_name').val('');
				$('#Email').val('');
				$('#Mobile').val('');
				$('#desc').val('');
				$('.new_i').html(data);		
				}
			}
		})

	});

});
</script>