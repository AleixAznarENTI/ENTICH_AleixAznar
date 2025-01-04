<?php
if (!isset($_POST["input_login_user"]) ||
    !isset($_POST["input_login_pass"])
){
	die("Error 1: Formulario no enviado!");	
}

$raw_user = $_POST["input_login_user"];
if(strlen($raw_user)<4){
	die("Error 2: Usuario muy corto!");
}

$raw_pass = $_POST["input_login_pass"];
if(strlen($raw_pass) < 6){
	die("Error 3: Contraseña muy corta!");
}

$user = addslashes(trim($raw_user));
if($user != $raw_user){
	die("Error 4: Usuario incorrecto!");
}

$pass = addslashes(trim($raw_pass));
if($pass != $raw_pass){
	die("Error 5: Contraseña incorrecta!");
}

$pass = md5($pass);


$query = "SELECT * FROM creators WHERE username='{$user}' AND password='{$pass}'";




$conn = mysqli_connect('localhost', 'entichAdmin', 'enti', 'entich');

$result = mysqli_query($conn,$query);

if(!$result){
    die("Error 6: no hay usuario!");	
}

if(mysqli_num_rows($result) != 1){
	die("Error 6: usuario o contraseña incorrectos!");
}  




$creator = mysqli_fetch_array($result);

session_start();

$_SESSION["id_creator"] = $creator["id_creator"];

header("Location: dashboard.php");
exit();

?>
