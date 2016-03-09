<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_plato = $_GET['id_plato'];
$error = $_GET['error'];

if (!empty($id_plato)){

	//Datos de la Habitacion
	$pos_pag = "SELECT * FROM plato WHERE id_plato='$id_plato'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 
		$id_restaurante = $row["id_restaurante"]; 
		$ord_plato = $row["ord_plato"]; 
	}

	$n_menu = "SELECT COUNT(ord_plato) FROM plato WHERE id_restaurante='$id_restaurante'";
	$max = mysql_db_query($dbname, $n_menu);
	$max = mysql_result($max, 0);

	$sig = $ord_plato + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE plato SET
					ord_plato='$act'
					WHERE ord_plato='$i' AND id_restaurante='$id_restaurante'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM plato WHERE id_plato='$id_plato'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el plato :".$ord_plato;
	
header("location: dise_restaurante_menu.php?id=$ids&error=$error");

?>

