<!-- Log in interface -->
<?php
	session_start();
	include 'pfi.php';

	if(!isset($_SESSION['user_id'])){
		header("Location:login.php");
	}
	
	$uid = $_SESSION['unique_id'];
	$ui = $_SESSION['user_name'];
	$uid = $_SESSION['unique_id'];
	
	if(empty($uid)){
	$ui;
	}
	else{
	$ui = $uid;
	}
?>

<html>
	<head>
		<link rel="icon" type="image/ico" href="logon1.png">
		<title> 
		bcwin - home
		</title>

		<link rel="stylesheet" type="text/css" href="index_stylesheet.css">
		<link rel="stylesheet" type="text/css" href="emojionearea.css">
		<script src="jquery-3.3.1.js"></script>
		<script src="jquery-ui/jquery-ui.js"></script>
		<script src="emojionearea.min.js"></script>
		<script src="jquery.form.js"></script>
	<head>

	<body>
		<div class="whole_up">
			<span style="width: 100%; position: absolute; bottom: 4%; float: left;">
				<span class="nav_left">
					<span style="width: 15%; float: left; height: 100%;">
						<img id="ofr" src="logon1.png" alt="" height = 32 width = 32 title="Home" style="margin-left: 6px; margin-top: 1px; vertical-align: bottom;">
					</span>
					<span style="width: 85%; float: right; height: 100%;">
						<span style="width: 100%; float: left; padding-top: 11px; vertical-align: bottom;">
							<span class="forum">
								<img style="margin-left: 5px; cursor: pointer; margin-bottom: 1px;" src="forum_icon.png" height="17" width="60" title="forum"></span>
							<span class="vibe">
								<img style="margin-left: 30px; cursor: pointer; margin-bottom: 2px;" src="vibe_icon-off.png" height="16" width="48" title="vibe"></span>
						</span>
					</span>
				</span>
				<span class="nav_right"> 
					<span style="width: 50%; height: 100%; margin-top: 1.5%; float: left; vertical-align: bottom; overflow: hidden;">
						<span class="drop_forum" style="cursor: pointer; margin-left: 23.5%;">
							<img src="rater_not_off.png" height="19" width="20" >
						</span>
						<span class="unseen_forum" style="font-family: monospace; font-size: 10px; color: gray; font-weight: bold;">
						</span>
						<span class="drop_vibe" style="cursor: pointer; margin-left: 10%;">
							<img src="vibe_not_off.png" height="19" width="19">
						</span>
						<span style="font-family: monospace; color: gray; font-size: 10px; font-weight: bold;"></span>

						<span class="drop_msg" style="cursor: pointer; margin-left: 10%;">
							<img src="message_not_on.png" height="19" width="19">
						</span>
						<span class="unseen_messages" style="font-family: monospace; color: gray; font-size: 10px; font-weight: bold;">
						</span>
					</span>
					<span style="float: right; width: 50%; margin: 0px; height: 100%; position: relative;">
						<?php pfi() ;?>
					</span>
				</span>
			</span>
		</div>
		
		<div id="msg_on">

		</div>
		<div class="whole_down">
			<span class="left" style="">
				<span id="fcl" class="fcl" style="width: 20%; background-color: none; height: 100%; margin: 0px; padding: 0px; display: inline; float: left;">
				</span>
				<span class="forum_replace" style="width: 80%; background-color: white; height: 100%; margin: 0px; padding: 0px; display: inline; float: right; position: relative;">
					
				</span>
			</span>
			<span class="right">
				<span style="width: 50%; background-color: none; height: 100%; margin: 0px; float: left;">
					<div style="width: 100%; background-color: none; height: 100%; margin: 0px; float: left; ">
						<span class="notification_viewer" style="margin: 0px 5%; width: 90%; max-height: 100%; float: right; margin-bottom: 0px; background-color: white; border-radius: 0px 0px 8px 8px; overflow-y: scroll; position: relative;"></span>
					</div>
				</span>
				<span  style="width: 50%; background-color: none; height: 100%; margin: 0px; float: right; overflow: hidden;">
					<span style="width: 100%; background-color: white; height: 5.5%; margin: 0px; float: left; z-index: 1;">
						<input id="search_forum" type="text" class="search_members" placeholder="search through members.." ></input>
					</span>
					<span class="members" style="width: 100%; height: 39.5%; float: right; background-color: white; overflow: hidden; border-bottom: none;"></span>
					<span class="all_members" style="width: 100%; overflow: hidden; height: 55%; border-top: 1px solid #F4F4F4; float: right;  background-color: white;"></span>
				</span>
			</span>
		</div>
	</body> 
</html>

<script >
	$(document).ready(function(){
		$(document).on('click', '.forum', function(){
			var forum = '<img class="forum" style="margin-left: 5px; cursor: pointer; margin-bottom: 1px;" src="forum_icon.png" height="17" width="60" title="forum">';
			$('.forum').html(forum);

			var vibe = '<img style="margin-left: 30px; cursor: pointer; margin-bottom: 2px;" src="vibe_icon-off.png" height="16" width="48" title="vibe">';
			$('.vibe').html(vibe);
		});

		$(document).on('click', '.vibe', function(){
			var forum = '<img class="forum" style="margin-left: 5px; cursor: pointer; margin-bottom: 1px;" src="forum_icon-off.png" height="17" width="60" title="forum">';
			$('.forum').html(forum);

			var vibe = '<img style="margin-left: 30px; cursor: pointer; margin-bottom: 2px;" src="vibe_icon.png" height="16" width="48" title="vibe">';
			$('.vibe').html(vibe);
		});




		$(document).on('click', '.p2', function(){
			if(confirm("logout ?"))
			{
				$.ajax({
				url:"logout.php",
				success:function(data)
				{
					window.location.href = data;
				}
				})
			}
		});


		function olstatu(){
			$.ajax({
				url: "olstatu.php",
				success:function(data){
					if(data == "off")
					{
						window.location.href = "login.php";
					}
				}
			})
		}

		setInterval(function(){
			update_online_status();
			users();
			u_m();
			msg_nv();
			olstatu();
		}, 5000);

		function update_online_status(){
			$.ajax({
				url: "update_online_status.php",
				success:function(){

				}
			})
		}

		users();
		function users()
		{	
			$.ajax({
				url: "members.php",
				method: "POST",
				success:function(data){
					$('.members').html(data);
				}
			})
		}



		all_users();
		function all_users()
		{	
			$.ajax({
				url: "all_members.php",
				method: "POST",
				success:function(data){
					$('.all_members').html(data);
				}
			})
		}

		u_m();
		function u_m(){
			$.ajax({
				url: "unseen_messages_not.php",
				method: "POST",
				success:function(data){
					$('.unseen_messages').html(data);
				}
			})
		}

		msg_act();
		function msg_act(){
			$.ajax({
				url: "display_um.php",
				method: "POST",
				success:function(data){
					$('.notification_viewer').html(data);
				}
			})
		}

		function msg_nv(){
			if (document.getElementById('mesf')){
				msg_act();
			}
			if (document.getElementById('unm'))
			{
				msg_act();
			}
		}

		$(".drop_msg").click(function(){
			msg_act();
		});

		$(document).on('click', '#buttons', function(){
			
			if(name == '')
			{

			}
			else
			{
				$('#buttons').hide();
				$('.search_load_members').show();
				
			}
		});

		setInterval(function(){
			empty_member_search();
		}, 1000);

		function empty_member_search(){
			if($('.search_members').val() == '')
			{
				if (document.getElementById('am'))
				{

				}
				else
				{
					all_users();
				}
			}
			else{
				var name = $('.search_members').val();
				$.ajax({
					url:"searched_members.php",
					method:"POST",
					data:{name:name},
					success:function(data)
					{
						$('#buttons').show();
						$('.search_load_members').hide();
						$('.all_members').html(data);
					}
				})
			}
		}

		forum_loader();
		function forum_loader(){
			$.ajax({
				url: "fl.php",
				method: "POST",
				success:function(data){
					$('.fcl').html(data);
				}
			})
		}

		function hnS(){
			var size = document.getElementById('fcl');
			if(size.style.display != "none"){
				size.style.display = "none";
				$('.forum_replace').css('width', '100%');
	  			$('.shtr').show();
			}
			else{
				$('.forum_replace').css('width', '80%');
	  			$('.shtr').hide();
	  			$('.fcl').show();
			}
		}

		function snh(){
			var size = document.getElementById('fcl');
			if(size.style.display != "none"){
	  			$('.hfrt').show();
	  			$('.shtr').hide();
			}
			else{
				$('.shtr').show();
			}
		}

		$(document).on('click', '.hfrt', function(){
			hnS();
	  	});

	  	$(document).on('click', '.shtr', function(){
	  		hnS();
	  	});



		$(document).on('click', '.mn', function(){
			unseen = $(this).data('id');
			var id = $(this).data('id');
			var seen = 'your_'+id;

			if (document.getElementById(seen)) {
				alert("Dialog already exist!");
			}
			else{

				setInterval(function(){
					update_chat_history_data(unseen);
				}, 5000);

				setInterval
				var name = $(this).data('name');
				var mult = 1;

				box(id,name,mult);
				$('#tm_'+id).emojioneArea({
	   				pickerPosition:"top",
	   				toneStyle: "bullet"
  				});

				$(document).on('click', '.close'+id, function(){
					var seen = '#your_'+id;
	  				$(seen).remove();
	  			});

	  			$(document).on('focus', '.emojionearea-editor', function(){
					var is_t = 'yes';
					$.ajax({
						url:"uits.php",
						method:"POST",
						data:{is_t:is_t},
						success:function()
						{

						}
					})
				});

				$(document).on('blur', '.emojionearea-editor', function(){
					var is_t = 'no';
					$.ajax({
						url:"uits.php",
						method:"POST",
						data:{is_t:is_t},
						success:function()
						{

						}
					})
				});

	  			$('#uploadFile_'+id).on('change', function(){
						$('#uploadImage_'+id).ajaxSubmit({
							success:function(data)
							{
								if(data != 0)
								{
									alert(data);
									resetForm: true
									$('#uploadFile_'+id).val('');
								}
								
								resetForm: true
								$('#uploadFile_'+id).val('');
								update_chat_history_from(id);
							}
						});
				});

  			}

  			$(document).on('click', '.play_mus', function(){
  				var mic = $(this).data('file');
  				var tar = $(this).data('target');
  				var tou = $(this).data('tou');
  				var fru = $(this).data('fru');

  				$('.muson').hide();
  				if(tou != fru)
  				{
	  				$('#paus_mus_'+unseen).show();
	  				$('#play_mus_'+unseen).show();
  				}
  				else{
  					$('#paus_mus_'+tou).show();
	  				$('#play_mus_'+tou).show();
  				}

				var pause = document.getElementsByClassName("musicp");
				for (i = 0; i < pause.length; i++) {
					pause[i].pause();  
				}

				var play = '<audio class="musicp" id="music_'+mic+'" hidden><source src="'+tar+'"></audio>';
				if(tou != fru)
				{
					$('#your_'+unseen).append(play);
				}
				else
				{
					$('#your_'+tou).append(play);
				}

				var play = document.getElementById('music_'+mic);
				play.play(); 
			});	

			$(document).on('click', '#paus_mus_'+id, function(){

				var pause = document.getElementsByClassName("musicp");
				for (i = 0; i < pause.length; i++) {
					pause[i].pause();  
				}  

				$('.muson').hide(); 
			});	

		});

		$(document).on('click', '.mycdb', function(){
			$('.mycdb').css('z-index','2');
			var id = $(this).attr('id');
			$('#'+id).css('z-index','3');
		});

		function box(id,name,mult)
		{
			var out = 50 + mult;
			var innn = 63 + mult;

			var on = '<div id="your_'+id+'" class="mycdb" style="height: 300px; width: 250px; box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.2); position: absolute; left: '+innn+'%; top: '+out+'%; background-color: white; border-radius: 15px; z-index: 2"><div id='+id+' style="height: 30px; width: 250px; border-bottom: 1px solid #F0F0F0; border-radius: 15px 15px 0px 0px; cursor: move; position: relative;"><span  style="color: gray; font-family: Calibri; font-weight: bold; font-size: 13px; margin-left: 10px; float: left; margin-top: 6px;"><span style="margin-right: 4px; margin-top: 5px; float: left;" id = "tile'+id+'">'+op(id)+'</span>'+name+'</span><img class="muson" style="height: 9px; width: 9px; position: absolute; top: 30%; right: 28%; cursor: pointer;" id="paus_mus_'+id+'" src="pause_icon.png" hidden><img class="muson" id="play_mus_'+id+'" style="height: 15px; width: 50px; position: absolute; top: 23%; right: 6%;" src="audio+wave.gif" hidden><img id="close_c" class= "close'+id+'" src="iconfinder_close2_1814078.png" title="close chat" height = 15 width = 15></div><div data-scroll-speed="2" id="loader_'+id+'" style="height: 225px; background-color: #F5F9FA; width: 250px;  margin: 0px; overflow-y: scroll; overflow-x: hidden;">'+ch(id)+'</div><div style="height: 45px; width: 250px; border-top: 1px solid #F0F0F0; border-radius: 0px 0px 15px 15px;"><span style="width: 80%; float: left; position: relative;"><textarea data-touserid="'+id+'" class="chat_box" id="tm_'+id+'" style="position: absolute;  border-radius: 15px;  background-color: #F7F7F7; padding: 8px; resize: none; border: none; width: 100%; color: #828282; height:30px; margin: 4.5px; margin-top: 6px; margin-left: 5px;" type="text"></textarea></span><div class="image_upload" ><form id="uploadImage_'+id+'" method="POST" action="upload_image.php"><label for="uploadFile_'+id+'"><img class="pic_upload" style="border-radius: 50%;" src="iconfinder_upload_1054942.png" height = 15 width = 15 title="upload file"></label><input type = "hidden" name = "tuid" value = '+id+'><input style="display: none;" type="file" name="uploadFile" id="uploadFile_'+id+'" accept=".jpg, .png, .JPG, .PNG, .mp3, .MP4, .mp4, .MP4, .pdf, .PDF, .gif, .GIF"/></form></div><img id='+id+' style="margin: 4.5px; position: absolute; bottom: 1%; right: 1%;" class="chat_o" src="sndmsg1.png" title="send message" height = 28 width = 28></div></div>';
			
			$("#msg_on").append(on);
			new_loc(id,name);
		}


		function new_loc(id,name){
			var seen = 'your_'+id;
			dragElement(document.getElementById(seen));

			function dragElement(elmnt) {
			  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
			  if (document.getElementById(id)) {
			    // if present, the header is where you move the DIV from:
			    document.getElementById(id).onmousedown = dragMouseDown;
			  } else {
			    // otherwise, move the DIV from anywhere inside the DIV: 
			    elmnt.onmousedown = dragMouseDown;
			  }

			  function dragMouseDown(e) {
			    e = e || window.event;
			    e.preventDefault();
			    // get the mouse cursor position at startup:
			    pos3 = e.clientX;
			    pos4 = e.clientY;
			    document.onmouseup = closeDragElement;
			    // call a function whenever the cursor moves:
			    document.onmousemove = elementDrag;
			  }

			  function elementDrag(e) {
			    e = e || window.event;
			    e.preventDefault();
			    // calculate the new cursor position:
			    pos1 = pos3 - e.clientX;
			    pos2 = pos4 - e.clientY;
			    pos3 = e.clientX;
			    pos4 = e.clientY;
			    // set the element's new position:
			    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
			    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
			  }

			  function closeDragElement() {
			    // stop moving when mouse button is released:
			    document.onmouseup = null;
			    document.onmousemove = null;
			  }
			}
		}

		function op(id){
			$.ajax({
				url:"online_pin.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					$('#tile'+id).html(data);
				}
			})
		}

		function ch(id)
		{   
			$.ajax({
				url:"chat_memory.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					$('#loader_'+id).html(data);
					updateScroll(id);
				}
			})
		}

		function chf(id)
		{   
			$.ajax({
				url:"chat_memory_form.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					$('#loader_'+id).html(data);
					updateScroll(id);
				}
			})
		}

		function updateScroll(id){
			var seen = 'loader_'+id;
    		var element = document.getElementById(seen);
    		element.scrollTop = element.scrollHeight;
		}

		$(document).on('click', '.chat_o', function(){
		var id = $(this).attr('id');
		var cm = $('#tm_'+id).val();

			if(cm != '')
			{
				$.ajax({
					url:"upload_m.php",
					method:"POST",
					data:{id:id, cm:cm},
						success:function(data)
						{
							var element = $('#tm_'+id).emojioneArea();
			    			element[0].emojioneArea.setText('');
							$('#loader_'+id).html(data);
							updateScroll(id);
						}
				})
			}
		});

		function mestus(id){
			$.ajax({
				url:"mestus.php",
				method:"POST",
				data:{id:id},
				success:function(data){
					if(document.getElementById('mestus_'+id))
					{
						$('#mestus_'+id).html(data);
					}
				}
			})
		}

		function update_chat_history_data(id)
		{
			var seen = 'your_'+id;
			mestus(id);

			if (document.getElementById(seen)) 
			{
			   $('.chat_box').each(function(){
				var id = $(this).data('touserid');
					$.ajax({
					url:"cum.php",
					method:"POST",
					data:{id:id},
						success:function(data){
							op(id);
							if(data != 0)
							{
								ch(id);
							}
						}
					})
				});
			} 
			else 
			{
			
			}
		}

		function update_chat_history_from(id)
		{
			var seen = 'your_'+id;
			if (document.getElementById(seen)) {
			   $('.chat_box').each(function(){
				var id = $(this).data('touserid');

					$.ajax({
					url:"cfm.php",
					method:"POST",
					data:{id:id},
						success:function(data){
							op(id);
							if(data != 0)
							{
								chf(id);
							}
						}
					})
				});
			} 
			else 
			{
			
			}
		}

		$(document).on('click', '.del', function(){
			var cmid = $(this).attr('id');
			if(confirm("Delete chat message ?"))
			{
				$.ajax({
					url:"rc.php",
					method:"POST",
					data:{cmid:cmid},
					success:function(data)
					{
						ch(data);
					}
				})
			}
		});

		$(document).on('click', '.approve', function(){
			var tid = $(this).attr('id');
			$.ajax({
				url:"ar.php",
				method:"POST",
				data:{tid:tid},
				success:function(data)
				{

				}
			})
		});

		$(document).on('click', '.decline', function(){
			var tid = $(this).attr('id');
			$.ajax({
				url:"dr.php",
				method:"POST",
				data:{tid:tid},
				success:function(data)
				{

				}
			})
		});

		$(document).on('click', '.upi', function(){
			var id = $(this).attr('id');
			$.ajax({
				url:"vsi.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$("#msg_on").append(data);
				}
			})

		});

		$(document).on('click', '.civ', function(){
	  		$('.iv').remove();
	  	});

	  	setInterval(function(){
	  		topics();
		}, 4000);

		function topics(){
			var tt = $('.topic_title').val();
			var td = $('.topic_desc').val();
			var replace = '<img class="upfa" src="add_forum.png" height=30 width=30 title="upload topic">';
			var recent = '<img id="add_forum" class="add_forum" src="add_forum_off.png" height=30 width=30 title="add topic">';
			if( tt != '' && td != '')
			{
				$('.topic_stat').html(replace);
			}
			else
			{
				if(document.getElementById("add_forum")){

				}
				else
				{
					$('.topic_stat').html(recent);	
				}
			}
		}

		$(document).on('click', '.add_forum', function(){
	  		$('.aff').slideToggle(500);

	  		$('#ff').on('change', function(){
	  			var tf = $('#ff').val();
	  			if(tf != '')
	  			{
					var file = '<img style="float: right;" src="iconfinder_circle-content-upload-cloud_1495031.png"  height="23" width="23" title="attached file" />';
						$('.isset').html(file);
				}
				else{
					var file = '<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />';
					$('.isset').html(file);	
				}
			});
	  	});



		$(document).on('click', '.upfa', function(){
			$('#submitfac').ajaxSubmit({
				success:function(data)
				{
					if(data != 0)
					{
						alert(data);
					}
					else
					{
						var recent = '<img id="add_forum" class="add_forum" src="add_forum_off.png" height=30 width=30 title="add topic">';
						resetForm: true
						var file = '<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attached file" />';
						$('.isset').html(file);
						$('.topic_title').val('');
						$('.topic_desc').val('');
						$('#ff').val('');
						$('.aff').hide(500);
						$('.topic_stat').html(recent);
						faculty_content();
					}
				}
			});
		});

		faculty_content();
		function faculty_content(){
				$.ajax({
				url:"facct.php",
					success:function(data)
					{
						$(".forum_replace").html(data);
						snh();
					}
				})
		}


		$(document).on('click', '.srbtn', function(){
			var val = $('.type_select2').val();
			var cate = $('#cate').val();
			var title = $('.topic_search').val();
			if(title != '')
			{
				$.ajax({
						url:"tabco.php",
						method:"POST",
						data:{val:val,title:title,cate:cate},
						success:function(data)
						{
							$('.tabco').html(data);
						}
				})
			}
		});

		$(document).on('change', '.type_select2', function(){
			var cate = $('.type_select').val();
			var val = $('.type_select2').val();
			var ser = $('.topic_search').val();
			$.ajax({
					url:"sorto.php",
					method:"POST",
					data:{val:val,ser:ser,cate:cate},
					success:function(data)
					{
						$('.tabco').html(data);
					}
			})
		});

		function loaded(){
			
		}

		function catt(tid){
			$.ajax({
				url:"cat-t.php",
				method:"POST",
				data:{tid:tid},
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		}

		$(document).on('click', '.cat-t', function(){
			var tid = $(this).attr('id');
			$.ajax({
				url:"cat-t.php",
				method:"POST",
				data:{tid:tid},
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		});

		$(document).on('click', '.topic_link', function(){
			var tid = $(this).attr('id');
			var cat = $(this).data('cat');
			$.ajax({
				url:"to_re.php",
				method:"POST",
				data:{tid:tid,cat:cat},
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
					forum_loader();
				}
			})
		});

		$(document).on('click', '.back_to_faculty', function(){
			var recent = '<img class="add_forum" src="add_forum_off.png" height=30 width=30 title="add topic">';
			$('.topic_stat').html(recent);

			faculty_content();
		});

		$(document).on('click', '.reply-link', function(){
			var id = $(this).attr('id');
			var cat = $(this).data('cat');

			$(".reply-link").hide();
			$(".f_r_a").show();

			if(document.getElementById("ffr"))
			{
				var f = $('#ffr').val();
				var t = $('.reply_desc').val()
				$('#ffr').on('change', function(){
					var tf = $('#ffr').val();
		  			if(tf != '')
		  			{
						var file = '<img style="float: right;" src="added_p.png"  height="23" width="23" title="attached file" />';
						$('.issetfr').html(file);
					}
					else{
						var file = '<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />';
						$('.issetfr').html(file);	
					}
					
				});

				setInterval(function(){
					on(id);
				}, 2000);

				var ac = '<span style="font-weight: lighter; margin-left: 2px;">cancel</span>';
				$('.change').html(ac);

				function on(id){
					if($('#ffr').val() != '' || $('.reply_desc').val() != '')
					{
						var ac = '<span id= "'+id+'_'+cat+'" class="act_c" style="color:#324A60;">comment</span>';
						$('.change').html(ac);
					}
					else{
						var ac = '<span class="cancel" style="font-weight: lighter; margin-left: 2px;">cancel</span>';
						$('.change').html(ac);
					}
				}
			}
		});

		$(document).on('click', '.cancel', function(){
			$(".f_r_a").hide();
			$(".reply-link").show();
		});

		$(document).on('click', '.upif', function(){
			var id = $(this).attr('id');
			$.ajax({
				url:"vsif.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$("#msg_on").append(data);
				}
			})
		});

		function unot(id){
			$.ajax({
				url:"unot.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$('.num_of').html(data);
				}
			})
		}


		$(document).on('click', '.act_c', function(){
			var id = $(this).attr('id');

			function udtr(id){
				$.ajax({
					url:"udtr.php",
					method:"POST",
					data:{id:id},
					success:function(data)
					{
						$('.replies_rep').html(data);
					}
				})
			}

			$('#fac_re').ajaxSubmit({
				success:function(data)
				{
					if(data != "")
					{
						alert(data);
						resetForm: true
						$('#ffr').val('');
					}
					else
					{
						resetForm: true
						$('#ffr').val('');
						$('.reply_desc').val('')
						$(".f_r_a").hide(500);
						$(".reply-link").show();
						udtr(id);
						unot(id);
					}
				}
			});
		});

		function dnot(id){
			$.ajax({
				url:"dnot.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$('.num_of').html(data);
				}
			})
		}

		$(document).on('click', '.dlr', function(){
			var id = $(this).attr('id');
			alert(id);
			if(confirm("Delete reply ?"))
			{
				$.ajax({
					url:"dlr.php",
					method:"POST",
					data:{id:id},
					success:function(data)
					{
						$('.replies_rep').html(data);
						dnot(id);
					}
				})
				u_f();
			}
		});		

		$(document).on('click', '.option_pin', function(){
			$('.pivi').fadeToggle(500);
		});

		function whole_re(id){
			$.ajax({
				url:"pr.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$(".pivi").html(data);
				}
			})
		}

		$(document).on('click', '.pin', function(){
			var id = $(this).attr('id');
			$.ajax({
				url:"fntr.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					whole_re(id);
					$('.option_pin').show(500);
					$('.pin').hide();
				}
			})
		});

		$(document).on('click', '.dto', function(){
			var id = $(this).attr('id');
			if(confirm('Delete topic?'))
			{
				$.ajax({
					url:"dto.php",
					method:"POST",
					data:{id:id},
					success:function(data)
					{
						if(data == '1')
						{
							catt(id);
						}
						else if(data == '2'){
							event_content();
						}
					}
				})
			}
		});

		setInterval(function(){
			u_f();
			frm_nv();
			eve();
		}, 5000);

		u_f();
		function u_f(){
			$.ajax({
				url: "unseen_forum_not.php",
				method: "POST",
				success:function(data){
					$('.unseen_forum').html(data);
				}
			})
		}

		function frm_nv(){
			if (document.getElementById('frmf')){
				u_fu();
			}
		}

		$(document).on('click', '.drop_forum', function(){
			u_fu();
		});

		function u_fu(){
			$.ajax({
				url: "display_uf.php",
				method: "POST",
				success:function(data){
					$('.notification_viewer').html(data);
				}
			})
		}

		$(document).on('click', '#cat1', function(){
			$('.loader').show();
			faculty_content();
			forum_loader();
		});

		function event_content(){
			$.ajax({
				url:"evcct.php",
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		}

		function ev_s_ti(){
			$.ajax({
				url:"ev_s_ti.php",
				success:function(data)
				{
					$("#fls").html(data);
				}
			})
		}

		$(document).on('click', '#cat2', function(){
			event_content();
			ev_s_ti();
		});

		$(document).on('click', '.add_event', function(){
			$(".aef").slideToggle(500);

			if(document.getElementById("aef"))
			{
				//var f = $('#ffr').val();
				//var t = $('.reply_desc').val()
				setInterval(function(){
					upld();
				}, 2500);

				function upld(){
					var even = $('.event_name').val();
					var eved = $('.event_desc').val();
					var evesd = $('.evesd').val();
					var evest = $('.evest').val();
					var evecd = $('.evecd').val();
					var evect = $('.evect').val();
					var evel = $('.event_loc').val();
					if( even != '' && eved != '' && evesd != '' && evest != '' && evecd != '' && evect != '' && evel != '')
					{
						$('.hv').val(even);
						$('.ha').val(eved);
						$('.hb').val(evesd);
						$('.hc').val(evest);
						$('.hd').val(evecd);
						$('.he').val(evect);
						$('#issete').show();
					}
					else
					{
						if(document.getElementById("issete")){

						}
						else
						{
							$('#issete').hide();	
						}
					}
				}

				$('#effs').on('change', function(){
					upld();
					if(confirm("Event details can not be altered after adding event poster, confirm?"))
					{
						$('#selpic').ajaxSubmit({
							success:function(data)
							{
								if(data == '0' || data == '1' || data == '2' || data == '3' || data == 'None')
								{
									if(data == '0')
									{
										alert('Invalid date range!');
									}
									else if(data == '1')
									{
										alert('Event name already exist!');
									}
									else if(data == '2')
									{
										alert('File size too large! preferred range 0 - 5MB!');
									}
									else if(data == '3')
									{
										alert('File size too large! preferred range 0 - 30MB!');
									}
									else if(data == 'None')
									{
										alert('No file selected!');
									}
								}
								else
								{
									$('.selpic').html(data);
									var tr = $('.event_name').val();
									var eved = $('.event_desc').val();
									var evesd = $('.evesd').val();
									var evest = $('.evest').val();
									var evecd = $('.evecd').val();
									var evect = $('.evect').val();
									var evel = $('.event_loc').val();
									var en = '<input type="text" id="event_name" class="event_name" name="event_name" readonly>';
									var ed = '<textarea class="event_desc" id="txta" name="event_desc" readonly></textarea>';
									var esd = '<input type="date" name="evesd" class="evesd" style="width:40%; font-family: Calibri; background-color: white; color: #84B58D; margin-top: 11px; border: none; padding-bottom: 5px; border-bottom: 1px solid #84B58D" readonly> <input type="time" name="evest" class="evest" style="width:30%; background-color: white; font-family: Calibri; color: #84B58D; margin-top: 11px; margin-left: 4%; border: none; padding-bottom: 5px; border-bottom: 1px solid #84B58D; display: inline;" readonly>';
									var ecd = '<input type="date" name="evecd" class="evecd" style="width:40%; font-family: Calibri; color: #C46362; margin-top: 11px; border: none; padding-bottom: 5px; background-color: white; border-bottom: 1px solid #C46362;" readonly> <input type="time" name="evect" class="evect" style="width:30%; background-color: white; font-family: Calibri; color: #C46362; margin-top: 11px; margin-left: 4%; border: none; padding-bottom: 5px; border-bottom: 1px solid #C46362; display: inline;" readonly>';
									var can = '<input type="text" class="event_loc" name="event_loc" readonly><img src="loc.png" style="float: right; vertical-align:bottom; margin-top: 23px; opacity: 0.5;" height=18 width=18 /><span style="cursor:pointer; position: absolute; right: 0px; top: 0px; font-size: 13px;" class="cancel">cancel</span>';
									$('.trw').html(en);
									$('.edc').html(ed);
									$('.esd').html(esd);
									$('.ecd').html(ecd);
									$('.cce').html(can);
									$('#event_name').val(tr);
									$('.event_desc').val(eved);
									$('.evesd').val(evesd);
									$('.evest').val(evest);
									$('.evecd').val(evecd);
									$('.evect').val(evect);
									$('.fn').val(tr);
									$('.event_loc').val(evel);
									var onit = $('.fn').val();
								}
							}
						});	
					}
				});				

				$(document).on('click', '.play_video', function(){
					$('.play_video').hide();
					var vid = document.getElementById("vid"); 
					vid.play(); 
				});	

				$(document).on('click', '#vid', function(){
					$('.play_video').show();
					var vid = document.getElementById("vid"); 
					vid.pause(); 
				});	

				$(document).on('click', '.cancel', function(){
					var ev = $('.event_name').val();
					var enn = '<input type="text" class="event_name" name="topic_title" placeholder="Event name:" required>';
					var en = '<input type="text" id="event_name" class="event_name" name="topic_title" disabled>';
					var ed = '<textarea class="event_desc" id="txta" name="topic_desc" ></textarea>';
					var esd = '<input type="date" class="evesd" style="width:40%; font-family: Calibri; background-color: white; color: #84B58D; margin-top: 11px; border: none; padding-bottom: 5px; border-bottom: 1px solid #84B58D" > <input type="time" class="evest" style="width:30%; background-color: white; font-family: Calibri; color: #84B58D; margin-top: 11px; margin-left: 4%; border: none; padding-bottom: 5px; border-bottom: 1px solid #84B58D; display: inline;" >';
					var ecd = '<input type="date" class="evecd" style="width:40%; font-family: Calibri; color: #C46362; margin-top: 11px; border: none; padding-bottom: 5px; background-color: white; border-bottom: 1px solid #C46362;" > <input type="time" class="evect" style="width:30%; background-color: white; font-family: Calibri; color: #C46362; margin-top: 11px; margin-left: 4%; border: none; padding-bottom: 5px; border-bottom: 1px solid #C46362; display: inline;" >';
					var can = '<input type="text" class="event_loc" name="event_loc" readonly><img src="loc.png" style="float: right; vertical-align:bottom; margin-top: 23px; opacity: 0.5;" height=18 width=18 />';
					$.ajax({
						url: "caev.php",
						method: "POST",
						data:{ev:ev},
						success:function(data){
							if(data != 0)
							{
								$('.trw').html(enn);
								$('.edc').html(ed);
								$('.esd').html(esd);
								$('.ecd').html(ecd);
								$('#effs').val('');
								$(".aef").slideUp(500);
								$('.selpic').html('');
								$('.cce').html('');
								$('#issete').hide();
								$('.cce').html(can);
							}
						}
					})
				});	
				
			}
		});

		$(document).on('click', '.play_video', function(){
			$('.play_video').hide();
			var vid = document.getElementById("vid"); 
			vid.play(); 
		});	

		$(document).on('click', '#vid', function(){
			$('.play_video').show();
			var vid = document.getElementById("vid"); 
			vid.pause(); 
		});	

		function eve(){
			var even = $('.event_name').val();
			var eved = $('.event_desc').val();
			var evesd = $('.evesd').val();
			var evest = $('.evest').val();
			var evecd = $('.evecd').val();
			var evect = $('.evect').val();
			var replace = '<img class="upfe" src="add_event_on.png" style="cursor:pointer;" height=25 width=29 title="upload event">';
			var recent = '<img id="add_event" class="add_event" src="add_event_off.png" height=30 width=30 title="add event">';
			if( even != '' && eved != '' && evesd != '' && evest != '' && evecd != '' && evect != '')
			{
				$('.event_stat').html(replace);
			}
			else
			{
				if(document.getElementById("add_event")){

				}
				else
				{
					$('.event_stat').html(recent);	
				}
			}
		}

		$(document).on('click', '.upfe', function(){
			$('#submitfe').ajaxSubmit({
				success:function(data)
				{
					if(data != 0)
					{
						if(data == '0')
						{
							alert('Fill out all empty spaces!');
						}
						else if(data == '1')
						{
							alert('Invalid date range!');
						}
						else if(data == '2')
						{
							alert('Event name already exist!');
						}
						else if(data == '3')
						{
							alert('Event name too short!');
						}
						else if(data == '4')
						{
							alert('Event description too short!');
						}
						else
						{
							alert(data);
						}
					}
					else{
						event_content();
					}
				}
			});		
		});	

		function starte(){
			$(document).on('click', '.eupcoming', function(){
				$.ajax({
					url: "eupcoming.php",
					success:function(data){
						$('.evsr').html(data);
					}
				})
			});	
		}

		$(document).on('click', '.eupcoming', function(){
			starte();
			$('.eupcoming').css('font-weight','bold');
			$('.elive').css('font-weight','lighter');
			$('.egoing').css('font-weight','lighter');
		});

		$(document).on('click', '.elive', function(){
			$.ajax({
				url: "elive.php",
				success:function(data){
					$('.evsr').html(data);
					$('.elive').css('font-weight','bold');
					$('.eupcoming').css('font-weight','lighter');
					$('.egoing').css('font-weight','lighter');
				}
			})
		});

		$(document).on('click', '.egoing', function(){
			$.ajax({
				url: "egoing.php",
				success:function(data){
					$('.evsr').html(data);
					$('.eupcoming').css('font-weight','lighter');
					$('.elive').css('font-weight','lighter');
					$('.egoing').css('font-weight','bold');
				}
			})
		});

		$(document).on('click', '.event_link', function(){
			var tid = $(this).attr('id');
			$.ajax({
				url:"ev_re.php",
				method:"POST",
				data:{tid:tid},
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		});

		$(document).on('click', '.back_to_event', function(){
			event_content();
		});

		setInterval(function(){
	  		loadede();
		}, 1000);

		function loadede(){
			var title = $('.search_e').val();
			if(title != ''){
				$.ajax({
					url:"se_ev_ti.php",
					method:"POST",
					data:{title:title},
					success:function(data)
					{
						$('.ev_ti').html(data);
					}
				})
			}
			else{
					if(!document.getElementById('sl')){
						se();
					}
			}
		}

		function se(){
			var output = '<img style="opacity: 0.1; margin-top: 10px;" src="search_help.png" height="200" width="200" />';
			$('.ev_ti').html(output);
		}

		$(document).on('click', '.reply-link_e', function(){
			var id = $(this).attr('id');
			$(".reply-link_e").hide();
			$(".f_r_e").show();

			if(document.getElementById("ffre"))
			{
				var f = $('#ffre').val();
				var t = $('.reply_desc_e').val()
				$('#ffre').on('change', function(){
					var file = '<img style="float: right;" src="uploaded_ev.png"  height="23" width="23" title="attached file" />';
					$('.issetfr').html(file);
				});

				setInterval(function(){
					one(id);
				}, 2000);

				function one(id){
					if($('#ffre').val() != '' || $('.reply_desc_e').val() != '')
					{
						var ac = '<span id='+id+' class="act_ce" style="color: #700707;">comment</span>';
						$('.changee').html(ac);
					}
					else{
						var ac = '<span class="cancel" style="font-weight: lighter; margin-left: 2px; color: gray;">cancel</span>';
						$('.changee').html(ac);
					}
				}
			}
		});

		$(document).on('click', '.cancel', function(){
			$(".f_r_e").hide();
			$(".reply-link_e").show();
		});

		$(document).on('click', '.act_ce', function(){
			var id = $(this).attr('id');


			function udtre(id){
				$.ajax({
					url:"udtre.php",
					method:"POST",
					data:{id:id},
					success:function(data)
					{
						$('.replies_repe').html(data);
					}
				})
			}

			$('#fac_ee').ajaxSubmit({
				success:function(data)
				{
					if(data != "")
					{
						alert(data);
						resetForm: true
						$('#ffre').val('');
					}
					else
					{
						resetForm: true
						$('#ffre').val('');
						$('.reply_desc_e').val('')
						$(".f_r_e").hide(500);
						$(".reply-link_e").show();
						udtre(id);
						unote(id);
					}
				}
			});
		});


		function unote(id){
			$.ajax({
				url:"unote.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$('.num_of_e').html(data);
				}
			})
		}

		$(document).on('click', '.upie', function(){
			var id = $(this).attr('id');
			$.ajax({
				url:"vsie.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$("#msg_on").append(data);
				}
			})
		});

		function dnote(id){
			$.ajax({
				url:"dnote.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$('.num_of_e').html(data);
				}
			})
		}

		$(document).on('click', '.dlre', function(){
			var id = $(this).attr('id');
			if(confirm("Delete reply ?"))
			{
				$.ajax({
					url:"dlre.php",
					method:"POST",
					data:{id:id},
					success:function(data)
					{
						dnote(id);
						$('.replies_repe').html(data);
						
					}
				})
				u_f();
			}
		});	

		function sale_content(){
			$.ajax({
				url:"vacct.php",
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		}

		function sa_c(){
			$.ajax({
				url:"sa_c.php",
				success:function(data)
				{
					$("#fls").html(data);
				}
			})
		}

		$(document).on('click', '#cat3', function(){
			$('.loader').show();
			sale_content();
			sa_c();
		});

		$(document).on('click', '#add_store', function(){
	  		$('.vff').slideToggle(500);

	  		$(document).on('change', '.c_type', function(){
				var c = $('.c_type').val();
				if(c == '4')
				{
					var ch = '<input id="4" class="c_num" type="number" min="2" max="4" placeholder="Alternatives" />';
					$('.c_num_re').html(ch)
				}
				else if(c == '10')
				{
					var ch = '<input id="10" class="c_num" type="number" min="2" max="10" placeholder="Alternatives" />';
					$('.c_num_re').html(ch)
				}
			});

	  		setInterval(function(){
				von();
			}, 5000);

			$(document).on('change', '.v_opt', function(){
				var c = $('.v_opt').val();
				if(c == 'opened')
				{
					$('.con_code').hide();
				}
				else if(c == 'closed')
				{
					$('.con_code').show();
				}
			});

			$(document).on('change', '.inv', function(){
				id = $(this).data('id');
				var filef = $('#vf_'+$id).val();

				if(filef != '')
				{
					var file = '<img style="position: absolute; right: 10%; top: 15%; opacity: 0.7;" src="v_file_on.png"  height="23" width="23" title="attached file" />';
					$('#fv_'+id).html(file);
				}
				else{
					var file = '<img style="position: absolute; right: 10%; top: 15%;" src="empty_attach.png"  height="23" width="23" title="attach file" />';
					$('#fv_'+id).html(file);
				}
			});
	  	});

		$(document).on('change', '.c_num', function(){
			var idd = $('.c_type').val();
			var c = $('.c_num').val();
			if(idd == 10){
				var	id = 10;
			}
			else{
				var id = 4;
			}

			if(c < 2 || c > id)
			{
				alert("Alternatives must be between 2-"+id+"!");
			}
			else
			{
				$.ajax({
					url:"num_of_c.php",
					method:"POST",
					data:{c:c, id:id},
					success:function(data)
					{
						$('.c_tab_al').html(data);
						
					}
				})
			}
		});

		$(document).on('focus', '.choice_num', function(){
			id = $(this).data('id');
			if(document.getElementById('ser_'+id))
			{
				$('#ser_'+id).show();
			}

			if(document.getElementsByClassName("hide_sl"))
			{
				var pause = document.getElementsByClassName("hide_sl");
				for (i = 0; i < pause.length; i++) 
				{
					pause[i].style.display = "none";
				}
			}

			if(document.getElementsByClassName("ser"))
			{
				$('.ser').each(function(){
					$('.ser').hide();
				});
			}

			$('#ser_'+id).show();

			var size = document.getElementById('ser_'+id);
			if(size.style.display != "none"){
				setInterval(function(){
				qso(id);
				}, 1000);
			}


			$('#hsl_'+id).show();

			function qso(id){
				var con = $('#con_'+id).val();
				if(con != '')
				{			var chser = $('#con_'+id).val();
							$.ajax({
								url:"serc_na.php",
								method:"POST",
								data:{chser:chser},
								success:function(data)
								{
									$('#ser_'+id).html(data);			
								}
							})
				}
			}
		});

		$(document).on('click', '.hide_sl', function(){
			n = $(this).data('id');

			$('#hsl_'+n).hide();
			$('#ser_'+n).hide();
		});

		$(document).on('click', '#scon', function(){
			n = $(this).data('name');

			var pause = document.getElementsByClassName("choice_num");
			ex = 0;
			for (i = 0; i < pause.length; i++) 
			{
				if(pause[i].value == n)
				{
					ex += 1;
				}
			}

			if(ex < 1)
			{
				$('#con_'+id).val(n);	
				$('#con_'+id).css('border-bottom', '1px solid #1E2D38');
			}
			else{
				alert("Alternative already exist!");
			}
		});

		function von(){
			if($('.contest_name').val() != '' && $('.c_type').val() != '' && $('.vote_desc').val() != '' && $('.v_opt').val() != '' && $('#v_hrs').val() != '' && $('#m_hrs').val() != '')
			{
				var pause = document.getElementsByClassName("choice_num");
				sure = 0;
				for (i = 0; i < pause.length; i++) 
				{
					if(pause[i].value == '')
					{
						sure += 1;
					}
				}

				nv = 0;
				if(document.getElementsByClassName("inv"))
				{
					var inv = document.getElementsByClassName("inv");
					for (i = 0; i < inv.length; i++) 
					{
						if(inv[i].value != '')
						{
							nv += 1;
						}
					}
				}
					

				if(sure < 1 || nv > 0)
				{
					var ac = '<img id="up_con" class="add_forum" src="add_vote_on.png" height=30 width=30 title="upload contest">';
					$('.store_stat').html(ac);
				}
				else{
					var ac = '<img id="add_store" class="add_forum" src="add_vote.png" height=30 width=30 title="add contest">';
					$('.store_stat').html(ac);
				}
			}
			else{
				var ac = '<img id="add_store" class="add_forum" src="add_vote.png" height=30 width=30 title="add contest">';
				$('.store_stat').html(ac);
			}
		}

		$(document).on('click', '#up_con', function(){
			var pause = document.getElementsByClassName("choice_num");
			total = 0;
			for (i = 0; i < pause.length; i++) 
			{
				total += 1;
			}
			$('.total').val(total);
			$('#submitvd').ajaxSubmit({
				success:function(data)
				{
					if(data != 0)
					{
						alert(data);
					}
					else{
						sale_content();
						sa_c();
					}
				}
			});
		});

		setInterval(function(){
	  		loaded_v();
		}, 1000);

		function loaded_v(){
			var title = $('.search_v').val();
			if(title != ''){
				$.ajax({
					url:"se_vo_cn.php",
					method:"POST",
					data:{title:title},
					success:function(data)
					{
						$('.vo_ti').html(data);
					}
				})
			}
			else{
					if(!document.getElementById('sl')){
						vs();
					}
			}
		}

		function vs(){
			var output = '<img style="opacity: 0.1; margin-top: 10px;" src="search_help.png" height="200" width="200" />';
			$('.vo_ti').html(output);
		}

		$(document).on('click', '.vact_na', function(){
			var tid = $(this).attr('id');
			$.ajax({
				url:"vo_re.php",
				method:"POST",
				data:{tid:tid},
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		});

		function vo_re(cid){
			$.ajax({
				url:"vo_re.php",
				method:"POST",
				data:{tid:tid},
				success:function(data)
				{
					$(".forum_replace").html(data);
				}
			})
		}

		$(document).on('click', '.back_to_vo', function(){
			sale_content();
		});

		$(document).on('click', '#view', function(){
			var x = document.getElementById("contest_code");
			if(x.type === "password"){
				x.type = "text";
			}
			else{
				x.type = "password";
			}
		});

		$(document).on('click', '.code_sub', function(){
			$('#vot_cv').ajaxSubmit({
				success:function(data)
				{
					if(data == '0')
					{
						alert('Empty field!');
					}
					else if(data == '1')
					{
						$('.error').show();
					}
					else{
						$(".forum_replace").html(data);
						snh();
					}
				}
			});
		});

		$(document).on('click', '.vote_but', function(){
			var cn = $(this).data('cn');
			var cid = $(this).data('cid');

			$.ajax({
				url:"vo_ch.php",
				method:"POST",
				data:{cn:cn, cid:cid},
				success:function(data)
				{
					if(data != '0')
					{
						$(".forum_replace").html(data);
						snh();
					}	
				}
			})
		});

		$(document).on('click', '.view_graph', function(){
			var cid = $(this).data('cid');
			var back = '<img src="vote_graph_off.png" class="off_graph" data-cid='+cid+' style="margin: 2px; margin-bottom: -5px; cursor: pointer;" title="Off graph" height="17" width="17">';

			$.ajax({
				url:"gdv.php",
				method:"POST",
				data:{cid:cid},
				success:function(data)
				{
						$('.ctv').html(data);
						snh();
						$('.vote_status').html(back);

						setInterval(function(){
							vsu(cid);
						}, 10000);
				}
			})
		});

		$(document).on('click', '.off_graph', function(){
			var cid = $(this).data('cid');
			var back = '<img src="vote_graph.png" class="view_graph" data-cid='+cid+' style="margin: 2px; margin-bottom: -5px; cursor: pointer;" title="View graph" height="17" width="17">';
			
			$.ajax({
				url:"rtv.php",
				method:"POST",
				data:{cid:cid},
				success:function(data)
				{
					if(data != '0')
					{
						$('.ctv').html(data);
						snh();
						$('.vote_status').html(back);
					}	
				}
			})
		});

		function vsu(cid){
			if (document.getElementById('vus'+cid)){
				$.ajax({
					url:"gdv.php",
					method:"POST",
					data:{cid:cid},
					success:function(data)
					{
						if(data != '0')
						{
							$('.ctv').html(data);
						}
						else
						{
							vo_re(cid);
						}		
					}
				})
			}
		}

		$(document).on('click', '.vcp', function(){
			var id = $(this).data('id');
			$.ajax({
				url:"vcp.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$("#msg_on").append(data);
				}
			})

		});

		$(document).on('click', '.conte', function(){
			sale_content();
		});

		$(document).on('click', '.enga', function(){
			eng_content();
		});

		function eng_content(){
			$.ajax({
				url:"evacct.php",
				success:function(data)
				{
					$(".onvote").html(data);
					snh();
				}
			})
		}

		function ol_content(){
			$.ajax({
				url:"ol_content.php",
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		}

		function ol_s_ti(){
			$.ajax({
				url:"ol_s_ti.php",
				success:function(data)
				{
					$("#fls").html(data);
				}
			})
		}

		$(document).on('click', '.add_ol', function(){
	  		$('.olf').slideToggle(500);

	  		$('#ffol').on('change', function(){
	  			var tf = $('#ffol').val();
	  			if(tf != '')
	  			{
					var file = '<img class="upol" style="float: right;" src="v_file_on.png" height=23 width=23>';
					$('.isset').html(file);
				}
				else{
					var file = '<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />';
					$('.isset').html(file);	
				}
			});

			$('#ffolc').on('change', function(){
	  			var tf = $('#ffolc').val();
	  			if(tf != '')
	  			{
					var file = '<img style="float: right; margin-left: 8px; cursor: pointer;" src="upld.png"  height="18" width="18" title="file attached" />';
					$('.issetc').html(file);
				}
				else{
					var file = '<img style="float: right; margin-left: 8px; cursor: pointer;" src="uplc.png"  height="18" width="18" title="attach file" />';
					$('.issetc').html(file);	
				}
			});
	  	});

		$(document).on('click', '#cat4', function(){
			$('.loader').show();
			ol_s_ti();
			ol_content();
		});

		setInterval(function(){
	  		libr();
		}, 4000);

		function libr(){
			var tt = $('.book_title').val();
			var td = $('.book_desc').val();
			var tf = $('#ffol').val();
			var tc = $('#olse').val();
			var replace = '<img class="upol" src="add_lib_on.png" height=30 width=30 title="upload topic">';
			var recent = '<img id="add_ol" class="add_ol" src="add_lib.png" height=30 width=30 title="add topic">';
			if( tt != '' && td != '' && tf != '' && tc != '')
			{
				$('.topic_sol').html(replace);
			}
			else
			{
				if(document.getElementById("add_forum")){

				}
				else
				{
					$('.topic_sol').html(recent);	
				}
			}
		}

		$(document).on('click', '.upol', function(){
			$('#submitol').ajaxSubmit({
				success:function(data)
				{
					if(data != 0)
					{
						ol_content();
					}
					else
					{
						alert(data);
					}
				}
			});
		});

		$(document).on('click', '#ol_bud', function(){
			var id = $(this).data('id');
			$.ajax({
				url:"ol_bud.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{

				}
			})
		});

		$(document).on('click', '#ol_bur', function(){
			var id = $(this).data('id');
			$.ajax({
				url:"ol_bur.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					window.open(data);
				}
			})
		});

		$(document).on('click', '.srol', function(){
			var val = $('.type_select2').val();
			var cate = $('#cate').val();
			var title = $('.topic_search').val();
			if(title != '')
			{
				$.ajax({
						url:"ol_s.php",
						method:"POST",
						data:{val:val,title:title,cate:cate},
						success:function(data)
						{
							$('.ol_view').html(data);
						}
				})
			}
		});

		$(document).on('click', '.ol_op', function(){
			var id = $(this).attr('id');
			$.ajax({
				url:"ol_ca.php",
				method:"POST",
				data:{id:id},
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})

		});

		$(document).on('click', '.book_c', function(){
			var id = $(this).attr('id');
			var tid = $(this).data('tid');
			$.ajax({
				url:"ol_re.php",
				method:"POST",
				data:{id:id,tid:tid},
				success:function(data)
				{
					$(".forum_replace").html(data);
					snh();
				}
			})
		});

	});
</script>