<?php

include "funciones.php";

session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['clave']))
{
	if (($_SESSION['usuario'] != 'invitado') && ($_SESSION['clave'] != 'invitado'))
	{

		$usuario = $_SESSION['usuario'];

		echo "<p style='float:right; margin:0px;'>Usuario conectado: ".$usuario."</p>";

		$conectar = conectar();

		$positivo = 1;

		$negativo = 0;
//contar votos positivos
		$query_1 = "SELECT count(id) as contar_pos FROM  inkesta WHERE Erantzuna=?";

//ejecutar el select
		$stmt = mysqli_prepare($conectar, $query_1);

		mysqli_stmt_bind_param($stmt, 'i', $positivo);

		$ejecutar_1 = mysqli_stmt_execute($stmt);

//verificar que se ha ejecutado la query
		if (!$ejecutar_1) 
		{
			echo "Ocurrió un error1";
		}

		else 
		{
//contar lineas select --> VOTOS POSITIVOS

			mysqli_stmt_bind_result($stmt, $contar_pos);

			mysqli_stmt_fetch($stmt);

			mysqli_stmt_close($stmt);

			$query_2 = "SELECT count(id) as contar_neg FROM  inkesta WHERE Erantzuna=?";

//ejecutar el select
			$stmt2 = mysqli_prepare($conectar, $query_2);

			mysqli_stmt_bind_param($stmt2, 'i', $negativo);

			$ejecutar_2 = mysqli_stmt_execute($stmt2);

//verificar que se ha ejecutado la query
			if (!$ejecutar_2) 
			{
				echo "Ocurrió un error2";
			}

			else 
			{
				mysqli_stmt_bind_result($stmt2, $contar_neg);

				mysqli_stmt_fetch($stmt2);


//contar lineas select --> VOTOS POSITIVOS
				mysqli_stmt_close($stmt2);

				$totalV = $contar_pos+$contar_neg;

				$porcentajePos = round($contar_pos / $totalV * 100, 2);
				$porcentajeNeg = round($contar_neg / $totalV * 100, 2);

				echo "<!DOCTYPE html>
				<html>
				<head>
				<title>RESULTADOS ENCUESTA</title>
				<meta charset='utf-8'>
				</head>
				<body>
				<h2>Encuesta. Resultados de la votación</h2>
				<table>
				<tr>
				<th>Respuesta</th>
				<th>Votos</th>
				<th>Porcentaje</th>
				</tr>
				<tr>
				<td>Sí</td>
				<td>".$contar_pos."</td>
				<td>".$porcentajePos."%</td>
				</tr>
				<tr>
				<td>No</td>
				<td>".$contar_neg."</td>
				<td>".$porcentajeNeg."%</td>
				</tr>
				</table>
				<p>Número total de votos emitidos: ".$totalV."</p>
				<a href='VEncuesta.php'>Página de votación</a>
				</body>
				</html>";

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