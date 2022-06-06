<?php  
	include 'conexionbd.php';

	session_start();
	
	// Definición de las variables
	$pregunta = "";
	$primera_respuesta = "";
	$segunda_respuesta = "";
	$tercera_respuesta = "";
	$solucion = "";
	$codigo = "";
	$respuesta = "";

	if (!isset($_SESSION['posicion'])){
		$_SESSION['posicion'] = 1;

		if (!isset($_SESSION['victorias']) && !isset($_SESSION['perdidas'])){	
			$_SESSION['victorias'] = 0;
			$_SESSION['perdidas'] = 0;
		}
	}
	else
	{
		++$_SESSION['posicion'];

		if($_SESSION['solucion'] == $_POST['respuesta']){
			++$_SESSION['victorias'];
		}
		else{
			++$_SESSION['perdidas'];
		}
	}

	$con=conexion();
	
	$sql = "select count(*) from PREGUNTAS where codigo ='" . $_SESSION['posicion'] ."';";
	$resultado=mysqli_query($con, $sql);
	$datos=mysqli_fetch_assoc($resultado);
	mysqli_close($con);

	
    $preg = obtener_datos_preguntas($_SESSION['posicion']);

	// $_SESSION: array superglobal para acceder a las sesiones
    $_SESSION['pregunta']=$preg['pregunta'];
    $_SESSION['primera_respuesta']=$preg['primera_respuesta'];
    $_SESSION['segunda_respuesta']=$preg['segunda_respuesta'];
    $_SESSION['tercera_respuesta']=$preg['tercera_respuesta'];
    $_SESSION['solucion']=$preg['solucion'];
	$_SESSION['codigo']=$preg['codigo'];

	if ($_SESSION['posicion'] == 8){	
			--$_SESSION['posicion'];
			echo '<t class="titulo">';
				echo "PUNTUACIÓN FINAL:";	
				echo '</br>';
				echo "Aciertos: ".$_SESSION['victorias'];
				echo '</br>';
				echo "Fallos: ".$_SESSION['perdidas'];		
				//echo '<style>.test { display:none;}</style>';
			echo '</t>';
			session_destroy();		
		}

	function obtener_datos_preguntas($posicion)
	{
		$con=conexion();

		$sql="select pregunta, primera_respuesta, segunda_respuesta, tercera_respuesta, solucion, codigo from PREGUNTAS where codigo = '" . $posicion . "';";
		$resultado=mysqli_query($con, $sql);
        $datos=mysqli_fetch_assoc($resultado);
        
		mysqli_close($con);
		
		return $datos;
	}

	function obtener_edad_segun_fecha($fecha_nacimiento)
	{
		$nacimiento = new DateTime($fecha_nacimiento);
		$ahora = new DateTime(date("Y-m-d"));
		$diferencia = $ahora->diff($nacimiento);
		return $diferencia->format("%y");
	}
?>

<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<link rel="stylesheet" href="./css/alta.css">
			<link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		    <title>Inicio</title>		
		</head>
		<body>
			<form action="./verDatos.php" method="post">
					<fieldset id="formulario_test">
						<legend id="test">PREGUNTA <?php echo$_SESSION['posicion'];?>:</legend></br></br>
						<table>
							<tr>
								<td>
									<?php echo $_SESSION['pregunta'];?> </br></br>
								</td>
							</tr>
							<tr>
								<td>
									<input id="primera_respuesta" type="radio" name="respuesta" value=1 />
									<?php echo$_SESSION['primera_respuesta'];?>
								</td>
							</tr>
							<tr>
								<td>
									<input id="segunda_respuesta" type="radio" name="respuesta" value=2 />
									<?php echo$_SESSION['segunda_respuesta'];?>
								</td>
							</tr>
							<tr>
								<td>
									<input id="tercera_respuesta" type="radio" name="respuesta" value=3 />
									<?php echo$_SESSION['tercera_respuesta'];?>
								</td>
							</tr>
						</table>
						</br></br>
						<div id="caja_boton">
							<input id="submit" type="submit" value="Siguiente" />
						</div>
					</fieldset>
					<div class="caja_usuario">
						<div class="datos_usuario">
							<h3><?php echo 'Jugador: ' .$_SESSION['nombre'] . ' ' . $_SESSION['apellido'];?></h3> 
							<!--<h3><?php echo 'Edad: ';?><?php obtener_edad_segun_fecha($_SESSION['fecha_nacimiento']); ?></h3>-->
						</div>
					</div>	
			</form>	
		</body>
	</html>
