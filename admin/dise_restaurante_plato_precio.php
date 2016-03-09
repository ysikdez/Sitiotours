<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_plato = $_GET['id_plato'];
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

//Datos de la restaurante
$datos_restaurante = "SELECT * FROM restaurante WHERE id_pagina='$ids'";
$datos_restaurante = mysql_db_query($dbname, $datos_restaurante); 
if ($row = mysql_fetch_array($datos_restaurante)){ $id_restaurante = $row["id_restaurante"]; }

//Datos del Plato
$datos_plato = "SELECT * FROM plato WHERE id_plato='$id_plato'";
$datos_plato = mysql_db_query($dbname, $datos_plato); 
if ($row = mysql_fetch_array($datos_plato)){ 
	$ord_plato = $row["ord_plato"]; 
	$nom_plato = $row["nom_plato"]; 
}

//Numero de platos y Nuevas platos
$numero_platos = "SELECT COUNT(ord_plato) FROM plato WHERE id_restaurante='$id_restaurante'";
$numero_platos = mysql_db_query($dbname, $numero_platos);
$numero_platos = mysql_result($numero_platos, 0);


if (!$_POST) {
	
} else {

	$pla = $_POST["pla"];
	$val = $_POST["val"];
	$ini = $_POST["ini"];
	$fin = $_POST["fin"];
	$ofe = $_POST["ofe"];
	$val_ofe = $_POST["val_ofe"];
	$act = $_POST["act"];
	$vis = $_POST["vis"];

	$des = $_POST["des"];

	$val = number_format($val, 2);
	$val_ofe = round($val_ofe / 100);
	
	//Nuevo Plato del Plato
	$nuevo_precio = "INSERT INTO pprecio (

							id_plato,
							ord_pprecio,
							pla_pprecio,
							val_pprecio,
							ini_pprecio,
							fin_pprecio,
							ofe_pprecio,
							val_ofe_pprecio,
							des_pprecio,
							act_pprecio,
							vis_pprecio

						) VALUES(

							'$id_plato',
							'$new_precio',
							'$pla',
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

	header("location: dise_restaurante_menu.php?id=$ids&error=$error");
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
		<title>Plato del Restaurante</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_restaurante_menu.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Nuevo Plato » <?=$new_precio?></h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<h4>» <?=$nom_plato?></h4>

			<br>
			<div>
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="text-center">
						<h4>Ingrese Caracteristicas del Nuevo Plato</h4>
						<h5>Porcion / Medicion del Plato »</h5>
						<input type="text" name="pla" placeholder="Mediano">
						<br>
						<h5>Plato estimado en USD »</h5>
						<input type="text" name="val" class="input-mini" placeholder="100.00">
						<br><br>
						<h5>Duracion de la Vigencia del Plato »</h5>
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
							<h5>Descripcion del Plato »</h5>
							<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Plato"></textarea>
						</label>
					</div>
					<br>
					<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
				</form>
			</div>
		</div>
	</body>
</html>