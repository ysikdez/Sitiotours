<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_tprecio = $_GET['id_tprecio'];
$ingresada = $_GET['error'];



//Datos de la Pagina
$datos_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$datos_pag = mysql_db_query($dbname, $datos_pag); 
if ($row = mysql_fetch_array($datos_pag)){ 

	$id_idi = $row["id_idioma"];
	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];

}

//Datos del Precio del Tour
$datos_pag = "SELECT * FROM tprecio WHERE id_tprecio='$id_tprecio'";
$datos_pag = mysql_db_query($dbname, $datos_pag); 
if ($row = mysql_fetch_array($datos_pag)){ 

	$per_tprecio = $row["per_tprecio"];
	$val_tprecio = $row["val_tprecio"];
	$ini_tprecio = $row["ini_tprecio"];
	$fin_tprecio = $row["fin_tprecio"];
	$ofe_tprecio = $row["ofe_tprecio"];
	$val_ofe_tprecio = $row["val_ofe_tprecio"];
	$act_tprecio = $row["act_tprecio"];
	$des_tprecio = $row["des_tprecio"];
	$vis_tprecio = $row["vis_tprecio"];

}

if (!$_POST) {
	
} else {

	$per = $_POST["per"];
	$val = $_POST["val"];
	$ini = $_POST["ini"];
	$fin = $_POST["fin"];
	$ofe = $_POST["ofe"];
	$val_ofe = $_POST["val_ofe"];
	$act = $_POST["act"];
	$des = $_POST["des"];
	$vis = $_POST["vis"];

	//Editar el Precio
	$editar_precio = "UPDATE tprecio SET

						per_tprecio = '$per',
						val_tprecio = '$val',
						ini_tprecio = '$ini',
						fin_tprecio = '$fin',
						ofe_tprecio = '$ofe',
						val_ofe_tprecio = '$val_ofe',
						act_tprecio = '$act',
						des_tprecio = '$des',
						vis_tprecio = '$vis'

						WHERE id_tprecio='$id_tprecio'";

	$cab_editar_precio = mysql_db_query($dbname, $editar_precio);		

	header("location: dise_tour_precio_edit.php?id=$ids&id_tprecio=$id_tprecio&error=$error");
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
		<title>Editar Precio</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_tour_precio.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>

			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h3>Editar el Precio del Tour » <?=$tit_pos_pag?> </h3>

						<h4>Ingrese Caracteristicas del Nuevo Precio</h4>
						<h5>Nª de Personas »</h5>
						<input type="text" name="per" class="input-mini" placeholder="10" value="<?=$per_tprecio?>">
						<br>
						<h5>Precio estimado en USD »</h5>
						<input type="text" name="val" class="input-mini" placeholder="100.00" value="<?=$val_tprecio?>">
						<br><br>
						<h5>Duracion de la Vigencia del Precio »</h5>
						<h5>Fecha de Inicio » </h5>
						<input type="date" name="ini" value="<?=$ini_tprecio?>">
						<h5>Fecha de Termino » </h5>
						<input type="date" name="fin" value="<?=$fin_tprecio?>">
						<br>
						<br>
						<h5>Oferta »</h5>
						<small>Si es una Oferta ingrese el valor del precio de esta en Porcentaje 30%</small>
						<br><br>
						<select class="input-mini"  name="ofe">
							<option value="1" <?php if ($ofe_tprecio==1) { ?> selected <?php }?>>si</option>
							<option value="0" <?php if ($ofe_tprecio==0) { ?> selected <?php }?>>no</option>
						</select>
						<input type="text" name="val_ofe" class="input-mini" placeholder="30" value="<?=$val_ofe_tprecio*100?>"> <strong> %</strong>
						<br>
						<br>
						<h5>Activo »
							<select class="input-mini"  name="act">
								<option value="1" <?php if ($act_tprecio==1) { ?> selected <?php }?>>si</option>
								<option value="0" <?php if ($act_tprecio==0) { ?> selected <?php }?>>no</option>
							</select>
						</h5>
						<h5>Visible »
							<select class="input-mini"  name="vis">
								<option value="1" <?php if ($vis_tprecio==1) { ?> selected <?php }?>>si</option>
								<option value="0" <?php if ($vis_tprecio==0) { ?> selected <?php }?>>no</option>
							</select>
						</h5>
						<br>
						<label>
							<h5>Descripcion del Precio »</h5>
							<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Precio"><?=$des_tprecio?></textarea>
						</label>	

				<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
			</form>
		</div>
	</body>
</html>