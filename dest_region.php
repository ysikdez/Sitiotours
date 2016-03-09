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
	<h5>
		<a class="" onclick="quitarDest('region')">
			<?=$tit_pos_pagina?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="region" value="<?=$ids?>">
<?php
} 



if ($niv_pagina==3) {

	//Datos de la Region X la seleccion del Pais
	$pos_region = "SELECT * FROM pagina WHERE id_pagina='$per_pagina'";
	$posi_region = mysql_db_query($dbname, $pos_region); 
	if ($row = mysql_fetch_array($posi_region)){ 
		$id_pag_region = $row["id_pagina"];
		$tit_pag_region = $row["tit_pos_pagina"];
	}
?>
	<h5>
		<a class=""  onclick="quitarDest('region')">
			<?=$tit_pag_region?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="region" value="<?=$id_pag_region?>">
<?php
} 




if ($niv_pagina==4) {

	//Datos del Pais X la seleccion Ciudad
	$pos_pais= "SELECT * FROM pagina WHERE id_pagina='$per_pagina'";
	$posi_pais = mysql_db_query($dbname, $pos_pais); 
	if ($row = mysql_fetch_array($posi_pais)){ 
		$id_pag_pais = $row["id_pagina"];
		$per_pag_pais = $row["per_pagina"];
	}

	//Datos de la Region X la seleccion del Pais
	$pos_pais = "SELECT * FROM pagina WHERE id_pagina='$per_pag_pais'";
	$posi_pais = mysql_db_query($dbname, $pos_pais); 
	if ($row = mysql_fetch_array($posi_pais)){ 
		$id_pag_region = $row["id_pagina"];
		$tit_pag_region = $row["tit_pos_pagina"];
	}
?>
	<h5>
		<a class="" onclick="quitarDest('region')">
			<?=$tit_pag_region?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="region" value="<?=$id_pag_region?>">
<?php
} 


if ($ids=="Ninguna") {
?>
	<select name="region" OnChange="selectDest();">
		<option value="Ninguna">Región</option>

<?php
	//Datos de los detalles del Diseño General
	$des_region = "SELECT * FROM pagina WHERE niv_pagina='2' AND dise_pagina='Destino'  ORDER BY tit_pos_pagina";
	$des_region = mysql_db_query($dbname, $des_region); 
	while ($row = mysql_fetch_array($des_region)){ 

		$id_pag_region = $row["id_pagina"];
		$tit_pag_region = $row["tit_pos_pagina"];

?>
		<option value="<?=$id_pag_region?>"><?=$tit_pag_region?></option>
	<?php 
	}
	?>
	</select>

<?php
}

?>