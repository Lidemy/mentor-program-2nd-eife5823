<?php

    require_once('conn.php');

	if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {

		$post_id = $_POST['post_id'];
		$stmt = $conn->prepare("DELETE FROM eife_comments WHERE post_id = '$post_id' or parent_id = '$post_id'");
		if ($stmt->execute() === TRUE) {
			header('Location: comments.php');
		} else {
			echo 'Error: ' . $stmt . '<br>' . $conn->error;
		}

	}
	
?>