<?php 

include ("admin/config.php");


$desdehab = $_GET['desdehab'];

$min_desde_hab = "SELECT MIN(val_hprecio) FROM hprecio";
$min_desde_hab = mysql_db_query($dbname, $min_desde_hab);
$min_desde_hab = mysql_result($min_desde_hab, 0);

$max_desde_hab = "SELECT MAx(val_hprecio) FROM hprecio";
$max_desde_hab = mysql_db_query($dbname, $max_desde_hab);
$max_desde_hab = mysql_result($max_desde_hab, 0);

if ($desdehab=="Ninguna") {
?>
	<select name="desdehab" class="input-small" OnChange="selectDesdeHab()">
		<option value="Ninguna">Desde</option>

		<?php

			if ($min_desde_hab!=0) {
				$val_desde_hab=number_format($min_desde_hab,2);
				?>
				<option value="<?=$val_desde_hab?>"><?=$val_desde_hab." USD"?></option>
				<?php
			}

			for ($pre_desde_hab=0; $pre_desde_hab <= $max_desde_hab; $pre_desde_hab+=20) {
				
				if ($pre_desde_hab>$min_desde_hab) {
					$val_desde_hab=number_format($pre_desde_hab,2);
					?>
					<option value="<?=$val_desde_hab?>"><?=$val_desde_hab." USD"?></option>
					<?php
				}
				
			}

			$mod_desde_hab=$max_desde_hab%20;

			if (($pre_desde_hab > $max_desde_hab) AND ($mod_desde_hab != 0)) {
				$val_desde_hab=number_format($max_desde_hab,2);
				?>
				<option value="<?=$val_desde_hab?>"><?=$val_desde_hab." USD"?></option>
			
				<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarDesdeHab()">
			<?=$desdehab." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="desdehab" value="<?=$desdehab?>">
<?php
}
?>

			