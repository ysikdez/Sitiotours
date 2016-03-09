<?php 

include ("admin/config.php");


$catealoja = $_GET['catealoja'];

if ($catealoja=="Ninguna") {
?>
	<select name="catealoja" OnChange="selectCateAloja()">
		<option value="Ninguna">Categoria del Alojamiento</option>

		<?php
		//Datos del Tipo de Alojamiento 
		$des_tip_aloja = "SELECT DISTINCT cat_alojamiento FROM alojamiento ORDER BY cat_alojamiento";
		$des_tip_aloja = mysql_db_query($dbname, $des_tip_aloja); 
		while ($row = mysql_fetch_array($des_tip_aloja)){ 

			$cat_alojamiento = $row["cat_alojamiento"];

		?>
		<option value="<?=$cat_alojamiento?>"><?=$cat_alojamiento?> Estrellas</option>
		<?php 
		}
		?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarCateAloja()">
			<?=$catealoja?> Estrellas <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="catealoja" value="<?=$catealoja?>">

<?php
}
?>

	
