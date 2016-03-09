<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_salida= $_GET['id_salida'];
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
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }

//Datos del tour
$pos_tour = "SELECT * FROM tour WHERE id_pagina='$ids'";
$posi_tour = mysql_db_query($dbname, $pos_tour); 
if ($row = mysql_fetch_array($posi_tour)){ $id_pag_tour = $row["id_tour"]; }

//Numero dia Salidas
$numero_salida = "SELECT COUNT(id_salida) FROM salida WHERE id_tour='$id_pag_tour'";
$numero_salida = mysql_db_query($dbname, $numero_salida);
$numero_salida = mysql_result($numero_salida, 0);
//Dia Siguiente del Itinerario
$sig_salida = $numero_salida + 1;


//Datos de los Precios de los Tours
$gen_pag = "SELECT * FROM salida WHERE id_tour='$id_pag_tour' AND id_salida='$id_salida'";
$gene_pag = mysql_db_query($dbname, $gen_pag); 
if ($row = mysql_fetch_array($gene_pag)){ 

	$id_salida = $row["id_salida"];
	$fec_salida = $row["fec_salida"];
	$hor_salida = $row["hor_salida"];
	$cup_salida = $row["cup_salida"];
	$ocu_salida = $row["ocu_salida"];
	$vis_salida = $row["vis_salida"];
	$pet_salida = $row["pet_salida"];
	$des_salida = $row["des_salida"];

	$cant = $cup_salida - $ocu_salida;
	$porc = $cant / $cup_salida;
	// round(3.655551, 0);
}

if (!$_POST) {
	
} else {

	$fec = $_POST["fec"];
	$hor = $_POST["hor"];
	$cup = $_POST["cup"];
	$ocu = $_POST["ocu"];
	$des = $_POST["des"];
	$vis = $_POST["vis"];
	$pet = $_POST["pet"];
	
	//Editar el Precio
	$editar_fecha = "UPDATE salida SET

							fec_salida = '$fec',
							hor_salida = '$hor',
							cup_salida = '$cup',
							ocu_salida = '$ocu',
							des_salida = '$des',
							vis_salida = '$vis',
							pet_salida = '$pet'

						WHERE id_salida='$id_salida'";

	$cab_editar_fecha = mysql_db_query($dbname, $editar_fecha);

	header("location: dise_tour_salida_edit.php?id=$ids&id_salida=$id_salida&error=$error");
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
		<title>Fechas de Salida del Tour</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href=" dise_tour_salida.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Fechas de Salida del Tour » <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_com_pag?></h4>
			<br>
			<p class="opcion-small inline-block"><img class="ball verde"></img> <small>Disponible</small> </p>
			<p class="opcion-small inline-block"><img class="ball amarillo"></img> <small>Pocos Lugares</small> </p>
			<p class="opcion-small inline-block"><img class="ball ambar"></img> <small>Solo un Lugar</small> </p>
			<p class="opcion-small inline-block"><img class="ball rojo"></img> <small>Agotado</small> </p>
			<p class="opcion-small inline-block"><img class="ball guinda"></img> <small>A peticion</small></p>					
			<hr>
			<div class="text-center">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<h4>Ingrese Caracteristicas de la Fecha de Salida</h4> 
					<p class="estado"> 
						<?php if ($porc>=0.3 && $cant!=1 && $cant!=0) { ?><img class="ball-grande verde"></img> <?php } ?> 
						<?php if ($porc<0.3 && $cant!=1 && $cant!=0) { ?><img class="ball-grande amarillo"></img> <?php } ?> 
						<?php if ($cant==1) { ?><img class="ball-grande ambar"></img> <?php } ?> 
						<?php if ($cant==0 && $pet_salida!=1) { ?><img class="ball-grande rojo"></img> <?php } ?> 
						<?php if ($cant==0 && $pet_salida==1) { ?><img class="ball-grande guinda"></img> <?php } ?> 
					</p>
					

					<h5>Fecha »</h5>
					<input type="date" name="fec" value="<?=$fec_salida?>">
					<h5>Hora »</h5>
					<input type="time" name="hor" class="hora" value="<?=$hor_salida?>">
					<br>
					<br>
					<h5>Cupos del Grupo »</h5>
					<input type="text" name="cup" class="input-mini" placeholder="10" value="<?=$cup_salida?>"><br>
					<h5>Cupos Ocupados del Grupo »</h5>
					<input type="text" name="ocu" class="input-mini" placeholder="10" value="<?=$ocu_salida?>"><br>
					<h5>Fecha de Salida Visible »</h5>
					<select class="input-mini"  name="vis">
						<option value="1" <?php if ($vis_salida==1) { ?> selected <?php } ?>>si</option>
						<option value="0" <?php if ($vis_salida==0) { ?> selected <?php } ?>>no</option>
					</select>		
					<br>
					<h5>Solicitud del Tour Agotado A peticion » </h5>
					<select class="input-mini"  name="pet">
						<option value="1" <?php if ($pet_salida==1) { ?> selected <?php } ?>>si</option>
						<option value="0" <?php if ($pet_salida==1) { ?> selected <?php } ?>>no</option>
					</select>
					<br>
					<label>
						<h5>Descripcion de la Fecha de Salida »</h5>
						<textarea class="span5" name="des" placeholder="Descripcion del Precio"><?=$des_salida?></textarea>
					</label>					

					<br>		

					<button class="btn btn-primary btn-sitio">Guardar</button>
				</form>
			</div>
		</div>
	</body>
</html>