<?php

    require_once('conn.php');

	if (isset($_POST['content']) && !empty($_POST['content'])) {
		$content = $_POST['content'];
		$post_id = $_POST['post_id'];
		$stmt = $conn->prepare("UPDATE comments SET content = '$content' WHERE post_id = $post_id");
		if ($stmt->execute() === TRUE) {
			header('Location: comments.php');
		} else {
			echo 'Error: ' . $stmt . '<br>' . $conn->error;
		}

	} else {
		header('Location: comments.php');
	}
	
?>