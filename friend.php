<?php 
	require_once "db.php";
	if(empty($_COOKIE['logged_in'])){
		header("Location: main.php");
	}
	setcookie("logged_in", $_COOKIE['logged_in'], time()+(86400*7));
 ?>
 <!DOCTYPE html>
<html>
<head>
	<title>Friend List - Goblogger</title>
	<link rel="icon" href="images/resources/logo.png">
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
		#content{
			margin: auto;
			padding-top: 80px;
			width:950px;
			min-height:600px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: white;
			padding-bottom: 30px;
			height:600px;
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
		.picture_found{
			width:70px;
			height:70px;
			background-color: #79D4F2;
			border: 2px solid white;
			border-radius: 40px;
		}
		.name_found{
			text-decoration: none;
			font-size: 20px;
			color: #79D4F2;
			display: block;
			width:300px;
			margin-top: -51px;
			margin-left: 300px;
		}
		.name_found:hover{
			text-decoration: underline;
		}
		.link_found{
			margin-left: 200px;
		}
		.add_friend{
			display: block;
			margin-top: -70px;
			margin-left: 700px;
			width:75px;
			text-decoration: none;
			font-size: 12px;
			color: #59BDDE;
		}
		.add_friend:hover{
			text-decoration: underline;
		}
		.delete_friend{
			display: block;
			margin-top: -70px;
			margin-left: 677px;
			width:100px;
			text-decoration: none;
			font-size: 12px;
			color: #59BDDE;
		}
		.delete_friend:hover{
			text-decoration: underline;
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
	</div>
	<div id="content">
		<?php 
				$username_logged = $_COOKIE['logged_in'];
				$conn = konek_db();
				$query = $conn->prepare("select * from friend where username=?");
				$query->bind_param("s", $username_logged);
				$result = $query->execute();
				$res = $query->get_result();
				if($res->num_rows == 0){
					echo "<p style=\"margin-left:100px;\">You have not added any friend yet.</p>";
				}
				else{
					while ($row = $res->fetch_array()) {
						$friend = $row['username_friend'];
						$query_friend = $conn->prepare("select * from member where username=?");
						$query_friend->bind_param("s", $friend);
						$result_friend = $query_friend->execute();
						$res_friend = $query_friend->get_result();
						while ($row_friend = $res_friend->fetch_array()) {
							$name_friend = $row_friend['name'];
							$profile_image = $row_friend['profile_image'];
						}
						if($profile_image != null && $profile_image != '')
							echo "<a href=\"profile.php?username=$friend\" class=\"link_found\"><img src=\"images/thumbnail/$profile_image\" class=\"picture_found\"></a>";
						else
							echo "<a href=\"profile.php?username=$friend\" class=\"link_found\"><img src=\"images/resources/default_profile.png\" class=\"picture_found\"></a>";
						echo "<a href=\"profile.php?username=$friend\" class=\"name_found\">$name_friend</a><br><br><br>";
						echo "<a href=\"remove_friend.php?friend=$friend\" class=\"delete_friend\">Remove friend</a><br><br><br>";
					}
				}
			 ?>
	</div>
	<div id="footer">
		<p>&copy;2016 <a href="main.php" style="text-decoration:none; color:white;">Goblogger.com</a></p>
	</div>
</body>
</html>