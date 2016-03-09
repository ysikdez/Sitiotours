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
	<select name="pais" OnChange="selectDest()">
		<option value="Ninguna">País</option>

<?php
	//Datos del pais X la seleccion de la Region
	$des_region = "SELECT * FROM pagina WHERE dise_pagina='Destino' AND per_pagina='$ids'  ORDER BY tit_pos_pagina";
	$des_region = mysql_db_query($dbname, $des_region); 
	while ($row = mysql_fetch_array($des_region)){ 

		$id_pag_pais = $row["id_pagina"];
		$tit_pag_pais = $row["tit_pos_pagina"];

?>
		<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
<?php 
	}
?>
	</select>
<?php
} 




if ($niv_pagina==3) {
	//Seleccion del Pais
?>
	<h5>
		<a class="" onclick="quitarDest('pais')">
			<?=$tit_pos_pagina?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="pais" value="<?=$ids?>">
<?php
} 




if ($niv_pagina==4) {

	//Datos del Pais X la seleccion de la ciudad
	$pos_pais = "SELECT * FROM pagina WHERE id_pagina='$per_pagina'";
	$posi_pais = mysql_db_query($dbname, $pos_pais); 
	if ($row = mysql_fetch_array($posi_pais)){ 
		$id_pag_pais = $row["id_pagina"];
		$tit_pag_pais = $row["tit_pos_pagina"];
	}
?>
	<h5>
		<a class="" onclick="quitarDest('pais')">
			<?=$tit_pag_pais?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="pais" value="<?=$id_pag_pais?>">
<?php
} 

if ($ids=="Ninguna") {
?>
	<select name="pais" OnChange="selectDest()">
		<option value="Ninguna">País</option>

<?php
//Datos de los detalles del Diseño General
$des_pais = "SELECT * FROM pagina WHERE niv_pagina='3' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
$des_pais = mysql_db_query($dbname, $des_pais); 
while ($row = mysql_fetch_array($des_pais)){ 

	$id_pag_pais = $row["id_pagina"];
	$tit_pag_pais = $row["tit_pos_pagina"];

?>
		<option value="<?=$id_pag_pais?>"><?=$tit_pag_pais?></option>
<?php 
}
?>
	</select>

<?php
}
?>
