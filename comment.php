<?php 
	date_default_timezone_set('Asia/Bangkok');
	require_once "db.php";
	if(!empty($_POST['comment'])) {
		$id_post = $_GET['id_post'];
		$username = $_COOKIE['logged_in'];
		$comment = $_POST['comment'];
		$date = date("Y-m-d G:i:s");
		$conn = konek_db();
		$query = $conn->prepare("insert into comment(id_post, username, comment, date) values(?, ?, ?, ?)");
		$query->bind_param("isss", $id_post, $username, $comment, $date);
		$result = $query->execute();
		if (! $result)
			die("<p>Proses query gagal.</p>");

		$query1 = $conn->prepare("select * from comment left join member ON comment.username = member.username where id_post = $id_post order by date asc");
		$result1 = $query1->execute();
		if(! $result1)
			die("Gagal query");
		$rows1 = $query1->get_result();
		while($row1 = $rows1->fetch_array()){
			$id_comment = $row1['id_comment'];
			$commenter = $row1['username'];
			$commenter_name = $row1['name'];
			$comment = $row1['comment'];
			$date_comment = $row1['date'];
			$commenter_image = $row1['profile_image'];
		}
		if($commenter_image == null || $commenter_image == '')
			$commenter_image1 = "images/resources/default_profile.png";
		else
			$commenter_image1 = "images/thumbnail/$commenter_image";

		echo json_encode(array("id_comment"=>$id_comment, "commenter"=>$commenter, "commenter_name"=>$commenter_name, "date_comment"=>$date_comment, "commenter_image"=>$commenter_image1, "comment"=>$comment));
	}
 ?>