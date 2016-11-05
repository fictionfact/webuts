<?php 
	require_once "db.php";
	$conn = konek_db();
	if(isset($_GET['username'])){
		$username = $_GET['username'];
		$query = $conn->prepare("update member set profile_image='' where username=?");
		$query->bind_param("s", $username);
		$result = $query->execute();
		if (!$result) {
			die("Proses query gagal");
		}
		$image = $username . ".jpg";
		unlink("images/profile/$image");
		unlink("images/thumbnail/$image");
		header("Location: edit_profile.php");
	}
 ?>