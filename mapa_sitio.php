<?php
include ("admin/config.php");
include ("admin/functions.php");

// $_SESSION['URL'] = "http://".$SERVER_NAME.$PHP_SELF."?".$QUERY_STRING; 
session_start();
if(isset($_SESSION['carro'])){$carro=$_SESSION['carro'];}else{ $carro=false; }


//Pagina
$id = $_GET["id"];

$dato_pagina = "SELECT * FROM pagina WHERE id_pagina='$id'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ 

	$id_idioma = $row["id_idioma"];
	$per = $row["per_pagina"];

	$des = $row["des_pagina"];
	$key = $row["key_pagina"];
	$tit = $row["tit_pagina"];
	$url = $row["url_pagina"];

	$map = $row["map_pagina"];

	$tit_pos = $row["tit_pos_pagina"];
	$tit_com = $row["tit_com_pagina"];

	$logo = $row["logo_pagina"];
	$alt_logo = $row["alt_logo_pagina"];
	$des_logo = $row["des_logo_pagina"];
}

//Padre
$dato_padre = "SELECT * FROM pagina WHERE id_pagina='$per'";
$dato_padre = mysql_db_query($dbname, $dato_padre); 
if ($row = mysql_fetch_array($dato_padre)){ 

	$id_pad = $row["id_pagina"];
	$per_pad = $row["per_pagina"];
	$url_pad = $row["url_pagina"];
	$tit_pos_pad = $row["tit_pos_pagina"];
	$ico_pag_pad = $row["ico_pagina"];

}

//Configuracion
$dato_config = "SELECT * FROM site WHERE id_site='1'";
$dato_config = mysql_db_query($dbname, $dato_config); 
if ($row = mysql_fetch_array($dato_config)){ 

	$url_site = $row["url_site"];
	$mail_site = $row["mail_site"];
	$auto_site = $row["auto_site"];
	$copy_site = $row["copy_site"];

}

//idioma
$dato_pagina = "SELECT * FROM idioma WHERE id_idioma='$id_idioma'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ $abre = $row["abre_idioma"];}

?>
<!DOCTYPE html>
<html lang="<?=$abre?>">
	<head>
		<base href="<?=$url_site?>" />
		<meta charset="utf-8">
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="<?=$auto_site?>" />
		<meta name="copyright" content="<?=$copy_site?>" />
		<!-- Descripción: entre 155 a 160 caracteres -->
		<meta name="description" content="<?=$des?>" />
		<meta name="distribution" content="Global" />
		<meta name="google-site-verification" content="" /> <!-- -------- -->
		<!-- Keywords: entre 300 caracteres -->
		<meta name="keywords" content="<?=$key?>" />
		<meta name="MSSmartTagsPreventParsing" content="TRUE" />
		<meta name="owner" content="<?=$auto_site?>" />
		<meta name="rating" content="General" />
		<meta name="reply-to" content="<?=$mail_site?>" />
		<meta name="revisit-After" content="1 days" />
		<meta name="robots" content="all" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="img/ico-sitiotours.png" rel="shortcut icon">
		
		<script src="js/script.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title><?=$tit?> :: Sitiotours.com </title>
	</head>

	<body>
		<?php
			include ("header.php");
		?>

		<section class="container marketing top-margen">
			<div class="row">
				<div class="span8">

					<article class="span8">

						<h1 class="text-left"><?=$tit_pos?> » </h1>
						<h2 class="text-left"><?=$tit_com?></h2>
						<br>
						<?php

							for ($i=0; $i <= 1 ; $i++) {
							MapaSitio($dbname,1,$i);
							}

						?>



					</article>

					<article class="span8">
						<hr class="featurette-divider">
						<h4>Contacto</h4>
						<?php 
								$url_pag_imprimir = pagUrl($dbname,$id);$pagurl="";
								$url_pag_imprimir = substr($url_pag_imprimir, 0, -1);

						?>
							<h3>
								<a href="<?=$url_pag_imprimir?>/imprimir" target="_blank" rel="nofollow"><i class="icon-imprimir ico-contacto"></i></a>
								<a data-toggle="collapse" data-target="#mensaje"><i class="icon-mail ico-mensaje ico-contacto"></i></a> 
								<a href="<?=$url_pag_imprimir?>" class=""><i class="icon-favorito ico-contacto"></i></a> 
							</h3>
							<div id="mensaje" class="collapse text-left">
								<div id="consulta">
									<form method="get" enctype="multipart/form-data" name="consulta">
										<input name="pag" type="hidden" value="<?=$id?>">
										<fieldset>
											<h4>Consulta :</h4>
											<input name="mail" type="email" class="span7" placeholder="E-mail" required title="Necesitamos su e-mail">
											<textarea name="mensaje" type="text" rows="3" class="span7" placeholder="¿Cual es su Consulta?" required title="Necesitamos su Consulta"></textarea>
											<a class="btn btn-filtro span6 text-center" onclick="Consulta()">Enviar</a>
										</fieldset>
									</form>
								</div>
							</div>
						
						<?php

							//Contacto
							$dato_contacto = "SELECT * FROM contacto WHERE id_pagina='$id' AND ord_contacto='1'";
							$dato_contacto = mysql_db_query($dbname, $dato_contacto); 
							if ($row = mysql_fetch_array($dato_contacto)){ $id_contacto = $row["id_contacto"]; }

							//Info del Contacto
							$dato_pagina = "SELECT * FROM info WHERE id_contacto='$id_contacto' AND vis_info='1' ORDER BY ord_info";
							$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
							while ($row = mysql_fetch_array($dato_pagina)){ 

								$tipo = $row["tipo_info"]; 
								$dato = $row["dato_info"]; 
						
								switch ($tipo) {
									case 'Dirección':
										?>
										<strong><spam class="ico-twitter">Dirección:</spam></strong><?=$dato?>
										<?php
										break;
									case 'E-mail':
										?>
										<a href="mailto:<?=$dato?>" itemprop="url"><i class="icon-mail ico-mail"></i></a>
										<?php
										break;
									case 'Facebook':
										?>
										<a href="<?=$dato?>" itemprop="url"><i class="icon-facebook ico-facebook"></i></a>
										<?php
										# code...
										break;
									case 'Google+':
										?>
										<a href="<?=$dato?>" itemprop="url"><i class="icon-google ico-google"></i></a>
										<?php
										break;
									case 'Instagram':
										?>
										<a href="<?=$dato?>" itemprop="url"><i class="icon-instagram ico-instagram"></i></a>
										<?php
										break;
									case 'Sitio Web':
										?>
										<a href="<?=$dato?>" itemprop="url"><spam class="ico-twitter">Web</spam></a>
										<?php
										break;
									case 'Skype':
										?>
										<a href="skype:<?=$dato?>?call" itemprop="url"><i class="icon-skype ico-skype"></i></a>
										<?php
										break;
									case 'Telefono':
										?>
										<strong>Fono:</strong><?=$dato?>
										<?php
										break;
									case 'Twitter':
										?>
										<a href="<?=$dato?>" itemprop="url"><i class="icon-twitter ico-twitter"></i></a>
										<?php
										break;
									case 'Youtube':
										?>
										<a href="<?=$dato?>" itemprop="url"><i class="icon-youtube ico-youtube"></i></a>
										<?php
										break;
								}
							}
						?>
					</article>
				</div>

				<?php
					include ("filtro.php");
					include ("comentario.php");
				?>
			</div>
		</section>		

				<?php
					include ("footer.php");
				?>


	</body>
</html>


