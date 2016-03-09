<?php 

include ("admin/config.php");


$desdetien = $_GET['desdetien'];

$min_desde_tien = "SELECT MIN(val_aprecio) FROM aprecio";
$min_desde_tien = mysql_db_query($dbname, $min_desde_tien);
$min_desde_tien = mysql_result($min_desde_tien, 0);

$max_desde_tien = "SELECT MAx(val_aprecio) FROM aprecio";
$max_desde_tien = mysql_db_query($dbname, $max_desde_tien);
$max_desde_tien = mysql_result($max_desde_tien, 0);

if ($desdetien=="Ninguna") {
?>
	<select name="desdetien" class="input-small" OnChange="selectDesdeTien()">
		<option value="Ninguna">Desde</option>

		<?php

			if ($min_desde_tien!=0) {
				$val_desde_tien=number_format($min_desde_tien,2);
				?>
				<option value="<?=$val_desde_tien?>"><?=$val_desde_tien." USD"?></option>
				<?php
			}

			for ($pre_desde_tien=0; $pre_desde_tien <= $max_desde_tien; $pre_desde_tien+=20) {
				
				if ($pre_desde_tien>$min_desde_tien) {
					$val_desde_tien=number_format($pre_desde_tien,2);
					?>
					<option value="<?=$val_desde_tien?>"><?=$val_desde_tien." USD"?></option>
					<?php
				}
				
			}

			$mod_desde_tien=$max_desde_tien%20;

			if (($pre_desde_tien > $max_desde_tien) AND ($mod_desde_tien != 0)) {
				$val_desde_tien=number_format($max_desde_tien,2);
				?>
				<option value="<?=$val_desde_tien?>"><?=$val_desde_tien." USD"?></option>
			
				<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarDesdeTien()">
			<?=$desdetien." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="desdetien" value="<?=$desdetien?>">
<?php
}
?>

			