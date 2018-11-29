<!DOCTYPE html>
<html>
<head>
	<title>會員註冊</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<style>
		* {
			margin: 0;
		}
		.regi_content {
			width: 50%;
			height: 500px;
			margin: 50px auto;
			background-color: #D7B98E;
			padding: 10px;
			position: static;
			border-radius: 10px;
		}
		.input {
			width: 80%;
			height: 40px;
			margin-top: 10px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			border: 2px solid #DDDDDD;
			font-size: 16px;
		}
		.register {
			width: 80%;
			height: 45px;
			margin-top: 20px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			background-color: #69B0AC;
			font-size: 16px;
			font-weight: bold;
		}
		h1 {
			text-align: center;
			padding: 10px;
			color:  #0B1013;
		}

		p {
			text-align: center;
			padding: 10px;
			font-size: 30px;
			color:  #0B1013;
		}
		.login {
			position: absolute;
			bottom: 30px;
			left: 100px;
			font-size: 14px;
			color: #666666;
			display: flex;
			justify-content: center;
			width: 60%;
		}
		.alert {
			font-size: 18px;
			color: red;
			font-weight: bold;
			position: absolute;
			bottom: 150px;
			left: 680px;
		
		}
		footer {
			text-align: center;
			padding: 70px;
			height: 70px;
			margin-bottom: 0px;
			background-color: #D7B98E;
			color: #0B1013;
		}
		.col-lg-12 {
			position: relative;
		}

		@media screen and (max-width:720px) {

			.regi_content {
				width: 100%;
				box-sizing: border-box;
			}
			h1 {
				font-size: 40px;
			}
			p {
				font-size: 30px;
			}
			.input {
				width: 100%;
				position: relative;
				left: 5px;
			}
			.col-lg-12 {
			position: relative;
			}

			.login {
			position: absolute;
			bottom: 30px;
			left: 50px;
			}

		}

		@media screen and (max-width:992px){
			.regi_content {
				width: 80%;
				box-sizing: border-box;
			}
			h1 {
				font-size: 40px;
			}
			p {
				font-size: 30px;
			}
			.input {
				width: 100%;
				position: relative;
				left: 5px;
			}
			.login {
			position: absolute;
			bottom: 30px;
			left: 100px;
			}
			.col-lg-12 {
			position: relative;
			}

		}
	</style>
</head>
<body style="background-color: #707C74;">
	<div class="container">	
	  <div class="regi_content row">
	  	<div class="col-lg-12">		
		  	<h1>Welcome!</h1>
			<p>會員帳號註冊</p>
			<form action="register.php" method="POST">
				<input class="input" type="text" name="username" placeholder="請輸入帳號"><br>	
				<input class="input" type="password" name="password" placeholder="請輸入密碼"><br>
				<input class="input" type="text" name="nickname" placeholder="請輸入暱稱"><br>
				<input class="register btn btn-info" type="submit" value="註冊帳號">
			</form>	
			<div class="login">已經有會員帳號？<a href="http://localhost/Eife/login.php">登入帳號</a></div>	
		</div>
	  </div>
	 </div> 		
  <footer>Copyright © Eife</footer>	  
</body>
</html>

<?php
require_once('conn.php');
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nickname'])) {

	$username = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$nickname = $_POST['nickname'];
	$stmt = $conn->prepare("SELECT * FROM eife_users WHERE username = ? or password= ? "); //判斷 username 及 nickname 是否在資料庫裡有重複
	$stmt->bind_param("ss", $username, $password);
	$stmt->execute();
	$result = $stmt->get_result(); //執行 sql
	$row = $result->fetch_assoc();
	if ($result->num_rows <= 0){
		$new_users = "INSERT INTO eife_users (username,password,nickname) VALUES ('$username', '$password', '$nickname')";
		$conn->query($new_users) or die('error'); //若無法插入顯示錯誤
		header('Location: login.php');	
	} else {
		echo '<h1 class="alert">註冊失敗!</h1>';
	}
}

?>