<?php

if (isset($_REQUEST['register'])) {
?>

<div id="main">
	<div class="login parent">
	<h2>Register Form</h2>
		<input id="user_id" name="username" placeholder="User Name" type="text">
		<input id="name" name="name" placeholder="Name" type="text">
		<input id="password" name="password" placeholder="Password" type="password">
		<input id="password" name="password" placeholder="Repeat Password" type="password">
		<input name="submit" type="submit" value=" Register " id="button-register">
		<div class="login error" id="error">
		</div>
<a href="./">Login</a>
	</div>
</div>


<?php
} else {
?>

<div id="main">
	<div class="login parent">
	<h2>Login Form</h2>
		<input id="user_id" name="username" placeholder="User Name" type="text">
		<input id="password" name="password" placeholder="**********" type="password">
		<input name="submit" type="submit" value=" Login " id="button-login">
		<div class="login error" id="error">

		</div>
<a href=".?register">Register</a>
	</div>
</div>


<?php 
}
?>
