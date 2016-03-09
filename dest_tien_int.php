<?php 

include ("admin/config.php");


$ids = $_GET['id'];

//Titulo de la Pagina
$let_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$niv_pagina = $row["niv_pagina"];
	$per_pagina = $row["per_pagina"];
	$tit_pos_pagina = $row["tit_pos_pagina"];
}


if ($niv_pagina==2) {
?>
	<select name="inttien" OnChange="selectDestTien()">
		<option value="Ninguna">Interior</option>

<?php
	//Paises de la seleccion de la Region
	$des_pais = "SELECT * FROM pagina WHERE dise_pagina='Destino' AND per_pagina='$ids'  ORDER BY tit_pos_pagina";
	$des_pais = mysql_db_query($dbname, $des_pais); 
	while ($row = mysql_fetch_array($des_pais)){ 
		$id_pag_pais = $row["id_pagina"];

		$cad_pais = " per_pagina=".$id_pag_pais." OR".$cad_pais;

	}

	//Ciudades de los Paises
	$des_ciudad = "SELECT * FROM pagina WHERE ".$cad_pais."DER BY tit_pos_pagina";
	$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
	while ($row = mysql_fetch_array($des_ciudad)){ 
		$id_pag_ciudad = $row["id_pagina"];

		$cad_ciudad = " per_pagina=".$id_pag_ciudad." OR".$cad_ciudad;
	}
  

	//Datos del interior X la seleccion de la Region
	$des_interior = "SELECT * FROM pagina WHERE ".$cad_ciudad."DER BY tit_pos_pagina";
	$des_interior = mysql_db_query($dbname, $des_interior); 
	while ($row = mysql_fetch_array($des_interior)){ 

		$id_pag_interior = $row["id_pagina"];
		$tit_pag_interior = $row["tit_pos_pagina"]; 

?>
		<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
<?php 
	}
?>
	</select>
<?php
}  



if ($niv_pagina==3) {
?>
	<select name="inttien" OnChange="selectDestTien()">
		<option value="Ninguna">Interior</option>

<?php
	//Ciudad de la seleccion del Pais
	$des_ciudad = "SELECT * FROM pagina WHERE dise_pagina='Destino' AND per_pagina='$ids'  ORDER BY tit_pos_pagina";
	$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
	while ($row = mysql_fetch_array($des_ciudad)){ 
		$id_pag_ciudad = $row["id_pagina"];

		$cad_ciudad = " per_pagina=".$id_pag_ciudad." OR".$cad_ciudad;

	}

	//Datos de la Ciudad interna X la seleccion del Pais
	$des_interior = "SELECT * FROM pagina WHERE ".$cad_ciudad."DER BY tit_pos_pagina";
	$des_interior = mysql_db_query($dbname, $des_interior); 
	while ($row = mysql_fetch_array($des_interior)){ 

		$id_pag_interior = $row["id_pagina"];
		$tit_pag_interior = $row["tit_pos_pagina"]; 

?>
		<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
<?php 
	}
?>
	</select>
<?php
}




if ($niv_pagina==4) {
?>
	<select name="inttien" OnChange="selectDestTien()">
		<option value="Ninguna">Interior</option>

<?php
	//Datos de la Ciudad interna X la seleccion del Pais
	$des_interior = "SELECT * FROM pagina WHERE dise_pagina='Destino' AND per_pagina='$ids'  ORDER BY tit_pos_pagina";
	$des_interior = mysql_db_query($dbname, $des_interior); 
	while ($row = mysql_fetch_array($des_interior)){ 

		$id_pag_interior = $row["id_pagina"];
		$tit_pag_interior = $row["tit_pos_pagina"]; 

?>
		<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
<?php 
	}
?>
	</select>
<?php
}



if ($niv_pagina==5) {
?>
	<h5>
		<a class="" onclick="quitarDestTien('inttien')">
			<?=$tit_pos_pagina?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="inttien" value="<?=$ids?>">
<?php
}



if ($ids=="Ninguna") {
?>
	<select name="inttien" OnChange="selectDestTien()">
		<option value="Ninguna">Interior</option>

<?php
//Datos de los detalles del Diseño General
$des_interior = "SELECT * FROM pagina WHERE niv_pagina='5' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
$des_interior = mysql_db_query($dbname, $des_interior); 
while ($row = mysql_fetch_array($des_interior)){ 

	$id_pag_interior = $row["id_pagina"];
	$tit_pag_interior = $row["tit_pos_pagina"];

?>
		<option value="<?=$id_pag_interior?>"><?=$tit_pag_interior?></option>
<?php 
}
?>
	</select>
<?php
}
?>

	
