<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_detalle = $_GET['id_detalle'];
$ingresada = $_GET['error'];



//Datos de la Pagina
$pos_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 

	$id_idi = $row["id_idioma"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];

}

//Datos de Detalle
$pos_det= "SELECT * FROM detalle WHERE id_detalle='$id_detalle'";
$posi_det = mysql_db_query($dbname, $pos_det); 
if ($row = mysql_fetch_array($posi_det)){ 

	$ord_detalle = $row["ord_detalle"];
	$tit_detalle = $row["tit_detalle"];
	$des_detalle = $row["des_detalle"];

}


if (!$_POST) {
	
} else {

	$tit_detalle = $_POST["tit_detalle"];
	$des_detalle = $_POST["des_detalle"];

	//Datos de la Pagina
	$pos_pag = "SELECT abre_idioma FROM idioma WHERE id_idioma='$idi'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ $abre_idioma = $row["abre_idioma"];}

	$editar_detalle = "UPDATE detalle SET

						tit_detalle = '$tit_detalle',
						des_detalle = '$des_detalle'

						WHERE id_detalle='$id_detalle'";

	$cab_editar_detalle = mysql_db_query($dbname, $editar_detalle);		

	header("location: dise_general_detalle_edit.php?id=$ids&id_detalle=$id_detalle&error=$error");
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
		<title>Editar Detalle</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_general_detalle.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>

			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h3><?=$tit_pos_pag?> » Editar Detalle » <?=$ord_detalle?> </h3>

				<br>

				<h5>Nombre Pagina / Titulo</h5>
				<label>
					<h5>Titulo del Detalle »</h5>
					<input type="text" name="tit_detalle" class="span5" placeholder="Titulo de la Imagen / Alt" required title="Se necesita el titulo" value="<?=$tit_detalle?>">
				</label>
				<label>
					<h5>Descripcion del Detalle »</h5>
					<textarea class="ckeditor span5" name="des_detalle" required title="Se necesita la descripcion"><?=$des_detalle?></textarea>
				</label>

				<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
			</form>
		</div>
	</body>
</html>