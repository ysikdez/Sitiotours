<!-- Comentarios facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<article class="span4">
	<?php
		$url_pag_tip = pagUrl($dbname,$id);$pagurl="";
		$url_pag_tip = substr($url_pag_tip, 0, -1);
	?>
	<h3>
		Compartir en:
		<!-- Facebook -->
		<a href="http://www.facebook.com/sharer.php?u=http://sitiotours.com/<?=$url_pag_tip?>" target="_blank"><i class="icon-facebook ico-facebook"></i></a>
		 
		<!-- Twitter -->
		<a href="http://twitter.com/share?url=http://sitiotours.com/<?=$url_pag_tip?>&text=<?=$tit_pos?>:Sitiotours.com&hashtags=sitiotours" target="_blank"><i class="icon-twitter ico-twitter"></i></a>
		 
		<!-- Google+ -->
		<a href="https://plus.google.com/share?url=http://sitiotours.com/<?=$url_pag_tip?>" target="_blank"><i class="icon-google ico-google"></i></a>
	</h3>
	<br>
	<h4>Comentarios » </h4>
	<?php

	//Datos del comentario
		$pos_pag_pad = "SELECT per_tic FROM tic WHERE id_pagina='$id' && niv_tic='0' && per_tic='0' && ord_tic='0'";
		$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
		if ($row = mysql_fetch_array($posi_pag_pad)){ $per_tic = $row["per_tic"]; }
			
		ComentPag($dbname,$id,0);

	?>
	<div id="coment_0">
		<form enctype="multipart/form-data" name="formulario_0">
			<h5>Nueva Recomendacion - Tips » <?=$per_tic?></h5>
			<label>
				<input type="text" name="nick_0" id="nick_0" class="span3" placeholder="Nombre" value="">
			</label>
			<label>
				<input type="email" name="mail_0" id="mail_0" class="span3" placeholder="E-mail" value="">
			</label>
			<label>
				<textarea rows="2" name="des_0" id="des_0" class="span3" placeholder="Comentario"></textarea>
			</label>
			<label class="checkbox inline">
				<input type="checkbox" name="like_0" id="like_0" value="1"> 
				Desea que le Enviemos Informacion 
			</label>
			<a class="btn btn-primary btn-sitio pull-right" onclick="Coment('0','<?=$id?>')">Guardar</a>
		</form>
	</div>
	<hr>
	<!-- Plugin de Comentarios para el FB -->
	<div class="fb-comments" data-href="http://sitiotours.com/<?=$url_pag_tip?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>

</article>