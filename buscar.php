<?php
include ("admin/config.php");
include ("admin/functions.php");


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

$buscar = $_GET['buscar'];

	$total_bus = "SELECT COUNT(pagina.id_pagina) FROM
							((((((((((((pagina
							LEFT JOIN tour ON pagina.id_pagina = tour.id_pagina)
							LEFT JOIN destino ON pagina.id_pagina = destino.id_pagina)
							LEFT JOIN opcion ON pagina.id_pagina = opcion.id_pagina)
							LEFT JOIN agencia ON pagina.id_pagina = agencia.id_pagina)
							LEFT JOIN alojamiento ON pagina.id_pagina = alojamiento.id_pagina)
							LEFT JOIN restaurante ON pagina.id_pagina = restaurante.id_pagina)
							LEFT JOIN tienda ON pagina.id_pagina = tienda.id_pagina)
							LEFT JOIN souvenir ON pagina.id_pagina = souvenir.id_pagina)
							LEFT JOIN tipica ON pagina.id_pagina = tipica.id_pagina)
							LEFT JOIN sitio ON pagina.id_pagina = sitio.id_pagina)
							LEFT JOIN actividad ON pagina.id_pagina = actividad.id_pagina)
							LEFT JOIN tic ON pagina.id_pagina = tic.id_pagina)

							WHERE

							pagina.tit_pos_pagina LIKE '%".$buscar."%' OR

							pagina.tit_com_pagina LIKE '%".$buscar."%' OR

							tour.tipo_tour LIKE '%".$buscar."%' OR

							tour.des_tour LIKE '%".$buscar."%' OR

							destino.des_destino LIKE '%".$buscar."%' OR

							opcion.des_opcion LIKE '%".$buscar."%' OR

							agencia.des_agencia LIKE '%".$buscar."%' OR

							alojamiento.tipo_alojamiento LIKE '%".$buscar."%' OR

							alojamiento.des_alojamiento LIKE '%".$buscar."%' OR

							restaurante.des_restaurante LIKE '%".$buscar."%' OR

							tienda.des_tienda LIKE '%".$buscar."%' OR

							souvenir.des_souvenir LIKE '%".$buscar."%' OR

							tipica.des_tipica LIKE '%".$buscar."%' OR

							sitio.des_sitio LIKE '%".$buscar."%' OR

							tic.nick_tic LIKE '%".$buscar."%' OR

							tic.des_tic LIKE '%".$buscar."%'";

	$total_bus = mysql_db_query($dbname, $total_bus);
	$total_bus = mysql_result($total_bus, 0);



	$des = "Sitiotours.com Encuentra tus Busquedas";
	$key = "busquedas,tour,";
	$tit = "Encuentra lo que Buscas";

	if ($total_bus=="0") {
		$tit_pos = "No se Ubico tu Busqueda ".$buscar." ";
		$tit_com = $total_bus." Busquedas de tu preferencia: ".$buscar." ";
		$des_pag = "Has Otra Busqueda";
	} else{
		
		$tit_pos = "Encontramos tu Busqueda ".$buscar." ";
		$tit_com = $total_bus." Busquedas de tu preferencia: ".$buscar." ";
		$des_pag = "En <a href=".'/'.">Sitiotours.com</a> Encontramos ".$total_bus." de tus Busquedas";
	}

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

		<section class="container marketing">
			<div class="row">
				<?php
					include ("filtro.php");
				?>

				<?php

					// maximo por pagina
					$limit = 5;

					// pagina pedida
					$pag = (int) $_GET["pag"];
					if ($pag < 1)
					{
					   $pag = 1;
					}
					$offset = ($pag-1) * $limit;

					$sql = "SELECT SQL_CALC_FOUND_ROWS 
											DISTINCT
											pagina.id_pagina
											
											FROM 
											((((((((((((pagina
											LEFT JOIN tour ON pagina.id_pagina = tour.id_pagina)
											LEFT JOIN destino ON pagina.id_pagina = destino.id_pagina)
											LEFT JOIN opcion ON pagina.id_pagina = opcion.id_pagina)
											LEFT JOIN agencia ON pagina.id_pagina = agencia.id_pagina)
											LEFT JOIN alojamiento ON pagina.id_pagina = alojamiento.id_pagina)
											LEFT JOIN restaurante ON pagina.id_pagina = restaurante.id_pagina)
											LEFT JOIN tienda ON pagina.id_pagina = tienda.id_pagina)
											LEFT JOIN souvenir ON pagina.id_pagina = souvenir.id_pagina)
											LEFT JOIN tipica ON pagina.id_pagina = tipica.id_pagina)
											LEFT JOIN sitio ON pagina.id_pagina = sitio.id_pagina)
											LEFT JOIN actividad ON pagina.id_pagina = actividad.id_pagina)
											LEFT JOIN tic ON pagina.id_pagina = tic.id_pagina)

											WHERE

											pagina.tit_pos_pagina LIKE '%".$buscar."%' OR

											pagina.tit_com_pagina LIKE '%".$buscar."%' OR

											tour.tipo_tour LIKE '%".$buscar."%' OR

											tour.des_tour LIKE '%".$buscar."%' OR

											destino.des_destino LIKE '%".$buscar."%' OR

											opcion.des_opcion LIKE '%".$buscar."%' OR

											agencia.des_agencia LIKE '%".$buscar."%' OR

											alojamiento.tipo_alojamiento LIKE '%".$buscar."%' OR

											alojamiento.des_alojamiento LIKE '%".$buscar."%' OR

											restaurante.des_restaurante LIKE '%".$buscar."%' OR

											tienda.des_tienda LIKE '%".$buscar."%' OR

											souvenir.des_souvenir LIKE '%".$buscar."%' OR

											tipica.des_tipica LIKE '%".$buscar."%' OR

											sitio.des_sitio LIKE '%".$buscar."%' OR

											tic.nick_tic LIKE '%".$buscar."%' OR

											tic.des_tic LIKE '%".$buscar."%'

											LIMIT $offset, $limit";

					$sqlTotal = "SELECT FOUND_ROWS() as total";

					$rs = mysql_query($sql);
					$rsTotal = mysql_query($sqlTotal);

					$rowTotal = mysql_fetch_assoc($rsTotal);
					// Total de registros sin limit
					$total = $rowTotal["total"];
				?>

				<article class="span8" itemscope itemtype="http://schema.org/ImageObject">
					<figure>
						<img src="image/<?=$url?>" alt="<?=$url?> - <?=$url?>" border="0" width="200" heigth="114" itemprop="contentURL">
					</figure>
					<meta itemprop="datePublished" content="2014-07-06">
					<h1 itemprop="name"><?=$tit_pos?></h1>
					<h2><?=$tit_com?></h2>
					<p itemprop="description"><?=$des_pag?></p><br>
					<p class="text-center">
						Se ubican en <?=$total?> Paginas
					</p>
				</article>


				<?php
					while ($row = mysql_fetch_assoc($rs)){ 

						$id_pag = $row["id_pagina"];						

						$dato_pag = "SELECT * FROM pagina WHERE id_pagina=$id_pag";
						$dato_pag = mysql_db_query($dbname, $dato_pag); 
						if ($row = mysql_fetch_array($dato_pag)){ 
							$tit_pos_pag = $row["tit_pos_pagina"];
							$des_pag = $row["des_pagina"];

						}
						$url_pag = pagUrl($dbname,$id_pag);$pagurl="";
						$url_pag = substr($url_pag, 0, -1);

						?>

						<article class="span4 text-left">
							<h3 itemprop="name" class="text-left">
							<a href="/<?=$url_pag?>"><?=$tit_pos_pag?></a>
							</h3>											
							<p itemprop="description"  class="text-left"><?=$des_pag?></p>
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

						for( $i=1; $i<=$totalPag ; $i++){
							if ($pag==$i) { $on="class='active'"; } else { $on=""; }
							$n=$i;

							$links[] = "<li ".$on."><a href=\"?buscar=$buscar&pag=$i\">$n</a></li>"; 
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

							for( $i=$ini; $i<=$fin ; $i++){	
								$n=$i; 
								if ($pag==$i) { $on="class='active'"; } else { $on=""; }
								if ($ini==$i && $i!=1) { $n="«"; } 
								if ($fin==$i && $i!=$totalPag) { $n="»"; }

								$links[] = "<li ".$on."><a href=\"?buscar=$buscar&pag=$i\">$n</a></li>"; 
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


