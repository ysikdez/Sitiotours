<?php 

include ("admin/config.php");


$desdepla = $_GET['desdepla'];

$min_desde_pla = "SELECT MIN(val_aprecio) FROM aprecio";
$min_desde_pla = mysql_db_query($dbname, $min_desde_pla);
$min_desde_pla = mysql_result($min_desde_pla, 0);

$max_desde_pla = "SELECT MAx(val_aprecio) FROM aprecio";
$max_desde_pla = mysql_db_query($dbname, $max_desde_pla);
$max_desde_pla = mysql_result($max_desde_pla, 0);

if ($desdepla=="Ninguna") {
?>
	<select name="desdepla" class="input-small" OnChange="selectDesdeRest()">
		<option value="Ninguna">Desde</option>

		<?php

			if ($min_desde_pla!=0) {
				$val_desde_pla=number_format($min_desde_pla,2);
				?>
				<option value="<?=$val_desde_pla?>"><?=$val_desde_pla." USD"?></option>
				<?php
			}

			for ($pre_desde_pla=0; $pre_desde_pla <= $max_desde_pla; $pre_desde_pla+=20) {
				
				if ($pre_desde_pla>$min_desde_pla) {
					$val_desde_pla=number_format($pre_desde_pla,2);
					?>
					<option value="<?=$val_desde_pla?>"><?=$val_desde_pla." USD"?></option>
					<?php
				}
				
			}

			$mod_desde_pla=$max_desde_pla%20;

			if (($pre_desde_pla > $max_desde_pla) AND ($mod_desde_pla != 0)) {
				$val_desde_pla=number_format($max_desde_pla,2);
				?>
				<option value="<?=$val_desde_pla?>"><?=$val_desde_pla." USD"?></option>
			
				<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarDesdeRest()">
			<?=$desdepla." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="desdepla" value="<?=$desdepla?>">
<?php
}
?>

			