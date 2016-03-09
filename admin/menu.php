<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}

$salir = $_GET['salir'];

if ($salir=="on"){
session_unset();
session_destroy();
header("location: index.php");
}

include ("functions.php");										
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<link href="../css/bootstrap.css" rel="stylesheet">
		<link href="css/estilos.css" rel="stylesheet">
		<link href="../img/ico-sitiotours.png" rel="shortcut icon">
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.js"></script>
		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>SitioTours: Menu </title>
	</head>

	<body>
		<figure>
			<img src="../img/sitiotours-logo.png" alt="Logo Sitiotours.com" border="0" class="logo">
		</figure>
		<br>
		<p>
			<ul class="unstyled">
				<li class="text-right"><a href="inicio.php" target="seleccion" class="text">Inicio</a></li>
				<li class="text-right"><a href="paginas.php" target="seleccion" class="text">Paginas</a></li>
				<li class="text-right"><a href="edicion.php" target="seleccion" class="text">Edicion</a></li>
				<li class="text-right"><a href="configuracion.php" target="seleccion" class="text">Configuracion</a></li>
				<li class="text-right"><a href="?salir=on" target="_top" class="text">Salir </a></li>
			</ul>
		</p>
		
	</body>
</html>