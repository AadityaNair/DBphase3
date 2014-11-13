<?php

$conn = new mysqli ($db_hostname , $db_username , $db_password , $db_databasename);
session_start();

$returnText = array();

if (isset($_POST['show_medicine'])) {  
	$query=$conn->prepare("SELECT `id` , `name` , `cost` , `supplier_id` FROM `Medicine`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$name,$cost,$supplier_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'cost' => $cost,
				'supplier_id' => $supplier_id
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_supplier'])) {  
	$query=$conn->prepare("SELECT `id` , `name` , `phone` , `address` FROM `Supplier`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$name,$phone,$address);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'phone' => $phone,
				'address' => $address
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_inventory'])) {  
	$query=$conn->prepare("SELECT `id` , `medicine_id` , `quantity_left` FROM `Inventory`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$medicine_id,$quantity_left);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'medicine_id' => $medicine_id,
				'quantity_left' => $quantity_left
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_patient'])) {  
	$query=$conn->prepare("SELECT `id` , `name` , `phone` , `address` FROM `Patient`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$name,$phone,$address);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'phone' => $phone,
				'address' => $address
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_patient_contact'])) {  
	$query=$conn->prepare("SELECT `id` , `name` , `phone` , `address` , `patient_id` FROM `Patient_Contact`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$name,$phone,$address,$patient_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'phone' => $phone,
				'address' => $address,
				'patient_id' => $patient_id
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_employee'])) {  
	$query=$conn->prepare("SELECT `id` , `name` , `salary` , `user_id` FROM `Employee`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$name,$salary,$user_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'salary' => $salary,
				'user_id' => $user_id
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_sales'])) {  
	$query=$conn->prepare("");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$cost,$employee_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'cost' => $cost,
				'employee_id' => $employee_id,
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_medicine_sold'])) {  
	$query=$conn->prepare("SELECT `id` , `quantity` , `medicine_id` , `sale_id` FROM `Medicine_Sold`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$quantity,$medicine_id,$sale_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'quantity' => $quantity,
				'medicine_id' => $medicine_id,
				'sale_id' => $sale_id
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_employee_dependent'])) {  
	$query=$conn->prepare("SELECT `id` , `name` , `relation` , `employee_id` FROM `Employee_Dependent`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$name,$relation,$employee_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'relation' => $relation,
				'employee_id' => $employee_id
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

echo json_encode($returnText);
$conn->close();
?>
