<?php
include ("config.php");

$pagina= $_GET['id'];
$signo = $_GET['sig'];
$pos = $_GET['pos'];
$nom = $_GET['nom'];

// tipo de letrero e id del letrero
$d_pos = "SELECT * FROM letrero_ima_prin WHERE tip_letrero_ima_prin='$nom' AND pos_letrero_ima_prin='$pos'";
$d_posi = mysql_db_query($dbname, $d_pos); 
if ($row = mysql_fetch_array($d_posi)){ 
	$tip_letrero = $row["tip_letrero_ima_prin"];
	$id_letrero = $row["id_letrero_ima_prin"]; 
}

$i = $pos;
	

if (!empty($i)){

	if ($signo == 1){
		
			$sig=$i+1;
			$ant=$i;
			
			//el letrero siguiente retrocede 
			$siguiente = "UPDATE letrero_ima_prin SET
						pos_letrero_ima_prin='$ant'
						WHERE pos_letrero_ima_prin='$sig' AND tip_letrero_ima_prin='$tip_letrero'";
			$cab_actual = mysql_db_query($dbname, $siguiente);

			//el letrero actual se va a la siguiente 
			$actual = "UPDATE letrero_ima_prin SET
						pos_letrero_ima_prin='$sig'
						WHERE id_letrero_ima_prin='$id_letrero'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE letrero_ima_prin SET
						pos_letrero_ima_prin='$sig'
						WHERE pos_letrero_ima_prin='$ant' AND tip_letrero_ima_prin='$tip_letrero'";
			$cab_actual = mysql_db_query($dbname, $anterior);	

			$actual = "UPDATE letrero_ima_prin SET
						pos_letrero_ima_prin='$ant'
						WHERE id_letrero_ima_prin='$id_letrero'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$pos;

			
header("location: imagen_prin.php?id=$pagina&error=$error");


?>

