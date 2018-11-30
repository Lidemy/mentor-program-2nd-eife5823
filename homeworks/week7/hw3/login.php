<?php
    require_once('conn.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>會員登入</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<style type="text/css">


		* {
			margin: 0;
		}
		.login_content {
			width: 50%;
			height: 500px;
			margin: 50px auto;
			background-color: #D7B98E;
			padding: 10px;
			position: relative;
			border-radius: 10px;
		}
		.input {
			width: 80%;
			height: 40px;
			margin-top: 20px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			border: 2px solid #DDDDDD;
			font-size: 16px;
		}
		.login {
			width: 80%;
			height: 45px;
			margin-top: 40px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			background-color: #69B0AC;
			font-size: 16px;
			font-weight: bold;
			color: #0B1013;
		}
		.register {
			width: 80%;
			height: 45px;
			margin-top: 30px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			background-color: #69B0AC;
			font-size: 16px;
			font-weight: bold;
			color: #0B1013;
		}
		h1 {
			text-align: center;
			padding: 10px;
			color: #0B1013;
		}

		p {
			text-align: center;
			padding: 10px;
			color: #0B1013;
		}
		footer {
			text-align: center;
			padding: 70px;
			height: 100px;
			margin-bottom: 0px;
			background-color: #D7B98E;
			color: #0B1013;
		}
		.alert {
			font-size: 18px;
			color: red;
			font-weight: bold;
			position: absolute;
			bottom: 100px;
			left: 640px;
		
		}
		@media screen and (max-width:720px) { /* 只要寬度在 720 以下 */

			.login_content {
				width: 100%;
				box-sizing: border-box;
			}
			h1 {
				text-align: center;
				padding: 10px;
				color: #0B1013;
				font-size: 30px;
			}
			p {
				text-align: center;
				color: #0B1013;
				font-size: 20px;
			}
			.input {
				width: 100%;
				height: 40px;
				margin-top: 20px;
				position: relative;
				left: 5px;
				border-radius: 10px;
				border: 2px solid #DDDDDD;
				font-size: 16px;
			}
			.login {
				width: 100%;
				height: 45px;
				margin-top: 40px;
				position: relative;
				left: 5px;
				border-radius: 10px;
				background-color: #69B0AC;
				font-size: 16px;
				font-weight: bold;
				color: white;
			}
			.register {
				width: 100%;
				height: 45px;
				margin-top: 20px;
				position: relative;
				left: 5px;
				border-radius: 10px;
				background-color: #69B0AC;
				font-size: 16px;
				font-weight: bold;
				color: white;
			}
		}
		@media screen and (max-width:992px) { /* 只要寬度在 992 以下 */
			.login_content {
				width: 70%;
				box-sizing: border-box;
			}
			h1 {
				text-align: center;
				padding: 10px;
				color: #0B1013;
				font-size: 30px;
			}
			p {
				text-align: center;
				color: #0B1013;
				font-size: 20px;
			}
		}

	</style>
</head>
<body style="background-color: #707C74;">
	<div class="container">	
	  <div class="login_content row">
	  	<div class="col-lg-12">	
		  	<h1>Welcome!</h1>
			<p>Hello! 訪客您好，如要留言請先登入會員唷!</p>
			<form method="POST">
				<input class="input" type="text" name="username" placeholder="請輸入帳號"><br>
				<input class="input" type="password" name="password" placeholder="請輸入密碼"><br>
				<input class="login btn btn-info" type="submit" value="登入">
				<input class="register btn btn-info" type="button" value="還不是會員嗎？點我註冊" onclick="location.href='http://mentor-program.co/eife5823/register.php' ">
			</form>	
		</div>
	  </div>
	 </div>

  <footer>Copyright © Eife</footer>	
</body>
</html>
<?php
		if(isset($_POST['username']) && isset($_POST['password'])) {
			$username = $_POST['username'];
			$password =$_POST['password'];

			$stmt = $conn->prepare("SELECT * FROM eife_users WHERE username = ?"); //解決 SQL Injection 
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$result = $stmt->get_result(); //執行 sql
			$row = $result->fetch_assoc();
			$hash = $row['password'];

			if (password_verify($password, $hash)) { //輸入的密碼必須和verify後的資料庫密碼相同
				$session_id = uniqid();
				$old_session = $conn->prepare("DELETE FROM eife_certificate WHERE username = ?");
				$old_session->bind_param("s", $username);
				$old_session->execute() or die ('error');
				$sql = $conn->prepare("INSERT INTO eife_certificate (s_id, username) VALUES (?, ?)");
				$sql->bind_param("ss", $session_id, $username);
				$sql->execute() or die ('error');
				setcookie("session_id", $session_id, time()+3600*24);
				header('Location: comments.php');
			} else {
				echo '<div class="alert">帳號或密碼錯誤!</div>';	

		    } 
		 } else {
		 	$conn->close();
		 }   


	?>