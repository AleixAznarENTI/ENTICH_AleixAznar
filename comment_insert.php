<?php
session_start();
if(!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

if(!isset($_POST["id_game"]) ||
   !isset($_POST["comment"])){
	die("ERROR 1: Formulario no bien hecho!");
}

$raw_id_game = (int)$_POST["id_game"];
if(!is_int($raw_id_game)){
	die("ERROR 2: Formato de juego no disponible!");
}
if($raw_id_game < 1){
	die("ERROR 3: Juego no existente.");
}

$raw_comment = $_POST["comment"];
if(strlen($raw_comment) < 3){
	die("ERROR 4: Comentario muy corto!");
}
$temp_comment = addslashes(trim($raw_comment));
if($temp_comment != $raw_comment){
	die("ERROR 5: Comentario no valido!");
}

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$query = "INSERT INTO comments (comment,id_creator, id_game) VALUES('{$temp_comment}','{$_SESSION["id_creator"]}','{$raw_id_game}');";

$result = mysqli_query($conn, $query);
$comment = mysqli_insert_id($conn);
$query = "INSERT INTO comments_games (id_comment, id_game) VALUES('{$comment}','{$raw_id_game}');";
$result = mysqli_query($conn, $query);
header("Location: game.php?id_game={$raw_id_game}");
exit();
?>
