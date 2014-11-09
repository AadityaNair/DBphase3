<?php
require 'debug.php';
require 'config.php';
$conn = new mysqli ($db_hostname , $db_username , $db_password , $db_databasename);
session_start();
if (!isset($_SESSION['user'])) {
	$_SESSION['user'] = "foobar";
}
if (!isset($_SESSION['admin'])) {
	$query = $conn->prepare("SELECT `id` FROM `Admins` WHERE `user_id` = (SELECT `id` FROM `Users` WHERE `user_id` = ? LIMIT 1)");
	$query->bind_param("s" , $_SESSION['user']);
	$query->execute();
	$query->bind_result($id);
	if ($id) {
		$_SESSION['admin'] = $_SESSION['user'];
	}
}
if (isset($_REQUEST['logout'])) {
	session_destroy();
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = '';
	header("Location: http://$host$uri/$extra");
}

?>
