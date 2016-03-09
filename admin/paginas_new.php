<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
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

	$idi=$_POST["idi"];
	$niv=$_POST["niv"];
	$ord=$_POST["ord"];
	$per=$_POST["per"];
	$dise=$_POST["dise"];
	$des=$_POST["des"];
	$key=$_POST["key"];
	$tit=$_POST["tit"];
	$tit_pos=$_POST["tit_pos"];
	$tit_com=$_POST["tit_com"];
	$ima_def=1;

	//Datos del Idioma
	$pos_pag = "SELECT abre_idioma FROM idioma WHERE id_idioma='$idi'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 

		$abre_idioma = $row["abre_idioma"];
	}

	$url=urls_amigables($tit_pos);

	$codigo=codigo_pagina($dise,$abre_idioma,$tit_pos,$niv,$ord,$per);


	$nueva_pagina = "INSERT INTO pagina (

							id_idioma,
							niv_pagina,
							ord_pagina,
							per_pagina,
							cod_pagina,
							url_pagina,
							dise_pagina,
							des_pagina,
							key_pagina,
							tit_pagina,
							tit_pos_pagina,
							tit_com_pagina,
							ima_def_pagina,
							vis_pagina

						) VALUES(

							'$idi',
							'$niv',
							'$ord',
							'$per',
							'$codigo',
							'$url',
							'$dise',
							'$des',
							'$key',
							'$tit',
							'$tit_pos',
							'$tit_com',
							'$ima_def',
							'1'

						)";

	$cab_nueva_pagina = mysql_db_query($dbname, $nueva_pagina);	

	//Datos de la Nueva Pagina 
	$new_pag = "SELECT id_pagina,ord_pagina,tit_pos_pagina FROM pagina WHERE id_idioma='$idi' AND niv_pagina='$niv' AND ord_pagina='$ord' AND per_pagina='$per' AND cod_pagina='$codigo'";
	$new_pag = mysql_db_query($dbname, $new_pag); 
	if ($row = mysql_fetch_array($new_pag)){ 
		$id_new_pag = $row["id_pagina"]; 
		$ord_new_pag = $row["ord_pagina"];
		$tit_new_pag = $row["tit_pos_pagina"];
	}

	switch ($dise) {

		//General
		case "General":
			$tipo_general = "INSERT INTO general (id_pagina) VALUES ('$id_new_pag')";
			$cab_tipo_general = mysql_db_query($dbname, $tipo_general);

		break;

		//Tour
		case "Tour":
			//**********************************************//
				//CODIGO DEL TOUR
			//**********************************************//
				$titulo=urls_amigables($tit_pos_pag);//padre
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='TOU'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_tour=$texto[0].'-'.$texto[1];
			//**********************************************//
			$nuevo_tour = "INSERT INTO tour (id_pagina,cod_tour,tipo_tour) VALUES ('$id_new_pag','$codigo_tour','$tit_pos_pag_pad')";
			$cab_nuevo_tour = mysql_db_query($dbname, $nuevo_tour);

		break;

		//Destino
		case "Destino":
			//**********************************************//
				//CODIGO DEL DESTINO
			//**********************************************//
				$titulo=urls_amigables($tit_pos_pag);//padre
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='DES'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_destino=$texto[0].'-'.$texto[1];
			//**********************************************//
			$niv_destino=$niv-1;
			$tipo_destino = "INSERT INTO destino (id_pagina,cod_destino) VALUES ('$id_new_pag','$codigo_destino')";
			$cab_tipo_destino = mysql_db_query($dbname, $tipo_destino);

		break;

		//Opcion de Viaje
		case "Opcion de Viaje":
			//**********************************************//
				//CODIGO DE LA OPCION DE VIAJE
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='OPC'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_opcion=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_opcion = "INSERT INTO opcion (id_pagina,cod_opcion) VALUES ('$id_new_pag','$codigo_opcion')";
			$cab_tipo_opcion = mysql_db_query($dbname, $tipo_opcion);
		break;

		//Agencia de Viaje
		case "Agencia de Viaje":
			//**********************************************//
				//CODIGO DE LA AGENCIA DE VIAJE
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='AGE'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_agencia=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_agencia = "INSERT INTO agencia (id_pagina,cod_agencia) VALUES ('$id_new_pag','$codigo_agencia')";
			$cab_tipo_agencia = mysql_db_query($dbname, $tipo_agencia);
		break;

		//Alojamiento - Hotel
		case "Alojamiento - Hotel":
			//**********************************************//
				//CODIGO DEL ALOJAMIENTO
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='ALO'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_alojamiento=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_alojamiento = "INSERT INTO alojamiento (id_pagina,cod_alojamiento) VALUES ('$id_new_pag','$codigo_alojamiento')";
			$cab_tipo_alojamiento = mysql_db_query($dbname, $tipo_alojamiento);
		break;

		//Restaurante
		case "Restaurante":
			//**********************************************//
				//CODIGO DEL RESTAURANTE
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='RES'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_restaurante=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_restaurante = "INSERT INTO restaurante (id_pagina,cod_restaurante) VALUES ('$id_new_pag','$codigo_restaurante')";
			$cab_tipo_restaurante = mysql_db_query($dbname, $tipo_restaurante);
		break;

		//Tienda
		case "Tienda":
			//**********************************************//
				//CODIGO DE LA TIENDA
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='TIE'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_tienda=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_tienda = "INSERT INTO tienda (id_pagina,cod_tienda) VALUES ('$id_new_pag','$codigo_tienda')";
			$cab_tipo_tienda = mysql_db_query($dbname, $tipo_tienda);
		break;

		//Regalo - Souvenir
		case "Regalo - Souvenir":
			//**********************************************//
				//CODIGO DEL REGALO - SOUVENIR
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='SOU'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_souvenir=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_souvenir = "INSERT INTO souvenir (id_pagina,cod_souvenir) VALUES ('$id_new_pag','$codigo_souvenir')";
			$cab_tipo_souvenir = mysql_db_query($dbname, $tipo_souvenir);
		break;

		//Comida Tipica
		case "Comida Tipica":
			//**********************************************//
				//CODIGO DE LA COMIDA TIPICA
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='TIP'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_tipica=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_tipica = "INSERT INTO tipica (id_pagina,cod_tipica) VALUES ('$id_new_pag','$codigo_tipica')";
			$cab_tipo_tipica = mysql_db_query($dbname, $tipo_tipica);
		break;

		//Sitio Turistico
		case "Sitio Turistico":
			//**********************************************//
				//CODIGO DEL SITIO TURISTICO
			//**********************************************//
				$titulo=urls_amigables($tit_new_pag);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='SIT'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_sitio=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_sitio = "INSERT INTO sitio (id_pagina,cod_sitio) VALUES ('$id_new_pag','$codigo_sitio')";
			$cab_tipo_sitio = mysql_db_query($dbname, $tipo_sitio);
		break;

		//Actividad Turistica
		case "Actividad Turistica":
			//**********************************************//
				//CODIGO DEL SITIO TURISTICO
			//**********************************************//
				$titulo=urls_amigables($tit_pos);
				//Mayuscula
				$t=strtoupper($titulo);
				//La primera 3 letras del tipo de tour
				$ti=str_split($t,3);
				$tipo=$ti[0];

				$orden=add_ceros($ord_new_pag,4);

				$idioma=strtoupper($abre_idioma);

				$txt='ACT'.$tipo.$orden.$idioma;
				$texto=str_split($txt,6);

				$codigo_actividad=$texto[0].'-'.$texto[1];
			//**********************************************//		
			$tipo_actividad = "INSERT INTO actividad (id_pagina,cod_actividad) VALUES ('$id_new_pag','$codigo_actividad')";
			$cab_tipo_actividad = mysql_db_query($dbname, $tipo_actividad);

		break;

		//Recomendacion - Tip Turistico
		case "Recomendaciones":

		break;

		//Galeria
		case "Galeria":

		break;

		//Amigos
		case "Amigos":

		break;

		//Mapa del Sitio
		case "Mapa del Sitio":

		break;

	}

	header("location: paginas_new.php?error=1");

	
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

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Paginas</title>
	</head>
	<body>
		<div class="row contorno">

<?php
//Formulario para una nueva Pagina
//$ingresada=1; 
if ($ingresada!=1) {
?>	
			<h3>Nueva Página</h3>
			<h4><?=$tit_pos_pag?> » Nº <?=$sig_ord?></h4>
			<br>
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<label>
					<h5>Tipo de Diseño de la Pagina »</h5>
					<input list="dise_newpag" name="dise" type="text" class="span5" value="General" required title="Se necesita un Tipo de Diseño">
					<datalist id="dise_newpag">
						<option value="General">
						<option value="Tour">
						<option value="Destino">
						<option value="Opcion de Viaje">
						<option value="Agencia de Viaje">
						<option value="Alojamiento - Hotel">
						<option value="Restaurante">
						<option value="Tienda">
						<option value="Regalo - Souvenir">
						<option value="Comida Tipica">
						<option value="Sitio Turistico">
						<option value="Actividad Turistica">
						<option value="Recomendaciones">
						<option value="Galeria">
						<option value="Amigos">
						<option value="Mapa del Sitio">
					</datalist>
					
					<a data-toggle="modal" class="btn btn-sitio pull-right" href="#np"><i class="icon-play"></i></a>
				</label>

				<div id="np" class="modal hide fade" tabindex="1" role="dialog" aria-labelledby="new" aria-hidden="true">
	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="new"><?=$tit_pos_pag?> » Nº <?=$sig_ord?> </h3>
				</div>

				<div class="modal-body">
		
					<h4>Configuración SEO » </h4>
					<p class="text-justify">Para Añadir una nueva Página debemos rellenar el siguiente formulario para el adecuado posicionamiento: El llenado debe ser lo mas conciso posible y debe reflejar contenido de la pagina..</p>
					
					<input type="hidden" id="idi_newpag" name="idi" value="<?=$id_idi?>">
					<input type="hidden" id="niv_newpag" name="niv" value="<?=$sig_niv?>">
					<input type="hidden" id="ord_newpag" name="ord" value="<?=$sig_ord?>">
					<input type="hidden" id="per_newpag" name="per" value="<?=$ids?>">

					<h5>Nombre Pagina / Titulo</h5>
					<label>
						<h5>
							Titulo de la Pagina »
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Pal.</small></small></span>
								<input type="text" id="pal_ti" class="jerarquia" value="0">
							</div>
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Car.</small></small></span>
								<input type="text" id="car_ti" class="jerarquia" value="0">
							</div>
						</h5>
						<input type="text" id="tex_ti" name="tit" class="span5" onKeyDown="cuentaTitulo()" onKeyUp="cuentaTitulo()" placeholder="Titulo de la Pagina" required title="Se necesita un Titulo de la Página">
					</label>

					<label>
						<h5>
							Titulo para el Posicionamiento » 
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Pal.</small></small></span>
								<input type="text" id="pal_posi" class="jerarquia" value="0">
							</div>
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Car.</small></small></span>
								<input type="text" id="car_posi" class="jerarquia" value="0">
							</div>
						</h5>
						<input type="text" id="tex_posi" name="tit_pos" class="span5" onKeyDown="cuentaPosicionamiento()" onKeyUp="cuentaPosicionamiento()" placeholder="Titulo para el Posicionamiento" required title="Se necesita un Titulo para el Posicionamiento">
					</label>

					<label>
						<h5>Titulo Comercial »</h5>
						<input type="text" name="tit_com" class="span5" placeholder="Titulo Comercial">
					</label>

					<label>
						<h5>
							Descripcion de la Pagina »
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Pal.</small></small></span>
								<input type="text" id="pal_des" class="jerarquia" value="0">
							</div>
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Car.</small></small></span>
								<input type="text" id="car_des" class="jerarquia" value="0">
							</div>
						</h5>
						<textarea rows="3" id="tex_des" name="des" class="span5" onKeyDown="cuentaDescripcion()" onKeyUp="cuentaDescripcion()" placeholder="Descripcion" required title="Se necesita una Descripcion para la Página"></textarea>
					</label>

					<label>
						<h5>
							Palabras Claves de la Pagina »
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Pal.</small></small></span>
								<input type="text" id="pal_key" class="jerarquia" value="0">
							</div>
							<div class="input-prepend pull-right">
								<span class="add-on"><small><small>Car.</small></small></span>
								<input type="text" id="car_key" class="jerarquia" value="0">
							</div>
						</h5>
						<textarea rows="3" id="tex_key" name="key" class="span5" onKeyDown="cuentaKeyword()" onKeyUp="cuentaKeyword()" placeholder="Palabras Claves" required title="Se necesita Palabras Claves para la Página"></textarea>
					</label>	
				</div>

				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
					<button class="btn btn-primary btn-sitio">Guardar</button>
				</div>

			</form>
<?php
} else {
?>
	<h3 class="center">Nueva Página Ingresada Correctamente</h3>
	<script type="text/javascript">
		window.open('paginas.php?error=1', 'seleccion', '');
	</script>
<?php
}
?>
			</div>

<?php
?>
		</div>
	</body>
</html>
