<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_aprecio = $_GET['id_aprecio'];
$signo = $_GET['sig'];
$error = $_GET['error'];

//Datos de la Habitacion
$pos_pag = "SELECT * FROM aprecio WHERE id_aprecio='$id_aprecio'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$id_articulo = $row["id_articulo"]; 
	$ord_aprecio = $row["ord_aprecio"]; 
}

$i = $ord_aprecio;

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE aprecio SET
						ord_aprecio='$ant'
						WHERE ord_aprecio='$sig' AND id_articulo = $id_articulo";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE aprecio SET
						ord_aprecio='$sig'
						WHERE id_aprecio='$id_aprecio'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE aprecio SET
						ord_aprecio='$sig'
						WHERE ord_aprecio='$ant' AND id_articulo = $id_articulo";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE aprecio SET
						ord_aprecio='$ant'
						WHERE id_aprecio='$id_aprecio'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_aprecio;

header("location: dise_tienda_catalogo.php?id=$ids&error=$error");


?>

