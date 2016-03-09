<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_video = $_GET['id_video'];

if (!empty($ids) || !empty($id_video)){


	$l_pos = "SELECT * FROM galeria_video WHERE id_video='$id_video'";
	$l_posi = mysql_db_query($dbname, $l_pos); 
	if ($row = mysql_fetch_array($l_posi)){ 

		$pos = $row["ord_galeria_video"]; 
		$id_galeria = $row["id_galeria"]; 

	}

	$indice = "SELECT COUNT(ord_galeria_video) FROM galeria_video WHERE id_galeria='$id_galeria'";
    $max = mysql_db_query($dbname, $indice);
    $max = mysql_result($max, 0);
	$sig = $pos + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE galeria_video SET
					ord_galeria_video='$act'
					WHERE id_galeria='$id_galeria' AND ord_galeria_video='$i'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}

	$modificar = "DELETE FROM video WHERE id_video='$id_video'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM galeria_video WHERE id_video='$id_video'";
	$result = mysql_db_query($dbname, $modificar);	

}else $error = "No se pudo borrar archivo :".$id_video;
	
header("location: galeria_video.php?id=$ids&error=$error");

?>

