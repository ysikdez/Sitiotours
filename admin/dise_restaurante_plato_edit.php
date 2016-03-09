<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$error = $_GET['error'];
$id_plato = $_GET['id_plato'];



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

//Datos de la restaurante
$datos_restaurante = "SELECT * FROM restaurante WHERE id_pagina='$ids'";
$datos_restaurante = mysql_db_query($dbname, $datos_restaurante); 
if ($row = mysql_fetch_array($datos_restaurante)){ 
	$id_restaurante = $row["id_restaurante"]; 
	$ord_restaurante = $row["ord_restaurante"]; 
}

//Datos del Plato
$datos_plato = "SELECT * FROM plato WHERE id_plato='$id_plato'";
$datos_plato = mysql_db_query($dbname, $datos_plato); 
if ($row = mysql_fetch_array($datos_plato)){ 

	$ord_plato = $row["ord_plato"]; 
	$nom_plato = $row["nom_plato"]; 
	$des_plato = $row["des_plato"]; 
	$ing_plato = $row["ing_plato"]; 
	$ela_plato = $row["ela_plato"]; 
}


if (!$_POST) {
	
} else {

	$nom = $_POST["nom"]; 
	$des = $_POST["des"]; 
	$ing = $_POST["ing"]; 
	$ela = $_POST["ela"]; 	

	$editar_plato = "UPDATE plato SET 

						nom_plato = '$nom',
						des_plato = '$des',
						ing_plato = '$ing',
						ela_plato = '$ela' 

						WHERE id_plato='$id_plato'";

	$db_editar_plato = mysql_db_query($dbname, $editar_plato);

	header("location: dise_restaurante_plato_edit.php?id=$ids&id_plato=$id_plato&error=$error");
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
		<title>Editar Plato del Restaurante</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_restaurante_menu.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<h3>Editar de Habitacion » <?=$ord_plato?></h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<div>
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
					<div class=" text-center">
						<h4>Ingrese Caracteristicas de la Habitacion</h4>
						<label>
							<h5>Nombre de la Habitacion » </h5>
							<input type="text" name="nom" placeholder="Ejemplo: Pizza Romana" value="<?=$nom_plato?>">
						</label>						
						<br>
						<label>
							<h5>Descripcion »</h5>
							<textarea class="ckeditor span5" name="des" placeholder=""><?=$des_plato?></textarea>
						</label>
						<br>
						<label>
							<h5>Ingredientes »</h5>
							<textarea class="ckeditor span5" name="ing" placeholder=""><?=$ing_plato?></textarea>
						</label>
						<br>
						<label>
							<h5>Elaboracion »</h5>
							<textarea class="ckeditor span5" name="ela" placeholder=""><?=$ela_plato?></textarea>
						</label>
						<br>

						<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>