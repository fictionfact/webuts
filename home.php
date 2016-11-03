<?php 
	require_once "db.php";
	session_start();
	if(empty($_COOKIE['logged_in'])){
		header("Location: main.php");
	}
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
			border: 2px solid #79D4F2;
			border-radius: 25px;
			vertical-align: top;
			background-color: #79D4F2;
			margin-left: 100px;
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
			position: relative;
			margin-left: 5px;
			top: 13px;
			vertical-align: top;
			text-decoration: none;
			font-weight: bold;
			color: #79D4F2;
		}
		#username_name:hover{
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<a href="main.php" style="text-decoration:none; margin-left:200px; margin-top:-100px">
				<img src="images/resources/logo_no_background.png" style="width:50px; height:50px;">
				<span style="color:white; font-size:30px; margin-top: 10px; position:absolute; width:100px; height:100px;">Goblogger</span>
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
					<label>Add image: </label><input type="file" name="image" accept=".jpg, .png, .bmp, .gif">
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
							$username = $row['username'];
							$content = $row['content'];
							$image = $row['image'];
							$date = $row['date'];
							$profileimage = $row['profile_image'];
							if($profileimage != null && $profileimage != '')
								echo "<a href=\"profile.php?username=$logged_username\"><img src=\"images/thumbnail/$profileimage\" class=\"image_profile\"></a>";
							else
								echo "<a href=\"profile.php?username=$logged_username\"><img src=\"images/resources/default_profile.png\" class=\"image_profile\"></a>";
							echo "<a href=\"profile.php?username=$username\" id=\"username_name\">$username</a><br>";
							if($image != null && $image != ''){
								echo "<img src=\"images/post/$image\" style=\"width:400px; margin-left:200px; margin-top:10px;\">";
							}
							echo "<p style=\"margin-left:150px; width:550px; text-align:justify;\">$content</p>";
							echo "<p style=\"text-align:right; position:relative; right:100px; font-size:12px; color:#D6D6D6;\">$date</p>";
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