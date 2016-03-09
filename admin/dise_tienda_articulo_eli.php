<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$id_articulo = $_GET['id_articulo'];
$error = $_GET['error'];

if (!empty($id_articulo)){

	//Datos de la Habitacion
	$pos_pag = "SELECT * FROM articulo WHERE id_articulo='$id_articulo'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 
		$id_tienda = $row["id_tienda"]; 
		$ord_articulo = $row["ord_articulo"]; 
	}

	$n_catalogo = "SELECT COUNT(ord_articulo) FROM articulo WHERE id_tienda='$id_tienda'";
	$max = mysql_db_query($dbname, $n_catalogo);
	$max = mysql_result($max, 0);

	$sig = $ord_articulo + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE articulo SET
					ord_articulo='$act'
					WHERE ord_articulo='$i' AND id_tienda='$id_tienda'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}
		
	$modificar = "DELETE FROM articulo_categoria WHERE id_articulo='$id_articulo'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM articulo_ocasion WHERE id_articulo='$id_articulo'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM articulo_dirigido WHERE id_articulo='$id_articulo'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM aprecio WHERE id_articulo='$id_articulo'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM articulo WHERE id_articulo='$id_articulo'";
	$result = mysql_db_query($dbname, $modificar);


}else $error = "No se pudo borrar el articulo :".$ord_articulo;
	
header("location: dise_tienda_catalogo.php?id=$ids&error=$error");

?>

