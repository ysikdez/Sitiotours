<?php 

include ("admin/config.php");


$cattien = $_GET['cattien'];

if ($cattien=="Ninguna") {
?>
	<select name="cattien" OnChange="selectCatTien()">
		<option value="Ninguna">Categoria</option>

		<?php
		//Datos de los detalles del Diseño General
		$des_cattien = "SELECT * FROM categoria";
		$des_cattien = mysql_db_query($dbname, $des_cattien); 
		while ($row = mysql_fetch_array($des_cattien)){ 

			$id_categoria = $row["id_categoria"];
			$nom_categoria = $row["nom_categoria"];

		?>
		<option value="<?=$id_categoria?>"><?=$nom_categoria?></option>
		<?php 
		}
		?>
	</select>
<?php
} else {

	$des_categoria = "SELECT * FROM categoria WHERE id_categoria=$cattien";
	$des_categoria = mysql_db_query($dbname, $des_categoria); 
	if ($row = mysql_fetch_array($des_categoria)){ 

		$nom_categoria = $row["nom_categoria"];
	}
?>
	<h5>
		<a class="" onclick="quitarCatTien()">
			<?=$nom_categoria?> <i class="icon-remove"></i>
		</a>
	</h5>
	<input type="hidden" name="cattien" value="<?=$cattien?>">

<?php
}
?>

	
