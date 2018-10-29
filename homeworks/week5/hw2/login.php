<?php
    require_once('conn.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>會員登入</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">

		* {
			margin: 0;
		}
		body {
			background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7Q_hyauob6_s9fUQD4pX2GoGyN3E-yqpojdTLiNf_nZuSIHND7Q);
			background-size: cover;
		}
		.login_content {
			width: 500px;
			height: 500px;
			margin: 50px auto;
			background-color: #FFBB66;
			padding: 10px;
			position: relative;
			border-radius: 10px;
		}
		.input {
			width: 400px;
			height: 40px;
			margin-top: 20px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			border: 2px solid #DDDDDD;
			font-size: 16px;
		}
		.login {
			width: 400px;
			height: 45px;
			margin-top: 40px;
			position: relative;
			left: 45px;
			border-radius: 10px;
			background-color: #009FCC;
			font-size: 16px;
			font-weight: bold;
		}
		.register {
			width: 400px;
			height: 45px;
			margin-top: 30px;
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
		}
		footer {
			text-align: center;
			padding: 40px;
			height: 70px;
			background-color: #FFBB66;
		}
		.alert {
			font-size: 18px;
			color: red;
			font-weight: bold;
			position: absolute;
			bottom: 200px;
			left: 680px;
		
		}

	</style>
</head>
<body>
  <div class="login_content">
  	<h1>Welcome!</h1>
	<p>Hello! 訪客您好，如要留言請先登入會員唷!</p>
	<form action="" method="POST">
		<input class="input" type="text" name="username" placeholder="請輸入帳號"><br>
		<input class="input" type="password" name="password" placeholder="請輸入密碼"><br>
		<input class="login" type="submit" value="登入">
		<input class="register" type="button" value="還不是會員嗎？點我註冊" onclick="location.href='http://localhost/Eife/register.php' ">
	</form>	
	
  </div>
  <footer>Copyright © Eife</footer>		
</body>
</html>
<?php
		if(isset($_POST['username']) && isset($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$sql = "SELECT * FROM users WHERE username ='". $username ."'or password='". $password ."'"; //利用字串連接子串起字串與變數
			$result = $conn->query($sql); //執行 sql
			$row = $result->fetch_assoc();
			$id = $row["id"];
			echo $id;

			if ($result->num_rows > 0) {
				echo '登入成功!';
				setcookie("id", $id, time()+3600*24);
				header('Location: comments.php');
			} else {
				header('Location: login.php');
			}
		}
	?>