<?php

    require_once('conn.php');

	if (empty($_POST['nickname']) || empty($_POST['content'])) {
		header('Location: comments.php');
	}

	if (isset($_POST['nickname']) && isset($_POST['content'])) {
		$id = $_COOKIE["id"];
		$content = $_POST['content'];
		$parent = $_POST['parent_id'];
		$childreply_sql = "INSERT INTO comments (user_id, parent_id, content) VALUES ('$id', '$parent', '$content')";

		if ($conn->query($childreply_sql) === TRUE) {
			header('Location: comments.php');
		} else {
			echo 'Error2: ' . $childreply_sql . '<br>' . $conn->error;
		}
	}


?>