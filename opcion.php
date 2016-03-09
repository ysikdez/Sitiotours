<?php 

include ("admin/config.php");


$ids = $_GET['id'];

//Titulo de la Pagina
$let_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($posi_pag)){ $tit_pos_pagina = $row["tit_pos_pagina"];}

if ($ids=="Ninguna") {
?>
	<select name="opcion" OnChange="selectOpcion()">
		<option value="Ninguna">Opción de Viaje</option>

		<?php
			//Lista de Opciones de Viaje
			$dato_opcion = "SELECT * FROM opcion";
			$dato_opcion = mysql_db_query($dbname, $dato_opcion); 
			while ($row = mysql_fetch_array($dato_opcion)){ 
				$id_opc = $row["id_opcion"];
				$id_pag_opc = $row["id_pagina"];

				//titulo de la Pagina
				$dato_pag_opcion = "SELECT tit_pos_pagina,id_pagina FROM pagina WHERE id_pagina='$id_pag_opc'";
				$dato_pag_opcion = mysql_db_query($dbname, $dato_pag_opcion); 
				if ($row = mysql_fetch_array($dato_pag_opcion)){ 
					$tit_pag_opcion = $row["tit_pos_pagina"];
					$id_pag_opcion = $row["id_pagina"];
				}

		?>
				<option value="<?=$id_pag_opcion?>"><?=$tit_pag_opcion?></option>
		<?php 
		}
		?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarOpcion()">
			<?=$tit_pos_pagina?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="opcion" value="<?=$ids?>">

<?php
}
?>

	
