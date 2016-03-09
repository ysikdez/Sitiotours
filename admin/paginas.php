<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");
$ingresada = $_GET['error'];

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link href="../css/bootstrap.css" rel="stylesheet">
		<link href="css/estilos.css" rel="stylesheet">
		<link href="../img/ico-sitiotours.png" rel="shortcut icon">

		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.js"></script>

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Paginas</title>
	</head>

	<body>
		<div class="row contorno">
			<h3>Páginas</h3>
			<div class="accordion text-justify">

<?php

	for ($i=0; $i <= 1 ; $i++) {
		Paginas($dbname,1,$i);
	}

?>

			</div>
		</div>
<?php

if ($ingresada!=1) {
	?>
		<script type="text/javascript">
			window.open('inicio.html', 'edicion', '');
		</script>
<?php
} 
?>
	</body>
</html>
