<?php 

include ("admin/config.php");


$tiprest = $_GET['tiprest'];

if ($tiprest=="Ninguna") {
?>
	<select name="tiprest" OnChange="selectTipRest()">
		<option value="Ninguna">Tipo</option>

		<?php
		//Datos de los detalles del Diseño General
		$des_region = "SELECT * FROM tipo ORDER BY nom_tipo";
		$des_region = mysql_db_query($dbname, $des_region); 
		while ($row = mysql_fetch_array($des_region)){ 

			$id_tipo = $row["id_tipo"];
			$nom_tipo = $row["nom_tipo"];

		?>
		<option value="<?=$id_tipo?>"><?=$nom_tipo?></option>
		<?php 
		}
		?>
	</select>
<?php
} else {

	$des_region = "SELECT * FROM tipo WHERE id_tipo=$tiprest";
	$des_region = mysql_db_query($dbname, $des_region); 
	if ($row = mysql_fetch_array($des_region)){ 

		$id_tipo = $row["id_tipo"];
		$nom_tipo = $row["nom_tipo"];
	}
?>
	<h5>
		<a class="" onclick="quitarTipRest()">
			<?=$nom_tipo?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="tiprest" value="<?=$tiprest?>">

<?php
}
?>

	
