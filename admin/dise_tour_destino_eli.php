<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_pag_dest = $_GET['id_dest'];
$id_tour = $_GET['id_tour'];
$error = $_GET['error'];

if (!empty($id_pag_dest)){

	$dato_destino = "SELECT id_destino FROM destino WHERE id_pagina='$id_pag_dest'";
	$dato_destino = mysql_db_query($dbname, $dato_destino); 
	if ($row = mysql_fetch_array($dato_destino)){ $id_dest = $row["id_destino"]; }

		
	$modificar = "DELETE FROM tour_destino WHERE id_destino='$id_dest' AND id_tour='$id_tour'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el pag destino :".$id_pag_dest;
	
header("location: dise_tour_destino.php?id=$ids&error=$error");

?>

