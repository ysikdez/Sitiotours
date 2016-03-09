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
	
	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];

}

//Datos de la Pagina Padre ---- 
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }

//Datos de la tienda
$dato_tienda = "SELECT * FROM tienda WHERE id_pagina='$ids'";
$dato_tienda = mysql_db_query($dbname, $dato_tienda); 
if ($row = mysql_fetch_array($dato_tienda)){ $id_tienda = $row["id_tienda"]; }

//Numero de Articulo y Nuevo Articulo
$numero_articulos = "SELECT COUNT(ord_articulo) FROM articulo WHERE id_tienda='$id_tienda'";
$numero_articulos = mysql_db_query($dbname, $numero_articulos);
$numero_articulos = mysql_result($numero_articulos, 0);
$new_articulo = $numero_articulos +1;



if (!$_POST) {
	
} else {

	$tit = $_POST["tit"];
	$des = $_POST["des"];
	$car = $_POST["car"];

	$agregar_articulo = "INSERT INTO articulo (

								id_tienda,
								ord_articulo,
								tit_articulo,
								des_articulo,
								car_articulo
								
								) VALUES (

								'$id_tienda',
								'$new_articulo',
								'$tit',
								'$des',
								'$car'

								)";	

	$cab_agregar_articulo = mysql_db_query($dbname, $agregar_articulo);	

	//Datos del Nuevo Articulo
	$dato_new_art= "SELECT * FROM articulo WHERE id_tienda='$id_tienda' AND ord_articulo='$new_articulo' AND tit_articulo='$tit'";
	$dato_new_art = mysql_db_query($dbname, $dato_new_art); 
	if ($row = mysql_fetch_array($dato_new_art)){ $id_new_art = $row["id_articulo"]; }

	//Articulo para categoriaes
	$dato_art_cat = "SELECT * FROM categoria";
	$dato_art_cat = mysql_db_query($dbname, $dato_art_cat); 
	while ($row = mysql_fetch_array($dato_art_cat)){ 

		$id_cat = $row["id_categoria"];
		$nom_categoria = $row["nom_categoria"];
		$ser_pos=urls_amigables($nom_categoria);
		$categoria=$_POST[$ser_pos];

		//Se incluye la categoria
		$existe_categoria = "SELECT COUNT(id_categoria) FROM articulo_categoria WHERE id_categoria='$id_cat' AND id_articulo='$id_new_art'";
		$existe_categoria = mysql_db_query($dbname, $existe_categoria);
		$existe_categoria = mysql_result($existe_categoria, 0);

		if ($existe_categoria==1) {
			if ($categoria!=1) {
				$eliminar_art_cat = "DELETE FROM articulo_categoria WHERE id_categoria='$id_cat' AND id_articulo='$id_new_art'";
				$result = mysql_db_query($dbname, $eliminar_art_cat);	
			} 
			
		} else {
			if ($categoria==1) {
				$ingresar_art_cat = "INSERT INTO articulo_categoria (id_categoria,id_articulo) VALUES ('$id_cat','$id_new_art')";
				$cab_ingresar_art_cat = mysql_db_query($dbname, $ingresar_art_cat);	
			}
			
		}

	}

	//Categoria Ocas
	$dato_art_oca = "SELECT * FROM ocasion";
	$dato_art_oca = mysql_db_query($dbname, $dato_art_oca); 
	while ($row = mysql_fetch_array($dato_art_oca)){ 

		$id_oca = $row["id_ocasion"];
		$nom_ocasion = $row["nom_ocasion"];
		$ser_pos=urls_amigables($nom_ocasion);
		$ocasion=$_POST[$ser_pos];

		//Se incluye la Ocasion
		$existe_ocasion = "SELECT COUNT(id_ocasion) FROM articulo_ocasion WHERE id_ocasion='$id_oca' AND id_articulo='$id_new_art'";
		$existe_ocasion = mysql_db_query($dbname, $existe_ocasion);
		$existe_ocasion = mysql_result($existe_ocasion, 0);

		if ($existe_ocasion==1) {
			if ($ocasion!=1) {
				$eliminar_art_oca = "DELETE FROM articulo_ocasion WHERE id_ocasion='$id_oca' AND id_articulo='$id_new_art'";
				$result = mysql_db_query($dbname, $eliminar_art_oca);	
			} 
			
		} else {
			if ($ocasion==1) {
				$ingresar_art_oca = "INSERT INTO articulo_ocasion (id_ocasion,id_articulo) VALUES ('$id_oca','$id_new_art')";
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
		$existe_dirigido = "SELECT COUNT(id_dirigido) FROM articulo_dirigido WHERE id_dirigido='$id_diri' AND id_articulo='$id_new_art'";
		$existe_dirigido = mysql_db_query($dbname, $existe_dirigido);
		$existe_dirigido = mysql_result($existe_dirigido, 0);

		if ($existe_dirigido==1) {
			if ($dirigido!=1) {
				$eliminar_art_dir = "DELETE FROM articulo_dirigido WHERE id_dirigido='$id_diri' AND id_articulo='$id_new_art'";
				$result = mysql_db_query($dbname, $eliminar_art_dir);	
			} 
			
		} else {
			if ($dirigido==1) {
				$ingresar_art_dir = "INSERT INTO articulo_dirigido (id_dirigido,id_articulo) VALUES ('$id_diri','$id_new_art')";
				$cab_ingresar_art_dir = mysql_db_query($dbname, $ingresar_art_dir);	
			}
			
		}

	}


	header("lcattion: dise_tienda_catalogo.php?id=$ids&error=$error");
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
		<title>Articulo de la Tienda </title>
	</head>
	<body onload="imaPrincipal();">
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_tienda.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Menu del Articulo » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<hr>
			<h5>Catalogo »</h5>
			<div class="accordion text-justify">
<?php

//Datos de las Articulo
$datos_articulos = "SELECT * FROM articulo WHERE id_tienda='$id_tienda' ORDER BY ord_articulo";
$datos_articulos = mysql_db_query($dbname, $datos_articulos); 
while ($row = mysql_fetch_array($datos_articulos)){ 

	$id_art= $row["id_articulo"];
	$ord_art = $row["ord_articulo"];
	$tit_art = $row["tit_articulo"];

	$numero_pre_art = "SELECT COUNT(ord_aprecio) FROM aprecio WHERE id_articulo='$id_art'";
	$numero_pre_art = mysql_db_query($dbname, $numero_pre_art);
	$numero_pre_art = mysql_result($numero_pre_art, 0);
	$new_pre_art = $numero_pre_art + 1;
?>
				<div class="accordion-group">
					<div class="accordion-titulo itinerario">
						<p class="numero"><strong><?=$ord_art?></strong></p>
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#ord_art<?=$ord_art?>"><strong> <?=$tit_art?></strong></a>
												

						<a href="dise_tienda_articulo_eli.php?id=<?=$ids?>&id_articulo=<?=$id_art?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
						
						<?php if($ord_art!=$numero_articulos) { ?>
						<a href="dise_tienda_articulo_ord.php?id=<?=$ids?>&id_articulo=<?=$id_art?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<?php if($ord_art!=1) { ?>
						<a href="dise_tienda_articulo_ord.php?id=<?=$ids?>&id_articulo=<?=$id_art?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

						<a href="dise_tienda_articulo_edit.php?id=<?=$ids?>&id_articulo=<?=$id_art?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
						<a href="dise_tienda_articulo_precio.php?id=<?=$ids?>&id_articulo=<?=$id_art?>&new_precio=<?=$new_pre_art?>"><h4 class="pull-right icono">$</h4></a>

					</div>
					<div id="ord_art<?=$ord_art?>" class="accordion-body collapse">
						<div class="accordion-inner">

	<?php

	//Datos de las precios
	$datos_pre_articulo = "SELECT * FROM aprecio WHERE id_articulo='$id_art' ORDER BY ord_aprecio";
	$datos_pre_articulo = mysql_db_query($dbname, $datos_pre_articulo); 
	while ($row = mysql_fetch_array($datos_pre_articulo)){ 

		$id_aprecio = $row["id_aprecio"];
		$ord_aprecio = $row["ord_aprecio"];
		$uni_aprecio = $row["uni_aprecio"];
		$val_aprecio = $row["val_aprecio"];
		$fin_aprecio = $row["fin_aprecio"];
	?>
							<div class="destino-caja">
								<p class="numero"><strong><?=$ord_aprecio?></strong></p> →
								<p class="precio"><small><strong><?=$uni_aprecio?></strong></small></p>
								<p class="numero">×</p>
								<p class="precio"><small><?=$val_aprecio?></small></p>
								<p class="numero"><small><small><strong>USD</strong></small></small></p>
								<p class="precio"><small><small><strong>Hasta »</strong></small></small></p>
								<p class="precio"><small><small><?=$fin_aprecio?></small></small></p>
								
								<a href="dise_tienda_articulo_precio_eli.php?id=<?=$ids?>&id_aprecio=<?=$id_aprecio?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA DETALLE DE LA PAGINA?")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
								<?php if($ord_aprecio!=$numero_pre_art) { ?>
								<a href="dise_tienda_articulo_precio_ord.php?id=<?=$ids?>&id_aprecio=<?=$id_aprecio?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<?php if($ord_aprecio!=1) { ?>
								<a href="dise_tienda_articulo_precio_ord.php?id=<?=$ids?>&id_aprecio=<?=$id_aprecio?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
								<?php } else { ?>
								<div class="pull-right icono"><i class="esp-ico"></i></div>
								<?php } ?>

								<a href="dise_tienda_articulo_precio_edit.php?id=<?=$ids?>&id_articulo=<?=$id_art?>&id_aprecio=<?=$id_aprecio?>"><div class="pull-right icono"><i class="icon-edit"></i></div></a>
							</div>
	<?php
	}
	?>

						</div>
					</div>
				</div>
<?php
}
?>
			</div>
			<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevoprecio"><i class="icon-plus"></i></a>
			<br>
			<hr>
			<div id="nuevoprecio" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="precio" aria-hidden="true">
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="precio">Nuevo Articulo » <?=$new_articulo?></h3>
					</div>
					<div class="modal-body">
						<h4 class="text-center">Ingrese Caracteristicas del Articulo</h4>
						<br>
						<label class="text-center">
							<h5>Nombre del Articulo » </h5>
							<input type="text" name="tit" placeholder="Nombre">
						</label>
						<br><br>
						<h5 class="text-center"> Categoria del Articulo » </h5>
						<?php
						//Restaurante es para Categoria
						$dato_categoria = "SELECT * FROM categoria";
						$dato_categoria = mysql_db_query($dbname, $dato_categoria); 
						while ($row = mysql_fetch_array($dato_categoria)){ 
							$id_cat = $row["id_categoria"];
							$nom_cat = $row["nom_categoria"];

							$cat=urls_amigables($nom_cat);

						?>
							<label class="checkbox inline opcion-medio">
								<input type="checkbox" name="<?=$cat?>" value="1"><?=$nom_cat?>
							</label>

						<?php
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

						?>
							<label class="checkbox inline opcion-medio">
								<input type="checkbox" name="<?=$oca?>" value="1"><?=$nom_oca?>
							</label>

						<?php
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

						?>
							<label class="checkbox inline opcion-medio">
								<input type="checkbox" name="<?=$diri?>" value="1"><?=$nom_diri?>
							</label>

						<?php
						}
						?>
						<br><br><br>
						<label>
							<h5>Descripcion del Articulo »</h5>
							<textarea class="ckeditor span5" name="des" placeholder="Descripcion del Articulo"></textarea>
						</label>
						<br>
						<label>
							<h5>Caracteristica del Articulo »</h5>
							<textarea class="ckeditor span5" name="car" placeholder="Caracteristica del Articulo"></textarea>
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