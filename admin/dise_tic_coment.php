<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$per = $_GET['per'];

if ($per == 0) { 
	$id_pagina = $_GET['pag'];
}

$nick = $_GET['nick'];
$mail = $_GET['mail'];
$des = $_GET['des'];
$like = $_GET['like'];

$fecha = date("Y-m-d H:i:s");	// 2001-03-10 17:16:18

//Mira si esta leido el Comentario
$dato_padre = "SELECT * FROM tic WHERE id_tic='$per'";
$dato_padre = mysql_db_query($dbname, $dato_padre); 
if ($row = mysql_fetch_array($dato_padre)){ 

	$id_pagina = $row["id_pagina"]; 
	$niv_pad_tic = $row["niv_tic"]; 
	$ord_pad_tic = $row["ord_tic"]; 
}

// Numeros total de Tic
$n_tic = "SELECT COUNT(id_tic) FROM tic";
$n_tic = mysql_db_query($dbname, $n_tic);
$n_tic = mysql_result($n_tic, 0);
$sig = $n_tic + 1;

// Numero de Tics de la Pagina
$n_tic_pag = "SELECT COUNT(id_tic) FROM tic WHERE per_tic='$per'";
$n_tic_pag = mysql_db_query($dbname, $n_tic_pag);
$n_tic_pag = mysql_result($n_tic_pag, 0);

$niv = $niv_pad_tic+1;
$ord = $n_tic_pag+1;

//codigo
$orden=add_ceros($sig,6);
$ti=str_split($orden,3);
$tipo1=$ti[0];
$tipo2=$ti[1];
$codigo='TIC-'.$tipo1.'-'.$tipo2;

if ($n_tic == 0) { 
	$per=0;
	$niv=1;
	$ord=1;
}


	//Nuevo Tic
	$nuevo_tic = "INSERT INTO tic (

					id_pagina,

					niv_tic,
					ord_tic,
					per_tic,
					cod_tic,

					fc_hr_tic,

					nick_tic,
					mail_tic,
					des_tic,

					vist_tic,
					fav_tic,
					like_tic

				) VALUES(

					'$id_pagina',

					'$niv',
					'$ord',
					'$per',
					'$codigo', 

					'$fecha',

					'$nick',
					'$mail',
					'$des',

					'0',
					'0',
					'$like'

				)";

	$cab_nuevo_tic = mysql_db_query($dbname, $nuevo_tic);

	//

	$query = "SELECT * FROM tic WHERE cod_tic='$codigo' && per_tic='$per' && id_pagina='$id_pagina' ";
	$conf = mysql_db_query($dbname, $query);

	if ($row = mysql_fetch_array($conf)){

		$ids = $row["id_tic"];
		$ord = $row["ord_tic"];
		$niv = $row["niv_tic"];
		$per = $row["per_tic"];
		$cod = $row["cod_tic"];
		$fc_hr = $row["fc_hr_tic"];
		$nick = $row["nick_tic"];
		$des = $row["des_tic"];
		$mail = $row["mail_tic"];
		$vist = $row["vist_tic"];
		$fav = $row["fav_tic"];
		$pic = $row["pic_tic"];	

?>
	<div class="media">
		<div class="pull-left">
			<img class="media-object img-circle guinda" data-src="holder.js/45x4" alt="45x45" src="img/<?=$pic_tic?>" style="width: 45x; height: 45px;">
		</div>

		<div class="media-body">
			<div class="pull-right">
				<strong><small><?=$fc_hr?> </small> </strong> <p class="numero"></p>
				<strong> <?=$pro?> </strong> <i class="icon-pie1"></i> 
				<br>
				<strong class="pull-right"> (<small>Votos <?=$n_val?></small>)</strong>
			</div>
			<div id="res_vito_<?=$ids?>" class="inline-block">
				<?php if ($vist==1) {?> <i class="icon-eye-open"></i> <?php } else {?> <i class="icon-eye-close"></i> <?php }?>
			</div>
			<div id="res_fav_<?=$ids?>" class="inline-block">
				<?php if ($fav==1) {?> <i class="icon-heart"></i> <?php } ?>
			</div>
			<h4 class="media-heading"><?=$nick?></h4>
			<h5 class="media-heading"><?=$mail?></h5>
			<small><?=$des?></small><br>
			<label class="checkbox inline opcion-mini">
				<input type="checkbox" name="visto_<?=$ids?>" id="visto_<?=$ids?>" <?php if ($vist==1) {?> checked <?php }?> value="1" onclick="Visto('<?=$ids?>')"> Leido
			</label>
			<label class="checkbox inline opcion-mini">
				<input type="checkbox" name="favorito_<?=$ids?>" id="favorito_<?=$ids?>" <?php if ($fav==1) {?> checked <?php }?> value="1" onclick="Favorito('<?=$ids?>')"> Favorito
			</label>
			<br>
			<div>
				<a class="pull-right" data-toggle="collapse" data-target="#responder<?=$ids?>">
					<i class="icon-retweet"></i>
				</a>
				<br>

				<div id="responder<?=$ids?>" class="collapse media-body">
					<div class="span5" id="coment_<?=$ids?>">
						<form method="post" enctype="multipart/form-data" name="formulario_<?=$ids?>" action="">
							<h5>Nueva Recomendacion - Tip's »</h5>
							<label>
								<input type="text" name="nick_<?=$ids?>" id="nick_<?=$ids?>" class="span5" placeholder="Nombre" value="Ysik">
							</label>
							<label>
								<input type="text" name="mail_<?=$ids?>" id="mail_<?=$ids?>" class="span5" placeholder="E-mail" value="info@sitiotours.com">
							</label>
							<label>
								<textarea rows="2" name="des_<?=$ids?>" id="des_<?=$ids?>" class="span5" placeholder="Comentario"></textarea>
							</label>
							<label class="checkbox inline">
								<input type="checkbox" name="like_<?=$ids?>" id="like_<?=$ids?>" <?php if ($fav==1) {?> checked <?php }?> value="1"> 
								Desea que le Enviemos Informacion 
							</label>
							<button class="btn btn-primary btn-sitio pull-right" onclick="Coment('<?=$ids?>','<?=$id_pagina?>')">Guardar</button>
						</form>
					</div>          
				</div>
			</div>
			<br>
		</div>
	</div>


<?php
	}

	if ($per=0) {
?>

	<div class="span5" id="coment_0">
		<form method="post" enctype="multipart/form-data" name="formulario_0" action="">
			<h5>Nueva Recomendacion - Tip's »</h5>
			<label>
				<input type="text" name="nick_0" id="nick_0" class="span5" placeholder="Nombre" value="Ysik">
			</label>
			<label>
				<input type="text" name="mail_0" id="mail_0" class="span5" placeholder="E-mail" value="info@sitiotours.com">
			</label>
			<label>
				<textarea rows="2" name="des_0" id="des_0" class="span5" placeholder="Comentario"></textarea>
			</label>
			<label class="checkbox inline">
				<input type="checkbox" name="like_0" id="like_0" <?php if ($fav==1) {?> checked <?php }?> value="1"> 
				Desea que le Enviemos Informacion 
			</label>
			<button class="btn btn-primary btn-sitio pull-right" onclick="Coment('0')">Guardar</button>
		</form>
	</div>	

<?php
	} 
?>






