<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_itinerario = $_GET['id_itinerario'];
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

//Datos del dia del Itinerario del Tour
$dato_dia = "SELECT * FROM itinerario WHERE id_itinerario='$id_itinerario'";
$dato_dia = mysql_db_query($dbname, $dato_dia); 
if ($row = mysql_fetch_array($dato_dia)){

	$id_tour = $row["id_tour"];
	$ord_itinerario = $row["ord_itinerario"];
	$tit_pos_itinerario = $row["tit_pos_itinerario"];
	$tit_com_itinerario = $row["tit_com_itinerario"];
	$des_itinerario = $row["des_itinerario"];
	$arch_ima_itinerario = $row["arch_ima_itinerario"];
	$tit_ima_itinerario = $row["tit_ima_itinerario"];
	$lug_ima_itinerario = $row["lug_ima_itinerario"];
	$fec_ima_itinerario = $row["fec_ima_itinerario"];
	$des_ima_itinerario = $row["des_ima_itinerario"];

}
$fecha_hora=explode('--',$fec_ima_itinerario);
$fecha=$fecha_hora[0];
$hora=$fecha_hora[1];

if (!$_POST) {
	
} else {

	$tit_pos = $_POST["tit_pos"];
	$tit_com = $_POST["tit_com"];
	$des = $_POST["des"];

	$tit_ima = $_POST["tit_ima"];
	$des_ima = $_POST["des_ima"];
	$lug_ima = $_POST["lug_ima"];

	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$fec_ima = $fecha.'--'.$hora;
	
	$arch_ima = $_POST["arch_ima"];

	//Archivo
	$destino = $_SERVER['DOCUMENT_ROOT'].'/image/' ; //Destino donde se guardaran los archivos
	$tamano = $_FILES ['arch_ima']['size']; //Tamaño del archivo 
	$val = intval($tamano);

	//Nombre con el que la imagen sera guardada
	$nombre = urls_amigables($tit_ima); 
	$lugar = urls_amigables($lug_ima);
	$fecha = urls_amigables($fec_ima);

	//Dia del Itinerario del Tour 
	$numero = add_ceros($sig_dia,3);
	
	//Tipo de Archivo 
	$arch=explode('.',$_FILES ['arch_ima']['name']);
	$tipo_arch='.'.$arch[1];
	//Nombre de la Imagen del Dia del Itinerario del Tour
	$nom_ima=$nombre.'-'.$lugar.'-'.$fecha.'-'.$numero.$tipo_arch;
	// $error = $nom_ima;

	if( !empty($val)) {

		// Comprobamos el tamaño del archivo debe ser menor 200kb
		if( $tamano < 204800 ){

			@unlink($nom_ima);

			move_uploaded_file ( $_FILES [ 'arch_ima' ][ 'tmp_name' ], $destino.$nom_ima); 
						
			//Editando Imagen
			$editar_dia = "UPDATE itinerario SET

								tit_pos_itinerario = '$tit_pos',
								tit_com_itinerario = '$tit_com',
								des_itinerario = '$des',

								arch_ima_itinerario = '$nom_ima',
								tit_ima_itinerario = '$tit_ima',
								des_ima_itinerario = '$des_ima',					
								lug_ima_itinerario = '$lug_ima',
								fec_ima_itinerario = '$fec_ima'
								
								WHERE id_itinerario='$id_itinerario'";

			$cab_editar_dia = mysql_db_query($dbname, $editar_dia);

		} else { $error = "El archivo pesa mas de lo determinado"; }
	} else {

		//Editando Imagen
		$editar_dia = "UPDATE itinerario SET

							tit_pos_itinerario = '$tit_pos',
							tit_com_itinerario = '$tit_com',
							des_itinerario = '$des'
							
							WHERE id_itinerario='$id_itinerario'";

		$cab_editar_dia = mysql_db_query($dbname, $editar_dia);	
	}

	$servicio = $_POST["servicio"];
	for ($sv=1; $sv <= $servicio ; $sv++) { 
		$serv[$sv] = $_POST["serv_".$sv];
		$id_iservicio = $serv[$sv];

		if (empty($id_iservicio)) {
			//Dato del Servicio 
			$datos_servicio = "SELECT * FROM iincluye WHERE id_itinerario='$id_itinerario' AND id_iservicio='$sv'";
			$datos_servicio = mysql_db_query($dbname, $datos_servicio); 
			if ($row = mysql_fetch_array($datos_servicio)){ $act_iincluye = $row["act_iincluye"];}

			if ($act_iincluye==1) {
				//Editando Servicio
				$editar_dia = "UPDATE iincluye SET act_iincluye = '0' WHERE id_itinerario='$id_itinerario' AND id_iservicio='$sv'";
				$cab_editar_dia = mysql_db_query($dbname, $editar_dia);

			} 

		} else {
			//Cantidad del Servicio
			$n_servicio = "SELECT COUNT(id_itinerario) FROM iincluye WHERE id_itinerario='$id_itinerario' AND id_iservicio='$id_iservicio'";
			$n_servicio = mysql_db_query($dbname, $n_servicio);
			$n_servicio = mysql_result($n_servicio, 0);

			if ($n_servicio==0) {
				//Insertar Servicio
				//Nuevos de Servicios del Itinerario del Tour
				$nuevo_servicio = "INSERT INTO iincluye ( id_itinerario,id_iservicio,act_iincluye) VALUES('$id_itinerario','$id_iservicio','1')";
				$cab_nuevo_servicio = mysql_db_query($dbname, $nuevo_servicio);	

			}

			//Dato del Servicio 
			$datos_servicio = "SELECT * FROM iincluye WHERE id_itinerario='$id_itinerario' AND id_iservicio='$id_iservicio'";
			$datos_servicio = mysql_db_query($dbname, $datos_servicio); 
			if ($row = mysql_fetch_array($datos_servicio)){ $act_iincluye = $row["act_iincluye"];}

			if ($act_iincluye==0 && $n_servicio==1) {
				//Editando Servicio
				$editar_dia = "UPDATE iincluye SET act_iincluye = '1' WHERE id_itinerario='$id_itinerario' AND id_iservicio='$id_iservicio'";
				$cab_editar_dia = mysql_db_query($dbname, $editar_dia);

			}
		}
		


		//Nuevos de Servicios del Itinerario del Tour
		$nuevo_servicio = "INSERT INTO iincluye (

								id_itinerario,
								id_iservicio,
								act_iincluye

							) VALUES(

								'$id_tour_itinerario',
								'$id_iservicio',
								'1'

							)";

		$cab_nuevo_servicio = mysql_db_query($dbname, $nuevo_servicio);	
	}

	header("location: dise_tour_itinerario_edit.php?id=$ids&id_itinerario=$id_itinerario&error=$error");

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
		<title>Itinerario del Tour</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_tour_itinerario.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Itinerario del Tour » <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_pos_pag?></h4>
			<div>
				<form method="post" enctype="multipart/form-data" name="formulario" action="">

					<h4>» Dia <?=$ord_itinerario?></h4>

					<label>
						<h5>Titulo de Posicionamiento</h5>
						<input type="text" name="tit_pos" class="span5" placeholder="Titulo de Posicionamiento" value="<?=$tit_pos_itinerario?>">
					</label>
					<label>
						<h5>Titulo Comercial</h5>
						<input type="text" name="tit_com" class="span5" placeholder="Titulo Comercial" value="<?=$tit_com_itinerario?>">
					</label>
					
					<h5>Descripcion del Nuevo Día »</h5>
					<textarea class="ckeditor span5" name="des" placeholder="Descripcion de la Imagen / Figcaption"><?=$des_itinerario?></textarea>
					<br>
					<h5>Que incluye el Día »</h5>

<?php
//Lista de lo que Incluye en el Dia 
$serv=0;
$pos_pag_agen = "SELECT * FROM iservicio ORDER BY id_iservicio";
$posi_pag_agen = mysql_db_query($dbname, $pos_pag_agen); 
while ($row = mysql_fetch_array($posi_pag_agen)){ 
	$serv++;
	$id_iservicio = $row["id_iservicio"]; 
	$nom_iservicio = $row["nom_iservicio"];

	//que esta activo el lo que incluye
	$activo_servicio = "SELECT act_iincluye FROM iincluye WHERE id_itinerario='$id_itinerario' AND id_iservicio='$id_iservicio'";
	$activo_servicio = mysql_db_query($dbname, $activo_servicio); 
	if ($row = mysql_fetch_array($activo_servicio)){ $act_servicio = $row["act_iincluye"]; }
?>
						<label class="checkbox inline opcion-small">
							<input type="checkbox" name="serv_<?=$serv?>" <?php if ($act_servicio==1) { ?> checked <?php } ?> value="<?=$id_iservicio?>"><?=$nom_iservicio?>
						</label>

<?php
	$act_servicio=0;
}
?>
						<input type="hidden" name="servicio" value="<?=$serv?>">
						
						<br><hr>
						<h5>Datos del Posicionamiento de la Imagen</h5>
<?php if (!empty($arch_ima_itinerario)) { ?>
						<div class="tour-caja ima-prin">
						<a href="dise_tour_itinerario_ima_eli.php?id=<?=$ids?>&id_itinerario=<?=$id_itinerario?>">
							<div class="pull-right icono"><i class="icon-remove"></i></div>
						</a>
							<figure>
								<img src="../image/<?=$arch_ima_itinerario?>" alt="<?=$tit_ima_itinerario?>" border="0">
							</figure>
						</div>
<?php } ?>
						<h6>Titulo de la Imagen</h6>
						<input name="tit_ima" type="text" class="span5" placeholder="Titulo de la Imagen / Alt" value="<?=$tit_ima_itinerario?>">
						<h6>Descripcion de la Imagen</h6>
						<textarea name="des_ima" rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"><?=$des_ima_itinerario?></textarea>
						<h6>Lugar de la Imagen</h6>
						<input name="lug_ima" type="text" class="span5" placeholder="Lugar de la Imagen" value="<?=$lug_ima_itinerario?>">
						<label>
							<h6>Fecha de la Imagen</h6>
							<input name="fecha" type="date" value="<?=$fecha?>">
							<input name="hora" type="time" class="hora" value="<?=$hora?>">
						</label>
						<h6>Archivo de la Imagen</h6>
						<input name="arch_ima" type="file" class="txt">	
						<br><br>
						<button class="btn btn-sitio pull-right btn-small">Guardar</button>

				</form>
			</div>
		</div>
	</body>
</html>