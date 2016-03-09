<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$error = $_GET['error'];
$id_articulo = $_GET['id_articulo'];



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
	
	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];

}

//Datos de la Pagina Padre ---- 
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }

//Datos de la tienda
$datos_tienda = "SELECT * FROM tienda WHERE id_pagina='$ids'";
$datos_tienda = mysql_db_query($dbname, $datos_tienda); 
if ($row = mysql_fetch_array($datos_tienda)){ 
	$id_tienda = $row["id_tienda"]; 
	$ord_tienda = $row["ord_tienda"]; 
}

//Datos del Plato
$datos_articulo = "SELECT * FROM articulo WHERE id_articulo='$id_articulo'";
$datos_articulo = mysql_db_query($dbname, $datos_articulo); 
if ($row = mysql_fetch_array($datos_articulo)){ 

	$ord_articulo = $row["ord_articulo"]; 
	$tit_articulo = $row["tit_articulo"]; 
	$des_articulo = $row["des_articulo"]; 
	$car_articulo = $row["car_articulo"]; 
	$ela_articulo = $row["ela_articulo"]; 
}


if (!$_POST) {
	
} else {

	$tit = $_POST["tit"]; 
	$des = $_POST["des"]; 
	$car = $_POST["car"]; 

	//Articulo para categoriaes
	$dato_art_cat = "SELECT * FROM categoria";
	$dato_art_cat = mysql_db_query($dbname, $dato_art_cat); 
	while ($row = mysql_fetch_array($dato_art_cat)){ 

		$id_cat = $row["id_categoria"];
		$nom_categoria = $row["nom_categoria"];
		$ser_pos=urls_amigables($nom_categoria);
		$categoria=$_POST[$ser_pos];

		//Se incluye la categoria
		$existe_categoria = "SELECT COUNT(id_categoria) FROM articulo_categoria WHERE id_categoria='$id_cat' AND id_articulo='$id_articulo'";
		$existe_categoria = mysql_db_query($dbname, $existe_categoria);
		$existe_categoria = mysql_result($existe_categoria, 0);

		if ($existe_categoria==1) {
			if ($categoria!=1) {
				$eliminar_art_cat = "DELETE FROM articulo_categoria WHERE id_categoria='$id_cat' AND id_articulo='$id_articulo'";
				$result = mysql_db_query($dbname, $eliminar_art_cat);	
			} 
			
		} else {
			if ($categoria==1) {
				$ingresar_art_cat = "INSERT INTO articulo_categoria (id_categoria,id_articulo) VALUES ('$id_cat','$id_articulo')";
				$cab_ingresar_art_cat = mysql_db_query($dbname, $ingresar_art_cat);	
			}
			
		}

	}

	//Categoria Ocasion
	$dato_art_oca = "SELECT * FROM ocasion";
	$dato_art_oca = mysql_db_query($dbname, $dato_art_oca); 
	while ($row = mysql_fetch_array($dato_art_oca)){ 

		$id_oca = $row["id_ocasion"];
		$nom_ocasion = $row["nom_ocasion"];
		$ser_oca=urls_amigables($nom_ocasion);
		$ocasion=$_POST[$ser_oca];

		//Se incluye la Ocasion
		$existe_ocasion = "SELECT COUNT(id_ocasion) FROM articulo_ocasion WHERE id_ocasion='$id_oca' AND id_articulo='$id_articulo'";
		$existe_ocasion = mysql_db_query($dbname, $existe_ocasion);
		$existe_ocasion = mysql_result($existe_ocasion, 0);

		if ($existe_ocasion==1) {
			if ($ocasion!=1) {
				$eliminar_art_oca = "DELETE FROM articulo_ocasion WHERE id_ocasion='$id_oca' AND id_articulo='$id_articulo'";
				$result = mysql_db_query($dbname, $eliminar_art_oca);	
			} 
			
		} else {
			if ($ocasion==1) {
				$ingresar_art_oca = "INSERT INTO articulo_ocasion (id_ocasion,id_articulo) VALUES ('$id_oca','$id_articulo')";
				$cab_ingresar_art_oca = mysql_db_query($dbname, $ingresar_art_oca);	
			}
			
		}

	}

	//Articulo puede ser Dirigido 
	$dato_art_dir = "SELECT * FROM dirigido";
	$dato_art_dir = mysql_db_query($dbname, $dato_art_dir); 
	while ($row = mysql_fetch_array($dato_art_dir)){ 

		$id_diri = $row["id_dirigido"];
		$nom_dirigido = $row["nom_dirigido"];
		$ser_pos=urls_amigables($nom_dirigido);
		$dirigido=$_POST[$ser_pos];

		//Se incluye lo dirigido
		$existe_dirigido = "SELECT COUNT(id_dirigido) FROM articulo_dirigido WHERE id_dirigido='$id_diri' AND id_articulo='$id_articulo'";
		$existe_dirigido = mysql_db_query($dbname, $existe_dirigido);
		$existe_dirigido = mysql_result($existe_dirigido, 0);

		if ($existe_dirigido==1) {
			if ($dirigido!=1) {
				$eliminar_art_dir = "DELETE FROM articulo_dirigido WHERE id_dirigido='$id_diri' AND id_articulo='$id_articulo'";
				$result = mysql_db_query($dbname, $eliminar_art_dir);	
			} 
			
		} else {
			if ($dirigido==1) {
				$ingresar_art_dir = "INSERT INTO articulo_dirigido (id_dirigido,id_articulo) VALUES ('$id_diri','$id_articulo')";
				$cab_ingresar_art_dir = mysql_db_query($dbname, $ingresar_art_dir);	
			}
			
		}

	}	

	$editar_articulo = "UPDATE articulo SET 

						tit_articulo = '$tit',
						des_articulo = '$des',
						car_articulo = '$car'

						WHERE id_articulo='$id_articulo'";

	$db_editar_articulo = mysql_db_query($dbname, $editar_articulo);

	header("location: dise_tienda_articulo_edit.php?id=$ids&id_articulo=$id_articulo&error=$error");
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
		<title>Editar Articulo Tienda</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_tienda_catalogo.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Editar el Articulo » <?=$ord_articulo?></h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<div>
				<form method="post" enctype="muldiriart/form-data" name="formulario" action="">
					<div class="">
						<h4>Ingrese Caracteristicas del Articulo</h4>
						<label>
							<h5>Nombre del Articulo » </h5>
							<input type="text" name="tit" placeholder="Ejemplo: Pizza Romana" value="<?=$tit_articulo?>">
						</label>						
						<br><br><br>
						<h5 class="text-center"> Categoria del Articulo » </h5>
						<?php
						//Restaurante es para Categoria
						$dato_categoria = "SELECT * FROM categoria";
						$dato_categoria = mysql_db_query($dbname, $dato_categoria); 
						while ($row = mysql_fetch_array($dato_categoria)){ 
							$id_cat = $row["id_categoria"];
							$nom_cat = $row["nom_categoria"];

							$cat=urls_amigables($nom_cat);

							//Categoria
							$exist_art_cat = "SELECT COUNT(id_categoria) FROM articulo_categoria WHERE id_categoria='$id_cat' AND id_articulo='$id_articulo'";
							$exist_art_cat = mysql_db_query($dbname, $exist_art_cat);
							$exist_art_cat = mysql_result($exist_art_cat, 0);

						?>
							<label class="checkbox inline opcion-medio">
								<input type="checkbox" name="<?=$cat?>" <?php if ($exist_art_cat=="1") { ?> checked <?php }?> value="1"><?=$nom_cat?>
							</label>

						<?php
							$exist_art_cat = 0;						
						}
						?>
						<br><br><br>
						<h5 class="text-center"> El Articulo es para la Ocasion » </h5>
						<?php
						//Restaurante es para la ocasion
						$dato_ocasion = "SELECT * FROM ocasion";
						$dato_ocasion = mysql_db_query($dbname, $dato_ocasion); 
						while ($row = mysql_fetch_array($dato_ocasion)){ 
							$id_oca = $row["id_ocasion"];
							$nom_oca = $row["nom_ocasion"];

							$oca=urls_amigables($nom_oca);

							//es para la Ocasion
							$exist_art_oca = "SELECT COUNT(id_ocasion) FROM articulo_ocasion WHERE id_ocasion='$id_oca' AND id_articulo='$id_articulo'";
							$exist_art_oca = mysql_db_query($dbname, $exist_art_oca);
							$exist_art_oca = mysql_result($exist_art_oca, 0);

						?>
							<label class="checkbox inline opcion-medio">
								<input type="checkbox" name="<?=$oca?>" <?php if ($exist_art_oca=="1") { ?> checked <?php }?> value="1"><?=$nom_oca?>
							</label>

						<?php
							$exist_art_oca = 0;
						}
						?>
						<br><br><br>
						<h5 class="text-center"> El Articulo es Para » </h5>
						<?php
						//Restaurante es Para
						$dato_dirigido = "SELECT * FROM dirigido";
						$dato_dirigido = mysql_db_query($dbname, $dato_dirigido); 
						while ($row = mysql_fetch_array($dato_dirigido)){ 
							$id_diri = $row["id_dirigido"];
							$nom_diri = $row["nom_dirigido"];

							$diri=urls_amigables($nom_diri);

							//Esta dirigido para
							$exist_art_diri = "SELECT COUNT(id_dirigido) FROM articulo_dirigido WHERE id_dirigido='$id_diri' AND id_articulo='$id_articulo'";
							$exist_art_diri = mysql_db_query($dbname, $exist_art_diri);
							$exist_art_diri = mysql_result($exist_art_diri, 0);							

						?>
							<label class="checkbox inline opcion-medio">
								<input type="checkbox" name="<?=$diri?>" <?php if ($exist_art_diri=="1") { ?> checked <?php }?> value="1"><?=$nom_diri?>
							</label>

						<?php
							$exist_art_diri = 0;						
						}
						?>
						<br><br><br>
						<label>
							<h5>Descripcion »</h5>
							<textarea class="ckeditor span5" name="des" placeholder=""><?=$des_articulo?></textarea>
						</label>
						<br>
						<label>
							<h5>Caracteristicas del Articulo »</h5>
							<textarea class="ckeditor span5" name="car" placeholder=""><?=$car_articulo?></textarea>
						</label>
						<br>

						<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>