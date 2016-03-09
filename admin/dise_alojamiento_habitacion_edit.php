<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$error = $_GET['error'];
$id_habitacion = $_GET['id_habitacion'];



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

//Datos de la Pagina Padre ---- 
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }

//Datos de la alojamiento
$datos_alojamiento = "SELECT * FROM alojamiento WHERE id_pagina='$ids'";
$datos_alojamiento = mysql_db_query($dbname, $datos_alojamiento); 
if ($row = mysql_fetch_array($datos_alojamiento)){ 
	$id_alojamiento = $row["id_alojamiento"]; 
	$ord_alojamiento = $row["ord_alojamiento"]; 
}

//Datos de la Habitacion
$datos_habitacion = "SELECT * FROM habitacion WHERE id_habitacion='$id_habitacion'";
$datos_habitacion = mysql_db_query($dbname, $datos_habitacion); 
if ($row = mysql_fetch_array($datos_habitacion)){ 

	$ord_habitacion = $row["ord_habitacion"]; 
	$tip_habitacion = $row["tip_habitacion"]; 
	$nom_habitacion = $row["nom_habitacion"]; 
	$des_habitacion = $row["des_habitacion"]; 
}


if (!$_POST) {
	
} else {

	$tip = $_POST["tip"];
	$nom = $_POST["nom"];
	$des = $_POST["des"];

	$editar_habitacion = "UPDATE habitacion SET tip_habitacion = '$tip',nom_habitacion = '$nom',des_habitacion = '$des' WHERE id_habitacion='$id_habitacion'";
	$db_editar_habitacion = mysql_db_query($dbname, $editar_habitacion);

	header("location: dise_alojamiento_habitacion_edit.php?id=$ids&id_habitacion=$id_habitacion&error=$error");
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
		<title>Habitaciones del Alojamiento</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_alojamiento_habitacion.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Editar de Habitacion » <?=$ord_habitacion?></h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<div>
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class=" text-center">
						<h4>Ingrese Caracteristicas de la Habitacion</h4>
						<label>
							<h5>Nombre de la Habitacion » </h5>
							<input type="text" name="nom" placeholder="Ejemplo: Suite Presidensial" value="<?=$nom_habitacion?>">
						</label>

						<label>
							<h5>Tipo de la Habitacion »</h5>
							<select name="tip">
								<option <?php if ($tip_habitacion=="Simple") { ?> selected <?php } ?> value="Simple">Simple</option>
								<option <?php if ($tip_habitacion=="Doble") { ?> selected <?php } ?> value="Doble">Doble</option>
								<option <?php if ($tip_habitacion=="Matrimonial") { ?> selected <?php } ?> value="Matrimonial">Matrimonial</option>
								<option <?php if ($tip_habitacion=="Triple") { ?> selected <?php } ?> value="Triple">Triple</option>
								<option <?php if ($tip_habitacion=="Cuadruple") { ?> selected <?php } ?> value="Cuadruple">Cuadruple</option>
								<option <?php if ($tip_habitacion=="Quintuple") { ?> selected <?php } ?> value="Quintuple">Quintuple</option>
							</select>
						</label>
						
						<br>
						<label>
							<h5>Descripcion de la Habitacion »</h5>
							<textarea class="ckeditor span5" name="des" placeholder="Descripcion de la Habitacion"><?=$des_habitacion?></textarea>
						</label>
						<br>											
						<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>