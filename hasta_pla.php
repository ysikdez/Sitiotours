<?php 

include ("admin/config.php");


$hastapla = $_GET['hastapla'];

$min_hasta_pla = "SELECT MIN(val_pprecio) FROM pprecio";
$min_hasta_pla = mysql_db_query($dbname, $min_hasta_pla);
$min_hasta_pla = mysql_result($min_hasta_pla, 0);

$max_hasta_pla = "SELECT MAx(val_pprecio) FROM pprecio";
$max_hasta_pla = mysql_db_query($dbname, $max_hasta_pla);
$max_hasta_pla = mysql_result($max_hasta_pla, 0);

if ($hastapla=="Ninguna") {
?>
	<select name="hastapla" class="input-small" OnChange="selectHastaRest()">
		<option value="Ninguna">Hasta</option>

		<?php

			$min_hasta_pla = "SELECT MIN(val_pprecio) FROM pprecio";
			$min_hasta_pla = mysql_db_query($dbname, $min_hasta_pla);
			$min_hasta_pla = mysql_result($min_hasta_pla, 0);

			$max_hasta_pla = "SELECT MAx(val_pprecio) FROM pprecio";
			$max_hasta_pla = mysql_db_query($dbname, $max_hasta_pla);
			$max_hasta_pla = mysql_result($max_hasta_pla, 0);

			if ($min_hasta_pla!=0) {
				$val_hasta_pla=number_format($min_hasta_pla,2);
				?>
				<option value="<?=$val_hasta_pla?>"><?=$val_hasta_pla." USD"?></option>
				<?php
			}

			for ($pre_hasta_pla=0; $pre_hasta_pla <= $max_hasta_pla; $pre_hasta_pla+=20) {
				
				if ($pre_hasta_pla>$min_hasta_pla) {
					$val_hasta_pla=number_format($pre_hasta_pla,2);
					?>
					<option value="<?=$val_hasta_pla?>"><?=$val_hasta_pla." USD"?></option>
					<?php
				}

				
			}

			$mod_hasta_pla=$max_hasta_pla%20;
			if (($pre_hasta_pla > $max_hasta_pla) AND ($mod_hasta_pla != 0)) {
				$val_hasta_pla=number_format($max_hasta_pla,2);
			?>
				<option value="<?=$val_hasta_pla?>"><?=$val_hasta_pla." USD"?></option>
			
			<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarHastaRest()">
			<?=$hastapla." USD"?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="hastapla" value="<?=$hastapla?>">
<?php
}
?>

			