<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_ima = $_GET['id_ima'];
$signo = $_GET['sig'];

$l_pos = "SELECT * FROM galeria_imagen WHERE id_imagen='$id_ima'";
$l_posi = mysql_db_query($dbname, $l_pos); 
if ($row = mysql_fetch_array($l_posi)){ 

	$pos = $row["ord_galeria_imagen"]; 
	$id_galeria = $row["id_galeria"]; 

}

$i = $pos;
	

if (!empty($i)){

	if ($signo == 1){
		
			$sig=$i+1;
			$ant=$i;
			
			//el letrero siguiente retrocede 
			$siguiente = "UPDATE galeria_imagen SET
						ord_galeria_imagen='$ant'
						WHERE ord_galeria_imagen='$sig' AND id_galeria='$id_galeria'";
			$cab_actual = mysql_db_query($dbname, $siguiente);

			//el letrero actual se va a la siguiente 
			$actual = "UPDATE galeria_imagen SET
						ord_galeria_imagen='$sig'
						WHERE id_imagen='$id_ima'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE galeria_imagen SET
						ord_galeria_imagen='$sig'
						WHERE ord_galeria_imagen='$ant' AND id_galeria='$id_galeria'";
			$cab_actual = mysql_db_query($dbname, $anterior);	

			$actual = "UPDATE galeria_imagen SET
						ord_galeria_imagen='$ant'
						WHERE id_imagen='$id_ima'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$pos;

			
header("location: galeria_foto.php?id=$ids&error=$error");


?>

