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
		<title>INSERTAR VIVIENDA</title>
		<meta charset='utf-8'>
		</head>
		<body>
		<p style='float:right; margin:0px;'>Usuario conectado: ".$usuario."</p>
		<h2>Inserción de nueva vivienda</h2>
		<form action='VInsertar.php' method='post' >
		<p>Título: * <input type='text' name='titulo'></p>
		<p>Categoria: 
		<select name='categoria'>
		<option value='Eskaintza'>Eskaintza</option>
		<option value='Kostaldea'>Kostaldea</option>
		<option value='Promozioa'>Promozioa</option>
		</select>
		</p>
		<p>Imagen: 
		<input type='fIle' name='imagen' accept='image/*'>
		</p>
		<p>Texto: * <input type='text' name='texto' style='height: 90px; width: 300px'></p>
		<p>Metros cuadrados: * <input type='text' name='metros'></p>
		<p><input type='submit' name='insertarV' value='Insertar vivienda'></p>
		<p>NOTA: los datos marcados con (*) deben ser rellenados obligatoriamente</p>
		</form>
		<a href='VPrincipal.php'>Volver al menu principal</a>
		</body>
		</html>";
//enctype='multipart/form-data'

		if ($_POST)
		{
//comprobar que no se ha quedado ningún apartado vacio
			if (empty($_POST['titulo']))
			{
				echo "No puedes dejar el titulo vacio";
			}

			else
			{
				if (empty($_POST['texto']))
				{
					echo "No puedes dejar el texto vacio";
				}

				else
				{
					if (empty($_POST['metros']))
					{
						echo "No puedes dejar m2 vacio";
					}

					else
					{

						$titulo = $_POST['titulo'];
						$texto = $_POST['texto'];
						$categoria = $_POST['categoria'];
						$fecha = date('Y')."/".date('m')."/".date('d');
						$nombreImg = $_POST['imagen'];
						$metros = $_POST['metros'];

						if ($nombreImg!='')
						{
							$file = basename($nombreImg, ".jpg");
						}

						else
						{
							$file = '';
						}

						$conectar = conectar();

						// $comprobar_vivienda = "SELECT * FROM etxebizitzak WHERE titulua='".$titulo."' AND deskribapena='".$texto."'AND kategoria ='".$categoria."' AND data='".$fecha."' AND argazkia='".$file."' AND m2='".$metros."'";

						$comprobar_vivienda = "SELECT * FROM etxebizitzak WHERE titulua=? AND deskribapena=? AND kategoria=? AND data=? AND argazkia=? AND m2=?";

//ejecutar el select
						$stmt = mysqli_prepare($conectar, $comprobar_vivienda);

						mysqli_stmt_bind_param($stmt, "ssssss", $titulo, $texto, $categoria, $fecha, $file, $metros);

						$query2 = mysqli_stmt_execute($stmt);

//verificar que se han insertado los valores
						if (!$query2) 
						{
							echo "Ocurrió un error";
						}

						else 
						{
							$lineas1 = mysqli_stmt_fetch($stmt);

							if ($lineas1)
							{
								echo "<br><br>La vivienda ya existe";
							}

							else
							{
								mysqli_stmt_close($stmt);
								
							//contar id
								$contar_id = "SELECT max(id) as num from etxebizitzak";

								$query_1 = mysqli_query($conectar, $contar_id);

								if (!$query_1)
								{
									echo "<br><br>Ocurrió un error1";
								}

								else
								{
									$contar = mysqli_fetch_array($query_1);

									$contar_num = (int)($contar['num']);

									$casa_sig = $contar_num+1;
								}

								$nombreImagen = 'vivienda'.$casa_sig;
			//insertar nuevo usuario

								if ($file == $nombreImagen || $file=='')
								{
									//$insertar = "INSERT INTO etxebizitzak VALUES ('$casa_sig','$titulo','$texto', '$categoria', '$fecha', '$file', '$metros')";

									$insertar = "INSERT INTO etxebizitzak VALUES (?, ?, ?, ?, ?, ?, ?)";

									$stmt2 = mysqli_prepare($conectar, $insertar);

									mysqli_stmt_bind_param($stmt2, 'sssssss', $casa_sig, $titulo, $texto, $categoria, $fecha, $file, $metros);

									$verficar =mysqli_stmt_execute($stmt2);									
									if (!$verificar) 
									{
										echo "<br><br>Ocurrió un error2";
									}

									else
									{
										echo "<br><br>Vivienda insertada correctamente";
									}
								}

								mysqli_stmt_close($stmt2);
							}

							else
							{
								echo "<br><br>El nombre de la imagen no tiene el formato correcto: debe conter la palabra vivienda y el id";
							}
						}
					}

					mysqli_close($conectar);
				}
			}
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