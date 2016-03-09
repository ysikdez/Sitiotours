<?php
include ("admin/config.php");
include ("admin/functions.php");

// $_SESSION['URL'] = "http://".$SERVER_NAME.$PHP_SELF."?".$QUERY_STRING; 
session_start();
if(isset($_SESSION['carro'])){$carro=$_SESSION['carro'];}else{ $carro=false; }


$formu = $_GET["formu"];
// pagina pedida
$pag = (int) $_GET["pag"];

//Pagina
$pagina = "SELECT id_pagina FROM pagina WHERE url_pagina='tours'";
$pagina = mysql_db_query($dbname, $pagina); 
if ($row = mysql_fetch_array($pagina)){ $id = $row["id_pagina"]; }


//Configuracion
$dato_config = "SELECT * FROM site WHERE id_site='1'";
$dato_config = mysql_db_query($dbname, $dato_config); 
if ($row = mysql_fetch_array($dato_config)){ 

	$url = $row["url_site"];
	$mail = $row["mail_site"];
	$auto = $row["auto_site"];
	$copy = $row["copy_site"];

}

//Pagina
$dato_pagina = "SELECT * FROM pagina WHERE id_pagina='$id'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ 

	$id_idioma = $row["id_idioma"];
	$des = "Los ".$formu." / pagina ".$pag." ".$row["des_pagina"];
	$key = $formu.",".$row["key_pagina"];
	$tit = $formu." - ".$row["tit_pagina"]." : pagina ".$pag." ";

	$tit_pos = $formu." - ".$row["tit_pos_pagina"]." / pagina ".$pag;
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
		<base href="<?=$url?>" />
		<meta charset="utf-8">
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="<?=$auto?>" />
		<meta name="copyright" content="<?=$copy?>" />
		<!-- Descripción: entre 155 a 160 caracteres -->
		<meta name="description" content="<?=$des?>" />
		<meta name="distribution" content="Global" />
		<meta name="google-site-verification" content="" /> <!-- -------- -->
		<!-- Keywords: entre 300 caracteres -->
		<meta name="keywords" content="<?=$key?>" />
		<meta name="MSSmartTagsPreventParsing" content="TRUE" />
		<meta name="owner" content="<?=$auto?>" />
		<meta name="rating" content="General" />
		<meta name="reply-to" content="<?=$mail?>" />
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
			//General
			$dato_general = "SELECT id_general, FROM general WHERE id_pagina='$id'";
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
			<div  class="span8">
				<article itemscope  class="span8" itemtype="http://schema.org/ImageObject">
					<figure>
						<img src="image/<?=$logo?>" alt="<?=$alt_logo?> - <?=$des_logo?>" border="0" width="200" heigth="114" itemprop="contentURL">
					</figure>
					<meta itemprop="datePublished" content="2014-07-06">
					<h1 itemprop="name"><?=$tit_pos?></h1>
					<h2><?=$tit_com?></h2>
					<p itemprop="description"><?=$des_general?></p>

					<div name="tipo" class="span8 tour-tipo">

						<?php
							$formu="top";
							// maximo por pagina
							$limit = 10;

							
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

										ORDER BY promedio DESC
										
										LIMIT $offset, $limit
										";

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
												<img src="image/<?=$logo_pag_tours?>" alt="<?=$alt_logo_pag_tours?> - <?=$des_logo_pag_tours?>" border="0" width="80" heigth="80" class="img-circle" itemprop="contentURL">
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


