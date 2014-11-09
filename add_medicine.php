<?php
    require 'debug.php '
    require 'config.php'
    $conn= new mysqli ($db_hostname, $db_username, $db_password, $db_databasename)

    // Get all data via POST
    $medicine_name=$_POST['name'];
    $medicine_supplier=$_POST['supplier'];
    $medicine_cost=$_POST['cost'];

    // Now the sql
    $query=$conn->prepare("INSERT INTO `Medicine` (`supplier`, `name`, `cost`) VALUES (?, ?, ?)");

    $query->bind_param("ssi", $medicine_supplier, $medicine_name, $medicine_cost);
    $query->execute();
    $query->bind_result($ret);

    if (!$ret){
        echo "Insert Unsuccessful.";
    }
?>
