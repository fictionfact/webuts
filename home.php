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
	<link rel="icon" href="images/resources/logo.png">
	<title>Goblogger</title>
	<style type="text/css">
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
		}
		#button_post:focus{
			outline:none;
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
	</style>
</head>
<body>
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
				<form method="post" action="post.php" enctype="multipart/form-data" id="write_post">
					<textarea name="content" id="textarea" placeholder="How's it going?"></textarea>
					<label>Add image: </label><input type="file" name="image" accept=".jpg, .png, .bmp">
					<input type="submit" name="post" value="Post" id="button_post">
				</form>
				<div id="posts">
					<?php 
						$conn = konek_db();
						$query = $conn->prepare("select * from post left join member ON post.username = member.username order by date desc");
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
							echo "<hr><div id=\"post\">";
							if($profileimage != null && $profileimage != '')
								echo "<a href=\"profile.php?username=$username\" class=\"link_profile\"><img src=\"images/thumbnail/$profileimage\" class=\"image_profile\"></a>";
							else
								echo "<a href=\"profile.php?username=$username\" class=\"link_profile\"><img src=\"images/resources/default_profile.png\" class=\"image_profile\"></a>";
							echo "<a href=\"profile.php?username=$username\" id=\"username_name\">$name</a><br>";
							if($image != null && $image != ''){
								echo "<img src=\"images/post/$image\" style=\"width:400px; margin-left:200px; margin-top:10px;\"><br><br>";
							}
							$content_new = nl2br($content);
							echo "<p style=\"margin-left:150px; margin-top:-2px; width:500px; text-align:justify; word-wrap:break-word; line-height:20px;\">$content_new</p>";
							echo "<p style=\"margin-left:580px; font-size:12px; color:#D6D6D6;\">$date</p>";
							echo "<form method=\"post\" action=\"comment.php?id_post=$id_post&logged_username=$logged_username\" class=\"form_comment\">";
							echo "<textarea name=\"comment\" id=\"text_comment\" placeholder=\"Write comment here.\"></textarea><br>";
							echo "<input type=\"submit\" name=\"post_comment\" value=\"Comment\" id=\"button_comment\">";
							echo "</form>";

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
										$commenter = $row1['username'];
										$commenter_name = $row1['name'];
										$comment = $row1['comment'];
										$date_comment = $row1['date'];
										$profileimagecommenter = $row1['profile_image'];
										if($profileimagecommenter != null && $profileimagecommenter != '')
											echo "<a href=\"profile.php?username=$commenter\" class=\"link_commenter\"><img src=\"images/thumbnail/$profileimagecommenter\" class=\"image_profile_commenter\"></a>";
										else
											echo "<a href=\"profile.php?username=$commenter\" class=\"link_commenter\"><img src=\"images/resources/default_profile.png\" class=\"image_profile_commenter\"></a>";
										echo "<a href=\"profile.php?username=$commenter\" class=\"commenter_name\">$commenter_name</a><br>";
										echo "<p style=\"color:#D6D6D6; font-size:10px; margin-left:460px; margin-top:-20px;\">$date_comment</p>";
										$comment_new = nl2br($comment);
										echo "<p style=\"margin-left:60px; margin-top: -5px; width:500px; text-align:justify; word-wrap:break-word; font-size:14px;\">$comment_new</p>";
										echo "<br>";
									}
									echo "</div>";
								}
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