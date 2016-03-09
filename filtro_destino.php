<?php 

include ("admin/config.php");
include ("admin/functions.php");



$region = $_GET['region'];
$pais = $_GET['pais'];
$ciudad = $_GET['ciudad'];


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
	$total_destino = mysql_db_query($dbname, $total_destino) or die(mysql_error());
	$total_destino = mysql_result($total_destino, 0);
	
}


?>
	<?=$total_destino?>
<?php

?>

			