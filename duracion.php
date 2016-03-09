<?php 

include ("admin/config.php");


$dur = $_GET['dur'];

//Titulo de la Pagina
$let_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($posi_pag)){ $tit_pos_pagina = $row["tit_pos_pagina"];}

	$max_duracion = "SELECT MAx(dur_dia_tour) FROM tour";
	$max_duracion = mysql_db_query($dbname, $max_duracion);
	$max_duracion = mysql_result($max_duracion, 0);

if ($dur=="Ninguna") {
?>
	<select name="duracion" class="input-small" OnChange="selectDuracion()">
		<option value="Ninguna">Duración</option>

		<?php

			for ($dura=0; $dura <= $max_duracion; $dura+=5) {

				if ($dura==0) {
					$dia=1;
					?>
					<option value="<?=$dia?>"><?=$dia." dia"?></option>
					<?php	
					} else{
						$dia=$dura;
						// if ($dura==5) { $min=2; }
					?>
					<option value="<?=$dia?>"><?=$min." - ".$dia." dias"?></option>
					<?php
					}
				?>
				<?php
				$min=$dia+1;
			}
			$mod=$max_duracion%5;
			if (($dura > $max_duracion) AND ($mod != 0)) {
				$dia=$max_duracion;
			?>
				<option value="<?=$max_duracion?>"><?=$min." - ".$dia." dias"?></option>
			
			<?php
			}
			?>
	</select>
<?php
} else {
?>
	<h5>
		<a class="" onclick="quitarDuracion()">
			<?php
			$dia=$dur;

			if ($dur==1) {
				
				?>
					<?=$dia." dia"?> <i class="icon-remove"></i>
				<?php	
				} else{

					$min=$dur-4;

					if ($dur==5) { $min=2; }

					$ult=$max_duracion-$dur;
					$mod_ult=$dur%5;
					
					if (($ult<5) AND ($mod_ult!=0)) {
						$mod=$max_duracion%5;
						$min=$max_duracion-($mod-1);
						?>
						<?=$min." - ".$dia." dias"?> <i class="icon-remove"></i>
						<?php

					}else{
						?>
						<?=$min." - ".$dia." dias"?> <i class="icon-remove"></i>
						<?php
					}

				}	?>
		</a>
	</h5>
	<input type="hidden" name="duracion" value="<?=$dur?>">
<?php
}
?>

			