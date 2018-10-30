<?php

    require_once('conn.php');

	if (empty($_POST['nickname']) || empty($_POST['content'])) {
		header('Location: comments.php');
	}

	if (isset($_POST['nickname']) && isset($_POST['content'])) {
		$id = $_COOKIE["id"]; //會員 id
		$content = $_POST['content'];
		$reply_sql = 'INSERT INTO comments (user_id, parent_id, content) VALUES ("' . $_COOKIE['id'] .'", "' . $_POST['parent_id'] .'", "' . $_POST['content'] .'")';

		if ($conn->query($reply_sql) === TRUE) {
			header('Location: comments.php');
		} else {
			echo 'Error: ' . $reply_sql . '<br>' . $conn->error;
		}
	}


?>