<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$letrero = $_GET['letrero'];

//Titulo de la Pagina
$let_pag = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$tit_pos_pagina = $row["tit_pos_pagina"];
}

//Coleccion del Letrero
$let_pag = "SELECT * FROM letrero_ima_prin WHERE id_letrero_ima_prin='$letrero'";
$let_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($let_pag)){ 
	$id_letrero = $row["id_letrero"];
	$id_ima_prin = $row["id_ima_prin"];
	$pos_letrero_ima_prin = $row["pos_letrero_ima_prin"];
	$tip_letrero_ima_prin = $row["tip_letrero_ima_prin"];
}

//Letrero
$let_pag = "SELECT * FROM letrero WHERE id_letrero='$id_letrero'";
$let_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($let_pag)){ 
	$ico_letrero = $row["ico_letrero"];
	$tit_letrero = $row["tit_letrero"];
	$des_letrero = $row["des_letrero"];
	$btn_letrero = $row["btn_letrero"];
	$link_letrero = $row["link_letrero"];
}

//Imagen
$let_pag = "SELECT * FROM ima_prin WHERE id_ima_prin='$id_ima_prin'";
$let_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($let_pag)){ 
	$arch_ima_prin = $row["arch_ima_prin"];
	$tit_ima_prin = $row["tit_ima_prin"];
	$lug_ima_prin = $row["lug_ima_prin"];
	$fec_ima_prin = $row["fec_ima_prin"];
	$des_ima_prin = $row["des_ima_prin"];
}

$fecha_hora=explode('--',$fec_ima_prin);
$fecha=$fecha_hora[0];
$hora=$fecha_hora[1];


if (!$_POST) {
	
} else {

	$ico = $_POST["ico_letrero"];
	$tit = $_POST["tit_letrero"];
	$des = $_POST["des_letrero"];
	$btn = $_POST["btn_letrero"];
	$link = $_POST["link_letrero"];

	$tit_ima = $_POST["tit_ima_prin"];
	$des_ima = $_POST["des_ima_prin"];
	$lug_ima = $_POST["lug_ima_prin"];

	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$fec_ima_prin = $fecha.'--'.$hora;

	$arch_ima_prin = $_POST["arch_ima_prin"];


	//Archivo
	$destino = $_SERVER['DOCUMENT_ROOT'].'/image/' ; //Destino donde se guardaran los archivos
	$tamano = $_FILES ['arch_ima_prin']['size']; //Tamaño del archivo 
	$val = intval($tamano);

	//Nombre con el que la imagen sera guardada
	$nombre = urls_amigables($tit_ima); 
	$lugar = urls_amigables($lug_ima);
	$fecha = urls_amigables($fec_ima_prin);

	//Cantidad de Imagenes Principales 
	$n_ima = "SELECT COUNT(id_ima_prin) FROM ima_prin";
	$max_ima = mysql_db_query($dbname, $n_ima);
	$max_ima = mysql_result($max_ima, 0);
	$sig_ima = $max_ima+1;
	$numero = add_ceros($sig_ima,3);
	
	//Tipo de Archivo 
	$arch=explode('.',$_FILES ['arch_ima_prin']['name']);
	$tipo_arch='.'.$arch[1];
	//Nombre de la Imagen Principal 
	$nom_ima_prin=$nombre.'-'.$lugar.'-'.$fecha.'-'.$numero.$tipo_arch;

	if( !empty($val)) {

		// Comprobamos el tamaño del archivo debe ser menor 600kb
		if( $tamano < 614400 ){

			@unlink($nom_ima_prin);
			
			move_uploaded_file ( $_FILES [ 'arch_ima_prin' ][ 'tmp_name' ], $destino.$nom_ima_prin); 
						
			//Editando Imagen
			$editar_imagen = "UPDATE ima_prin SET
						
								arch_ima_prin = '$nom_ima_prin',
								tit_ima_prin = '$tit_ima',
								lug_ima_prin = '$lug_ima',					
								fec_ima_prin = '$fec_ima_prin',
								des_ima_pri = '$des_ima'
								
								WHERE id_ima_prin='$id_ima_prin'";

			$cab_editar_imagen = mysql_db_query($dbname, $editar_imagen);

			//Nuevo Letrero
			$editar_letrero = "UPDATE letrero SET
						
								ico_letrero = '$ico',
								tit_letrero = '$tit',
								des_letrero = '$des',					
								btn_letrero = '$btn',
								link_letrero = '$link'
								
								WHERE id_letrero='$id_letrero'";

			$cab_editar_letrero = mysql_db_query($dbname, $editar_letrero);						

		} else { $error = "El archivo pesa mas de lo determinado"; }
	} else {

			//Editando Imagen
			$editar_imagen = "UPDATE ima_prin SET

								tit_ima_prin = '$tit_ima',
								lug_ima_prin = '$lug_ima',					
								fec_ima_prin = '$fec_ima_prin',
								des_ima_prin = '$des_ima'
								
								WHERE id_ima_prin='$id_ima_prin'";

			$cab_editar_imagen = mysql_db_query($dbname, $editar_imagen);

			//Nuevo Letrero
			$editar_letrero = "UPDATE letrero SET
						
								ico_letrero = '$ico',
								tit_letrero = '$tit',
								des_letrero = '$des',					
								btn_letrero = '$btn',
								link_letrero = '$link'
								
								WHERE id_letrero='$id_letrero'";

			$cab_editar_letrero = mysql_db_query($dbname, $editar_letrero);	


	}
	header("location: letrero_edit.php?id=$ids&letrero=$letrero");
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

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Imagenes Principales</title>
	</head>
	<body onload="cuentaDescripcion();">

		<div class="row contorno">
			<div class="text-center">
				<a class="btn btn-sitio pull-right" href="imagen_prin.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
				<br>
				<h4>Coleccion del Carrusel » <?=$tit_pos_pagina?> » <?=$tip_letrero_ima_prin?> » <?=$pos_letrero_ima_prin?></h4>
				<div class="tour-caja">
					<figure>
						<img src="../image/<?=$arch_ima_prin?>" alt="<?=$tit_ima_prin?>" border="0">
					</figure>
				</div>
				<div>
					<form method="post" enctype="multipart/form-data" name="formulario" action="">

						<h4>Datos del Carrusel</h4>
						<br>
						<h5>Letrero</h5>

						<select name="ico_letrero">
							<option value="Sin Icono" <?php if ("Sin Icono"==$ico_letrero) { ?> selected <?php } ?>>Sin Icono</option>
							<option value="icon-tour" <?php if ("icon-tour"==$ico_letrero) { ?> selected <?php } ?>>Tour</option>
							<option value="icon-destino" <?php if ("icon-destino"==$ico_letrero) { ?> selected <?php } ?>>Destino</option>
							<option value="icon-opcion" <?php if ("icon-opcion"==$ico_letrero) { ?> selected <?php } ?>>Opcion de Viaje</option>
							<option value="icon-agencia" <?php if ("icon-agencia"==$ico_letrero) { ?> selected <?php } ?>>Agencia</option>
							<option value="icon-hotel" <?php if ("icon-hotel"==$ico_letrero) { ?> selected <?php } ?>>Alojamiento</option>
							<option value="icon-restaurante" <?php if ("icon-restaurante"==$ico_letrero) { ?> selected <?php } ?>>Restaurante</option>
							<option value="icon-tienda" <?php if ("icon-tienda"==$ico_letrero) { ?> selected <?php } ?>> Tienda</option>
							<option value="icon-souvenir" <?php if ("icon-souvenir"==$ico_letrero) { ?> selected <?php } ?>>Souvenir</option>
							<option value="icon-comida" <?php if ("icon-comida"==$ico_letrero) { ?> selected <?php } ?>>Comida Tipica</option>
							<option value="icon-sitio" <?php if ("icon-sitio"==$ico_letrero) { ?> selected <?php } ?>>Sitio Turistico</option>
							<option value="icon-actividad" <?php if ("icon-actividad"==$ico_letrero) { ?> selected <?php } ?>>Actividad Turistica</option>
							<option value="icon-tic" <?php if ("icon-tic"==$ico_letrero) { ?> selected <?php } ?>>Recomendacion Turistica</option>
						</select>
						<input name="tit_letrero" type="text" class="span5" placeholder="Titulo" required title="Titulo del Letrero" value="<?=$tit_letrero?>">

						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Pal.</small></small></span>
							<input type="text" id="pal_des" class="jerarquia" value="0">
						</div>
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Car.</small></small></span>
							<input type="text" id="car_des" class="jerarquia" value="0">
						</div>
						<br>
						<textarea name="des_letrero" rows="3" id="tex_des" name="des" class="span5" onKeyDown="cuentaDescripcion()" onKeyUp="cuentaDescripcion()" placeholder="Descripcion" required title="Se necesita una Descripcion del Letrero"><?=$des_letrero?></textarea>

						<input name="btn_letrero" type="text" class="span5" placeholder="Nombre del Boton" required title="Se necesita Nombre del Boton del letrero" value="<?=$btn_letrero?>">
						<input name="link_letrero" type="url" class="span5" placeholder="Link del Boton"  required title="Se necesita el enlace del Boton" value="<?=$link_letrero?>">

						<br>
						<h5>Datos del Posicionamiento de la Imagen</h5>
						<input name="tit_ima_prin" type="text" class="span5" placeholder="Titulo de la Imagen / Alt" required title="Se necesita el titulo de la Imagen" value="<?=$tit_ima_prin?>">
						<textarea name="des_ima_prin" rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"><?=$des_ima_prin?></textarea>
						<input name="lug_ima_prin" type="text" class="span5" placeholder="Lugar de la Imagen"  required title="Se necesita el lugar de la Imagen" value="<?=$lug_ima_prin?>">
						<label>
							<h6>Fecha de la Imagen</h6>
							<input name="fecha" type="date" required title="Se necesita la fecha de la Imagen" value="<?=$fecha?>">
							<input name="hora" type="time" class="hora" value="<?=$hora?>">
						</label>
						<h6>Archivo de la Imagen</h6>
						<input name="arch_ima_prin" type="file" class="txt">
						<br>
						<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>