<!DOCTYPE html>
<html>
<head>
	<title>編輯留言</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<style type="text/css">

			.container {
			width: 700px;
			height: 500px;
			margin:80px auto;
			background-color: #D7B98E;
			border-radius: 10px;	
			}
			.edit {
			padding: 15px;
		    }
		    .nickname {
			width: 300px;
			height: 30px;
			display: inline-block;
			font-size: 18px;
			border-radius: 10px;
			font-weight: bold;
			}
			.comments {
			width: 80%;
			height: 200px;
			margin-top: 10px;
			border-radius: 10px;
			font-size: 16px;
			}
			.btn {
			border-radius: 10px;
			font-size: 16px;
			font-weight: bold;
			}
			@media screen and (max-width:720px) {
				.comments {
				width: 80%;
				height: 200px;
				}
			}

			@media screen and (max-width:580px) {
				.container {
				width: 90%;	
				}
				.comments {
				width: 100%;
				height: 200px;
				}
				.nickname {
				width: 70%;	
				}
			}

	</style>
</head>
<body style="background-color: #707C74;">
<?php
	require_once('conn.php');
	/* 取得 username */
	if(isset($_COOKIE["session_id"]) && !empty($_COOKIE["session_id"])) {
	$session_id = $_COOKIE["session_id"];
	$stmt =  $conn->prepare("SELECT * FROM eife_certificate WHERE s_id = ?");
	$stmt->bind_param("s", $session_id );
	$stmt->execute();
	$check_login= $stmt->get_result(); //執行 sql
	$check_login_row = $check_login->fetch_assoc();
	$user = $check_login_row['username'];
    } else {
    	echo 'Error: ' . $stmt . '<br>' . $conn->error;
    }
    /* 取得暱稱 */
	$get_users = $conn->prepare("SELECT * FROM eife_users WHERE username = '$user' "); 
	$get_users->execute();
	$get_users_result = $get_users->get_result();
	if ($get_users_result->num_rows > 0) {
			$row_get_users = $get_users_result->fetch_assoc();
			$nickname = $row_get_users['nickname'];
		} else {
			echo 'Error: ' . $get_users . '<br>' . $conn->error;
		}
	


?>	
  <div class="container">
  	<div class="edit row">
  		<div class="col-lg-12">
			  <form action="handle_edit.php" method="POST">
					<input name="nickname" class="nickname" type="text" placeholder="暱稱"
					<?php //有登入就代入暱稱	  		
					    if(isset($session_id)) {
					  	echo 'value = "'.$nickname.'"';
					    }
					?> readonly><br>
					<textarea name="content" class="comments" placeholder="編輯留言"></textarea><br>
					<input type="hidden" value="<?php echo $_GET['post_id'] ?>" name="post_id"> 
					<input class="btn btn-info" type="submit" value="送出">
			  </form>
		</div>	  
	</div>
  </div>		
	

</body>
</html>