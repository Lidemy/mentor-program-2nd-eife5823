<?php
setcookie("session_id", '', time()+3600*24);
header('Location: login.php');

?>