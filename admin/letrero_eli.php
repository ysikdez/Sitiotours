<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$pagina= $_GET['id'];
$letrero= $_GET['letrero'];

if (!empty($pagina) || !empty($letrero)){


	$l_pos = "SELECT * FROM letrero_ima_prin WHERE id_letrero_ima_prin='$letrero'";
	$l_posi = mysql_db_query($dbname, $l_pos); 
	if ($row = mysql_fetch_array($l_posi)){ 

		$pos = $row["pos_letrero_ima_prin"];
		$nombre = $row["tip_letrero_ima_prin"]; 

	}

	$indice = "SELECT COUNT(pos_letrero_ima_prin) FROM letrero_ima_prin WHERE tip_letrero_ima_prin='$nombre'";
    $max = mysql_db_query($dbname, $indice);
    $max = mysql_result($max, 0);
	$sig = $pos + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE letrero_ima_prin SET
					pos_letrero_ima_prin='$act'
					WHERE tip_letrero_ima_prin='$nombre' AND pos_letrero_ima_prin='$i'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM letrero_ima_prin WHERE id_letrero_ima_prin='$letrero'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar archivo :".$nombre.'---'.$pos.'----'.$letrero.'pagina'.$pagina;
	
header("location: imagen_prin.php?id=$pagina&error=$error");

?>

