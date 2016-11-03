<?php 
	session_start();
	require_once "db.php";
	if(isset($_COOKIE['logged_in'])){
		header("Location: already_login.php");
	}
	else if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password-confirm']) && !empty($_POST['name']) && !empty($_POST['gender']) && !empty($_POST['date']) && !empty($_POST['month']) && !empty($_POST['year']) && !empty($_POST['email'])) {
		$conn = konek_db();
		$username = $_POST['username'];
		$password = sha1($_POST['password']);
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$date = $_POST['date'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		$birthday = $year."-".$month."-".$date;
		$email = $_POST['email'];

		$query = $conn->prepare("select * from member where username=?");
		$query->bind_param("s", $username);
		$result = $query->execute();
		$res = $query->get_result();
		if($res->num_rows == 1){
			$_SESSION['username']=false;
		}

		if($_POST['password'] != $_POST['password-confirm']){
			$_SESSION['password'] = false;
		}

		$query = $conn->prepare("select * from member where email=?");
		$query->bind_param("s", $email);
		$result = $query->execute();
		$res = $query->get_result();
		if($res->num_rows == 1){
			$_SESSION['email']=false;
		}

		if((($month=='01' || $month=='03' || $month=='05' || $month=='07' || $month=='08' || $month=='10' || $month=='12') && $date>'31') || (($month=='04' || $month=='06' || $month=='09' || $month=='11') && $date>'30') || ($month=='02' && $date>'29'))	{
			$_SESSION['date']=false;
		}

		if($_POST['password'] == $_POST['password-confirm']){
			$query = $conn->prepare("insert into member(username, password, name, birthday, email, gender) values(?, ?, ?, ?, ?, ?)");
			$query->bind_param("ssssss", $username, $password, $name, $birthday, $email, $gender);
			$result = $query->execute();

			if(!$result){
				header("Location: main.php");
			}
			else{
				$_SESSION['registered'] = true;
				header("Location: login_page.php");
			}
		}else{
			header("Location: main.php");
		}
	}
	else{
		$_SESSION['not_filled'] = true;
		header('Location: main.php');
	}
 ?>