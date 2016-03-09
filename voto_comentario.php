<?php 
include ("admin/config.php");
include ("admin/functions.php");

$id_tic = $_GET['id'];
$voto = $_GET['voto'];
$fecha =date("Y-m-d H:i:s");

//Nuevo voto
$nuevo_voto = "INSERT INTO val_tic (

						id_tic,
						fc_hr_val_tic,
						pun_val_tic

					) VALUES(

						'$id_tic',
						'$fecha',
						'$voto'
					)";

$nuevo_voto = mysql_db_query($dbname, $nuevo_voto);

//Datos de la valoracion
$dato_val_tip = "SELECT 
						COUNT(val_tic.pun_val_tic) AS numero,
						AVG(val_tic.pun_val_tic) AS promedio
						FROM
						(tic LEFT JOIN val_tic ON tic.id_tic=val_tic.id_tic)
						WHERE tic.id_tic='$id_tic'";
$dato_val_tip = mysql_db_query($dbname, $dato_val_tip); 
if ($row = mysql_fetch_array($dato_val_tip)){ 

	$numero = $row["numero"];
	$promedio = $row["promedio"];
	$promedio = ceil($promedio);
}
?>
	<div id="voto-comentario-<?=$id_tic?>" class="text-center" >
		<?php 
			if ($promedio=='1') { $act1='ico-val_on'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
			if ($promedio=='2') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
			if ($promedio=='3') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_off'; $act5='ico-val_off';} 
			if ($promedio=='4') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_off';} 
			if ($promedio=='5') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_on';} 
		?>
		<small><small><small>
			<strong><?=$numero?></strong> Votos<br>
			<a class="icon-pie2 <?=$act1?>"></a>
			<a class="icon-pie1 <?=$act2?>"></a>
			<a class="icon-pie1 <?=$act3?>"></a>
			<a class="icon-pie2 <?=$act4?>"></a>
			<a class="icon-pie1 <?=$act5?>"></a><br>
			Gracias por su voto: <strong><?=$voto?></strong>
		</small></small></small>
	</div>


