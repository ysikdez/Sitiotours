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
	
	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];

}

//Datos de la Pagina Padre ---- Tipo del Destino que lo Agrupa
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }


//Datos de la Pagina Diseño General
$datos_souvenir = "SELECT * FROM souvenir WHERE id_pagina='$ids'";
$datos_souvenir = mysql_db_query($dbname, $datos_souvenir); 
if ($row = mysql_fetch_array($datos_souvenir)){ 

	$id_souvenir = $row["id_souvenir"];
	$cod_souvenir = $row["cod_souvenir"];
	$des_souvenir = $row["des_souvenir"];
	$mat_souvenir = $row["mat_souvenir"];
	$ela_souvenir = $row["ela_souvenir"];

}


if (!$_POST) {
	
} else {

	$des = $_POST["des"];
	$mat = $_POST["mat"];
	$ela = $_POST["ela"];

	$logo_pag = $_POST["logo_pag"];
	$ima_def = $_POST["ima_def"];

	$alt_logo_pag = $_POST["alt_logo_pag"];
	$des_logo_pag = $_POST["des_logo_pag"];


	//Idioma
	$pos_pag = "SELECT abre_idioma FROM idioma WHERE id_idioma='$id_idi'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ $abre_idioma = $row["abre_idioma"]; }


	if ($ima_def==1) {

		$dise_souvenir = "UPDATE souvenir SET 

							des_souvenir = '$des',
							mat_souvenir = '$mat',
							ela_souvenir = '$ela'

						WHERE id_pagina='$ids'";

		$db_dise_souvenir = mysql_db_query($dbname, $dise_souvenir);

	}else {

		$dise_souvenir = "UPDATE souvenir SET 
		
							des_souvenir = '$des',
							mat_souvenir = '$mat',
							ela_souvenir = '$ela'

						WHERE id_pagina='$ids'";

		$db_dise_souvenir = mysql_db_query($dbname, $dise_souvenir);

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

	header("location: dise_souvenir.php?id=$ids&error=$error");
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
		<title>Editar el Souvenir o Regalo</title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h4 class="pull-right">Codigo : <?=$cod_pag?></h4>
				<br>
				<h3>Editar el Souvenir - Regalo » </h3>						
				<h4>» <?=$tit_pos_pag_pad?></h4>
				<h5>» <?=$tit_pos_pag?></h5>
				<br>
				<h5>Codigo del Souvenir » <?=$cod_souvenir?></h5>
				<br>
				<hr>
				<h5>Destino »
					<a class="btn btn-sitio pull-right" href="dise_souvenir_destino.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
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
				
				<h5>Descripción »</h5>
				<textarea class="ckeditor span5" name="des"><?=$des_souvenir?></textarea>
				<br>				
				
				<h5>Materiales »</h5>
				<textarea class="ckeditor span5" name="mat"><?=$mat_souvenir?></textarea>
				<br>				
				
				<h5>Elaboración »</h5>
				<textarea class="ckeditor span5" name="ela"><?=$ela_souvenir?></textarea>
				<br>
				<label>
					<input type="checkbox" name="ima_def" id="ima_def" <?php if (empty($logo_pag)) { ?> checked="checked" <?php } ?> onclick="imaPrincipal()" value="1"> 
					sin Logo por Defecto
				</label>
				<br>
				<div id="n_ima">
				<?php if (!empty($logo_pag)) { ?>
					<div class="text-center">
						<div class="tour-caja ico-prin">
							<a href="dise_souvenir_logo_eli.php?id=<?=$ids?>"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
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