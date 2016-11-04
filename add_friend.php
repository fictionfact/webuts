<?php 
	require_once "db.php";
	$conn = konek_db();
	if (isset($_GET['username']) && isset($_GET['friend'])) {
		$username = $_GET['username'];
		$friend = $_GET['friend'];
		$query = $conn->prepare("insert into friend values(?, ?)");
		$query->bind_param("ss", $username, $friend);
		$result = $query->execute();
		if (! $result)
			die("<p>Proses query gagal.</p>");
		$query = $conn->prepare("insert into friend values(?, ?)");
		$query->bind_param("ss", $friend, $username);
		$result = $query->execute();
		if (! $result)
			die("<p>Proses query gagal.</p>");
		header("Location: home.php");
	}
?>