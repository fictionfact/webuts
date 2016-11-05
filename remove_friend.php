<?php 
	require_once "db.php";
	$conn = konek_db();
	if(empty($_COOKIE['logged_in'])){
		header("Location: main.php");
	}
	if(isset($_GET['friend'])){
		$username_friend = $_GET['friend'];
		$username = $_COOKIE['logged_in'];
		$query = $conn->prepare("delete from friend where username=? and username_friend=?");
		$query->bind_param("ss", $username, $username_friend);
		$result = $query->execute();
		$query = $conn->prepare("delete from friend where username=? and username_friend=?");
		$query->bind_param("ss", $username_friend, $username);
		$result = $query->execute();
		header("Location: friend.php");
	}
 ?>