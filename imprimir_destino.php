<?php
include ("admin/config.php");
include ("admin/functions.php");

// $_SESSION['URL'] = "http://".$SERVER_NAME.$PHP_SELF."?".$QUERY_STRING; 
session_start();
if(isset($_SESSION['carro'])){$carro=$_SESSION['carro'];}else{ $carro=false; }


//Pagina
$id = $_GET["id"];

$dato_pagina = "SELECT * FROM (pagina LEFT JOIN destino ON pagina.id_pagina = destino.id_pagina) WHERE pagina.id_pagina='$id'";
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

//destino

	$id_destino = $row["id_destino"];
	$cod_destino = $row["cod_destino"];
	$lat_destino = $row["lat_destino"];
	$lon_destino = $row["lon_destino"];
	$des_destino = $row["des_destino"];
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
		<link href="css/imprimir.css" rel="stylesheet">
		<link href="img/ico-sitiotours.png" rel="shortcut icon">
		
		<script src="js/script.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title><?=$tit?> :: Imprimir :: Sitiotours.com </title>
	</head>

	<body  onLoad="window.print()">
		<section class="container marketing margen-top">
			<div class="row text-center">	
				<a class="brand margen-top" href="#">
					<div itemscope itemtype="http://schema.org/ImageObject">
						<figure>
							<img src="img/sitio-logo.png" itemprop="contentURL" alt="Logo Sitiotours.com" width="100" height="58">
						</figure>
						<meta itemprop="datePublished" content="2014-07-06">
						<figcaption itemprop="name" class="text-center">sitiotours.com</figcaption>
					</div>
				</a>
				<br>
				<article class="text-center margin-top">

					<div>
						<h1 class="inline-block pull-left"><small><i class="icon-destino ico-titulo"></i> </small> </h1>	
						<h1 class="inline-block pull-left"> <small>Destinos » </small></h1>
						<br><br>
						<?php

							$ids_dest=pagPadreDestino($dbname,$id);
							$ids_dest = substr($ids_dest, 0, -1);

							$des='';
							$des_pad = "SELECT * FROM pagina WHERE id_pagina IN ($ids_dest)";
							$des_pad = mysql_db_query($dbname, $des_pad); 
							while ($row = mysql_fetch_array($des_pad)){ 

								$per_des = $row["per_pagina"];
								$tit_des = $row["tit_pos_pagina"];
								$des=$des.$tit_des." » ";

								?>
									<div class="inline-block pull-left text-left titulo"><h1><small><?=$tit_des?> »</small/></h1></div>
								<?php

							} 
							$pad_id='';

						?>
					</div><br><br><br>
					<h1 class="text-left"><small><?=$tit_pos?> </small></h1>
					<h2 class="text-left"><small><?=$tit_com?> </small></h2>
					<br>
					<h4 class="text-left">Descripcion :</h4>
					<p class="text-justify"><?=$des_destino?></p>
					<br>
				</article>
				<hr class="span9">
				<article>
					<div class="text-center">

							<?php
							//Datos de la Galeria de Imagen
							$datos_galeria_imagen = "SELECT *
														FROM
														((galeria LEFT JOIN galeria_imagen ON galeria.id_galeria = galeria_imagen.id_galeria)
														LEFT JOIN imagen ON imagen.id_imagen = galeria_imagen.id_imagen)
														WHERE galeria.id_pagina='$id'AND tipo_galeria='Fotografica'
														ORDER BY ord_galeria_imagen";

							$datos_galeria_imagen = mysql_db_query($dbname, $datos_galeria_imagen); 
							while ($row = mysql_fetch_array($datos_galeria_imagen)){ 

								$id_ima_galeria = $row["id_imagen"];
								$ord_gal_imagen = $row["ord_galeria_imagen"];
								
								$arch_gal_imagen = $row["arch_imagen"];	
								$tit_gal_imagen = $row["tit_imagen"];	
								$lug_gal_imagen = $row["lug_imagen"];	
								$des_gal_imagen = $row["des_imagen"];	
								$fec_gal_imagen = $row["fec_imagen"];

								?>
								<div>
									<img src="image/<?=$arch_gal_imagen?>" alt="<?=$tit_gal_imagen." ".$lug_gal_imagen." ".$fec_gal_imagen?>">
									<div>
										<h4><?=$tit_gal_imagen?></h4>
										<p><?=$des_gal_imagen?></p>
									</div>
								</div><br>
							<?php
								}
							?>
					</div>
				</article>
				<br>
				<hr class="span9">
				<br>
				<article class="span8 text-left">
						<hr class="featurette-divider">

						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/tours"><i class="icon-tour"></i> Tours »</a></h5>
							<ul class="text-left">
								<?php
									$ids_pag_destino="'".$id."',".pagPadreDestino($dbname,$id);
									$ids_pag_destino = substr($ids_pag_destino, 0, -1);

									//ids del destino
									$dato_destino = "SELECT DISTINCT id_destino FROM destino WHERE id_pagina IN ($ids_pag_destino)";
									$dato_destino = mysql_db_query($dbname, $dato_destino); 
									while ($row = mysql_fetch_array($dato_destino)){
										$id_dest_int=$row["id_destino"];
										$ids_dest_int=$ids_dest_int."'".$id_dest_int."',";
									}
									$ids_dest_int = substr($ids_dest_int, 0, -1);


									//Tours Similares
									$dato_tours_destino = "SELECT DISTINCT tour.id_tour, tour.id_pagina
																FROM
																tour LEFT JOIN tour_destino ON tour.id_tour = tour_destino.id_tour
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_tours_destino = mysql_db_query($dbname, $dato_tours_destino); 
									while ($row = mysql_fetch_array($dato_tours_destino)){ 

										$id_tours = $row["id_tour"];
										$id_pag_tours = $row["id_pagina"];

										$dato_pag_tours = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_tours";
										$dato_pag_tours = mysql_db_query($dbname, $dato_pag_tours); 
										if ($row = mysql_fetch_array($dato_pag_tours)){ 

											$tit_pag_tours = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_tours);$pagurl="";
										$url_pag_tours = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_tours?>"><?=$tit_pag_tours?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/souvenirs-regalos"><i class="icon-souvenir"></i> Souvenirs y Regalos »</a></h5>
							<ul class="text-left">
								<?php
									//Souvenir del destino
									$dato_souvenir = "SELECT DISTINCT id_pagina
																FROM
																souvenir
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_souvenir = mysql_db_query($dbname, $dato_souvenir); 
									while ($row = mysql_fetch_array($dato_souvenir)){ 

										$id_souvenirs = $row["id_souvenir"];
										$id_pag_souvenirs = $row["id_pagina"];

										$dato_pag_tours = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_souvenirs";
										$dato_pag_tours = mysql_db_query($dbname, $dato_pag_tours); 
										if ($row = mysql_fetch_array($dato_pag_tours)){ 

											$tit_pag_souvenirs = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_souvenirs);$pagurl="";
										$url_pag_souvenirs = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_souvenirs?>"><?=$tit_pag_souvenirs?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/comidas-tipicas"><i class="icon-comida"></i> Comidas Tipicas »</a></h5>
							<ul class="text-left">
								<?php
									//Comida Tipica del destino
									$dato_tipica = "SELECT DISTINCT id_pagina
																FROM
																tipica
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_tipica = mysql_db_query($dbname, $dato_tipica); 
									while ($row = mysql_fetch_array($dato_tipica)){ 

										$id_tipicas = $row["id_tipica"];
										$id_pag_tipicas = $row["id_pagina"];

										$dato_pag_tours = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_tipicas";
										$dato_pag_tours = mysql_db_query($dbname, $dato_pag_tours); 
										if ($row = mysql_fetch_array($dato_pag_tours)){ 

											$tit_pag_tipicas = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_tipicas);$pagurl="";
										$url_pag_tipicas = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_tipicas?>"><?=$tit_pag_tipicas?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/sitios-turisticos"><i class="icon-sitio"></i> Sitios Turisticos »</a></h5>
							<ul class="text-left">
								<?php
									//Sitios Turisticos del destino
									$dato_sitio = "SELECT DISTINCT id_pagina
																FROM
																sitio
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_sitio = mysql_db_query($dbname, $dato_sitio); 
									while ($row = mysql_fetch_array($dato_sitio)){ 

										$id_sitios = $row["id_sitio"];
										$id_pag_sitios = $row["id_pagina"];

										$dato_pag_sitios = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_sitios";
										$dato_pag_sitios = mysql_db_query($dbname, $dato_pag_sitios); 
										if ($row = mysql_fetch_array($dato_pag_sitios)){ 

											$tit_pag_sitios = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_sitios);$pagurl="";
										$url_pag_sitios = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_sitios?>"><?=$tit_pag_sitios?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/alojamientos-hoteles"><i class="icon-hotel"></i> Alojamientos - Hoteles »</a></h5>
							<ul class="text-left">
								<?php
									//Alojamiento - Hoteles del destino
									$dato_alojamiento = "SELECT DISTINCT id_pagina
																FROM
																alojamiento
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_alojamiento = mysql_db_query($dbname, $dato_alojamiento); 
									while ($row = mysql_fetch_array($dato_alojamiento)){ 

										$id_alojamientos = $row["id_alojamiento"];
										$id_pag_alojamientos = $row["id_pagina"];

										$dato_pag_alojamientos = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_alojamientos";
										$dato_pag_alojamientos = mysql_db_query($dbname, $dato_pag_alojamientos); 
										if ($row = mysql_fetch_array($dato_pag_alojamientos)){ 

											$tit_pag_alojamientos = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_alojamientos);$pagurl="";
										$url_pag_alojamientos = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_alojamientos?>"><?=$tit_pag_alojamientos?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/restaurantes"><i class="icon-restaurante"></i> Restaurantes »</a></h5>
							<ul class="text-left">
								<?php
									//Restaurantes del destino
									$dato_restaurante = "SELECT DISTINCT id_pagina
																FROM
																restaurante
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_restaurante = mysql_db_query($dbname, $dato_restaurante); 
									while ($row = mysql_fetch_array($dato_restaurante)){ 

										$id_restaurantes = $row["id_restaurante"];
										$id_pag_restaurantes = $row["id_pagina"];

										$dato_pag_restaurantes = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_restaurantes";
										$dato_pag_restaurantes = mysql_db_query($dbname, $dato_pag_restaurantes); 
										if ($row = mysql_fetch_array($dato_pag_restaurantes)){ 

											$tit_pag_restaurantes = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_restaurantes);$pagurl="";
										$url_pag_restaurantes = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_restaurantes?>"><?=$tit_pag_restaurantes?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/tiendas"><i class="icon-tienda"></i> Tiendas »</a></h5>
							<ul class="text-left">
								<?php
									//Tiendas del destino
									$dato_tienda = "SELECT DISTINCT id_pagina
																FROM
																tienda
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_tienda = mysql_db_query($dbname, $dato_tienda); 
									while ($row = mysql_fetch_array($dato_tienda)){ 

										$id_tiendas = $row["id_tienda"];
										$id_pag_tiendas = $row["id_pagina"];

										$dato_pag_tiendas = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_tiendas";
										$dato_pag_tiendas = mysql_db_query($dbname, $dato_pag_tiendas); 
										if ($row = mysql_fetch_array($dato_pag_tiendas)){ 

											$tit_pag_tiendas = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_tiendas);$pagurl="";
										$url_pag_tiendas = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_tiendas?>"><?=$tit_pag_tiendas?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/actividades-turisticas"><i class="icon-actividad"></i>  Actividades Turisticas »</a></h5>
							<ul class="text-left">
								<?php
									//Actividades del destino
									$dato_actividad = "SELECT DISTINCT id_pagina
																FROM
																actividad
																WHERE id_destino IN ($ids_dest_int)
																LIMIT 0, 3";

									$dato_actividad = mysql_db_query($dbname, $dato_actividad); 
									while ($row = mysql_fetch_array($dato_actividad)){ 

										$id_actividades = $row["id_actividad"];
										$id_pag_actividades = $row["id_pagina"];

										$dato_pag_actividades = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina=$id_pag_actividades";
										$dato_pag_actividades = mysql_db_query($dbname, $dato_pag_actividades); 
										if ($row = mysql_fetch_array($dato_pag_actividades)){ 

											$tit_pag_actividades = $row["tit_pos_pagina"];

										} 

										$url_pag = pagUrl($dbname,$id_pag_actividades);$pagurl="";
										$url_pag_actividades = substr($url_pag, 0, -1);

										?>
											<li>
												<a href="<?=$url_pag_actividades?>"><?=$tit_pag_actividades?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>				
					</article>
				<br>
				<hr class="span9">
				<br>
				<article class="span9">
					<p>
						<strong>Contactanos:</strong><br>
						<?php
							//Info del Contacto
							$dato_pagina = "SELECT * FROM info WHERE id_contacto='1' AND vis_info='1' ORDER BY ord_info";
							$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
							while ($row = mysql_fetch_array($dato_pagina)){ 

								$tipo_pie = $row["tipo_info"]; 
								$dato_pie = $row["dato_info"]; 

								switch ($tipo_pie) {
									case 'Dirección':
										?>
										<small><strong><spam class="enlace-pie">Dirección:</spam></strong><?=$dato_pie?></small>
										<?php
										break;
									case 'E-mail':
										?>
										<a class="enlace-pie" href="mailto:<?=$dato_pie?>" itemprop="url"><i class="icon-mail ico-ml"></i> <?=$dato_pie?></a><br>
										<?php
										break;
									case 'Facebook':
										?>
										<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-facebook1 ico-fb"></i> Facebook</a><br>
										<?php
										# code...
										break;
									case 'Google+':
										?>
										<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-google ico-go"></i> Google+</a><br>
										<?php
										break;
									case 'Instagram':
										?>
										<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-instagram ico-in"></i> Instagram</a><br>
										<?php
										break;
									case 'Sitio Web':
										?>
										<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><small><?=$dato_pie?></small></a>
										<?php
										break;
									case 'Skype':
										?>
										<a class="enlace-pie" href="skype:<?=$dato_pie?>?call" itemprop="url"><i class="icon-skype ico-sk"></i> Skype</a><br>
										<?php
										break;
									case 'Telefono':
										?>
										<small><strong>Fono:</strong><?=$dato_pie?></small>
										<?php
										break;
									case 'Twitter':
										?>
										<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-twitter1 ico-tw"></i> Twitter</a><br>
										<?php
										break;
									case 'Youtube':
										?>
										<a class="enlace-pie" href="<?=$dato_pie?>" itemprop="url"><i class="icon-youtube ico-yt"></i> Youtube</a><br>
										<?php
										break;
								}

							}

						?>
					</p>
				</article>
			</div>
		</section>

	</body>
</html>


