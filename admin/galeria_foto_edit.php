<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_ima = $_GET['id_ima'];
$error = $_GET['error'];
$tipo = "Fotografica";

//Datos de la Pagina
$pos_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 

	$id_idi = $row["id_idioma"];

	$per_pag = $row["per_pagina"];
	$dise_pag = $row["dise_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
}

//Datos de la Pagina Padre
$datos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$datos_pag_pad = mysql_db_query($dbname, $datos_pag_pad); 
if ($row = mysql_fetch_array($datos_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"];}

//Existe ya la Galeria datos de la Galeria 
$dato_galeria = "SELECT * FROM galeria WHERE id_pagina='$ids' AND tipo_galeria='$tipo'";
$dato_galeria = mysql_db_query($dbname, $dato_galeria); 
if ($row = mysql_fetch_array($dato_galeria)){ 
	$id_galeria = $row["id_galeria"];
	$cod_galeria = $row["cod_galeria"];
}

//Galeria - Imagen - datos de la Galeria 
$dato_galeria_imagen = "SELECT * FROM galeria_imagen WHERE id_imagen='$id_ima' AND id_galeria='$id_galeria'";
$dato_galeria_imagen = mysql_db_query($dbname, $dato_galeria_imagen); 
if ($row = mysql_fetch_array($dato_galeria_imagen)){ $ord_gal_ima = $row["ord_galeria_imagen"];}

//Datos de la Imagen
$datos_imagen = "SELECT * FROM imagen WHERE id_imagen='$id_ima'";
$datos_imagen = mysql_db_query($dbname, $datos_imagen); 
if ($row = mysql_fetch_array($datos_imagen)){ 
	$arch_imagen = $row["arch_imagen"];	
	$tit_imagen = $row["tit_imagen"];	
	$lug_imagen = $row["lug_imagen"];	
	$des_imagen = $row["des_imagen"];	
	$fec_imagen = $row["fec_imagen"];
	$hor_imagen = $row["hor_imagen"];
	$vis_imagen = $row["vis_imagen"];
}


if (!$_POST) {
	
} else {

	$tit = $_POST["tit"];
	$des = $_POST["des"];
	$lug = $_POST["lug"];
	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$vis = $_POST["vis"];
	$arch = $_POST["arch"];

	//Datos de la Pagina Idioma
	$pos_pag = "SELECT abre_idioma FROM idioma WHERE id_idioma='$idi'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ $abre_idioma = $row["abre_idioma"];}

	//CODIGO DE LA GALERIA FOTOGRAFICA
	//Mayuscula
	$nom_pag=urls_amigables($tit_pos_pag);
	$t=strtoupper($nom_pag);
	//La primera 3 letras del tipo de tour
	$ti=str_split($t,3);
	$titulo=$ti[0];
	//Numero de la Galeria
	$orden=add_ceros($sig_galeria,4);
	//Idioma
	$idioma=strtoupper($abre_idioma);

	$txt='FOT'.$titulo.$orden.$idioma;
	$texto=str_split($txt,6);

	$codigo=$texto[0].'-'.$texto[1];

//******************************************//
//				   Imagen 					//
//******************************************//

	//Archivo
	$destino = $_SERVER['DOCUMENT_ROOT'].'/image/' ; //Destino donde se guardaran los archivos
	$tamano = $_FILES ['arch']['size']; //Tamaño del archivo 
	$val = intval($tamano);

	//Nombre con el que la imagen sera guardada
	$nombre = urls_amigables($tit); 
	$lugar_ima = urls_amigables($lug);
	$fecha_ima = urls_amigables($fecha);

	//Cantidad de Imagenes Principales 
	$n_ima = "SELECT COUNT(id_imagen) FROM imagen";
	$max_ima = mysql_db_query($dbname, $n_ima);
	$max_ima = mysql_result($max_ima, 0);
	$sig_ima = $max_ima+1;
	$numero = add_ceros($sig_ima,3);
	
	//Tipo de Archivo 
	$archivo=explode('.',$_FILES ['arch']['name']);
	$tipo_arch='.'.$archivo[1];
	//Nombre de la Imagen Principal 
	$nom_ima=$nombre.'-'.$lugar_ima.'-'.$fecha_ima.'-'.$numero.$tipo_arch;

//*****************************************//

//existe Galeria

if( !empty($val)) {
	// Comprobamos el tamaño del archivo debe ser menor 600kb
	if( $tamano < 614400 ){

		move_uploaded_file ( $_FILES [ 'arch' ][ 'tmp_name' ], $destino.$nom_ima);

		//Editar la Imagen del Album Fotografia
		$editar_imagen = "UPDATE imagen SET

								tit_imagen = '$tit',
								des_imagen = '$des',
								lug_imagen = '$lug',
								fec_imagen = '$fecha',
								hor_imagen = '$hora',
								vis_imagen = '$vis',
								arch_imagen = '$nom_ima'

							WHERE id_imagen ='$id_ima'";

		$cab_editar_imagen = mysql_db_query($dbname, $editar_imagen);

	} else { $error="La imagen No tiene el Tamaño Adecuado"; }

}else {
	//Editar la Imagen del Album Fotografia sin Imagen	
	$editar_imagen = "UPDATE imagen SET

							tit_imagen = '$tit',
							des_imagen = '$des',
							lug_imagen = '$lug',
							fec_imagen = '$fecha',
							hor_imagen = '$hora',
							vis_imagen = '$vis'

						WHERE id_imagen ='$id_ima'";

	$cab_editar_imagen = mysql_db_query($dbname, $editar_imagen);
}

	header("location: galeria_foto_edit.php?id=$ids&id_ima=$id_ima&error=$error");
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
		<title>Galeria de la Pagina </title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="galeria_foto.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Galeria de Fotos » </h3>
			<div class="text-center">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<h3 id="imagen"> Album » <?=$tit_pos_pag_pad?> » <?=$tit_pos_pag?> » <span class="numero"><?=$ord_gal_ima?></span></h3>

					<h5>Edite los datos de la Imagen de su Album</h5>
					<div class="tour-caja">
						<figure>
							<img src="../image/<?=$arch_imagen?>" alt="<?=$tit_imagen?>" border="0">
						</figure>
					</div>						
					<h6>Titulo de la Imagen</h6>
					<input name="tit" type="text" class="span5" placeholder="Titulo de la Imagen / Alt" value="<?=$tit_imagen?>">
					<h6>Descripcion de la Imagen</h6>
					<textarea name="des" rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"><?=$des_imagen?></textarea>
					<h6>Lugar de la Imagen</h6>
					<input name="lug" type="text" class="span5" placeholder="Lugar de la Imagen" value="<?=$lug_imagen?>">
					<label>
						<h6>Fecha de la Imagen</h6>
						<input name="fecha" type="date" value="<?=$fec_imagen?>">
						<input name="hora" type="time" class="hora" value="<?=$hor_imagen?>">
					</label>
					<label class="checkbox inline opcion-small">
						<input type="checkbox" name="vis" <?php if ($vis_imagen=="1") { ?> checked <?php } ?> value="1"> Visible
					</label>						
					<h6>Archivo de la Imagen</h6>
					<input name="arch" type="file" class="txt">	
					<br><br>
					<button class="btn btn-sitio">Guardar</button>
				</form>
			</div>
			<hr>
		</div>
	</body>
</html>