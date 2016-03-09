<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_salida= $_GET['id_salida'];
$error = $_GET['error'];

if (!empty($id_salida)){
	
	$modificar = "DELETE FROM salida WHERE id_salida='$id_salida'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el Precio :".$id_salida;
	
header("location: dise_tour_salida.php?id=$ids&error=$error");

?>

