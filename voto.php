<?php 
include ("admin/config.php");
include ("admin/functions.php");

$id = $_GET['id'];
$voto = $_GET['voto'];
$fecha =date("Y-m-d");
$hora =date("H:i:s");
$codigo=$fecha."-".add_ceros($id,5);
//Nuevo voto
$nuevo_voto = "INSERT INTO valoracion (

						id_pagina,
						cod_valoracion,
						fec_valoracion,
						hor_valoracion,
						pun_valoracion

					) VALUES(

						'$id',
						'$codigo',
						'$fecha',
						'$hora',
						'$voto'

					)";

$nuevo_voto = mysql_db_query($dbname, $nuevo_voto);

//Datos de la valoracion
$dato_valoracion = "SELECT 
						COUNT(valoracion.pun_valoracion) AS numero,
						AVG(valoracion.pun_valoracion) AS promedio
						FROM
						(pagina LEFT JOIN valoracion ON pagina.id_pagina=valoracion.id_pagina)
						WHERE pagina.id_pagina='$id'";
$dato_valoracion = mysql_db_query($dbname, $dato_valoracion); 
if ($row = mysql_fetch_array($dato_valoracion)){ 

	$numero = $row["numero"];
	$promedio = $row["promedio"];
	$promedio = ceil($promedio);
}
?>
	<div id="voto">
		<?php 
			if ($promedio=='1') { $act1='ico-val_on'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
			if ($promedio=='2') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
			if ($promedio=='3') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_off'; $act5='ico-val_off';} 
			if ($promedio=='4') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_off';} 
			if ($promedio=='5') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_on';} 
		?>
		<a class="icon-pie2 <?=$act1?>"></a>
		<a class="icon-pie1 <?=$act2?>"></a>
		<a class="icon-pie1 <?=$act3?>"></a>
		<a class="icon-pie2 <?=$act4?>"></a>
		<a class="icon-pie1 <?=$act5?>"></a>
		<br>
		<small><small><strong><?=$numero?></strong> Votos</small></small><br>
		<small><small>Gracias por su voto: <strong><?=$voto?></strong></small></small>
	</div>


