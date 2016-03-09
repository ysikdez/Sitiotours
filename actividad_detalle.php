<?php
include ("admin/config.php");
include ("admin/functions.php");

// $_SESSION['URL'] = "http://".$SERVER_NAME.$PHP_SELF."?".$QUERY_STRING; 
session_start();
if(isset($_SESSION['carro'])){$carro=$_SESSION['carro'];}else{ $carro=false; }


//Pagina
$id = $_GET["id"];

$dato_pagina = "SELECT * FROM (pagina LEFT JOIN actividad ON pagina.id_pagina = actividad.id_pagina) WHERE pagina.id_pagina='$id'";
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

//Actividad

	$id_actividad = $row["id_actividad"];
	$cod_actividad = $row["cod_actividad"];

	$id_destino = $row["id_destino"];

	$fec_ini_actividad = $row["fec_ini_actividad"];
	$fec_ini_actividad = strtotime($fec_ini_actividad);
	$fec_ini_actividad = date("F j, Y", $fec_ini_actividad);

	$hor_ini_actividad = $row["hor_ini_actividad"];
	$hor_ini_actividad = strtotime($hor_ini_actividad);
	$hor_ini_actividad = date("h:i a", $hor_ini_actividad);	

	$fec_fin_actividad = $row["fec_fin_actividad"];
	$fec_fin_actividad = strtotime($fec_fin_actividad);
	$fec_fin_actividad = date("F j, Y", $fec_fin_actividad);

	$hor_fin_actividad = $row["hor_fin_actividad"];
	$hor_fin_actividad = strtotime($hor_fin_actividad);
	$hor_fin_actividad = date("h:i a", $hor_fin_actividad);	

	$des_actividad = $row["des_actividad"];

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

		<link href="/css/bootstrap.css" rel="stylesheet">
		<link href="/img/ico-sitiotours.png" rel="shortcut icon">
		
		<script src="/js/script.js"></script>
		<script src="/js/jquery.js"></script>
		<script src="/js/bootstrap.js"></script>

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
					<?php

					?>
					<article class="span8 text-center">
						<div>
							<h1 class="inline-block pull-left">
								<a href="/<?=$url_pad?>"><i class="<?=$ico_pag_pad?> ico-titulo"></i></a>
							</h1>	
							<h1 class="inline-block pull-left">
								<a href="/<?=$url_pad?>" class="titulo"><?=$tit_pos_pad?></a> » 
							</h1>
						</div>
						<br><br><br>
						<h1 class="text-left"><?=$tit_pos?></h1>
						<h2 class="text-left"><?=$tit_com?></h2>
						<figure>
							<img src="/image/<?=$logo?>" alt="<?=$alt_logo?> - <?=$des_logo?>" border="0" width="111" heigth="111" itemprop="contentURL">
						</figure>
						<br>
						<small>
							<dl class="dl-horizontal text-left">

								<dt><strong>Codigo :</strong></dt>
								<dd><?=$cod_actividad?></dd>

								<dt><strong>Destino :</strong></dt>
								<dd>
									<?php
										//Destino
										$dato_destino = "SELECT pagina.id_pagina ,destino.id_destino ,pagina.tit_pos_pagina ,pagina.url_pagina
																FROM
																((actividad LEFT JOIN destino ON actividad.id_destino = destino.id_destino)
																LEFT JOIN pagina ON pagina.id_pagina = destino.id_pagina)
																WHERE
																actividad.id_actividad='$id_actividad'";

										$dato_destino = mysql_db_query($dbname, $dato_destino); 
										while ($row = mysql_fetch_array($dato_destino)){ 

											$id_tourdest = $row["id_destino"];//id de los Destinos del Tour
											$id_pag_dest = $row["id_pagina"];
											$tit_pag_dest = $row["tit_pos_pagina"];

											$url_pag = pagUrl($dbname,$id_pag_dest);$pagurl="";
											$url_pag_dest = substr($url_pag, 0, -1);


											$ids_dest=pagPadreDestino($dbname,$id_pag_dest);
											$ids_dest = substr($ids_dest, 0, -1);

											$des='';
											$des_pad = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina IN ($ids_dest)";
											$des_pad = mysql_db_query($dbname, $des_pad); 
											while ($row = mysql_fetch_array($des_pad)){ 

													$tit_des = $row["tit_pos_pagina"];
													$des=$des.$tit_des." » ";

											} 
											$pad_id='';
											?>
												<a href="/<?=$url_pag_dest?>" class="tooltip-test" title="<?=$des?>"><?=$tit_pag_dest?></a>, 
											<?php

											$ids_tour_dest = $ids_tour_dest.$id_tourdest.",";//ids de los Destinos del Tour
										}
										$ids_tour_dest = substr($ids_tour_dest, 0, -1); //id de los Destinos del Tour sin ,
									?>
									<br>
								</dd>

								<dt><strong>Inicio :</strong></dt>
								<dd>
									<?=$fec_ini_actividad?> a las <?=$hor_ini_actividad?><br>
								</dd>

								<dt><strong>Fin :</strong></dt>
								<dd>
									<?=$fec_fin_actividad?> a las <?=$hor_fin_actividad?><br>
								</dd>

							</dl>
						</small>
						<br>
						<h4 class="text-left">Descripcion :</h4>
						<p class="text-justify"><?=$des_actividad?></p>
						<br><br>
						<p>
							<?php
								//Datos de la valoracion
								$dato_valoracion = "SELECT 
														COUNT(valoracion.pun_valoracion) AS numero,
														AVG(valoracion.pun_valoracion) AS promedio
														FROM
														((tour LEFT JOIN pagina ON pagina.id_pagina = tour.id_pagina)
														LEFT JOIN valoracion ON pagina.id_pagina=valoracion.id_pagina)
														WHERE id_tour='$id_tour'";
								$dato_valoracion = mysql_db_query($dbname, $dato_valoracion); 
								if ($row = mysql_fetch_array($dato_valoracion)){ 

									$numero = $row["numero"];
									$promedio = $row["promedio"];
									$promedio = ceil($promedio);
								}
							?>
							<div id="voto">
								<?php 
									if ($promedio=='0') { $act1='ico-val_off'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
									if ($promedio=='1') { $act1='ico-val_on'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
									if ($promedio=='2') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
									if ($promedio=='3') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_off'; $act5='ico-val_off';} 
									if ($promedio=='4') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_off';} 
									if ($promedio=='5') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_on';} 
								?>
								<a class="icon-pie1 <?=$act1?>" onclick='Votar(<?=$id?>,1)'></a>
								<a class="icon-pie2 <?=$act2?>" onclick='Votar(<?=$id?>,2)'></a>
								<a class="icon-pie1 <?=$act3?>" onclick='Votar(<?=$id?>,3)'></a>
								<a class="icon-pie2 <?=$act4?>" onclick='Votar(<?=$id?>,4)'></a>
								<a class="icon-pie1 <?=$act5?>" onclick='Votar(<?=$id?>,5)'></a>
								<br>
								<small><small><strong><?=$numero?></strong> Votos</small></small>
							</div>
						</p>
					</article>
					<article class="span8 text-center apagado-mini">
						<iframe src="<?=$map?>" width="600" height="400" frameborder="0" style="border:0" class="span7 text-center"></iframe>
					</article>
					<article class="span8">
						<div id="imagen" class="carousel slide alto">
							<ol class="carousel-indicators  alto">
								<?php

									$total_ima = "SELECT  COUNT(imagen.id_imagen)
															FROM
															((galeria LEFT JOIN galeria_imagen ON galeria.id_galeria = galeria_imagen.id_galeria)
															LEFT JOIN imagen ON imagen.id_imagen = galeria_imagen.id_imagen)
															WHERE galeria.id_pagina='$id' AND tipo_galeria='Fotografica'";

									$total_ima = mysql_db_query($dbname, $total_ima);
									$total_ima = mysql_result($total_ima, 0);
									$total_ima = $total_ima-1;

									for ($i=0; $i <= $total_ima; $i++) { 
										if ($i==0) { $ima_act="active";} else { $ima_act="";}
										?>
											<li data-target="#imagen" data-slide-to="<?=$i?>" class="<?=$ima_act?>"></li>
										<?php
									}
								?>
							</ol>
							<div class="carousel-inner">
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

									if ($ord_gal_imagen==1) { $ima_act="active";} else { $ima_act="";}

									?>
									<div class="item <?=$ima_act?>">
										<figure>
											<img src="/image/<?=$arch_gal_imagen?>" alt="<?=$tit_gal_imagen." ".$lug_gal_imagen." ".$fec_gal_imagen?>" class="alto">
										</figure>
										<div class="carousel-caption">
											<h4><?=$tit_gal_imagen?></h4>
											<p><?=$des_gal_imagen?></p>
										</div>
									</div>
								<?php
									}
								?>

								<a class="left carousel-control" href="#imagen" data-slide="prev">‹</a>
								<a class="right carousel-control" href="#imagen" data-slide="next">›</a>
							</div>
						</div>
					</article>
					<article class="span8 text-center">
						<?php
							//Datos de la Galeria de Videos
							$datos_galeria_video = "SELECT *
														FROM
														((galeria LEFT JOIN galeria_video ON galeria.id_galeria = galeria_video.id_galeria)
														LEFT JOIN video ON video.id_video = galeria_video.id_video)
														WHERE galeria.id_pagina='$id' AND tipo_galeria='Videografica'
														ORDER BY ord_galeria_video";

							$datos_galeria_video = mysql_db_query($dbname, $datos_galeria_video); 
							while ($row = mysql_fetch_array($datos_galeria_video)){ 

									$id_video_galeria = $row["id_video"];
									$ord_gal_video = $row["ord_galeria_video"];
															
									$cod_gal_video = $row["cod_video"];	
									$tit_gal_video = $row["tit_video"];	
									$lug_gal_video = $row["lug_video"];	
									$des_gal_video = $row["des_video"];	
									$fec_gal_video = $row["fec_video"];

								?>
								<div class="span7 text-center">
									<div class="google-maps">
										<?=$cod_gal_video?>
									</div>
									<h5><?=$tit_gal_video?></h5>
									<small><?=$lug_gal_video?> - <?=$fec_gal_video?></small>
									<br>
									<?=$des_gal_video?>
								</div>
						<?php
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
								<a href="/<?=$url_pag_imprimir?>/imprimir" target="_blank" rel="nofollow"><i class="icon-imprimir ico-contacto"></i></a>
								<a data-toggle="collapse" data-target="#mensaje"><i class="icon-mail ico-mensaje ico-contacto"></i></a> 
								<a href="/<?=$url_pag_imprimir?>" class=""><i class="icon-favorito ico-contacto"></i></a> 
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

					<article class="span8 text-left">
						<hr class="featurette-divider">

						<div class="text-left span4 tour-tipo">
							<h5 class="text-left"><a href="/tours"><i class="icon-tour"></i> Tours »</a></h5>
							<ul class="text-left">
								<?php
									//Tours Similares
									$dato_tours_similares = "SELECT DISTINCT tour.id_tour, tour.id_pagina
																FROM
																tour LEFT JOIN tour_destino ON tour.id_tour = tour_destino.id_tour
																WHERE id_destino IN ($ids_tour_dest) AND tipo_tour='$tipo_tour' AND id_pagina<>'$id'
																LIMIT 0, 3";

									$dato_tours_similares = mysql_db_query($dbname, $dato_tours_similares); 
									while ($row = mysql_fetch_array($dato_tours_similares)){ 

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
												<a href="/<?=$url_pag_tours?>"><?=$tit_pag_tours?></a>
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
																WHERE id_destino IN ($ids_tour_dest)
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
												<a href="/<?=$url_pag_souvenirs?>"><?=$tit_pag_souvenirs?></a>
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
																WHERE id_destino IN ($ids_tour_dest)
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
												<a href="/<?=$url_pag_tipicas?>"><?=$tit_pag_tipicas?></a>
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
																WHERE id_destino IN ($ids_tour_dest)
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
												<a href="/<?=$url_pag_sitios?>"><?=$tit_pag_sitios?></a>
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
																WHERE id_destino IN ($ids_tour_dest)
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
												<a href="/<?=$url_pag_alojamientos?>"><?=$tit_pag_alojamientos?></a>
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
																WHERE id_destino IN ($ids_tour_dest)
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
												<a href="/<?=$url_pag_restaurantes?>"><?=$tit_pag_restaurantes?></a>
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
																WHERE id_destino IN ($ids_tour_dest)
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
												<a href="/<?=$url_pag_tiendas?>"><?=$tit_pag_tiendas?></a>
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
																WHERE id_destino IN ($ids_tour_dest)
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
												<a href="/<?=$url_pag_actividades?>"><?=$tit_pag_actividades?></a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>				
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


