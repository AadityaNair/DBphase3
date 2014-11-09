<?php
require 'init.php';
//@Nair : Basically Contains all ajax requests
$returnText = array();

if (isset($_POST['key'])) {
	// do Something
}

if (isset($_SESSION['admin'])) {
	if (isset($_POST['key'])) {
		// Admin-Level do Something
	}
}

if (isset($_GET['key'])) {
	// do Something Insecure
}

// Admin-Level Get is not Allowed.

echo json_encode($returnText);
?>
