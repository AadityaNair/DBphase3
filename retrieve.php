// @Nair Contains all show queries
// Moved to a separate file to avoid clutter
// Temporary

<?php


if (isset($_POST['show_medicine_expanded'])) {  // show Medicines to Database
	$offset = (int) $_POST['offset'] or 0;
	$query=$conn->prepare("SELECT M.id AS id , M.name AS name , M.cost AS cost , S.name AS supplier_name , S.phone AS supplier_phone , S.address AS supplier_address FROM `Medicine` AS M , `Supplier` AS S WHERE S.id = M.supplier LIMIT 100 OFFSET ?");
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_supplier_expanded'])) {  // Register a new supplier in database
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_inventory_expanded'])) {  // show medicines to inventory.
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_patients'])) {  // Register Patients
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_contact'])) {  // Register Patients' Contact
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_employee'])) {  // Register Employee
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_sale'])) {  // Register a Sale
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['medicine_sold'])) {  // Store Medicines Sold
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_employee_dependent'])) {  // show Employees' Contact
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_pharmacist'])) {  // Pharmacist Specialisation
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_doctor'])) {  // Doctor Specialisation
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_ayurvedic'])) {  // Ayurvedic
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_sedative'])) {  // Sedative
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_homeopathic'])) {  // Homeopathic
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

if (isset($_POST['show_miscellaneous'])) {  // Miscellaneous
	$offset = (int) $_POST['offset'] or 0;
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
			array_push(return_text, return_text_item);
		}
	}
	$query->close();
	$conn->close();
	echo json_encode($return_text);
	exit;
}

?>
