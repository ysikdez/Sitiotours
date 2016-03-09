<?php 
include ("admin/config.php");
include ("admin/functions.php");

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

		$n_interno = "SELECT COUNT(id_tic) FROM tic WHERE per_tic='$ids' ";
		$interno = mysql_db_query($dbname, $n_interno);
		$interno = mysql_result($interno, 0);

		$n_val = "SELECT COUNT(id_val_tic) FROM val_tic WHERE id_tic='$ids' ";
		$n_val = mysql_db_query($dbname, $n_val);
		$n_val = mysql_result($n_val, 0);

		if ($n_val==0) {

			$pro = 0;

		} else {

			$result = mysql_query("SELECT SUM(pun_val_tic) as total FROM val_tic WHERE id_tic='$ids' ");   
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$row["total"];
			$pro = $row["total"] / $n_val;
			$pro = round($pro,0);

		}

	?>
    <div class="text-right coment-caja ">
      <div class="">
        <div>
          <div id="voto-comentario-<?=$ids?>" class="text-right">
            <?php 
              if ($pro=='0') { $act1='ico-val_off'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
              if ($pro=='1') { $act1='ico-val_on'; $act2='ico-val_off'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
              if ($pro=='2') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_off'; $act4='ico-val_off'; $act5='ico-val_off';} 
              if ($pro=='3') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_off'; $act5='ico-val_off';} 
              if ($pro=='4') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_off';} 
              if ($pro=='5') { $act1='ico-val_on'; $act2='ico-val_on'; $act3='ico-val_on'; $act4='ico-val_on'; $act5='ico-val_on';} 
            ?>
            <small><small><small>
              <a class="icon-pie1 <?=$act1?>" onclick='VotarComentario(<?=$ids?>,1)'></a>
              <a class="icon-pie2 <?=$act2?>" onclick='VotarComentario(<?=$ids?>,2)'></a>
              <a class="icon-pie1 <?=$act3?>" onclick='VotarComentario(<?=$ids?>,3)'></a>
              <a class="icon-pie2 <?=$act4?>" onclick='VotarComentario(<?=$ids?>,4)'></a>
              <a class="icon-pie1 <?=$act5?>" onclick='VotarComentario(<?=$ids?>,5)'></a> <span>   .</span>
            </small></small></small>
          </div>                  
          <h5 class="media-heading text-left">
            <?php if ($fav==1) {?> <i class="icon-heart"></i> <?php } ?>
            <?=$nick?> (<strong><?=$n_val?></strong> Votos)
          </h5>
          <small><small><strong><?=$fc_hr?></strong></small></small>
          <br>
          <small><?=$des?></small><br>
        </div>
        <div class="text-right">
          <a data-toggle="collapse" data-target="#responder<?=$ids?>">
            <i class="icon-retweet"></i>
          </a>
          <div id="responder<?=$ids?>" class="collapse media-body">
            <div class="span3" id="coment_<?=$ids?>">
              <form method="post" enctype="multipart/form-data" name="formulario_<?=$ids?>" action="">
                <h5>Nueva Recomendacion - Tips »</h5>
                <label>
                  <input type="text" name="nick_<?=$ids?>" id="nick_<?=$ids?>" class="span3" placeholder="Nombre" value="">
                </label>
                <label>
                  <input type="email" name="mail_<?=$ids?>" id="mail_<?=$ids?>" class="span3" placeholder="E-mail" value="">
                </label>
                <label>
                  <textarea rows="2" name="des_<?=$ids?>" id="des_<?=$ids?>" class="span3" placeholder="Comentario"></textarea>
                </label>
                <label class="checkbox inline">
                  <input type="checkbox" name="like_<?=$ids?>" id="like_<?=$ids?>" value="1"> 
                  Desea que le Enviemos Informacion 
                </label>
                <a class="btn btn-primary btn-sitio pull-right" onclick="Coment('<?=$ids?>','<?=$id_pagina?>')">Guardar</a>
              </form>
            </div>          
          </div>
        </div>
        <?php
          if ($interno > 0) {
            ComentPag($dbname,$pagina,$ids);
          }
        ?>
      </div>
    </div>


<?php
	}

	if ($per=0) {
?>

	<div class="span3" id="coment_0">
		<form method="post" enctype="multipart/form-data" name="formulario_0" action="">
			<h5>Nueva Recomendacion - Tips »</h5>
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
			<a class="btn btn-primary btn-sitio pull-right" onclick="Coment('0','<?=$ids?>')">Guardar</a>
		</form>
	</div>	

<?php
	} 
?>






