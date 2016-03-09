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
	
	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];

}

//Datos de la Pagina Padre ---- Tipo del Destino que lo Agrupa
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }


//Datos de la Pagina Diseño General
$datos_agencia = "SELECT * FROM agencia WHERE id_pagina='$ids'";
$datos_agencia = mysql_db_query($dbname, $datos_agencia); 
if ($row = mysql_fetch_array($datos_agencia)){ 

	$id_agencia = $row["id_agencia"];
	$cod_agencia = $row["cod_agencia"];
	$des_agencia = $row["des_agencia"];
	$open_a_agencia = $row["open_a_agencia"];
	$close_a_agencia = $row["close_a_agencia"];
	$open_b_agencia = $row["open_b_agencia"];
	$close_b_agencia = $row["close_b_agencia"];

}

$fecha = date("Y-m-d H:i:s");	// 2001-03-10 17:16:18

if (!$_POST) {
	
} else {
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
		<title>Editar la Agencia</title>
	</head>
	<body>
<!-- Comentarios facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

		<div class="row contorno">
			<?php
				if ($tit_pos_pag == "Recomendaciones - Tips Turisticos" OR $ids==0) {
				} else {
			?>
				<a class="btn btn-sitio pull-right" href="dise_tic.php?id=<?=$per_pag?>"><i class="icon-arrow-left"></i></a>
			<?php					
				}
			?>
			<br><br>
			<h4 class="pull-right">Codigo : <?=$cod_pag?></h4>
			<h3>Recomendaciones » </h3>						
			<h4>» <?=$tit_pos_pag_pad?></h4>
			<h5>» <?=$tit_pos_pag?></h5>
			<br>
			<hr>
			
<?php

//Datos del comentario
	$pos_pag_pad = "SELECT per_tic FROM tic WHERE id_pagina='$ids' && niv_tic='0' && per_tic='0' && ord_tic='0'";
	$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
	if ($row = mysql_fetch_array($posi_pag_pad)){ $per_tic = $row["per_tic"]; }
		
	ComentariosPagina($dbname,$ids,0);

?>

			<br>

            <div class="span5" id="coment_0">
              <form method="post" enctype="multipart/form-data" name="formulario_0" action="">
                <h5>Nueva Recomendacion - Tic's » <?=$per_tic?></h5>
                <label>
                  <input type="text" name="nick_0" id="nick_0" class="span5" placeholder="Nombre" value="Ysik">
                </label>
                <label>
                  <input type="text" name="mail_0" id="mail_0" class="span5" placeholder="E-mail" value="info@sitiotours.com">
                </label>
                <label>
                  <textarea rows="2" name="des_0" id="des_0" class="span5" placeholder="Comentario"></textarea>
                </label>
                <label class="checkbox inline">
                  <input type="checkbox" name="like_0" id="like_0" value="1"> 
                  Desea que le Enviemos Informacion 
                </label>
                <button class="btn btn-primary btn-sitio pull-right" onclick="Coment('0','<?=$ids?>')">Guardar</button>
              </form>
            </div> 

		</div>
						
			
			<hr>
			<h3>Comentarios » </h3>	
			<?php
				$url_pag_tip = pagUrl($dbname,$ids);$pagurl="";
				$url_pag_tip = substr($url_pag_tip, 0, -1);
			?>
			<!-- Plugin de Comentarios para el FB -->
			<div class="fb-comments" data-href="http://sitiotours.com/<?=$url_pag_tip?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>


	</body>
</html>