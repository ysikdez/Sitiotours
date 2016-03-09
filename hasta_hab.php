<?php 

include ("admin/config.php");


$hastahab = $_GET['hastahab'];

$min_hasta_hab = "SELECT MIN(val_hprecio) FROM hprecio";
$min_hasta_hab = mysql_db_query($dbname, $min_hasta_hab);
$min_hasta_hab = mysql_result($min_hasta_hab, 0);

$max_hasta_hab = "SELECT MAx(val_hprecio) FROM hprecio";
$max_hasta_hab = mysql_db_query($dbname, $max_hasta_hab);
$max_hasta_hab = mysql_result($max_hasta_hab, 0);

if ($hastahab=="Ninguna") {
?>
	<select name="hastahab" class="input-small" OnChange="selectHastaHab()">
		<option value="Ninguna">Hasta</option>

		<?php

			$min_hasta_hab = "SELECT MIN(val_hprecio) FROM hprecio";
			$min_hasta_hab = mysql_db_query($dbname, $min_hasta_hab);
			$min_hasta_hab = mysql_result($min_hasta_hab, 0);

			$max_hasta_hab = "SELECT MAx(val_hprecio) FROM hprecio";
			$max_hasta_hab = mysql_db_query($dbname, $max_hasta_hab);
			$max_hasta_hab = mysql_result($max_hasta_hab, 0);

			if ($min_hasta_hab!=0) {
				$val_hasta_hab=number_format($min_hasta_hab,2);
				?>
				<option value="<?=$val_hasta_hab?>"><?=$val_hasta_hab." USD"?></option>
				<?php
			}

			for ($pre_hasta_hab=0; $pre_hasta_hab <= $max_hasta_hab; $pre_hasta_hab+=20) {
				
				if ($pre_hasta_hab>$min_hasta_hab) {
					$val_hasta_hab=number_format($pre_hasta_hab,2);
					?>
					<option value="<?=$val_hasta_hab?>"><?=$val_hasta_hab." USD"?></option>
					<?php
				}

				
			}

			$mod_hasta_hab=$max_hasta_hab%20;
			if (($pre_hasta_hab > $max_hasta_hab) AND ($mod_hasta_hab != 0)) {
				$val_hasta_hab=number_format($max_hasta_hab,2);
			?>
				<option value="<?=$val_hasta_hab?>"><?=$val_hasta_hab." USD"?></option>
			
			<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarHastaHab()">
			<?=$hastahab." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="hastahab" value="<?=$hastahab?>">
<?php
}
?>

			