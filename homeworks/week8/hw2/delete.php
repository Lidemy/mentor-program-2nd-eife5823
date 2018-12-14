<?php

    require_once('conn.php');
    session_start();

	if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {

		$post_id = $_POST['post_id'];
		$user_id = $_SESSION['user_id'];
		$stmt = $conn->prepare("DELETE FROM comments WHERE post_id = '$post_id' or parent_id = '$post_id' AND user_id = '$user_id'"); // 權限驗證，只有自己的留言可刪除，不能透過改 data-id 刪除別人留言
		if ($stmt->execute() === TRUE) {
			echo "Success!";
		} else {
			echo 'Error: ' . $stmt . '<br>' . $conn->error;
		}

	}
	
?>