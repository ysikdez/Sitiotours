<?php
include ("admin/config.php");
include ("admin/functions.php");

$tip_tab="restaurante";

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

$regrest = $_GET['regrest'];
$pairest = $_GET['pairest'];
$ciurest = $_GET['ciurest'];
$intrest = $_GET['intrest'];

$esprest = $_GET['esprest'];
$tiprest = $_GET['tiprest'];
$ocarest = $_GET['ocarest'];

$desdepla = $_GET['desdepla'];
$hastapla = $_GET['hastapla'];



// Destino
if (($regrest =="Ninguna") AND ($pairest =="Ninguna") AND ($ciurest =="Ninguna") AND ($intrest =="Ninguna")) { 

	$dato_destino = "SELECT id_destino FROM destino";
	$dato_destino = mysql_db_query($dbname, $dato_destino); 
	while ($row = mysql_fetch_array($dato_destino)){ 
		$id_destino = $row["id_destino"];
		$ids_dest = $ids_dest."'".$id_destino."',";
	}
	$destino = substr($ids_dest, 0, -1);

} else {

	if ($regrest !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena
		$dest=$regrest; 
	}
	if ($pairest !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena 
		$dest=$pairest; 
	}
	if ($ciurest !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$dest=$ciurest; 
	}
	if ($intrest !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$dest=$intrest; 
	}


	$ids_pag_dest="'".$dest."',".pagInternas($dbname,$dest);
	$ids_pag_dest = substr($ids_pag_dest, 0, -1);

	$dato_destino = "SELECT id_destino FROM destino WHERE id_pagina IN ($ids_pag_dest)";
	$dato_destino = mysql_db_query($dbname, $dato_destino); 
	while ($row = mysql_fetch_array($dato_destino)){ 
		$id_destino = $row["id_destino"];
		$ids_dest = $ids_dest."'".$id_destino."',";
	}
	$destino = substr($ids_dest, 0, -1);	
}


//Region
if ($regrest!="Ninguna") {
	$dato_key_reg = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$regrest'";
	$dato_key_reg = mysql_db_query($dbname, $dato_key_reg); 
	if ($row = mysql_fetch_array($dato_key_reg)){ $key_reg = $row["tit_pos_pagina"]; }
}

//Pais
if ($pairest!="Ninguna") {
	$dato_key_pais = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$pairest'";
	$dato_key_pais = mysql_db_query($dbname, $dato_key_pais); 
	if ($row = mysql_fetch_array($dato_key_pais)){ $key_pais = $row["tit_pos_pagina"]; }
}

//Ciudad
if ($ciurest!="Ninguna") {
	$dato_key_ciu = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$ciurest'";
	$dato_key_ciu = mysql_db_query($dbname, $dato_key_ciu); 
	if ($row = mysql_fetch_array($dato_key_ciu)){ $key_ciu = $row["tit_pos_pagina"]; }
}

//Interior
if ($intrest!="Ninguna") {
	$dato_key_int = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$intrest'";
	$dato_key_int = mysql_db_query($dbname, $dato_key_int); 
	if ($row = mysql_fetch_array($dato_key_int)){ $key_int = $row["tit_pos_pagina"]; }
}


// Precio del Plato
$min_desde_pla = "SELECT MIN(val_pprecio) FROM pprecio";
$min_desde_pla = mysql_db_query($dbname, $min_desde_pla);
$min_desde_pla = mysql_result($min_desde_pla, 0);

$max_desde_pla = "SELECT MAx(val_pprecio) FROM pprecio";
$max_desde_pla = mysql_db_query($dbname, $max_desde_pla);
$max_desde_pla = mysql_result($max_desde_pla, 0);

	if ($desdepla=="Ninguna") { $desdepla=$min_desde_pla;}
	if ($hastapla=="Ninguna") { $hastapla=$max_desde_pla;}


// Especialidad
if ($esprest =="Ninguna") {

	$dato_esprest = "SELECT DISTINCT id_especialidad FROM especialidad";
	$dato_esprest = mysql_db_query($dbname, $dato_esprest); 
	while ($row = mysql_fetch_array($dato_esprest)){ 
		$id_especialidad = $row["id_especialidad"];
		$esp_rest = $esp_rest."'".$id_especialidad."',";
	}
	$esprest = substr($esp_rest, 0, -1);
	
} 

// Tipo de Restaurante
if ($tiprest =="Ninguna") {

	$dato_tiprest = "SELECT DISTINCT id_tipo FROM tipo";
	$dato_tiprest = mysql_db_query($dbname, $dato_tiprest); 
	while ($row = mysql_fetch_array($dato_tiprest)){ 
		$id_tipo = $row["id_tipo"];
		$tip_rest = $tip_rest."'".$id_tipo."',";
	}
	$tiprest = substr($tip_rest, 0, -1);
}

// Ocasion
if ($ocarest =="Ninguna") {

	$dato_ocarest = "SELECT DISTINCT id_rocasion FROM rocasion";
	$dato_ocarest = mysql_db_query($dbname, $dato_ocarest); 
	while ($row = mysql_fetch_array($dato_ocarest)){ 
		$id_rocasion = $row["id_rocasion"];
		$oca_rest = $oca_rest."'".$id_rocasion."',";
	}
	$ocarest = substr($oca_rest, 0, -1);
}

	$total_rest = "SELECT COUNT(DISTINCT restaurante.id_restaurante) FROM

							(((((restaurante
							LEFT JOIN plato ON restaurante.id_restaurante = plato.id_restaurante)
							LEFT JOIN pprecio ON plato.id_plato = pprecio.id_plato)
							LEFT JOIN restaurante_especialidad ON restaurante.id_restaurante = restaurante_especialidad.id_restaurante)
							LEFT JOIN restaurante_tipo ON restaurante.id_restaurante = restaurante_tipo.id_restaurante)
							LEFT JOIN restaurante_rocasion ON restaurante.id_restaurante = restaurante_rocasion.id_restaurante)

							WHERE

							(((((pprecio.val_pprecio BETWEEN ".$desdepla." AND ".$hastapla.")

							AND
							restaurante_especialidad.id_especialidad IN (".$esprest."))
							AND
							restaurante_tipo.id_tipo IN (".$tiprest."))
							AND
							restaurante_rocasion.id_rocasion IN (".$ocarest."))
							AND
							restaurante.id_destino IN (".$destino."))";

	$total_rest = mysql_db_query($dbname, $total_rest);
	$total_rest = mysql_result($total_rest, 0);


//Pagina
$dato_pagina = "SELECT * FROM pagina WHERE id_pagina='$id'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ 

	$id_idioma = $row["id_idioma"];
}


	$des = "Sitiotours.com Encuentra tus Restaurantes ubicados en el Destino: ".$key_reg." - ".$key_pais." - ".$key_ciu." - ".$key_int.", ";
	$key = "restaurantes,".$key_opc.",".$key_reg.",".$key_pais.",".$key_ciu.", ".$key_int;
	$tit = "Encuentra tu Restaurante";

	if ($total_rest=="0") {
		$tit_pos = "No se Ubico tu Restaurante";
		$tit_com = $total_rest." Restaurantes de tu preferencia";
		$des_pag = "Has Otra Selección";
	} else{
		
		$tit_pos = "Encontramos tu Restaurante";
		$tit_com = $total_rest." Restaurantes de tu preferencia";
		$des_pag = "En Sitiotours.com Encontramos ".$total_rest." de tus Restaurantes ubicados con el Destino ".$key_reg." - ".$key_pais." - ".$key_ciu." - ".$key_int.", ";
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
					<h1 itemprop="name"><span class="icon-restaurante ico-car"></span> <?=$tit_pos?></h1>
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

					$sql = "SELECT SQL_CALC_FOUND_ROWS 
											DISTINCT
											restaurante.id_pagina,
											restaurante.id_restaurante,
											restaurante.cat_restaurante
											
											FROM 
											(((((restaurante
											LEFT JOIN plato ON restaurante.id_restaurante = plato.id_restaurante)
											LEFT JOIN pprecio ON plato.id_plato = pprecio.id_plato)
											LEFT JOIN restaurante_especialidad ON restaurante.id_restaurante = restaurante_especialidad.id_restaurante)
											LEFT JOIN restaurante_tipo ON restaurante.id_restaurante = restaurante_tipo.id_restaurante)
											LEFT JOIN restaurante_rocasion ON restaurante.id_restaurante = restaurante_rocasion.id_restaurante)

											WHERE

											(((((pprecio.val_pprecio BETWEEN ".$desdepla." AND ".$hastapla.")

											AND
											restaurante_especialidad.id_especialidad IN (".$esprest."))
											AND
											restaurante_tipo.id_tipo IN (".$tiprest."))
											AND
											restaurante_rocasion.id_rocasion IN (".$ocarest."))
											AND
											restaurante.id_destino IN (".$destino."))

											LIMIT $offset, $limit";

					$sqlTotal = "SELECT FOUND_ROWS() as total";

					$rs = mysql_query($sql);
					$rsTotal = mysql_query($sqlTotal);

					$rowTotal = mysql_fetch_assoc($rsTotal);
					// Total de registros sin limit
					$total = $rowTotal["total"];

					while ($row = mysql_fetch_assoc($rs)){ 

						$id_pag_rest = $row["id_pagina"];
						$id_restaurante = $row["id_restaurante"];
						$cat_restaurante = $row["cat_restaurante"];

						

						$dato_pag_rest = "SELECT * FROM pagina WHERE id_pagina=$id_pag_rest";
						$dato_pag_rest = mysql_db_query($dbname, $dato_pag_rest); 
						if ($row = mysql_fetch_array($dato_pag_rest)){ 
							$tit_pos_pag_rest = $row["tit_pos_pagina"];
							$des_pag_rest = $row["des_pagina"];
							$url_pag_rest = $row["url_pagina"];
						}

						?>

						<article class="span4" itemscope itemtype="http://schema.org/ImageObject">
							<a href="/restaurantes/<?=$url_pag_rest?>">
								<h3 itemprop="name"><?=$tit_pos_pag_rest?></h3>
								
								<figure>
									<img src="image/<?=$logo_int?>" alt="<?=$alt_logo_int?> - <?=$des_logo_int?>" border="0" width="111" heigth="111" class="img-circle pull-left" itemprop="contentURL">
								</figure>
								<meta itemprop="datePublished" content="2014-07-06">
								<h4 itemprop="name">(<?=$cat_restaurante?> tenedores)</h4>
							</a>
														
							<p itemprop="description"><?=$des_pag_rest?></p>
							<a  href="/tour/<?=$url_pag_rest?>" class="btn btn-sitio span3 btn-filtro">
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

						for( $i=1; $i<=$totalPag ; $i++){
							if ($pag==$i) { $on="class='active'"; } else { $on=""; }
							$n=$i;

							$links[] = "<li ".$on."><a href=\"?regrest=$regrest&pairest=$pairest&ciurest=$ciurest&intrest=$intrest&tipoaloja=$tipoaloja&catealoja=$catealoja&tiphab=$tiphab&desdehab=$desdehab&hastahab=$hastahab&pag=$i\">$n</a></li>"; 
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

								$links[] = "<li ".$on."><a href=\"?regrest=$regrest&pairest=$pairest&ciurest=$ciurest&intrest=$intrest&tipoaloja=$tipoaloja&catealoja=$catealoja&tiphab=$tiphab&desdehab=$desdehab&hastahab=$hastahab&pag=$i\">$n</a></li>"; 
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


