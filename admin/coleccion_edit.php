<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$nombre = $_GET['nom'];

//Titulo de la Pagina
$let_pag = "SELECT tit_pos_pagina FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 
	$tit_pos_pagina = $row["tit_pos_pagina"];
}

//Titulo de la Coleccion del Letrero
$let_pag = "SELECT tip_letrero_ima_prin FROM letrero_ima_prin WHERE tip_letrero_ima_prin='$nombre'";
$let_pag = mysql_db_query($dbname, $let_pag); 
if ($row = mysql_fetch_array($let_pag)){ 
	$tip_letrero_ima_prin = $row["tip_letrero_ima_prin"];
}

?>



<h4>Coleccion del Carrusel » <?=$tit_pos_pagina?> » <?=$tip_letrero_ima_prin?></h4>
<p>Debe de Guardar el Tipo de la Coleccion para editar la Coleccion</p>
<?php
//Cantidad de Imagenes Principales 
$n_ima = "SELECT MAX(pos_letrero_ima_prin) FROM letrero_ima_prin WHERE tip_letrero_ima_prin='$nombre'";
$max_ima = mysql_db_query($dbname, $n_ima);
$max_ima = mysql_result($max_ima, 0);
$sig_ima = $max_ima+1;

//Datos del Letrero
$let_pag = "SELECT * FROM letrero_ima_prin WHERE tip_letrero_ima_prin='$nombre' ORDER BY pos_letrero_ima_prin";
$ima_pag = mysql_db_query($dbname, $let_pag); 
while ($row = mysql_fetch_array($ima_pag)){ 

	$id_letrero_ima_prin = $row["id_letrero_ima_prin"];
	$id_letrero = $row["id_letrero"];
	$id_ima_prin = $row["id_ima_prin"];
	$pos_letrero_ima_prin = $row["pos_letrero_ima_prin"];
	$tip_letrero_ima_prin = $row["tip_letrero_ima_prin"];

		$let_pag = "SELECT * FROM letrero WHERE id_letrero='$id_letrero'";
		$posi_pag = mysql_db_query($dbname, $let_pag); 
		if ($row = mysql_fetch_array($posi_pag)){ 

			$tit_letrero = $row["tit_letrero"];
			$des_letrero = $row["des_letrero"];

		}

		$let_pag = "SELECT * FROM ima_prin WHERE id_ima_prin='$id_ima_prin'";
		$posi_pag = mysql_db_query($dbname, $let_pag); 
		if ($row = mysql_fetch_array($posi_pag)){ 

			$arch_ima_prin = $row["arch_ima_prin"];
			$tit_ima_prin = $row["tit_ima_prin"];

		}
?>
<div class="tour-caja ima-prin">
	<p class="numero"><strong><?=$pos_letrero_ima_prin?></strong></p>
	<a href="letrero_eli.php?id=<?=$ids?>&letrero=<?=$id_letrero_ima_prin?>" onclick='return confirm("¿Esta seguro que desea eliminar esta Imagen?")'>
		<div class="pull-right icono"><i class="icon-remove"></i></div>
	</a>

<?php
//Siguiente
if($pos_letrero_ima_prin!=$max_ima) { ?>
	<a href="letrero_ord.php?id=<?=$ids?>&sig=1&pos=<?=$pos_letrero_ima_prin?>&nom<?=$tip_letrero_ima_prin?>" title="Siguiente">
		<div class="pull-right icono"><i class="icon-chevron-right"></i></div>
	</a>
<?php } else { ?>
	<div class="pull-right icono"><i class="esp-ico"></i></div>
<?php } ?>	</a>


<?php 
//Anterior
if($pos_letrero_ima_prin!=1) { ?>
	<a href="letrero_ord.php?id=<?=$ids?>&sig=0&pos=<?=$pos_letrero_ima_prin?>&nom=<?=$tip_letrero_ima_prin?>" title="Anterior">
		<div class="pull-right icono"><i class="icon-chevron-left"></i></div>
	</a>
<?php } else { ?>
	<div class="pull-right icono"><i class="esp-ico"></i></div>
<?php } ?>


	<a href="letrero_edit.php?id=<?=$ids?>&letrero=<?=$id_letrero_ima_prin?>" title="Editar">
		<div class="pull-right icono"><i class="icon-edit"></i></div>
	</a>

	<figure>
	<img src="../image/<?=$arch_ima_prin?>" alt="<?=$tit_ima_prin?>" border="0">
	</figure>
	<figcaption>
		<h5><?=$tit_letrero?></h5>
		<?=$des_letrero?>
	</figcaption>
</div>
<?php 
	}
?>
<br><br>
<a class="btn btn-sitio pull-right btn-small" type="submit" data-toggle="modal" href="#nuevaimagen"><i class="icon-plus"></i></a>


<div id="nuevaimagen" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imagen" aria-hidden="true">
	<form method="post" enctype="multipart/form-data" name="formulario" action="letrero_nue.php">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="imagen">Coleccion del Carrusel » <?=$tip_letrero_ima_prin?> » <span class="numero"><?=$sig_ima?> </span> Imagen</h3>
		</div>

		<div class="modal-body">
			<h4>Datos del Carrusel</h4>
			<br>
			<h5>Letrero</h5>
			<input type="hidden" name="id" value="<?=$ids?>">
			<input type="hidden" name="coleccion" value="<?=$tip_letrero_ima_prin?>">
			<select name="ico_letrero">
				<option value="Sin Icono">Sin Icono</option>
				<option value="icon-tour">Tour</option>
				<option value="icon-destino">Destino</option>
				<option value="icon-opcion">Opcion de Viaje</option>
				<option value="icon-agencia">Agencia</option>
				<option value="icon-hotel">Alojamiento</option>
				<option value="icon-restaurante">Restaurante</option>
				<option value="icon-tienda"> Tienda</option>
				<option value="icon-souvenir">Souvenir</option>
				<option value="icon-comida">Comida Tipica</option>
				<option value="icon-sitio">Sitio Turistico</option>
				<option value="icon-actividad">Actividad Turistica</option>
				<option value="icon-tic">Recomendacion Turistica</option>
			</select>
			<input name="tit_letrero" type="text" class="span5" placeholder="Titulo" required title="Titulo del Letrero">

			<div class="input-prepend pull-right">
				<span class="add-on"><small><small>Pal.</small></small></span>
				<input type="text" id="pal_des" class="jerarquia" value="0">
			</div>
			<div class="input-prepend pull-right">
				<span class="add-on"><small><small>Car.</small></small></span>
				<input type="text" id="car_des" class="jerarquia" value="0">
			</div>
			<br>
			<textarea name="des_letrero" rows="3" id="tex_des" class="span5" onKeyDown="cuentaDescripcion()" onKeyUp="cuentaDescripcion()" placeholder="Descripcion" required title="Se necesita una Descripcion del Letrero"></textarea>

			<input name="btn_letrero" type="text" class="span5" placeholder="Nombre del Boton" required title="Se necesita Nombre del Boton del letrero">
			<input name="link_letrero" type="text" class="span5" placeholder="Link del Boton"  required title="Se necesita el enlace del Boton">

			<br>
			<h5>Datos del Posicionamiento de la Imagen</h5>
			<input name="tit_ima_prin" type="text" class="span5" placeholder="Titulo de la Imagen / Alt" required title="Se necesita el titulo de la Imagen">
			<textarea name="des_ima_prin" rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"></textarea>
			<input name="lug_ima_prin" type="text" class="span5" placeholder="Lugar de la Imagen"  required title="Se necesita el lugar de la Imagen">
			<label>
				<h6>Fecha de la Imagen</h6>
				<input name="fecha" type="date" required title="Se necesita la fecha de la Imagen">
				<input name="hora" type="time" class="hora">
			</label>
			<h6>Archivo de la Imagen</h6>
			<input name="arch_ima_prin" type="file" class="txt" required title="Se necesita Seleccionar el archivo de la Imagen">
		</div>

		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button class="btn btn-primary btn-sitio">Save changes</button>
		</div>
	</form>
</div>

