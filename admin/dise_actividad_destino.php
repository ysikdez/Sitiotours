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

	$per_pag = $row["per_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
}


//Datos de la Pagina Padre
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ 
	$id_idioma = $row["id_idioma"];
	$tit_pos_pag_pad = $row["tit_pos_pagina"];
}

//Datos del actividad
$pos_tour = "SELECT * FROM actividad WHERE id_pagina='$ids'";
$posi_tour = mysql_db_query($dbname, $pos_tour); 
if ($row = mysql_fetch_array($posi_tour)){ 
	$id_actividad = $row["id_actividad"]; 
	$id_destino = $row["id_destino"]; 
}


if (!$_POST) {
	
} else {

	$region = $_POST["region"];
	$pais = $_POST["pais"];
	$ciudad = $_POST["ciudad"];
	$interior = $_POST["interior"];

	if ($region=="Ninguna") {
		$error="Debe escoger algun destino";

	} else {

		if ($pais=="Ninguna" && $region!="Ninguna") {
			
			$id_pag_new_des=$region;
	
		}

		if ($ciudad=="Ninguna" && $pais!="Ninguna" && $region!="Ninguna") {
			
			$id_pag_new_des=$pais;
	
		}

		if ($interior=="Ninguna" && $ciudad!="Ninguna" && $pais!="Ninguna" && $region!="Ninguna") {
			
			$id_pag_new_des=$ciudad;

		}

		if ($interior!="Ninguna" && $ciudad!="Ninguna" && $pais!="Ninguna" && $region!="Ninguna") {
			
			$id_pag_new_des=$interior;
		}

		//Datos del destino
		$dato_pag_destino = "SELECT * FROM destino WHERE id_pagina='$id_pag_new_des'";
		$dato_pag_destino = mysql_db_query($dbname, $dato_pag_destino); 
		if ($row = mysql_fetch_array($dato_pag_destino)){ $id_new_des = $row["id_destino"]; }


		//Nuevo destino
		$nuevo_destino = "UPDATE actividad SET id_destino = $id_new_des WHERE id_pagina='$ids'";

		$cab_nuevo_destino = mysql_db_query($dbname, $nuevo_destino);	
	}

	$error=$id_new_des;

	header("location: dise_actividad_destino.php?id=$ids&error=$error");
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
		<title>Destino del Alojamiento</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_actividad.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Destino »</h3>  
			<h3>» <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_com_pag?></h4>
			<hr>
			


<?php
				
			if ($id_destino==0) {
			} else {
				

				$pagina_destino = "SELECT id_pagina FROM destino WHERE id_destino=$id_destino";
				$pagina_destino = mysql_db_query($dbname, $pagina_destino); 
				while ($row = mysql_fetch_array($pagina_destino)){ $id_pag = $row["id_pagina"];}

				//Necesita el id de la pagina del destino
				$ids_dest="'".$id_pag."',".pagPadreDestino($dbname,$id_pag);
				$ids_dest = substr($ids_dest, 0, -1);

				?>
				<div class="destino-caja">
					
					<strong>
				<?php
				$des_pad = "SELECT * FROM pagina WHERE id_pagina IN ($ids_dest)";
				$des_pad = mysql_db_query($dbname, $des_pad); 
				while ($row = mysql_fetch_array($des_pad)){ 

						$id_des = $row["id_pagina"];
						$ord_des = $row["ord_pagina"];
						$niv_des = $row["niv_pagina"];
						$tit_des = $row["tit_pos_pagina"];				
				?>
						
							
					<?=$tit_des?> » 

				<?php
				}
				$pad_id='';		

	?>
					</strong>
				</div>

	<?php 	}	?>

			<br>			
				<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevodestino"><i class="icon-plus"></i></a>
				<br>

				<div id="nuevodestino" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="destino" aria-hidden="true">
					<form method="post" enctype="multipart/form-data" name="formulario" action="">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="destino">Nuevo destino</h3>
						</div>
						<div class="modal-body text-center">
							<h4>Selecione el Destino</h4>
							<h5>Region</h5>
							<div id="region">
								<select name="region" OnChange="selectDestino()">
									<option value="Ninguna">Elige</option>

<?php
//Datos de los detalles del Diseño General
$des_region = "SELECT * FROM pagina WHERE niv_pagina='2' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
$des_region = mysql_db_query($dbname, $des_region); 
while ($row = mysql_fetch_array($des_region)){ 

	$id_pag_region = $row["id_pagina"];
	$tit_pag_region = $row["tit_pos_pagina"];

?>
									<option value="<?=$id_pag_region?>"><?=$tit_pag_region?></option>
<?php 
}
?>
								</select>
							</div>

							<h5>Pais</h5>
							<div id="pais">
								<select name="pais" OnChange="selectDestino()">
									<option value="Ninguna">Elige</option>

<?php
//Datos de los detalles del Diseño General
$des_pais = "SELECT * FROM pagina WHERE niv_pagina='3' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
$des_pais = mysql_db_query($dbname, $des_pais); 
while ($row = mysql_fetch_array($des_pais)){ 

	$id_pag_pais = $row["id_pagina"];
	$tit_pag_pais = $row["tit_pos_pagina"];

?>
									<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
<?php 
}
?>
								</select>
							</div>

							<h5>Ciudad</h5>
							<div id="ciudad">
								<select name="ciudad" OnChange="selectDestino()">
									<option value="Ninguna">Elige</option>

<?php
//Datos de los detalles del Diseño General
$des_ciudad = "SELECT * FROM pagina WHERE niv_pagina='4' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
while ($row = mysql_fetch_array($des_ciudad)){ 

	$id_pag_ciudad = $row["id_pagina"];
	$tit_pag_ciudad = $row["tit_pos_pagina"];

?>
									<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
<?php 
}
?>
								</select>
							</div>

							<h5>Interior</h5>
							<div id="interior">
								<select name="interior" OnChange="selectDestino()">
									<option value="Ninguna">Elige</option>

<?php
//Datos de los detalles del Diseño General
$des_interior = "SELECT * FROM pagina WHERE niv_pagina='5' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
$des_interior = mysql_db_query($dbname, $des_interior); 
while ($row = mysql_fetch_array($des_interior)){ 

	$id_pag_interior = $row["id_pagina"];
	$tit_pag_interior = $row["tit_pos_pagina"];

?>
									<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
<?php 
}
?>
								</select>
							</div>
									
						</div>		
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
							<button class="btn btn-primary btn-sitio">Guardar</button>
						</div>
					</form>
				</div>
				<hr>





		</div>
	</body>
</html>