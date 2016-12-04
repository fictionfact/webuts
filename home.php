<?php 
	require_once "db.php";
	session_start();
	if(empty($_COOKIE['logged_in'])){
		header("Location: main.php");
	}
	setcookie("logged_in", $_COOKIE['logged_in'], time()+(86400*7));
 ?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<meta charset="UTF-8">
	<link rel="icon" href="images/resources/logo.png">
	<title>Goblogger</title>
	<style type="text/css">
		@keyframes fadeIn {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}
		@keyframes fadeOut {
			0% {
				opacity: 1;
			}

			100% {
				opacity: 0;
			}
		}
		.anim{
			animation-duration: 0.5s;
			transition-timing-function: ease-in;
			animation-name: fadeIn;
		}
		.anim_out{
			animation-duration: 0.5s;
			transition-timing-function: ease-in;
			animation-name: fadeOut;
		}
		body{
			font-family: arial;
			background-image: url('images/resources/bg.png');
			background-size: 30%;
		}
		#header{
			margin-left:-8px;
			margin-top:-8px;
			width:100%;
			height:50px;
			background-color: #79D4F2;
			position:fixed;
			z-index: 999;
		}
		#footer{
			background-color: #79D4F2;
			height:50px;
			width:100%;
			margin-left: -8px;
			position:absolute;
			padding-bottom: 12px;
		}
		#footer p{
			text-align: center;
			margin-top:20px;
			color:white;
		}
		#content{
			margin: auto;
			padding-top: 80px;
			width:950px;
			min-height: 600px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: white;
		}
		#searchform{
			margin-left: 500px;
			margin-top: -43px;
		}
		#field_search{
			width:300px;
			border: 1px solid white;
		}
		#field_search:focus{
			outline: none;
		}
		#button_search{
			margin-left: 5px;
			color:white;
			border: 2px solid white;
			background-color: #79D4F2;
			border-radius: 10px;
			transition: background-color 300ms;
		}
		#button_search:hover{
			background-color: #59BDDE;
		}
		#button_search:focus{
			outline:none;
		}
		#sidebar img{
			width:40px;
			height:40px;
			margin-left: 1000px;
			margin-top: -34px;
			position: absolute;
			border: 2px solid white;
			border-radius: 25px;
		}
		.image_profile{
			width:40px;
			height:40px;
			border: 2px solid white;
			border-radius: 25px;
			vertical-align: top;
			background-color: #79D4F2;
		}
		.link_profile{
			margin-left: 100px;
		}
		.image_profile_commenter{
			width:30px;
			height:30px;
			border: 1.5px solid white;
			border-radius: 18.75px;
			vertical-align: top;
			background-color: #79D4F2;
		}
		.link_commenter{
			margin-left: 20px;
		}
		.side_text{
			text-decoration: none;
			color:white;
			position:absolute;
			margin-left:1065px;
			margin-top: -27px;
			border: 2px solid white;
			padding:5px;
			border-radius: 10px;
			transition: background-color 300ms;
		}
		#sidetext{
			margin-left:1150px;
		}
		.side_text:hover{
			background-color: #59BDDE;
		}
		#write{
			width:800px;
			margin-left: auto;
			margin-right: auto;
		}
		#textarea{
			display: block;
			margin-left: auto;
			margin-right: auto;
			width:600px;
			height:100px;
			resize:none;
			margin-bottom: 10px;
		}
		#textarea:focus{
			outline:none;
		}
		#write label{
			margin-left:110px;
		}
		#button_post{
			padding-left:15px;
			padding-right:15px;
			padding-top: 10px;
			padding-bottom: 10px;
			color:white;
			margin-left: 200px;
			border: 1px solid white;
			background-color: #79D4F2;
			border-radius: 5px;
			transition: background-color 300ms;
		}
		#button_post:focus{
			outline:none;
		}
		#button_post:hover{
			background-color: #59BDDE;
			cursor:pointer;
		}
		#write_post{
			padding-bottom: 50px;
		}
		#username_name{
			margin-left: 150px;
			display: block;
			margin-top:-30px;
			text-decoration: none;
			font-weight: bold;
			color: #79D4F2;
			width:300px;
		}
		#username_name:hover{
			text-decoration: underline;
		}
		.commenter_name{
			margin-top: -25px;
			margin-left: 60px;
			font-size: 14px;
			display: block;
			text-decoration: none;
			font-weight: bold;
			color: #79D4F2;
			width:300px;
		}
		.commenter_name:hover{
			text-decoration: underline;
		}
		.form_comment #text_comment{
			resize: none;
			width:600px;
			height:80px;
			margin-left: 100px;
		}
		#text_comment:focus{
			outline: none;
		}
		#button_comment{
			margin-left: 627px;
			color:white;
			padding:10px;
			border: 2px solid white;
			background-color: #79D4F2;
			border-radius: 10px;
			transition: background-color 300ms;
		}
		#button_comment:hover{
			background-color: #59BDDE;
			cursor:pointer;
		}
		#button_comment:focus{
			outline:none;
		}
		.comment_list{
			margin-top: 10px;
			border: 1px solid #79D4F2;
			width:605px;
			margin-left:100px;
			border-radius: 10px;
		}
		hr{
			margin-bottom: 30px;
			height:0px;
			border:0;
			border-top: 1px solid #79D4F2;
		}
		.link_delete_post{
			font-size: 12px;
			display: block;
			margin-left: 630px;
			margin-top: -33px;
			color: #59BDDE;
			text-decoration: none;
			width:62px;
		}
		.link_delete_post:hover{
			text-decoration: underline;
			cursor: pointer;
		}
		.link_delete_comment{
			font-size: 10px;
			display: block;
			margin-top: -10px;
			margin-left: 481px;
			color: #59BDDE;
			text-decoration: none;
			width:75px;
		}
		.link_delete_comment:hover{
			text-decoration: underline;
			cursor: pointer;
		}
		#block{
			top:0;
			left:0;
			background-color:rgba(255,255,255,0.5);
			width:100%;
			height: 100%;
			position: fixed;
			z-index: 99999999;
			display: none;
		}
	</style>
</head>
<body>
	<div id="block">
		<img src="images/resources/loading.gif" style="display:block; margin:auto; margin-top: 250px; width:100px; height:auto;" onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false">
	</div>
	<div id="wrapper">
		<div id="header">
			<a href="main.php" style="text-decoration:none; margin-left:200px; margin-top:-100px">
				<img src="images/resources/logo_no_background.png" style="width:50px; height:50px;">
				<span style="color:white; font-size:30px; margin-top: 10px; position:absolute; width:100px;">Goblogger</span>
			</a>
			<form method="post" action="search.php"  id="searchform"> 
				<input type="text" name="name" id="field_search" style="height:20px;"> 
				<input type="submit" name="submit" value="Search" style="height:26px;" id="button_search"> 
			</form> 
			<div id="sidebar">
				<?php
					$conn = konek_db();
					$logged_username = $_COOKIE['logged_in'];
					$query = $conn->prepare("select profile_image from member where username=?");
					$query->bind_param("s", $logged_username);
					$result = $query->execute();
					if(!$result)
						die('query gagal');
					$rows = $query->get_result();
					while($row = $rows->fetch_array()){
						$profile_image = $row['profile_image'];
						if($profile_image != null && $profile_image != '')
							echo "<a href=\"profile.php?username=$logged_username\"><img src=\"images/thumbnail/$profile_image\"></a>";
						else
							echo "<a href=\"profile.php?username=$logged_username\"><img src=\"images/resources/default_profile.png\"></a>";
					}
				?>
				<a href="friend.php" class="side_text">Friends</a>
				<a href="logout.php" class="side_text" id="sidetext">Logout</a>
			</div>
		</div>
		<div id="content">
			<div id="write">

				<div id="write_post">
					<textarea name="content" id="textarea" placeholder="How's it going?"></textarea>
					<label>Add image: </label><input type="file" name="image" accept=".jpg, .png, .bmp" id="image">
					<button type="button" name="post" id="button_post" onclick="post()">Post</button>
				</div>

				<script type="text/javascript">
					function post(){
							xhr = new XMLHttpRequest();
							content = document.getElementById("textarea");
							image = document.getElementById("image");
							xhr.onreadystatechange = function(){
								if(xhr.readyState == 4){
									bl = document.getElementById("block");
									bl.style.display = "none";
									if(xhr.status == 200){
										json = JSON.parse(xhr.responseText);
										if((content != null || image.files[0] != null) && json.pesan == "something"){
											var posts = document.getElementById("posts");
											var post = document.createElement("div");
											var link_profile = document.createElement("a");
											var username_name = document.createElement("a");
											var delete_post = document.createElement("a");
											var br = document.createElement("br");
											var br1 = document.createElement("br");
											var br2 = document.createElement("br");
											var br3 = document.createElement("br");
											var br4 = document.createElement("br");
											var br5 = document.createElement("br");
											var br6 = document.createElement("br");
											var post_content = document.createElement("p");
											var date = document.createElement("p");
											var comment = document.createElement("form");
											var comment_area = document.createElement("textarea");
											var comment_button = document.createElement("button");
											var profile_image = document.createElement("img");
											var hr = document.createElement("hr");

											link_profile.href = 'profile.php?username=' + json.username;
											profile_image.src = json.image_shown;
											profile_image.classList.add("image_profile");
											link_profile.appendChild(profile_image);
											link_profile.classList.add("link_profile");

											username_name.href = 'profile.php?username=' + json.username;
											username_name.innerHTML = json.name;
											username_name.id = "username_name";

											var temp = document.createElement("p");
											temp.style.display = "none";
											temp.id = "temp";
											temp.innerHTML = json.id_post;
											temp.style.fontSize = "0px";

											delete_post.onclick = 
											function(){
												temp_value = $(this).parent().find("#temp").text();
												function_delete_post(this, temp_value);
											};
											delete_post.classList.add("link_delete_post");
											delete_post.innerHTML = "Delete post";

											if(json.image != null && json.image != ''){
												var post_image = document.createElement("img");
												post_image.src = "images/post/" + json.image;
												post_image.style.width = "400px";
												post_image.style.marginLeft = "200px";
												post_image.style.marginTop = "10px";
											}

											post_content.innerHTML = json.content_new;
											post_content.style.marginLeft = "150px";
											post_content.style.marginTop = "-2px";
											post_content.style.width = "500px";
											post_content.style.textAlign = "justify";
											post_content.style.wordWrap = "break-word";
											post_content.style.lineHeight = "20px";

											date.innerHTML = json.date;
											date.style.marginLeft = "580px";
											date.style.fontSize = "12px";
											date.style.color = "#D6D6D6";

											comment_area.name = "comment";
											comment_area.id = "text_comment";
											comment_area.placeholder = "Write comment here.";
											comment_button.type = "button";
											comment_button.name = "post_comment";
											comment_button.innerHTML = "Comment";
											comment_button.id = "button_comment";
											comment_button.onclick = 
											function(){
												temp_value = $(this).parent().parent().find("#temp").text();
												function_comment(temp_value, this);
											};
											comment.appendChild(comment_area);
											comment.appendChild(br);
											comment.appendChild(comment_button);
											comment.method = "post";
											comment.action = "comment.php?id_post=" + json.id_post + "&logged_username=" + json.logged_username;
											comment.classList.add("form_comment")

											post.classList.add("post");
											post.classList.add("anim");
											post.appendChild(link_profile);
											post.appendChild(username_name);
											post.appendChild(br1);
											post.appendChild(temp);
											post.appendChild(delete_post);
											post.appendChild(br2);
											if(json.image != null && json.image != ''){
												post.appendChild(post_image);
												post.appendChild(br3);post.appendChild(br4);
											}
											post.appendChild(post_content);
											post.appendChild(date);
											post.appendChild(comment);

											posts.insertBefore(br5, posts.firstChild);
											posts.insertBefore(br6, posts.firstChild);
											posts.insertBefore(post, posts.firstChild);
											posts.insertBefore(hr, posts.firstChild);
										}
									}
								}
								else{
									bl = document.getElementById("block");
									bl.style.display = "block";
								}
							}
							form = new FormData();
							form.append("content", content.value);
							form.append("image", image.files[0]);
							xhr.open("post", "post.php", true);
							xhr.send(form);
							content.value="";
							image.value="";
					}
					function function_delete_post(e, id){
						xhr = new XMLHttpRequest();
						xhr.onreadystatechange = function(){
							if(xhr.readyState == 4){
								bl = document.getElementById("block");
								bl.style.display = "none";
								if(xhr.status == 200){
									json = JSON.parse(xhr.responseText);
									if(json.pesan == "something"){
										e.parentNode.classList.add("anim_out");
										setTimeout(function(){
											remove_post_node(e);
										}, 400);
									}
								}
							}else{
								bl = document.getElementById("block");
								bl.style.display = "block";
							}
						}
						xhr.open("get", "delete_post.php?id_post=" + id, true);
						xhr.send();
					}
					function remove_post_node(e){
						e.parentNode.parentNode.removeChild(e.parentNode.nextSibling.nextSibling);
						e.parentNode.parentNode.removeChild(e.parentNode.nextSibling);
						e.parentNode.parentNode.removeChild(e.parentNode.previousSibling);
						e.parentNode.parentNode.removeChild(e.parentNode);
					}
					function function_comment(id1, e){
						xhr = new XMLHttpRequest();
						xhr.onreadystatechange = function(){
							if(xhr.readyState == 4){
								bl = document.getElementById("block");
								bl.style.display = "none";
								if(xhr.status == 200){
									json = JSON.parse(xhr.responseText);
									if($(e).parent().parent().find(".comment_list").length == 0){
										var comment_list = document.createElement("div");
										var comment_title = document.createElement("p");
										var individual_comment = document.createElement("div");
										var link_commenter = document.createElement("a");
										var image_commenter = document.createElement("img");
										var commenter_name = document.createElement("a");
										var br1_0 = document.createElement('br');
										var date_comment = document.createElement('p');
										var comment_content = document.createElement('p');
										var delete_comment = document.createElement('a');
										var br1_1 = document.createElement('br');
										var br1_2 = document.createElement('br');
										var temp_comment_id = document.createElement('p');

										temp_comment_id.innerHTML = json.id_comment;
										temp_comment_id.style.opacity = '0';
										temp_comment_id.id = "temp_comment";
										temp_comment_id.style.fontSize = '0px';

										link_commenter.href = "profile.php?username=" + json.commenter;
										link_commenter.classList.add("link_commenter");
										image_commenter.src = json.commenter_image;
										image_commenter.classList.add('image_profile_commenter');
										link_commenter.appendChild(image_commenter);

										commenter_name.href = "profile.php?username=" + json.commenter;
										commenter_name.classList.add("commenter_name");
										commenter_name.innerHTML = json.commenter_name;

										date_comment.style.color= '#D6D6D6';
										date_comment.style.fontSize= '10px';
										date_comment.style.marginLeft= '460px';
										date_comment.style.marginTop= '-20px';
										date_comment.innerHTML = json.date_comment;

										comment_content.style.marginLeft = '60px';
										comment_content.style.marginTop = '-5px';
										comment_content.style.width= '500px';
										comment_content.style.textAlign= "justify";
										comment_content.style.wordWrap = "break-word";
										comment_content.style.fontSize= '14px';
										comment_content.innerHTML = json.comment;

										delete_comment.onclick = function(){
											temp_value_comment = $(this).parent().find("#temp_comment").text();
											function_delete_comment(this, temp_value_comment);
										};
										delete_comment.classList.add('link_delete_comment');
										delete_comment.innerHTML ="Delete comment";

										individual_comment.classList.add("comment");
										individual_comment.appendChild(link_commenter);
										individual_comment.appendChild(commenter_name);
										individual_comment.appendChild(br1_0);
										individual_comment.appendChild(date_comment);
										individual_comment.appendChild(comment_content);
										individual_comment.appendChild(delete_comment);
										individual_comment.appendChild(br1_1);
										individual_comment.appendChild(temp_comment_id);

										comment_list.classList.add('comment_list');
										comment_list.classList.add('anim');
										comment_title.innerHTML = "Comments";
										comment_title.style.marginLeft = "20px";
										comment_list.appendChild(comment_title);
										comment_list.appendChild(individual_comment);

										parent = e.parentNode.parentNode;
										last_child = parent.lastChild.previousSibling;
										parent.insertBefore(comment_list, last_child);
										parent.insertBefore(br1_2, last_child);
									}
									else{
										var individual_comment = document.createElement("div");
										var link_commenter = document.createElement("a");
										var image_commenter = document.createElement("img");
										var commenter_name = document.createElement("a");
										var br1_0 = document.createElement('br');
										var date_comment = document.createElement('p');
										var comment_content = document.createElement('p');
										var delete_comment = document.createElement('a');
										var br1_1 = document.createElement('br');
										var temp_comment_id = document.createElement('p');

										temp_comment_id.innerHTML = json.id_comment;
										temp_comment_id.style.opacity = '0';
										temp_comment_id.id = "temp_comment";
										temp_comment_id.style.fontSize = '0px';

										link_commenter.href = "profile.php?username=" + json.commenter;
										link_commenter.classList.add("link_commenter");
										image_commenter.src = json.commenter_image;
										image_commenter.classList.add('image_profile_commenter');
										link_commenter.appendChild(image_commenter);

										commenter_name.href = "profile.php?username=" + json.commenter;
										commenter_name.classList.add("commenter_name");
										commenter_name.innerHTML = json.commenter_name;

										date_comment.style.color= '#D6D6D6';
										date_comment.style.fontSize= '10px';
										date_comment.style.marginLeft= '460px';
										date_comment.style.marginTop= '-20px';
										date_comment.innerHTML = json.date_comment;

										comment_content.style.marginLeft = '60px';
										comment_content.style.marginTop = '-5px';
										comment_content.style.width= '500px';
										comment_content.style.textAlign= "justify";
										comment_content.style.wordWrap = "break-word";
										comment_content.style.fontSize= '14px';
										comment_content.innerHTML = json.comment;

										delete_comment.onclick = function(){
											temp_value_comment = $(this).parent().find("#temp_comment").text();
											function_delete_comment(this, temp_value_comment);
										};
										delete_comment.classList.add('link_delete_comment');
										delete_comment.innerHTML ="Delete comment";

										individual_comment.classList.add("comment");
										individual_comment.classList.add("anim");
										individual_comment.appendChild(link_commenter);
										individual_comment.appendChild(commenter_name);
										individual_comment.appendChild(br1_0);
										individual_comment.appendChild(date_comment);
										individual_comment.appendChild(comment_content);
										individual_comment.appendChild(delete_comment);
										individual_comment.appendChild(br1_1);
										individual_comment.appendChild(temp_comment_id);

										console.log(individual_comment);
										parent = e.parentNode.previousSibling.previousSibling;
										console.log(parent);
										parent.appendChild(individual_comment);
									}

								}
							}else{
								bl = document.getElementById("block");
								bl.style.display = "block";
							}
						}
						content_text = $(e).parent().find("#text_comment").val();
						$(e).parent().find("#text_comment").val('')
						form = new FormData();
						form.append("comment", content_text);
						xhr.open("post", "comment.php?id_post=" + id1 , true);
						xhr.send(form);
					}
					function function_delete_comment(e, id_comment){
						console.log(e.parentNode.parentNode.children.length);
						xhr = new XMLHttpRequest();
						xhr.onreadystatechange = function(){
							if(xhr.readyState == 4){
								bl = document.getElementById("block");
								bl.style.display = "none";
								if(xhr.status == 200){
								console.log(e.parentNode.parentNode.children.length);
									json = JSON.parse(xhr.responseText);
									if(json.pesan == "something"){
										e.parentNode.classList.add("anim_out");
										if(e.parentNode.parentNode.children.length == 2)
											e.parentNode.parentNode.classList.add("anim_out");
										setTimeout(function(){
											remove_comment_node(e);
										}, 400);
									}
								}
							}else{
								bl = document.getElementById("block");
								bl.style.display = "block";
							}
						}
						xhr.open("get", "delete_comment.php?id_comment=" + id_comment, true);
						xhr.send();
					}
					function remove_comment_node(e){
						if(e.parentNode.parentNode.children.length == 2){
							e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
						}else
							e.parentNode.parentNode.removeChild(e.parentNode);
					}
				</script>

				<div id="posts">
					<?php 
						$conn = konek_db();
						$query = $conn->prepare("select post.*, member.name, member.profile_image FROM post left join member ON post.username = member.username where post.username in (select friend.username_friend from friend where friend.username = ?) or post.username = ? order by date desc");
						$query->bind_param("ss", $logged_username, $logged_username);
						$result = $query->execute();
						if(! $result)
							die("Gagal query");
						$rows = $query->get_result();
						while($row = $rows->fetch_array()){
							$id_post = $row['id_post'];
							$username = $row['username'];
							$name = $row['name'];
							$content = $row['content'];
							$image = $row['image'];
							$date = $row['date'];
							$profileimage = $row['profile_image'];
							echo "<hr><div class=\"post\">";
							if($profileimage != null && $profileimage != '')
								echo "<a href=\"profile.php?username=$username\" class=\"link_profile\"><img src=\"images/thumbnail/$profileimage\" class=\"image_profile\"></a>";
							else
								echo "<a href=\"profile.php?username=$username\" class=\"link_profile\"><img src=\"images/resources/default_profile.png\" class=\"image_profile\"></a>";
							echo "<a href=\"profile.php?username=$username\" id=\"username_name\">$name</a><br>";
							if (strcasecmp($username, $logged_username) == 0) {
								echo "<a onclick=\"function_delete_post(this, $id_post)\" class=\"link_delete_post\">Delete post</a>";
							}
							if($image != null && $image != ''){
								echo "<img src=\"images/post/$image\" style=\"width:400px; margin-left:200px; margin-top:10px;\"><br><br>";
							}
							if (strcasecmp($username, $logged_username) == 0)
								echo "<br>";
							$content_new = nl2br($content);
							echo "<p style=\"margin-left:150px; margin-top:-2px; width:500px; text-align:justify; word-wrap:break-word; line-height:20px;\">$content_new</p>";
							echo "<p style=\"margin-left:580px; font-size:12px; color:#D6D6D6;\">$date</p>";

							$querycheck = $conn->prepare("select * from comment where id_post = $id_post");
							$resultcheck = $querycheck->execute();
							if($result){
								$resultcheck1 = $querycheck->get_result();
								if($resultcheck1->num_rows > 0){
									echo "<div class=\"comment_list\">";
									echo "<p style=\"margin-left:20px;\">Comments</p>";
									$query1 = $conn->prepare("select * from comment left join member ON comment.username = member.username where id_post = $id_post order by date asc");
									$result1 = $query1->execute();
									if(! $result1)
										die("Gagal query");
									$rows1 = $query1->get_result();
									while($row1 = $rows1->fetch_array()){
										$id_comment = $row1['id_comment'];
										$commenter = $row1['username'];
										$commenter_name = $row1['name'];
										$comment = $row1['comment'];
										$date_comment = $row1['date'];
										$profileimagecommenter = $row1['profile_image'];
										echo "<div class=\"comment\">";
										if($profileimagecommenter != null && $profileimagecommenter != '')
											echo "<a href=\"profile.php?username=$commenter\" class=\"link_commenter\"><img src=\"images/thumbnail/$profileimagecommenter\" class=\"image_profile_commenter\"></a>";
										else
											echo "<a href=\"profile.php?username=$commenter\" class=\"link_commenter\"><img src=\"images/resources/default_profile.png\" class=\"image_profile_commenter\"></a>";
										echo "<a href=\"profile.php?username=$commenter\" class=\"commenter_name\">$commenter_name</a><br>";
										echo "<p style=\"color:#D6D6D6; font-size:10px; margin-left:460px; margin-top:-20px;\">$date_comment</p>";
										$comment_new = nl2br($comment);
										echo "<p style=\"margin-left:60px; margin-top: -5px; width:500px; text-align:justify; word-wrap:break-word; font-size:14px;\">$comment_new</p>";
										if (strcasecmp($commenter, $logged_username) == 0) {
											echo "<a onclick=\"function_delete_comment(this, $id_comment)\" class=\"link_delete_comment\">Delete comment</a>";
										}
										echo "<br></div>";
									}
									echo "</div><br>";
								}
								echo "<div id=\"form_comment\" class=\"form_comment\">";
								echo "<textarea name=\"comment\" id=\"text_comment\" placeholder=\"Write comment here.\"></textarea><br>";
								echo "<button type=\"button\" name=\"post_comment\" onclick=\"function_comment($id_post, this)\" id=\"button_comment\">Comment</button>";
								echo "</div>";
							}
							echo "</div>";
							echo "<br><br>";
						}
					 ?>
				</div>
			</div>
		</div>
		<div id="footer">
			<p>&copy;2016 <a href="main.php" style="text-decoration:none; color:white;">Goblogger.com</a></p>
		</div>
	</div>
</body>
</html>