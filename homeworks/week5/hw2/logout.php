<?php
$id = $_COOKIE['id'];
setcookie("id", '');
header('Location: login.php');

?>