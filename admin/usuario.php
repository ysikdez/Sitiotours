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
	$pass = $_POST["pass"];
	$niv = $_POST["niv"];

	$n_user = "SELECT COUNT(id_usuario) FROM usuario";
	$total_user = mysql_db_query($dbname, $n_user);
	$total_user = mysql_result($total_user, 0);
	$sig_user=$total_user+1;

	$apellido=strtoupper(urls_amigables($ape));//
	$nombre=strtoupper(urls_amigables($nom));//

	$let_ap=str_split($apellido,3);
	$let_no=str_split($nombre,3);
	$apel=$let_ap[0];
	$nomb=$let_no[0];

	$orden=add_ceros($sig_user,3);

	$codigo=$apel.$nomb.$orden;	

	$nuevo_usuario = "INSERT INTO usuario (

							cod_usuario,
							nick_usuario,
							ape_usuario,
							nom_usuario,
							pass_usuario,
							niv_usuario

						) VALUES(

							'$codigo',
							'$nick',
							'$ape',
							'$nom',
							'$pass',
							'$niv'

						)";

	$nuevo_usuario = mysql_db_query($dbname, $nuevo_usuario);
	

	header("location: usuario.php?error=$error");
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
		<title>Editar Usuario</title>
	</head>
	<body>
		<div class="row contorno">
			<h3>Usuarios del Sistema Administartivo</h3>
			<p><strong>Codigo  »  Nick  » Usuario</strong></p>
			<?php
				//Datos del Usuario
				$datos_usuario = "SELECT * FROM usuario";
				$datos_usuario = mysql_db_query($dbname, $datos_usuario); 
				while ($row = mysql_fetch_array($datos_usuario)){ 

					$id_usuario = $row["id_usuario"];
					$cod_usuario = $row["cod_usuario"];
					$nick_usuario = $row["nick_usuario"];
					$ape_usuario = $row["ape_usuario"];
					$nom_usuario = $row["nom_usuario"];
					$pass_usuario = $row["pass_usuario"];
					$niv_usuario = $row["niv_usuario"];
			?>
				<div class="destino-caja">
					<a href="usuario_eli.php?id=<?=$id_usuario?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR?")'>
						<div class="pull-right icono"><i class="icon-remove"></i></div>
					</a>
					<a href="usuario_edit.php?id=<?=$id_usuario?>">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
					</a>
					<?=$cod_usuario?> » <?=$nick_usuario?> » <?=$ape_usuario?> <?=$nom_usuario?>
				</div>
			<?php
				}
			?>

			<br>
			<a data-toggle="modal" class="btn btn-sitio pull-right" href="#usuario"><i class="icon-plus"></i></a>

			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<div id="usuario" class="modal hide fade" tabindex="1" role="dialog" aria-labelledby="new" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="new">Nuevo Usuario » Nº <?=$sig_user?> </h3>
					</div>

					<div class="modal-body text-center">
			
						<h4>Caracteristicas del Nuevo Usuario» </h4>

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
							<h5>Password »</h5>
							<input type="text" name="pass">
						</label>
						<label>
							<h5>Nivel »</h5>
							<select name="niv">
								<option value="1" <?php if ("1"==$niv) { ?> selected <?php } ?>>N1</option>
								<option value="2" <?php if ("2"==$niv) { ?> selected <?php } ?>>N2</option>
								<option value="3" <?php if ("3"==$niv) { ?> selected <?php } ?>>N3</option>
								<option value="4" <?php if ("4"==$niv) { ?> selected <?php } ?>>N4</option>
							</select>
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