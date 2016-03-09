<?php 

include ("admin/config.php");


$has = $_GET['has'];

	$min_hasta = "SELECT MIN(val_tprecio) FROM tprecio";
	$min_hasta = mysql_db_query($dbname, $min_hasta);
	$min_hasta = mysql_result($min_hasta, 0);

	$max_hasta = "SELECT MAx(val_tprecio) FROM tprecio";
	$max_hasta = mysql_db_query($dbname, $max_hasta);
	$max_hasta = mysql_result($max_hasta, 0);

if ($has=="Ninguna") {
?>
	<select name="hasta" class="input-small" OnChange="selectHasta()">
		<option value="Ninguna">Hasta</option>

		<?php

			if ($min_hasta!=0) {
				$val_hasta=number_format($min_hasta,2);
				?>
				<option value="<?=$val_hasta?>"><?=$val_hasta." USD"?></option>
				<?php
			}

			for ($pre_hasta=0; $pre_hasta <= $max_hasta; $pre_hasta+=100) {
				
				if ($pre_hasta!=0) {
					$val_hasta=number_format($pre_hasta,2);
					?>
					<option value="<?=$val_hasta?>"><?=$val_hasta." USD"?></option>
					<?php
				}
				
			}
			$mod_hasta=$max_hasta%100;
			if (($pre_hasta > $max_hasta) AND ($mod_hasta != 0)) {
				$val_hasta=number_format($max_hasta,2);
			?>
				<option value="<?=$val_hasta?>"><?=$val_hasta." USD"?></option>
			
			<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarHasta()">
			<?=$has." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="hasta" value="<?=$has?>">
<?php
}
?>

			