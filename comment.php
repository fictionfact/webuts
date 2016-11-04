<?php 
	require_once "db.php";
	if(!empty($_POST['comment'])) {
		$id_post = $_GET['id_post'];
		$username = $_GET['logged_username'];
		$comment = $_POST['comment'];
		$date = date("Y-m-d G:i:s");
		$conn = konek_db();
		$query = $conn->prepare("insert into comment(id_post, username, comment, date) values(?, ?, ?, ?)");
		$query->bind_param("isss", $id_post, $username, $comment, $date);
		$result = $query->execute();
		if (! $result)
			die("<p>Proses query gagal.</p>");
		header("Location: home.php");
	}
 ?>