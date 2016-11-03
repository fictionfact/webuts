<?php 
	require_once 'db.php';
	if(!empty($_POST['content'])) {
		$content = $_POST['content'];
		$conn = konek_db();
		$query = $conn->prepare("SHOW TABLE STATUS WHERE `Name` = 'post'");
		$result = $query->execute();
		if(! $result)
			die("Gagal query");
		$rows = $query->get_result();
		while($row = $rows->fetch_array()){
			$id = $row['Auto_increment'];
		}
		$file_gambar = '';
		if (isset($_FILES['image'])) {
			if ($_FILES['image']['error'] == 0) {
				$image=$_FILES['image'];

				$extension = new SplFileInfo($image['name']);
				$extension = $extension->getExtension();
				$file_gambar = $id . "." . $extension;
				copy($image['tmp_name'], 'images/post/' . $file_gambar);
			}
		}
		$date = date("Y-m-d G:i:s");
		$username = $_COOKIE['logged_in'];

		$query = $conn->prepare("insert into post(username, content, image, date) values(?, ?, ?, ?)");
		$query->bind_param("ssss", $username, $content, $file_gambar, $date);
		$result = $query->execute();
		if (! $result)
			die("<p>Proses query gagal.</p>");
		header("Location: home.php");
	}
 ?>