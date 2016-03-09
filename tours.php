<?php
include ("admin/config.php");
include ("admin/functions.php");

// $_SESSION['URL'] = "http://".$SERVER_NAME.$PHP_SELF."?".$QUERY_STRING; 
session_start();
if(isset($_SESSION['carro'])){$carro=$_SESSION['carro'];}else{ $carro=false; }


//Pagina
$id = $_GET["id"];
$seccion = "tours";
$url_pagina = $id;


//con la url encontrar el id
$dato_url_tour = "SELECT id_pagina FROM pagina WHERE url_pagina='$seccion'";
$dato_url_tour = mysql_db_query($dbname, $dato_url_tour); 
while ($fila = mysql_fetch_array($dato_url_tour)){ 

	$id_pagina = $fila["id_pagina"];

	$dato_url_id_pad = "SELECT id_pagina FROM pagina WHERE url_pagina='$url_pagina' AND per_pagina=$id_pagina";
	$dato_url_id_pad = mysql_db_query($dbname, $dato_url_id_pad); 
	if ($row = mysql_fetch_array($dato_url_id_pad)){ $id = $row["id_pagina"]; }
}


//Configuraciond_pagina='$per_pagina' AND
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

	$id = $row["id_pagina"];
	$id_idioma = $row["id_idioma"];
	$per = $row["per_pagina"];

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

//Padre
$dato_padre = "SELECT * FROM pagina WHERE id_pagina='$per'";
$dato_padre = mysql_db_query($dbname, $dato_padre); 
if ($row = mysql_fetch_array($dato_padre)){ 

	$tit_pos_pad = $row["tit_pos_pagina"];
	$ico_pag_pad = $row["ico_pagina"];

	$url_pag = pagUrl($dbname,$per);$pagurl="";
	$url_pag_pad = substr($url_pag, 0, -1);

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
			//General
			$dato_general = "SELECT id_general,des_general FROM general WHERE id_pagina='$id'";
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
				<article class="span8 text-center">
					<div>
						<h1 class="inline-block pull-left">
							<a href="/<?=$url_pag_pad?>"><i class="<?=$ico_pag_pad?> ico-titulo"></i></a>
						</h1>	
						<h1 class="inline-block pull-left">
							<a href="/<?=$url_pag_pad?>" class="titulo"><?=$tit_pos_pad?></a> » 
						</h1>
						<div class="inline-block pull-left text-left titulo">
							<div class="dropdown">
								<a href="#" class="dropdown-toggle " data-toggle="dropdown">
									<h1> <?=$tit_pos?><b class="caret"></b> </h1>
								</a>
								<ul class="dropdown-menu">
									<?php
										//tipo
										$dato_tip_tour = "SELECT * FROM pagina WHERE per_pagina='$per'";
										$dato_tip_tour = mysql_db_query($dbname, $dato_tip_tour); 
										while ($row = mysql_fetch_array($dato_tip_tour)){ 
											$id_tip_tour = $row["id_pagina"];
											$tit_pos_tip_tour = $row["tit_pos_pagina"];

											$url_pag = pagUrl($dbname,$id_tip_tour);$pagurl="";
											$url_pag = substr($url_pag, 0, -1);
											?>
												<li><a href="/<?=$url_pag?>"><?=$tit_pos_tip_tour?></a></li>
											<?php
										}
									?>
								</ul>
							</div>
						</div>
						<br><br><br>
					</div>
						<h2 class="text-left"><?=$tit_com?></h2>
						<p itemprop="description"><?=$des_general?><br></p>

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
			
					<div  class="span8 tour-tipo">
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
					<div name="tipo" class="tour-tipo">					

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

										WHERE tipo_tour='$tit_pos'

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

								$id_tours = $row["id_tour"];
								$tipo_tours = $row["tipo_tour"];

								$dur_dia_tour = $row["dur_dia_tour"];
								$dur_noc_tour = $row["dur_noc_tour"];

								$logo_pag_tours = $row["logo_pagina"];
								$alt_logo_pag_tours = $row["alt_logo_pagina"];
								$des_logo_pag_tours = $row["des_logo_pagina"];


								$dato_url_id_pad = "SELECT id_pagina FROM tour WHERE id_tour='$id_tours'";
								$dato_url_id_pad = mysql_db_query($dbname, $dato_url_id_pad); 
								if ($row = mysql_fetch_array($dato_url_id_pad)){ $id_pag_tours = $row["id_pagina"]; }

								$url_pag_tours = pagUrl($dbname,$id_pag_tours);$pagurl="";
								$url_pag_tours = substr($url_pag_tours, 0, -1);

								?> 
									<div class="span4 tour-tipo" itemscope itemtype="http://schema.org/ImageObject">
										<a href="/<?=$url_pag_tours?>">
											<h3 itemprop="name"><?=$tit_pos_pag_tours?> (<?=$dur_dia_tour?> D / <?=$dur_noc_tour?> N)</h3>
											<figure>
												<img src="image/<?=$logo_pag_tours?>" alt="<?=$alt_logo_pag_tours?> - <?=$des_logo_pag_tours?>" border="0" width="80" heigth="80" class="img-circle" itemprop="contentURL">
											</figure>
											<meta itemprop="datePublished" content="2014-07-06">
										</a>
										
										<h4 itemprop="name"><?=$tipo_tours?></h4>
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

											$links[] = "<li ".$on."><a href=\"?formu=$formu&tipo=$tit_pos&pag=$i\">$n</a></li>"; 
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

											$links[] = "<li ".$on."><a href=\"?formu=$formu&tipo=$tit_pos&pag=$i\">$n</a></li>"; 
										}

									}

									echo implode(" ", $links);
								?>
			  				</ul>
						</div>

						<br>						

					</div>
				</article>
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


