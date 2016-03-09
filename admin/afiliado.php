<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");


if (!$_POST) {
	
} else {

	$nick = $_POST["nick"];
	$ape = $_POST["ape"];
	$nom = $_POST["nom"];
	$mail = $_POST["mail"];
	$id_pagina = $_POST["id_pagina"];

	$n_afiliado = "SELECT COUNT(id_afiliado) FROM afiliado";
	$total_afiliado = mysql_db_query($dbname, $n_afiliado);
	$total_afiliado = mysql_result($total_afiliado, 0);
	$sig_afiliado=$total_afiliado+1;

	$apellido=strtoupper(urls_amigables($ape));//
	$nombre=strtoupper(urls_amigables($nom));//

	$let_ap=str_split($apellido,3);
	$let_no=str_split($nombre,3);
	$apel=$let_ap[0];
	$nomb=$let_no[0];

	$orden=add_ceros($sig_afiliado,3);

	$codigo=$apel.$nomb.$orden;	

	$nuevo_afiliado = "INSERT INTO afiliado (

							cod_afiliado,
							nick_afiliado,
							ape_afiliado,
							nom_afiliado,
							mail_afiliado,
							id_pagina

						) VALUES(

							'$codigo',
							'$nick',
							'$ape',
							'$nom',
							'$mail',
							'$id_pagina'

						)";

	$nuevo_afiliado = mysql_db_query($dbname, $nuevo_afiliado);
	

	header("location: afiliado.php?error=$error");
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
		<title>Afiliados</title>
	</head>
	<body>
		<div class="row contorno">
			<h3>Afiliados</h3>
			<p><strong>Codigo  »  Nick  » Afiliado</strong></p>
			<?php
				//Datos del Usuario
				$datos_afiliado = "SELECT * FROM afiliado";
				$datos_afiliado = mysql_db_query($dbname, $datos_afiliado); 
				while ($row = mysql_fetch_array($datos_afiliado)){ 

					$id_afiliado = $row["id_afiliado"];
					$cod_afiliado = $row["cod_afiliado"];
					$nick_afiliado = $row["nick_afiliado"];
					$ape_afiliado = $row["ape_afiliado"];
					$nom_afiliado = $row["nom_afiliado"];
					$mail_afiliado = $row["mail_afiliado"];
					$id_pagina = $row["id_pagina"];
			?>
				<div class="destino-caja">
					<a href="afiliado_eli.php?id=<?=$id_afiliado?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR?")'>
						<div class="pull-right icono"><i class="icon-remove"></i></div>
					</a>
					<a href="afiliado_edit.php?id=<?=$id_afiliado?>">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
					</a>
					<?=$cod_afiliado?> » <?=$nick_afiliado?> » <?=$ape_afiliado?> <?=$nom_afiliado?>
				</div>
			<?php
				}
			?>

			<br>
			<a data-toggle="modal" class="btn btn-sitio pull-right" href="#afiliado"><i class="icon-plus"></i></a>

			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<div id="afiliado" class="modal hide fade" tabindex="1" role="dialog" aria-labelledby="new" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="new">Nuevo Afiliado » Nº <?=$sig_afiliado?> </h3>
					</div>

					<div class="modal-body text-center">
			
						<h4>Caracteristicas del Nuevo Afiliado» </h4>

						<label>
							<h5>Nick »</h5>
							<input type="text" name="nick">
						</label>
						<label>
							<h5>Apellidos »</h5>
							<input type="text" class="span4" name="ape">
						</label>
						<label>
							<h5>Nombres »</h5>
							<input type="text" class="span4" name="nom">
						</label>
						<label>
							<h5>Email »</h5>
							<input type="text" name="mail">
						</label>
					</div>

					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
						<button class="btn btn-primary btn-sitio">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>