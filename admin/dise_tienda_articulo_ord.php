<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_articulo = $_GET['id_articulo'];
$signo = $_GET['sig'];
$error = $_GET['error'];

//Datos de la Habitacion
$pos_pag = "SELECT * FROM articulo WHERE id_articulo='$id_articulo'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$id_tienda = $row["id_tienda"]; 
	$ord_articulo = $row["ord_articulo"]; 
}

$i = $ord_articulo;

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE articulo SET
						ord_articulo='$ant'
						WHERE ord_articulo='$sig' AND id_tienda = $id_tienda";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE articulo SET
						ord_articulo='$sig'
						WHERE id_articulo='$id_articulo'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE articulo SET
						ord_articulo='$sig'
						WHERE ord_articulo='$ant' AND id_tienda = $id_tienda";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE articulo SET
						ord_articulo='$ant'
						WHERE id_articulo='$id_articulo'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_articulo;

header("location: dise_tienda_catalogo.php?id=$ids&error=$error");


?>

