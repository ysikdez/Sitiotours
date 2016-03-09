<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_video = $_GET['id_video'];
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

//Galeria - Video - datos de la Galeria 
$dato_galeria_video = "SELECT * FROM galeria_video WHERE id_video='$id_video' AND id_galeria='$id_galeria'";
$dato_galeria_video = mysql_db_query($dbname, $dato_galeria_video); 
if ($row = mysql_fetch_array($dato_galeria_video)){ $ord_gal_video = $row["ord_galeria_video"];}

//Datos del Video
$datos_video = "SELECT * FROM video WHERE id_video='$id_video'";
$datos_video = mysql_db_query($dbname, $datos_video); 
if ($row = mysql_fetch_array($datos_video)){ 
	$cod_video = $row["cod_video"];	
	$tit_video = $row["tit_video"];	
	$lug_video = $row["lug_video"];	
	$des_video = $row["des_video"];	
	$fec_video = $row["fec_video"];
	$hor_video = $row["hor_video"];
	$vis_video = $row["vis_video"];
}


if (!$_POST) {
	
} else {

	$tit = $_POST["tit"];
	$des = $_POST["des"];
	$lug = $_POST["lug"];
	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$vis = $_POST["vis"];
	$cod = $_POST["cod"];

//existe Galeria

	//Editar el Video del Album Fotografia
	$editar_video = "UPDATE video SET

							tit_video = '$tit',
							des_video = '$des',
							lug_video = '$lug',
							fec_video = '$fecha',
							hor_video = '$hora',
							vis_video = '$vis',
							cod_video = '$cod'

						WHERE id_video ='$id_video'";

	$cab_editar_video = mysql_db_query($dbname, $editar_video);

	header("location: galeria_video_edit.php?id=$ids&id_video=$id_video&error=$error");

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
		<title>Galeria de Video de la Pagina </title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="galeria_video.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Galeria de Video » </h3>
			<div class="text-center">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<h3 id="video"> Album » <?=$tit_pos_pag_pad?> » <?=$tit_pos_pag?> » <span class="numero"><?=$ord_gal_video?></span></h3>

					<h5>Edite los datos del Video de su Album</h5>
					<div class="tour-caja text-center">
						<div class="text-center">
							<?=$cod_video?>
						</div>
					</div>						
					<h6>Titulo del Video</h6>
					<input name="tit" type="text" class="span5" placeholder="Titulo del Video / Alt" value="<?=$tit_video?>">
					<h6>Descripcion del Video</h6>
					<textarea name="des" rows="2" class="span5" placeholder="Descripcion del Video / Figcaption"><?=$des_video?></textarea>
					<h6>Lugar del Video</h6>
					<input name="lug" type="text" class="span5" placeholder="Lugar del Video" value="<?=$lug_video?>">
					<label>
						<h6>Fecha del Video</h6>
						<input name="fecha" type="date" value="<?=$fec_video?>">
						<input name="hora" type="time" class="hora" value="<?=$hor_video?>">
					</label>
					<label class="checkbox inline opcion-small">
						<input type="checkbox" name="vis" <?php if ($vis_video=="1") { ?> checked <?php } ?> value="1"> Visible
					</label>
					<h6>Codigo del Video: Width="560" Height="315"</h6>
					<textarea name="cod" rows="2" class="span5" placeholder="Codigo del Video / Embed"><?=$cod_video?></textarea> 	
					<br><br>
					<button class="btn btn-sitio">Guardar</button>
				</form>
			</div>
			<hr>
		</div>
	</body>
</html>