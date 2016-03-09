<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
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

//Cantidad de Galerias de la Pagina --- A implementar mas de una Galeria por pagina
$n_gale = "SELECT COUNT(id_galeria) FROM galeria WHERE id_galeria='$id_galeria'";
$max_gale = mysql_db_query($dbname, $n_gale);
$max_gale = mysql_result($max_gale, 0);
$sig_gale = $max_gale+1;

//Cantidad de Imagenes de la Galeria
$n_gale_ima = "SELECT COUNT(ord_galeria_imagen) FROM galeria_imagen WHERE id_galeria='$id_galeria'";
$max_gale_ima = mysql_db_query($dbname, $n_gale_ima);
$max_gale_ima = mysql_result($max_gale_ima, 0);
$sig_gale_ima = $max_gale_ima+1;


if (!$_POST) {
	
} else {

	$tit = $_POST["tit"];
	$des = $_POST["des"];
	$lug = $_POST["lug"];
	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$vis = $_POST["vis"];
	$arch = $_POST["arch"];

	$error=$lug.$fecha.$hora;
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

	if (empty($id_galeria)) {
		//No existe Galeria

		if( !empty($val)) {
			// Comprobamos el tamaño del archivo debe ser menor 600kb
			if( $tamano < 614400 ){

				//Nueva Galeria Fotografica
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

				
				move_uploaded_file ( $_FILES [ 'arch' ][ 'tmp_name' ], $destino.$nom_ima);

				//Nueva Imagen del Album Fotografia
				$nueva_imagen = "INSERT INTO imagen (

										tit_imagen,
										des_imagen,
										lug_imagen,
										fec_imagen,
										hor_imagen,
										vis_imagen,
										arch_imagen

									) VALUES(

										'$tit',
										'$des',
										'$lug',
										'$fecha',
										'$hora',
										'$vis',
										'$nom_ima'

									)";
				$cab_nueva_imagen = mysql_db_query($dbname, $nueva_imagen);	

				//Id de la Galeria 
				$dato_galeria = "SELECT * FROM galeria WHERE id_pagina='$ids' AND tipo_galeria='$tipo' AND cod_galeria='$codigo'";
				$dato_galeria = mysql_db_query($dbname, $dato_galeria); 
				if ($row = mysql_fetch_array($dato_galeria)){ $id_galeria = $row["id_galeria"];	}

				//Id de la Imagen 
				$dato_imagen = "SELECT * FROM imagen WHERE tit_imagen='$tit' AND lug_imagen='$lug' AND fec_imagen='$fecha'";
				$dato_imagen = mysql_db_query($dbname, $dato_imagen); 
				if ($row = mysql_fetch_array($dato_imagen)){ $id_imagen = $row["id_imagen"];	}

				//Conectar Imagen y el Album
				$nueva_gal_ima = "INSERT INTO galeria_imagen (

										id_imagen,
										id_galeria,
										ord_galeria_imagen

									) VALUES(

										'$id_imagen',
										'$id_galeria',
										'$sig_gale_ima'

									)";
				$cab_nueva_gal_ima = mysql_db_query($dbname, $nueva_gal_ima);	

			} else { $error="La imagen No tiene el Tamaño Adecuado";}

		}else {	$error="Tiene que ingresar el Archivo de la imagen";}
	} else {
		//Si existe Galeria

		if( !empty($val)) {
			// Comprobamos el tamaño del archivo debe ser menor 600kb
			if( $tamano < 614400 ){

				move_uploaded_file ( $_FILES [ 'arch' ][ 'tmp_name' ], $destino.$nom_ima);

				//Nueva Imagen del Album Fotografia
				$nueva_imagen = "INSERT INTO imagen (

										tit_imagen,
										des_imagen,
										lug_imagen,
										fec_imagen,
										hor_imagen,
										vis_imagen,
										arch_imagen

									) VALUES(

										'$tit',
										'$des',
										'$lug',
										'$fecha',
										'$hora',
										'$vis',
										'$nom_ima'

									)";
				$cab_nueva_imagen = mysql_db_query($dbname, $nueva_imagen);	

				$error="hay-esta-hecho".$error;

				//Id de la Imagen 
				$dato_imagen = "SELECT * FROM imagen WHERE tit_imagen='$tit' AND des_imagen='$des' AND fec_imagen='$fecha' AND arch_imagen='$nom_ima'";
				$dato_imagen = mysql_db_query($dbname, $dato_imagen); 
				if ($row = mysql_fetch_array($dato_imagen)){ $id_imagen = $row["id_imagen"];}

				//Conectar Imagen y el Album
				$nueva_gal_ima = "INSERT INTO galeria_imagen (

										id_imagen,
										id_galeria,
										ord_galeria_imagen

									) VALUES(

										'$id_imagen',
										'$id_galeria',
										'$sig_gale_ima'

									)";
				$cab_nueva_gal_ima = mysql_db_query($dbname, $nueva_gal_ima);

			} else { $error="La imagen No tiene el Tamaño Adecuado"; }

		}else { $error="Tiene que ingresar el Archivo de la imagen"; }
	}

	header("location: galeria_foto.php?id=$ids&error=$error");
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
		case "Recomendacion":
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
			<h3>Galeria de Fotos »</h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>

<?php

//Datos de la Galeria de Imagen
$datos_galeria_imagen = "SELECT * FROM galeria_imagen WHERE id_galeria='$id_galeria' ORDER BY ord_galeria_imagen";
$datos_galeria_imagen = mysql_db_query($dbname, $datos_galeria_imagen); 
while ($row = mysql_fetch_array($datos_galeria_imagen)){ 
	$id_ima_galeria = $row["id_imagen"];
	$ord_gal_imagen = $row["ord_galeria_imagen"];

	//Datos de imagen
	$datos_imagen = "SELECT * FROM imagen WHERE id_imagen='$id_ima_galeria'";
	$datos_imagen = mysql_db_query($dbname, $datos_imagen); 
	if ($row = mysql_fetch_array($datos_imagen)){ 
		$arch_gal_imagen = $row["arch_imagen"];	
		$tit_gal_imagen = $row["tit_imagen"];	
		$lug_gal_imagen = $row["lug_imagen"];	
		$des_gal_imagen = $row["des_imagen"];	
		$fec_gal_imagen = $row["fec_imagen"];
?>

<div class="tour-caja ima-prin">
	<p class="numero"><strong><?=$ord_gal_imagen?></strong></p>
	<a href="galeria_foto_eli.php?id=<?=$ids?>&id_ima=<?=$id_ima_galeria?>" onclick='return confirm("¿Esta seguro que desea eliminar esta Imagen?")'>
		<div class="pull-right icono"><i class="icon-remove"></i></div>
	</a>

<?php
//Siguiente
if($ord_gal_imagen!=$max_gale_ima) { ?>
	<a href="galeria_foto_ord.php?id=<?=$ids?>&sig=1&id_ima=<?=$id_ima_galeria?>" title="Siguiente">
		<div class="pull-right icono"><i class="icon-chevron-right"></i></div>
	</a>
<?php } else { ?>
	<div class="pull-right icono"><i class="esp-ico"></i></div>
<?php } ?>


<?php 
//Anterior
if($ord_gal_imagen!=1) { ?>
	<a href="galeria_foto_ord.php?id=<?=$ids?>&sig=0&id_ima=<?=$id_ima_galeria?>" title="Anterior">
		<div class="pull-right icono"><i class="icon-chevron-left"></i></div>
	</a>
<?php } else { ?>
	<div class="pull-right icono"><i class="esp-ico"></i></div>
<?php } ?>


	<a href="galeria_foto_edit.php?id=<?=$ids?>&id_ima=<?=$id_ima_galeria?>" title="Editar">
		<div class="pull-right icono"><i class="icon-edit"></i></div>
	</a>

	<figure>
	<img src="../image/<?=$arch_gal_imagen?>" alt="<?=$tit_gal_imagen?>" border="0">
	</figure>
	<figcaption>
		<h5><?=$tit_gal_imagen?></h5>
		<small><?=$lug_gal_imagen?> - <?=$fec_gal_imagen?></small>
		<br>
		<?=$des_gal_imagen?>
	</figcaption>
</div>

<?php
	}
}
?>

			<hr>
			</div>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevafoto"><i class="icon-plus"></i> <i class="icon-picture"></i></a>


			<div id="nuevafoto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imagen" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="imagen"> Album » <?=$tit_pos_pag_pad?> » <?=$tit_pos_pag?> » <span class="numero"><?=$sig_gale_ima?></span></h3>
					</div>

					<div class="modal-body text-center">
						<h5>Ingre de los datos de la Nueva Imagen de su Album</h5>
						<h6>Titulo de la Imagen</h6>
						<input name="tit" type="text" class="span5" placeholder="Titulo de la Imagen / Alt" >
						<h6>Descripcion de la Imagen</h6>
						<textarea name="des" rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"></textarea>
						<h6>Lugar de la Imagen</h6>
						<input name="lug" type="text" class="span5" placeholder="Lugar de la Imagen">
						<label>
							<h6>Fecha de la Imagen</h6>
							<input name="fecha" type="date">
							<input name="hora" type="time" class="hora">
						</label>
						<label class="checkbox inline opcion-small">
							<input type="checkbox" name="vis" value="1"> Visible
						</label>						
						<h6>Archivo de la Imagen</h6>
						<input name="arch" type="file" class="txt">	
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