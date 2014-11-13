<?php
require_once 'debug.php';
require_once 'config.php';
require_once 'pbkdf2.php';

$conn = new mysqli ($db_hostname , $db_username , $db_password , $db_databasename);
session_start();

if (!isset($_SESSION['admin'])) {
	$query = $conn->prepare("SELECT `id` FROM `Admins` WHERE `user_id` = (SELECT `id` FROM `Users` WHERE `user_id` = ? LIMIT 1)");
	$query->bind_param("s" , $_SESSION['user']);
	$query->execute();
	$query->bind_result($id);
	if ($id) {
		$_SESSION['admin'] = $_SESSION['user'];
	}
	$query->close();
}

if (isset($_REQUEST['logout'])) {
	session_destroy();
	$host = $_SERVER['HTTP_HOST'];
	$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = '';
	header("Location: http://$host$uri/$extra");
}
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
	$query->close();
	$conn->close();
	exit;
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
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_inventory'])) {  // Add medicines to inventory.
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
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_patient'])) {  // Register Patients
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
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_patient_contact'])) {  // Register Patients' Contact
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
	$query->close();
	$conn->close();
	exit;
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
    $query->close();
	$conn->close();
    exit;
}

if (isset($_POST['add_sales'])) {  // Register a Sale
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
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_medicine_sold'])) {  // Store Medicines Sold
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
	$query->close();
	$conn->close();
	exit;
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
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['login_request'])) {
	$user_id  = $_POST['user_id'];
	$password = $_POST['password'];

	if ($user_id === "" or $password === "") {
		echo "Cannot Be Blank";
		$conn->close();
		exit;
	}

	$query = $conn->prepare("SELECT `id` , `password_hash` , `password_salt` FROM `Users` WHERE `user_id` = ? LIMIT 1");
	if (!$query) {
		echo "Unsuccessful";	
	} else {
		$query->bind_param("s", $user_id);
		$query->execute();
		$query->bind_result($id,$password_hash,$password_salt);
		$query->fetch();
		if (!$id) {
			echo "Invalid Username or Password";
			$query->close();
			$conn->close();
			exit;
		} else {
			$pbkdf2_password = PBKDF2_HASH_ALGORITHM.":".PBKDF2_ITERATIONS.":"."$password_salt:$password_hash";
			if (validate_password("$password" , "$pbkdf2_password")) {
				$_SESSION['user'] = $user_id;
				echo "Login Sucessfull";
			} else {
				echo "Invalid Username or Password";
				$query->close();
				$conn->close();
				exit;
			}
		}
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['register_request'])) {
	$user_id  = $_POST['user_id'];
	$password = $_POST['password'];
	$name = $_POST['name'];

	if ($user_id === "" or $password === "" or $name == "") {
		echo "Cannot Be Blank";
		$conn->close();
		exit;
	}

	$query = $conn->prepare("SELECT `id` FROM `Users` WHERE `user_id` = ? LIMIT 1");
	if (!$query) {
		echo "Unsuccessful";	
	} else {
		$query->bind_param("s", $user_id);
		$query->execute();
		$query->bind_result($id);
		$query->fetch();
		$query->close();
		if ($id) {
			echo "Already Exists";
			$conn->close();
			exit;
		} else {
			$pbkdf2_password = create_hash($password);
			$password_hash = explode(":", $pbkdf2_password)[HASH_PBKDF2_INDEX];
			$password_salt = explode(":", $pbkdf2_password)[HASH_SALT_INDEX];

			$query = $conn->prepare("INSERT INTO `Users` (`password_hash`, `password_salt` , `user_id` , `name`) VALUES ( ? , ? , ? , ? )");
			if (!$query) {
				echo "Unsuccessful";
			} else {
				$query->bind_param("ssss" , $password_hash , $password_salt , $user_id , $name);
				$query->execute();
				echo "Registeration Sucessfull";
			}
		}
	}
	$query->close();
	$conn->close();
	exit;	
}

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
				'cost' => $cost,
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

if (isset($_POST['show_patient_expanded'])) {  
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

if (isset($_POST['show_patient_contact_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT PC.id AS id , PC.name AS name , PC.phone AS phone , P.name AS patient_name , P.phone AS patient_phone , P.address AS patient_address , PC.address AS address FROM `Patient_Contact` AS PC , `Patient` AS P WHERE PC.patient_id = P.id LIMIT 100 OFFSET ?");
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

if (isset($_POST['show_sales_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT S.id AS id , S.cost AS cost , E.name AS employee_name , E.id AS employee_user_id FROM `Sales` AS S , `Employee` AS E WHERE E.id = S.employee_id LIMIT 100 OFFSET ?");
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

if (isset($_POST['show_medicine_sold_expanded'])) {  
	
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

	$query=$conn->prepare("SELECT ED.id AS id , ED.name AS name , ED.relation AS relation , E.name AS employee_name , E.user_id AS employee_user_id FROM `Employee_Dependent` AS ED , `Employee` AS E WHERE E.id = ED.employee_id LIMIT 100 OFFSET ?");
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

if (isset($_POST['show_users_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT `id` , `user_id` , `password_hash` , `password_salt` FROM `Users` LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$user_id,$password_hash,$password_salt);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'user_id' => $user_id,
				'password_hash' => $password_hash,
				'password_salt' => $password_salt
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_admins_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT A.id AS id , U.user_id AS user_user_id , U.password_hash AS user_password_hash , U.password_salt AS user_password_salt FROM `Users` AS U , `Admins` AS A WHERE A.user_id = U.id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$user_user_id,$user_password_hash,$user_password_salt);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'user_user_id' => $user_user_id,
				'user_password_hash' => $user_password_hash,
				'user_password_salt' => $user_password_salt
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_SESSION['admin'])) {
	if (isset($_POST['key'])) {
		// Admin-Level do Something
	}
}

echo json_encode($returnText);
$conn->close();
?>
