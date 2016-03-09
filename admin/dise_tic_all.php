<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$error = $_GET['error'];



//Datos de la Pagina
$pos_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 

	$id_idi = $row["id_idioma"];
	$cod_pag = $row["cod_pagina"];

	$per_pag = $row["per_pagina"];

	$dise_pag = $row["dise_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
	
	$logo_pag = $row["logo_pagina"];
	$alt_logo_pag = $row["alt_logo_pagina"];
	$des_logo_pag = $row["des_logo_pagina"];

}

//Datos de la Pagina Padre ---- Tipo del Destino que lo Agrupa
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ $tit_pos_pag_pad = $row["tit_pos_pagina"]; }


//Datos de la Pagina de los Comentarios 
$dato_comentarios = "SELECT * FROM pagina WHERE tit_pos_pagina='$tit_pos_pag'";
$dato_comentarios = mysql_db_query($dbname, $dato_comentarios); 
if ($row = mysql_fetch_array($dato_comentarios)){ 

	$id_pag_coment = $row["id_pagina"];

}

if ($id_pag_coment==0 OR $id_pag_coment==1 OR $id_pag_coment==2 OR $id_pag_coment==3) {
	$id_pag_comentario="'0','1','2','3'";
} else {

	$id_pag_comentario = "'".$id_pag_coment."',".pagInternas($dbname,$id_pag_coment);
	$id_pag_comentario = substr($id_pag_comentario, 0, -1);
}


$fecha = date("Y-m-d H:i:s");	// 2001-03-10 17:16:18

if (!$_POST) {
	
} else {
}

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link href="../css/bootstrap.css" rel="stylesheet">
		<link href="css/estilos.css" rel="stylesheet">
		<link href="../img/ico-sitiotours.png" rel="shortcut icon">

		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="js/script.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="ckeditor/ckeditor.js"></script>

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Recomendaciones</title>
	</head>
	<body>
		<div class="row contorno">
			<a class="btn btn-sitio pull-right" href="dise_top_tic.php?id=<?=$ids?>"><i class="icon-arrow-left"></i></a>
			<br><br>
			<h4 class="pull-right">Codigo : <?=$cod_pag?></h4>					
			<h3>» <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_pos_pag?></h4>
			<br>
			<hr>
			
<?php

// maximo por pagina
$limit = 5;

// pagina pedida
$pag = (int) $_GET["pag"];
if ($pag < 1)
{
   $pag = 1;
}
$offset = ($pag-1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT
			tic.id_tic,
			tic.id_pagina,
			pagina.tit_pos_pagina,
			pagina.url_pagina,
			tic.fc_hr_tic,
			tic.nick_tic,
			tic.des_tic,
			tic.mail_tic,
			tic.vist_tic,
			tic.fav_tic,
			tic.pic_tic
			FROM

				((pagina INNER JOIN tic ON pagina.id_pagina=tic.id_pagina) LEFT JOIN val_tic ON tic.id_tic=val_tic.id_tic)
			
			WHERE tic.id_pagina IN ($id_pag_comentario)
			
			ORDER BY val_tic.pun_val_tic DESC
			
			LIMIT $offset,$limit";

$sqlTotal = "SELECT FOUND_ROWS() as total";

$rs = mysql_query($sql);
$rsTotal = mysql_query($sqlTotal);

$rowTotal = mysql_fetch_assoc($rsTotal);
// Total de registros sin limit
$total = $rowTotal["total"];


         while ($row = mysql_fetch_assoc($rs))
         {
				$id_pag = $row["id_pagina"]; 
				$id_tic = $row["id_tic"]; 
				$titulo = $row["tit_pos_pagina"]; 
				$url = $row["url_pagina"]; 

				$nombre = $row["nick_tic"]; 
				$fecha = $row["fc_hr_tic"]; 
				$des = $row["des_tic"]; 
				$mail = $row["mail_tic"]; 
				$vist = $row["vist_tic"]; 
				$fav = $row["fav_tic"]; 


				// suma de Tics de la Pagina
				$sum_val = "SELECT SUM(pun_val_tic) FROM val_tic WHERE id_tic='$id_tic'";
				$sum_val = mysql_db_query($dbname, $sum_val);
				$sum_val = mysql_result($sum_val, 0);


				// Numero de Tics de la Pagina
				$n_val = "SELECT COUNT(id_val_tic) FROM val_tic WHERE id_tic='$id_tic'";
				$n_val = mysql_db_query($dbname, $n_val);
				$n_val = mysql_result($n_val, 0);

				$pro_val = $sum_val / $n_val;
				$pro_val = round($pro_val, 0);

         ?>

			<div class="media">
				<div class="pull-left">
					<img class="media-object img-circle guinda" data-src="holder.js/45x4" alt="45x45" src="img/<?=$pic_tic?>" style="width: 45x; height: 45px;">
				</div>
				<div class="media-body">
					<div class="pull-right">
						<strong><small><?=$fecha?> </small> </strong> <p class="numero"></p>
						<strong> <?=$pro_val?> </strong> <i class="icon-pie1"></i> 
						<br>
						<strong class="pull-right"> (<small>Votos <?=$n_val?></small>)</strong>
					</div>
					<div id="res_vito_<?=$id_tic?>" class="inline-block">
						<?php if ($vist==1) {?> <i class="icon-eye-open"></i> <?php } else {?> <i class="icon-eye-close"></i> <?php }?>
					</div>
					<div id="res_fav_<?=$id_tic?>" class="inline-block">
						<?php if ($fav==1) {?> <i class="icon-heart"></i> <?php } ?>
					</div>

						<h4 class="media-heading"><?=$nombre?></h4>
						<h5 class="media-heading"><?=$mail?></h5>
						<small><?=$des?></small><br>
						<label class="checkbox inline opcion-mini">
						<input type="checkbox" name="visto_<?=$id_tic?>" id="visto_<?=$id_tic?>" <?php if ($vist==1) {?> checked <?php }?> value="1" onclick="Visto('<?=$id_tic?>')"> Leido
						</label>
						<label class="checkbox inline opcion-mini">
						<input type="checkbox" name="favorito_<?=$id_tic?>" id="favorito_<?=$id_tic?>" <?php if ($fav==1) {?> checked <?php }?> value="1" onclick="Favorito('<?=$id_tic?>')"> Favorito
						</label>
						<br>
				</div>

				<div>
					<a class="pull-right" data-toggle="collapse" data-target="#responder<?=$id_tic?>">
						<i class="icon-retweet"></i>
					</a>
				<br>

				<div id="responder<?=$id_tic?>" class="collapse media-body">
					<div class="span5" id="coment_<?=$id_tic?>">
						<form method="post" enctype="multipart/form-data" name="formulario_<?=$id_tic?>" action="">
							<h5>Nueva Recomendacion - Tic's »</h5>
							<label>
								<input type="text" name="nick_<?=$id_tic?>" id="nick_<?=$id_tic?>" class="span5" placeholder="Nombre" value="Ysik">
							</label>
							<label>
								<input type="text" name="mail_<?=$id_tic?>" id="mail_<?=$id_tic?>" class="span5" placeholder="E-mail" value="info@sitiotours.com">
							</label>
							<label>
								<textarea rows="2" name="des_<?=$id_tic?>" id="des_<?=$id_tic?>" class="span5" placeholder="Comentario"></textarea>
							</label>
							<label class="checkbox inline">
								<input type="checkbox" name="like_<?=$id_tic?>" id="like_<?=$id_tic?>" value="1"> 
								Desea que le Enviemos Informacion 
							</label>
							<button class="btn btn-primary btn-sitio pull-right" onclick="Coment('<?=$id_tic?>','<?=$id_pag?>')">Guardar</button>
						</form>
					</div>          
				</div>
			</div>
			<br><br>

         <?php
         }
      ?>


			<div class="pagination">
				<ul>
		<?php


			$totalPag = ceil($total/$limit);
			$links = array();

			if ($totalPag<=5){

				for( $i=1; $i<=$totalPag ; $i++)
				{
					if ($pag==$i) { $on="class='active'"; } else { $on=""; }
					$n=$i;

					$links[] = "<li ".$on."><a href=\"?id=$ids&pag=$i\">$n</a></li>"; 
				}

			}else{

				
				if ($pag < 5){ 

					$ini=1; 
					$fin=5;

				} else{ 

					$ini=$pag-2;
					$fin=$pag+2;
				}		

				if ($fin >= $totalPag) { $fin=$totalPag; } 

				for( $i=$ini; $i<=$fin ; $i++)
				{	
					$n=$i; 
					if ($pag==$i) { $on="class='active'"; } else { $on=""; }
					if ($ini==$i && $i!=1) { $n="«"; } 
					if ($fin==$i && $i!=$totalPag) { $n="»"; }

					$links[] = "<li ".$on."><a href=\"?id=$ids&pag=$i\">$n</a></li>"; 
				}

			}

			echo implode(" ", $links);
		?>
  				</ul>
			</div>
		</div>
	</body>
</html>