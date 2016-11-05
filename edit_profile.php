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
	<title>Edit Profile</title>
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
			height: 600px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: white;
			padding-bottom: 30px;
		}
		td{
			width:150px;
			height: 30px;
		}
		td input{
			height:30px;
			width:250px;
			outline:none;
		}
		td select{
			height:30px;
			width:254px;
			outline:none;
		}
		table{
			margin-left:auto;
			margin-right: auto;
		}
		#image_edit{
			display: block;
			margin-left: auto;
			margin-right: auto;
			width:200px;
			background-color: #79D4F2;
		}
		#button_submit_edit{
			margin-top:5px;
			height:40px;
			background-color: #79D4F2;
			border:none;
			color:white;
			border-radius: 20px;
			transition: background-color 300ms;
		}
		#button_submit_edit:hover{
			background-color: #59BDDE;
		}
		#button_submit_edit:focus{
			outline:0;
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
				$query = $conn->prepare("select * from member where username=?");
				$query->bind_param("s", $logged_username);
				$result = $query->execute();
				if(!$result)
					die('query gagal');
				$rows = $query->get_result();
				while($row = $rows->fetch_array()){
					$name = $row['name'];
					$gender = $row['gender'];
					$location = $row['location'];
					$occupation = $row['occupation'];
					$hobby = $row['hobby'];
					$profile_image_edit = $row['profile_image'];
				}
				if($profile_image != null && $profile_image != '')
					echo "<img src=\"images/profile/$profile_image_edit\" id=\"image_edit\">";
				else
					echo "<img src=\"images/resources/default_profile.png\" id=\"image_edit\">";
				echo "<br>";
			?>
			<form method="post" action="edit.php" enctype="multipart/form-data">
				<label style="margin-left:325px;">Change image: </label><input type="file" name="image" accept=".jpg"><br><br>
				<?php
					if(isset($_SESSION['updated'])){
						echo "<p style=\"text-align:center; color:#59BDDE\">Profile updated successfully!</p>";
						unset($_SESSION['updated']);
					}
				?>
				<table>
					<tr>
						<td>Name</td>
						<td>
							<input type="text" name="name" value="<?php echo $name ?>">
						</td>
					</tr>
					<tr>
						<td>Gender</td>
						<td>
							<select name="gender">
								<option value="m" <?php if($gender=='m'){echo "selected=\"selected\"";} ?>>Male</option>
								<option value="f" <?php if($gender=='f'){echo "selected=\"selected\"";} ?>>Female</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Location</td>
						<td>
							<input type="text" name="location" value="<?php echo $location ?>">
						</td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td>
							<input type="text" name="occupation" value="<?php echo $occupation ?>">
						</td>
					</tr>
					<tr>
						<td>Hobby</td>
						<td>
							<input type="text" name="hobby" value="<?php echo $hobby ?>">
						</td>
					</tr>
					<tr>
						<td colspan="2"><div style="text-align:right;"><input type="submit" name="submit_edit" value="Edit Profile" id="button_submit_edit"></div></td>
					</tr>
				</table>
			</form>
		</div>
		<div id="footer">
			<p>&copy;2016 <a href="main.php" style="text-decoration:none; color:white;">Goblogger.com</a></p>
		</div>
	</div>
</body>
</html>