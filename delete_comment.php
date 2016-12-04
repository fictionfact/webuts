<?php 
	require_once "db.php";
	$conn = konek_db();
	if(isset($_GET['id_comment'])){
		$id_comment = $_GET['id_comment'];
		$query = $conn->prepare("delete from comment where id_comment = $id_comment");
		$result = $query->execute();
		if(!$result)
			die("Proses query gagal");
		echo json_encode(array("pesan"=>"something"));
	}
?>