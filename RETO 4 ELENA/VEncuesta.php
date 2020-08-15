<?php

include("funciones.php");

session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['clave']))
{
	if (($_SESSION['usuario'] != 'invitado') && ($_SESSION['clave'] != 'invitado'))
	{
		$usuario = $_SESSION['usuario'];

		echo "<!DOCTYPE html>
		<html>
		<head>
		<title>ENCUESTA</title>
		<meta charset='utf-8'>
		</head>
		<body>
		<p style='float:right; margin:0px;'>Usuario conectado: ".$usuario."</p>
		<h1>Encuesta</h1>
		<p>Cree ud. que el precio de la vivienda seguirá subiendo al ritmo actual?</p>
		<form action='VEncuesta.php' method='post'>
		<input type='radio' name='si_no' value='si'> Sí
		<br>
		<input type='radio' name='si_no' value='no'> No
		<br>
		<br>
		<input type='submit' name='voto' value='Votar'>
		<br>
		<br>
		<a href='encuestaresultados.php'> Ver resultados</a>
		<br>
		<br>
		<a href='VPrincipal.php'>VOLVER AL MENU PRINCIPAL</a>
		</form>
		</body>
		</html>";

		if ($_POST)
		{
			$conectar = conectar();
//declarar variable usuario y respuesta
			$usuario = $_SESSION['usuario'];
			$encuesta = $_POST['si_no'];

//comprobar que el usuario actual aún no haya votado
			$datos = "SELECT * FROM  inkesta WHERE izena =?";

			$stmt = mysqli_prepare($conectar, $datos);

			mysqli_stmt_bind_param($stmt, "s", $usuario);

			$ejecutar = mysqli_stmt_execute($stmt);

			if (!$ejecutar)
			{
				echo "<br>Ocurrio un error";
			}

			else
			{

				$lineas = mysqli_stmt_fetch($stmt);

				if (!$lineas)
				{

					mysqli_stmt_close($stmt);

					if ($encuesta='si') 
					{
						$respuesta = 1;
					}

					else
					{
						$respuesta = 0;
					}

//contar id
					$contar_id = "SELECT max(id) as num from inkesta";

					$query_1 = mysqli_query($conectar, $contar_id);

					if (!$query_1) 
					{
						echo "Ocurrió un error";
					}

					else 
					{

						$contar = mysqli_fetch_array($query_1);

						$contar_num = (int)($contar['num']);

						$contar_num_sig = $contar_num+1;

					}

//insertar datos
					//$insertar = "INSERT INTO  inkesta VALUES('$contar_num_sig','$usuario','$respuesta')";

					$insertar = "INSERT INTO  inkesta VALUES(?,?,?)";

					$stmt2 = mysqli_prepare($conectar, $insertar);

					mysqli_stmt_bind_param($stmt2, 'sss', $contar_num_sig, $usuario, $respuesta);

					$query_2 = mysqli_stmt_execute($stmt2);

					if (!$query_2) 
					{
						echo "Ocurrió un error";
					}

					else 
					{
						mysqli_stmt_close($stmt2);

						echo "<br>Se ha registrado la respuesta del usuario ".$usuario.".";
					}
				}

				else
				{
					echo "<br>El usuario " . $usuario . " no puede votar más de una vez";
				}

				mysqli_close($conectar);
			}
		}
	}

	else
	{
		echo "Los invitados no tienen acceso a esta pagina.";

		echo "<br><br><a href='Viviendaszub.html'>Conectarse con un usuario</a>";
	}
}

else
{
	echo "No se ha iniciado sesión.";

	echo "<br><br><a href='Viviendaszub.html'>INICIAR SESION</a>";
}
?>