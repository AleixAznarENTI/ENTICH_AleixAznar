<?php
	session_start();
	if(!isset($_SESSION["id_creator"])){
		header("Location: login.php");
		exit();
	}

	if(!isset($_POST["name"])	||
	   !isset($_POST["user"]) ||
	   !isset($_POST["mail"]) ||
	   !isset($_POST["image"]) ||
	   !isset($_POST["description"])){
		
		die("ERROR 1: Formulario no enviado!");
	   }	

	$raw_name = $_POST["name"];
	if(strlen($raw_name)<2){
		die("ERROR 2: Nombre demasiado corto.");
	}

	$raw_user = $_POST["user"];
	if(strlen($raw_user)<4){
		die("ERROR 3: Nombre de usuario demasiado corto.");
	}

	$raw_mail = $_POST["mail"];
	if(strlen($raw_mail) < 6){
		die("ERROR 4: Mail demasiado corto.");
	}

	$raw_desc = $_POST["description"];
	$desc_temp = addslashes($raw_desc);
	if($raw_desc != $desc_temp){
		die("ERROR 5: Descripción demasiado corta.");
	}
	
	$mail_temp = addslashes($raw_mail);
	if(!filter_var($mail_temp, FILTER_VALIDATE_EMAIL)){
		die("ERROR 5.5: Mail no correcto!");
	}

	$name_temp = addslashes(trim($raw_name));
	if($name_temp != $raw_name){
		die("ERROR 6: Símbolos encontrados en el nombre!");
	}

	$user_temp = addslashes(trim($raw_user));
	if($user_temp != $raw_user){
		die("ERROR 7: Símbolos encontrados en el usuario!");
	}
	
	$query = "UPDATE creators SET name = '{$name_temp}', username = '{$user_temp}', email = '{$mail_temp}', description = '{$desc_temp}' WHERE id_creator = {$_SESSION["id_creator"]};";

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$result = mysqli_query($conn, $query);

if(!$result){
	die("ERROR 10: No se ha insertado en la base de datos");
}

header("Location: dashboard.php");
exit();


?>
