<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_info = $_GET['id_info'];

if (!empty($ids) || !empty($id_info)){


	$l_pos = "SELECT * FROM info WHERE id_info='$id_info'";
	$l_posi = mysql_db_query($dbname, $l_pos); 
	if ($row = mysql_fetch_array($l_posi)){ 

		$id_contacto = $row["id_contacto"]; 
		$pos = $row["ord_contacto"]; 

	}

	$indice = "SELECT COUNT(ord_info) FROM info WHERE id_contacto='$id_contacto'";
    $max = mysql_db_query($dbname, $indice);
    $max = mysql_result($max, 0);
	$sig = $pos + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE info SET
					ord_info='$act'
					WHERE id_contacto='$id_contacto' AND ord_info='$i'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}

	$modificar = "DELETE FROM info WHERE id_info='$id_info'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar archivo :".$id_info;
	
header("location: social.php?id=$ids&error=$error");

?>

