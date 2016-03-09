<?php 
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$ingresada = $_GET['error'];

//Datos de la Pagina Padre 
$pos_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 

	$ord_pag = $row["ord_pagina"];
	$niv_pag = $row["niv_pagina"];
	$per_pag = $row["per_pagina"];
	$id_idi = $row["id_idioma"];
	$tit_pos_pag = $row["tit_pos_pagina"];
}

//el nuevo nivel de la nueva pagina 
$sig_niv = $niv_pag+1;

$n_sub = "SELECT MAX(ord_pagina) FROM pagina WHERE id_idioma='$id_idi' && niv_pagina='$sig_niv' && per_pagina='$ids'";
$max_sub = mysql_db_query($dbname, $n_sub);
$max_sub = mysql_result($max_sub, 0);

//el nuevo nuemero de orden de la nueva pagina 
$sig_ord = $max_sub+1;

if (!$_POST) {
	
} else {

	$dise=$_POST["dise"];
	$idi=$_POST["idi"];
	$niv=$_POST["niv"];
	$ord=$_POST["ord"];
	$per=$_POST["per"];
	$tit=$_POST["tit"];
	$tit_pos=$_POST["tit_pos"];
	$tit_com=$_POST["tit_com"];
	$des=$_POST["des"];
	$key=$_POST["key"];
	$ima=$_POST["ima"];
	
}



 //echo $ids."string".$ingresada;

	// if (!$_POST){  }
	
	// else{ 
	// 				$ti_itinerario_ct = $_POST["ti_itinerario_ct"];
	// 				$tipo_itinerario_ct = $_POST["tipo_itinerario_ct"];
	// 				$txt_itinerario_ct = $_POST["txt_itinerario_ct"];
					
	// 				$desayuno_ico = $_POST["desayuno_ico"];
	// 				$almuerzo_ico = $_POST["almuerzo_ico"];
	// 				$cena_ico = $_POST["cena_ico"];
	// 				$hotel_ico = $_POST["hotel_ico"];
	// 				$avion_ico = $_POST["avion_ico"];
	// 				$tren_ico = $_POST["tren_ico"];
	// 				$bus_ico = $_POST["bus_ico"];
	// 				$bote_ico = $_POST["bote_ico"];
	// 				$trek_ico = $_POST["trek_ico"];
	// 				$camping_ico = $_POST["camping_ico"];
	// 				$ticket_ico = $_POST["ticket_ico"];

	// 				$ti_ima_itinerario_ct = $_POST["ti_ima_itinerario_ct"];
					
	// 				$destino = $_SERVER['DOCUMENT_ROOT'].'/ima' ; 
	// 				$tamano = $_FILES [ 'ima_itinerario_ct' ][ 'size' ]; 
	// 				$prefijo = substr(md5(uniqid(rand())),0,3);
	// 				$nombre = urls_amigables($ti_ima_itinerario_ct);
	// 				$val =intval($tamano);
					
	// 			$indice = "SELECT COUNT(*) FROM itinerario_ct WHERE id_tour_ct='$id_tour_ct'";
	// 			$i = mysql_db_query($dbname, $indice);
	// 			$i = mysql_result($i, 0);
	// 			$pos_itinerario_ct = $i + 1;

					
	// 	if($tipo_itinerario_ct == on) 
	// 	{
			
	// 		$iti = "INSERT INTO itinerario_ct (
																	 
	// 							ti_itinerario_ct,
	// 							tipo_itinerario_ct,
	// 							pos_itinerario_ct,
	// 							id_tour_ct
					
	// 							) VALUES
				
	// 							('$ti_itinerario_ct',
	// 							 '$tipo_itinerario_ct',
	// 							 '$pos_itinerario_ct',
	// 							 '$id_tour_ct'
	// 							)";
	// 		$cab_iti = mysql_db_query($dbname, $iti);	
						
	// 	} else {
			
	// 	if( empty($val)) 
	// 	{

	// 		$modificar = "INSERT INTO itinerario_ct (
																	 
	// 							ti_itinerario_ct,
	// 							tipo_itinerario_ct,
	// 							txt_itinerario_ct,
	// 							ti_ima_itinerario_ct,
	// 							pos_itinerario_ct,
	// 							id_tour_ct
					
	// 							) VALUES
				
	// 							('$ti_itinerario_ct',
	// 							 '$tipo_itinerario_ct',
	// 							 '$txt_itinerario_ct', 
	// 							 '$ti_ima_itinerario_ct',
	// 							 '$pos_itinerario_ct',
	// 							 '$id_tour_ct'
	// 							)";
												
	// 			$result = mysql_db_query($dbname, $modificar);
				
	// 			$pos = "SELECT * FROM itinerario_ct WHERE pos_itinerario_ct='$pos_itinerario_ct' AND id_tour_ct='$id_tour_ct'";
	// 			$posi = mysql_db_query($dbname, $pos); 
	// 			if ($row = mysql_fetch_array($posi))	{ $id_itinerario_ct = $row["id_itinerario_ct"]; }
				
	// 			$modificar = "INSERT INTO icono_ct (
														 
	// 							desayuno_ico,
	// 							almuerzo_ico,
	// 							cena_ico,
	// 							hotel_ico,
	// 							avion_ico,
	// 							tren_ico,
	// 							bus_ico,
	// 							bote_ico,
	// 							trek_ico,
	// 							camping_ico,
	// 							ticket_ico,
	// 							id_itinerario_ct
								
	// 							) VALUES
				
	// 							('$desayuno_ico', 
	// 							 '$almuerzo_ico', 
	// 							 '$cena_ico', 
	// 							 '$hotel_ico',
	// 							 '$avion_ico',
	// 							 '$tren_ico',
	// 							 '$bus_ico',
	// 							 '$bote_ico',
	// 							 '$trek_ico',
	// 							 '$camping_ico',
	// 							 '$ticket_ico',
	// 							 '$id_itinerario_ct'
	// 							)";
												
	// 			$result = mysql_db_query($dbname, $modificar);
				
	// 	} else {

	// 	// Comprobamos el tamaño 
	// 		if( $tamano < 204800 ){ 
				
	// 			move_uploaded_file ( $_FILES [ 'ima_itinerario_ct' ][ 'tmp_name' ], 
	// 								 $destino . '/'. $nombre . '-' . $prefijo . '-' . $_FILES [ 'ima_itinerario_ct' ][ 'name' ]); 
		
	// 			$ima_itinerario_ct =  $nombre . '-' . $prefijo . '-' . $_FILES [ 'ima_itinerario_ct' ][ 'name' ] ;
				
				
	// 			$modificar = "INSERT INTO itinerario_ct (
														 
	// 							ti_itinerario_ct,
	// 							tipo_itinerario_ct,
	// 							txt_itinerario_ct,
	// 							ti_ima_itinerario_ct,
	// 							ima_itinerario_ct,
	// 							pos_itinerario_ct,
	// 							id_tour_ct
					
	// 							) VALUES
				
	// 							('$ti_itinerario_ct',
	// 							 '$tipo_itinerario_ct',
	// 							 '$txt_itinerario_ct', 
	// 							 '$ti_ima_itinerario_ct',
	// 							 '$ima_itinerario_ct',
	// 							 '$pos_itinerario_ct',
	// 							 '$id_tour_ct'
	// 							)";
												
	// 			$result = mysql_db_query($dbname, $modificar);
				
	// 			$pos = "SELECT * FROM itinerario_ct WHERE pos_itinerario_ct='$pos_itinerario_ct' AND id_tour_ct='$id_tour_ct'";
	// 			$posi = mysql_db_query($dbname, $pos); 
	// 			if ($row = mysql_fetch_array($posi))	{ $id_itinerario_ct = $row["id_itinerario_ct"]; }
				
	// 			$modificar = "INSERT INTO icono_ct (
														 
	// 							desayuno_ico,
	// 							almuerzo_ico,
	// 							cena_ico,
	// 							hotel_ico,
	// 							avion_ico,
	// 							tren_ico,
	// 							bus_ico,
	// 							bote_ico,
	// 							trek_ico,
	// 							camping_ico,
	// 							ticket_ico,
	// 							id_itinerario_ct
								
	// 							) VALUES
				
	// 							('$desayuno_ico', 
	// 							 '$almuerzo_ico', 
	// 							 '$cena_ico', 
	// 							 '$hotel_ico',
	// 							 '$avion_ico',
	// 							 '$tren_ico',
	// 							 '$bus_ico',
	// 							 '$bote_ico',
	// 							 '$trek_ico',
	// 							 '$camping_ico',
	// 							 '$ticket_ico',
	// 							 '$id_itinerario_ct'
	// 							)";
												
	// 			$result = mysql_db_query($dbname, $modificar);
	// 			$error = "1"
				
	// 		} else  $error = "El archivo pesa mas de lo determinado"; 				
		
	// 	}

	// 	}

	// 	header("location: new_pagina.php?error=$error");

	// }

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

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Imagenes Principales</title>
	</head>
	<body>
		<div class="row contorno">
			<div class="text-center">
				<a class="btn btn-sitio pull-right" href="edit_paginas.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
				<h3>Imagenes principales</h3>

				<form name="formulario" method="post" action="">
	
					<select name="trimestres" OnChange="tipoIma();loadXMLDoc()">
					<option value="1er. Trimestre" selected>1er. Trimestre</option>
					<option value="2do. Trimestre">2er. Trimestre</option>
					<option value="3er. Trimestre">3er. Trimestre</option>
					<option value="4to. Trimestre">4to. Trimestre</option>
					</select>

					<input type="text" id="nom" name="nom">

				</form>

				<div id="myDiv"><h2>Let AJAX change this text</h2></div>


				
				<div class="tour-caja ima-prin">
					<p class="numero"><strong>1</strong></p>
					<a href="#"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
					<a type="submit" data-toggle="modal" href="#editarimagen">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
					</a>

					<figure>
					<img src="../image/12.jpg" alt="Logo Sitiotours.com" border="0">
					</figure>
					<figcaption>
						<h5>Tours</h5>
						La magia de concer lugares nuevos y unicos en el mundo, un sueño en tus manos
					</figcaption>
				</div>
				<div class="tour-caja ima-prin">
					<p class="numero"><strong>2</strong></p>
					<a href="#"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
					<a type="submit" data-toggle="modal" href="#editarimagen">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
					</a>

					<figure>
					<img src="../image/1.jpg" alt="Logo Sitiotours.com" border="0">
					</figure>
					<figcaption>
						<h5>Tours</h5>
						La magia de concer lugares nuevos y unicos en el mundo, un sueño en tus manos
					</figcaption>
				</div>
				<div class="tour-caja ima-prin">
					<p class="numero"><strong>3</strong></p>
					<a href="#"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
					<a type="submit" data-toggle="modal" href="#editarimagen">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
					</a>

					<figure>
					<img src="../image/2.jpg" alt="Logo Sitiotours.com" border="0">
					</figure>
					<figcaption>
						<h5>Tours</h5>
						La magia de concer lugares nuevos y unicos en el mundo, un sueño en tus manos
					</figcaption>
				</div>
				<div class="tour-caja ima-prin">
					<p class="numero"><strong>4</strong></p>
					<a href="#"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
					<a type="submit" data-toggle="modal" href="#editarimagen">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
					</a>

					<figure>
					<img src="../image/3.jpg" alt="Logo Sitiotours.com" border="0">
					</figure>
					<figcaption>
						<h5>Tours</h5>
						La magia de concer lugares nuevos y unicos en el mundo, un sueño en tus manos
					</figcaption>
				</div>
				<div class="tour-caja ima-prin">
					<p class="numero"><strong>5</strong></p>
					<a href="#"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
					<a href="#"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
					<a type="submit" data-toggle="modal" href="#editarimagen">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
					</a>

					<figure>
					<img src="../image/4.jpg" alt="Logo Sitiotours.com" border="0">
					</figure>
					<figcaption>
						<h5>Tours</h5>
						La magia de concer lugares nuevos y unicos en el mundo, un sueño en tus manos
					</figcaption>
				</div>
			</div>
			<br>
			
		<div>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#editarimagen">Nueva Imagen</a>
		</div>

		<div id="editarimagen" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imagen" aria-hidden="true">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="imagen"><span class="numero">1</span>Imagen</h3>
			</div>

			<div class="modal-body">
				<img src="../image/4.jpg" alt="Logo Sitiotours.com" border="0">
				<h5>Datos del Carrusel</h5>
				<input type="text" class="span5" placeholder="Titulo">
				<textarea rows="3" class="span5" placeholder="Descripcion"></textarea>
				<input type="text" class="span5" placeholder="Nombre del Boton">
				<input type="text" class="span5" placeholder="Link del Boton">
				<br>
				<h5>Datos del Posicionamiento de la Imagen</h5>
				<input type="text" class="span5" placeholder="Nombre del Archivo de la Imagen">
				<input type="text" class="span5" placeholder="Titulo de la Imagen / Alt">
				<textarea rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"></textarea>
				<input type="file" class="txt">


			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<button class="btn btn-primary">Save changes</button>
			</div>
		</div>


		</div>
	</body>
</html>