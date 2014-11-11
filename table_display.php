<?php
	require_once 'init.php';

	if (!isset($_GET['table'])) {
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = '';
		header("Location: http://$host$uri/$extra");
	}

	$table = $_GET['table'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" /> 
	<title>
		Table : <?php echo $table; ?>
	</title>
		<link rel="stylesheet" type="text/css" href="./main.css">
		<link rel="stylesheet" type="text/css" href="./table_display.css">
		<script type="text/javascript" src="./table_display.js"></script>
</head>
<body>
<div id="wrapper">
		<div id="header-wrapper">
<?php
	include 'navbar.php';
?>
		</div>
		<div id="content-wrapper">
<?php
	
?>			
		</div>
		<div id="footer-wrapper">
<?php 
	include 'footer.php';
?>
		</div>
	</div>
	<script type="text/javascript" src="./main.js"></script>
	<script type="text/javascript">
		var t = Table({
			"table" : <?php echo json_encode($table); ?>
		});
	</script>
<?php 

?>
</body>
</html>