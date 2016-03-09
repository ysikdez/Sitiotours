<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_info = $_GET['id_info'];
$error = $_GET['error'];


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
$datos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$datos_pag_pad = mysql_db_query($dbname, $datos_pag_pad); 
if ($row = mysql_fetch_array($datos_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"];}

//Datos de la Informacion de Contacto
$datos_info = "SELECT * FROM info WHERE id_info='$id_info'";
$datos_info = mysql_db_query($dbname, $datos_info); 
if ($row = mysql_fetch_array($datos_info)){ 
	$ord_info = $row["ord_info"];
	$tipo_info = $row["tipo_info"];
	$dato_info = $row["dato_info"];
	$des_info = $row["des_info"];
	$vis_info = $row["vis_info"];
	$act_info = $row["act_info"];
}



if (!$_POST) {
	
} else {

	$tipo = $_POST["tipo"];
	$dato = $_POST["dato"];
	$des = $_POST["des"];
	$vis = $_POST["vis"];
	$act = $_POST["act"];

	//Editar info
	$editar_info = "UPDATE info SET

							tipo_info = '$tipo',
							dato_info = '$dato',
							des_info = '$des',
							vis_info = '$vis',
							act_info = '$act'					

						WHERE id_info='$id_info'";

	$cab_editar_info = mysql_db_query($dbname, $editar_info);	


	header("location: social_info_edit.php?id=$ids&id_info=$id_info&error=$error");
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
		<title>Editar Informacion del Contacto </title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="social.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>			
			<h3>Editar informacion del Contacto » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<hr>
			
			<div class="text_center">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<h3 id="imagen"><?=$tit_pos_pag?> » Informacion del contacto <span class="numero"><?=$ord_info?> </span> </h3>
					
					<div class="text-center">
						<label>
							<h5>Tipo de la Informacion »</h5>
							<select class="opcion-medio" name="tipo">
								<option value="Dirección" <?php if ($tipo_info=="Dirección") { ?> selected <?php }?>>Dirección</option>
								<option value="E-mail" <?php if ($tipo_info=="E-mail") { ?> selected <?php }?>>E-mail</option>
								<option value="Facebook" <?php if ($tipo_info=="Facebook") { ?> selected <?php }?>>Facebook</option>
								<option value="Google+" <?php if ($tipo_info=="Google+") { ?> selected <?php }?>>Google+</option>
								<option value="Instagram" <?php if ($tipo_info=="Instagram") { ?> selected <?php }?>>Instagram</option>
								<option value="Sitio Web" <?php if ($tipo_info=="Sitio Web") { ?> selected <?php }?>>Sitio Web</option>
								<option value="Skype" <?php if ($tipo_info=="Skype") { ?> selected <?php }?>>Skype</option>
								<option value="Telefono" <?php if ($tipo_info=="Telefono") { ?> selected <?php }?>>Telefono</option>
								<option value="Twitter" <?php if ($tipo_info=="Twitter") { ?> selected <?php }?>>Twitter</option>
								<option value="Youtube" <?php if ($tipo_info=="Youtube") { ?> selected <?php }?>>Youtube</option>
							</select>
						</label>
						<label>
							<h5>Informacion »</h5>
							<input type="text" name="dato" class="span5" placeholder="El numero de telefono, Enlace web, Email" value="<?=$dato_info?>">
						</label>						
						<label>
							<h5>Descripcion la Informacion »</h5>
							<textarea class="span5" name="des" placeholder="Descripcion"><?=$des_info?></textarea>
						</label>

						<label class="checkbox inline opcion-small">
							<input type="checkbox" name="vis" <?php if ($vis_info=="1") { ?> checked <?php }?> value="1"> Visible
						</label>
						<label class="checkbox inline opcion-small">
							<input type="checkbox" name="act" <?php if ($act_info=="1") { ?> checked <?php }?> value="1"> Activo
						</label>
						<br>		
						<br>
						<button class="btn btn-primary btn-sitio">Guardar</button>
					</div>

				</form>
			</div>
		</div>
	</body>
</html>