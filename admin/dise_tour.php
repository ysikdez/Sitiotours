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

	$niv_pag = $row["niv_pagina"];
	$ord_pag = $row["ord_pagina"];
	$per_pag = $row["per_pagina"];

	$cod_pag = $row["cod_pagina"];

	$dise_pag = $row["dise_pagina"];

	$tit_pag = $row["tit_pagina"];
	$url_pag = $row["url_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
	
	$des_pag = $row["des_pagina"];
	$key_pag = $row["key_pagina"];
	$map_pag = $row["map_pagina"];
	$ima_def_pag = $row["ima_def_pagina"];

}

//Datos de la Pagina Padre ---- Tipo del Tour
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ 
	$id_idioma = $row["id_idioma"];
	$tit_pos_pag_pad = $row["tit_pos_pagina"];
}

//Datos de la Pagina Idioma
$pos_idio = "SELECT * FROM idioma WHERE id_idioma='$id_idioma'";
$posi_idio = mysql_db_query($dbname, $pos_idio); 
if ($row = mysql_fetch_array($posi_idio)){ $abre_idioma = $row["abre_idioma"];}


//Datos de la Pagina Diseño Tour
$gen_pag = "SELECT * FROM tour WHERE id_pagina='$ids'";
$gene_pag = mysql_db_query($dbname, $gen_pag); 
if ($row = mysql_fetch_array($gene_pag)){ 

	$id_tour = $row["id_tour"];
	$cod_tour = $row["cod_tour"];
	$id_agencia = $row["id_agencia"];
	$cod_tour = $row["cod_tour"];
	$tipo_tour = $row["tipo_tour"];
	$dif_tour = $row["dif_tour"];
	$dur_dia_tour = $row["dur_dia_tour"];
	$dur_noc_tour = $row["dur_noc_tour"];
	$des_tour = $row["des_tour"];

}


if (!$_POST) {
	
} else {

	$agencia = $_POST["agencia"];



	$dificultad = $_POST["dificultad"];

	$dias = $_POST["dias"];
	$noches = $_POST["noches"];

	//Opciones del Tour
	$dato_tour_opc = "SELECT * FROM opcion";
	$dato_tour_opc = mysql_db_query($dbname, $dato_tour_opc); 
	while ($row = mysql_fetch_array($dato_tour_opc)){ 

		$id_opci = $row["id_opcion"];
		$id_pag_opci = $row["id_pagina"];

		//titulo de la Pagina
		$dato_pag_opcion = "SELECT url_pagina FROM pagina WHERE id_pagina='$id_pag_opci'";
		$dato_pag_opcion = mysql_db_query($dbname, $dato_pag_opcion); 
		if ($row = mysql_fetch_array($dato_pag_opcion)){ $tit_opcion = $row["url_pagina"]; }

		$opcion=$_POST[$tit_opcion];

		//Se incluye la Opcion
		$existe_opcion = "SELECT COUNT(id_opcion) FROM tour_opcion WHERE id_opcion='$id_opci' AND id_tour='$id_tour'";
		$existe_opcion = mysql_db_query($dbname, $existe_opcion);
		$existe_opcion = mysql_result($existe_opcion, 0);

		if ($existe_opcion==1) {
			if ($opcion!=1) {
				$eliminar_tour_opc = "DELETE FROM tour_opcion WHERE id_opcion='$id_opci' AND id_tour='$id_tour'";
				$result = mysql_db_query($dbname, $eliminar_tour_opc);	
			} 
			
		} else {
			if ($opcion==1) {
				$ingresar_tour_opc = "INSERT INTO tour_opcion (id_opcion,id_tour) VALUES ('$id_opci','$id_tour')";
				$cab_ingresar_tour_opc = mysql_db_query($dbname, $ingresar_tour_opc);	
			}
			
		}

		$error=$tit_opcion.$error.'-'.$id_pag_opci;
	}
	$des_tour = $_POST["des_tour"];

	
	if ($agencia == "Ninguna") { $id_agencia ='null';} else {

		//Datos de la Agencia
		$pos_pag_agencia = "SELECT id_pagina FROM pagina WHERE tit_pos_pagina='$agencia'";
		$posi_pag_agencia = mysql_db_query($dbname, $pos_pag_agencia); 
		if ($row = mysql_fetch_array($posi_pag_agencia)){ $id_pag_agencia = $row["id_pagina"];}

		$pos_pag = "SELECT id_agencia FROM agencia WHERE id_pagina='$id_pag_agencia'";
		$posi_pag = mysql_db_query($dbname, $pos_pag);
		if ($row = mysql_fetch_array($posi_pag)){ $id_agencia = $row["id_agencia"]; $id_agencia ="'".$id_agencia."'";}	
		
	}


	
	//Datos de la Pagina Idioma
	$pos_pag = "SELECT abre_idioma FROM idioma WHERE id_idioma='$idi'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ $abre_idioma = $row["abre_idioma"];}

	//CODIGO DEL TOUR
	$titulo=urls_amigables($tit_pos_pag_pad);
	//Mayuscula
	$t=strtoupper($titulo);
	//La primera 3 letras del tipo de tour
	$ti=str_split($t,3);
	$tipo=$ti[0];

	$orden=add_ceros($ord_pag,4);

	$idioma=strtoupper($abre_idioma);

	$txt='TOU'.$tipo.$orden.$idioma;
	$texto=str_split($txt,6);

	$codigo=$texto[0].'-'.$texto[1];


	$editar_tour = "UPDATE tour SET

						id_agencia = $id_agencia,
						cod_tour = '$codigo',
						tipo_tour = '$tit_pos_pag_pad',
						dif_tour = '$dificultad',
						dur_dia_tour = '$dias',
						dur_noc_tour = '$noches',
						des_tour = '$des_tour'

						WHERE id_pagina='$ids'";

	$cab_editar_tour = mysql_db_query($dbname, $editar_tour);

	header("location: dise_tour.php?id=$ids&error=$error");
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
		<title>Editar Paginas</title>
	</head>
	<body>
		<div class="row contorno">
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h4 class="pull-right">Codigo de pagina: <?=$cod_pag?></h4>
				<br>
				<h3>Editar Tour » <?=$tit_pos_pag_pad?></h3>
				<h4>» <?=$tit_pos_pag?></h4>
				<br>
				<h5>Codigo del Tour » <?=$cod_tour?></h5>
				<hr>
				<br>				
				<label>
					<h5>Agencia »</h5>
<?php
if (!empty ($id_agencia)) {

	//Id de la Agencia del Tour
	$pos_pag_agen = "SELECT * FROM agencia WHERE id_agencia='$id_agencia'";
	$posi_pag_agen = mysql_db_query($dbname, $pos_pag_agen); 
	if ($row = mysql_fetch_array($posi_pag_agen)){ $id_pag_agen = $row["id_pagina"]; }

	//Titulo de la Agencia del Tour
	$pos_pag_agen = "SELECT * FROM pagina WHERE id_pagina='$id_pag_agen' ";
	$posi_pag_agen = mysql_db_query($dbname, $pos_pag_agen); 
	if ($row = mysql_fetch_array($posi_pag_agen)){ $tit_agencia_act = $row["tit_pos_pagina"]; }

} else {
	$tit_agencia_act='Ninguna';
}

?>
					<input list="agencia" type="text" name="agencia" type="text" class="span5" value="<?=$tit_agencia_act?>">
					<datalist id="agencia">
						<option value="Ninguna">
<?php
//Lista de Agencias
$pos_pag_agen = "SELECT DISTINCT tit_pos_pagina FROM pagina WHERE dise_pagina='Agencia de Viaje' ORDER BY tit_pos_pagina";
$posi_pag_agen = mysql_db_query($dbname, $pos_pag_agen); 
while ($row = mysql_fetch_array($posi_pag_agen)){ 
	$tit_agencia = $row["tit_pos_pagina"]; 
?>
						<option value="<?=$tit_agencia?>">

<?php
}
?>
					</datalist>
				</label>
				<br>

				<label class="text-center">
					<h5>Dificultad » </h5>
					<select class="opcion-mini" name="dificultad">
						<option value="1" <?php if ($dif_tour==1) { ?> selected <?php }?>>1</option>
						<option value="2" <?php if ($dif_tour==2) { ?> selected <?php }?>>2</option>
						<option value="3" <?php if ($dif_tour==3) { ?> selected <?php }?>>3</option>
						<option value="4" <?php if ($dif_tour==4) { ?> selected <?php }?>>4</option>
						<option value="5" <?php if ($dif_tour==5) { ?> selected <?php }?>>5</option>
					</select>
				</label>
				<br>
				
				<label class="text-center">
					<h5>Duracion » </h5>
					<strong>Dias</strong>
					<input type="text" name="dias" class="opcion-mini" value="<?=$dur_dia_tour?>" placeholder="1">	
					<p class="numero"></p>		
					<strong>Noches</strong>
					<input type="text" name="noches" class="opcion-mini" value="<?=$dur_noc_tour?>" placeholder="0">
				</label>
				<br>
				<h5 class="text-center"> Opciones de Viaje » </h5>
<?php
//Lista de Opciones de Viaje
$dato_opcion = "SELECT * FROM opcion";
$dato_opcion = mysql_db_query($dbname, $dato_opcion); 
while ($row = mysql_fetch_array($dato_opcion)){ 
	$id_opc = $row["id_opcion"];
	$id_pag_opc = $row["id_pagina"];

	//titulo de la Pagina
	$dato_pag_opcion = "SELECT tit_pos_pagina,url_pagina FROM pagina WHERE id_pagina='$id_pag_opc'";
	$dato_pag_opcion = mysql_db_query($dbname, $dato_pag_opcion); 
	if ($row = mysql_fetch_array($dato_pag_opcion)){ 
		$tit_opcion = $row["tit_pos_pagina"];
		$url_opcion = $row["url_pagina"];
	}

	//especialidad con que cuenta
	$exist_opc = "SELECT COUNT(id_opcion) FROM tour_opcion WHERE id_opcion='$id_opc' AND id_tour='$id_tour'";
	$exist_opc = mysql_db_query($dbname, $exist_opc);
	$exist_opc = mysql_result($exist_opc, 0);

?>
				<label class="checkbox inline opcion-medio">
					<input type="checkbox" name="<?=$url_opcion?>" <?php if ($exist_opc=="1") { ?> checked <?php }?> value="1"><?=$tit_opcion?>
				</label>

<?php
	$exist_opc = 0;
}
?>
				<br><br>
				<br><hr>
				<h5>Destinos »
					<a class="btn btn-sitio pull-right" href="dise_tour_destino.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5>
				<hr>
				<h5>Precios »
					<a class="btn btn-sitio pull-right" href="dise_tour_precio.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5>
				<hr>
				<h5>Itinerarios »
					<a class="btn btn-sitio pull-right" href="dise_tour_itinerario.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
<?php
if ($tit_pos_pag_pad=="Grupal") {
?>
				<h5>Fechas de Salida »
					<a class="btn btn-sitio pull-right" href="dise_tour_salida.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
<?php
}
?>
				<h5>Galeria: Fotos »
					<a class="btn btn-sitio pull-right" href="galeria_foto.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
				<h5>Galeria: Videos »
					<a class="btn btn-sitio pull-right" href="galeria_video.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
				<h5>Red Social »
					<a class="btn btn-sitio pull-right" href="social.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
				<br>

				<label>
					<h5>Descripcion de la Pagina »</h5>
					<textarea class="ckeditor span5" name="des_tour" placeholder="Descripcion del Tour"><?=$des_tour?></textarea>
				</label>
				<br>


				<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
			</form>
		</div>
	</body>
</html>