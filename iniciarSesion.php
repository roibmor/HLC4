<?php
    include 'conexionbd.php';

	// Iniciar una nueva sesión o reanudar la existente
	// debe ser llamada siempre, antes de realizar cualquier otra operación relacionada con sesiones
    session_start();

	// define variables y les da valores vacíos
	$email = "";
	
    if (isset($_POST['comprobacion'])) {
		
        $email = $_POST['email'];
			
        $error = comprobar_sql_injection($email);

        if ($error == TRUE)
        {
            header("location:./index.php");
        }
        else
        {
            $con=conexion();
            $sql="select count(*) as total from USUARIOS where email='" . $email ."';";
            $resultado=mysqli_query($con, $sql);
            $datos=mysqli_fetch_assoc($resultado);
            $cantidad = $datos['total'];
            mysqli_close($con);

            if ($cantidad > 0)
            {
                $jug = obtener_datos_usuario($email);

				// $_SESSION: array superglobal para acceder a las sesiones
                $_SESSION['nombre']=$jug['nombre'];
                $_SESSION['email']=$jug['email'];
                $_SESSION['apellido']=$jug['apellido'];
                $_SESSION['victorias']=$jug['IFNULL(ganadas,0)'];
                $_SESSION['perdidas']=$jug['IFNULL(perdidas,0)'];
                $_SESSION['jugando']=false;
                $_SESSION['sesionJuego']=true;
                header("location:./verDatos.php");
            }
            else
            {
                header("location:./index.php");
            }            
        }      
    }
    

    function obtener_datos_usuario($email)
	{
		$con=conexion();

		$sql="select email, nombre, fecha_nacimiento, apellido, IFNULL(ganadas,0), IFNULL(perdidas,0) from USUARIOS where email = '" . $email . "';";
		$resultado=mysqli_query($con, $sql);
        $datos=mysqli_fetch_assoc($resultado);
        
		mysqli_close($con);
		
		return $datos;
	}
    
    function comprobar_sql_injection($valor)
	{
		$error = FALSE;
		if (strpos($valor, "'") == TRUE) {
			$error = TRUE;
		}
		else if (strpos($valor, '"') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, ';') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '<') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '>') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '/') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '&') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '--') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '/*') == TRUE)
		{
			$error = TRUE;
		}
		else if (strpos($valor, '*/') == TRUE)
		{
			$error = TRUE;
		}
		return $error;
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8"/>
		<link rel="stylesheet" href="./css/lista.css">
		<title>Login</title>
	</head>
	<body>
		
			<h1 class = "titulo">Login</h1>
			<form action=" " method="post">	
				<input type="text" id="email" name="email" placeholder="Introduce tu correo electrónico" <?php echo($email); ?>><br/><br/><br/><br/>
				<input type="submit" id="submit" name="enviar" value="Enviar"/>
				<input id="comprobacion" type="hidden" name="comprobacion" value="ok" />
			</form>
		
	</body>
</html>
