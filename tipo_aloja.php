<?php 

include ("admin/config.php");


$tipoaloja = $_GET['tipoaloja'];

if ($tipoaloja=="Ninguna") {
?>
	<select name="tipoaloja" OnChange="selectTipoAloja()">
		<option value="Ninguna">Tipo de Alojamiento</option>

		<?php
		//Datos del Tipo de Alojamiento 
		$des_tip_aloja = "SELECT DISTINCT tipo_alojamiento FROM alojamiento ORDER BY tipo_alojamiento";
		$des_tip_aloja = mysql_db_query($dbname, $des_tip_aloja); 
		while ($row = mysql_fetch_array($des_tip_aloja)){ 

			$tipo_alojamiento = $row["tipo_alojamiento"];

		?>
		<option value="<?=$tipo_alojamiento?>"><?=$tipo_alojamiento?></option>
		<?php 
		}
		?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarTipoAloja()">
			<?=$tipoaloja?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="tipoaloja" value="<?=$tipoaloja?>">

<?php
}
?>

	
