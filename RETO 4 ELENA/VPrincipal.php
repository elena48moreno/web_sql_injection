﻿<?php

session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['clave']))
{
	$usuario = $_SESSION['usuario'];

	echo "<!DOCTYPE html>
	<html>
	<head>
	<title>MENU</title>
	</head>
	<body>";
	

	if (($_SESSION['usuario'] == 'invitado') && ($_SESSION['clave'] == 'invitado'))
	{
		echo "<p style='float:right; margin:0px;'>Acceso de invitado</p>
		<h2>BASE DE DATOS VIVIENDAS</h2>
		<a href='VListado.php'>Consultar viviendas</a>
		<a href='Viviendaszub.html'>Iniciar sesion</a>";
	}

	else
	{
		echo "
		<p style='float:right; margin:0px;'>Usuario conectado: ".$usuario."</p>
		<h2>BASE DE DATOS VIVIENDAS</h2>
		<a href='VListado.php'>Consultar viviendas</a>
		<a href='VEncuesta.php'>Encuesta</a>
		<a href='VInsertar.php'>Insertar viviendas</a>
		<a href='VBorrar.php?borrar'>Eliminar viviendas</a>
		<br>
		<a href='VSalida.php'>SALIR</a>
		</body>
		</html>";
	}
}

else
{
	echo "No se ha iniciado sesión.";
	echo "<br><a href='Viviendaszub.html'>INICIAR SESION</a>";
}
?>