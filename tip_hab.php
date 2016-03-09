<?php 

include ("admin/config.php");


$tiphab = $_GET['tiphab'];

if ($tiphab=="Ninguna") {
?>
	<select name="tiphab" OnChange="selectTipHab()">
		<option value="Ninguna">Tipo de Habitacion</option>

		<?php
		//Datos del Tipo de Alojamiento 
		$des_tip_aloja = "SELECT DISTINCT tip_habitacion FROM habitacion ORDER BY tip_habitacion";
		$des_tip_aloja = mysql_db_query($dbname, $des_tip_aloja); 
		while ($row = mysql_fetch_array($des_tip_aloja)){ 

			$tip_habitacion = $row["tip_habitacion"];

		?>
		<option value="<?=$tip_habitacion?>"><?=$tip_habitacion?></option>
		<?php 
		}
		?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarTipHab()">
			<?=$tiphab?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="tiphab" value="<?=$tiphab?>">

<?php
}
?>

	
