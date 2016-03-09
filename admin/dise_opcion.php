<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$ingresada = $_GET['error'];



//Datos de la Pagina
$pos_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 

	$id_idi = $row["id_idioma"];
	$cod_pag = $row["cod_pagina"];

	$per_pag = $row["per_pagina"];

	$dise_pag = $row["dise_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
	
	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];

}

//Datos de la Pagina Padre ---- Tipo del Destino que lo Agrupa
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }

//Datos del Destino
$datos_opcion = "SELECT * FROM opcion WHERE id_pagina='$ids'";
$datos_opcion = mysql_db_query($dbname, $datos_opcion); 
if ($row = mysql_fetch_array($datos_opcion)){ 

	$id_opcion = $row["id_opcion"];
	$cod_opcion = $row["cod_opcion"];
	$des_opcion = $row["des_opcion"];

}


if (!$_POST) {
	
} else {

	$des = $_POST["des"];

	$dise_opcion = "UPDATE opcion SET des_opcion = '$des' WHERE id_opcion='$id_opcion'";
	$db_opcion = mysql_db_query($dbname, $dise_opcion);

	header("location: dise_opcion.php?id=$ids&error=$error");
}

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
		<script src="ckeditor/ckeditor.js"></script>

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Editar Paginas</title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h4 class="pull-right">Codigo : <?=$cod_pag?></h4>
				<h3>Editar Opcion de Viaje » </h3>						
				<h4>» <?=$tit_pos_pag_pad?></h4> 
				<h5>» <?=$tit_pos_pag?></h5>
				<br>
				<h5>Codigo de la Opcion de Viaje » <?=$cod_opcion?></h5>
				<hr>
				<h5>Galeria: Fotos »
					<a class="btn btn-sitio pull-right" href="galeria_foto.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
				<h5>Galeria: Videos »
					<a class="btn btn-sitio pull-right" href="galeria_video.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
				<h5>Red Social »
					<a class="btn btn-sitio pull-right" href="social.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
				<div class="text-center">
					<h5>Contenido de la Opcion de Viaje »</h5>
					<textarea class="ckeditor span5" name="des" required title="Se necesita el contenido de la Opcion de Viaje"><?=$des_opcion?></textarea>
					<br>

					<br>
					<button class="btn btn-primary btn-sitio">Guardar</button>
				</div>
			</form>
		</div>
	</body>
</html>