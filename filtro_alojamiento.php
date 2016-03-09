<?php 

include ("admin/config.php");
include ("admin/functions.php");

$regaloja = $_GET['regaloja'];
$paialoja = $_GET['paialoja'];
$ciualoja = $_GET['ciualoja'];
$intaloja = $_GET['intaloja'];

$tipoaloja = $_GET['tipoaloja'];
$catealoja = $_GET['catealoja'];
$tiphab = $_GET['tiphab'];

$desdehab = $_GET['desdehab'];
$hastahab = $_GET['hastahab'];


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

// Precio del Habitacion
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

	$total_aloja = mysql_db_query($dbname, $total_aloja) or die(mysql_error());
	$total_aloja = mysql_result($total_aloja, 0);
?>
	<?=$total_aloja?>
<?php

?>

			