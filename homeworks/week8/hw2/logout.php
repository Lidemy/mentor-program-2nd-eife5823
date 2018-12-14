<?php
require_once('conn.php');
session_start();
unset($_SESSION["user_id"]); // 單獨刪除該筆紀錄
session_destroy(); // 將爭在使用中的全部 session 清除
header('Location: login.php');
?>