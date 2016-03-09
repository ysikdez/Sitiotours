<?php 

include ("admin/config.php");


$hastatien = $_GET['hastatien'];

$min_hasta_tien = "SELECT MIN(val_aprecio) FROM aprecio";
$min_hasta_tien = mysql_db_query($dbname, $min_hasta_tien);
$min_hasta_tien = mysql_result($min_hasta_tien, 0);

$max_hasta_tien = "SELECT MAx(val_aprecio) FROM aprecio";
$max_hasta_tien = mysql_db_query($dbname, $max_hasta_tien);
$max_hasta_tien = mysql_result($max_hasta_tien, 0);

if ($hastatien=="Ninguna") {
?>
	<select name="hastatien" class="input-small" OnChange="selectHastaTien()">
		<option value="Ninguna">Hasta</option>

		<?php

			$min_hasta_tien = "SELECT MIN(val_pprecio) FROM pprecio";
			$min_hasta_tien = mysql_db_query($dbname, $min_hasta_tien);
			$min_hasta_tien = mysql_result($min_hasta_tien, 0);

			$max_hasta_tien = "SELECT MAx(val_pprecio) FROM pprecio";
			$max_hasta_tien = mysql_db_query($dbname, $max_hasta_tien);
			$max_hasta_tien = mysql_result($max_hasta_tien, 0);

			if ($min_hasta_tien!=0) {
				$val_hasta_tien=number_format($min_hasta_tien,2);
				?>
				<option value="<?=$val_hasta_tien?>"><?=$val_hasta_tien." USD"?></option>
				<?php
			}

			for ($pre_hasta_tien=0; $pre_hasta_tien <= $max_hasta_tien; $pre_hasta_tien+=20) {
				
				if ($pre_hasta_tien>$min_hasta_tien) {
					$val_hasta_tien=number_format($pre_hasta_tien,2);
					?>
					<option value="<?=$val_hasta_tien?>"><?=$val_hasta_tien." USD"?></option>
					<?php
				}

				
			}

			$mod_hasta_tien=$max_hasta_tien%20;
			if (($pre_hasta_tien > $max_hasta_tien) AND ($mod_hasta_tien != 0)) {
				$val_hasta_tien=number_format($max_hasta_tien,2);
			?>
				<option value="<?=$val_hasta_tien?>"><?=$val_hasta_tien." USD"?></option>
			
			<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarHastaTien()">
			<?=$hastatien." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="hastatien" value="<?=$hastatien?>">
<?php
}
?>

			