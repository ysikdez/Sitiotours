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
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }

//Datos del tour
$pos_tour = "SELECT * FROM tour WHERE id_pagina='$ids'";
$posi_tour = mysql_db_query($dbname, $pos_tour); 
if ($row = mysql_fetch_array($posi_tour)){ $id_pag_tour = $row["id_tour"]; }

//Numero dia del Itinerario del Tour
$numero_dia = "SELECT COUNT(id_itinerario) FROM itinerario WHERE id_tour='$id_pag_tour'";
$numero_dia = mysql_db_query($dbname, $numero_dia);
$numero_dia = mysql_result($numero_dia, 0);
//Dia Siguiente del Itinerario
$sig_dia = $numero_dia + 1;


if (!$_POST) {
	
} else {

	$tit_pos = $_POST["tit_pos"];
	$tit_com = $_POST["tit_com"];
	$des = $_POST["des"];

	$tit_ima = $_POST["tit_ima"];
	$des_ima = $_POST["des_ima"];
	$lug_ima = $_POST["lug_ima"];

	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$fec_ima = $fecha.'--'.$hora;
	
	$arch_ima = $_POST["arch_ima"];

	//Archivo
	$destino = $_SERVER['DOCUMENT_ROOT'].'/image/' ; //Destino donde se guardaran los archivos
	$tamano = $_FILES ['arch_ima']['size']; //Tamaño del archivo 
	$val = intval($tamano);

	//Nombre con el que la imagen sera guardada
	$nombre = urls_amigables($tit_ima); 
	$lugar = urls_amigables($lug_ima);
	$fecha = urls_amigables($fec_ima);

	//Dia del Itinerario del Tour 
	$numero = add_ceros($sig_dia,3);
	
	//Tipo de Archivo 
	$arch=explode('.',$_FILES ['arch_ima']['name']);
	$tipo_arch='.'.$arch[1];
	//Nombre de la Imagen del Dia del Itinerario del Tour
	$nom_ima=$nombre.'-'.$lugar.'-'.$fecha.'-'.$numero.$tipo_arch;

	if( !empty($val)) {

		// Comprobamos el tamaño del archivo debe ser menor 200kb
		if( $tamano < 204800 ){
			move_uploaded_file ( $_FILES [ 'arch_ima' ][ 'tmp_name' ], $destino.$nom_ima); 

		//Nuevo Dia del Itinerario del Tour
		$nuevo_dia = "INSERT INTO itinerario (

								id_tour,
								ord_itinerario,

								tit_pos_itinerario,
								tit_com_itinerario,
								des_itinerario,

								arch_ima_itinerario,
								tit_ima_itinerario,
								des_ima_itinerario,
								lug_ima_itinerario,
								fec_ima_itinerario

							) VALUES(

								'$id_pag_tour',
								'$sig_dia',

								'$tit_pos',
								'$tit_com',
								'$des',

								'$nom_ima',
								'$tit_ima',
								'$des_ima',
								'$lug_ima',
								'$fec_ima'

							)";

		$cab_nuevo_dia = mysql_db_query($dbname, $nuevo_dia);	

		} else { $error = "El archivo pesa mas de lo determinado"; }
	} else { 

		//Nuevo Dia del Itinerario del Tour
		$nuevo_dia = "INSERT INTO itinerario (

								id_tour,
								ord_itinerario,

								tit_pos_itinerario,
								tit_com_itinerario,
								des_itinerario

							) VALUES(

								'$id_pag_tour',
								'$sig_dia',

								'$tit_pos',
								'$tit_com',
								'$des'

							)";

		$cab_nuevo_dia = mysql_db_query($dbname, $nuevo_dia);		
	}

	//Dato del Itinerario
	$datos_itinerario = "SELECT * FROM itinerario WHERE id_tour='$id_pag_tour' AND ord_itinerario='$sig_dia' AND tit_pos_itinerario='$tit_pos'";
	$datos_itinerario = mysql_db_query($dbname, $datos_itinerario); 
	if ($row = mysql_fetch_array($datos_itinerario)){ $id_tour_itinerario = $row["id_itinerario"];}

	$servicio = $_POST["servicio"];
	for ($sv=1; $sv <= $servicio ; $sv++) { 
		$serv[$sv] = $_POST["serv_".$sv];
		$id_iservicio = $serv[$sv];

		//Nuevos de Servicios del Itinerario del Tour
		$nuevo_servicio = "INSERT INTO iincluye (

								id_itinerario,
								id_iservicio,
								act_iincluye

							) VALUES(

								'$id_tour_itinerario',
								'$id_iservicio',
								'1'

							)";

		$cab_nuevo_servicio = mysql_db_query($dbname, $nuevo_servicio);	
	}

	header("location: dise_tour_itinerario.php?id=$ids&error=$error");

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
		<title>Itinerario del Tour</title>
	</head>
	<body>
		<div class="row contorno">

			<a class="btn btn-sitio pull-right" href="dise_tour.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Itinerario del Tour » <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_pos_pag?></h4>
			<hr>
			<div class="accordion text-justify">
<?php

//Datos de los dias del Itinerario del Tour
$gen_pag = "SELECT * FROM itinerario WHERE id_tour='$id_pag_tour' ORDER BY ord_itinerario";
$gene_pag = mysql_db_query($dbname, $gen_pag); 
while ($row = mysql_fetch_array($gene_pag)){ 

	$id_itinerario = $row["id_itinerario"];
	$ord_itinerario = $row["ord_itinerario"];
	$tit_pos_itinerario = $row["tit_pos_itinerario"];
	$des_itinerario = $row["des_itinerario"];
?>
				<div class="accordion-group">
					<div class="accordion-titulo itinerario">
						<p class="numero"><strong><?=$ord_itinerario?></strong></p>
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#orden<?=$ord_itinerario?>"><strong> <?=$tit_pos_itinerario?></strong></a>

						<a href="dise_tour_itinerario_eli.php?id=<?=$ids?>&id_itinerario=<?=$id_itinerario?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
						<?php if($ord_itinerario!=$numero_dia) { ?>
						<a href="dise_tour_itinerario_ord.php?id=<?=$ids?>&id_itinerario=<?=$id_itinerario?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<?php if($ord_itinerario!=1) { ?>
						<a href="dise_tour_itinerario_ord.php?id=<?=$ids?>&id_itinerario=<?=$id_itinerario?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<a href="dise_tour_itinerario_edit.php?id=<?=$ids?>&id_itinerario=<?=$id_itinerario?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
					</div>

					<div id="orden<?=$ord_itinerario?>" class="accordion-body collapse">
						<div class="accordion-inner">
							<?=$des_itinerario?>
						</div>
					</div>
				</div>
<?php
}
?>
			</div>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevodia"><i class="icon-plus"></i></a>

			<div id="nuevodia" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="itinerario" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="itinerario"> Tour <?=$tit_pos_pag?> » Dia <span class="numero"><?=$sig_dia?> </span></h3>
					</div>

					<div class="modal-body">
						<label>
							<h5>Titulo de Posicionamiento</h5>
							<input type="text" name="tit_pos" class="span5" placeholder="Titulo de Posicionamiento">
						</label>
						<label>
							<h5>Titulo Comercial</h5>
							<input type="text" name="tit_com" class="span5" placeholder="Titulo Comercial">
						</label>
						
						<h5>Descripcion del Nuevo Día »</h5>
						<textarea class="ckeditor span5" name="des" placeholder="Descripcion de la Imagen / Figcaption"></textarea>
						<br>
						<h5>Que incluye el Día »</h5>
						<div>
<?php
//Lista de lo que Incluye en el Dia 
$serv=0;
$pos_pag_agen = "SELECT * FROM iservicio ORDER BY id_iservicio";
$posi_pag_agen = mysql_db_query($dbname, $pos_pag_agen); 
while ($row = mysql_fetch_array($posi_pag_agen)){ 
	$serv++;
	$id_iservicio = $row["id_iservicio"]; 
	$nom_iservicio = $row["nom_iservicio"]; 
?>
							<label class="checkbox inline opcion-small">
								<input type="checkbox" name="serv_<?=$serv?>" value="<?=$id_iservicio?>"><?=$nom_iservicio?>
							</label>

<?php
}
?>
						</div>
						<input type="hidden" name="servicio" value="<?=$serv?>">

						
						<br>
						<h5>Datos del Posicionamiento de la Imagen</h5>
						<input name="tit_ima" type="text" class="span5" placeholder="Titulo de la Imagen / Alt">
						<textarea name="des_ima" rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"></textarea>
						<input name="lug_ima" type="text" class="span5" placeholder="Lugar de la Imagen">
						<label>
							<h6>Fecha de la Imagen</h6>
							<input name="fecha" type="date">
							<input name="hora" type="time" class="hora">
						</label>
						<h6>Archivo de la Imagen</h6>
						<input name="arch_ima" type="file" class="txt">	
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