<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];

//Mira si esta leido el Comentario
$let_pag = "SELECT vist_tic FROM tic WHERE id_tic='$ids'";
$posi_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($posi_pag)){ $vist_tic = $row["vist_tic"]; }


if ($vist_tic==1) {

	$cambiar_noleido = "UPDATE tic SET	vist_tic = '0'	WHERE id_tic='$ids'";
	$bd_cambiar_noleido = mysql_db_query($dbname, $cambiar_noleido);

?>
	<i class="icon-eye-close"></i>

<?php
	} else {

	$cambiar_leido = "UPDATE tic SET vist_tic = '1'	WHERE id_tic='$ids'";
	$bd_cambiar_leido = mysql_db_query($dbname, $cambiar_leido);
?>
	<i class="icon-eye-open"></i>
<?php
	}
?>
