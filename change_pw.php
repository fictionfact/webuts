<?php 
	session_start();
	require_once "db.php";
	$conn = konek_db();
	if(!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){
		$old_password = sha1($_POST['old_password']);
		$new_password = sha1($_POST['new_password']);
		$confirm_password = sha1($_POST['confirm_password']);
		$username = $_COOKIE['logged_in'];
		$query = $conn->prepare("select password from member where username=?");
		$query->bind_param("s", $username);
		$result = $query->execute();
		if(!$result)
			die("Proses query gagal");
		$rows = $query->get_result();
		while ($row = $rows->fetch_array()) {
			$password = $row['password'];
		}
		if($old_password == $password){
			if($new_password == $confirm_password){
				$query_update = $conn->prepare("update member set password = ? where username = ?");
				$query_update->bind_param("ss", $new_password, $username);
				$result_update = $query_update->execute();
				if(!$result_update)
					die("Proses query gagal");
				$_SESSION['password_changed'] = true;
				header("Location: change_password.php");
			}else{
				$_SESSION['password_not_match'] = true;
				header("Location: change_password.php");
			}
		}else{
			$_SESSION['wrong_password'] = true;
			header("Location: change_password.php");
		}
	}
	else{
		$_SESSION['not_filled'] = true;
		header("Location: change_password.php");
	}
 ?>