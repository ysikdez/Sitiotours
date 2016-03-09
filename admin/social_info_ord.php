<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_info = $_GET['id_info'];
$signo = $_GET['sig'];

$l_pos = "SELECT * FROM info WHERE id_info='$id_info'";
$l_posi = mysql_db_query($dbname, $l_pos); 
if ($row = mysql_fetch_array($l_posi)){ 

	$id_contacto = $row["id_contacto"]; 
	$pos = $row["ord_info"]; 

}

$i = $pos;
	

if (!empty($i)){

	if ($signo == 1){
		
			$sig=$i+1;
			$ant=$i;
			
			//el letrero siguiente retrocede 
			$siguiente = "UPDATE info SET
						ord_info='$ant'
						WHERE ord_info='$sig' AND id_contacto='$id_contacto'";
			$cab_actual = mysql_db_query($dbname, $siguiente);

			//el letrero actual se va a la siguiente 
			$actual = "UPDATE info SET
						ord_info='$sig'
						WHERE id_info='$id_info'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE info SET
						ord_info='$sig'
						WHERE ord_info='$ant' AND id_contacto='$id_contacto'";
			$cab_actual = mysql_db_query($dbname, $anterior);	

			$actual = "UPDATE info SET
						ord_info='$ant'
						WHERE id_info='$id_info'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$pos;

			
header("location: social.php?id=$ids&error=$error");


?>

