<?php

include("funciones.php");

session_start();

echo "<!DOCTYPE html>
<html>
<head>
<title>LISTADO</title>
<meta charset='utf-8'>
</head>";

if (isset($_SESSION['usuario']) && isset($_SESSION['clave']))
{
	$usuario = $_SESSION['usuario'];

	echo "<p style='float:right; margin:0px;'>Usuario conectado: ".$usuario."</p>";

	$conectar = conectar();
	//seleccionar datos tabla
	$query = "SELECT * FROM  etxebizitzak ORDER BY data DESC";

//ejecutar el select
	$ejecutar = mysqli_query($conectar, $query);

//verificar que se han insertado los valores
	if (!$ejecutar) 
	{
		echo "Ocurrió un error";
	}

	else 
	{
	//pasar resultados como array

		$casas = mysqli_fetch_array($ejecutar);
	}

	echo "<h1>Consulta de viviendas</h1>";

	echo "<table style= 'border: 2px solid black; text-align: center'>";
	echo "<tr>";
	echo "<th style= 'border: 2px solid black'>Titulo</th>";
	echo "<th style= 'border: 2px solid black'>Texto</th>";
	echo "<th style= 'border: 2px solid black'>Categoria</th>";
	echo "<th style= 'border: 2px solid black'>Fecha</th>";
	echo "<th style= 'border: 2px solid black'>Imagen</th>";
	echo "<th style= 'border: 2px solid black'>Metros cuadrados</th>";
	echo "<th style= 'border: 2px solid black'>Precio(euros)</th>";
	
	if (($_SESSION['usuario'] != 'invitado') && ($_SESSION['clave'] != 'invitado'))
	{
		echo "<th style= 'border: 2px solid black'>Modificar vivienda</th>";
	}
	echo "</tr>";
	//$contar_img = 1;

	for ($i=0; $i < $casas; $i++) 
	{ 
		echo "<tr>";
		echo "<td style= 'border: 2px solid black'>";
		echo $casas['titulua'];
		echo "</td>";
		echo "<td style= 'border: 2px solid black'>";
		echo $casas['deskribapena'];
		echo "</td>";
		echo "<td style= 'border: 2px solid black'>";
		echo $casas['kategoria'];
		echo "</td>";
		echo "<td style= 'border: 2px solid black'>";
		echo $casas['data'];
		echo "</td>";
		echo "<td style= 'border: 2px solid black'>";

		if ($casas['argazkia'] !== '')
		{
			$img_casa = "img/".$casas['argazkia'].".jpg";

			if (!file_exists($img_casa))
			{
				echo "La imagen no esta disponible";
			}

			else
			{
				echo "<a href='img/".$casas['argazkia'].".jpg'><img src='img/ico-fichero.gif'></a>";
			}
		}

		else
		{
			echo "";
		}

		echo "</td>";
		echo "<td style= 'border: 2px solid black'>";
		echo $casas['m2'];
		echo "</td>";
		echo "<td style= 'border: 2px solid black'>";
		echo precio($casas['kategoria'],$casas['m2']);
		echo "</td>";

		if (($_SESSION['usuario'] != 'invitado') && ($_SESSION['clave'] != 'invitado'))
		{
			echo "<td style= 'border: 2px solid black'>";
			echo "<a href='VModificar.php?idViv=".$casas['id']."'>Modificar</a>";
			echo "</td>";
		}

		echo "</tr>";

		$casas = mysqli_fetch_array($ejecutar);
	}

	echo "</table>";
	echo "<br>";
	
	if (($_SESSION['usuario'] != 'invitado') && ($_SESSION['clave'] != 'invitado'))
	{
		echo "<a href='VListado.php?fichero'>Crear fichero viviendas</a>";
	}

	if (isset($_GET['fichero']))
	{

		$archivo = "ficheros/viviendas.txt";
		$file = fopen($archivo, "w");

		$query = "SELECT * FROM  etxebizitzak";

		$resultado = mysqli_query($conectar, $query);
		
		while ($casas_fich = mysqli_fetch_array($resultado))
		{ 
			fwrite($file, $casas_fich['id']);
			fwrite($file, ", ");
			fwrite($file, $casas_fich['titulua']);
			fwrite($file, ", ");
			fwrite($file, $casas_fich['deskribapena']);
			fwrite($file, ", ");
			fwrite($file, $casas_fich['kategoria']);
			fwrite($file, ", ");
			fwrite($file, $casas_fich['data']);
			fwrite($file, ", ");
			fwrite($file, $casas_fich['argazkia']);
			fwrite($file, ", ");
			fwrite($file, $casas_fich['m2']);
			fwrite($file, "\r\n");

			$casas = mysqli_fetch_array($ejecutar);
		}

		fclose($file);

		echo "<br><br>Se ha generado el fichero correctamente<br>";	
	}
	echo "<br><a href='VPrincipal.php'>Volver al menu principal</a>";

	mysqli_close($conectar);
}

else
{
	echo "<br>No se ha iniciado sesión.";

	echo "<br><a href='Viviendaszub.html'>INICIAR SESION</a>";
}
?>