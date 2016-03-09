<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$error = $_GET['error'];

//Datos de la Pagina
$pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$p_pag = mysql_db_query($dbname, $pag); 
if ($row = mysql_fetch_array($p_pag)){ 

	$ord_pag = $row["ord_pagina"];
	$niv_pag = $row["niv_pagina"];
	$per_pag = $row["per_pagina"];
	$id_idi = $row["id_idioma"];
	$tit_pos_pag = $row["tit_pos_pagina"];
	$ima_def_pag = $row["ima_def_pagina"];

}


if ($ima_def_pag == 1) {
	$letrero = "Inicio";
} else {
	//Nombre del letrero
	$colec_pag = "SELECT * FROM coleccion WHERE id_pagina='$ids'";
	$coleccion_pag = mysql_db_query($dbname, $colec_pag); 
	if ($row = mysql_fetch_array($coleccion_pag)){ 

		$id_letrero_ima_prin = $row["id_letrero_ima_prin"];
		$letre_pag = "SELECT * FROM letrero_ima_prin WHERE id_letrero_ima_prin='$id_letrero_ima_prin'";
		$letre_pag = mysql_db_query($dbname, $letre_pag); 
		if ($row = mysql_fetch_array($letre_pag)){ 
			$letrero = $row["tip_letrero_ima_prin"];
		}
	}
}


if (!$_POST) {
	
} else {

	$tip_coleccion=$_POST["tip_coleccion"];

	if ($tip_coleccion!="Nueva Coleccion" || $ima_def_pag!="1") {

		if ($tip_coleccion!=$letrero) {
	
			//Nombre de la pagina seleccionada
			$n_tip = "SELECT COUNT(id_pagina) FROM coleccion WHERE id_pagina='$ids'";
			$n_tipo = mysql_db_query($dbname, $n_tip);
			$n_tipo = mysql_result($n_tipo, 0);

			$pos_pag = "SELECT * FROM letrero_ima_prin WHERE tip_letrero_ima_prin = '$tip_coleccion'";
			$posi_pag = mysql_db_query($dbname, $pos_pag); 
			if ($row = mysql_fetch_array($posi_pag)){ $id_letrero = $row["id_letrero_ima_prin"];}
			
			if ($n_tipo == 0) {

				$ima_prin = "INSERT INTO coleccion (id_pagina,id_letrero_ima_prin) VALUES ('$ids','$id_letrero')";
				$cab_ima_prin = mysql_db_query($dbname, $ima_prin);
				
				$editar_pagina = "UPDATE pagina SET	ima_def_pagina = '0' WHERE id_pagina='$ids'";
				$cab_editar_pagina = mysql_db_query($dbname, $editar_pagina);

			} else {

				$ima_prin = "UPDATE coleccion SET id_letrero_ima_prin = '$id_letrero' WHERE id_pagina='$ids'";
				$cab_ima_prin = mysql_db_query($dbname, $ima_prin);

				$editar_pagina = "UPDATE pagina SET	ima_def_pagina = '0' WHERE id_pagina='$ids'";
				$cab_editar_pagina = mysql_db_query($dbname, $editar_pagina);
		
			}		
		}	
	}
	header("location: imagen_prin.php?id=$ids&error=$error");
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
		<title>Imagenes Principales</title>
	</head>
<?php
	//Titulo de la Pagina
	$let_pag = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$ids'";
	$posi_pag = mysql_db_query($dbname, $let_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 

		$tit_pos_pagina = $row["tit_pos_pagina"];
	}
?>
	<body onload="tipoIma(<?=$ids?>);cuentaDescripcion();">
		<div class="row contorno">
			<div class="text-center">
				<a class="btn btn-sitio pull-right" href="paginas_edit.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
				<br>
				<h3><?=$tit_pos_pagina?> » Imagenes principales </h3>
				<form method="post" enctype="multipart/form-data" name="formulario" action="">
	
					<select name="tip_coleccion" OnChange="tipoIma(<?=$ids?>)">
						<option value="Nueva Coleccion">Nueva Coleccion</option>
<?php
	//Nombre del Letrero de la imagenes Principales
	$let_pag = "SELECT DISTINCT tip_letrero_ima_prin FROM letrero_ima_prin ORDER BY tip_letrero_ima_prin";
	$posi_pag = mysql_db_query($dbname, $let_pag); 
	while ($row = mysql_fetch_array($posi_pag)){ 

		$nom_letrero = $row["tip_letrero_ima_prin"];

?>
						<option value="<?=$nom_letrero?>" <?php if ($letrero==$nom_letrero) { ?> selected <?php }?>><?=$nom_letrero?></option>
<?php
	}
?>
					</select>

					<br>
					<button class="btn btn-sitio block" id="guardar">Guardar</button>
				</form>

				<div id="coleccion"></div>
			</div>
		</div>
	</body>
</html>
