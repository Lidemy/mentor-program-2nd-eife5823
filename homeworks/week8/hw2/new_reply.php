<?php

    require_once('conn.php');

	if (empty($_POST['nickname']) || empty($_POST['content'])) {
		header('Location: comments.php');
	}

	if (isset($_POST['nickname']) && isset($_POST['content'])) {

		/*利用 nickname 抓出 user id*/
		$nickname = $_POST['nickname'];
		$get_users = $conn->prepare("SELECT * FROM users WHERE nickname = '$nickname'");
		$get_users->execute();
		$result_users = $get_users->get_result();
		$row_users = $result_users->fetch_assoc();
		if($result_users->num_rows > 0) {
			$content = $_POST['content'];
			$parent_id = $_POST['parent_id'];
			$user_id = $row_users["user_id"];
		}
		$get_main = $conn->prepare("SELECT comments.post_id, comments.user_id, comments.content, users.nickname, users.username, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.user_id WHERE parent_id = 0 ORDER BY created_at DESC"); //撈出主留言資料
		$get_main -> execute();
		$get_main_result = $get_main->get_result();
		$get_main_row = $get_main_result->fetch_array();
		$created_at = $get_main_row['created_at'];
		$post_id = $get_main_row['post_id'];
	
		$reply_sql = $conn->prepare("INSERT INTO comments (user_id, parent_id, content) VALUES (?,?,?)");
		$reply_sql->bind_param("iis", $user_id, $parent_id, $content);
		$reply_sql->execute() or die(header('Location: login.php'));
		
		if ($parent_id === 0) { //新增主留言用AJAX，若是子留言還是刷新頁面
			$arr = array(
			'result' => 'success',
			'created_at' => $created_at, 
			'post_id' => $post_id,
			);
			echo json_encode($arr);	
		} else {
			header('Location: comments.php');
		}
		
		
	}

?>