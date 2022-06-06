
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
		<link rel="stylesheet" href="./css/lista.css">
		<title>Página principal</title>
	</head>

	<body>
		<main id="main">

			<?php
				
				echo '<t class="titulo">';
					echo "Test de Friends";				
				echo '</t>';

				echo '</br></br>';

				echo '<p>';
					echo "No es ningún secreto que la serie 'Friends' es una de las más famosas de todos los tiempos. Y";
					echo "es que esta serie, que se emitió por primera vez en 1994, es un clásico que la televisión no deja";
					echo "de repetir y a la que todos nos hemos enganchado en más de una ocasión.";
					echo '</br>';
					echo "Rachel, Mónica, Phoebe, Ross, Chandler y Joey. ¿Sabrías responder a algunas preguntas sobre ellos?";
				echo '</p>';		
								
			?>

			<br/><br/>
			
			<form action = "miFormulario">
				<input type="submit" formaction="iniciarSesion.php" value="Iniciar sesión" id="submit" name="Iniciar"/>
				&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
				<input type="submit" formaction="alta.php" value="Alta jugador" id="submit" name="Alta"/>
			</form>

			<br/><br/>
		</main>

	</body>

</html> 
