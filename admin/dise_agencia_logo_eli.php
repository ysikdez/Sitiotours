<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");

$pagina= $_GET['id'];

if (!empty($pagina) or $pagina==0){

	//Idioma
	$log_pag = "SELECT logo_pagina FROM pagina WHERE id_pagina='$pagina'";
	$logo_pag = mysql_db_query($dbname, $log_pag); 
	if ($row = mysql_fetch_array($logo_pag)){ $logo = $row["logo_pagina"]; }


	@unlink($logo);

	$editar_pagina = "UPDATE pagina SET	
						logo_pagina = '',
						alt_logo_pagina = '',
						des_logo_pagina = ''
						WHERE id_pagina='$pagina'";
	$bd_editar_pagina = mysql_db_query($dbname, $editar_pagina);


}else $error = "No se pudo borrar archivo del logo: ".$logo_pag;
	
header("location: dise_agencia.php?id=$pagina&error=$error");

?>

