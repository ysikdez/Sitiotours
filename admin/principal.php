<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	  <meta charset="UTF-8">
	  <script src="../js/jquery.js"></script>
	  <script src="../js/bootstrap.js"></script>
	  <link href="../img/ico-sitiotours.png" rel="shortcut icon">
	  <link href="css/estilo.css" type="text/css" rel="stylesheet" />
	  <link href="imagenes/logo.png" rel="shortcut icon">
	  <title>Sistema de Administracion Sitio Tours</title>
</head>

	<frameset cols="130,40%,*" frameborder="no" border="0" framespacing="0">
		<frame src="menu.php" name="menu" scrolling="no" id="menu">
		<frame src="inicio.html" name="seleccion" id="seleccion">
		<frame src="inicio.html" name="edicion" id="edicion">
		<noframes>
			Sorry, your browser does not handle frames!
		</noframes>
	</frameset>	
</html>
