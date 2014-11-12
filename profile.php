<h1>
<?php
echo "Welcome " . $_SESSION['user'];
?>
</h1>

<div class="table-list parent">
<?php 
	if (isset($_SESSION['admin'])) {
?>
	<div class="table-list child" id="Supplier">
		Supplier 
	</div>
	<div class="table-list child" id="Medicine">
		Medicine 
	</div>	
	<div class="table-list child" id="Inventory">
		Inventory 
	</div>	
	<div class="table-list child" id="Patient">
		Patient 
	</div>
	<div class="table-list child" id="Patient_Contact">
		Patient Contact 
	</div>
	<div class="table-list child" id="Employee">
		Employee 
	</div>	
	<div class="table-list child" id="Sales">
		Sales 
	</div>	
	<div class="table-list child" id="Medicine_Sold">
		Medicine Sold 
	</div>
	<div class="table-list child" id="Employee_Dependent">
		Employee Dependent 
	</div>
	<div class="table-list child" id="Users">
		Users 
	</div>
	<div class="table-list child" id="Admins">
		Admins 
	</div>
<?php 
	} else {
?>
	<div class="table-list child" id="Supplier">
		Supplier 
	</div>
	<div class="table-list child" id="Medicine">
		Medicine 
	</div>	
	<div class="table-list child" id="Patient">
		Patient 
	</div>
	<div class="table-list child" id="Patient_Contact">
		Patient Contact 
	</div>
<?php
	}
?>
</div>
