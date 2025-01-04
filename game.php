<?php
session_start();

if(!isset($_GET["id_game"])){
	header("Location: index.php");
	exit();
}

require_once("template.php");
$query = "SELECT * FROM games WHERE id_game = {$_GET['id_game']}";
require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
$result = mysqli_query($conn, $query);
if($result){
	$game = mysqli_fetch_assoc($result);
}

if($result && mysqli_num_rows($result) > 0){
printHead("ENTIch: {$game['title']}");
openBody("{$game['title']}");
echo <<<EOD
	<ul>
		<li>
			<h2>
				{$game['title']}
			</h2>
			<figure>
				<img src="imgs/{$game['header']}" alt="img">
			</figure>
			<p>
				Página de Steam: 
				<a href="{$game['link']}">
					{$game['title']}
				</a>
			</p>
			<p>
				Precio: {$game['price']} 
			</p>
			<p>
				Trailer <a href="{$game['trailer']}">aqui</a>
			</p>
		</li>
	</ul>
EOD;

if(isset($_SESSION["id_creator"])){
		echo <<<EOD
	<form action="comment_insert.php" method="post">
		<h2>Deja tu comentario</h2>
		<input type="hidden" id="publish_game" name="id_game" value="{$game['id_game']}">
		<label for="publish_comment">Tu comentario:</label>
		<textarea id="publish_comment" name="comment" placeholder="Escribe tu comentario aquí..." required></textarea>
		<button type="submit">Enviar</button>
	</form>
EOD;
}

//comment list
$query = "SELECT * FROM comments JOIN comments_games ON comments.id_comment = comments_games.id_comment WHERE comments_games.id_game = {$game['id_game']};";
$result = mysqli_query($conn, $query);
if($result && mysqli_num_rows($result) > 0){
	echo "<ul>";
	echo "<li><h2>Comentarios</h2><li>";
		while($comment = mysqli_fetch_assoc($result)){
		$query = "SELECT * FROM creators WHERE id_creator={$comment['id_creator']}";
		$creatorResult = mysqli_query($conn, $query);
		$cResult = mysqli_fetch_assoc($creatorResult);
			echo <<<EOD
				<li>
					<p><strong>{$cResult['username']}</strong></p>
					<p>{$comment['comment']}</p>
				</li>
			EOD;
		
		}
		echo "</ul>";
	}
	else{
		echo "<h2>No se han encontrado comentarios.</h2>";
	}
}
else{
printHead("No Game");
openBody("No Game");
echo "<h1>No se ha encontrado el juego</h1>";
}
closeBody();



?>
