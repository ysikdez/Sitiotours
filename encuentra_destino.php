<?php
include ("admin/config.php");
include ("admin/functions.php");

$tip_tab="destino";

// $_SESSION['URL'] = "http://".$SERVER_NAME.$PHP_SELF."?".$QUERY_STRING; 
session_start();
if(isset($_SESSION['carro'])){$carro=$_SESSION['carro'];}else{ $carro=false; }

$id=0;


//Configuracion
$dato_config = "SELECT * FROM site WHERE id_site='1'";
$dato_config = mysql_db_query($dbname, $dato_config); 
if ($row = mysql_fetch_array($dato_config)){ 

	$url = $row["url_site"];
	$mail = $row["mail_site"];
	$auto = $row["auto_site"];
	$copy = $row["copy_site"];

}

$region=$_GET["region"];
$pais=$_GET["pais"];
$ciudad=$_GET["ciudad"];


// Destino
if (($region =="Ninguna") AND ($pais =="Ninguna") AND ($ciudad =="Ninguna")) { 

	$total_destino = "SELECT COUNT(DISTINCT id_destino) FROM destino";
	$total_destino = mysql_db_query($dbname, $total_destino);
	$total_destino = mysql_result($total_destino, 0);

} else {

	if ($region !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena
		$destino=$region; 
	}
	if ($pais !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena 
		$destino=$pais; 
	}
	if ($ciudad !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$destino=$ciudad; 
	}


	$ids_pag_dest="'".$destino."',".pagInternas($dbname,$destino);
	$ids_pag_dest = substr($ids_pag_dest, 0, -1);

	$dato_destino = "SELECT id_destino FROM destino WHERE id_pagina IN ($ids_pag_dest)";
	$dato_destino = mysql_db_query($dbname, $dato_destino); 
	while ($row = mysql_fetch_array($dato_destino)){ 
		$id_destino = $row["id_destino"];
		$ids_dest = $ids_dest."'".$id_destino."',";
	}
	$ids_dest = substr($ids_dest, 0, -1);	

	$total_destino = "SELECT COUNT(DISTINCT id_destino) FROM destino WHERE id_destino IN ($ids_dest)";
	$total_destino = mysql_db_query($dbname, $total_destino);
	$total_destino = mysql_result($total_destino, 0);	
}


//Region
if ($region!="Ninguna") {
	$dato_key_reg = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$region'";
	$dato_key_reg = mysql_db_query($dbname, $dato_key_reg); 
	if ($row = mysql_fetch_array($dato_key_reg)){ $key_reg = $row["tit_pos_pagina"]; }
}

//Pais
if ($pais!="Ninguna") {
	$dato_key_pais = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$pais'";
	$dato_key_pais = mysql_db_query($dbname, $dato_key_pais); 
	if ($row = mysql_fetch_array($dato_key_pais)){ $key_pais = $row["tit_pos_pagina"]; }
}

//Ciudad
if ($ciudad!="Ninguna") {
	$dato_key_ciu = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$ciudad'";
	$dato_key_ciu = mysql_db_query($dbname, $dato_key_ciu); 
	if ($row = mysql_fetch_array($dato_key_ciu)){ $key_ciu = $row["tit_pos_pagina"]; }
}


//Pagina
$dato_pagina = "SELECT * FROM pagina WHERE id_pagina='$id'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ 

	$id_idioma = $row["id_idioma"];
}


	$des = "Sitiotours.com Encuentra tu Destino: ".$key_reg." - ".$key_pais." - ".$key_ciu." ";
	$key = "tour,".$key_reg.",".$key_pais.",".$key_ciut;
	$tit = "Encuentra tu Destino";

	$tit_pos = "Encontramos tus Destinos";
	$tit_com = $total_destino." Destinos de tu preferencia";
	$des_pag = "En Sitiotours.com Encontramos ".$total_destino." de tus Destinos Turisticos ".$key_reg." - ".$key_pais." - ".$key_ciu.", los que te encantaria visitar";


//idioma
$dato_pagina = "SELECT * FROM idioma WHERE id_idioma='$id_idioma'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ $abre = $row["abre_idioma"];}

?>
<!DOCTYPE html>
<html lang="<?=$abre?>">
	<head>
		<base href="" />
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
		<meta name="keywords" content="<?=$key?>,sitiotours" />
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

		<section class="container marketing  top-margen">
			<div class="row">
				<?php
					include ("filtro.php");
				?>

				<article class="span8" itemscope itemtype="http://schema.org/ImageObject">
					<figure>
						<img src="image/<?=$url?>" alt="<?=$url?> - <?=$url?>" border="0" width="200" heigth="114" itemprop="contentURL">
					</figure>
					<meta itemprop="datePublished" content="2014-07-06">
					<h1 itemprop="name"><span class="icon-destino ico-car"></span> <?=$tit_pos?></h1>
					<h2><?=$tit_com?></h2>
					<p itemprop="description"><?=$des_pag?></p><br>
					<p class="text-center">
					</p>
				</article>

				<?php

					// maximo por pagina
					$limit = 10;

					// pagina pedida
					$pag = (int) $_GET["pag"];
					if ($pag < 1)
					{
					   $pag = 1;
					}
					$offset = ($pag-1) * $limit;

					if (($region =="Ninguna") AND ($pais =="Ninguna") AND ($ciudad =="Ninguna")) { 
							$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT id_destino FROM destino LIMIT $offset, $limit";

					} else{

						$sql = "SELECT SQL_CALC_FOUND_ROWS 

												DISTINCT

												id_destino

												FROM destino 

												WHERE id_destino IN ($ids_dest)

												LIMIT $offset, $limit";
						
					}

					$sqlTotal = "SELECT FOUND_ROWS() as total";

					$rs = mysql_query($sql);
					$rsTotal = mysql_query($sqlTotal);

					$rowTotal = mysql_fetch_assoc($rsTotal);
					// Total de registros sin limit
					$total = $rowTotal["total"];

					while ($row = mysql_fetch_assoc($rs)){ 

						$id_destino = $row["id_destino"];
						$id_pag_destino = $row["id_pagina"];

						$dato_pag_tour = "SELECT 
											DISTINCT pagina.id_pagina, pagina.tit_pos_pagina, pagina.url_pagina
											FROM

											pagina INNER JOIN destino ON pagina.id_pagina = destino.id_pagina
											WHERE id_destino=$id_destino";

						$dato_pag_tour = mysql_db_query($dbname, $dato_pag_tour); 
						if ($row = mysql_fetch_array($dato_pag_tour)){ 
							$tit_pos_pag_dest = $row["tit_pos_pagina"];
							$des_pag_dest = $row["des_pagina"];
							$url_pag_dest = $row["url_pagina"];
						}
						?>

						<article class="span4" itemscope itemtype="http://schema.org/ImageObject">
							<a href="/destinos/<?=$url_pag_dest?>">
								<h3 itemprop="name"><?=$tit_pos_pag_dest?></h3>
								
								<figure>
									<img src="image/<?=$logo_int?>" alt="<?=$alt_logo_int?> - <?=$des_logo_int?>" border="0" width="111" heigth="111" class="img-circle pull-left" itemprop="contentURL">
								</figure>
								<meta itemprop="datePublished" content="2014-07-06">
							</a>
														
							<p itemprop="description"><?=$des_pag_dest?></p>
							<a  href="/destinos/<?=$url_pag_dest?>" class="btn btn-sitio span3 btn-filtro">
								<h3><i class="icon-favorito pull-left"></i></h3> <strong>Agregalo a tus Favoritos</strong>
							</a>
							
						</article>
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

							$links[] = "<li ".$on."><a href=\"?region=$region&pais=$pais&ciudad=$ciudad&pag=$i\">$n</a></li>"; 
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

							$links[] = "<li ".$on."><a href=\"?region=$region&pais=$pais&ciudad=$ciudad&pag=$i\">$n</a></li>"; 
						}

					}

					echo implode(" ", $links);
				?>
		  				</ul>
					</div>

				<br>
				


			</div>
		</section>		

				<?php
					include ("footer.php");
				?>


	</body>
</html>


