<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$id = $_GET["id"];

if (!empty($id)){
		
	$modificar = "DELETE FROM usuario WHERE id_usuario='$id'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el Usuario :".$id;
	
header("location: usuario.php?id=$id&error=$error");

?>

