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
	$cod_pag = $row["cod_pagina"];

	$per_pag = $row["per_pagina"];

	$dise_pag = $row["dise_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
	
	$ima_def_pag = $row["ima_def_pagina"];

	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];	

}

//Datos de la Pagina Padre --
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


//Datos del Restaurante
$datos_restaurante = "SELECT * FROM restaurante WHERE id_pagina='$ids'";
$datos_restaurante = mysql_db_query($dbname, $datos_restaurante); 
if ($row = mysql_fetch_array($datos_restaurante)){ 

	$id_restaurante = $row["id_restaurante"];
	$cod_restaurante = $row["cod_restaurante"];
	$tipo_restaurante = $row["tipo_restaurante"];
	$cat_restaurante = $row["cat_restaurante"];
	$des_restaurante = $row["des_restaurante"];
	$afo_restaurante = $row["afo_restaurante"];
	$open_a_restaurante = $row["open_a_restaurante"];
	$close_a_restaurante = $row["close_a_restaurante"];
	$open_b_restaurante = $row["open_b_restaurante"];
	$close_b_restaurante = $row["close_b_restaurante"];

}

if (!$_POST) {
	
} else {

	$afo = $_POST["afo"];
	$cat = $_POST["cat"];

	$open_a = $_POST["open_a"];
	$close_a = $_POST["close_a"];

	$open_b = $_POST["open_b"];
	$close_b = $_POST["close_b"];

	$des = $_POST["des"];

	$logo_pag = $_POST["logo_pag"];
	$ima_def = $_POST["ima_def"];
	$alt_logo_pag = $_POST["alt_logo_pag"];
	$des_logo_pag = $_POST["des_logo_pag"];	

	//Restaurante para ocasiones
	$dato_rest_oca = "SELECT * FROM rocasion";
	$dato_rest_oca = mysql_db_query($dbname, $dato_rest_oca); 
	while ($row = mysql_fetch_array($dato_rest_oca)){ 

		$id_roca = $row["id_rocasion"];
		$nom_rocasion = $row["nom_rocasion"];
		$ser_pos=urls_amigables($nom_rocasion);
		$ocasion=$_POST[$ser_pos];

		//Se incluye la ocasion
		$existe_ocasion = "SELECT COUNT(id_rocasion) FROM restaurante_rocasion WHERE id_rocasion='$id_roca' AND id_restaurante='$id_restaurante'";
		$existe_ocasion = mysql_db_query($dbname, $existe_ocasion);
		$existe_ocasion = mysql_result($existe_ocasion, 0);

		if ($existe_ocasion==1) {
			if ($ocasion!=1) {
				$eliminar_rest_oca = "DELETE FROM restaurante_rocasion WHERE id_rocasion='$id_roca' AND id_restaurante='$id_restaurante'";
				$result = mysql_db_query($dbname, $eliminar_rest_oca);	
			} 
			
		} else {
			if ($ocasion==1) {
				$ingresar_rest_oca = "INSERT INTO restaurante_rocasion (id_rocasion,id_restaurante) VALUES ('$id_roca','$id_restaurante')";
				$cab_ingresar_rest_oca = mysql_db_query($dbname, $ingresar_rest_oca);	
			}
			
		}

	}

	//Tipos de Restaurante
	$dato_tipo_rest = "SELECT * FROM tipo";
	$dato_tipo_rest = mysql_db_query($dbname, $dato_tipo_rest); 
	while ($row = mysql_fetch_array($dato_tipo_rest)){ 

		$id_tip = $row["id_tipo"];
		$nom_tipo = $row["nom_tipo"];
		$ser_tip=urls_amigables($nom_tipo);
		$tipo=$_POST[$ser_tip];

		//Se incluye en el Hotel
		$existe_tipo = "SELECT COUNT(id_tipo) FROM tipo WHERE id_tipo='$id_tip' AND id_restaurante='$id_restaurante'";
		$existe_tipo = mysql_db_query($dbname, $existe_tipo);
		$existe_tipo = mysql_result($existe_tipo, 0);

		if ($existe_tipo==1) {
			if ($tipo!=1) {
				$eliminar_rest_tip = "DELETE FROM restaurante_tipo WHERE id_tipo='$id_tip' AND id_restaurante='$id_restaurante'";
				$result = mysql_db_query($dbname, $eliminar_rest_tip);	
			} 
			
		} else {
			if ($tipo==1) {
				$ingresar_tip_rest = "INSERT INTO restaurante_tipo (id_tipo,id_restaurante) VALUES ('$id_tip','$id_restaurante')";
				$cab_ingresar_tip_rest = mysql_db_query($dbname, $ingresar_tip_rest);	
			}
			
		}

	}

	//Lista de especialidades
	$dato_esp_rest = "SELECT * FROM especialidad";
	$dato_esp_rest = mysql_db_query($dbname, $dato_esp_rest); 
	while ($row = mysql_fetch_array($dato_esp_rest)){ 

		$id_esp = $row["id_especialidad"];
		$nom_especialidad = $row["nom_especialidad"];
		$nom_esp=urls_amigables($nom_especialidad);
		$especialidad=$_POST[$nom_esp];

		//especialidades del restaurante
		$existe_especialidad = "SELECT COUNT(id_especialidad) FROM restaurante_especialidad WHERE id_especialidad='$id_esp' AND id_restaurante='$id_restaurante'";
		$existe_especialidad = mysql_db_query($dbname, $existe_especialidad);
		$existe_especialidad = mysql_result($existe_especialidad, 0);

		if ($existe_especialidad==1) {
			if ($especialidad!=1) {
				$modificar = "DELETE FROM restaurante_especialidad WHERE id_especialidad='$id_esp' AND id_restaurante='$id_restaurante'";
				$result = mysql_db_query($dbname, $modificar);	
			} 
			
		} else {
			if ($especialidad==1) {
				$ingresar_esp_rest = "INSERT INTO restaurante_especialidad (id_especialidad,id_restaurante) VALUES ('$id_esp','$id_restaurante')";
				$cab_ingresar_esp_rest = mysql_db_query($dbname, $ingresar_esp_rest);	
			}
			
		}

	}


	if ($ima_def==on) {

		$dise_rest = "UPDATE restaurante SET 

							afo_restaurante = '$afo',
							cat_restaurante = '$cat',
							open_a_restaurante = '$open_a',
							close_a_restaurante = '$close_a',
							open_b_restaurante = '$open_b',
							close_b_restaurante = '$close_b',
							des_restaurante = '$des'

							WHERE id_pagina='$ids'";

		$db_dise_rest = mysql_db_query($dbname, $dise_rest);

	}else {

		$dise_rest = "UPDATE restaurante SET 

							afo_restaurante = '$afo',
							cat_restaurante = '$cat',
							open_a_restaurante = '$open_a',
							close_a_restaurante = '$close_a',
							open_b_restaurante = '$open_b',
							close_b_restaurante = '$close_b',
							des_restaurante = '$des'

							WHERE id_pagina='$ids'";
							
		$db_dise_rest = mysql_db_query($dbname, $dise_rest);

		//Archivo
		$destino = $_SERVER['DOCUMENT_ROOT'].'/img/' ; //Destino donde se guardaran los archivos
		$tamano = $_FILES ['logo_pag']['size']; //Tamaño del archivo 
		$val = intval($tamano);

		//Nombre con el que la imagen sera guardada
		$nombre = urls_amigables($alt_logo_pag); 
		$lugar = "sitiotours";
		$fecha = date("Y-m-d");

		//Cantidad de Imagenes Principales 
		$n_ima = "SELECT COUNT(DISTINCT logo_pagina) FROM pagina";
		$max_ima = mysql_db_query($dbname, $n_ima);
		$max_ima = mysql_result($max_ima, 0);
		$sig_ima = $max_ima+1;
		$numero = add_ceros($sig_ima,2);
		
		//Tipo de Archivo 
		$arch=explode('.',$_FILES ['logo_pag']['name']);
		$tipo_arch='.'.$arch[1];
		//Nombre de la Imagen Principal 
		$nom_ima_prin=$nombre.'-'.$lugar.'-'.$fecha.'-'.$numero.$tipo_arch;

		// Comprobamos el tamaño del archivo debe ser menor 20kb
		if( $tamano < 20480 ){
			
			move_uploaded_file ( $_FILES [ 'logo_pag' ][ 'tmp_name' ], $destino.$nom_ima_prin); 

			$editar_pagina = "UPDATE pagina SET	
								logo_pagina = '$nom_ima_prin',
								alt_logo_pagina = '$alt_logo_pag',
								des_logo_pagina = '$des_logo_pag'
								WHERE id_pagina='$ids'";
			$bd_editar_pagina = mysql_db_query($dbname, $editar_pagina);	

		}else {

			$editar_pagina = "UPDATE pagina SET
								alt_logo_pagina = '$alt_logo_pag',
								des_logo_pagina = '$des_logo_pag'
								WHERE id_pagina='$ids'";
			$bd_editar_pagina = mysql_db_query($dbname, $editar_pagina);
		}
	
	}
	

	header("location: dise_restaurante.php?id=$ids&error=$error");
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
		<title>Editar Restaurante</title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h4 class="pull-right">Codigo de pagina: <?=$cod_pag?></h4>
				<br>
				<h5>Editar » </h5>					
				<h4>» <?=$tit_pos_pag_pad?></h4>
				<h3>» <?=$tit_pos_pag?></h3>
				<h5>Codigo del Restaurante » <?=$cod_restaurante?></h5>
				<hr>
				<label class="text-center">
					<h5>Aforo del Restaurante » </h5>
					<input type="text" name="afo" class="opcion-mini" placeholder="10" value="<?=$afo_restaurante?>">
				</label>
				<label class="text-center">
					<h5>Categoria del Restaurante » </h5>
					<select name="cat">
						<option value="5" <?php if ($cat_restaurante=="5") { ?> selected <?php }?>>5 Tenedores</option>
						<option value="4" <?php if ($cat_restaurante=="4") { ?> selected <?php }?>>4 Tenedores</option>
						<option value="3" <?php if ($cat_restaurante=="3") { ?> selected <?php }?>>3 Tenedores</option>
						<option value="2" <?php if ($cat_restaurante=="2") { ?> selected <?php }?>>2 Tenedores</option>
						<option value="1" <?php if ($cat_restaurante=="1") { ?> selected <?php }?>>1 Tenedor</option>
					</select>
				</label>
				<div class="text-center">
					<h5>Horario de Atencion del Restaurante»</h5>
					<h6>Horario 1 »</h6>
					<label>
						Apertura : <input type="time" name="open_a" class="hora" value="<?=$open_a_restaurante?>">
						<p class="precio"></p>
						Cierre : <input type="time" name="close_a" class="hora" value="<?=$close_a_restaurante?>">
					</label>

					<h6>Horario 2 »</h6>
					<label>
						Apertura : <input type="time" name="open_b" class="hora" value="<?=$open_b_restaurante?>">
						<p class="precio"></p>
						Cierre : <input type="time" name="close_b" class="hora" value="<?=$close_b_restaurante?>">
					</label>
				</div>
				<br>

				<h5 class="text-center"> El restaurante tiene las Siguientes Especialidades » </h5>
<?php
//Lista de Especialidades
$dato_especialidad = "SELECT * FROM especialidad";
$dato_especialidad = mysql_db_query($dbname, $dato_especialidad); 
while ($row = mysql_fetch_array($dato_especialidad)){ 
	$id_esp = $row["id_especialidad"];
	$nom_esp = $row["nom_especialidad"];

	$esp=urls_amigables($nom_esp);

	//especialidad con que cuenta
	$exist_esp_rest = "SELECT COUNT(id_especialidad) FROM restaurante_especialidad WHERE id_especialidad='$id_esp' AND id_restaurante='$id_restaurante'";
	$exist_esp_rest = mysql_db_query($dbname, $exist_esp_rest);
	$exist_esp_rest = mysql_result($exist_esp_rest, 0);

?>
				<label class="checkbox inline opcion-medio">
					<input type="checkbox" name="<?=$esp?>" <?php if ($exist_esp_rest=="1") { ?> checked <?php }?> value="1"><?=$nom_esp?>
				</label>

<?php
	$exist_esp_rest = 0;
}
?>
				<br><br><br>
				<h5 class="text-center"> El Restaurante es del Tipo » </h5>
<?php
//Tipo de Restaurante
$dato_tipo = "SELECT * FROM tipo";
$dato_tipo = mysql_db_query($dbname, $dato_tipo); 
while ($row = mysql_fetch_array($dato_tipo)){ 
	$id_tip = $row["id_tipo"];
	$nom_tip = $row["nom_tipo"];

	$tip=urls_amigables($nom_tip);

	//Tipo de restaurante que es
	$exist_tip_rest = "SELECT COUNT(id_tipo) FROM restaurante_tipo WHERE id_tipo='$id_tip' AND id_restaurante='$id_restaurante'";
	$exist_tip_rest = mysql_db_query($dbname, $exist_tip_rest);
	$exist_tip_rest = mysql_result($exist_tip_rest, 0);

?>
				<label class="checkbox inline opcion-medio">
					<input type="checkbox" name="<?=$tip?>" <?php if ($exist_tip_rest=="1") { ?> checked <?php }?> value="1"><?=$nom_tip?>
				</label>

<?php
	$exist_tip_rest = 0;
}
?>
				<br><br><br>
				<h5 class="text-center"> El restaurante es para Ocasiones » </h5>
<?php
//Restaurante es para Ocasiones
$dato_ocasion = "SELECT * FROM rocasion";
$dato_ocasion = mysql_db_query($dbname, $dato_ocasion); 
while ($row = mysql_fetch_array($dato_ocasion)){ 
	$id_rocas = $row["id_rocasion"];
	$nom_rocas = $row["nom_rocasion"];

	$oca=urls_amigables($nom_rocas);

	//Tipo de restaurante que es
	$exist_oca_rest = "SELECT COUNT(id_rocasion) FROM restaurante_rocasion WHERE id_rocasion='$id_rocas' AND id_restaurante='$id_restaurante'";
	$exist_oca_rest = mysql_db_query($dbname, $exist_oca_rest);
	$exist_oca_rest = mysql_result($exist_oca_rest, 0);

?>
				<label class="checkbox inline opcion-medio">
					<input type="checkbox" name="<?=$oca?>" <?php if ($exist_oca_rest=="1") { ?> checked <?php }?> value="1"><?=$nom_rocas?>
				</label>

<?php
	$exist_oca_rest =0;
}
?>
				<br><br><hr>
				<h5>Destino »
					<a class="btn btn-sitio pull-right" href="dise_restaurante_destino.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5><hr>
				<h5>Menu & Precios »
					<a class="btn btn-sitio pull-right" href="dise_restaurante_menu.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5>
				<hr>
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
					<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Tour"><?=$des_restaurante?></textarea>
				</label>
				<br>
								
				<label>
					<input type="checkbox" name="ima_def" id="ima_def" <?php if (empty($logo_pag)) { ?> checked="checked" <?php } ?> onclick="imaPrincipal()"> 
					Sin Logo por Defecto
				</label>

				<br>
				<div id="n_ima">
				<?php if (!empty($logo_pag)) { ?>
					<div class="text-center">
						<div class="tour-caja ico-prin">
							<a href="dise_restaurante_logo_eli.php?id=<?=$ids?>"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
							<img src="../img/<?=$logo_pag?>" alt="<?=$alt_logo_pag?>" border="0">
						</div>
					</div>
				<?php } ?>
					
					<label>
						<h5>Titulo del Logo de la pagina / Alt »</h5>
						<input type="text" name="alt_logo_pag" class="span5" placeholder="Titulo de la Imagen / Alt" value="<?=$alt_logo_pag?>">
					</label>
					<label>
						<h5>Descripcion del Logo de la pagina / Figcaption »</h5>
						<textarea rows="2" name="des_logo_pag" class="span5" placeholder="Descripcion de la Imagen / Figcaption"><?=$des_logo_pag?></textarea>
					</label>
					<input type="file" name="logo_pag" class="txt">
				</div>
				<br>

				<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
			</form>
		</div>
	</body>
</html>