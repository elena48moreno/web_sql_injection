<?php

function conectar()
{
//conectar servidor BD
	$host="localhost";
	$user="root";
	$paswd="";
	$bd="casas";

//conectar servidor BD
	$conn = mysqli_connect($host, $user, $paswd, $bd);

	if(!$conn)
	{
		echo "No se ha podido conectar a la base de datos";
	}

	else
	{
		return $conn;
	}
}

function precio($a,$b)
{
	$euro_metro=0;

	if ($a='Kostaldea')
	{
		$euro_metro=4000;
	}
	if ($a='Promozioa')
	{
		$euro_metro=2500;
	}
	if ($a='Eskaintza')
	{
		$euro_metro=3000;
	}

	$precio_viv = $b*$euro_metro;

	return $precio_viv;
}
?>