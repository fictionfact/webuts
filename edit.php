<?php 
	session_start();
	require_once "db.php";
	$conn = konek_db();
	if(!empty($_POST['name'])){
		$username = $_COOKIE['logged_in'];
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$location = $_POST['location'];
		$occupation = $_POST['occupation'];
		$hobby = $_POST['hobby'];
		$query1 = $conn->prepare("select profile_image from member where username=?");
		$query1->bind_param("s", $username);
		$result1 = $query1->execute();
		$rows1 = $query1->get_result();
		while($row1 = $rows1->fetch_array()){
			$file_gambar = $row1['profile_image'];
		}

		if (!empty($_FILES['image'])) {
			if ($_FILES['image']['error'] == 0) {
				$file_gambar = '';
				$query_check = $conn->prepare("select profile_image from member where username=?");
				$query_check->bind_param("s", $username);
				$result_check = $query_check->execute();
				if(!$result_check)
					die("Proses check image gagal");
				$rows = $query_check->get_result();
				while($row = $rows->fetch_array()){
					$image_temp = $row['profile_image'];
				}
				$image=$_FILES['image'];
				$file_gambar = $username . ".jpg";
				if($image_temp != null && $image_temp != ""){
					unlink("images/profile/$file_gambar");
					unlink("images/thumbnail/$file_gambar");
				}
				copy($image['tmp_name'], 'images/profile/' . $file_gambar);

				$image_crop = imagecreatefromjpeg("images/profile/$file_gambar");
				$filename = "images/thumbnail/$file_gambar";

				$thumb_width = 300;
				$thumb_height = 300;

				$width = imagesx($image_crop);
				$height = imagesy($image_crop);

				$original_aspect = $width / $height;
				$thumb_aspect = $thumb_width / $thumb_height;

				if ( $original_aspect >= $thumb_aspect )
				{
				   // If image is wider than thumbnail (in aspect ratio sense)
				   $new_height = $thumb_height;
				   $new_width = $width / ($height / $thumb_height);
				}
				else
				{
				   // If the thumbnail is wider than the image
				   $new_width = $thumb_width;
				   $new_height = $height / ($width / $thumb_width);
				}

				$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

				// Resize and crop
				imagecopyresampled($thumb,
                   $image_crop,
                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                   0, 0,
                   $new_width, $new_height,
                   $width, $height);
				imagejpeg($thumb, $filename, 80);

			}
		}

		$query = $conn->prepare("update member set name=?, gender=?, location=?, occupation=?, hobby=?, profile_image=? where username=?");
		$query->bind_param("sssssss", $name, $gender, $location, $occupation, $hobby, $file_gambar, $username);
		$result = $query->execute();
		if(!$result){
			die("Proses query gagal");
		}
		$_SESSION['updated'] = true;
		header("Location: edit_profile.php");
	}
 ?>