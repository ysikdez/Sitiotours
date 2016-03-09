<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];

//Mira si esta leido el Comentario
$let_pag = "SELECT fav_tic FROM tic WHERE id_tic='$ids'";
$posi_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($posi_pag)){ $fav_tic = $row["fav_tic"]; }


if ($fav_tic==1) {

	$cambiar_nofavorito = "UPDATE tic SET	fav_tic = '0'	WHERE id_tic='$ids'";
	$bd_cambiar_nofavorito = mysql_db_query($dbname, $cambiar_nofavorito);

?>
	<i class="esp-ico"></i>

<?php
	} else {

	$cambiar_favorito = "UPDATE tic SET fav_tic = '1'	WHERE id_tic='$ids'";
	$bd_cambiar_favorito = mysql_db_query($dbname, $cambiar_favorito);
?>
	<i class="icon-heart"></i>
<?php
	}
?>
