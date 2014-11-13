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

if (isset($_POST['add_medicine'])) {  
	$name=$_POST['name'];
	$supplier_id=$_POST['supplier_id'];
	$cost=$_POST['cost'];

	
	$query=$conn->prepare("INSERT INTO `Medicine` (`supplier_id`, `name`, `cost`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ssi", $supplier_id, $name, $cost);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_supplier'])) {  
	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];

	
	$query=$conn->prepare("INSERT INTO `Supplier` (`address`, `name`, `phone`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ssi", $address, $name, $phone);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_inventory'])) {  
	$medicine_id=$_POST['medicine_id'];
	$quantity_left=$_POST['quantity_left'];

	
	$query=$conn->prepare("INSERT INTO `Inventory` (`medicine_id`, `quantity_left`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("si", $medicine_id, $quantity_left);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_patient'])) {  
	$name=$_POST['name'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];

	
	$query=$conn->prepare("INSERT INTO `Patients` (`name`, `phone`, `address`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sis", $name, $phone, $address);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_patient_contact'])) {  
	$name=$_POST['name'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $patient_id=$_POST['patient_id'];

	
	$query=$conn->prepare("INSERT INTO `Inventory` (`name`, `phone`, `address`, `patient_id`) VALUES (?, ?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sisi", $name, $phone, $address, $patient_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_employee'])) {  
	$name=$_POST['name'];
	$salary=$_POST['salary'];
	
	$query=$conn->prepare("INSERT INTO `Employee` (`name`, `salary`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("si", $name, $salary);
		$query->execute();
    }
    
    $query->close();
	$conn->close();
    exit;
}

if (isset($_POST['add_sales'])) {  
	$employee_id=$_POST['employee'];
	$cost=$_POST['cost'];

	
	$query=$conn->prepare("INSERT INTO `Sales` (`employee_id`, `cost`) VALUES (?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("ii", $employee_id, $cost);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_medicine_sold'])) {  
	$sale_id=$_POST['sale_id'];
    $quantity=$_POST['quantity'];
    $medicine_id=$_POST['medicine_id'];

	
	$query=$conn->prepare("INSERT INTO `Medicine_Sold` (`medicine_id`, `quantity`, `sale_id`) VALUES (?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("iii", $medicine_id, $quantity_left, $sale_id);
		$query->execute();
	}
	$query->close();
	$conn->close();
	exit;
}

if (isset($_POST['add_employee_dependent'])) {  
	$name=$_POST['name'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $employee_id=$_POST['employee_id'];

	
	$query=$conn->prepare("INSERT INTO `Employee_Dependent` (`name`, `phone`, `address`, `employee_id`) VALUES (?, ?, ?, ?)");
	if (!$query){
		echo "Insert Unsuccessful.";
	}
	else{
		$query->bind_param("sisi", $name, $phone, $address, $employee_id);
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

	if ($user_id === "" or $password === "") {
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

			$query = $conn->prepare("INSERT INTO `Users` (`password_hash`, `password_salt` , `user_id` ) VALUES ( ? , ? , ? )");
			if (!$query) {
				echo "Unsuccessful";
			} else {
				$query->bind_param("sss" , $password_hash , $password_salt , $user_id );
				$query->execute();
				echo "Registeration Sucessfull";
			}
		}
	}
	$conn->close();
	exit;	
}

if (isset($_POST['show_medicine_expanded'])) {  
	if (isset($_POST['offset']))
		$offset = (int) $_POST['offset'];
	else 
		$offset = 0;

	$query=$conn->prepare("SELECT M.id AS id , M.name AS name , M.cost AS cost , S.name AS supplier_name , S.phone AS supplier_phone , S.address AS supplier_address FROM `Medicine` AS M , `Supplier` AS S WHERE S.id = M.supplier_id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$name,$cost,$supplier_name,$supplier_phone,$supplier_address);
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

	$query=$conn->prepare("SELECT I.id AS id , MS.medicine_name AS medicine_name , MS.medicine_cost AS medicine_cost , MS.supplier_name AS supplier_name , MS.supplier_phone AS supplier_phone , MS.supplier_address AS supplier_address FROM `Inventory` AS I , (SELECT M.id AS medicine_id , M.name AS medicine_name , M.cost AS medicine_cost , S.name AS supplier_name , S.phone AS supplier_phone , S.address AS supplier_address FROM `Medicine` AS M , `Supplier` AS S WHERE S.id = M.supplier_id) AS MS WHERE MS.medicine_id = I.medicine_id LIMIT 100 OFFSET ?");
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

	$query=$conn->prepare("SELECT S.id AS id , S.cost AS cost , E.name AS employee_name FROM `Sales` AS S , `Employee` AS E WHERE E.id = S.employee_id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$cost,$employee_name);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'cost' => $cost,
				'employee_name' => $employee_name,
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

	$query=$conn->prepare("SELECT ED.id AS id , ED.name AS name , ED.relation AS relation , E.name AS employee_name FROM `Employee_Dependent` AS ED , `Employee` AS E WHERE E.id = ED.employee_id LIMIT 100 OFFSET ?");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->bind_param("i", $offset);
		$query->execute();
		$query->bind_result($id,$name,$relation,$employee_name);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'name' => $name,
				'relation' => $relation,
				'employee_name' => $employee_name,
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
	$query=$conn->prepare("SELECT `id` , `cost` , `employee_id` FROM `Sales`");
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

if (isset($_POST['show_users'])) {  
	$query=$conn->prepare("SELECT `id` , `user_id` , `password_hash` , `password_salt` FROM `Users`");
	if (!$query){
		echo "Failed";
	}
	else{
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

if (isset($_POST['show_admins'])) {  
	$query=$conn->prepare("SELECT `id` , `user_id` FROM `Admins`");
	if (!$query){
		echo "Failed";
	}
	else{
		$query->execute();
		$query->bind_result($id,$user_id);
		$return_text = array();
		while ($query->fetch()) {
			$return_text_item = array(
				'id' => $id,
				'user_id' => $user_id,
			);
			array_push($return_text, $return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['delete_medicine'])) {  
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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
	if (!isset($_POST['id']) or $_POST['id'] === "") {
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

if (isset($_POST['update_medicine'])) {  
    $id=$_POST['id'];
    $name=$_POST['name']; 
    $supplier_id=$_POST['supplier_id'];
    $cost=$_POST['cost'];

    if ($name==="" or $supplier==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }
    
    $query=$conn->prepare("UPDATE `Medicine` SET `supplier_id`=?, `cost`=?, `name`= ? WHERE `id`= ? ");
    if (!$query){
        echo "Update Unsuccessful";
    }
    else{
        $query->bind_param("sisi", $supplier_id, $cost, $name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_supplier'])) {  
    $id=$_POST['id'];
    $name=$_POST['name']; 
    $phone=$_POST['phone'];
    $address=$_POST['address'];

    if ($name==="" or $address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }
    
    $query=$conn->prepare("UPDATE `Supplier` SET `phone`=?, `address`=?, `name`=? WHERE `id`= ?");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("issi", $phone, $address, $name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_inventory'])) {  
    $id=$_POST['id'];
    $medicine_id=$_POST['medicine_id'];
    $quantity_left=$_POST['quantity_left'];

    $query=$conn->prepare("UPDATE `Inventory` SET `quantity_left`=?, `medicine_id`=? WHERE `id` = ? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("iii",$quantity_left, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_patient'])) {  
    $id=$_POST['id'];
    $name=$_POST['name'];  
    $phone=$_POST['phone'];
    $address=$_POST['address'];

    if ($name==="" or $address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    $query=$conn->prepare("UPDATE `Patient` SET `phone`=?, `address`=?, `name`= ? WHERE `id`=?" );
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("issi", $phone, $address, $name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_contact'])) {  
    $id=$_POST['id'];
    $name=$_POST['name']; 
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $patient_id=$_POST['patient_id'];

    if ($name==="" or $address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }
    
    $query=$conn->prepare("UPDATE `Patient_Contact` SET `phone`=?, `address`=?, `patient_id`=?, `name`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("isisi", $phone, $address, $patient_id, $name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_employee'])) {  
    $id=$_POST['id'];
    $name=$_POST['name'];
    $salary=$_POST['salary'];
    if ($name==="" )
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    $query=$conn->prepare("UPDATE `Employee` SET `salary`=?, `name`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("isi", $salary, $name, $id);
        $query->execute();
    }
    
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_sales'])) {  
    $id=$_POST['id'];
    $employee_id=$_POST['employee_id'];
    $cost=$_POST['cost'];
    
    $query=$conn->prepare("UPDATE `Sales` SET `cost`=?, `employee_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("iii", $cost, $employee_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    
    exit;
}

if (isset($_POST['update_medicine_sold'])) {  
    $id=$_POST['id'];
    $sale_id=$_POST['sale_id'];
    $quantity=$_POST['quantity'];
    $medicine_id=$_POST['medicine_id'];

    $query=$conn->prepare("UPDATE `Medicine_Sold` SET `quantity`=?, `medicine_id`=?, `sale_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("iiii", $quantity_left, $medicine_id, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_employee_dependent'])) {  
    $id=$_POST['id'];
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $employee_id=$_POST['employee_id'];
    if ($name==="" or $address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }
    
    $query=$conn->prepare("UPDATE `Employee_Dependent` SET `phone`=?, `address`=?, `employee_id`=?, `name`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("isisi", $phone, $address, $employee_id, $name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_SESSION['admin'])) {
	if (isset($_POST['key'])) {
		
	}
}

echo json_encode($returnText);
$conn->close();
?>
