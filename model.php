<?php
require 'init.php';
//@Nair : Basically Contains all ajax requests
$returnText = array();


if (isset($_POST['add_medicine'])) {  // Add Medicines to Database
	$medicine_name=$_POST['name'];
	$medicine_supplier=$_POST['supplier'];
	$medicine_cost=$_POST['cost'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Medicine` (`supplier`, `name`, `cost`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ssi", $medicine_supplier, $medicine_name, $medicine_cost);
		$query->execute();
	}
}

if (isset($_POST['add_supplier'])) {  // Register a new supplier in database
	$supplier_name=$_POST['name'];
	$supplier_phone=$_POST['supplier'];
	$supplier_address=$_POST['cost'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Supplier` (`address`, `name`, `phone`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ssd", $supplier_address, $supplier_name, $supplier_phone);
		$query->execute();
	}
}

if (isset($_POST['add_to_inventory'])) {  // Add medicines to inventory.
	$medicine_id=$_POST['med_id'];
	$quantity_left=$_POST['quantity'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Inventory` (`medicine_id`, `quantity_left`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sd", $medicine_id, $quantity_left);
		$query->execute();
	}
}

if (isset($_POST['add_patients'])) {  // Register Patients
	$patient_name=$_POST['name'];
    $patient_phone=$_POST['phone'];
    $patient_address=$_POST['address'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Patients` (`name`, `phone`, `address`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sds", $patient_name, $patient_phone, $patient_address);
		$query->execute();
	}
}

if (isset($_POST['add_contact'])) {  // Register Patients' Contact
	$contact_name=$_POST['name'];
    $contact_phone=$_POST['phone'];
    $contact_address=$_POST['address'];
    $patient_id=$_POST['patient_id'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Inventory` (`name`, `phone`, `address`, `patient_id`) VALUES (?, ?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sdsd", $contact_name, $contact_phone, $contact_address, $patient_id);
		$query->execute();
	}
}

if (isset($_POST['add_employee'])) {  // Register Employee
	$name=$_POST['name'];
	$salary=$_POST['salary'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Employee` (`name`, `salary`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sd", $name, $salary);
		$query->execute();
    }
    // Code to link to create links to add_pharmacist / add_doctor
}

if (isset($_POST['add_sale'])) {  // Register a Sale
	$employee_id=$_POST['employee'];
	$cost=$_POST['cost'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Sales` (`employee_id`, `cost`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("dd", $employee_id, $cost);
		$query->execute();
	}
}

if (isset($_POST['medicine_sold'])) {  // Store Medicines Sold
	$sale_id=$_POST['sale_id'];
    $quantity=$_POST['quantity'];
    $medicine_id=$_POST['medicine_id'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Medicine_Sold` (`medicine_id`, `quantity`, `medicine_id`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ddd", $medicine_id, $quantity_left, $medicine_id);
		$query->execute();
	}
}

if (isset($_POST['add_employee_dependent'])) {  // Register Employees' Contact
	$dependent_name=$_POST['name'];
    $dependent_phone=$_POST['phone'];
    $dependent_address=$_POST['address'];
    $employee_id=$_POST['employee_id'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Employee_Dependent` (`name`, `phone`, `address`, `employee_id`) VALUES (?, ?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sdsd", $dependent_name, $dependent_phone, $dependent_address, $employee_id);
		$query->execute();
	}
}

if (isset($_POST['pharmacist'])) {  // Pharmacist Specialisation
	$employee_id=$_POST['employee_id'];
    $designation=$_POST['designation'];
    $department=$_POST['department'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Pharmacist` (`department`, `designation`, `employee_id`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ssd", $department, $designation, $employee_id);
		$query->execute();
	}
}

if (isset($_POST['doctor'])) {  // Doctor Specialisation
	$employee_id=$_POST['employee_id'];
    $designation=$_POST['designation'];
    $department=$_POST['department'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Doctor` (`department`, `designation`, `employee_id`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ssd", $department, $designation, $employee_id);
		$query->execute();
	}
}

if (isset($_POST['ayurvedic'])) {  // Ayurvedic
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Ayurvedic` (`medicine_id`, `type`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("dd", $medicine_id, $type);
		$query->execute();
	}
}

if (isset($_POST['Sedative'])) {  // Sedative
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Sedative` (`medicine_id`, `type`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("dd", $medicine_id, $type);
		$query->execute();
	}
}

if (isset($_POST['Homeopathic'])) {  // Homeopathic
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Homeopathic` (`medicine_id`, `type`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("dd", $medicine_id, $type);
		$query->execute();
	}
}

if (isset($_POST['Miscellaneous'])) {  // Miscellaneous
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("INSERT INTO `Miscellaneous` (`medicine_id`, `type`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("dd", $medicine_id, $type);
		$query->execute();
	}
}


if (isset($_SESSION['admin'])) {
	if (isset($_POST['key'])) {
		// Admin-Level do Something
	}
}

if (isset($_GET['key'])) {
    // do Something Insecure
    // Live life dangerously
}

// Admin-Level Get is not Allowed.

echo json_encode($returnText);
?>
