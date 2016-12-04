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
	<title>Change Password - Goblogger</title>
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
		#content{
			margin: auto;
			padding-top: 80px;
			width:950px;
			min-height: 600px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: white;
			padding-bottom: 30px;
		}
		td{
			width:150px;
			height: 50px;
		}
		td input{
			height:30px;
			width:250px;
			outline:none;
		}
		table{
			margin-left:auto;
			margin-right:auto;
			margin-top: 120px;
		}
		#button{
			margin-top:5px;
			height:40px;
			background-color: #79D4F2;
			border:none;
			color:white;
			border-radius: 20px;
			transition: background-color 300ms;
		}
		#button:hover{
			background-color: #59BDDE;
		}
		#button:focus{
			outline:0;
		}
		.status{
			position: absolute;
			margin-top: 80px;
			color:red;
		}
		.status_changed{
			position: absolute;
			margin-top: 80px;
			color:#59BDDE;
		}
		#back_button{
			color: #79D4F2;
			text-decoration: none;
			margin-left:273px;
		}
		#back_button:hover{
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
				if(isset($_SESSION['password_changed'])) {
					echo "<label class=\"status_changed\" style=\"margin-left: 350px;\">Password changed successfully!</label>";
					unset($_SESSION['password_changed']);
				}
				else if(isset($_SESSION['wrong_password'])){
					echo "<label class=\"status\" style=\"margin-left:400px;\">Your password is wrong!</label>";
					unset($_SESSION['wrong_password']);
				}
				else if(isset($_SESSION['password_not_match'])){
					echo "<label class=\"status\" style=\"margin-left:380px;\">New passwords don't match!</label>";
					unset($_SESSION['password_not_match']);
				}else if(isset($_SESSION['not_filled'])){
					echo "<label class=\"status\" style=\"margin-left:400px;\">Please fill all the form!</label>";
					unset($_SESSION['not_filled']);
				}
			 ?>
			<form method="post" action="change_pw.php">
				<table>
					<tr>
						<td>Old Password</td>
						<td><input type="password" name="old_password"></td>
					</tr>
					<tr>
						<td>New Password</td>
						<td><input type="password" name="new_password"></td>
					</tr>
					<tr>
						<td>Confirm Password</td>
						<td><input type="password" name="confirm_password"></td>
					</tr>
					<tr>
						<td colspan="2"><div style="text-align:right;"><input type="submit" name="submit_pw" value="Change Password" id="button"></div></td>
					</tr>
				</table>
				<a href="edit_profile.php" id="back_button">Back</a>
			</form>
		</div>
		<div id="footer">
			<p>&copy;2016 <a href="main.php" style="text-decoration:none; color:white;">Goblogger.com</a></p>
		</div>
	</div>
</body>
</html>