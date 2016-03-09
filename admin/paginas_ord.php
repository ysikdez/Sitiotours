<?php
include ("config.php");

$pagina= $_GET['id'];
$signo = $_GET['sig'];

$pos = "SELECT * FROM pagina WHERE id_pagina='$pagina'";
$posi = mysql_db_query($dbname, $pos); 
if ($row = mysql_fetch_array($posi)){ 

	$ord_pagina = $row["ord_pagina"];
	$niv_pagina = $row["niv_pagina"];
	$per_pagina = $row["per_pagina"];
	$id_idioma = $row["id_idioma"];

}

$i = $ord_pagina;
	

if (!empty($i)){

	if ($signo == 0){
		
			$sig=$i+1;
			$ant=$i;
			
			//la pagina siguiente retrocede 
			$siguiente = "UPDATE pagina SET
						ord_pagina='$ant'
						WHERE ord_pagina='$sig' AND per_pagina='$per_pagina' AND id_idioma=$id_idioma AND niv_pagina = $niv_pagina";
			$cab_actual = mysql_db_query($dbname, $siguiente);	

			//la pagina se va a la siguiente 
			$actual = "UPDATE pagina SET
						ord_pagina='$sig'
						WHERE id_pagina='$pagina'";
			$cab_siguiente = mysql_db_query($dbname, $actual);				
			
	}else{
		
			$ant=$i-1;
			$sig=$i;
			
			$anterior = "UPDATE pagina SET
						ord_pagina='$sig'
						WHERE ord_pagina='$ant' AND per_pagina='$per_pagina' AND id_idioma=$id_idioma AND niv_pagina = $niv_pagina";
			$cab_actual = mysql_db_query($dbname, $anterior);	


			$actual = "UPDATE pagina SET
						ord_pagina='$ant'
						WHERE id_pagina='$pagina'";
			$cab_anterior = mysql_db_query($dbname, $actual);				

	}
		
	}else $error = "No se pudo cambiar de posicion :".$ord_pagina;

header("location: paginas.php?error=$error");


?>

