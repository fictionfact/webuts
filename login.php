<?php 
	session_start();
	require_once "db.php";
	if(!empty($_POST['username']) && !empty($_POST['password'])){
		$conn = konek_db();
		$username = $_POST['username'];
		$password = sha1($_POST['password']);

		$query = $conn->prepare("select * from member where username=? and password=?");
		$query->bind_param("ss", $username, $password);
		$result = $query->execute();

		if($result){
			$res = $query->get_result();
			if($res->num_rows == 1){
				$_SESSION['username'] = $username;
				header("Location: home.php");
				setcookie("username", $username, time()+(86400*7));
			}
			else{
				header("Location: main.php");
			}
		} else{
			header("Location: main.php");
		}
	}
 ?>