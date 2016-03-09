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


//Datos del Alojamiento
$datos_alojamiento = "SELECT * FROM alojamiento WHERE id_pagina='$ids'";
$datos_alojamiento = mysql_db_query($dbname, $datos_alojamiento); 
if ($row = mysql_fetch_array($datos_alojamiento)){ 

	$id_alojamiento = $row["id_alojamiento"];
	$cod_alojamiento = $row["cod_alojamiento"];
	$tipo_alojamiento = $row["tipo_alojamiento"];
	$cat_alojamiento = $row["cat_alojamiento"];
	$des_alojamiento = $row["des_alojamiento"];

}

if (!$_POST) {
	
} else {

	$tipo = $_POST["tipo"];
	$cat = $_POST["cat"];
	$des = $_POST["des"];

	$logo_pag = $_POST["logo_pag"];
	$ima_def = $_POST["ima_def"];
	$alt_logo_pag = $_POST["alt_logo_pag"];
	$des_logo_pag = $_POST["des_logo_pag"];	

	//Lista de Servicios del Alojamiento posee
	$dato_serv_aloja = "SELECT * FROM aservicio";
	$dato_serv_aloja = mysql_db_query($dbname, $dato_serv_aloja); 
	while ($row = mysql_fetch_array($dato_serv_aloja)){ 

		$id_aser = $row["id_aservicio"];
		$nom_aservicio = $row["nom_aservicio"];
		$ser_pos=urls_amigables($nom_aservicio);
		$servicio=$_POST[$ser_pos];

		//Se incluye en el Hotel
		$existe_ajolamiento = "SELECT COUNT(id_aservicio) FROM aincluye WHERE id_aservicio='$id_aser' AND id_alojamiento='$id_alojamiento'";
		$existe_ajolamiento = mysql_db_query($dbname, $existe_ajolamiento);
		$existe_ajolamiento = mysql_result($existe_ajolamiento, 0);

		if ($existe_ajolamiento==1) {
			if ($servicio!=1) {
				$modificar = "DELETE FROM aincluye WHERE id_aservicio='$id_aser' AND id_alojamiento='$id_alojamiento'";
				$result = mysql_db_query($dbname, $modificar);	
			} 
			
		} else {
			if ($servicio==1) {
				$incluye_servicio = "INSERT INTO aincluye (id_aservicio,id_alojamiento,act_aincluye) VALUES ('$id_aser','$id_alojamiento',1)";
				$cab_incluye_servicio = mysql_db_query($dbname, $incluye_servicio);	
			}
			
		}

	}


	if ($ima_def==on) {

		$dise_aloja = "UPDATE alojamiento SET 
							tipo_alojamiento = '$tipo',
							cat_alojamiento = '$cat',
							des_alojamiento = '$des'
							WHERE id_pagina='$ids'";
		$db_dise_aloja = mysql_db_query($dbname, $dise_aloja);

	}else {

		$dise_aloja = "UPDATE alojamiento SET 
							tipo_alojamiento = '$tipo',
							cat_alojamiento = '$cat',
							des_alojamiento = '$des'
							WHERE id_pagina='$ids'";
		$db_dise_aloja = mysql_db_query($dbname, $dise_aloja);

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
	

	header("location: dise_alojamiento.php?id=$ids&error=$error");
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
		<title>Editar Alojamiento</title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h4 class="pull-right">Codigo de pagina: <?=$cod_pag?></h4>
				<br>
				<h5>Editar » </h5>					
				<h4>» <?=$tit_pos_pag_pad?></h4>
				<h3>» <?=$tit_pos_pag?></h3>
				<h5>Codigo del Alojamiento » <?=$cod_alojamiento?></h5>
				<hr>
				<label class="text-center">
					<h5>Tipo de Alojamiento » </h5>
					<select name="tipo">
						<option value="Hotel" <?php if ($tipo_alojamiento=="Hotel") { ?> selected <?php }?>>Hotel</option>
						<option value="Hostal" <?php if ($tipo_alojamiento=="Hostal") { ?> selected <?php }?>>Hostal</option>
						<option value="Hospedaje" <?php if ($tipo_alojamiento=="Hospedaje") { ?> selected <?php }?>>Hospedaje</option>

					</select>
				</label>

				<label class="text-center">
					<h5>Categoria de Alojamiento » </h5>
					<select name="cat">
						<option value="5" <?php if ($cat_alojamiento=="5") { ?> selected <?php }?>>5 estrellas</option>
						<option value="4" <?php if ($cat_alojamiento=="4") { ?> selected <?php }?>>4 estrellas</option>
						<option value="3" <?php if ($cat_alojamiento=="3") { ?> selected <?php }?>>3 estrellas</option>
						<option value="2" <?php if ($cat_alojamiento=="2") { ?> selected <?php }?>>2 estrellas</option>
						<option value="1" <?php if ($cat_alojamiento=="1") { ?> selected <?php }?>>1 estrellas</option>

					</select>
				</label>
				<br>
				<h5 class="text-center"> Servicios que Ofrece el Alojamiento » </h5>
<?php
//Lista de Servicios del Alojamiento posee
$dato_serv_aloja = "SELECT * FROM aservicio";
$dato_serv_aloja = mysql_db_query($dbname, $dato_serv_aloja); 
while ($row = mysql_fetch_array($dato_serv_aloja)){ 
	$id_aservicio = $row["id_aservicio"];
	$nom_aservicio = $row["nom_aservicio"];

	$servi=urls_amigables($nom_aservicio);

	$dato_ser_incluido_aloja = "SELECT * FROM aincluye WHERE id_aservicio='$id_aservicio' AND id_alojamiento='$id_alojamiento'";
	$dato_ser_incluido_aloja = mysql_db_query($dbname, $dato_ser_incluido_aloja); 
	if ($row = mysql_fetch_array($dato_ser_incluido_aloja)){
		$act_aincluye = $row["act_aincluye"]; 
	}

?>
				<label class="checkbox inline opcion-medio">
					<input type="checkbox" name="<?=$servi?>" <?php if ($act_aincluye=="1") { ?> checked <?php }?> value="1"><?=$nom_aservicio?>
				</label>

<?php
	$act_aincluye =0;
}
?>
				<input type="hidden" name="servicios" value="<?=$ser_alo?>">
				<br><hr>
				<h5>Destino »
					<a class="btn btn-sitio pull-right" href="dise_alojamiento_destino.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
				</h5>
				<hr>
				<h5>Habitaciones & Precios »
					<a class="btn btn-sitio pull-right" href="dise_alojamiento_habitacion.php?id=<?=$ids?>"><i class="icon-arrow-right"></i></a>
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
					<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Tour"><?=$des_alojamiento?></textarea>
				</label>
				<br>
								
				<label>
					<input type="checkbox" name="ima_def" id="ima_def" <?php if (empty($logo_pag)) { ?> checked="checked" <?php } ?> onclick="imaPrincipal()"> Paginas Generales sin Logo por Defecto
				</label>

				<br>
				<div id="n_ima">
				<?php if (!empty($logo_pag)) { ?>
					<div class="text-center">
						<div class="tour-caja ico-prin">
							<a href="dise_alojamiento_logo_eli.php?id=<?=$ids?>"><div class="pull-right icono"><i class="icon-remove"></i></div></a>
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