<?php 

include "funciones.php";

if (isset($_POST['Entrar']))
{
	echo "<!DOCTYPE html>
	<html>
	<head>
	<title>REGISTRO</title>
	<meta charset='utf-8'>
	</head>";

	if (empty($_POST['usuario']))
	{
		echo "No puedes dejar el nombre vacio";
		echo "<br>";
		echo "<a href='Viviendaszub.html'>Volver al formulario</a>";
	}

	else
	{
		if (empty($_POST['clave']))
		{
			echo "No puedes dejar la clave vacia";
			echo "<br>";
			echo "<a href='Viviendaszub.html'>Volver al formulario</a>";
		}

		else
		{

				//seleccionar datos usuario
			$usuario = $_POST['usuario'];
			$clave = $_POST['clave'];

			$conectar = conectar();

			$datos = "SELECT pasahitza FROM  erabiltzaileak WHERE izena =?";
//ejecutar el select
			$stmt = mysqli_prepare($conectar, $datos);

			mysqli_stmt_bind_param($stmt, "s", $usuario);

			$query = mysqli_stmt_execute($stmt);

//verificar que se han insertado los valores
			if (!$query) 
			{
				echo "Ocurrió un error";
			}

			else 
			{
				mysqli_stmt_bind_result($stmt, $clave1);

				$lineas = mysqli_stmt_fetch($stmt);

				if ($lineas)
				{
					$hash_passwd = $clave;

					$comprobar = password_verify($clave, $hash_passwd);

					if($comprobar || $clave == $clave1)
					{
						mysqli_stmt_close($stmt);

						session_start();

						$_SESSION['usuario'] = $_POST['usuario'];
						$_SESSION['clave'] = $_POST['clave'];
						echo "El usuario ".$usuario." se ha logeado correctamente";
						echo "<br><br><a href='VPrincipal.php'>IR AL MENU PRINCIPAL</a>";
					}

					else
					{
						echo "La contraseña es incorrecta";
					}

				}

				else
				{
					echo "No existe el usuario. Registrese o vuelva al formulario.";
					echo "<br><br><a href='VRegistro.php?registro'>REGISTRARSE</a>";
					echo "<br><br><a href='Viviendaszub.html'>VOLVER AL FORMULARIO</a>";
				}
			}
			mysqli_close($conectar);
		}
	}
}

if (isset($_POST['invitado']))
{
	session_start();

	$_SESSION['usuario'] = 'invitado';
	$_SESSION['clave'] = 'invitado';

	$usuario = $_SESSION['usuario'];

	echo "Está usando el acceso para invitados";
	echo "<br><br><a href='VPrincipal.php'>IR AL MENU PRINCIPAL</a>";
}

if (isset($_GET['registro']))
{
	echo "<body>
	<h2>INSERTE LOS DATOS DEL NUEVO USUARIO</h2>
	<form action='VRegistro.php?registro' method='post'>
	<p>Login del nuevo usuario: <input type='text' name='usuarioN'></p>
	<p>Nombre del nuevo usuario: <input type='text' name='nombreN'></p>
	<p>Clave del nuevo usuario: <input type='password' name='claveN'></p>
	<p><input type='submit' name='crearU' value='Crear usuario'></p>
	</form>
	<p><a href='Viviendaszub.html'>Cambiar de usuario (Volver al inicio de sesión)</a></p>
	</body>
	</html>";

	if (isset($_POST['crearU']))
	{
//comprobar que no se ha quedado ningún apartado vacio
		if (empty($_POST['usuarioN']))
		{
			echo "No puedes dejar el login vacio";
		}

		else
		{
			if (empty($_POST['nombreN']))
			{
				echo "No puedes dejar el nombre vacio";
			}

			else
			{
				if (empty($_POST['claveN']))
				{
					echo "No puedes dejar la clave vacia";
				}

				else
				{
					$usuarioN = $_POST['usuarioN'];

					$claveN = password_hash($_POST['claveN'], PASSWORD_DEFAULT);

					$conectar = conectar();

					$datos1 = "SELECT izena FROM  erabiltzaileak WHERE izena =?";
//ejecutar el select
					$stmt2 = mysqli_prepare($conectar, $datos1);

					mysqli_stmt_bind_param($stmt2, "s", $usuarioN);

					$query2 = mysqli_stmt_execute($stmt2);

//verificar que se han insertado los valores
					if (!$query2) 
					{
						echo "Ocurrió un error";
					}

					else 
					{

						$lineas2 = mysqli_stmt_fetch($stmt2);

						if ($lineas2)
						{
							echo "El usuario ya existe";
						}

						else
						{
//contar id
							mysqli_stmt_close($stmt2);

							$contar_id = "SELECT max(id) from erabiltzaileak";

							$query_1 = mysqli_query($conectar, $contar_id);

							if (!$query_1) 
							{
								echo "Ocurrió un error1";
							}

							$contar = mysqli_fetch_array($query_1);

							$contar_num = intval($contar[0]);

							$usuario_sig = $contar_num+1;


					//insertar nuevo usuario
							//$insertar = "INSERT INTO erabiltzaileak (id,izena,pasahitza) VALUES ('$usuario_sig','$usuarioN','$claveN')";

							$insertar = "INSERT INTO erabiltzaileak (id,izena,pasahitza) VALUES (?,?,?)";					

							$stmt3 = mysqli_prepare($conectar, $insertar);

							mysqli_stmt_bind_param($stmt3, "sss", $usuario_sig, $usuarioN, $claveN);

							$query_2 = mysqli_stmt_execute($stmt3);

							if (!$query_2)
							{
								echo "Ocurrió un error2";
							}

							else
							{
								echo "<br>Usuario registrado correctamente";
							}
						}
					}
					mysqli_close($conectar);
				}
			}	
		}
	}
}
?>