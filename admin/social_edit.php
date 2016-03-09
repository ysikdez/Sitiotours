<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_contacto = $_GET['id_contacto'];
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

//Datos del Contacto
$datos_contacto = "SELECT * FROM contacto WHERE id_contacto='$id_contacto'";
$datos_contacto = mysql_db_query($dbname, $datos_contacto); 
if ($row = mysql_fetch_array($datos_contacto)){ 

	$ord_contacto = $row["ord_contacto"];
	$carg_contacto = $row["carg_contacto"];
	$ape_contacto = $row["ape_contacto"];
	$nom_contacto = $row["nom_contacto"];
	$des_contacto = $row["des_contacto"];
	$vis_contacto = $row["vis_contacto"];
	$act_contacto = $row["act_contacto"];
}

if (!$_POST) {
	
} else {

	$carg = $_POST["carg"];
	$ape = $_POST["ape"];
	$nom = $_POST["nom"];
	$des = $_POST["des"];
	$vis = $_POST["vis"];
	$act = $_POST["act"];

	// if ($vis!=1) { $vis=0;}
	// if ($act!=1) { $act=0;}

	//Editar contacto
	$editar_contacto = "UPDATE contacto SET

							carg_contacto = '$carg',
							ape_contacto = '$ape',
							nom_contacto = '$nom',
							des_contacto = '$des',
							vis_contacto = '$vis',
							act_contacto = '$act'
							

						WHERE id_contacto='$id_contacto'";

	$cab_editar_contacto = mysql_db_query($dbname, $editar_contacto);	


	header("location: social_edit.php?id=$ids&id_contacto=$id_contacto&error=$error");
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
		<title>Editar Contacto de la Pagina</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="social.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>	
			<h3>Editar Constacto de la Pagina » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>

			<div class="text-center">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<h3 id="imagen"><?=$tit_pos_pag?> » Contacto <span class="numero"><?=$ord_contacto?> </span> </h3>
					
					<label>
						<h5>Cargo del Contacto »</h5>
						<input type="text" name="carg" class="span5" placeholder="Cargo" value="<?=$carg_contacto?>">
					</label>
					<label>
						<h5>Apellidos del Contacto »</h5>
						<input type="text" name="ape" class="span5" placeholder="Apellidos" value="<?=$ape_contacto?>">
					</label>
					<label>
						<h5>Nombres del Contacto »</h5>
						<input type="text" name="nom" class="span5" placeholder="Nombres" value="<?=$nom_contacto?>">
					</label>
					<label>
						<h5>Descripcion del Contacto »</h5>
						<textarea class="span5" name="des" placeholder="Descripcion"><?=$des_contacto?></textarea>
					</label>

					<label class="checkbox inline opcion-small">
						<input type="checkbox" name="vis" <?php if ($vis_contacto==1) { ?> checked <?php }?> value="1"> Visible
					</label>
					<label class="checkbox inline opcion-small">
						<input type="checkbox" name="act" <?php if ($act_contacto==1) { ?> checked <?php }?>  value="1"> Activo
					</label>
					<br><br>

					<button class="btn btn-primary btn-sitio">Guardar</button>

				</form>
			</div>
		</div>
	</body>
</html>