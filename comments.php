<?php
session_start();
if(!isset($_SESSION['id_creator'])){
	header('Location: login.php');
	exit();
}
require_once("template.php");
printHead("ENTIch: Comments");
openBody("Comments");

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
$query = "SELECT
    		comments.comment,
			comments.id_comment,
			comments.id_game,
			comments.id_creator
		  FROM
		    comments
   		  JOIN
		    comments_games
	      ON 
		    comments.id_comment = comments_games.id_comment
		  JOIN		
		    games
		  ON 
		    comments_games.id_game = games.id_game
		  JOIN
		    creators_games
		  ON 
		    games.id_game = creators_games.id_game
		  WHERE
			creators_games.id_creator = {$_SESSION['id_creator']};";

$result = mysqli_query($conn, $query);


if($result && mysqli_num_rows($result) > 0){
	echo "<ul>";
	echo "<li><h2>MIS COMENTARIOS</h2></li>";
	while ($commentInfo = mysqli_fetch_assoc($result)){
		$query = "SELECT * FROM creators WHERE id_creator={$commentInfo['id_creator']};";
		$creatorResult = mysqli_query($conn, $query);
		$cResult = mysqli_fetch_assoc($creatorResult);
		$query = "SELECT * FROM games WHERE id_game={$commentInfo['id_game']};";
		$gameResult = mysqli_query($conn, $query);
		$gResult = mysqli_fetch_assoc($gameResult);
		echo <<<EOD
			<li>
				<p><strong>{$cResult['username']} - </strong><a href="game.php?id_game={$commentInfo['id_game']}">{$gResult['title']}</a></p>
				<p>{$commentInfo['comment']}</p>
			</li>
		EOD;
	}
	echo "</ul>";
}
else{
	echo "<h2>NO SE HAN ENCONTRADO COMENTARIOS</h2>";
}

closeBody();

?>
