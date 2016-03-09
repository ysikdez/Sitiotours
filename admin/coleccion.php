<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];

?>

<h3>Coleccion Nueva del Carrusel</h3>

<form method="post" enctype="multipart/form-data" name="formulario" action="coleccion_nue.php?">
	<input name="nom_coleccion" type="text" class="span5" placeholder="Nombre de la Nueva Coleccion del Carrusel" required title="Se necesita el Nombre de la Nueva Coleccion del Carrusel">
	<br>

	<h4>Datos del Carrusel</h4>
	<br>
	<h5>Letrero</h5>

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
	<input type="hidden" name="id" value="<?=$ids?>">
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
	<textarea name="des_letrero" rows="3" id="tex_des" name="des" class="span5" onKeyDown="cuentaDescripcion()" onKeyUp="cuentaDescripcion()" placeholder="Descripcion" required title="Se necesita una Descripcion del Letrero"></textarea>

	<input name="btn_letrero" type="text" class="span5" placeholder="Nombre del Boton" required title="Se necesita Nombre del Boton del letrero">
	<input name="link_letrero" type="url" class="span5" placeholder="Link del Boton"  required title="Se necesita el enlace del Boton">

	<br>
	<h5>Datos del Posicionamiento de la Imagen</h5>
	<input name="tit_ima_prin" type="text" class="span5" placeholder="Titulo de la Imagen / Alt" required title="Se necesita el titulo de la Imagen">
	<textarea name="des_ima_prin" rows="2" class="span5" placeholder="Descripcion de la Imagen / Figcaption"><?=$des_ima_prin?></textarea>
	<input name="lug_ima_prin" type="text" class="span5" placeholder="Lugar de la Imagen"  required title="Se necesita el lugar de la Imagen">
	<label>
		<h6>Fecha de la Imagen</h6>
		<input name="fecha" type="date" required title="Se necesita la fecha de la Imagen">
		<input name="hora" type="time" class="hora" value="<?=$hora?>">
	</label>
	<h6>Archivo de la Imagen</h6>
	<input name="arch_ima_prin" type="file" class="txt" required title="Se necesita que cargue la Imagen">
	<br><br>
	<button class="btn btn-primary btn-sitio pull-right">Guardar</button>

</form>

