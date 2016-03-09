<?php 

include ("admin/config.php");
include ("admin/functions.php");


$opcion = $_GET['opcion'];
$region = $_GET['region'];
$pais = $_GET['pais'];
$ciudad = $_GET['ciudad'];
$interior = $_GET['interior'];
$duracion = $_GET['duracion'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

// Opcion
if ($opcion =="Ninguna") {

	$dato_opcion = "SELECT id_opcion FROM opcion";
	$dato_opcion = mysql_db_query($dbname, $dato_opcion); 
	while ($row = mysql_fetch_array($dato_opcion)){ 
		$id_opcion = $row["id_opcion"];
		$ids_opc = $ids_opc."'".$id_opcion."',";
	}
	$ids_opc = substr($ids_opc, 0, -1);
	
} else {

	$dato_opcion = "SELECT id_opcion FROM opcion WHERE id_pagina='$opcion'";
	$dato_opcion = mysql_db_query($dbname, $dato_opcion); 
	if ($row = mysql_fetch_array($dato_opcion)){ 
		$id_opcion = $row["id_opcion"];
		$ids_opc = $id_opcion;
	}
}

// $total_tour = "SELECT COUNT(DISTINCT id_tour) FROM tour_opcion WHERE id_opcion IN ($ids_opc)";
// $total_tour = mysql_db_query($dbname, $total_tour);
// $total_tour = mysql_result($total_tour, 0);

// Destino
if (($region =="Ninguna") AND ($pais =="Ninguna") AND ($ciudad =="Ninguna") AND ($interior =="Ninguna")) { 

	$dato_destino = "SELECT id_destino FROM destino";
	$dato_destino = mysql_db_query($dbname, $dato_destino); 
	while ($row = mysql_fetch_array($dato_destino)){ 
		$id_destino = $row["id_destino"];
		$ids_dest = $ids_dest."'".$id_destino."',";
	}
	$ids_dest = substr($ids_dest, 0, -1);

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
	if ($interior !="Ninguna") { 
		$ids_dest = "";//Inicializa la cadena
		$destino=$interior; 
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
}

	// $total_destino = "SELECT COUNT(DISTINCT id_tour) FROM tour_destino WHERE id_destino IN ($ids_dest)";
	// $total_destino = mysql_db_query($dbname, $total_destino);
	// $total_destino = mysql_result($total_destino, 0);


// Precio del Tour
	$min_desde = "SELECT MIN(val_tprecio) FROM tprecio";
	$min_desde = mysql_db_query($dbname, $min_desde);
	$min_desde = mysql_result($min_desde, 0);

	$max_hasta = "SELECT MAx(val_tprecio) FROM tprecio";
	$max_hasta = mysql_db_query($dbname, $max_hasta);
	$max_hasta = mysql_result($max_hasta, 0);

	if ($desde=="Ninguna") { $desde=$min_desde;}
	if ($hasta=="Ninguna") { $hasta=$max_hasta;}

// $total_precio = "SELECT COUNT(DISTINCT id_tour) FROM tprecio WHERE val_tprecio BETWEEN ".$desde." AND ".$hasta;
// $total_precio = mysql_db_query($dbname, $total_precio);
// $total_precio = mysql_result($total_precio, 0);


// Duracion
	$min_dia = "SELECT MIN(dur_dia_tour) FROM tour";
	$min_dia = mysql_db_query($dbname, $min_dia);
	$min_dia = mysql_result($min_dia, 0);

	$max_dia = "SELECT MAx(dur_dia_tour) FROM tour";
	$max_dia = mysql_db_query($dbname, $max_dia);
	$max_dia = mysql_result($max_dia, 0);

	switch ($duracion) {
		case ($duracion=="Ninguna"):
			$min_duracion=$min_dia;
			if (empty($min_duracion)) {
				$min_duracion=0;
			}
			$max_duracion=$max_dia;
			break;

		case ($duracion==1):
			$min_duracion=1;
			$max_duracion=1;
			break;

		case ($duracion==5):
			$min_duracion=2;
			$max_duracion=$duracion;
			break;
		
		default:
			$min_duracion=$duracion-4;
			$max_duracion=$duracion;

			$ult=$max_dia-$duracion;
			$mod_ult=$duracion%5;
	
			if (($ult<5) AND ($mod_ult!=0)) {
				$min_duracion=$max_duracion-($mod_ult-1);
			}
			break;
	}





	$total_tour = "SELECT COUNT(DISTINCT tour.id_tour) FROM 
								(((tour LEFT JOIN tprecio ON tour.id_tour = tprecio.id_tour)
								LEFT JOIN tour_opcion ON tour.id_tour = tour_opcion.id_tour)
								LEFT JOIN tour_destino ON tour.id_tour = tour_destino.id_tour)
								WHERE 
								(tprecio.val_tprecio BETWEEN ".$desde." AND ".$hasta.")
								AND
								(tour.dur_dia_tour BETWEEN ".$min_duracion." AND ".$max_duracion.")
								AND
								(tour_opcion.id_opcion IN (".$ids_opc."))
								AND
                				(tour_destino.id_destino IN (".$ids_dest."))";

	$total_tour = mysql_db_query($dbname, $total_tour) or die(mysql_error());
	$total_tour = mysql_result($total_tour, 0);

?>
	<?=$total_tour?>
<?php

?>

			