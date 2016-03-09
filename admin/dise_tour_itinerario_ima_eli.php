<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_itinerario = $_GET['id_itinerario'];
$ingresada = $_GET['error'];

if (!empty($ids) || !empty($id_itinerario)){

	//Datos del dia del Itinerario del Tour
	$dato_dia = "SELECT * FROM itinerario WHERE id_itinerario='$id_itinerario'";
	$dato_dia = mysql_db_query($dbname, $dato_dia); 
	if ($row = mysql_fetch_array($dato_dia)){ $arch_ima_itinerario = $row["arch_ima_itinerario"];}

	@unlink($arch_ima_itinerario);
				
	//Editando Imagen
	$editar_dia = "UPDATE itinerario SET

						arch_ima_itinerario = '',
						tit_ima_itinerario = '',
						des_ima_itinerario = '',					
						lug_ima_itinerario = '',
						fec_ima_itinerario = ''
						
						WHERE id_itinerario='$id_itinerario'";

	$cab_editar_dia = mysql_db_query($dbname, $editar_dia);

}else $error = "No se pudo borrar archivo :".$id_itinerario;
	
header("location: dise_tour_itinerario_edit.php?id=$ids&id_itinerario=$id_itinerario&error=$error");

?>

