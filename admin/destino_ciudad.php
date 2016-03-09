<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

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
	<select name="ciudad" OnChange="selectDestino()">
		<option value="Ninguna">Elige</option>

<?php
	//Paises de la seleccion de la Region
	$des_pais = "SELECT * FROM pagina WHERE dise_pagina='Destino' AND per_pagina='$ids'  ORDER BY tit_pos_pagina";
	$des_pais = mysql_db_query($dbname, $des_pais); 
	while ($row = mysql_fetch_array($des_pais)){ 
		$id_pag_pais = $row["id_pagina"];

		$cad_pais = " per_pagina=".$id_pag_pais." OR".$cad_pais;

	}

	//Datos de la Ciudad X la seleccion de la Region
	$des_ciudad = "SELECT * FROM pagina WHERE ".$cad_pais."DER BY tit_pos_pagina";
	$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
	while ($row = mysql_fetch_array($des_ciudad)){ 

		$id_pag_ciudad = $row["id_pagina"];
		$tit_pag_ciudad = $row["tit_pos_pagina"]; 

?>
		<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
<?php 
	}
?>
	</select>
<?php
}  



if ($niv_pagina==3) {
?>
	<select name="ciudad" OnChange="selectDestino()">
		<option value="Ninguna">Elige</option>

<?php
	//Datos de la Ciudad X la seleccion del Pais
	$des_ciudad = "SELECT * FROM pagina WHERE dise_pagina='Destino' AND per_pagina='$ids'  ORDER BY tit_pos_pagina";
	$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
	while ($row = mysql_fetch_array($des_ciudad)){ 

		$id_pag_ciudad = $row["id_pagina"];
		$tit_pag_ciudad = $row["tit_pos_pagina"]; 

?>
		<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
<?php 
	}
?>
	</select>
<?php
} 




if ($niv_pagina==4) {
	//Seleccion de la Ciudad
?>
	<a class="btn select-caja btn-st" onclick="quitarDestino('ciudad')">
		<h6 class="info"><?=$tit_pos_pagina?>
		<i class="icon-remove"></i></h6>
	</a>
	<input type="hidden" name="ciudad" value="<?=$ids?>">
<?php
} 




if ($niv_pagina==5) {

	//Datos de la Ciudad X la seleccion de la ciudad interna
	$pos_ciudad = "SELECT * FROM pagina WHERE id_pagina='$per_pagina'";
	$posi_ciudad = mysql_db_query($dbname, $pos_ciudad); 
	if ($row = mysql_fetch_array($posi_ciudad)){ 
		$id_pag_ciudad = $row["id_pagina"];
		$tit_pag_ciudad = $row["tit_pos_pagina"];
	}
?>
	<a class="btn select-caja btn-st" onclick="quitarDestino('ciudad')">
		<h6 class="info"><?=$tit_pag_ciudad?>
		<i class="icon-remove"></i></h6>
	</a>
	<input type="hidden" name="ciudad" value="<?=$id_pag_ciudad?>">
<?php
}



if ($ids=="Ninguna") {
?>
		<select name="ciudad" OnChange="selectDestino()">
			<option value="Ninguna">Elige</option>

<?php
//Datos de los detalles del Diseño General
$des_ciudad = "SELECT * FROM pagina WHERE niv_pagina='4' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
$des_ciudad = mysql_db_query($dbname, $des_ciudad); 
while ($row = mysql_fetch_array($des_ciudad)){ 

	$id_pag_ciudad = $row["id_pagina"];
	$tit_pag_ciudad = $row["tit_pos_pagina"];

?>
			<option value="<?=$id_pag_ciudad?>"><?=$tit_pag_ciudad?></option>
<?php 
}
?>
		</select>

<?php
}
?>

	
