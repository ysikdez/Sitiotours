<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
//$id_plato = $_GET['id_plato'];
$id_pprecio = $_GET['id_pprecio'];
$error = $_GET['error'];

if (!empty($id_pprecio)){

	//Datos de la Habitacion
	$pos_pag = "SELECT * FROM pprecio WHERE id_pprecio='$id_pprecio'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 
		$id_plato = $row["id_plato"]; 
		$ord_pprecio = $row["ord_pprecio"]; 
	}

	$n_menu = "SELECT COUNT(ord_pprecio) FROM pprecio WHERE id_plato='$id_plato'";
	$max = mysql_db_query($dbname, $n_menu);
	$max = mysql_result($max, 0);

	$sig = $ord_pprecio + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE pprecio SET
					ord_pprecio='$act'
					WHERE ord_pprecio='$i' AND id_plato='$id_plato'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM pprecio WHERE id_pprecio='$id_pprecio'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el Precio de la Habitacion :".$ord_pprecio;
	
header("location: dise_restaurante_menu.php?id=$ids&error=$error");

?>

