<?php 
	header("Content-Type: application/json; charset: utf-8");
	date_default_timezone_set('Asia/Bangkok');
	require_once 'db.php';
	if(!empty($_POST['content']) || isset($_FILES['image'])) {
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

		$logged_username = $_COOKIE["logged_in"];
		$query = $conn->prepare("select post.*, member.name, member.profile_image FROM post left join member ON post.username = member.username where post.username in (select friend.username_friend from friend where friend.username = ?) or post.username = ? order by date asc");
		$query->bind_param("ss", $logged_username, $logged_username);
		$result = $query->execute();
		if(! $result)
			die("Gagal query");
		$rows = $query->get_result();
		while($row = $rows->fetch_array()){
			$id_post = $row['id_post'];
			$username = $row['username'];
			$name = $row['name'];
			$content = $row['content'];
			$image = $row['image'];
			$date = $row['date'];
			$profileimage = $row['profile_image'];
		}
		if($profileimage == null || $profileimage == '')
			$image_shown = "images/resources/default_profile.png";
		else
			$image_shown = "images/thumbnail/$profileimage";
		$content_new = nl2br($content);

		echo json_encode(array("id_post"=>$id_post, "username"=>$username, "name"=>$name, "content"=>$content, "image"=>$image, "date"=>$date, "image_shown"=>$image_shown, "content_new"=>$content_new, "logged_username"=>$logged_username, "pesan"=>"something"));
	}
	else
		echo json_encode(array("pesan"=>"nothing"));
 ?>