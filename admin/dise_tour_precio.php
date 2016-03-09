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

	$per_pag = $row["per_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
}

//Datos de la Pagina Padre
$datos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$datos_pag_pad = mysql_db_query($dbname, $datos_pag_pad); 
if ($row = mysql_fetch_array($datos_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"];}

//Datos de Tour
$datos_tour = "SELECT * FROM tour WHERE id_pagina='$ids'";
$datos_tour = mysql_db_query($dbname, $datos_tour); 
if ($row = mysql_fetch_array($datos_tour)){ $id_pag_tour = $row["id_tour"];}


//Numero de Precios del Tour
$numero_tprecio = "SELECT COUNT(id_tprecio) FROM tprecio WHERE id_tour='$id_pag_tour'";
$numero_tprecio = mysql_db_query($dbname, $numero_tprecio);
$numero_tprecio = mysql_result($numero_tprecio, 0);
//Precio Siguiente
$sig_tprecio = $numero_tprecio + 1;


if (!$_POST) {
	
} else {

	$persona = $_POST["persona"];
	$precio = $_POST["precio"];
	$inicio = $_POST["inicio"];
	$fin = $_POST["fin"];
	$oferta = $_POST["oferta"];
	$valor_oferta = $_POST["valor_oferta"];
	$activo = $_POST["activo"];
	$visible = $_POST["visible"];

	$des_precio = $_POST["des_precio"];

	$valor_oferta = $valor_oferta / 100;

	//Nuevo Precio del TOur
	$nuevo_precio = "INSERT INTO tprecio (

							id_tour,
							per_tprecio,
							val_tprecio,
							ini_tprecio,
							fin_tprecio,
							ofe_tprecio,
							val_ofe_tprecio,
							des_tprecio,
							act_tprecio,
							vis_tprecio

						) VALUES(

							'$id_pag_tour',
							'$persona',
							'$precio',
							'$inicio',
							'$fin',
							'$oferta',
							'$valor_oferta',
							'$des_precio',
							'$activo',
							'$visible'

						)";

	$cab_nuevo_precio = mysql_db_query($dbname, $nuevo_precio);	
	$error=$id_gen;

	header("location: dise_tour_precio.php?id=$ids&error=$error");
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
		<title>Precios del Tour</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_tour.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Precios del Tour » <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_com_pag?></h4>
			<hr>

			<h4>Precios »</h4>
			<br>
			<strong><small>
				<p class="personas">Nª Per</p>|
				<p class="precio">USD</p>|
				<p class="duracion">Duracion</p>|
				<p class="oferta">Ofe.</p>|
				<p class="activo">Vis.</p>
			</small></strong>
<?php

//Datos de los Precios de los Tours
$gen_pag = "SELECT * FROM tprecio WHERE id_tour='$id_pag_tour' ORDER BY per_tprecio";
$gene_pag = mysql_db_query($dbname, $gen_pag); 
while ($row = mysql_fetch_array($gene_pag)){ 

	$id_tprecio = $row["id_tprecio"];
	$per_tprecio = $row["per_tprecio"];
	$val_tprecio = $row["val_tprecio"];
	$ini_tprecio = $row["ini_tprecio"];
	$fin_tprecio = $row["fin_tprecio"];
	$ofe_tprecio = $row["ofe_tprecio"];
	$vis_tprecio = $row["vis_tprecio"];
?>

			<div class="destino-caja">
				<p class="personas"><strong><?=$per_tprecio?></strong></p> 					
				<p class="precio"><small><?=$val_tprecio?></small></p>
				<p class="duracion"> <small><small><?=$ini_tprecio?></small></small> - <small><small><?=$fin_tprecio?></small></small></p>
				<p class="oferta"><small><?php if ($ofe_tprecio==1) { ?> si <?php }else{?> no <?php }?></small></p>
				<p class="activo"><small><?php if ($vis_tprecio==1) { ?> si <?php }else{?> no <?php }?></small></p>
				<a href="dise_tour_precio_eli.php?id=<?=$ids?>&id_tprecio=<?=$id_tprecio?>"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
				<a href="dise_tour_precio_edit.php?id=<?=$ids?>&id_tprecio=<?=$id_tprecio?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
			</div>
<?php 
}
?>
			<br>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevoprecio"><i class="icon-plus"></i></a>
			<br>
			<hr>


			<div id="nuevoprecio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="precio" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="precio">Nuevo precio <?=$new_tprecio?>» </h3>
					</div>
					<div class="modal-body text-center">
						<h4>Ingrese Caracteristicas del Nuevo Precio</h4>
						<h5>Nª de Personas »</h5>
						<input type="text" name="persona" class="input-mini" placeholder="10">
						<br>
						<h5>Precio estimado en USD »</h5>
						<input type="text" name="precio" class="input-mini" placeholder="100.00">
						<br><br>
						<h5>Duracion de la Vigencia del Precio »</h5>
						<h5>Fecha de Inicio » </h5>
						<input type="date" name="inicio">
						<h5>Fecha de Termino » </h5>
						<input type="date" name="fin">
						<br>
						<br>
						<h5>Oferta »</h5>
						<small>Si es una Oferta ingrese el valor del precio de esta en Porcentaje 30%</small>
						<br><br>
						<select class="input-mini"  name="oferta">
							<option value="1">si</option>
							<option value="0">no</option>
						</select>
						<input type="text" name="valor_oferta" class="input-mini" placeholder="30"> <strong> %</strong>
						<br>
						<br>
						<h5>Activo »
							<select class="input-mini"  name="activo">
								<option value="1">si</option>
								<option value="0">no</option>
							</select>
						</h5>
						<h5>Visible »
							<select class="input-mini"  name="visible">
								<option value="1">si</option>
								<option value="0">no</option>
							</select>
						</h5>
						<br>
						<label>
							<h5>Descripcion del Precio »</h5>
							<textarea class="ckeditor span5" name="des_precio" placeholder="Descripcion del Precio"></textarea>
						</label>					
					</div>		
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<button class="btn btn-primary btn-sitio">Guardar</button>
					</div>
				</form>
			</div>

		</div>
	</body>
</html>