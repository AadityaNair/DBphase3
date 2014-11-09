<?php
require 'config.php';
//@Nair : Meant to be inserted as require in the top of everyfile.
$link = new mysqli ($db_hostname , $db_username , $db_password , $db_databasename);
session_start();
if (!isset($_SESSION['user'])) {
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = '';
	header("Location: http://$host$uri/$extra");
}
if (!isset($_SESSION['admin'])) {
	$query = $conn->prepare("SELECT `id` FROM `Admins` WHERE `username` = ?");
	$query->bind_param("s" , $_SESSION['user']);
	$query->execute();
	$query->bind_result($id);
	if ($id) {
		$_SESSION['admin'] = $_SESSION['user'];
	}
}
header('Content-Type: text/html; charset=utf-8');
?>
