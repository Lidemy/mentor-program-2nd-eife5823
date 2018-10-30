<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>留言板實做</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="comments.css">
</head>
<body>
<div class="container">
	<header>
		<span style="font-size: 40px;">留言板</span>
	    <?php  //判斷是否為登入狀態
		  require_once('conn.php');
		  
		  if(!isset($_COOKIE["id"])) {
		  	$login = false;
		  } else {
		  	$login = true;  
		  }
		?>
		<ul>
			<?php
			if($login === false) {
				echo '<li><a href="login.php">登入</a></li>';}
			?>
			<?php
			if($login === false) {
				echo '<li><a href="register.php">註冊</a></li>';}
			?>
			<?php
			if($login === true) {
				echo '<li><a href="logout.php">登出</a></li>';}
			?>
		</ul>
	</header>
	<div class="new_reply">
	  <form action="new_reply.php" method="POST">
		<input name="nickname" class="nickname" type="text" placeholder="暱稱"
		<?php //有登入就代入暱稱
		     /* 取得暱稱 */
	  		$id = $_COOKIE["id"];
	  		$sql_nick = "SELECT nickname FROM users WHERE id = $id"; //從存在cookie的id取得暱稱
	  		$result_nick = $conn->query($sql_nick);
	 		$row_nick = $result_nick->fetch_assoc();
	  		$nickname = $row_nick['nickname'];
		    if(isset($id)) {
		  	echo 'value = "'.$nickname.'"';
		    }
		?> readonly><br>
		<textarea name="content" class="comments" placeholder="留言內容"></textarea><br>
		<input type="hidden" name="parent_id" value="0"> 
		<input class="submit" type="submit" value="送出">
	  </form>
	</div>
	<div class="msg_container">
	  <?php 
	    /* 設定分頁 */
		$sql = 'SELECT * FROM comments WHERE parent_id = 0';  //撈出所有主留言
		$result = $conn->query($sql);
		$reply_sum = $result->num_rows; //主留言總筆數
		$per = 10; //每頁10筆資料
		$pages = ceil($reply_sum / $per); //總頁數

		if (!isset($_GET["page"])) {
			$page = 1;
		} else {
			$page = intval($_GET["page"]); //取得整數頁
		}

		$showOnPage = "SELECT comments.post_id, comments.user_id, comments.content, users.nickname, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE parent_id = 0 ORDER BY created_at DESC LIMIT 10"; //利用join合併兩張table的id，並取到需要的資料
		$result_page = $conn->query($showOnPage) or die($conn->error);
		if ($reply_sum > 0) {
			while($row = $result_page->fetch_assoc()){
				
				echo "<div class='old_reply'>
		     			<div class='header'>
			    			<div class='nickname'>{$row['nickname']}</div>
			    			<div class='timestamp'>{$row['created_at']}</div>	
			 			</div>
			 			<div class='comments'>{$row['content']}</div>
					  </div>"; 			 	  
				 $post_id =  $row['post_id']; //這邊必須使用 post id 去篩選是對哪個主留言做回應，否則會有子留言重複出現的情況				
				 $childReply = 'SELECT comments.user_id, comments.content, users.nickname, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE parent_id = ' . $row['post_id'] . ' ORDER BY created_at DESC'; 	//撈取子留言
	   			 $result_child = $conn->query($childReply) or die($conn->error);
	    		 if ($result_child->num_rows > 0) {
	      			while ($row_child = $result_child->fetch_assoc()) {
	     				
	     				echo "<div class='child_reply'>
 	    							<div class='header'>	
		  								<div class='subNickname'>{$row_child['nickname']}</div>
		  								<div class='subTimestamp'>{$row_child['created_at']}</div>
	    							</div>	
       				   				<div class='subComments'>{$row_child['content']}</div>
	 			 				</div>";
	       			 };	
	   			  };
	   			 ?>
	   			 <form action="new_childreply.php" class="childform" method="POST">
					<input class="nickname" name="nickname" type="text" placeholder="暱稱" 
		   				<?php //有登入就代入暱稱
				      	if(isset($id)) {echo 'value = "'.$nickname.'"';}?>readonly><br>
					<textarea name="content" class="child__input-comments"  placeholder="發表回應"></textarea><br>
					<input type="hidden" name="parent_id" value="<?php echo $row['post_id'] ?>">
					<input class="submit" type="submit" value="送出">
				 </form> 
	   			
    <?php				 
			};
		};	
	?> 
	   
    
	
	</div>
  </div>		

</div>
</body>
</html>