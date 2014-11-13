// @Parth Contains all Update queries
// Moved to a separate file to avoid clutter
// Temporary

<?php


if (isset($_POST['update_medicine'])) {  // Update Medicines to Database
    $id=$_POST['id'];
    $medicine_name=$_POST['name']; // Assumed Candidate Key
    $medicine_supplier=$_POST['supplier'];
    $medicine_cost=$_POST['cost'];

    if ($medicine_name==="" or $medicine_supplier==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    // Now the sql
    $query=$conn->prepare("UPDATE `Medicine` SET `supplier`=?, `cost`=?, `name`= ? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful";
    }
    else{
        $query->bind_param("sisd", $medicine_supplier, $medicine_cost, $medicine_name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_supplier'])) {  // Register a new supplier in database
    $id=$_POST['id'];
    $supplier_name=$_POST['name']; // Assumed Candidate Key
    $supplier_phone=$_POST['phone'];
    $supplier_address=$_POST['cost'];

    if ($supplier_name==="" or $supplier_address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    // Now the sql
    $query=$conn->prepare("UPDATE `Supplier` SET `phone`=?, `address`=?, `name`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("sdsd", $supplier_address, $supplier_phone, $supplier_name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_to_inventory'])) {  // Update medicines to inventory.
    $id=$_POST['id'];
    $medicine_id=$_POST['med_id'];
    $quantity_left=$_POST['quantity'];


    //Now the sql
    $query=$conn->prepare("UPDATE `Inventory` SET `quantity_left`=?, `medicine_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("dsd",$quantity_left, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_patients'])) {  // Register Patients
    $id=$_POST['id'];
    $patient_name=$_POST['name'];  // Candidate Key
    $patient_phone=$_POST['phone'];
    $patient_address=$_POST['address'];

    if ($patient_name==="" or $patient_address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }


    // Now the sql
    $query=$conn->prepare("UPDATE `Patients` SET `phone`=?, `address`=?, `name`= ? WHERE `id`=?" );
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("dssd", $patient_phone, $patient_address, $patient_name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_contact'])) {  // Register Patients' Contact
    $id=$_POST['id'];
    $contact_name=$_POST['name']; // Candidate Key
    $contact_phone=$_POST['phone'];
    $contact_address=$_POST['address'];
    $patient_id=$_POST['patient_id'];

    if ($contact_name==="" or $contact_address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }


    // Now the sql
    $query=$conn->prepare("UPDATE `Patient_Contact` SET `phone`=?, `address`=?, `patient_id`=?, `name`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("dsdsd", $contact_phone, $contact_address, $patient_id, $contact_name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_employee'])) {  // Register Employee
    $id=$_POST['id'];
    $name=$_POST['name'];
    $salary=$_POST['salary'];
    if ($name==="" )
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }


    // Now the sql
    $query=$conn->prepare("UPDATE `Employee` SET `salary`=?, `name`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("dsd", $salary, $name, $id)
            $query->execute();
    }
    // Code to link to create links to update_pharmacist / update_doctor
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_sale'])) {  // Register a Sale
    $id=$_POST['id'];
    $employee_id=$_POST['employee'];
    $cost=$_POST['cost'];

    // Now the sql
    $query=$conn->prepare("UPDATE `Sales` SET `cost`=?, `employee_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("ddd", $cost, $employee_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    // Code to link to medicine sold
    exit;
}

if (isset($_POST['medicine_sold'])) {  // Store Medicines Sold
    $id=$_POST['id'];
    $sale_id=$_POST['sale_id'];
    $quantity=$_POST['quantity'];
    $medicine_id=$_POST['medicine_id'];

    // Now the sql
    $query=$conn->prepare("UPDATE `Medicine_Sold` SET `quantity`=?, `medicine_id`=?, `sale_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("dddd", $quantity_left, $medicine_id, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_employee_dependent'])) {  // Update Employees' Contact
    $id=$_POST['id'];
    $dependent_name=$_POST['name'];
    $dependent_phone=$_POST['phone'];
    $dependent_address=$_POST['address'];
    $employee_id=$_POST['employee_id'];
    if ($dependent_name==="" or $dependent_address==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }


    // Now the sql
    $query=$conn->prepare("UPDATE `Employee_Dependent` SET `phone`=?, `address`=?, `employee_id`=?, `name`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("dsdsd", $dependent_phone, $dependent_address, $employee_id, $dependent_name, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_pharmacist'])) {  // Pharmacist Specialisation
    $id=$_POST['id'];
    $employee_id=$_POST['employee_id'];
    $designation=$_POST['designation'];
    $department=$_POST['department'];
    if ($designation==="" or $department==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }


    // Now the sql
    $query=$conn->prepare("UPDATE `Pharmacist` SET `department`=?, `designation`=?, `employee_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("ssdd", $department, $designation, $employee_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_doctor'])) {  // Doctor Specialisation
    $id=$_POST['id'];
    $employee_id=$_POST['employee_id'];
    $designation=$_POST['designation'];
    $department=$_POST['department'];

    if ($designation==="" or $department==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    // Now the sql
    $query=$conn->prepare("UPDATE `Doctor` SET `department`=?, `designation`=?, `employee_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("ssdd", $department, $designation, $employee_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_ayurvedic'])) {  // Ayurvedic
    $id=$_POST['id'];
    $medicine_id=$_POST['medicine_id'];
    $type=$_POST['type'];
    if ($type==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }
    // Now the sql
    $query=$conn->prepare("UPDATE `Ayurvedic` SET `type`=?, `medicine_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("sdd", $type, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_sedative'])) {  // Sedative
    $id=$_POST['id'];
    $medicine_id=$_POST['medicine_id'];
    $type=$_POST['type'];
    if ($type==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    // Now the sql
    $query=$conn->prepare("UPDATE `Sedative` SET `type`=?, `medicine_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("sdd", $type, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_homeopathic'])) {  // Homeopathic
    $id=$_POST['id'];
    $medicine_id=$_POST['medicine_id'];
    $type=$_POST['type'];
    if ($type==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    // Now the sql
    $query=$conn->prepare("UPDATE `Homeopathic` SET `type`=?, `medicine_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("sdd", $type, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}

if (isset($_POST['update_miscellaneous'])) {  // Miscellaneous
    $id=$_POST['id'];
    $medicine_id=$_POST['medicine_id'];
    $type=$_POST['type'];
    if ($type==="")
    {
        echo "Cannot be blank";
        $conn->close();
        exit;
    }

    // Now the sql
    $query=$conn->prepare("UPDATE `Miscellaneous` SET `type`=?, `medicine_id`=? WHERE `id`=? ");
    if (!$query){
        echo "Update Unsuccessful.";
    }
    else{
        $query->bind_param("sdd", $type, $medicine_id, $id);
        $query->execute();
    }
    $query->close();
    $conn->close();
    exit;
}
?>
