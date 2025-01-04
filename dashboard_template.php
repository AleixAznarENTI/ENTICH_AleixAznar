<?php
	function openDashboard(){

		echo <<<EOD
			<aside>
				<nav>
					<h2>Opciones</h2>
					<ul>
						<li><a href="dashboard.php">Perfil</a></li>
						<li><a href="dashboard_games.php">Juegos</a></li>
					</ul>
				</nav>
			</aside>
			<article>
				
		

EOD;

	}

	function closeDashboard(){
		echo <<<EOD
</article>
EOD;


	}
?>
