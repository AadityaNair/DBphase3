<?php

$conn = new mysqli_connect("localhost" , "root" , "saphira" , "db");

if (isset($_POST['delete_medicine'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Medicine` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_supplier'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Supplier` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_inventory'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Inventory` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_patient'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Patient` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_patient_contact'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Patient_Contact` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_employee'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Employee` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_sales'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Sales` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_medicine_sold'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Medicine_Sold` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_employee_dependent'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Employee_Dependent` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_users'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Users` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['delete_admins'])) {  
	if (!isset($id) or $_POST['id'] === "") {
		$conn->close();
		exit;
	}
	$id = (int) $_POST['id'];
	$query=$conn->prepare("DELETE FROM `Admins` WHERE `id` = ?");
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("i", $id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

?>
