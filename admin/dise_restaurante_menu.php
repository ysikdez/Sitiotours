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

//Datos de la restaurante
$dato_restaurante = "SELECT * FROM restaurante WHERE id_pagina='$ids'";
$dato_restaurante = mysql_db_query($dbname, $dato_restaurante); 
if ($row = mysql_fetch_array($dato_restaurante)){ $id_restaurante = $row["id_restaurante"]; }

//Numero de Platos y Nuevo Platos
$numero_platos = "SELECT COUNT(ord_plato) FROM plato WHERE id_restaurante='$id_restaurante'";
$numero_platos = mysql_db_query($dbname, $numero_platos);
$numero_platos = mysql_result($numero_platos, 0);
$new_plato = $numero_platos +1;


if (!$_POST) {
	
} else {

	$nom = $_POST["nom"];
	$des = $_POST["des"];
	$ing = $_POST["ing"];
	$ela = $_POST["ela"];

	$agregar_plato = "INSERT INTO plato (

								id_restaurante,
								ord_plato,
								nom_plato,
								des_plato,
								ing_plato,
								ela_plato
								
								) VALUES (

								'$id_restaurante',
								'$new_plato',
								'$nom',
								'$des',
								'$ing',
								'$ela'

								)";

	$cab_agregar_plato = mysql_db_query($dbname, $agregar_plato);	

	header("location: dise_restaurante_menu.php?id=$ids&error=$error");
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
		<title>Platos del Restaurante</title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_restaurante.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Menu del Restaurante » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<hr>
			<h5>Platos »</h5>
			<div class="accordion text-justify">
<?php

//Datos de las Platos
$datos_platos = "SELECT * FROM plato WHERE id_restaurante='$id_restaurante' ORDER BY ord_plato";
$datos_platos = mysql_db_query($dbname, $datos_platos); 
while ($row = mysql_fetch_array($datos_platos)){ 

	$id_plat= $row["id_plato"];
	$ord_plat = $row["ord_plato"];
	$nom_plat = $row["nom_plato"];

	$numero_pre_plat = "SELECT COUNT(ord_pprecio) FROM pprecio WHERE id_plato='$id_plat'";
	$numero_pre_plat = mysql_db_query($dbname, $numero_pre_plat);
	$numero_pre_plat = mysql_result($numero_pre_plat, 0);
	$new_pre_plat = $numero_pre_plat + 1;
?>
				<div class="accordion-group">
					<div class="accordion-titulo itinerario">
						<p class="numero"><strong><?=$ord_plat?></strong></p>
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#ord_plat<?=$ord_plat?>"><strong> <?=$nom_plat?></strong></a>
												

						<a href="dise_restaurante_plato_eli.php?id=<?=$ids?>&id_plato=<?=$id_plat?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
						
						<?php if($ord_plat!=$numero_platos) { ?>
						<a href="dise_restaurante_plato_ord.php?id=<?=$ids?>&id_plato=<?=$id_plat?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<?php if($ord_plat!=1) { ?>
						<a href="dise_restaurante_plato_ord.php?id=<?=$ids?>&id_plato=<?=$id_plat?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<a href="dise_restaurante_plato_edit.php?id=<?=$ids?>&id_plato=<?=$id_plat?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
						<a href="dise_restaurante_plato_precio.php?id=<?=$ids?>&id_plato=<?=$id_plat?>&new_precio=<?=$new_pre_plat?>"><h4 class="pull-right icono">$</h4></a>

					</div>
					<div id="ord_plat<?=$ord_plat?>" class="accordion-body collapse">
						<div class="accordion-inner">

	<?php

	//Datos de las precios
	$datos_pre_plato = "SELECT * FROM pprecio WHERE id_plato='$id_plat' ORDER BY ord_pprecio";
	$datos_pre_plato = mysql_db_query($dbname, $datos_pre_plato); 
	while ($row = mysql_fetch_array($datos_pre_plato)){ 

		$id_pprecio = $row["id_pprecio"];
		$ord_pprecio = $row["ord_pprecio"];
		$pla_pprecio = $row["pla_pprecio"];
		$val_hprecio = $row["val_pprecio"];
		$fin_hprecio = $row["fin_pprecio"];
	?>
							<div class="destino-caja">
								<p class="numero"><strong><?=$ord_pprecio?></strong></p> →
								<p class="precio"><small><strong><?=$pla_pprecio?></strong></small></p>
								<p class="numero">×</p>
								<p class="precio"><small><?=$val_hprecio?></small></p>
								<p class="numero"><small><small><strong>USD</strong></small></small></p>
								<p class="precio"><small><small><strong>Hasta »</strong></small></small></p>
								<p class="precio"><small><small><?=$fin_hprecio?></small></small></p>
								
								<a href="dise_restaurante_plato_precio_eli.php?id=<?=$ids?>&id_pprecio=<?=$id_pprecio?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
								<?php if($ord_pprecio!=$numero_pre_plat) { ?>
								<a href="dise_restaurante_plato_precio_ord.php?id=<?=$ids?>&id_pprecio=<?=$id_pprecio?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<?php if($ord_pprecio!=1) { ?>
								<a href="dise_restaurante_plato_precio_ord.php?id=<?=$ids?>&id_pprecio=<?=$id_pprecio?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<a href="dise_restaurante_plato_precio_edit.php?id=<?=$ids?>&id_plato=<?=$id_plat?>&id_pprecio=<?=$id_pprecio?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
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
						<h3 id="precio">Nuevo Plato » <?=$new_plato?></h3>
					</div>
					<div class="modal-body text-center">
						<h4>Ingrese Caracteristicas del Plato</h4>
						<label>
							<h5>Nombre del Plato » </h5>
							<input type="text" name="nom" placeholder="Nombre">
						</label>
						<br>
						<label>
							<h5>Descripcion del Plato »</h5>
							<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Plato"></textarea>
						</label>
						<br>
						<label>
							<h5>Ingredientes del Plato »</h5>
							<textarea class="ckeditor span5" name="ing" placeholder="Ingredientes del Plato"></textarea>
						</label>
						<br>
						<label>
							<h5>Elaboracion del Plato »</h5>
							<textarea class="ckeditor span5" name="ela" placeholder="Elaboracion del Plato"></textarea>
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