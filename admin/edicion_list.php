<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];

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
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.js"></script>

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Paginas</title>
	</head>

	<body>
		<div class="row contorno">

<?php
  $query = "SELECT * FROM pagina WHERE id_pagina='$ids'";
  $conf = mysql_db_query($dbname, $query);

  if ($row = mysql_fetch_array($conf)){

    $dise = $row["dise_pagina"];
    $ord = $row["ord_pagina"];
    $niv = $row["niv_pagina"];
    $per = $row["per_pagina"];
    $codigo = $row["cod_pagina"];
    $tit_pos_pag = $row["tit_pos_pagina"];

    $n_menu = "SELECT COUNT(ord_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids'";
    $orden = mysql_db_query($dbname, $n_menu);
    $orden = mysql_result($orden, 0);

?>
			<h3>Edición » <?=$tit_pos_pag?></h3>
			<div class="accordion text-justify">
			    <div class="accordion-group">
					<div class="accordion-titulo maps<?=$niv?>">
			        
			        
						<p class="numero"><strong><?=$ord?></strong></p>
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#orden<?=$per?>-<?=$niv?>-<?=$ord?>"><strong><?=$tit_pos_pag?></strong></a>           

						<a  
						<?php
							switch ($dise) {

								//General
								case "General":
							?>
								href="dise_general.php?id=<?=$ids?>"
							<?php
								break;

								//Tour
								case "Tour":
							?>
								href="dise_tour.php?id=<?=$ids?>"
							<?php				
								break;

								//Destino
								case "Destino":
							?>
								href="dise_destino.php?id=<?=$ids?>"
							<?php								
								break;

								//Opcion de Viaje
								case "Opcion de Viaje":
							?>
								href="dise_opcion.php?id=<?=$ids?>"
							<?php				
								break;

								//Agencia de Viaje
								case "Agencia de Viaje":
							?>
								href="dise_agencia.php?id=<?=$ids?>"
							<?php
								break;

								//Alojamiento - Hotel
								case "Alojamiento - Hotel":
							?>
								href="dise_alojamiento.php?id=<?=$ids?>"
							<?php			
								break;

								//Restaurante
								case "Restaurante":
							?>
								href="dise_restaurante.php?id=<?=$ids?>"
							<?php				
								break;

								//Tienda
								case "Tienda":
							?>
								href="dise_tienda.php?id=<?=$ids?>"
							<?php				
								break;

								//Regalo - Souvenir
								case "Regalo - Souvenir":
							?>
								href="dise_souvenir.php?id=<?=$ids?>"
							<?php				
								break;

								//Comida Tipica
								case "Comida Tipica":
							?>
								href="dise_tipica.php?id=<?=$ids?>"
							<?php			
								break;

								//Sitio Turistico
								case "Sitio Turistico":				
							?>
								href="dise_sitio.php?id=<?=$ids?>"
							<?php
								break;

								//Recomendacion - Tic Turistico
								case "Recomendacion - Tic Turistico":
							?>
								href="dise_tic.php?id=<?=$ids?>"
							<?php
								break;

								//Galeria
								case "Galeria":
							?>
							<?php
								break;

								//Enlace
								case "Enlace":
							?>
							<?php
								break;

								//Mapa del Sitio
								case "Mapa del Sitio":
							?>
							<?php
								break;

							}
						?>
						target="edicion" title="<?=$dise?>">
						<div class="pull-right icono"><i class="icon-edit"></i></div>
						</a>

						<?php if($orden!=0 && $ids!=0) { ?>
						<a href="edicion_list.php?id=<?=$ids?>" target="seleccion">
						<div class="pull-right icono"><i class="icon-list"></i></div>
						</a>
						<?php } else { ?>
						<div class="pull-right icono"><i class="esp-ico"></i></div>
						<?php } ?>

					</div>

					<div id="orden<?=$per?>-<?=$niv?>-<?=$ord?>" class="accordion-body collapse in">
						<div class="accordion-inner">

<?php
		edicion($dbname,1,$ids);
?>
						</div>
					</div>
				</div>
<?php     
  }mysql_free_result($conf);
?>

			</div>
		</div>
<script type="text/javascript">
	window.open('inicio.html', 'edicion', '');
</script>
	</body>
</html>
