<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
//$id_articulo = $_GET['id_articulo'];
$id_aprecio = $_GET['id_aprecio'];
$error = $_GET['error'];

if (!empty($id_aprecio)){

	//Datos de la Habitacion
	$pos_pag = "SELECT * FROM aprecio WHERE id_aprecio='$id_aprecio'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 
		$id_articulo = $row["id_articulo"]; 
		$ord_aprecio = $row["ord_aprecio"]; 
	}

	$n_menu = "SELECT COUNT(ord_aprecio) FROM aprecio WHERE id_articulo='$id_articulo'";
	$max = mysql_db_query($dbname, $n_menu);
	$max = mysql_result($max, 0);

	$sig = $ord_aprecio + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE aprecio SET
					ord_aprecio='$act'
					WHERE ord_aprecio='$i' AND id_articulo='$id_articulo'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM aprecio WHERE id_aprecio='$id_aprecio'";
	$result = mysql_db_query($dbname, $modificar);

}else $error = "No se pudo borrar el Precio de la Habitacion :".$ord_aprecio;
	
header("location: dise_tienda_catalogo.php?id=$ids&error=$error");

?>

