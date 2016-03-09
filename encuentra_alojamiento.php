<?php
include ("admin/config.php");
include ("admin/functions.php");

$tip_tab="alojamiento";

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

$regaloja=$_GET["regaloja"];
$paialoja=$_GET["paialoja"];
$ciualoja=$_GET["ciualoja"];
$intaloja=$_GET["intaloja"];

$tipoaloja=$_GET["tipoaloja"];
$catealoja=$_GET["catealoja"];
$tiphab=$_GET["tiphab"];

$desdehab=$_GET["desdehab"];
$hastahab=$_GET["hastahab"];



// Destino
if (($regaloja =="Ninguna") AND ($paialoja =="Ninguna") AND ($ciualoja =="Ninguna") AND ($intaloja =="Ninguna")) { 

	$dato_destino = "SELECT id_destino FROM destino";
	$dato_destino = mysql_db_query($dbname, $dato_destino); 
	while ($row = mysql_fetch_array($dato_destino)){ 
		$id_destino = $row["id_destino"];
		$ids_dest = $ids_dest."'".$id_destino."',";
	}
	$destino = substr($ids_dest, 0, -1);

} else {

	if ($regaloja !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena
		$dest=$regaloja; 
	}
	if ($paialoja !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena 
		$dest=$paialoja; 
	}
	if ($ciualoja !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$dest=$ciualoja; 
	}
	if ($intaloja !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$dest=$intaloja; 
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
if ($regaloja!="Ninguna") {
	$dato_key_reg = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$regaloja'";
	$dato_key_reg = mysql_db_query($dbname, $dato_key_reg); 
	if ($row = mysql_fetch_array($dato_key_reg)){ $key_reg = $row["tit_pos_pagina"]; }
}

//Pais
if ($paialoja!="Ninguna") {
	$dato_key_pais = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$paialoja'";
	$dato_key_pais = mysql_db_query($dbname, $dato_key_pais); 
	if ($row = mysql_fetch_array($dato_key_pais)){ $key_pais = $row["tit_pos_pagina"]; }
}

//Ciudad
if ($ciualoja!="Ninguna") {
	$dato_key_ciu = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$ciualoja'";
	$dato_key_ciu = mysql_db_query($dbname, $dato_key_ciu); 
	if ($row = mysql_fetch_array($dato_key_ciu)){ $key_ciu = $row["tit_pos_pagina"]; }
}

//Interior
if ($intaloja!="Ninguna") {
	$dato_key_int = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$intaloja'";
	$dato_key_int = mysql_db_query($dbname, $dato_key_int); 
	if ($row = mysql_fetch_array($dato_key_int)){ $key_int = $row["tit_pos_pagina"]; }
}


// Precio de la Habitacion
$min_desde_hab = "SELECT MIN(val_hprecio) FROM hprecio";
$min_desde_hab = mysql_db_query($dbname, $min_desde_hab);
$min_desde_hab = mysql_result($min_desde_hab, 0);

$max_desde_hab = "SELECT MAx(val_hprecio) FROM hprecio";
$max_desde_hab = mysql_db_query($dbname, $max_desde_hab);
$max_desde_hab = mysql_result($max_desde_hab, 0);

	if ($desdehab=="Ninguna") { $desdehab=$min_desde_hab;}
	if ($hastahab=="Ninguna") { $hastahab=$max_desde_hab;}

// Tipo de Alojamiento
if ($tipoaloja =="Ninguna") {

	$dato_tipoaloja = "SELECT DISTINCT tipo_alojamiento FROM alojamiento";
	$dato_tipoaloja = mysql_db_query($dbname, $dato_tipoaloja); 
	while ($row = mysql_fetch_array($dato_tipoaloja)){ 
		$tipo_alojamiento = $row["tipo_alojamiento"];
		$tipo_aloja = $tipo_aloja."'".$tipo_alojamiento."',";
	}
	$tipoaloja = substr($tipo_aloja, 0, -1);
	
} else { $tipoaloja ="'".$tipoaloja."'";}

// Categoria de Alojamiento
if ($catealoja =="Ninguna") {

	$dato_catealoja = "SELECT DISTINCT cat_alojamiento FROM alojamiento";
	$dato_catealoja = mysql_db_query($dbname, $dato_catealoja); 
	while ($row = mysql_fetch_array($dato_catealoja)){ 
		$cat_alojamiento = $row["cat_alojamiento"];
		$cate_aloja = $cate_aloja."'".$cat_alojamiento."',";
	}
	$catealoja = substr($cate_aloja, 0, -1);
}

// Tipo de Habitacion
if ($tiphab =="Ninguna") {

	$dato_tiphab = "SELECT DISTINCT tip_habitacion FROM habitacion";
	$dato_tiphab = mysql_db_query($dbname, $dato_tiphab); 
	while ($row = mysql_fetch_array($dato_tiphab)){ 
		$tip_habitacion = $row["tip_habitacion"];
		$tip_hab = $tip_hab."'".$tip_habitacion."',";
	}
	$tiphab = substr($tip_hab, 0, -1);
}else { $tiphab ="'".$tiphab."'";}

	$total_aloja = "SELECT COUNT(DISTINCT alojamiento.id_alojamiento) FROM

							((alojamiento LEFT JOIN habitacion ON alojamiento.id_alojamiento = habitacion.id_alojamiento)
							LEFT JOIN hprecio ON habitacion.id_habitacion=hprecio.id_habitacion)

							WHERE
							(((((hprecio.val_hprecio BETWEEN ".$desdehab." AND ".$hastahab.")
							AND
							
							alojamiento.tipo_alojamiento IN (".$tipoaloja."))

							AND
							alojamiento.cat_alojamiento IN (".$catealoja."))
							AND
							habitacion.tip_habitacion IN (".$tiphab."))
							AND
							alojamiento.id_destino IN (".$destino."))";

	$total_aloja = mysql_db_query($dbname, $total_aloja);
	$total_aloja = mysql_result($total_aloja, 0);


//Pagina
$dato_pagina = "SELECT * FROM pagina WHERE id_pagina='$id'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ 

	$id_idioma = $row["id_idioma"];
}


	$des = "Sitiotours.com Encuentra tus Alojamientos ubicados en el Destino: ".$key_reg." - ".$key_pais." - ".$key_ciu." - ".$key_int.", ";
	$key = "alojamientos,hoteles,".$key_opc.",".$key_reg.",".$key_pais.",".$key_ciu.", ".$key_int;
	$tit = "Encuentra tu Alojamiento";

	if ($total_aloja=="0") {
		$tit_pos = "No se Ubico tu Alojamiento";
		$tit_com = $total_aloja." Alojamientos de tu preferencia";
		$des_pag = "Has Otra Selección";
	} else{
		
		$tit_pos = "Encontramos tu Alojamiento";
		$tit_com = $total_aloja." Alojamientos de tu preferencia";
		$des_pag = "En Sitiotours.com Encontramos ".$total_aloja." de tus Alojamientos ubicados con el Destino ".$key_reg." - ".$key_pais." - ".$key_ciu." - ".$key_int.", ";
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

		<section class="container marketing top-margen">
			<div class="row">
				<?php
					include ("filtro.php");
				?>

				<article class="span8" itemscope itemtype="http://schema.org/ImageObject">
					<figure>
						<img src="image/<?=$url?>" alt="<?=$url?> - <?=$url?>" border="0" width="200" heigth="114" itemprop="contentURL">
					</figure>
					<meta itemprop="datePublished" content="2014-07-06">
					<h1 itemprop="name"><span class="icon-hotel ico-car"></span> <?=$tit_pos?></h1>
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
											alojamiento.id_pagina,
											alojamiento.id_alojamiento,
											alojamiento.tipo_alojamiento,
											alojamiento.cat_alojamiento
											
											FROM 
											((alojamiento LEFT JOIN habitacion ON alojamiento.id_alojamiento = habitacion.id_alojamiento)
											LEFT JOIN hprecio ON habitacion.id_habitacion=hprecio.id_habitacion)

											WHERE
											(((((hprecio.val_hprecio BETWEEN ".$desdehab." AND ".$hastahab.")
											AND
											
											alojamiento.tipo_alojamiento IN (".$tipoaloja."))

											AND
											alojamiento.cat_alojamiento IN (".$catealoja."))
											AND
											habitacion.tip_habitacion IN (".$tiphab."))
											AND
											alojamiento.id_destino IN (".$destino."))

											LIMIT $offset, $limit";

					$sqlTotal = "SELECT FOUND_ROWS() as total";

					$rs = mysql_query($sql);
					$rsTotal = mysql_query($sqlTotal);

					$rowTotal = mysql_fetch_assoc($rsTotal);
					// Total de registros sin limit
					$total = $rowTotal["total"];

					while ($row = mysql_fetch_assoc($rs)){ 

						$id_pag_aloja = $row["id_pagina"];
						$id_alojamiento = $row["id_alojamiento"];
						$tip_alojamiento = $row["tip_alojamiento"];
						$cat_alojamiento = $row["cat_alojamiento"];
						

						$dato_pag_aloja = "SELECT * FROM pagina WHERE id_pagina=$id_pag_aloja";
						$dato_pag_aloja = mysql_db_query($dbname, $dato_pag_aloja); 
						if ($row = mysql_fetch_array($dato_pag_aloja)){ 
							$tit_pos_pag_aloja = $row["tit_pos_pagina"];
							$des_pag_aloja = $row["des_pagina"];
							$url_pag_aloja = $row["url_pagina"];
						}

						?>

						<article class="span4" itemscope itemtype="http://schema.org/ImageObject">
							<a href="/alojamientos-hoteles/<?=$url_pag_aloja?>">
								<h3 itemprop="name"><?=$tit_pos_pag_aloja?></h3>
								
								<figure>
									<img src="image/<?=$logo_int?>" alt="<?=$alt_logo_int?> - <?=$des_logo_int?>" border="0" width="111" heigth="111" class="img-circle pull-left" itemprop="contentURL">
								</figure>
								<meta itemprop="datePublished" content="2014-07-06">
								<h4 itemprop="name">(<?=$tipo_alojamiento?> / <?=$cat_alojamiento?> estrellas)</h4>
							</a>
														
							<p itemprop="description"><?=$des_pag_aloja?></p>
							<a  href="/tour/<?=$url_pag_aloja?>" class="btn btn-sitio span3 btn-filtro">
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

							$links[] = "<li ".$on."><a href=\"?regaloja=$regaloja&paialoja=$paialoja&ciualoja=$ciualoja&intaloja=$intaloja&tipoaloja=$tipoaloja&catealoja=$catealoja&tiphab=$tiphab&desdehab=$desdehab&hastahab=$hastahab&pag=$i\">$n</a></li>"; 
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

								$links[] = "<li ".$on."><a href=\"?regaloja=$regaloja&paialoja=$paialoja&ciualoja=$ciualoja&intaloja=$intaloja&tipoaloja=$tipoaloja&catealoja=$catealoja&tiphab=$tiphab&desdehab=$desdehab&hastahab=$hastahab&pag=$i\">$n</a></li>"; 
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


