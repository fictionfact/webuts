<?php 
	session_start();
	require_once "db.php";
	if(isset($_COOKIE['logged_in'])){
		header("Location: already_login.php");
	}
	else if(!empty($_POST['username']) && !empty($_POST['password'])){
		$conn = konek_db();
		$username = $_POST['username'];
		$password = sha1($_POST['password']);

		$query = $conn->prepare("select * from member where username=? and password=?");
		$query->bind_param("ss", $username, $password);
		$result = $query->execute();
		$res = $query->get_result();
		if($res->num_rows != 1){
			$_SESSION['login']=false;
		}

		$query = $conn->prepare("select * from member where username=? and password=?");
		$query->bind_param("ss", $username, $password);
		$result = $query->execute();

		if($result){
			$res = $query->get_result();
			if($res->num_rows == 1){
				header("Location: home.php");
				setcookie("logged_in", $username, time()+(86400*7));
			}
			else{
				header("Location: login_page.php");
			}
		}else{
			header("Location: login_page.php");
		}
	}else{
		$_SESSION['login_not_filled'] = true;
		header("Location: login_page.php");
	}
 ?>