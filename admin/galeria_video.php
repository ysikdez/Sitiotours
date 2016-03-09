<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$error = $_GET['error'];
$tipo = "Videografica";

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

//Cantidad de Galerias de la Pagina --- A implementar mas de una Galeria por pagina
$n_gale = "SELECT COUNT(id_galeria) FROM galeria WHERE id_galeria='$id_galeria'";
$max_gale = mysql_db_query($dbname, $n_gale);
$max_gale = mysql_result($max_gale, 0);
$sig_gale = $max_gale+1;

//Cantidad de Videos de la Galeria
$n_gale_video = "SELECT COUNT(ord_galeria_video) FROM galeria_video WHERE id_galeria='$id_galeria'";
$max_gale_video = mysql_db_query($dbname, $n_gale_video);
$max_gale_video = mysql_result($max_gale_video, 0);
$sig_gale_video = $max_gale_video+1;


if (!$_POST) {
	
} else {

	$code = $_POST["cod"];
	$tit = $_POST["tit"];
	$des = $_POST["des"];
	$lug = $_POST["lug"];
	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$vis = $_POST["vis"];

	//GALERIA FOTOGRAFICA CODIGO
	//Numero de Galerias Fotograficas de la Pagina
	$numero_galeria = "SELECT COUNT(id_galeria) FROM galeria WHERE tipo_galeria='$tipo'";
	$numero_galeria = mysql_db_query($dbname, $numero_galeria);
	$numero_galeria = mysql_result($numero_galeria, 0);
	//Galeria Siguiente
	$sig_galeria = $numero_galeria + 1;

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

	$txt='VID'.$titulo.$orden.$idioma;
	$texto=str_split($txt,6);

	$codigo=$texto[0].'-'.$texto[1];


	if (empty($id_galeria)) {
		//No existe Galeria

		//Nueva Galeria Videografica
		$nueva_galeria = "INSERT INTO galeria (

								id_pagina,
								cod_galeria,
								tipo_galeria

							) VALUES(

								'$ids',
								'$codigo',
								'$tipo'

							)";

		$cab_nueva_galeria = mysql_db_query($dbname, $nueva_galeria);
			
		//Nuevo Video del Album Videografico
		$nuevo_video = "INSERT INTO video (

								tit_video,
								des_video,
								lug_video,
								fec_video,
								hor_video,
								vis_video,
								cod_video

							) VALUES(

								'$tit',
								'$des',
								'$lug',
								'$fecha',
								'$hora',
								'$vis',
								'$code'

							)";
		$cab_nuevo_video = mysql_db_query($dbname, $nuevo_video);	

		//Id de la Galeria 
		$dato_galeria = "SELECT * FROM galeria WHERE id_pagina='$ids' AND tipo_galeria='$tipo' AND cod_galeria='$codigo'";
		$dato_galeria = mysql_db_query($dbname, $dato_galeria); 
		if ($row = mysql_fetch_array($dato_galeria)){ $id_galeria = $row["id_galeria"];	}

		//Id del Video
		$dato_video = "SELECT * FROM video WHERE tit_video='$tit' AND des_video='$des' AND fec_video='$fecha' AND cod_video='$code'";
		$dato_video = mysql_db_query($dbname, $dato_video); 
		if ($row = mysql_fetch_array($dato_video)){ $id_video = $row["id_video"];	}

		$error=$id_video."-video".$id_video."-galeria".$id_galeria.$error;

		//Conectar Video y el Album
		$nueva_gal_video = "INSERT INTO galeria_video (

								id_video,
								id_galeria,
								ord_galeria_video

							) VALUES(

								'$id_video',
								'$id_galeria',
								'$sig_gale_video'

							)";
		$cab_nueva_gal_video = mysql_db_query($dbname, $nueva_gal_video);	

	} else {
		//Si existe Galeria

		//Nuevo video del Album Videografico
		$nueva_video = "INSERT INTO video (

								tit_video,
								des_video,
								lug_video,
								fec_video,
								hor_video,
								vis_video,
								cod_video

							) VALUES(

								'$tit',
								'$des',
								'$lug',
								'$fecha',
								'$hora',
								'$vis',
								'$code'

							)";
		$cab_nueva_video = mysql_db_query($dbname, $nueva_video);	


		//Id del video
		$dato_video = "SELECT * FROM video WHERE tit_video='$tit' AND des_video='$des' AND fec_video='$fecha' AND cod_video='$code'";
		$dato_video = mysql_db_query($dbname, $dato_video); 
		if ($row = mysql_fetch_array($dato_video)){ $id_video = $row["id_video"];}

		$error=$id_video."-video".$id_video."-galeria".$id_galeria.$error;

		//Conectar Video y el Album
		$nuevo_gal_video = "INSERT INTO galeria_video (

								id_video,
								id_galeria,
								ord_galeria_video

							) VALUES(

								'$id_video',
								'$id_galeria',
								'$sig_gale_video'

							)";
		$cab_nuevo_gal_video = mysql_db_query($dbname, $nuevo_gal_video);

	}

	header("location: galeria_video.php?id=$ids&error=$error");
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
			<a class="btn btn-sitio pull-right" 
<?php
	switch ($dise_pag) {

		//General
		case "General":
	?>
		href="dise_general.php?id=<?=$ids?>"
	<?php
		break;

		//Tour
		case "Tour":
	?>
		href="dise_tour.php?id=<?=$ids?>"
	<?php				
		break;

		//Destino
		case "Destino":
	?>
		href="dise_destino.php?id=<?=$ids?>"
	<?php								
		break;

		//Opcion de Viaje
		case "Opcion de Viaje":
	?>
		href="dise_opcion.php?id=<?=$ids?>"
	<?php				
		break;

		//Agencia de Viaje
		case "Agencia de Viaje":
	?>
		href="dise_agencia.php?id=<?=$ids?>"
	<?php
		break;

		//Alojamiento - Hotel
		case "Alojamiento - Hotel":
	?>
		href="dise_alojamiento.php?id=<?=$ids?>"
	<?php			
		break;

		//Restaurante
		case "Restaurante":
	?>
		href="dise_restaurante.php?id=<?=$ids?>"
	<?php				
		break;

		//Tienda
		case "Tienda":
	?>
		href="dise_tienda.php?id=<?=$ids?>"
	<?php				
		break;

		//Regalo - Souvenir
		case "Regalo - Souvenir":
	?>
		href="dise_souvenir.php?id=<?=$ids?>"
	<?php				
		break;

		//Comida Tipica
		case "Comida Tipica":
	?>
		href="dise_tipica.php?id=<?=$ids?>"
	<?php			
		break;

		//Sitio Turistico
		case "Sitio Turistico":				
	?>
		href="dise_sitio.php?id=<?=$ids?>"
	<?php
		break;

		//Recomendacion - Tic Turistico
		case "Recomendacion - Tic Turistico":
	?>
		href="dise_tic.php?id=<?=$ids?>"
	<?php
		break;

		//Galeria
		case "Galeria":
	?>
	<?php
		break;

		//Enlace
		case "Enlace":
	?>
	<?php
		break;

		//Mapa del Sitio
		case "Mapa del Sitio":
	?>
	<?php
		break;

	}
?>
		><i class="icon-arrow-left"></i></a>
			<h3>Galeria de Videos » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>

<?php

//Datos de la Pagina Padre
$datos_galeria_video = "SELECT * FROM galeria_video WHERE id_galeria='$id_galeria' ORDER BY ord_galeria_video";
$datos_galeria_video = mysql_db_query($dbname, $datos_galeria_video); 
while ($row = mysql_fetch_array($datos_galeria_video)){ 
	$id_video_galeria = $row["id_video"];
	$ord_gal_video = $row["ord_galeria_video"];

	//Datos de la Pagina Padre
	$datos_video = "SELECT * FROM video WHERE id_video='$id_video_galeria'";
	$datos_video = mysql_db_query($dbname, $datos_video); 
	if ($row = mysql_fetch_array($datos_video)){ 
		$cod_gal_video = $row["cod_video"];	
		$tit_gal_video = $row["tit_video"];	
		$lug_gal_video = $row["lug_video"];	
		$des_gal_video = $row["des_video"];	
		$fec_gal_video = $row["fec_video"];
?>

			<div class="tour-caja text-center">
				<p class="numero"><strong><?=$ord_gal_video?></strong></p>
				<a href="galeria_video_eli.php?id=<?=$ids?>&id_video=<?=$id_video_galeria?>" onclick='return confirm("¿Esta seguro que desea eliminar este Video?")'>
					<div class="pull-right icono"><i class="icon-remove"></i></div>
				</a>

<?php
//Siguiente
if($ord_gal_video!=$max_gale_video) { ?>
				<a href="galeria_video_ord.php?id=<?=$ids?>&sig=1&id_video=<?=$id_video_galeria?>" title="Siguiente">
					<div class="pull-right icono"><i class="icon-chevron-right"></i></div>
				</a>
<?php } else { ?>
				<div class="pull-right icono"><i class="esp-ico"></i></div>
<?php } ?>


<?php 
//Anterior
if($ord_gal_video!=1) { ?>
				<a href="galeria_video_ord.php?id=<?=$ids?>&sig=0&id_video=<?=$id_video_galeria?>" title="Anterior">
					<div class="pull-right icono"><i class="icon-chevron-left"></i></div>
				</a>
<?php } else { ?>
				<div class="pull-right icono"><i class="esp-ico"></i></div>
<?php } ?>

				<a href="galeria_video_edit.php?id=<?=$ids?>&id_video=<?=$id_video_galeria?>" title="Editar">
					<div class="pull-right icono"><i class="icon-edit"></i></div>
				</a>
				<br><br>
				<div class="text-center">
					<?=$cod_gal_video?>
				</div>
				<figcaption>
					<h5><?=$tit_gal_video?></h5>
					<small><?=$lug_gal_video?> - <?=$fec_gal_video?></small>
					<br>
					<?=$des_gal_video?>
				</figcaption>
			</div>

<?php
	}
}
?>

			<hr>
			</div>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevafoto"><i class="icon-plus"></i> <i class="icon-film"></i></a>


			<div id="nuevafoto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="video" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="video"> Album » <?=$tit_pos_pag_pad?> » <?=$tit_pos_pag?> » <span class="numero"><?=$sig_gale_video?></span></h3>
					</div>

					<div class="modal-body text-center">
						<h5>Ingrese los datos del Nuevo Video de su Album</h5>
						<h6>Titulo de la Video</h6>
						<input name="tit" type="text" class="span5" placeholder="Titulo del Video / Alt" >
						<h6>Descripcion del Video</h6>
						<textarea name="des" rows="2" class="span5" placeholder="Descripcion del Video / Figcaption"></textarea>
						<h6>Lugar del Video</h6>
						<input name="lug" type="text" class="span5" placeholder="Lugar del Video">
						<label>
							<h6>Fecha del Video</h6>
							<input name="fecha" type="date">
							<input name="hora" type="time" class="hora">
						</label>
						<label class="checkbox inline opcion-small">
							<input type="checkbox" name="vis" value="1"> Visible
						</label>						
						<h6>Codigo del Video: Width="560" Height="315"</h6>
						<textarea name="cod" rows="2" class="span5" placeholder="Codigo del Video / Embed"></textarea> 
						<br><br>
					</div>

					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<button class="btn btn-sitio pull-right btn-small">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>