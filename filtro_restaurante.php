<?php 

include ("admin/config.php");
include ("admin/functions.php");

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
// else { $esprest ="'".$esprest."'";}

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
// else { $ocarest ="'".$ocarest."'";}


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

	$total_rest = mysql_db_query($dbname, $total_rest) or die(mysql_error());
	$total_rest = mysql_result($total_rest, 0);
?>
	<?=$total_rest?>
<?php

?>

			