<?php 
	session_start();
	if(isset($_COOKIE["logged_in"])){
		header("Location: home.php");
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="images/resources/logo.png">
	<title>Goblogger</title>
	<style type="text/css">
		input:-webkit-autofill {
			-webkit-box-shadow: 0 0 0px 1000px white inset;
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
		}
		#footer{
			background-color: #79D4F2;
			height:50px;
			width:100%;
			margin-left: -8px;
			position:absolute;
			padding-bottom: 4px;
		}
		#footer p{
			text-align: center;
			margin-top:20px;
			color:white;
		}
		.button{
			margin-top:5px;
			height:40px;
			background-color: #79D4F2;
			border:none;
			color:white;
			border-radius: 20px;
			transition: background-color 300ms;
		}
		.button:hover{
			background-color: #59BDDE;
		}
		.button:focus{
			outline:0;
			border:none;
		}
		#content{
			margin: auto;
			width:1150px;
			min-height:600px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: white;
		}
		#login{
			position: absolute;
			width:450px;
			margin-top: 170px;
			margin-left: 340px;
		}
		#login table{
			padding-top:60px;
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
		#side_text{
			text-decoration: none;
			color:white;
			position: absolute;
			margin-left: 900px;
			margin-top: 10px;
			border: 2px solid white;
			padding:5px;
			border-radius: 10px;
			transition: background-color 300ms;
		}
		#side_text:hover{
			background-color: #59BDDE;
		}
	</style>
</head>
<body>
	<div id='wrapper'>
		<div id='header'>
			<a href="main.php" style="text-decoration:none; margin-left:200px; margin-top:-100px">
				<img src="images/resources/logo_no_background.png" style="width:50px; height:50px;">
				<span style="color:white; font-size:30px; margin-top: 10px; position:absolute; width:100px; height:100px;">Goblogger</span>
			</a>
			<a href="main.php" id="side_text">Register</a>
		</div>
		<div id='content'>
			<?php
				if (isset($_SESSION['registered'])) {
					echo "<p style='text-align: center; margin-top:100px; position: absolute;margin-left: 435px;'>Registration success!<br><br>Login to your newly created account!</p>";
					unset($_SESSION['registered']);
				}
				else{
					echo "<p style='text-align: center; margin-top:150px; position: absolute;margin-left: 490px;'>Login to your account!</p>";
				}
			?>
			<div id="login">
					<form method="post" action="login.php">
						<table>
							<tr>
								<td><label>Username</label></td>
	           					<td><input type="text" name="username"></td>
	           				</tr>
	           				<tr>
	           					<td><label>Password</label></td>
	           					<td><input type="password" name="password"></td>
	           				</tr>
	           				<?php 
		           				if(isset($_SESSION['login'])){
		           					echo "<tr>";
		           					echo "<td colspan=2><label style=\"color:red; margin-left:155px;\">Username/Password is wrong</label></td>";
		           					echo "</tr>";
		           					unset($_SESSION['login']);
		           				}
		           				else if(isset($_SESSION['login_not_filled'])){
		           					echo "<td colspan=2><label style=\"color:red; margin-left:155px;\">Please fill all the data</label></td>";
		           				}
		           			 ?>
	           				<tr>
	           					<td colspan="2"><div style="text-align:right;"><input type="submit" value="Login" id="button_login" class="button"></div></td>
	           				</tr>
	           			</table>
	           		</form>
				</div>
		</div>
		<div id='footer'>
			<p>&copy;2016 <a href="main.php" style="text-decoration:none; color:white;">Goblogger.com</a></p>
		</div>
	</div>
</body>
</html>