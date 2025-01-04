<?php
session_start();
if(isset($_SESSION["id_creator"])){
	header("Location: dashboard.php");
	exit();
}
require_once("template.php");
printHead("ENTIch: Login");
openBody("Inicio de Sesión");
echo <<<EOD
<form method="POST" action="login_check.php">
<p><label for ="login_user">Username:</label> <input type="text" id="login_user" name="input_login_user" required></p>
<p><label for ="login_pass">Password:</label> <input type="password" id="login_pass" name="input_login_pass" required></p>
<p><input type="submit" name="login_submit" id="input_login_submit" value="Submit"></p>
</form>

<form method="POST" action="register_check.php">
<p><label for="register_name">Name:</label> <input type="text" id="register_name" name="input_name" required></p>
<p><label for="register_user">User Name:</label> <input type="text" id="register_user" name="input_user" required></p>
<p><label for="register_pass">Pass:</laber> <input type="password" id="register_pass" name="input_pass" required></p>
<p><label for="register_repass">Repass:</label> <input type="password" id="register_repass" name="input_repass" required></p>
<p><label for="register_mail">Mail:</label> <input type="email" id="register_mail" name="input_mail" required></p>
<p><input type="submit" name="register_submit" id="input_submit" value="Submit"></p>
</form>


EOD;
closeBody();

?>
