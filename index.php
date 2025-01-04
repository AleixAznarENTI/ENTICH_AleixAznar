<?php
session_start();

require_once("template.php");
printHead("ENTIch: Home");
openBody("Home");
require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
$query = "SELECT * FROM games";
$result = mysqli_query($conn, $query);

if($result && mysqli_num_rows($result) > 0){
	echo "<ul>";
	echo "<li><h2>JUEGOS</h2></li>";
	while ($gamesInfo = mysqli_fetch_assoc($result)){
		echo <<<EOD
			<li>
				</p><a href="game.php?id_game={$gamesInfo['id_game']}">{$gamesInfo['title']}</a></p>
				<p>Precio: {$gamesInfo['price']}</p>
				<figure><img src="{$gamesInfo['header']}" alt="img" /></figure>
			</li>
		EOD;
	}
}

closeBody();

?>
