<?php 
	require_once "db.php";
	$conn = konek_db();
	if(isset($_GET['id_post'])){
		$id_post = $_GET['id_post'];
		$query = $conn->prepare("select image from post where id_post = ?");
		$query->bind_param("s", $id_post);
		$result = $query->execute();
		if(!$result)
			die("Proses query gagal 1");
		$rows = $query->get_result();
		while($row = $rows->fetch_array()){
			$image = $row['image'];
		}
		$query = $conn->prepare("delete from post where id_post = ?");
		$query->bind_param("s", $id_post);
		$result = $query->execute();
		if(!$result)
			die("Proses query gagal 1");
		$query = $conn->prepare("delete from comment where id_post = ?");
		$query->bind_param("s", $id_post);
		$result = $query->execute();
		if(!$result)
			die("Proses query gagal 2");
		unlink("images/post/$image");
		header("Location: main.php");
	}
?>