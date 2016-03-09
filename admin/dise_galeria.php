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
			
			<br><br>
			<h4 class="pull-right">Codigo : <?=$cod_pag?></h4>					
			<h3>» <?=$tit_pos_pag_pad?></h3>
			<h4>» <?=$tit_pos_pag?></h4>
			<br>
			<hr>
			
<?php

//Datos de la Pagina de los Comentarios 
$dato_comentarios = "SELECT * FROM pagina WHERE tit_pos_pagina='$tit_pos_pag'";
$dato_comentarios = mysql_db_query($dbname, $dato_comentarios); 
if ($row = mysql_fetch_array($dato_comentarios)){ 

	$id_pag_coment = $row["id_pagina"];

}

if ($tit_pos_pag=="Fotos") {
	$galeria="imagen";
} else {
	$galeria="video";
}


// maximo por pagina
$limit = 3;

// pagina pedida
$pag = (int) $_GET["pag"];
if ($pag < 1)
{
   $pag = 1;
}
$offset = ($pag-1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $galeria LIMIT $offset, $limit";
$sqlTotal = "SELECT FOUND_ROWS() as total";

$rs = mysql_query($sql);
$rsTotal = mysql_query($sqlTotal);

$rowTotal = mysql_fetch_assoc($rsTotal);
// Total de registros sin limit
$total = $rowTotal["total"];



$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $galeria
			
			ORDER BY ord_".$galeria." ASC

			LIMIT $offset,$limit";

$sqlTotal = "SELECT FOUND_ROWS() as total";

$rs = mysql_query($sql);
$rsTotal = mysql_query($sqlTotal);

$rowTotal = mysql_fetch_assoc($rsTotal);
// Total de registros sin limit
$total = $rowTotal["total"];


         while ($row = mysql_fetch_assoc($rs))
         {
				$id_pag = $row["id_".$galeria]; 
		 
				$tit = $row["tit_".$galeria]; 
				$lug = $row["lug_".$galeria]; 
				$fec = $row["fec_".$galeria]; 
				$hor = $row["hor_".$galeria]; 
				$des = $row["des_".$galeria]; 
				$ord = $row["ord_".$galeria]; 
				$aut = $row["aut_".$galeria]; 

				if ($galeria=="video"){$cod = $row["cod_".$galeria]; } else{ $cod = $row["cod_".$galeria]; }

         ?>

		<div class="tour-caja ">
			<p class="numero"><strong><?=$ord?></strong></p>
			<a href="galeria_foto_eli.php?id=<?=$ids?>&id_ima=<?=$id_ima_galeria?>" onclick='return confirm("¿Esta seguro que desea eliminar esta Imagen?")'>
				<div class="pull-right icono"><i class="icon-remove"></i></div>
			</a>
<?php
if ($galeria=="video"){
?>
			<?=$cod?>
<?php
} else{
?>
			<figure>
			<img src="../image/<?=$arch_gal_imagen?>" alt="<?=$tit_gal_imagen?>" border="0">
			</figure>
<?php
} 
?>

			<figcaption>
				<h5><?=$tit?></h5>
				<h6><?=$aut?></h6>
				<small><?=$lug?> - <?=$fec?></small>
				<br>
				<?=$des?>
			</figcaption>
		</div>

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