<?php

    require_once('conn.php');

	if (empty($_POST['nickname']) || empty($_POST['content'])) {
		header('Location: comments.php');
	}

	if (isset($_POST['nickname']) && isset($_POST['content'])) {

		/*利用 nickname 抓出 user id*/
		$nickname = $_POST['nickname'];
		$get_users = $conn->prepare("SELECT * FROM eife_users WHERE nickname = '$nickname'");
		$get_users->bind_param("s", $session_id);
		$get_users->execute();
		$result_users = $get_users->get_result();
		$row_users = $result_users->fetch_assoc();
		if($result_users->num_rows > 0) {
			$content = $_POST['content'];
			$parent_id = $_POST['parent_id'];
			$user_id = $row_users["id"];
		}
	
		$reply_sql = $conn->prepare("INSERT INTO eife_comments (user_id, parent_id, content) VALUES (?,?,?)");
		$reply_sql->bind_param("sss", $user_id, $parent_id, $content);

		if ($reply_sql->execute() === TRUE) {
			header('Location: comments.php');
		} else {
			echo 'Error: ' . $reply_sql . '<br>' . $conn->error;
		}
	}

?>