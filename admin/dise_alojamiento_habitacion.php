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

//Datos de la alojamiento
$datos_alojamiento = "SELECT * FROM alojamiento WHERE id_pagina='$ids'";
$datos_alojamiento = mysql_db_query($dbname, $datos_alojamiento); 
if ($row = mysql_fetch_array($datos_alojamiento)){ $id_alojamiento = $row["id_alojamiento"]; }

//Numero de Habitaciones y Nuevas Habitaciones
$numero_habitaciones = "SELECT COUNT(ord_habitacion) FROM habitacion WHERE id_alojamiento='$id_alojamiento'";
$numero_habitaciones = mysql_db_query($dbname, $numero_habitaciones);
$numero_habitaciones = mysql_result($numero_habitaciones, 0);
$new_habitaciones = $numero_habitaciones +1;


if (!$_POST) {
	
} else {

	$tip = $_POST["tip"];
	$nom = $_POST["nom"];
	$des = $_POST["des"];

	$agrega_habitacion = "INSERT INTO habitacion (tip_habitacion,nom_habitacion,des_habitacion,id_alojamiento,ord_habitacion) VALUES ('$tip','$nom','$des','$id_alojamiento','$new_habitaciones')";
	$cab_agrega_habitacion = mysql_db_query($dbname, $agrega_habitacion);	

	header("location: dise_alojamiento_habitacion.php?id=$ids&error=$error");
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
		<title>Habitaciones del Alojamiento</title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_alojamiento.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Lista de Habitaciones » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<hr>
			<h5>Habitaciones »</h5>
			<div class="accordion text-justify">
<?php

//Datos de las Habitaciones
$datos_habitaciones = "SELECT * FROM habitacion WHERE id_alojamiento='$id_alojamiento' ORDER BY ord_habitacion";
$datos_habitaciones = mysql_db_query($dbname, $datos_habitaciones); 
while ($row = mysql_fetch_array($datos_habitaciones)){ 

	$id_habita = $row["id_habitacion"];
	$ord_habita = $row["ord_habitacion"];
	$nom_habita = $row["nom_habitacion"];
	$tip_habita = $row["tip_habitacion"];

	$numero_pre_hab = "SELECT COUNT(ord_hprecio) FROM hprecio WHERE id_habitacion='$id_habita'";
	$numero_pre_hab = mysql_db_query($dbname, $numero_pre_hab);
	$numero_pre_hab = mysql_result($numero_pre_hab, 0);
	$new_pre_hab = $numero_pre_hab + 1;
?>
				<div class="accordion-group">
					<div class="accordion-titulo itinerario">
						<p class="numero"><strong><?=$ord_habita?></strong></p>
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#ord_habi<?=$ord_habita?>"><strong> <?=$nom_habita?> : </strong> <?=$tip_habita?></a>
												

						<a href="dise_alojamiento_habitacion_eli.php?id=<?=$ids?>&id_habitacion=<?=$id_habita?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
						
						<?php if($ord_habita!=$numero_habitaciones) { ?>
						<a href="dise_alojamiento_habitacion_ord.php?id=<?=$ids?>&id_habitacion=<?=$id_habita?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<?php if($ord_habita!=1) { ?>
						<a href="dise_alojamiento_habitacion_ord.php?id=<?=$ids?>&id_habitacion=<?=$id_habita?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<a href="dise_alojamiento_habitacion_edit.php?id=<?=$ids?>&id_habitacion=<?=$id_habita?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
						<a href="dise_alojamiento_habitacion_precio.php?id=<?=$ids?>&id_habitacion=<?=$id_habita?>&new_precio=<?=$new_pre_hab?>"><h4 class="pull-right icono">$</h4></a>

					</div>
					<div id="ord_habi<?=$ord_habita?>" class="accordion-body collapse">
						<div class="accordion-inner">

	<?php

	//Datos de las precios
	$datos_pre_hab = "SELECT * FROM hprecio WHERE id_habitacion='$id_habita' ORDER BY ord_hprecio";
	$datos_pre_hab = mysql_db_query($dbname, $datos_pre_hab); 
	while ($row = mysql_fetch_array($datos_pre_hab)){ 

		$id_hprecio = $row["id_hprecio"];
		$ord_hprecio = $row["ord_hprecio"];
		$hab_hprecio = $row["hab_hprecio"];
		$val_hprecio = $row["val_hprecio"];
		$fin_hprecio = $row["fin_hprecio"];
	?>
							<div class="destino-caja">
								<p class="numero"><strong><?=$ord_hprecio?></strong></p> →
								<p class="numero"><small><strong><?=$hab_hprecio?></strong></small></p>
								<p class="numero"><small><small><strong>Hab.</strong></small></small></p>
								<p class="numero">×</p>
								<p class="precio"><small><?=$val_hprecio?></small></p>
								<p class="numero"><small><small><strong>USD</strong></small></small></p>
								<p class="precio"><small><small><strong>Hasta »</strong></small></small></p>
								<p class="precio"><small><small><?=$fin_hprecio?></small></small></p>
								
								<a href="dise_alojamiento_habitacion_precio_eli.php?id=<?=$ids?>&id_hprecio=<?=$id_hprecio?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
								<?php if($ord_hprecio!=$numero_pre_hab) { ?>
								<a href="dise_alojamiento_habitacion_precio_ord.php?id=<?=$ids?>&id_hprecio=<?=$id_hprecio?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<?php if($ord_hprecio!=1) { ?>
								<a href="dise_alojamiento_habitacion_precio_ord.php?id=<?=$ids?>&id_hprecio=<?=$id_hprecio?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<a href="dise_alojamiento_habitacion_precio_edit.php?id=<?=$ids?>&id_habitacion=<?=$id_habita?>&id_hprecio=<?=$id_hprecio?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
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

			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevoprecio"><i class="icon-plus"></i></a>
			<br>
			<hr>
			<div id="nuevoprecio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="precio" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="precio">Nueva Habitacion » <?=$new_habitaciones?></h3>
					</div>
					<div class="modal-body text-center">
						<h4>Ingrese Caracteristicas de la Habitacion</h4>
						<label>
							<h5>Nombre de la Habitacion » </h5>
							<input type="text" name="nom" placeholder="Ejemplo: Suite Presidensial">
						</label>

						<label>
							<h5>Tipo de la Habitacion »</h5>
							<select name="tip">
								<option value="Simple">Simple</option>
								<option value="Doble">Doble</option>
								<option value="Matrimonial">Matrimonial</option>
								<option value="Triple">Triple</option>
								<option value="Cuadruple">Cuadruple</option>
								<option value="Quintuple">Quintuple</option>
							</select>
						</label>
						
						<br>
						<label>
							<h5>Descripcion de la Habitacion »</h5>
							<textarea class="ckeditor span5" name="des" placeholder="Descripcion de la Habitacion"></textarea>
						</label>											
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