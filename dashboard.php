<?php
session_start();

if(!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

require_once("template.php");

$query = "SELECT * FROM creators WHERE id_creator=".$_SESSION["id_creator"];

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

$result = mysqli_query($conn, $query);

if(!$result){

	header("Location: login.php");
	exit();

}

if(mysqli_num_rows($result) != 1){
	header("Location: login.php");
	exit();
}




$creator = mysqli_fetch_array($result);





printHead("Dashboard de ".$creator["name"]);

openBody("Dashboard de  ".$creator["name"]);

require_once("dashboard_template.php");

openDashboard();

echo <<<EOD
<form method="POST" action="profile_update.php">

<p><label for="profile_name">Nombre:</label><input type="text" value="{$creator["name"]}" name="name" id="profile_name" /></p>
<p><label for="profile_user">Usuario:</label><input type="text" value="{$creator["username"]}" name="user" id="profile_user" /></p>
<p><label for="profile_mail">Mail:</label><input type="text" value="{$creator["email"]}" name="mail" id="profile_mail" /></p>
<p><label for="profile_image">Image:</label><input type="text" value="{$creator["image"]}" name="image" id="profile_image" /></p>
<p><label for="profile_description">Descripción:</label><textarea name="description" id="profile_description">{$creator["description"]}</textarea></p>
<p><input type="submit" value="Actualizar" /></p>
</form>
EOD;

closeDashboard();
closeBody();

?>
