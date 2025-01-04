<?php
if (!isset($_POST["input_name"]) ||
	!isset($_POST["input_user"]) ||
	!isset($_POST["input_pass"]) ||
	!isset($_POST["input_repass"]) ||
	!isset($_POST["input_mail"])){
	die("ERROR 1: Formulario no enviado");	
}



$raw_name = $_POST["input_name"];

if (strlen($raw_name) < 2){
	die("ERROR 2: Nombre demasiado corto");
}


$raw_user = $_POST["input_user"];


if (strlen($raw_user) < 4){
	die("ERROR 3: Nombre de usuario demasiado corto");
}


$raw_pass = $_POST["input_pass"];

if (strlen($raw_pass) < 6){
	die("ERROR 4: Contraseña demasiado corta");
}


$raw_mail = $_POST["input_mail"];


if (strlen($raw_mail) < 6){
	die("ERROR 5: Mail demasiado corto");
}

$mail_temp = addslashes($raw_mail);

if(!filter_var($mail_temp, FILTER_VALIDATE_EMAIL)){
	die("ERROR 5.5: Mail no correcto!");
}



$name_temp = addslashes(trim($raw_name));

if ($name_temp != $raw_name){
	die("ERROR 6: Símbolos encontrados en el nombre");
}


$user_temp = addslashes(trim($raw_user));

if ($user_temp != $raw_user){
	die("ERROR 7: Símbolos encontrados en el usuario");
}


$pass_temp = addslashes(trim($raw_pass));

if ($pass_temp != $raw_pass){
	die("ERROR 8: Símbolos encontrados en la contraseña");
}

$raw_repass = $_POST["input_repass"];

if ($pass_temp != $raw_repass){
	die("ERROR 9: Las contraseñas no coinciden");
}

$pass_temp = md5($pass_temp);

$query = "INSERT INTO creators(name,username,password,email) 
   VALUES('{$name_temp}','{$user_temp}','{$pass_temp}','{$mail_temp}');";

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password,$db_name);

$result = mysqli_query($conn, $query);

if(!$result){
	die("Error 10: No se ha insertado en la base de datos");
}

$id_creator = mysqli_insert_id($conn);

session_start();
$_SESSION["id_creator"] = $id_creator;


header("Location: dashboard.php");

exit();


?>
