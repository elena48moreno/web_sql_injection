<?php
session_start();
unset($_SESSION['usuario']);
unset($_SESSION['clave']);
session_destroy();

echo "<!DOCTYPE html>
<html>
<head>
<title>SALIDA</title>
<meta charset='utf-8'>
<body>
Gracias por la visita
<br><br> <a href='Viviendaszub.html'>Iniciar sesión</a>
</body>
</html>
";
?>