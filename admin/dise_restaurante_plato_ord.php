<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_plato = $_GET['id_plato'];
$signo = $_GET['sig'];
$error = $_GET['error'];

//Datos de la Habitacion
$pos_pag = "SELECT * FROM plato WHERE id_plato='$id_plato'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$id_restaurante = $row["id_restaurante"]; 
	$ord_plato = $row["ord_plato"]; 
}

$i = $ord_plato;

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE plato SET
						ord_plato='$ant'
						WHERE ord_plato='$sig' AND id_restaurante = $id_restaurante";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE plato SET
						ord_plato='$sig'
						WHERE id_plato='$id_plato'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE plato SET
						ord_plato='$sig'
						WHERE ord_plato='$ant' AND id_restaurante = $id_restaurante";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE plato SET
						ord_plato='$ant'
						WHERE id_plato='$id_plato'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_plato;

header("location: dise_restaurante_menu.php?id=$ids&error=$error");


?>

