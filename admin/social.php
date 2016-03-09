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

	$per_pag = $row["per_pagina"];
	$dise_pag = $row["dise_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
}

//Datos de la Pagina Padre
$datos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$datos_pag_pad = mysql_db_query($dbname, $datos_pag_pad); 
if ($row = mysql_fetch_array($datos_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"];}

//Numero de Contacto
$numero_contacto = "SELECT COUNT(id_contacto) FROM contacto WHERE id_pagina='$ids'";
$numero_contacto = mysql_db_query($dbname, $numero_contacto);
$numero_contacto = mysql_result($numero_contacto, 0);
//Contacto Siguiente
$sig_contacto = $numero_contacto + 1;


if (!$_POST) {
	
} else {

	$carg = $_POST["carg"];
	$ape = $_POST["ape"];
	$nom = $_POST["nom"];
	$des = $_POST["des"];
	$vis = $_POST["vis"];
	$act = $_POST["act"];

	//Nuevo contacto
	$nuevo_contacto = "INSERT INTO contacto (

							id_pagina,
							ord_contacto,
							carg_contacto,
							ape_contacto,
							nom_contacto,
							des_contacto,
							vis_contacto,
							act_contacto

						) VALUES(

							'$ids',
							'$sig_contacto',
							'$carg',
							'$ape',
							'$nom',
							'$des',
							'$vis',
							'$act'

						)";

	$cab_nuevo_contacto = mysql_db_query($dbname, $nuevo_contacto);	


	header("location: social.php?id=$ids&error=$error");
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
		<title>Contactod de la Pagina</title>
	</head>
	<body onload="cuentaTitulo();imaPrincipal();">
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
			<h3>Lista de Constactos de la Pagina » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<hr>
			<div class="accordion text-justify">
<?php

$dato_contacto = "SELECT * FROM contacto WHERE id_pagina='$ids' ORDER BY ord_contacto";
$dato_contacto = mysql_db_query($dbname, $dato_contacto); 
while ($row = mysql_fetch_array($dato_contacto)){ 

	$id_contacto = $row["id_contacto"];
	$ord_contacto = $row["ord_contacto"];
	$carg_contacto = $row["carg_contacto"];
	$ape_contacto = $row["ape_contacto"];
	$nom_contacto = $row["nom_contacto"];
	$des_contacto = $row["des_contacto"];
	$vis_contacto = $row["vis_contacto"];
	$act_contacto = $row["act_contacto"];


?>
				<div class="accordion-group">
					<div class="accordion-titulo itinerario">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#orden<?=$ord_contacto?>">
							<p class="numero"><strong><?=$ord_contacto?></strong></p>
							<strong> <?=$carg_contacto?></strong>
						</a>


						<a href="social_eli.php?id=<?=$ids?>&id_contacto=<?=$id_contacto?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTE CONTACTO DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
						
						<?php if($ord_contacto!=$numero_contacto) { ?>
						<a href="social_ord.php?id=<?=$ids?>&id_contacto=<?=$id_contacto?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<?php if($ord_contacto!=1) { ?>
						<a href="social_ord.php?id=<?=$ids?>&id_contacto=<?=$id_contacto?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<a href="social_edit.php?id=<?=$ids?>&id_contacto=<?=$id_contacto?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
						<a href="social_info_new.php?id=<?=$ids?>&id_contacto=<?=$id_contacto?>"><div class="pull-right icono"><i class="icon-tags"></i></div></a>

					</div>
					<div id="orden<?=$ord_contacto?>" class="accordion-body collapse <?php if ($ord_contacto=="1") { ?> in <?php }?>">
						<div class="accordion-inner">
<?php
	//Numero de info
	$numero_info = "SELECT COUNT(id_info) FROM info WHERE id_contacto='$id_contacto'";
	$numero_info = mysql_db_query($dbname, $numero_info);
	$numero_info = mysql_result($numero_info, 0);
	//info Siguiente
	// $sig_info = $numero_info + 1;

	$datos_info = "SELECT * FROM info WHERE id_contacto='$id_contacto' ORDER BY ord_info";
	$datos_info = mysql_db_query($dbname, $datos_info); 
	while ($row = mysql_fetch_array($datos_info)){ 

		$id_info = $row["id_info"];
		$ord_info = $row["ord_info"];
		$tipo_info = $row["tipo_info"];
		$n_tipo_info = $row["n_tipo_info"];
		$dato_info = $row["dato_info"];
		$des_info = $row["des_info"];
		$vis_info = $row["vis_info"];
		$act_info = $row["act_info"];
?>
							<div class="destino-caja">
								<a href="social_info_eli.php?id=<?=$ids?>&id_info=<?=$id_info?>"><i class="icon-remove pull-right"></i></a>

								<?php if($ord_info!=$numero_info) { ?>
								<a href="social_info_ord.php?id=<?=$ids?>&id_info=<?=$id_info?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<?php if($ord_info!=1) { ?>
								<a href="social_info_ord.php?id=<?=$ids?>&id_info=<?=$id_info?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<a href="social_info_edit.php?id=<?=$ids?>&id_info=<?=$id_info?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
								<small>
									<dl class="dl-horizontal">	
										<dt>
											<p class="numero"><strong><?=$ord_info?></strong></p>
											<?=$tipo_info?> : <small><?=$dato_info?></small>
										</dt>
										<dd>
											<small><?=$des_info?></small> 
										</dd>
									</dl>
								</small>
							</div>
<?php
	}
?>
						</div>
					</div>
				</div>
<?php
}
?>
			</div>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevocontacto"><i class="icon-plus"></i><i class="icon-user"></i></a>

			<div id="nuevocontacto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imagen" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="imagen"><?=$tit_pos_pag?> » Contacto <span class="numero"><?=$sig_contacto?> </span> </h3>
					</div>

					<div class="modal-body text-center">
						<label>
							<h5>Cargo del Contacto »</h5>
							<input type="text" name="carg" class="span5" placeholder="Cargo">
						</label>
						<label>
							<h5>Apellidos del Contacto »</h5>
							<input type="text" name="ape" class="span5" placeholder="Apellidos">
						</label>
						<label>
							<h5>Nombres del Contacto »</h5>
							<input type="text" name="nom" class="span5" placeholder="Nombres">
						</label>
						<label>
							<h5>Descripcion del Contacto »</h5>
							<textarea class="span5" name="des" placeholder="Descripcion"></textarea>
						</label>

						<label class="checkbox inline opcion-small">
							<input type="checkbox" name="vis" value="1"> Visible
						</label>
						<label class="checkbox inline opcion-small">
							<input type="checkbox" name="act" value="1"> Activo
						</label>
						<br>		
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