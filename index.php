<?php
require_once 'debug.php';
require_once 'config.php';

$conn = new mysqli ($db_hostname , $db_username , $db_password , $db_databasename);
session_start();
if (!isset($_SESSION['admin'])) {
	$query = $conn->prepare("SELECT `id` FROM `Admins` WHERE `user_id` = (SELECT `id` FROM `Users` WHERE `user_id` = ? LIMIT 1)");
	$query->bind_param("s" , $_SESSION['user']);
	$query->execute();
	$query->bind_result($id);
	$query->fetch();
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Doctors</title>
	<link rel="stylesheet" type="text/css" href="./main.css">
</head>
<body>
	<div id="wrapper">
		<div id="header-wrapper">
<?php
	if (isset($_SESSION['user'])) {
		include 'navbar.php';
	}
?>
		</div>
		<div id="content-wrapper">
<?php
	if (!isset($_SESSION['user'])) {
		include 'login.php';
	} else {
		include 'profile.php';
	}
?>			
		</div>
		<div id="footer-wrapper">
<?php 
	include 'footer.php';
?>
		</div>
	</div>
	<script type="text/javascript" src="./main.js"></script>
<?php 
	if (!isset($_SESSION['user'])) {
?>
	<script type="text/javascript" src="./login.js"></script>
<?php
	}
?>
</body>
</html>
