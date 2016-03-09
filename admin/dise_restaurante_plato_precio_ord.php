<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_pprecio = $_GET['id_pprecio'];
$signo = $_GET['sig'];
$error = $_GET['error'];

//Datos de la Habitacion
$pos_pag = "SELECT * FROM pprecio WHERE id_pprecio='$id_pprecio'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$id_plato = $row["id_plato"]; 
	$ord_pprecio = $row["ord_pprecio"]; 
}

$i = $ord_pprecio;

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE pprecio SET
						ord_pprecio='$ant'
						WHERE ord_pprecio='$sig' AND id_plato = $id_plato";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE pprecio SET
						ord_pprecio='$sig'
						WHERE id_pprecio='$id_pprecio'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE pprecio SET
						ord_pprecio='$sig'
						WHERE ord_pprecio='$ant' AND id_plato = $id_plato";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE pprecio SET
						ord_pprecio='$ant'
						WHERE id_pprecio='$id_pprecio'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_pprecio;

header("location: dise_restaurante_menu.php?id=$ids&error=$error");


?>

