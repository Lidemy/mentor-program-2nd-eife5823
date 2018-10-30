<!DOCTYPE html>
<html>
<head>
	<title>會員註冊</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		* {
			margin: 0;
		}
		body {
			background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7Q_hyauob6_s9fUQD4pX2GoGyN3E-yqpojdTLiNf_nZuSIHND7Q);
			background-size: cover;
		}
		.regi_content {
			width: 500px;
			height: 500px;
			margin: 50px auto;
			background-color: #FFBB66;
			padding: 10px;
			position: static;
			border-radius: 10px;
		}
		.input {
			width: 400px;
			height: 40px;
			margin-top: 10px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			border: 2px solid #DDDDDD;
			font-size: 16px;
		}
		.register {
			width: 400px;
			height: 45px;
			margin-top: 20px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			background-color: #009FCC;
			font-size: 16px;
			font-weight: bold;
		}
		h1 {
			text-align: center;
			padding: 10px;
		}

		p {
			text-align: center;
			padding: 10px;
			font-size: 30px;
		}
		span {
			font-size: 14px;
			position: relative;
			left: 50px;
			color: #666666;
		}
		.login {
			position: absolute;
			bottom: 200px;
			left: 540px;
		}
		.alert {
			font-size: 18px;
			color: red;
			font-weight: bold;
			position: absolute;
			bottom: 150px;
			left: 680px;
		
		}
	</style>
</head>
<body>
  <div class="regi_content">
  	<h1>Welcome!</h1>
	<p>會員帳號註冊</p>
	<form action="register.php" method="POST">
		<input class="input" type="text" name="username" placeholder="請輸入帳號"><br>	
		<input class="input" type="password" name="password" placeholder="請輸入密碼"><br>
		<input class="input" type="text" name="nickname" placeholder="請輸入暱稱"><br>
		<input class="register" type="submit" value="註冊帳號">
	</form>	
  </div>
  <span class="login">已經有會員帳號？<a href="http://localhost/Eife/login.php">登入帳號</a></span>

</body>
</html>

<?php
require_once('conn.php');
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nickname'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	$nickname = $_POST['nickname'];
	$sql = "SELECT * FROM users WHERE username ='". $username ."'or nickname='". $nickname ."'"; //判斷 username 及 nickname 是否在資料庫裡有重複
	$result = $conn->query($sql); //執行 sql
	if ($result->num_rows <= 0){
		$new_users = "INSERT INTO users (username,password,nickname) VALUES ('$username', '$password', '$nickname')";
		$conn->query($new_users) or die('error'); //若無法插入顯示錯誤
		header('Location: comments.php');	
	} else {
		echo '<h1 class="alert">註冊失敗!</h1>';
	}
}

?>