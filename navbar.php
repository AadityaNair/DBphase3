<div id="navbar-wrapper" class="navbar parent">
	<div class="navbar child navbar-fixed " id="button-home">
		Home
	</div>
	<div class="navbar child navbar-fixed " id="button-report">
		Report
	</div>
<?php
	if (isset($_SESSION['admin'])) {
?>
	<div class="navbar child navbar-fixed " id="button-admin">
		Admin
	</div>
<?php
	}
?>
	<div class="navbar child navbar-fixed right" id="button-logout">
		Logout
	</div>
</div>