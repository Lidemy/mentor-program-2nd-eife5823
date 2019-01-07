<?php
	require_once('conn.php');
	session_start();
	ini_set("display_errors", "On");
	error_reporting(E_ALL & ~E_NOTICE);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Comment Board</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="board.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>
		$(document).ready(function() { //新增與刪除留言改成 AJAX
			$('.container').on('click', '.delete_main', function (e) {
				if (!confirm('確定要刪除嗎?')) return;
				const post_id = $(e.target).attr('data-id'); //按下刪除鍵取到 post id
				$.ajax({
				  method: "POST",
				  url: "./delete.php",
				  data: { post_id } //ES6裡面key跟value相同的話只傳一個值即可
				}).done(function(msg) {
				    $(e.target).parent().parent().parent().remove(); //刪除主留言
				  }).fail( function () {
				  	alert('刪除失敗!');
				  });	
			});
			$('.container').on('click', '.delete_sub', function (e) {
				if (!confirm('確定要刪除嗎?')) return;
				const post_id = $(e.target).attr('data-id'); //按下刪除鍵取到 post id
				$.ajax({
				  method: "POST",
				  url: "./delete.php",
				  data: { post_id } //ES6裡面key跟value相同的話只傳一個值即可
				}).done(function(msg) {
				    $(e.target).parent().parent().parent().parent().remove(); //刪除子留言
				  }).fail( function () {
				  	alert('刪除失敗!');
				  });	
			});
			$('form[class=main_msg]').submit(function(e) {	//新增主留言
			 	e.preventDefault();		
				const content = $(e.target).find('textarea[name=content]').val();
				const parentId = $(e.target).find('input[name=parent_id]').val();
				const nickname = $(e.target).find('input[name=nickname]').val();
 				$.ajax({
				  type: 'POST',
				  url: 'new_reply.php',
				  data: {
				  	content: content,
				  	parent_id: parentId,
				  	nickname: nickname
				  }, 
				  success: function(resp){
				  	const res = JSON.parse(resp);
				  	if (res.result === 'success') {
				  		$('.old_group').prepend(`
				  			<div class="old_group">			
								<div class="old_reply">	
										<div class='header'>
					  						<div class='nickname'>${nickname}</div>
					  						<div class='timestamp'>${res.created_at}</div>	
										</div>
								<div class='comments'>${content}</div>
								<div class="delete_comment" data-id='${res.post_id}'>
									<input class="delete_main" type="button" name="delete" value="刪除" data-id='${res.post_id}'>	
								</div>		
								<form action="edit_page.php" method="GET"> 
									<input type="hidden" name="post_id" value='${res.post_id}'> 
									<input class="edit_main" type="submit" name="edit" value="編輯">
							    </form>
						</div>
						<div class="form row">
				  	       <div class="col-lg-12">	
					   			 <form action="new_reply.php" class="childform" method="POST">
									<input class="nickname" name="nickname" type="text" placeholder="暱稱" value='${nickname}'readonly><br>
									<textarea name="content" class="child__input-comments"  placeholder="發表回應"></textarea><br>
									<input type="hidden" name="parent_id" value="${res.post_id}">
									<input class="submit" type="submit" value="送出">
								 </form>
							</div>
						</div>	 		
				  			`);
				  	}
				  }
				});
			});

		});
	</script>
</head>
<body style="background-color: #707C74;">
	 <?php  //判斷是否為登入狀態

		if(isset($_SESSION["user_id"])) {
		  	$login = true;
		  	$get_nick = $conn->prepare("SELECT nickname  FROM users  WHERE user_id=?");
		  	$get_nick->bind_param("i", $_SESSION["user_id"]);
		  	$get_nick->execute();
		  	$nick_result = $get_nick->get_result();
		  	if($nick_result->num_rows > 0) {
		  		$nick_row = $nick_result->fetch_assoc();
		  		$nickname = $nick_row["nickname"];
		  	}
		  	
		 } else {
		  	$login = false;
		  	$nickname = "";
		  	
		 }	
		?>
<div class="container">
	<header>
		<nav class="navbar fixed-top navbar-expand-xl navbar-light" style="background-color: #707C74;">
		  <a class="navbar-brand" style="color: white;">留言版</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNav">  
		     <ul class="navbar-nav">
				<?php
				if($login == false) { 
					echo ' <li class="nav-item">
	    					 <a class="nav-link" href="login.php">登入</a>
	  					   </li>
	  					   <li class="nav-item">
	    					 <a class="nav-link" href="register.php">註冊</a>
	  					   </li>'					    
			    ;}
				?>
				<?php
				if($login == true) {
					echo ' <li class="nav-item">
	    					 <a class="nav-link" href="logout.php">登出</a>
	  					   </li>';}
				?>
			  </ul>
	     </div>
	</nav>	
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
		$count_reply = $conn->prepare("SELECT COUNT(*) as sum FROM comments WHERE parent_id = 0");  //主留言總筆數
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
	?>	
		

	<div class="main_msg form row"> 
	  	<div class="col-lg-12">	
		  <div class="new_reply">
			  <form action="new_reply.php" method="POST">
					<input name="nickname" class="nickname" type="text" placeholder="暱稱"
					<?php //有登入就代入暱稱	  		
					    if(isset($_SESSION["user_id"])) {
					  	echo 'value = "'.$nickname.'"';
					    }
					?> readonly><br>	 
					<textarea name="content" class="comments" placeholder="留言內容"></textarea><br>
					<input type="hidden" name="parent_id" value="0">
				    <input class="btn btn-secondary" type="submit" value="送出">
			  </form>    
			</div>		    	
		</div>					
	</div>								
		

		<?php 
		$showOnPage = "SELECT comments.post_id, comments.user_id, comments.content, users.nickname, users.username, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.user_id WHERE parent_id = 0 ORDER BY created_at DESC LIMIT $start, $per"; //利用join合併兩張table的id，並取到需要的資料
		$result_page = $conn->query($showOnPage) or die($conn->error);
		if ($result_page->num_rows > 0) {
			while($row = $result_page->fetch_assoc()){
				$post_id = $row['post_id']; //抓出主留言的 post id

		?>
	<div class="old_group">			
		<div class="old_reply">	
				<div class='header'>
					  <div class='nickname'><?php echo $row['nickname']?></div>
					  <div class='timestamp'><?php echo $row['created_at']?></div>	
				</div>
				<div class='comments'><?php echo htmlspecialchars($row['content'])?></div>
					 <?php 
					   if ($row['nickname'] === $nickname) { //刪除主留言，只有自己的留言才能刪除
					 ?>
				<div class="delete_comment" data-id='<?php echo $post_id ?>'>
					<input class="btn btn-outline-danger delete_main" type="button" name="delete" value="刪除" data-id='<?php echo $post_id ?>'>	
				</div>		
				<form action="edit_page.php" method="GET"> 
					<input type="hidden" name="post_id" value='<?php echo $post_id ?>'> 
					<input class="btn btn-outline-info edit_main" type="submit" name="edit" value="編輯">
			    </form>
		
				    <?php  	
			 		  }
			 		?>
		</div>	 		
		
				
		<?php					 	  
				 //這邊必須使用 post id 去篩選是對哪個主留言做回應，否則會有子留言重複出現的情況				
				 $childReply = 'SELECT comments.user_id, comments.post_id, comments.content, users.nickname, users.username, comments.created_at FROM comments LEFT JOIN users ON comments.user_id = users.user_id WHERE parent_id = ' . $row['post_id'] . ' ORDER BY created_at DESC'; 	//撈取子留言
	   			 $result_child = $conn->query($childReply) or die($conn->error);
	    		 if ($result_child->num_rows > 0) {
	      			while ($row_child = $result_child->fetch_assoc()) {
	      				$comment_user_id = $row_child['user_id']; //抓出子留言的 user id
	      				if ($row['user_id'] === $comment_user_id ) { //若是在自己留言底下回覆，顯示不同背景色 
	     ?>		
	    <div class="childReply_red row">
	  	     <div class="col-lg-12">
	  	     	<div class="changeColor">
	 	    		<div class='header'>	
			  			<div class='subNickname'><?php echo $row_child['nickname']?></div>
			  			<div class='subTimestamp'><?php echo $row_child['created_at']?></div>
		    		</div>	
	       			<div class='subComments'><?php echo $row_child['content']?></div>
	       				   	<?php 
				 		  		if ($row_child['nickname'] === $nickname) { //刪除子留言，只有自己的留言才能刪除
				 		    ?>
				 	<form class="delete_comment">				
						<input class="btn btn-outline-warning delete_sub" type="button" name="delete" value="刪除" data-id='<?php echo $row_child['post_id']?>'>
					</form>    
					<form action="edit_page.php" method="GET"> 
				 		<input type="hidden" name="post_id" value='<?php echo $row_child['post_id'] ?>'> 
						<input class="btn btn-outline-info edit_child" type="submit" name="edit" value="編輯">
					</form>
					   		<?php  	
				 		  	   }
				 			?>
				 </div>						 
			</div>						  
		</div>

	 					 <?php 
	 					  } else {
						 ?>
		<div class="childReply row">
	  	    <div class="col-lg-12">
		     	<div class='child_reply'>
	 	    		  <div class='header'>	
			  				<div class='subNickname'><?php echo $row_child['nickname']?></div>
			  				<div class='subTimestamp'><?php echo $row_child['created_at']?></div>
		    		  </div>	
	       				   	<div class='subComments'><?php echo $row_child['content']?></div>
	       				   				<?php 
				 		  					if ($row_child['nickname'] === $nickname) { //刪除子留言，只有自己的留言才能刪除
				 						?>
				 		  	<div class="delete_comment">				
							    <input class="delete_sub btn btn-outline-danger" type="button" name="delete" value="刪除" data-id='<?php echo $row_child['post_id'] ?>'>
							</div>    
					     	<form action="edit_page.php" method="GET"> 
				 		  		<input type="hidden" name="post_id" value='<?php echo $row_child['post_id']?>'> 
						   		<input class="btn btn-outline-warning edit_child" type="submit" name="edit" value="編輯">
					      	</form>
					   					 <?php  	
				 		  					}
				 						 ?> 
		 		</div>
		 	</div>			       
		</div>			 		          				 		           				
	 	<?php		 
	 					}						
	       			 };	
	   			  };
	   	?>
	   
	   	<div class="form row">
  	       <div class="col-lg-12">	
	   			 <form action="new_reply.php" class="childform" method="POST">
					<input class="nickname" name="nickname" type="text" placeholder="暱稱" 
		   				<?php //有登入就代入暱稱
				      	if(isset($_SESSION["user_id"])) { echo 'value = "'.$nickname.'"'; } ?>readonly><br>
					<textarea name="content" class="child__input-comments"  placeholder="發表回應"></textarea><br>
					<input type="hidden" name="parent_id" value="<?php echo $row['post_id'] ?>">
					<input class="btn btn-secondary" type="submit" value="送出">
				 </form>
			</div>
		</div>
	</div>	 			  	   			
	    <?php				 
				};
			};	
		?> 	
	 

	    <?php  //換頁功能


		?>		
</div>		
	
</body>
  
</html>