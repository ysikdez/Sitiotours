<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_habitacion = $_GET['id_habitacion'];
$new_precio = $_GET['new_precio'];
$error = $_GET['error'];


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
if ($row = mysql_fetch_array($datos_alojamiento)){ $id_alojamiento = $row["id_alojamiento"]; }

//Datos de la Habitacion
$datos_habitacion = "SELECT * FROM habitacion WHERE id_habitacion='$id_habitacion'";
$datos_habitacion = mysql_db_query($dbname, $datos_habitacion); 
if ($row = mysql_fetch_array($datos_habitacion)){ 
	$tip_habitacion = $row["tip_habitacion"]; 
	$nom_habitacion = $row["nom_habitacion"]; 
}

//Numero de Habitaciones y Nuevas Habitaciones
$numero_habitaciones = "SELECT COUNT(ord_habitacion) FROM habitacion WHERE id_alojamiento='$id_alojamiento'";
$numero_habitaciones = mysql_db_query($dbname, $numero_habitaciones);
$numero_habitaciones = mysql_result($numero_habitaciones, 0);
// $new_habitaciones = $numero_habitaciones +1;


if (!$_POST) {
	
} else {

	$hab = $_POST["hab"];
	$val = $_POST["val"];
	$ini = $_POST["ini"];
	$fin = $_POST["fin"];
	$ofe = $_POST["ofe"];
	$val_ofe = $_POST["val_ofe"];
	$act = $_POST["act"];
	$vis = $_POST["vis"];

	$des = $_POST["des"];

	$val_ofe = $val_ofe / 100;

	//Nuevo Precio del TOur
	$nuevo_precio = "INSERT INTO hprecio (

							id_habitacion,
							ord_hprecio,
							hab_hprecio,
							val_hprecio,
							ini_hprecio,
							fin_hprecio,
							ofe_hprecio,
							val_ofe_hprecio,
							des_hprecio,
							act_hprecio,
							vis_hprecio

						) VALUES(

							'$id_habitacion',
							'$new_precio',
							'$hab',
							'$val',
							'$ini',
							'$fin',
							'$ofe',
							'$val_ofe',
							'$des',
							'$act',
							'$vis'

						)";

	$cab_nuevo_precio = mysql_db_query($dbname, $nuevo_precio);	
	$error=$id_gen;	

	header("location: dise_alojamiento_habitacion.php?id=$ids&error=$error");
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
			<h3>Nuevo Precio » <?=$new_precio?></h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<h4>» <?=$nom_habitacion?> - <?=$tip_habitacion?></h4>

			<br>
			<div>
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="text-center">
						<h4>Ingrese Caracteristicas del Nuevo Precio</h4>
						<h5>Nª de Habitaciones »</h5>
						<input type="text" name="hab" class="input-mini" placeholder="10">
						<br>
						<h5>Precio estimado en USD »</h5>
						<input type="text" name="val" class="input-mini" placeholder="100.00">
						<br><br>
						<h5>Duracion de la Vigencia del Precio »</h5>
						<h5>Fecha de Inicio » </h5>
						<input type="date" name="ini">
						<h5>Fecha de Termino » </h5>
						<input type="date" name="fin">
						<br>
						<br>
						<h5>Oferta »</h5>
						<small>Si es una Oferta ingrese el valor del precio de esta en Porcentaje 30%</small>
						<br><br>
						<select class="input-mini"  name="ofe">
							<option value="1">si</option>
							<option value="0">no</option>
						</select>
						<input type="text" name="val_ofe" class="input-mini" placeholder="30"> <strong> %</strong>
						<br>
						<br>
						<h5>Activo »
							<select class="input-mini"  name="act">
								<option value="1">si</option>
								<option value="0">no</option>
							</select>
						</h5>
						<h5>Visible »
							<select class="input-mini"  name="vis">
								<option value="1">si</option>
								<option value="0">no</option>
							</select>
						</h5>
						<br>
						<label>
							<h5>Descripcion del Precio »</h5>
							<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Precio"></textarea>
						</label>
					</div>
					<br>
					<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
				</form>
			</div>
		</div>
	</body>
</html>