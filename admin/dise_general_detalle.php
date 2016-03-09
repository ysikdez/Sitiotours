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

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
}

//Datos del diseño genereal
$pos_pag = "SELECT * FROM general WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ $id_gen = $row["id_general"]; }



if (!$_POST) {
	
} else {

	$sig_detalle = $_POST["sig_detalle"];
	$tit_detalle = $_POST["tit_detalle"];
	$des_detalle = $_POST["des_detalle"];


	//Nuevo detalle
	$nuevo_detalle = "INSERT INTO detalle (

							id_general,
							ord_detalle,
							tit_detalle,
							des_detalle

						) VALUES(

							'$id_gen',
							'$sig_detalle',
							'$tit_detalle',
							'$des_detalle'

						)";

	$cab_nuevo_detalle = mysql_db_query($dbname, $nuevo_detalle);	
	$error=$id_gen;

	header("location: dise_general_detalle.php?id=$ids&error=$error");
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
		<title>Detalles de la Pagina</title>
	</head>
	<body onload="cuentaTitulo();imaPrincipal();">
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_general.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Lista de Detalles de la Pagina » </h3>						
			<h4>» <?=$tit_pos_pag?></h4>
			<h5>» <?=$tit_com_pag?></h5>
			<hr>
			<div class="accordion text-justify">
<?php

$n_menu = "SELECT COUNT(ord_detalle) FROM detalle WHERE id_general='$id_gen'";
$orden = mysql_db_query($dbname, $n_menu);
$orden = mysql_result($orden, 0);

//Datos de los detalles del Diseño General
$gen_pag = "SELECT * FROM detalle WHERE id_general='$id_gen' ORDER BY ord_detalle";
$gene_pag = mysql_db_query($dbname, $gen_pag); 
while ($row = mysql_fetch_array($gene_pag)){ 

	$id_detalle = $row["id_detalle"];
	$ord_detalle = $row["ord_detalle"];
	$tit_detalle = $row["tit_detalle"];
	$des_detalle = $row["des_detalle"];
?>
				<div class="accordion-group">
					<div class="accordion-titulo itinerario">
						<p class="numero"><strong><?=$ord_detalle?></strong></p>
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#orden<?=$ord_detalle?>"><strong> <?=$tit_detalle?></strong></a>
												
<?php
    if ($ord_detalle!=0) {
?>
						<a href="dise_general_detalle_eli.php?id=<?=$ids?>&id_detalle=<?=$id_detalle?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
						<?php if($ord_detalle!=$orden) { ?>
						<a href="dise_general_detalle_ord.php?id=<?=$ids?>&id_detalle=<?=$id_detalle?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<?php if($ord_detalle!=1) { ?>
						<a href="dise_general_detalle_ord.php?id=<?=$ids?>&id_detalle=<?=$id_detalle?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<a href="dise_general_detalle_edit.php?id=<?=$ids?>&id_detalle=<?=$id_detalle?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>

<?php
    } else {
?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<a href="paginas_edit.php?id=<?=$ids?>" target="edicion"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
<?php
    }
?>

					</div>
					<div id="orden<?=$ord_detalle?>" class="accordion-body collapse">
						<div class="accordion-inner">
							<?=$des_detalle?>
						</div>
					</div>
				</div>
<?php
}
?>
			</div>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevodetalle"><i class="icon-plus"></i></a>

<?php

$sig=$orden+1;

?>
			<div id="nuevodetalle" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imagen" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="imagen"><?=$tit_pos_pag?> » <span class="numero"><?=$sig?> </span> Detalle</h3>
					</div>

					<div class="modal-body">
						<input type="hidden" name="sig_detalle" value="<?=$sig?>">
						<label>
							<h5>Titulo del Detalle »</h5>
							<input type="text" name="tit_detalle" class="span5" placeholder="Titulo de la Imagen / Alt" required title="Se necesita el titulo">
						</label>
						<label>
							<h5>Descripcion del Detalle »</h5>
							<textarea class="ckeditor span5" name="des_detalle" required title="Se necesita la descripcion"></textarea>
						</label>
						<br>		
					</div>

					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<button class="btn btn-primary btn-sitio">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>