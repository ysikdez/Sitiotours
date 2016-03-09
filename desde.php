<?php 

include ("admin/config.php");


$des = $_GET['des'];

	$min_desde = "SELECT MIN(val_tprecio) FROM tprecio";
	$min_desde = mysql_db_query($dbname, $min_desde);
	$min_desde = mysql_result($min_desde, 0);

	$max_desde = "SELECT MAx(val_tprecio) FROM tprecio";
	$max_desde = mysql_db_query($dbname, $max_desde);
	$max_desde = mysql_result($max_desde, 0);

if ($des=="Ninguna") {
?>
	<select name="desde" class="input-small" OnChange="selectDesde()">
		<option value="Ninguna">Desde</option>

		<?php

			if ($min_desde!=0) {
				$val_desde=number_format($min_desde,2);
				?>
				<option value="<?=$val_desde?>"><?=$val_desde." USD"?></option>
				<?php
			}

			for ($pre_desde=0; $pre_desde <= $max_desde; $pre_desde+=100) {
				
				if ($pre_desde!=0) {
					$val_desde=number_format($pre_desde,2);
					?>
					<option value="<?=$val_desde?>"><?=$val_desde." USD"?></option>
					<?php
				}
				
			}
			$mod_desde=$max_desde%100;
			if (($pre_desde > $max_desde) AND ($mod_desde != 0)) {
				$val_desde=number_format($max_desde,2);
			?>
				<option value="<?=$val_desde?>"><?=$val_desde." USD"?></option>
			
			<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarDesde()">
			<?=$des." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="desde" value="<?=$des?>">
<?php
}
?>

			