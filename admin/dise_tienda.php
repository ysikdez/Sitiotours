<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
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
	
	$ima_def_pag = $row["ima_def_pagina"];

	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];	

}

//Datos de la Pagina Padre --
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ 
	$id_idioma = $row["id_idioma"];
	$tit_pos_pag_pad = $row["tit_pos_pagina"];
}

//Datos de la Pagina Idioma
$pos_idio = "SELECT * FROM idioma WHERE id_idioma='$id_idioma'";
$posi_idio = mysql_db_query($dbname, $pos_idio); 
if ($row = mysql_fetch_array($posi_idio)){ $abre_idioma = $row["abre_idioma"];}


//Datos del Tienda
$datos_tienda = "SELECT * FROM tienda WHERE id_pagina='$ids'";
$datos_tienda = mysql_db_query($dbname, $datos_tienda); 
if ($row = mysql_fetch_array($datos_tienda)){ 

	$id_tienda = $row["id_tienda"];
	$cod_tienda = $row["cod_tienda"];
	$des_tienda = $row["des_tienda"];
	$afo_tienda = $row["afo_tienda"];
	$open_a_tienda = $row["open_a_tienda"];
	$close_a_tienda = $row["close_a_tienda"];
	$open_b_tienda = $row["open_b_tienda"];
	$close_b_tienda = $row["close_b_tienda"];

}

if (!$_POST) {
	
} else {

	$afo = $_POST["afo"];
	$cat = $_POST["cat"];

	$open_a = $_POST["open_a"];
	$close_a = $_POST["close_a"];

	$open_b = $_POST["open_b"];
	$close_b = $_POST["close_b"];

	$des = $_POST["des"];

	$logo_pag = $_POST["logo_pag"];
	$ima_def = $_POST["ima_def"];
	$alt_logo_pag = $_POST["alt_logo_pag"];
	$des_logo_pag = $_POST["des_logo_pag"];	


	if ($ima_def==on) {

		$dise_tienda = "UPDATE tienda SET 

							afo_tienda = '$afo',
							open_a_tienda = '$open_a',
							close_a_tienda = '$close_a',
							open_b_tienda = '$open_b',
							close_b_tienda = '$close_b',
							des_tienda = '$des'

							WHERE id_pagina='$ids'";

		$db_dise_tienda = mysql_db_query($dbname, $dise_tienda);

	}else {

		$dise_tienda = "UPDATE tienda SET 

							afo_tienda = '$afo',
							open_a_tienda = '$open_a',
							close_a_tienda = '$close_a',
							open_b_tienda = '$open_b',
							close_b_tienda = '$close_b',
							des_tienda = '$des'

							WHERE id_pagina='$ids'";
							
		$db_dise_tienda = mysql_db_query($dbname, $dise_tienda);

		//Archivo
		$destino = $_SERVER['DOCUMENT_ROOT'].'/img/' ; //Destino donde se guardaran los archivos
		$tamano = $_FILES ['logo_pag']['size']; //Tamaño del archivo 
		$val = intval($tamano);

		//Nombre con el que la imagen sera guardada
		$nombre = urls_amigables($alt_logo_pag); 
		$lugar = "sitiotours";
		$fecha = date("Y-m-d");

		//Cantidad de Imagenes Principales 
		$n_ima = "SELECT COUNT(DISTINCT logo_pagina) FROM pagina";
		$max_ima = mysql_db_query($dbname, $n_ima);
		$max_ima = mysql_result($max_ima, 0);
		$sig_ima = $max_ima+1;
		$numero = add_ceros($sig_ima,2);
		
		//Tipo de Archivo 
		$arch=explode('.',$_FILES ['logo_pag']['name']);
		$tipo_arch='.'.$arch[1];
		//Nombre de la Imagen Principal 
		$nom_ima_prin=$nombre.'-'.$lugar.'-'.$fecha.'-'.$numero.$tipo_arch;

		// Comprobamos el tamaño del archivo debe ser menor 20kb
		if( $tamano < 20480 ){
			
			move_uploaded_file ( $_FILES [ 'logo_pag' ][ 'tmp_name' ], $destino.$nom_ima_prin); 

			$editar_pagina = "UPDATE pagina SET	
								logo_pagina = '$nom_ima_prin',
								alt_logo_pagina = '$alt_logo_pag',
								des_logo_pagina = '$des_logo_pag'
								WHERE id_pagina='$ids'";
			$bd_editar_pagina = mysql_db_query($dbname, $editar_pagina);	

		}else {

			$editar_pagina = "UPDATE pagina SET
								alt_logo_pagina = '$alt_logo_pag',
								des_logo_pagina = '$des_logo_pag'
								WHERE id_pagina='$ids'";
			$bd_editar_pagina = mysql_db_query($dbname, $editar_pagina);
		}
	
	}
	

	header("location: dise_tienda.php?id=$ids&error=$error");
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
		<title>Editar Tienda</title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h4 class="pull-right">Codigo de pagina: <?=$cod_pag?></h4>
				<br>
				<h5>Editar » </h5>					
				<h4>» <?=$tit_pos_pag_pad?></h4>
				<h3>» <?=$tit_pos_pag?></h3>
				<h5>Codigo de la Tienda » <?=$cod_tienda?></h5>
				<hr>
				<label class="text-center">
					<h5>Aforo del Tienda » </h5>
					<input type="text" name="afo" class="opcion-mini" placeholder="10" value="<?=$afo_tienda?>">
				</label>
				<div class="text-center">
					<h5>Horario de Atencion de la Tienda»</h5>
					<h6>Horario 1 »</h6>
					<label>
						Apertura : <input type="time" name="open_a" class="hora" value="<?=$open_a_tienda?>">
						<p class="precio"></p>
						Cierre : <input type="time" name="close_a" class="hora" value="<?=$close_a_tienda?>">
					</label>

					<h6>Horario 2 »</h6>
					<label>
						Apertura : <input type="time" name="open_b" class="hora" value="<?=$open_b_tienda?>">
						<p class="precio"></p>
						Cierre : <input type="time" name="close_b" class="hora" value="<?=$close_b_tienda?>">
					</label>
				</div>
				<br>

				<hr>
				<h5>Destino »
					<a class="btn btn-sitio pull-right" href="dise_tienda_destino.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5>
				<hr>
				<h5>Catalogo & Precios »
					<a class="btn btn-sitio pull-right" href="dise_tienda_catalogo.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5>
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
				<br>
				<label>
					<h5>Descripcion de la Pagina »</h5>
					<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Tour"><?=$des_tienda?></textarea>
				</label>
				<br>
								
				<label>
					<input type="checkbox" name="ima_def" id="ima_def" <?php if (empty($logo_pag)) { ?> checked="checked" <?php } ?> onclick="imaPrincipal()"> 
					Sin Logo por Defecto
				</label>

				<br>
				<div id="n_ima">
				<?php if (!empty($logo_pag)) { ?>
					<div class="text-center">
						<div class="tour-caja ico-prin">
							<a href="dise_tienda_logo_eli.php?id=<?=$ids?>"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
							<img src="../img/<?=$logo_pag?>" alt="<?=$alt_logo_pag?>" border="0">
						</div>
					</div>
				<?php } ?>
					
					<label>
						<h5>Titulo del Logo de la pagina / Alt »</h5>
						<input type="text" name="alt_logo_pag" class="span5" placeholder="Titulo de la Imagen / Alt" value="<?=$alt_logo_pag?>">
					</label>
					<label>
						<h5>Descripcion del Logo de la pagina / Figcaption »</h5>
						<textarea rows="2" name="des_logo_pag" class="span5" placeholder="Descripcion de la Imagen / Figcaption"><?=$des_logo_pag?></textarea>
					</label>
					<input type="file" name="logo_pag" class="txt">
				</div>
				<br>

				<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
			</form>
		</div>
	</body>
</html>