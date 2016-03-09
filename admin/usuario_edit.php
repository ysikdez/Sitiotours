<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$id = $_GET["id"];

$dato_usuario = "SELECT * FROM usuario WHERE id_usuario=$id";
$dato_usuario = mysql_db_query($dbname, $dato_usuario); 
if ($row = mysql_fetch_array($dato_usuario)){ 

	$cod_usuario = $row["cod_usuario"];
	$nick_usuario = $row["nick_usuario"];
	$ape_usuario = $row["ape_usuario"];
	$nom_usuario = $row["nom_usuario"];
	$pass_usuario = $row["pass_usuario"];
	$niv_usuario = $row["niv_usuario"];
}

if (!$_POST) {
	
} else {

	$nick = $_POST["nick"];
	$ape = $_POST["ape"];
	$nom = $_POST["nom"];
	$mail = $_POST["mail"];
	$pass = $_POST["pass"];
	$niv = $_POST["niv"];

	$n_usuario = "SELECT COUNT(id_usuario) FROM usuario";
	$total_usuario = mysql_db_query($dbname, $n_usuario);
	$total_usuario = mysql_result($total_usuario, 0);
	$sig_usuario=$total_usuario;

	$apellido=strtoupper(urls_amigables($ape));//
	$nombre=strtoupper(urls_amigables($nom));//

	$let_ap=str_split($apellido,3);
	$let_no=str_split($nombre,3);
	$apel=$let_ap[0];
	$nomb=$let_no[0];

	$orden=add_ceros($sig_usuario,3);

	$codigo=$apel.$nomb.$orden;	


	 $editar_site = "UPDATE usuario SET
        
            cod_usuario = '$codigo',
            nick_usuario = '$nick',
            ape_usuario = '$ape',         
            nom_usuario = '$nom',
            pass_usuario = '$pass',
            niv_usuario = '$niv'
            
            WHERE id_usuario='$id'";

  $editar_site = mysql_db_query($dbname, $editar_site); 

	

	header("location: usuario_edit.php?id=$id&error=$error");
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
		<title>Afiliado</title>
	</head>
	<body>
		<div class="row contorno text-center">
			<a class="btn btn-sitio pull-right" href="usuario.php"><i class="icon-arrow-left"></i></a>				
			<h3>Editar Afiliado</h3>

			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<div>
					<h4>Caracteristicas del Nuevo Usuario » <?=$cod_usuario?></h4>

					<label>
						<h5>Nick »</h5>
						<input type="text" name="nick" value="<?=$nick_usuario?>">
					</label>
					<label>
						<h5>Apellidos »</h5>
						<input type="text" class="span4" name="ape" value="<?=$ape_usuario?>">
					</label>
					<label>
						<h5>Nombres »</h5>
						<input type="text" class="span4" name="nom" value="<?=$nom_usuario?>">
					</label>
					<label>
						<h5>Password »</h5>
						<input type="text" name="pass" value="<?=$pass_usuario?>">
					</label>
					<label>
						<h5>Nivel »</h5>
						<select name="niv">
							<option value="1" <?php if ("1"==$niv_usuario) { ?> selected <?php } ?>>N1</option>
							<option value="2" <?php if ("2"==$niv_usuario) { ?> selected <?php } ?>>N2</option>
							<option value="3" <?php if ("3"==$niv_usuario) { ?> selected <?php } ?>>N3</option>
							<option value="4" <?php if ("4"==$niv_usuario) { ?> selected <?php } ?>>N4</option>
						</select>
					</label>

					<button class="btn btn-primary btn-sitio">Guardar</button>
				</div>
			</form>
		</div>
	</body>
</html>