// @Parth Contains all Update queries
// Moved to a separate file to avoid clutter
// Temporary

<?php


if (isset($_POST['update_medicine'])) {  // Update Medicines to Database
	$medicine_name=$_POST['name']; // Assumed Candidate Key
	$medicine_supplier=$_POST['supplier'];
	$medicine_cost=$_POST['cost'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Medicine` SET`supplier`=?, `cost`=? WHERE  `name`= ?);
	if (!$query){
		echo "Update Unsuccessful";
	}
	else{
		$query->bind_param("sis", $medicine_supplier, $medicine_cost, $medicine_name);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_supplier'])) {  // Register a new supplier in database
	$supplier_name=$_POST['name']; // Assumed Candidate Key
    $supplier_phone=$_POST['phone];
	$supplier_address=$_POST['cost'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Supplier` SET `phone`=?, `address`=? WHERE `name`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("sds", $supplier_address, $supplier_phone, $supplier_name);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_to_inventory'])) {  // Update medicines to inventory.
	$medicine_id=$_POST['med_id'];
	$quantity_left=$_POST['quantity'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Inventory` SET `quantity_left`=? WHERE `medicine_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("ds",$quantity_left, $medicine_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_patients'])) {  // Register Patients
	$patient_name=$_POST['name'];  // Candidate Key
    $patient_phone=$_POST['phone'];
    $patient_address=$_POST['address'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Patients` SET `phone`=?, `address`=? WHERE `name`= ?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("dss", $patient_phone, $patient_address, $patient_name);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_contact'])) {  // Register Patients' Contact
	$contact_name=$_POST['name']; // Candidate Key
    $contact_phone=$_POST['phone'];
    $contact_address=$_POST['address'];
    $patient_id=$_POST['patient_id'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Patient_Contact` SET `phone`=?, `address`=? WHERE `patient_id`=? AND `name`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("dsds", $contact_phone, $contact_address, $patient_id, $contact_name);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_employee'])) {  // Register Employee
	$name=$_POST['name'];
	$salary=$_POST['salary'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Employee` SET `salary`=? WHERE `name`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
        $query->bind_param("ds", $salary, $name)
		$query->execute();
    }
    // Code to link to create links to update_pharmacist / update_doctor
    $query->close();
	$conn->close();
    exit;
}

if (isset($_POST['update_sale'])) {  // Register a Sale
	$employee_id=$_POST['employee'];
	$cost=$_POST['cost'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Sales` SET `cost`=? WHERE `employee_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("dd", $cost, $employee_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
    // Code to link to medicine sold
	exit;
}

if (isset($_POST['medicine_sold'])) {  // Store Medicines Sold
	$sale_id=$_POST['sale_id'];
    $quantity=$_POST['quantity'];
    $medicine_id=$_POST['medicine_id'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Medicine_Sold` SET `quantity`=? WHERE `medicine_id`=? AND `sale_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("ddd", $quantity_left, $medicine_id, $medicine_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_employee_dependent'])) {  // Update Employees' Contact
	$dependent_name=$_POST['name'];
    $dependent_phone=$_POST['phone'];
    $dependent_address=$_POST['address'];
    $employee_id=$_POST['employee_id'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Employee_Dependent` SET `phone`=?, `address`=? WHERE `employee_id`=? AND `name`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("dsds", $dependent_phone, $dependent_address, $employee_id, $dependent_name);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_pharmacist'])) {  // Pharmacist Specialisation
	$employee_id=$_POST['employee_id'];
    $designation=$_POST['designation'];
    $department=$_POST['department'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Pharmacist` SET `department`=?, `designation`=? WHERE `employee_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("ssd", $department, $designation, $employee_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_doctor'])) {  // Doctor Specialisation
	$employee_id=$_POST['employee_id'];
    $designation=$_POST['designation'];
    $department=$_POST['department'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Doctor` SET `department`=?, `designation`=? WHERE `employee_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("ssd", $department, $designation, $employee_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_ayurvedic'])) {  // Ayurvedic
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Ayurvedic` SET `type`=? WHERE `medicine_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("sd", $type, $medicine_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_sedative'])) {  // Sedative
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Sedative` SET `type`=? WHERE `medicine_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("sd", $type, $medicine_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_homeopathic'])) {  // Homeopathic
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Homeopathic` SET `type`=? WHERE `medicine_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("sd", $type, $medicine_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['update_miscellaneous'])) {  // Miscellaneous
	$medicine_id=$_POST['medicine_id'];
	$type=$_POST['type'];

	// Now the sql
	$query=$conn->prepare("UPDATE `Miscellaneous` SET `type`=? WHERE `medicine_id`=?");
	if (!$query){
		echo "Update Unsuccessful.";
	}
	else{
		$query->bind_param("sd", $type, $medicine_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

?>
