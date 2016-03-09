<?php 

include ("admin/config.php");


$ocarest = $_GET['ocarest'];

if ($ocarest=="Ninguna") {
?>
	<select name="ocarest" OnChange="selectOcaRest()">
		<option value="Ninguna">Ocasión</option>

		<?php
		//Datos de los detalles del Diseño General
		$des_rocasion = "SELECT * FROM rocasion ORDER BY nom_rocasion";
		$des_rocasion = mysql_db_query($dbname, $des_rocasion); 
		while ($row = mysql_fetch_array($des_rocasion)){ 

			$id_rocasion = $row["id_rocasion"];
			$nom_rocasion = $row["nom_rocasion"];

		?>
		<option value="<?=$id_rocasion?>"><?=$nom_rocasion?></option>
		<?php 
		}
		?>
	</select>
<?php
} else {

	$des_rocasion = "SELECT * FROM rocasion WHERE id_rocasion=$ocarest";
	$des_rocasion = mysql_db_query($dbname, $des_rocasion); 
	if ($row = mysql_fetch_array($des_rocasion)){ 

		$id_rocasion = $row["id_rocasion"];
		$nom_rocasion = $row["nom_rocasion"];
	}
?>
	<h5>
		<a class="" onclick="quitarOcaRest()">
			<?=$nom_rocasion?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="ocarest" value="<?=$ocarest?>">

<?php
}
?>

	
