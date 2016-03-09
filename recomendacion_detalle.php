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

//Datos de la Pagina de los Comentarios 
$dato_comentarios = "SELECT * FROM pagina WHERE tit_pos_pagina='$tit_pos'";
$dato_comentarios = mysql_db_query($dbname, $dato_comentarios); 
if ($row = mysql_fetch_array($dato_comentarios)){ 

	$id_pag_coment = $row["id_pagina"];

}

if ($id_pag_coment==0 OR $id_pag_coment==1 OR $id_pag_coment==2 OR $id_pag_coment==3) {
	$id_pag_comentario="'0','1','2','3'";
} else {

	$id_pag_comentario = "'".$id_pag_coment."',".pagInternas($dbname,$id_pag_coment);
	$id_pag_comentario = substr($id_pag_comentario, 0, -1);
}

//****************************************************************************************************//

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
		<title><?=$tit?> - <?=$tit_pos_pad?> :: Sitiotours.com </title>
	</head>

	<body>
		<?php
			include ("header.php");
		?>

		<section class="container marketing top-margen">
			<div class="row">
				<div class="span8">
					<article class="span8">
						<div class="span8 text-center">
							<h1 class="inline-block pull-left">
								<a href="/<?=$url_pad?>"><i class="<?=$ico_pag_pad?> ico-titulo"></i></a>
							</h1>	
							<h1 class="inline-block pull-left">
								<a href="/<?=$url_pad?>" class="titulo"><?=$tit_pos_pad?></a> » 
							</h1>
							<br><br><br>
							<h1 class="text-left"><?=$tit_pos?></h1>
							<h2 class="text-left"><?=$tit_com?></h2>
							<figure>
								<img src="/image/<?=$logo?>" alt="<?=$alt_logo?> - <?=$des_logo?>" border="0" width="111" heigth="111" itemprop="contentURL">
							</figure>
							<br><br>
						</div>						
					</article>

					<article class="span8">
						<hr class="featurette-divider">
						<h4 class="text-left">Descripcion :</h4>
						<p class="text-justify"><?=$des_actividad?></p>
						<br>
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
						
						<hr class="featurette-divider">
					</article>

					<article class="span8">
						<div class="span7">
							<?php

								// maximo por pagina
								$limit = 15;

								// pagina pedida
								$pag = (int) $_GET["pag"];
								if ($pag < 1)
								{
									$pag = 1;
								}
								$offset = ($pag-1) * $limit;

								$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT
											tic.id_tic,
											tic.id_pagina,
											pagina.tit_pos_pagina,
											pagina.url_pagina,
											tic.fc_hr_tic,
											tic.nick_tic,
											tic.des_tic,
											tic.mail_tic,
											tic.vist_tic,
											tic.fav_tic,
											tic.pic_tic
											FROM

												((pagina INNER JOIN tic ON pagina.id_pagina=tic.id_pagina) LEFT JOIN val_tic ON tic.id_tic=val_tic.id_tic)
											
											WHERE tic.id_pagina IN ($id_pag_comentario)
											
											ORDER BY val_tic.pun_val_tic DESC
											
											LIMIT $offset,$limit";

								$sqlTotal = "SELECT FOUND_ROWS() as total";

								$rs = mysql_query($sql);
								$rsTotal = mysql_query($sqlTotal);

								$rowTotal = mysql_fetch_assoc($rsTotal);
								// Total de registros sin limit
								$total = $rowTotal["total"];


								while ($row = mysql_fetch_assoc($rs))
								{
									$id_pag = $row["id_pagina"]; 
									$id_tic = $row["id_tic"]; 
									$titulo = $row["tit_pos_pagina"]; 
									$url = $row["url_pagina"]; 

									$nombre = $row["nick_tic"]; 
									$fecha = $row["fc_hr_tic"]; 
									$des = $row["des_tic"]; 
									$mail = $row["mail_tic"]; 
									$vist = $row["vist_tic"]; 
									$fav = $row["fav_tic"]; 


									// suma de Tips de la Pagina
									$sum_val = "SELECT SUM(pun_val_tic) FROM val_tic WHERE id_tic='$id_tic'";
									$sum_val = mysql_db_query($dbname, $sum_val);
									$sum_val = mysql_result($sum_val, 0);


									// Numero de Tips de la Pagina
									$n_val = "SELECT COUNT(id_val_tic) FROM val_tic WHERE id_tic='$id_tic'";
									$n_val = mysql_db_query($dbname, $n_val);
									$n_val = mysql_result($n_val, 0);

									$pro_val = $sum_val / $n_val;
									$pro_val = round($pro_val, 0);

							?>
								<div class="media">
									<div class="media-body text-justify">
<!-- 										<div class="pull-left">
											<img class="media-object img-circle guinda" data-src="holder.js/45x4" alt="45x45" src="img/<?=$pic_tic?>" style="width: 45x; height: 45px;">
										</div> -->

										<div id="voto-comentario-<?=$id_tic?>" class="pull-right">											
											<?php 
												if ($pro_val=='0') { $act1='ico-val_off'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
												if ($pro_val=='1') { $act1='ico-val_on'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
												if ($pro_val=='2') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
												if ($pro_val=='3') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_off'; $act5='ico-val_off';} 
												if ($pro_val=='4') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_off';} 
												if ($pro_val=='5') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_on';} 
											?>
											<small><small><small>
												<a class="icon-pie1 <?=$act1?>" onclick='VotarComentario(<?=$id_tic?>,1)'></a>
												<a class="icon-pie2 <?=$act2?>" onclick='VotarComentario(<?=$id_tic?>,2)'></a>
												<a class="icon-pie1 <?=$act3?>" onclick='VotarComentario(<?=$id_tic?>,3)'></a>
												<a class="icon-pie2 <?=$act4?>" onclick='VotarComentario(<?=$id_tic?>,4)'></a>
												<a class="icon-pie1 <?=$act5?>" onclick='VotarComentario(<?=$id_tic?>,5)'></a>
											</small></small></small>
										</div>									
										<h5 class="media-heading text-left">
											<?php
												$url_pag_tip = pagUrl($dbname,$id_pag);$pagurl="";
												$url_pag_tip = substr($url_pag_tip, 0, -1);
											?>


											<?php if ($fav==1) {?> <i class="icon-heart"></i> <?php } ?>
											<?=$nombre?> / <a href="/<?=$url_pag_tip?>"><?=$titulo?> </a>  (<strong><?=$n_val?></strong> Votos)
										</h5>
										<small><small><strong><?=$fecha?></strong></small></small>
										<br>
										<small><?=$des?></small><br>
									</div>

									<div>
										<a class="pull-right" data-toggle="collapse" data-target="#responder<?=$id_tic?>">
											<i class="icon-retweet"></i>
										</a>
										<br>
										<div id="responder<?=$id_tic?>" class="collapse media-body">
											<div class="span5" id="coment_<?=$id_tic?>">
												<form method="post" enctype="multipart/form-data" name="formulario_<?=$id_tic?>" action="">
													<h5>Nueva Recomendacion - Tips »</h5>
													<label>
														<input type="text" name="nick_<?=$id_tic?>" id="nick_<?=$id_tic?>" class="span5" placeholder="Nombre" value="Ysik">
													</label>
													<label>
														<input type="text" name="mail_<?=$id_tic?>" id="mail_<?=$id_tic?>" class="span5" placeholder="E-mail" value="info@sitiotours.com">
													</label>
													<label>
														<textarea rows="2" name="des_<?=$id_tic?>" id="des_<?=$id_tic?>" class="span5" placeholder="Comentario"></textarea>
													</label>
													<label class="checkbox inline">
														<input type="checkbox" name="like_<?=$id_tic?>" id="like_<?=$id_tic?>" value="1"> 
														Desea que le Enviemos Informacion 
													</label>
													<button class="btn btn-primary btn-sitio pull-right" onclick="Coment('<?=$id_tic?>','<?=$pagina?>')">Guardar</button>
												</form>
											</div>          
										</div>
									</div>
									<br><br>
								</div>
							<?php
							}
							?>
							<div class="pagination">
								<ul>
									<?php


										$totalPag = ceil($total/$limit);
										$links = array();

										if ($totalPag<=5){

											for( $i=1; $i<=$totalPag ; $i++)
											{
												if ($pag==$i) { $on="class='active'"; } else { $on=""; }
												$n=$i;

												$links[] = "<li ".$on."><a href=\"?id=$id&pag=$i\">$n</a></li>"; 
											}

										}else{

											
											if ($pag < 5){ 

												$ini=1; 
												$fin=5;

											} else{ 

												$ini=$pag-2;
												$fin=$pag+2;
											}		

											if ($fin >= $totalPag) { $fin=$totalPag; } 

											for( $i=$ini; $i<=$fin ; $i++)
											{	
												$n=$i; 
												if ($pag==$i) { $on="class='active'"; } else { $on=""; }
												if ($ini==$i && $i!=1) { $n="«"; } 
												if ($fin==$i && $i!=$totalPag) { $n="»"; }

												$links[] = "<li ".$on."><a href=\"?id=$id&pag=$i\">$n</a></li>"; 
											}

										}

										echo implode(" ", $links);
									?>
				  				</ul>
							</div>
						</div>
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
				</div>

				<?php
					include ("filtro.php");
				?>
			</div>
		</section>		

				<?php
					include ("footer.php");
				?>


	</body>
</html>


