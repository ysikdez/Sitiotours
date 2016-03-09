<?php 

include ("admin/config.php");
include ("admin/functions.php");

$regtien = $_GET['regtien'];
$paitien = $_GET['paitien'];
$ciutien = $_GET['ciutien'];
$inttien = $_GET['inttien'];

$cattien = $_GET['cattien'];

$desdetien = $_GET['desdetien'];
$hastatien = $_GET['hastatien'];


// Destino
if (($regtien =="Ninguna") AND ($paitien =="Ninguna") AND ($ciutien =="Ninguna") AND ($inttien =="Ninguna")) { 

	$dato_destino = "SELECT id_destino FROM destino";
	$dato_destino = mysql_db_query($dbname, $dato_destino); 
	while ($row = mysql_fetch_array($dato_destino)){ 
		$id_destino = $row["id_destino"];
		$ids_dest = $ids_dest."'".$id_destino."',";
	}
	$destino = substr($ids_dest, 0, -1);

} else {

	if ($regtien !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena
		$dest=$regtien; 
	}
	if ($paitien !="Ninguna") {
		$ids_dest = "";//Inicializa la cadena 
		$dest=$paitien; 
	}
	if ($ciutien !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$dest=$ciutien; 
	}
	if ($inttien !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$dest=$inttien; 
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

// Precio del Articulo
$min_desde_tien = "SELECT MIN(val_aprecio) FROM aprecio";
$min_desde_tien = mysql_db_query($dbname, $min_desde_tien);
$min_desde_tien = mysql_result($min_desde_tien, 0);

$max_desde_tien = "SELECT MAx(val_aprecio) FROM aprecio";
$max_desde_tien = mysql_db_query($dbname, $max_desde_tien);
$max_desde_tien = mysql_result($max_desde_tien, 0);

	if ($desdetien=="Ninguna") { $desdetien=$min_desde_tien;}
	if ($hastatien=="Ninguna") { $hastatien=$max_desde_tien;}

// Categoria del Articulo
if ($cattien =="Ninguna") {

	$dato_cattien = "SELECT DISTINCT id_categoria FROM categoria";
	$dato_cattien = mysql_db_query($dbname, $dato_cattien); 
	while ($row = mysql_fetch_array($dato_cattien)){ 
		$id_categoria = $row["id_categoria"];
		$esp_rest = $esp_rest."'".$id_categoria."',";
	}
	$cattien = substr($esp_rest, 0, -1);
	
} 


	$total_tien = "SELECT COUNT(DISTINCT tienda.id_tienda) FROM

							(((tienda
							LEFT JOIN articulo ON tienda.id_tienda = articulo.id_tienda)
							LEFT JOIN aprecio ON articulo.id_articulo = aprecio.id_articulo)
							LEFT JOIN articulo_categoria ON articulo.id_articulo = articulo_categoria.id_articulo)

							WHERE

							(((aprecio.val_aprecio BETWEEN ".$desdetien." AND ".$hastatien.")

							AND
							articulo_categoria.id_categoria IN (".$cattien."))

							AND
							tienda.id_destino IN (".$destino."))";

	$total_tien = mysql_db_query($dbname, $total_tien) or die(mysql_error());
	$total_tien = mysql_result($total_tien, 0);
?>
	<?=$total_tien?>
<?php

?>

			