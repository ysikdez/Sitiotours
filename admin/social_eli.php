<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_contacto = $_GET['id_contacto'];

if (!empty($ids) || !empty($id_contacto)){


	$l_pos = "SELECT * FROM contacto WHERE id_contacto='$id_contacto'";
	$l_posi = mysql_db_query($dbname, $l_pos); 
	if ($row = mysql_fetch_array($l_posi)){ 

		$pos = $row["ord_contacto"]; 

	}

	$indice = "SELECT COUNT(ord_contacto) FROM contacto WHERE id_pagina='$ids'";
    $max = mysql_db_query($dbname, $indice);
    $max = mysql_result($max, 0);
	$sig = $pos + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE contacto SET
					ord_contacto='$act'
					WHERE id_pagina='$ids' AND ord_contacto='$i'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}

	$modificar = "DELETE FROM info WHERE id_contacto='$id_contacto'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM contacto WHERE id_contacto='$id_contacto'";
	$result = mysql_db_query($dbname, $modificar);	

}else $error = "No se pudo borrar archivo :".$id_contacto;
	
header("location: social.php?id=$ids&error=$error");

?>

