<?php 

include ("admin/config.php");


$esprest = $_GET['esprest'];

if ($esprest=="Ninguna") {
?>
	<select name="esprest" OnChange="selectEspRest()">
		<option value="Ninguna">Especialidad</option>

		<?php
		//Datos de los detalles del Diseño General
		$des_especialidad = "SELECT * FROM especialidad ORDER BY nom_especialidad";
		$des_especialidad = mysql_db_query($dbname, $des_especialidad); 
		while ($row = mysql_fetch_array($des_especialidad)){ 

			$id_especialidad = $row["id_especialidad"];
			$nom_especialidad = $row["nom_especialidad"];

		?>
		<option value="<?=$id_especialidad?>"><?=$nom_especialidad?></option>
		<?php 
		}
		?>
	</select>
<?php
} else {

	$des_especialidad = "SELECT * FROM especialidad WHERE id_especialidad=$esprest";
	$des_especialidad = mysql_db_query($dbname, $des_especialidad); 
	if ($row = mysql_fetch_array($des_especialidad)){ 
		$id_especialidad = $row["id_especialidad"];
		$nom_especialidad = $row["nom_especialidad"];
	}
?>
	<h5>
		<a class="" onclick="quitarEspRest()">
			<?=$nom_especialidad?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="esprest" value="<?=$esprest?>">

<?php
}
?>

	
