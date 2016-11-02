<?php 
	if(isset($_COOKIE["username"])){
		header("Location: home.php");
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="images/resources/logo.png">
	<title>Welcome to Goblogger</title>
	<style type="text/css">
		input:-webkit-autofill {
			-webkit-box-shadow: 0 0 0px 1000px white inset;
		}
		body{
			font-family: arial;
			background-image: url('images/resources/bg.png');
			background-size: 30%;
		}
		#main{
			margin:auto;
		}
		#register{
			width: 450px;
			float:left;
			margin-left: 50px;
		}
		#login{
			width:450px;
			float:right;
			margin-right: 50px;
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
		#button_register, #button_login{
			width:255px;
		}
		#login table{
			padding-top:60px;
		}
		td select{
			height:30px;
			width:254px;
			outline:none;
		}
		.bday{
			width:61px;
		}
		#header{
			margin-left:-8px;
			margin-top:-8px;
			width:100%;
			height:50px;
			background-color: #79D4F2;
			position:fixed;
		}
		#desc{
			text-align: center;
			font-size: 20px;
			padding-top:70px;
		}
		#content{
			margin: auto;
			width:1150px;
			height:600px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: white;
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
	</style>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<a href="main.php" style="text-decoration:none; margin-left:200px; margin-top:-100px">
				<img src="images/resources/logo_no_background.png" style="width:50px; height:50px;">
				<span style="color:white; font-size:30px; margin-top: 10px; position:absolute; width:100px; height:100px;">Goblogger</span>
			</a>
		</div>
		<div id="content">
			<div id="desc">
				<p>Welcome to Goblogger!<br> Find, connect, and share your moments with your friends and family!</p>
			</div>
			<div id="main">
				<div id="register">
					<p style="text-align:center;">Create new account now!</p>
					<form method="post" action="register.php">
						<table>
							<tr>
								<td><label>Username</label></td>
		           				<td><input type="text" name="username"></td>
		           			</tr>	
		           			<tr>
		           				<td><label>Password</label></td>
		           				<td><input type="password" name="password"></td>
		           			</tr>
		           			<tr>
		           				<td><label>Confirm Password</label></td>
		           				<td><input type="password" name="password-confirm"></td>
		           			</tr>
		           			<tr>
		           				<td><label>Name</label></td>
		           				<td><input type="text" name="name"></td>
		           			</tr>
		           			<tr>
		           				<td><label>Gender</label></td>
		           				<td>
		           					<select name="gender">
		           						<option value="m">Male</option>
		           						<option value="f">Female</option>
		           					</select>
		           				</td>
		           			</tr>
		           			<tr>
		           				<td><label>Birthday</label></td>
		           				<td>
		           					<label>D:</label>
		           					<select name="date" class="bday">
		           						<?php 
		           							for($i = 1; $i<=31;$i++){
		           								if($i < 10)
		           									echo "<option value=\"0$i\">0$i</option>";
		           								else
			           								echo "<option value=\"$i\">$i</option>";
		           							}
		           						 ?>
		           					</select>
		           					<label>M:</label>
		           					<select name="month" class="bday">
		           						<?php 
		           							for($i=1;$i<=12;$i++){
		           								if($i < 10)
		           									echo "<option value=\"0$i\">0$i</option>";
		           								else
			           								echo "<option value=\"$i\">$i</option>";
		           							}
		           						 ?>
		           					</select>
		           					<label>Y:</label>
		           					<select name="year" class="bday">
		           						<?php 
		           							for($i=date("Y");$i>=1900; $i--){
		           								echo "<option value=\"$i\">$i</option>";
		           							}
		           						 ?>
		           					</select>
		           				</td>
		           			</tr>
		           			<tr>
		           				<td><label>Email</label></td>
		           				<td><input type="text" name="email"></td>
		           			</tr>
		           			<tr>
		           				<td colspan="2"><div style="text-align:right;"><input type="submit" value="register" id="button_register" class="button"></div></td>
		           			</tr>
		           		</table>
		           	</form>
				</div>
				<p style="float:left; margin-left:45px; margin-top:130px">Or,</p>
				<div id="login">
					<p style="text-align:center;">Login to an existing account!</p>
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
	           				<tr>
	           					<td colspan="2"><div style="text-align:right;"><input type="submit" value="Login" id="button_login" class="button"></div></td>
	           				</tr>
	           			</table>
	           		</form>
				</div>
			</div>
		</div>
		<div id="footer">
			<p>&copy;2016 <a href="home_button.php" style="text-decoration:none; color:white;">Goblogger.com</a></p>
		</div>
	</div>
</body>
</html>