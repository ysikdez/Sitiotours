<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_contacto = $_GET['id_contacto'];
$signo = $_GET['sig'];

$l_pos = "SELECT * FROM contacto WHERE id_contacto='$id_contacto'";
$l_posi = mysql_db_query($dbname, $l_pos); 
if ($row = mysql_fetch_array($l_posi)){ 

	$pos = $row["ord_contacto"]; 

}

$i = $pos;
	

if (!empty($i)){

	if ($signo == 1){
		
			$sig=$i+1;
			$ant=$i;
			
			//el letrero siguiente retrocede 
			$siguiente = "UPDATE contacto SET
						ord_contacto='$ant'
						WHERE ord_contacto='$sig' AND id_pagina='$ids'";
			$cab_actual = mysql_db_query($dbname, $siguiente);

			//el letrero actual se va a la siguiente 
			$actual = "UPDATE contacto SET
						ord_contacto='$sig'
						WHERE id_contacto='$id_contacto'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE contacto SET
						ord_contacto='$sig'
						WHERE ord_contacto='$ant' AND id_pagina='$ids'";
			$cab_actual = mysql_db_query($dbname, $anterior);	

			$actual = "UPDATE contacto SET
						ord_contacto='$ant'
						WHERE id_contacto='$id_contacto'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$pos;

			
header("location: social.php?id=$ids&error=$error");


?>

