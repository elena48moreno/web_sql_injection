<?php  

include "funciones.php";

session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['clave']))
{
	if (($_SESSION['usuario'] != 'invitado') && ($_SESSION['clave'] != 'invitado'))
	{
		$usuario = $_SESSION['usuario'];

		if (isset($_GET['idViv']))
		{
			$viviendaId = $_GET['idViv'];

			$conectar = conectar();

			$seleccionar = "SELECT titulua, deskribapena, kategoria, argazkia, m2 FROM etxebizitzak WHERE id=?";

			$stmt = mysqli_prepare($conectar, $seleccionar);

			mysqli_stmt_bind_param($stmt, "i", $viviendaId);

			$ejecutar = mysqli_stmt_execute($stmt);

			if (!$ejecutar)
			{
				echo "Ocurrio un error";
			}

			else
			{
				mysqli_stmt_bind_result($stmt, $titulo, $texto, $categoria, $imagen, $metros);

				mysqli_stmt_fetch($stmt);

				$cat = array('Eskaintza.', 'Kostaldea.', 'Promozioa');


				echo "<!DOCTYPE html>
				<html>
				<head>
				<title>MODIFICAR VIVIENDA</title>
				<meta charset='utf-8'>
				</head>
				<body>
				<p style='float:right; margin:0px;'>Usuario conectado: ".$usuario."
				</p>
				<h2>Modificar vivienda</h2>
				<form action='VModificar.php?idViv=".$viviendaId."' method='post'>
				<p>Título: * <input type='text' name='titulo' value='".$titulo."'></p>
				<p>Categoria:
				<select name='categoria'>";

			//echo "<option value='".$result[$i]."'>".$cat[0].$cat[1]."</option>";

				if ($cat[0]=$categoria)
				{
					echo "<option value='".$cat[0]."'>".$cat[0]."</option>";
					echo "<option value='".$cat[1]."'>".$cat[1]."</option>";
					echo "<option value='".$cat[2]."'>".$cat[2]."</option>";
				}

				elseif ($cat[1]=$categoria)
				{
					echo "<option value='".$cat[1]."'>".$cat[1]."</option>";
					echo "<option value='".$cat[2]."'>".$cat[2]."</option>";
					echo "<option value='".$cat[0]."'>".$cat[0]."</option>";
				}

				elseif ($cat[2]=$categoria)
				{
					echo "<option value='".$cat[2]."'>".$cat[2]."</option>";
					echo "<option value='".$cat[0]."'>".$cat[0]."</option>";
					echo "<option value='".$cat[1]."'>".$cat[1]."</option>";
				}

				echo "</select>
				</p>
				<p>Imagen: 
				<input type='file' name='imagen' accept='image/*'>
				</p>
				<p>Texto: * <input type='text' name='texto' value='".$texto."' style='height: 90px; width: 300px'></p>
				<p>Metros cuadrados: * <input type='text' name='metros' value='".$metros."'></p>
				<p><input type='submit' name='modificarV' value='Modificar vivienda'></p>
				<p>NOTA: los datos marcados con (*) deben ser rellenados obligatoriamente</p>
				</form>
				<a href='VPrincipal.php'>Volver al menu principal</a>
				</body>
				</html>";

				if (isset($_POST['modificarV']))
				{
					if (empty($_POST['titulo']))
					{
						echo "<br><br>No puedes dejar el titulo vacio";
					}

					else
					{
						if (empty($_POST['texto']))
						{
							echo "<br><br>No puedes dejar el titulo vacio";
						}

						else
						{
							if (empty($_POST['metros']))
							{
								echo "<br><br>No puedes dejar m2 vacio";
							}

							else
							{
								$tituloN = $_POST['titulo'];
								$categoriaN = $_POST['categoria'];
								$imagenN = $_POST['imagen'];
								$textoN = $_POST['texto'];
								$metrosN = $_POST['metros'];
								$fechaN = date('Y-m-d');

								if ($imagenN!='')
								{
									$imagenN = basename($imagenN, ".jpg");
								}

								else
								{
									$imagenN = '';
								}

								if (($tituloN==$titulo) && ($categoriaN==$categoria) && ($textoN==$texto) && ($metrosN==$metros) && ($imagenN==$imagen))
								{
									echo "<br><br>No has hecho ningun cambio en la vivienda ".$viviendaId.".";
								}

								else
								{
									mysqli_stmt_close($stmt);

									$editarViv = "UPDATE etxebizitzak SET titulua=?, deskribapena=?, kategoria=?, data=?, argazkia=?, m2=? WHERE id=?";

									$stmt2 = mysqli_prepare($conectar, $editarViv);

									if ($stmt2)
									{
										mysqli_stmt_bind_param($stmt2, 'sssssss', $tituloN, $textoN, $categoriaN, $fechaN, $imagenN, $metrosN, $viviendaId);

										$mod = mysqli_stmt_execute($stmt2);

										$verificar = mysqli_stmt_affected_rows($stmt2);

										if ($verificar)
										{
											echo "<br><br>La vivienda se ha actualizado correctamente";
										}

										else
										{
											echo "<br><br>La vivienda no se pudo actualizar";
										}
									}

									else
									{
										echo "<br><br>Error de consulta";
									}

									mysqli_stmt_close($stmt2);
								}
							}
						}
					}
				}
			}
			mysqli_close($conectar);
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
	echo "No se ha iniciado sesion";
	echo "<br><br><a href='Viviendaszub.html'>INICIAR SESION</a>";
}
?>