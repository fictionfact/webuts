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
	<title>Profile - Goblogger</title>
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
			min-height:600px;
			width:950px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: white;
			padding-bottom: 30px;
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
		#profile_image_visited{
			width: 200px;
			margin-left: auto;
			margin-right: auto;
			display: block;
		}
		table{
			margin-left:auto;
			margin-right: auto;
			margin-top: 50px;
			padding-top: 50px;
			padding-bottom: 50px;
			padding-left: 100px;
			padding-right: 100px;
			border: 2px solid #79D4F2;
			border-radius: 30px;
		}
		td{
			width:200px;
			height:30px;
		}
		#edit_profile{
			text-decoration: none;
			margin-left: 650px;
			margin-top: -30px;
			display: block;
			color: #59BDDE;
		}
		#edit_profile:hover{
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
		<div id="content">
			<?php 
				if(isset($_GET['username'])){
					$username_visited = $_GET['username'];
				}else{
					$username_visited = $_COOKIE['logged_in'];
				}
				$conn = konek_db();
				$query = $conn->prepare("select * from member where username=?");
				$query->bind_param("s", $username_visited);
				$result = $query->execute();
				$rows = $query->get_result();
				while($row = $rows->fetch_array()){
					$name = $row['name'];
					$birthday = $row['birthday'];
					$gender = $row['gender'];
					$location = $row['location'];
					$occupation = $row['occupation'];
					$hobby = $row['hobby'];
					$profile_image_visited = $row['profile_image'];
				}
				if($profile_image_visited != null && $profile_image_visited != "")
					echo "<a href=\"images/profile/$profile_image_visited\"><img src=\"images/profile/$profile_image_visited\" id=\"profile_image_visited\"></a>";
				else
					echo "<img src=\"images/resources/default_profile.png\" id=\"profile_image_visited\" style=\"background-color:#79D4F2;\">";
			?>
			<table>
				<tr>
					<td>Name</td>
					<td><?php echo $name; ?></td>
				</tr>
				<tr>
					<td>Gender</td>
					<td>
						<?php 
							if($gender == "m")
								echo "Male";
							else
								echo "Female";
						 ?>
					</td>
				</tr>
				<tr>
					<td>Birthday</td>
					<td><?php echo $birthday; ?></td>
				</tr>
				<tr>
					<td>Location</td>
					<td>
						<?php 
							if($location != "" && $location != null)
								echo $location;
							else
								echo "-";
						 ?>
					</td>
				</tr>
				<tr>
					<td>Occupation</td>
					<td>
						<?php 
							if($occupation != "" && $occupation != null)
								echo $occupation;
							else
								echo "-";
						 ?>
					</td>
				</tr>
				<tr>
					<td>Hobby</td>
					<td>
						<?php 
							if($hobby != "" && $hobby != null)
								echo $hobby;
							else
								echo "-";
						 ?>
					</td>
				</tr>
			</table>
			<?php 
				if ($username_visited == $_COOKIE['logged_in']) {
					echo "<a href=\"edit_profile.php\" id=\"edit_profile\">Edit profile</a>";
				}
				else{	
					$query_friend = $conn->prepare("select * from friend where username=? and username_friend=?");
					$query_friend->bind_param("ss", $logged_username, $username_visited);
					$result_friend = $query_friend->execute();
					$rows_friend = $query_friend->get_result();
					if($rows_friend->num_rows == 1){
						echo "<a href=\"remove_friend.php?friend=$username_visited\" id=\"edit_profile\">Remove friend</a>";
					}
					else
						echo "<a href=\"add_friend.php?friend=$username_visited\" id=\"edit_profile\">Add friend</a>";
				}
			 ?>
		</div>
		<div id="footer">
			<p>&copy;2016 <a href="main.php" style="text-decoration:none; color:white;">Goblogger.com</a></p>
		</div>
	</div>
</body>
</html>