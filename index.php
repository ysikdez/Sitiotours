<?php

include ("admin/config.php");
include ("admin/functions.php");

$id = $_GET["id"];

//con la url encontrar el id
$dato_config = "SELECT id_pagina FROM pagina WHERE url_pagina='$id'";
$dato_config = mysql_db_query($dbname, $dato_config); 
if ($row = mysql_fetch_array($dato_config)){ $id = $row["id_pagina"];}


// $_SESSION['URL'] = "http://".$SERVER_NAME.$PHP_SELF."?".$QUERY_STRING; 
session_start();
if(isset($_SESSION['carro'])){$carro=$_SESSION['carro'];}else{ $carro=false; }


//Configuracion
$dato_config = "SELECT * FROM site WHERE id_site='1'";
$dato_config = mysql_db_query($dbname, $dato_config); 
if ($row = mysql_fetch_array($dato_config)){ 

	$url_site = $row["url_site"];
	$mail_site = $row["mail_site"];
	$auto_site = $row["auto_site"];
	$copy_site = $row["copy_site"];

}

//Pagina
$dato_pagina = "SELECT * FROM pagina WHERE id_pagina='$id'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ 

	$id_idioma = $row["id_idioma"];
	$des = $row["des_pagina"];
	$key = $row["key_pagina"];
	$tit = $row["tit_pagina"];
	$url = $row["url_pagina"];

	$tit_pos = $row["tit_pos_pagina"];
	$tit_com = $row["tit_com_pagina"];

	$logo = $row["logo_pagina"];
	$alt_logo = $row["alt_logo_pagina"];
	$des_logo = $row["des_logo_pagina"];
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
		<link href="/img/icon-sitiotours.png" rel="shortcut icon">
		
		<script src="/js/script.js"></script>
		<script src="/js/jquery.js"></script>
		<script src="/js/bootstrap.js"></script>

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title><?=$tit?> :: Sitiotours.com </title>
	</head>

	<body>
		<?php
			//General
			$dato_general = "SELECT * FROM general WHERE id_pagina='$id'";
			$dato_general = mysql_db_query($dbname, $dato_general); 
			if ($row = mysql_fetch_array($dato_general)){ 
				$id_general = $row["id_general"];
				$des_general = $row["des_general"];
			}
		?>

				<?php
					include ("header.php");
				?>

		<section class="container marketing top-margen">
			<div class="row">
				<?php
					include ("filtro.php");
				?>

				<article class="span8" itemscope itemtype="http://schema.org/ImageObject">
					<?php
						if (!empty($logo)) {
							?>
								<figure>
									<img src="/image/<?=$logo?>" alt="<?=$alt_logo?> - <?=$des_logo?>" border="0" width="200" heigth="114" itemprop="contentURL">
								</figure>
								<meta itemprop="datePublished" content="2014-07-06">
							<?php
						}
					?>
					<h1 itemprop="name"><?=$tit_pos?></h1>
					<h2><?=$tit_com?></h2>
					<p itemprop="description"><?=$des_general?><br></p>
					<p class="text-center">

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
					</p>
				</article>

				<br>
				<?php
					//Detalle
					$dato_pagina = "SELECT * FROM detalle WHERE id_general='$id_general'";
					$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
					while ($row = mysql_fetch_array($dato_pagina)){ 

						$tit_detalle = $row["tit_detalle"];
						$des_detalle = $row["des_detalle"];

						?>
						<article class="span6 text-center">
							<h2><?=$tit_detalle?></h2>
							<p><?=$des_detalle?></p>
						</article>

					<?php
					}
				?>

				<?php
					//Pagina
					$dato_pagina = "SELECT * FROM pagina WHERE per_pagina='$id' AND id_pagina>'0' AND ord_pagina<'15'";
					$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
					while ($row = mysql_fetch_array($dato_pagina)){ 

						$id_int = $row["id_pagina"];
						$ord_int = $row["ord_pagina"];
						$url_int = $row["url_pagina"];
						$tit_int = $row["tit_pagina"];
						$des_int = $row["des_pagina"];
						$tit_pos_int = $row["tit_pos_pagina"];

						$logo_int = $row["logo_pagina"];
						$alt_logo_int = $row["alt_logo_pagina"];
						$des_logo_int = $row["des_logo_pagina"];

						$url_pag = pagUrl($dbname,$id_int);$pagurl="";
						$url_pag = substr($url_pag, 0, -1);

						if ($id==0) {

							if ($ord_int>2) {
								?>
									<article class="span4" itemscope itemtype="http://schema.org/ImageObject">
										<a href="/<?=$url_pag?>">
											<?php 
												if (!empty($logo_int)) {
												?>
													<figure>
														<img src="/image/<?=$logo_int?>" alt="<?=$alt_logo_int?> - <?=$des_logo_int?>" border="0" width="111" heigth="111" itemprop="contentURL">
													</figure>
												<?php
											}
											?>
											<meta itemprop="datePublished" content="2014-07-06">
											<h2 itemprop="name"><?=$tit_pos_int?></h2>
										</a>
										<p itemprop="description"><?=$des_int?></p>
									</article>
								<?php					
							}

						} else{
							?>
								<article class="span4" itemscope itemtype="http://schema.org/ImageObject">
									<a href="/<?=$url_pag?>">
										<?php 
											if (!empty($logo_int)) {
											?>
												<figure>
													<img src="/image/<?=$logo_int?>" alt="<?=$alt_logo_int?> - <?=$des_logo_int?>" border="0" width="111" heigth="111" itemprop="contentURL">
												</figure>
											<?php
										}
										?>
										<meta itemprop="datePublished" content="2014-07-06">
										<h2 itemprop="name"><?=$tit_pos_int?></h2>
									</a>
									<p itemprop="description"><?=$des_int?></p>
								</article>
							<?php
						}
					}

				?>

				<?php
					if ($url=="tours") {
						?>

						<div  class="span8">

							<hr class="featurette-divider">
							<form method="get" enctype="multipart/form-data" name="formulario" action="">
								<label>
									<h3>Encuentra tu Tour</h3>
									<input list="formu" name="dise" type="text" value="Top" placeholder="Nombre de tu Tour">
									<datalist id="formu">
										<option value="Top">
										<!-- <option value="Nombre">
										<option value="Precio">
										<option value="Nuevo">
										<option value="Oferta"> -->
									</datalist>
								</label>
							</form>
						</div>
						<div name="tipo" class="span8 tour-tipo">					

							<?php
								$formu="top";
								// maximo por pagina
								$limit = 4;

								// pagina pedida
								$pag = (int) $_GET["pag"];
								if ($pag < 1)
								{
								   $pag = 1;
								}
								$offset = ($pag-1) * $limit;

								$sql = "SELECT SQL_CALC_FOUND_ROWS 
												*,
												COUNT(valoracion.pun_valoracion) AS numero,
												AVG(valoracion.pun_valoracion) AS promedio 
											FROM

												((tour LEFT JOIN pagina ON pagina.id_pagina = tour.id_pagina)
												LEFT JOIN valoracion ON pagina.id_pagina=valoracion.id_pagina)

											GROUP BY tour.id_pagina

											ORDER BY promedio DESC";

								$sqlTotal = "SELECT FOUND_ROWS() as total";

								$rs = mysql_query($sql);
								$rsTotal = mysql_query($sqlTotal);

								$rowTotal = mysql_fetch_assoc($rsTotal);
								// Total de registros sin limit
								$total = $rowTotal["total"];

								while ($row = mysql_fetch_assoc($rs)){ 

									$promedio = $row["promedio"];
									$id_pag_tours = $row["id_pagina"];

									$tit_pos_pag_tours = $row["tit_pos_pagina"];
									$des_pag_tours = $row["des_pagina"];

									$tipo_tours = $row["tipo_tour"];
									$tipo_tours = $row["tipo_tour"];

									$dur_dia_tour = $row["dur_dia_tour"];
									$dur_noc_tour = $row["dur_noc_tour"];

									$logo_pag_tours = $row["logo_pagina"];
									$alt_logo_pag_tours = $row["alt_logo_pagina"];
									$des_logo_pag_tours = $row["des_logo_pagina"];

									$url_pag = pagUrl($dbname,$id_pag_tours);$pagurl="";
									$url_pag = substr($url_pag, 0, -1);

									?> 
										<div class="span4 tour-tipo" itemscope itemtype="http://schema.org/ImageObject">
											<a href="/<?=$url_pag?>">
												<h3 itemprop="name"><?=$tit_pos_pag_tours?> (<?=$dur_dia_tour?> D / <?=$dur_noc_tour?> N)</h3>
												<figure>
													<img src="/image/<?=$logo_pag_tours?>" alt="<?=$alt_logo_pag_tours?> - <?=$des_logo_pag_tours?>" border="0" width="80" heigth="80" class="img-circle" itemprop="contentURL">
												</figure>
												<h4 itemprop="name"><?=$tipo_tours?></h4>
												<meta itemprop="datePublished" content="2014-07-06">
											</a>
											<p itemprop="description"><?=$des_pag_tours?></p>
											
										</div>
									<?php
								}
							?>

							<br>
							<br>
							<div class="pagination span12 text-center">
								<ul>
									<?php


										$totalPag = ceil($total/$limit);
										$links = array();

										if ($totalPag<=5){

											for( $i=1; $i<=$totalPag ; $i++)
											{
												if ($pag==$i) { $on="class='active'"; } else { $on=""; }
												$n=$i;

												$links[] = "<li ".$on."><a href=\"?formu=$formu&pag=$i\">$n</a></li>"; 
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

												$links[] = "<li ".$on."><a href=\"?formu=$formu&pag=$i\">$n</a></li>"; 
											}

										}

										echo implode(" ", $links);
									?>
				  				</ul>
							</div>

							<br>						

						</div>

						<?php
					}
				?>

				<?php
					if ($url=="mapa-del-sitio") {
						?>
							<div  class="span8">
								<?php
								for ($i=0; $i <= 1 ; $i++) {
									MapaSitio($dbname,1,$i);
									}
								?>
							</div>
						<?php

					}
				?>
				<br>


			</div>
		</section>		

				<?php
					include ("footer.php");
				?>


	</body>
</html>


