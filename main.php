<!DOCTYPE html>
<html>
<head>
	<title>Tugas PHP</title>
	<style type="text/css">
		#main{
			width:900px;
			margin:auto;
		}
		#register{
			width: 300px;
			float:left;
		}
		#login{
			width:300px;
			float:right;
		}
		td{
			width:150px;
			height: 25px;
		}
		td input{
			height:20px;
			width:150px;
		}
		#button_register, #button_login{
			width:155px;
		}
		#login table{
			padding-top:40px;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			
		</div>
		<div id="main">
			<div id="register">
				<p style="text-align:center;">Create new account now!</p>
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
           				<td><label>Birthday</label></td>
           				<td><input type="date" name="birthday"></td>
           			</tr>
           			<tr>
           				<td><label>Email</label></td>
           				<td><input type="text" name="email"></td>
           			</tr>
           			<tr>
           				<td colspan="2"><div style="text-align:right;"><input type="submit" value="Register" id="button_register"></div></td>
           			</tr>
           		</table>
			</div>
			<p style="float:left; margin-left:150px; margin-top:100px">Or,</p>
			<div id="login">
				<p style="text-align:center;">Login to an existing account!</p>
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
           				<td colspan="2"><div style="text-align:right;"><input type="submit" value="Login" id="button_login"></div></td>
           			</tr>
           		</table>
			</div>
		</div>
		<div id="footer">
			
		</div>
	</div>
</body>
</html>