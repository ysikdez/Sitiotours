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

//Numero dia Salidas
$numero_salida = "SELECT COUNT(id_salida) FROM salida WHERE id_tour='$id_pag_tour'";
$numero_salida = mysql_db_query($dbname, $numero_salida);
$numero_salida = mysql_result($numero_salida, 0);
//Dia Siguiente del Itinerario
$sig_salida = $numero_salida + 1;



if (!$_POST) {
	
} else {

	$fec = $_POST["fec"];
	$hor = $_POST["hor"];
	$cup = $_POST["cup"];
	$ocu = $_POST["ocu"];
	$des = $_POST["des"];
	$vis = $_POST["vis"];
	$pet = $_POST["pet"];


	//Nuevo fecha de Salida
	$nueva_fecha = "INSERT INTO salida (

							id_tour,
							fec_salida,
							hor_salida,
							cup_salida,
							ocu_salida,
							des_salida,
							vis_salida,
							pet_salida

						) VALUES(

							'$id_pag_tour',
							'$fec',
							'$hor',
							'$cup',
							'$ocu',
							'$des',
							'$vis',
							'$pet'

						)";

	$cab_nueva_fecha = mysql_db_query($dbname, $nueva_fecha);	
	$error=$id_gen;

	header("location: dise_tour_salida.php?id=$ids&error=$error");
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
			<a class="btn btn-sitio pull-right" href="dise_tour.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Fechas de Salida del Tour » <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_com_pag?></h4>
			<hr>

			<h4>Fechas de Salida » id tour <?=$id_pag_tour?></h4>
				<p class="opcion-small inline-block"><img class="ball verde"></img> Disponible </p>
				<p class="opcion-small inline-block"><img class="ball amarillo"></img> Pocos Lugares </p>
				<p class="opcion-small inline-block"><img class="ball ambar"></img> Solo un Lugar </p>
				<p class="opcion-small inline-block"><img class="ball rojo"></img> Agotado </p>
				<p class="opcion-small inline-block"><img class="ball guinda"></img> A peticion</p>
			<br><br>

			<strong><small>
				<p class="fecha"> Fecha </p> |
				<p class="grupo"> Nª Gru </p> |
				<p class="ocupante"> Nª Ocu </p> |
				<p class="estado"> Est. </p> |
				<p class="activo">Vis.</p>
			</small></strong>
<?php

//Datos de los Precios de los Tours
$gen_pag = "SELECT * FROM salida WHERE id_tour='$id_pag_tour' ORDER BY fec_salida";
$gene_pag = mysql_db_query($dbname, $gen_pag); 
while ($row = mysql_fetch_array($gene_pag)){ 

	$id_salida = $row["id_salida"];
	$fec_salida = $row["fec_salida"];
	$cup_salida = $row["cup_salida"];
	$ocu_salida = $row["ocu_salida"];
	$vis_salida = $row["vis_salida"];
	$pet_salida = $row["pet_salida"];

	$cant = $cup_salida - $ocu_salida;
	$porc = $cant / $cup_salida;
	// round(3.655551, 0);

?>
			<div class="destino-caja">				
				<p class="fecha"><small><small><?=$fec_salida?></small></small></p>
				<p class="grupo"><small> <?=$cup_salida?></small></p>
				<p class="ocupante"><small> <?=$ocu_salida?></small></p>
				<p class="estado"> 
					<?php if ($porc>=0.3 && $cant!=1 && $cant!=0) { ?><img class="ball verde"></img> <?php } ?> 
					<?php if ($porc<0.3 && $cant!=1 && $cant!=0) { ?><img class="ball amarillo"></img> <?php } ?> 
					<?php if ($cant==1) { ?><img class="ball ambar"></img> <?php } ?> 
					<?php if ($cant==0 && $pet_salida!=1) { ?><img class="ball rojo"></img> <?php } ?> 
					<?php if ($cant==0 && $pet_salida==1) { ?><img class="ball guinda"></img> <?php } ?> 
				</p>
				<p class="activo"><small><?php if ($vis_salida==1) { ?> si <?php }else{?> no <?php }?></small></p>
				<a href="dise_tour_salida_eli.php?id=<?=$ids?>&id_salida=<?=$id_salida?>"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
				<a href="dise_tour_salida_edit.php?id=<?=$ids?>&id_salida=<?=$id_salida?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
			</div>
<?php 
}
?>

			<br>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevasalida"><i class="icon-plus"></i></a>
			<br>
			<hr>

			<div id="nuevasalida" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imagen" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="itinerario"> Tour <?=$tit_pos_pag?> » Fecha de Salida <span class="numero"><?=$sig_salida?> </span></h3>
					</div>

					<div class="modal-body text-center">
						<h4>Ingrese Caracteristicas de la Fecha de Salida »</h4>
						<h5>Fecha »</h5>
						<input type="date" name="fec">
						<h5>Hora »</h5>
						<input type="time" name="hor" class="hora">
						<br>
						<br>
						<h5>Cupos del Grupo »</h5>
						<input type="text" name="cup" class="input-mini" placeholder="10"><br>
						<h5>Cupos Ocupados del Grupo »</h5>
						<input type="text" name="ocu" class="input-mini" placeholder="10"><br>
						<h5>Fecha de Salida Visible »</h5>
						<select class="input-mini"  name="vis">
							<option value="1">si</option>
							<option value="0">no</option>
						</select>		
						<br>
						<h5>Solicitud del Tour Agotado A peticion » </h5>
						<select class="input-mini"  name="pet">
							<option value="1">si</option>
							<option value="0">no</option>
						</select>
						<br>
						<label>
							<h5>Descripcion de la Fecha de Salida »</h5>
							<textarea class="span5" name="des" placeholder="Descripcion del Precio"></textarea>
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