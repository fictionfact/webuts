<?php 
	header("Content-Type: application/json; charset: utf-8");
	require_once 'db.php';
	if(isset($_POST['post_number'])){
		$conn = konek_db();
		$logged_username = $_COOKIE['logged_in'];
		$many_item = 10;
		$post_number = $_POST['post_number'];
		$query = $conn->prepare("select post.*, member.name, member.profile_image FROM post left join member ON post.username = member.username where post.username in (select friend.username_friend from friend where friend.username = ?) or post.username = ? order by date desc limit ?,?");
		$query->bind_param("ssii", $logged_username, $logged_username, $post_number , $many_item);
		$result = $query->execute();
		if(! $result)
			die("Gagal query");
		$x = 0;
		$rows = $query->get_result();
		$array_gc = array(array());
		$array_gp = array();
		while($row = $rows->fetch_array()){
			$id_post[$x] = $row['id_post'];
			$username[$x] = $row['username'];
			$name[$x] = $row['name'];
			$content[$x] = $row['content'];
			$image[$x] = $row['image'];
			$date[$x] = $row['date'];
			$profileimage[$x] = $row['profile_image'];

			$query1 = $conn->prepare("select * from comment where id_post = ?");
			$query1->bind_param("i", $id_post[$x]);
			$result1 = $query1->execute();
			$rows1 = $query1->get_result();
			$y = 0;
			if($rows1->num_rows > 0){
				while($row1 = $rows1->fetch_array()){
					$id_comment1[$y] = $row1['id_comment'];
					$id_post1[$y] = $row1['id_post'];
					$username1[$y] = $row1['username'];
					$comment1[$y] = $row1['comment'];
					$date1[$y] = $row1['date'];
					$array_gc[$x][$y] = array("id_comment_gc"=>$id_comment1[$y], "id_post_gc"=>$id_post1[$y], "username_gc"=>$username1[$y], "comment_gc"=>$comment1[$y], "date_gc"=>$date1[$y]);
					$y++;
				}
			}

					if($profileimage[$x] == null || $profileimage[$x] == '')
						array_push($image_shown[], "images/resources/default_profile.png");
					else
						array_push($image_shown[], "images/thumbnail/$profileimage");
					

			$array_gp[$x] = array("id_post_gp"=>$id_post[$x], "username_gp"=>$username[$x], "name_gp"=>$name[$x], "content_gp"=>$content[$x], "image_gp"=>$image[$x], "date_gp"=>$date[$x], "profileimage_gp"=>$image_shown[$x]);
			$x++;
		}
		echo json_encode(array("array1"=>$array_gp));
	}


?>


