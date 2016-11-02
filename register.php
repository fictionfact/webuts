<?php 
	require_once "db.php";
	if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password-confirm']) && !empty($_POST['name']) && !empty($_POST['gender']) && !empty($_POST['date']) && !empty($_POST['month']) && !empty($_POST['year']) && !empty($_POST['email'])) {
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
		$color = "#79D4F2";

		$query = $conn->prepare("insert into member(username, password, name, birthday, email, gender, color) values(?, ?, ?, ?, ?, ?, ?)");
		$query->bind_param("sssssss", $username, $password, $name, $birthday, $email, $gender, $color);
		$result = $query->execute();

		if(!$result)
			die("BRUH");

		setcookie("username", $username, time()+ (86400*7));

		header("Location: main.php");
	}
	else
		die("data tidak benar");
 ?>