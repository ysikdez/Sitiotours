<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_articulo = $_GET['id_articulo'];
$id_aprecio = $_GET['id_aprecio'];
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

//Datos de la tienda
$datos_tienda = "SELECT * FROM tienda WHERE id_pagina='$ids'";
$datos_tienda = mysql_db_query($dbname, $datos_tienda); 
if ($row = mysql_fetch_array($datos_tienda)){ $id_tienda = $row["id_tienda"]; }

//Datos del Arcticulo
$datos_articulo = "SELECT * FROM articulo WHERE id_articulo='$id_articulo'";
$datos_articulo = mysql_db_query($dbname, $datos_articulo); 
if ($row = mysql_fetch_array($datos_articulo)){ 
	$ord_articulo = $row["ord_articulo"]; 
	$tit_articulo = $row["tit_articulo"]; 
}

//Datos del Precio del Arcticulo
$datos_precio_articulo = "SELECT * FROM aprecio WHERE id_aprecio='$id_aprecio'";
$datos_precio_articulo = mysql_db_query($dbname, $datos_precio_articulo); 
if ($row = mysql_fetch_array($datos_precio_articulo)){ 
	$uni_aprecio = $row["uni_aprecio"]; 
	$val_aprecio = $row["val_aprecio"]; 
	$ini_aprecio = $row["ini_aprecio"]; 
	$fin_aprecio = $row["fin_aprecio"]; 
	$ofe_aprecio = $row["ofe_aprecio"]; 
	$val_ofe_aprecio = $row["val_ofe_aprecio"]; 
	$act_aprecio = $row["act_aprecio"]; 
	$vis_aprecio = $row["vis_aprecio"]; 
	$des_aprecio = $row["des_aprecio"]; 
	$ord_aprecio = $row["ord_aprecio"]; 
}

//Numero de Habitaciones y Nuevas Habitaciones
$numero_articulos = "SELECT COUNT(ord_articulo) FROM articulo WHERE id_tienda='$id_tienda'";
$numero_articulos = mysql_db_query($dbname, $numero_articulos);
$numero_articulos = mysql_result($numero_articulos, 0);
// $new_articuloes = $numero_articulos +1;


if (!$_POST) {
	
} else {

	$uni = $_POST["uni"];
	$val = $_POST["val"];
	$ini = $_POST["ini"];
	$fin = $_POST["fin"];
	$ofe = $_POST["ofe"];
	$val_ofe = $_POST["val_ofe"];
	$act = $_POST["act"];
	$vis = $_POST["vis"];

	$des = $_POST["des"];

	$val_ofe = $val_ofe / 100;

	// Editar Precio el precio
	$editar_precio_articulo = "UPDATE aprecio SET 

							uni_aprecio = '$uni',
							val_aprecio = '$val',
							ini_aprecio = '$ini',
							fin_aprecio = '$fin',
							ofe_aprecio = '$ofe',
							val_ofe_aprecio = '$val_ofe',
							act_aprecio = '$act',
							vis_aprecio = '$vis',
							des_aprecio = '$des'

							WHERE id_aprecio='$id_aprecio'";

	$db_editar_precio_articulo = mysql_db_query($dbname, $editar_precio_articulo);

	header("location: dise_tienda_articulo_precio_edit.php?id=$ids&id_articulo=$id_articulo&id_aprecio=$id_aprecio&error=$error");
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
		<title>Editar el Precio del Plato</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_tienda_catalogo.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Editar Precio » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<h4>» <?=$tit_articulo?> </h4>

			<br>
			<div>
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="text-center">
						<h4>Ingrese Caracteristicas del Precio</h4>
						<h5>Porcion / Medicion del Plato »</h5>
						<input type="text" name="uni" uniceholder="3 Und." value="<?=$uni_aprecio?>">
						<br>
						<h5>Precio estimado en USD »</h5>
						<input type="text" name="val" class="input-mini" uniceholder="100.00" value="<?=$val_aprecio?>">
						<br><br>
						<h5>Duracion de la Vigencia del Precio »</h5>
						<h5>Fecha de Inicio » </h5>
						<input type="date" name="ini" value="<?=$ini_aprecio?>">
						<h5>Fecha de Termino » </h5>
						<input type="date" name="fin" value="<?=$fin_aprecio?>">
						<br>
						<br>
						<h5>Oferta »</h5>
						<small>Si es una Oferta ingrese el valor del precio de esta en Porcentaje 30%</small>
						<br><br>
						<select class="input-mini"  name="ofe">
							<option value="1" <?php if ($ofe_aprecio=="1") { ?> selected <?php }?>>si</option>
							<option value="0" <?php if ($ofe_aprecio=="0") { ?> selected <?php }?>>no</option>
						</select>
						<input type="text" name="val_ofe" class="input-mini" uniceholder="30" value="<?=$val_ofe_aprecio*100?>"> <strong> %</strong>
						<br>
						<br>
						<h5>Activo »
							<select class="input-mini"  name="act">
								<option value="1" <?php if ($act_aprecio=="1") { ?> selected <?php }?>>si</option>
								<option value="0" <?php if ($act_aprecio=="0") { ?> selected <?php }?>>no</option>
							</select>
						</h5>
						<h5>Visible »
							<select class="input-mini"  name="vis">
								<option value="1" <?php if ($vis_aprecio=="1") { ?> selected <?php }?>>si</option>
								<option value="0" <?php if ($vis_aprecio=="0") { ?> selected <?php }?>>no</option>
							</select>
						</h5>
						<br>
						<label>
							<h5>Descripcion del Precio »</h5>
							<textarea class="ckeditor span5" name="des" uniceholder="Descripcion del Precio"><?=$des_aprecio?></textarea>
						</label>
					</div>
					<br>
					<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
				</form>
			</div>
		</div>
	</body>
</html>