<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$ids = $_GET['id'];
$id_ima = $_GET['id_ima'];

if (!empty($ids) || !empty($id_ima)){


	$l_pos = "SELECT * FROM galeria_imagen WHERE id_imagen='$id_ima'";
	$l_posi = mysql_db_query($dbname, $l_pos); 
	if ($row = mysql_fetch_array($l_posi)){ 

		$pos = $row["ord_galeria_imagen"]; 
		$id_galeria = $row["id_galeria"]; 

	}

	$indice = "SELECT COUNT(ord_galeria_imagen) FROM galeria_imagen WHERE id_galeria='$id_galeria'";
    $max = mysql_db_query($dbname, $indice);
    $max = mysql_result($max, 0);
	$sig = $pos + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE galeria_imagen SET
					ord_galeria_imagen='$act'
					WHERE id_galeria='$id_galeria' AND ord_galeria_imagen='$i'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}

	$modificar = "DELETE FROM galeria_imagen WHERE id_imagen='$id_ima'";
	$result = mysql_db_query($dbname, $modificar);
		
	$modificar = "DELETE FROM imagen WHERE id_imagen='$id_ima'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar archivo :".$id_ima;
	
header("location: galeria_foto.php?id=$ids&error=$error");

?>

