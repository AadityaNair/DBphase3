<?php

// @Nair : Temp. 
// Temporary

require 'init.php'; 

if (isset($_POST['show_medicine_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT M.id AS id , M.name AS name , M.cost AS cost , S.name AS supplier_name , S.phone AS supplier_phone , S.address AS supplier_address FROM Medicine AS M , Supplier AS S WHERE S.id = M.supplier LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$supplier_name,$supplier_phone,$supplier_address,$name,$cost);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'cost' => $cost
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_supplier_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT `id` , `name` , `phone` , `address` FROM `Supplier` LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
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

if (isset($_POST['show_inventory_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT I.id AS id , MS.medicine_name AS medicine_name , MS.medicine_cost AS medicine_cost , MS.supplier_name AS supplier_name , MS.supplier_phone AS supplier_phone , MS.supplier_address AS supplier_address FROM `Inventory` AS I , (SELECT M.id AS medicine_id , M.name AS medicine_name , M.cost AS medicine_cost , S.name AS supplier_name , S.phone AS supplier_phone , S.address AS supplier_address FROM `Medicine` AS M , `Supplier` AS S WHERE S.id = M.supplier) AS MS WHERE MS.medicine_id = I.medicine_id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$medicine_name,$medicine_cost,$supplier_name,$supplier_phone,$supplier_address);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'medicine_name' => $medicine_name,
				'medicine_cost' => $medicine_cost,
				'supplier_name' => $supplier_name,
				'supplier_phone' => $supplier_phone,
				'supplier_address' => $supplier_address
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_patients_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT `id` , `name` , `phone` , `address` FROM `Patient` LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$name,$phone,$address);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'$phone' => $phone,
				'$address' => $address
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_patient_contact_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT PC.id AS id , PC.name AS name , PC.phone AS phone , P.name AS patient_name , P.phone AS patient_phone , P.address AS patient_address , PC.address AS address FROM `Patient_Contact` AS P , `Patient` AS P WHERE PC.patient_id = P.id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$name,$phone,$patient_name,$patient_phone,$patient_address,$address);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'phone' => $phone,
				'patient_name' => $patient_name,
				'patient_phone' => $patient_phone,
				'patient_address' => $patient_address,
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

if (isset($_POST['show_employee_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT `id` , `name` , `salary` , `user_id` FROM `Employee` LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
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

if (isset($_POST['show_sale_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT S.id AS id , S.cost AS cost , E.name AS employee_name , E.user_id AS employee_user_id FROM `Sales` AS S , `Employee` AS E WHERE E.id = S.employee_id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$cost,$employee_name,$employee_user_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'cost' => $cost,
				'employee_name' => $employee_name,
				'employee_user_id' => $employee_user_id
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['medicine_sold_expanded'])) {  
	
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result();
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,

			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_employee_dependent_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT ED.id AS id , ED.name AS name , ED.relation AS relation , E.name AS employee_name , E.user_id AS employee_user_id FROM `Employee_Depednent` AS ED , `Employee` AS E WHERE E.id = ED.employee_id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$name,$relation,$employee_name,$employee_user_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'relation' => $relation,
				'$employee_name' => $employee_name,
				'employee_user_id' => $employee_user_id
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

echo "[]";
$conn->close();
?>