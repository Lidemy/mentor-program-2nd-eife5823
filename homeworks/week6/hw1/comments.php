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
	    <?php  //判斷是否為登入狀態，利用 session id 取得 nickname
		  require_once('conn.php');

		  if(isset($_COOKIE["session_id"]) && !empty($_COOKIE["session_id"])) {
		  	$session_id = $_COOKIE["session_id"];
		  	$login = true;
		  	$stmt =  $conn->prepare("SELECT * FROM eife_certificate WHERE s_id = ?");
		  	$stmt->bind_param("s", $session_id );
		  	$stmt->execute();
		  	$check_login= $stmt->get_result(); //執行 sql
		  	if(!$check_login || $check_login->num_rows <= 0) {
		  		$user = null;
		  		$login = false; 
		  	} else {
		  		$login = true; 
		  		$check_login_row = $check_login->fetch_assoc();
		  		$user = $check_login_row['username'];
		  	}
		 } else {
		 		$user = null;
		  		$login = false;
		 }	
		?>
		<ul>
			<?php
			if($login == false) {
				echo '<li><a href="login.php">登入</a></li>';}
			?>
			<?php
			if($login == false) {
				echo '<li><a href="register.php">註冊</a></li>';}
			?>
			<?php
			if($login == true) {
				echo '<li><a href="logout.php">登出</a></li>';}
			?>
		</ul>
	</header>
		  <?php 
	    /* 設定分頁 */
		$per = 10; //每頁顯示10筆資料
		if (!isset($_GET['page'])) {
			$page = 1;
		} else {
			$page = intval($_GET['page']); //必須設定數值才抓的到 $_GET 的值
		}
	    $start = ($page-1)*$per; //每頁從第幾筆留言開始
		$count_reply = $conn->prepare("SELECT COUNT(*) as sum FROM eife_comments WHERE parent_id = 0 ");  //主留言總筆數
		$count_reply->execute(); //執行 sql
		$count_result = $count_reply->get_result(); 
		if($count_result->num_rows > 0) {
			$row_main = $count_result->fetch_assoc();
			$pages = ceil($row_main['sum'] / $per); //總頁數			
		}
	    echo '<div class="page">';
				for ($i=1; $i<=$pages; $i++) {
			 		echo "<a href='./comments.php?page=$i'>$i</a>"; //跑頁數連結的迴圈
				}
		echo '</div>';

		/* 分頁設定結束 */

		$get_users = $conn->prepare("SELECT * FROM eife_users WHERE username = '$user' "); //取得暱稱
		$get_users->execute();
		$get_users_result = $get_users->get_result();
		if ($get_users_result->num_rows > 0) {
			$row_get_users = $get_users_result->fetch_assoc();
			$nickname = $row_get_users['nickname'];
		} 
		?>
	<div class="new_reply">
	  <form action="new_reply.php" method="POST">
		<input name="nickname" class="nickname" type="text" placeholder="暱稱"
		<?php //有登入就代入暱稱	  		
		    if(isset($session_id)) {
		  	echo 'value = "'.$nickname.'"';
		    }
		?> readonly><br>
		<textarea name="content" class="comments" placeholder="留言內容"></textarea><br>
		<input type="hidden" name="parent_id" value="0"> 
		<input class="submit" type="submit" value="送出">
	  </form>
	</div>

		<?php 
		$showOnPage = "SELECT eife_comments.post_id, eife_comments.user_id, eife_comments.content, eife_users.nickname, eife_users.username, eife_comments.created_at FROM eife_comments LEFT JOIN eife_users ON eife_comments.user_id = eife_users.id WHERE parent_id = 0 ORDER BY created_at DESC LIMIT $start, $per"; //利用join合併兩張table的id，並取到需要的資料
		$result_page = $conn->query($showOnPage) or die($conn->error);
		if ($result_page->num_rows > 0) {
			while($row = $result_page->fetch_assoc()){
				$post_id = $row['post_id']; //抓出主留言的 post id
		?>		
				<div class='old_reply'>
		     	  <div class='header'>
			        <div class='nickname'><?php echo $row['nickname']?></div>
			    	<div class='timestamp'><?php echo $row['created_at']?></div>	
			 	  </div>
			 		<div class='comments'><?php echo htmlspecialchars($row['content'])?></div>
			 		<?php 
			 		  if ($row['username'] === $user) { //刪除主留言，只有自己的留言才能刪除
			 		?>
			 		  <form action="delete.php" method="POST"> 
			 		  	<input type="hidden" name="post_id" value='<?php echo $post_id ?>'> 
					    <input class="delete_main" type="submit" name="delete" value="刪除留言">
				      </form>
				      <form action="edit_page.php" method="GET"> 
			 		  	<input type="hidden" name="post_id" value='<?php echo $post_id ?>'> 
					    <input class="edit_main" type="submit" name="edit" value="編輯留言">
				      </form>
				    <?php  	
			 		  }
			 		?>

				</div>
				
		<?php					 	  
				 //這邊必須使用 post id 去篩選是對哪個主留言做回應，否則會有子留言重複出現的情況				
				 $childReply = 'SELECT eife_comments.user_id, eife_comments.post_id, eife_comments.content, eife_users.nickname, eife_users.username, eife_comments.created_at FROM eife_comments LEFT JOIN eife_users ON eife_comments.user_id = eife_users.id WHERE parent_id = ' . $row['post_id'] . ' ORDER BY created_at DESC'; 	//撈取子留言
	   			 $result_child = $conn->query($childReply) or die($conn->error);
	    		 if ($result_child->num_rows > 0) {
	      			while ($row_child = $result_child->fetch_assoc()) {
	      				$comment_user_id = $row_child['user_id']; //抓出子留言的 user id
	      				if ($row['user_id'] === $comment_user_id ) { //若是在自己留言底下回覆，顯示不同背景色 
	     ?>				
	     					<div class='changeColor'>
 	    						<div class='header'>	
		  							<div class='subNickname'><?php echo $row_child['nickname']?></div>
		  							<div class='subTimestamp'><?php echo $row_child['created_at']?></div>
	    						</div>	
       				   				<div class='subComments'><?php echo $row_child['content']?></div>
       				   				<?php 
			 		  					if ($row_child['username'] === $user) { //刪除子留言，只有自己的留言才能刪除
			 						?>
			 		  					<form action="delete.php" method="POST"> 
			 		  						<input type="hidden" name="post_id" value='<?php echo $row_child['post_id'] ?>'> 
					    					<input class="delete_sub" type="submit" name="delete" value="刪除留言">
				     					</form>
				     					<form action="edit_page.php" method="GET"> 
			 		  						<input type="hidden" name="post_id" value='<?php echo $row_child['post_id'] ?>'> 
					    					<input class="edit_child" type="submit" name="edit" value="編輯留言">
				     				    </form>
				   					 <?php  	
			 		  					}
			 						 ?> 
	 					    </div>
	 					 <?php 
	 					  } else {
						 ?>
	     				 <div class='child_reply'>
 	    						<div class='header'>	
		  							<div class='subNickname'><?php echo $row_child['nickname']?></div>
		  							<div class='subTimestamp'><?php echo $row_child['created_at']?></div>
	    						</div>	
       				   				<div class='subComments'><?php echo $row_child['content']?></div>
       				   				<?php 
			 		  					if ($row_child['username'] === $user) { //刪除子留言，只有自己的留言才能刪除
			 						?>
			 		  					<form action="delete.php" method="POST"> 
			 		  						<input type="hidden" name="post_id" value='<?php echo $row_child['post_id'] ?>'> 
					    					<input class="delete_sub" type="submit" name="delete" value="刪除留言">
				     					</form>
				     					<form action="edit_page.php" method="GET"> 
			 		  						<input type="hidden" name="post_id" value='<?php echo $row_child['post_id']?>'> 
					   					    <input class="edit_child" type="submit" name="edit" value="編輯留言">
				      					</form>
				   					 <?php  	
			 		  					}
			 						 ?> 
	 					 </div>
	 							       
	     				 		      
	     				 		           				
	 	<?php		 
	 					}						
	       			 };	
	   			  };
	   	?>
	   			 <form action="new_reply.php" class="childform" method="POST">
					<input class="nickname" name="nickname" type="text" placeholder="暱稱" 
		   				<?php //有登入就代入暱稱
				      	if(isset($session_id)) { echo 'value = "'.$nickname.'"'; } ?>readonly><br>
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
    <?php  //換頁功能


	?>		
  </body>
</html>