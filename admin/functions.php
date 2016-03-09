<?php
//devuelve el nombre del dia
$nombre_dia = date("w");
switch ($nombre_dia) {
   case 0:
       $nom_dia = "Domingo";
       break;
   case 1:
       $nom_dia = "Lunes";
       break;
   case 2:
       $nom_dia = "Martes";
       break;
   case 3:
       $nom_dia = "Miercoles";
       break;
   case 4:
       $nom_dia = "Jueves";
       break;
   case 5:
       $nom_dia = "Viernes";
       break;
   case 6:
       $nom_dia = "Sabado";
       break;
}

//devuelve el nombre del mes
$nombre_mes = date("n");
switch ($nombre_mes) {
   case 1:
       $nom_mes = "Enero";
       break;
   case 2:
       $nom_mes = "Febrero";
       break;
   case 3:
       $nom_mes = "Marzo";
       break;
   case 4:
       $nom_mes = "Abril";
       break;
   case 5:
       $nom_mes = "Mayo";
       break;
   case 6:
       $nom_mes = "Junio";
       break;
   case 7:
       $nom_mes = "Julio";
       break;
   case 8:
       $nom_mes = "Agosto";
       break;
   case 9:
       $nom_mes = "Setiembre";
       break;
   case 10:
       $nom_mes = "Octubre";
       break;
   case 11:
       $nom_mes = "Noviembre";
       break;
   case 12:
       $nom_mes = "Diciembre";
       break;
   }
  
  $nombre_mes_mas = date("n");
switch ($nombre_mes_mas) {
   case 1:
       $nom_mes_mas = "FEBRERO";
       break;
   case 2:
       $nom_mes_mas = "MARZO";
       break;
   case 3:
       $nom_mes_mas = "ABRIL";
       break;
   case 4:
       $nom_mes_mas = "MAYO";
       break;
   case 5:
       $nom_mes_mas = "JUNIO";
       break;
   case 6:
       $nom_mes_mas = "JULIO";
       break;
   case 7:
       $nom_mes_mas = "AGOSTO";
       break;
   case 8:
       $nom_mes_mas = "SETIEMBRE";
       break;
   case 9:
       $nom_mes_mas = "OCTUBRE";
       break;
   case 10:
       $nom_mes_mas = "NOVIEMBRE";
       break;
   case 11:
       $nom_mes_mas = "DICIEMBRE";
       break;
   case 12:
       $nom_mes_mas = "ENERO";
       break;
   }
  
function dame_nombre_mes($mes){
	 switch ($mes){
	 	case 1:
			$nombre_mes="Enero";
			break;
	 	case 2:
			$nombre_mes="Febrero";
			break;
	 	case 3:
			$nombre_mes="Marzo";
			break;
	 	case 4:
			$nombre_mes="Abril";
			break;
	 	case 5:
			$nombre_mes="Mayo";
			break;
	 	case 6:
			$nombre_mes="Junio";
			break;
	 	case 7:
			$nombre_mes="Julio";
			break;
	 	case 8:
			$nombre_mes="Agosto";
			break;
	 	case 9:
			$nombre_mes="Septiembre";
			break;
	 	case 10:
			$nombre_mes="Octubre";
			break;
	 	case 11:
			$nombre_mes="Noviembre";
			break;
	 	case 12:
			$nombre_mes="Diciembre";
			break;
	}
	return $nombre_mes;
}   
   
function cambiaf_a_normal($fecha){
    ereg( "([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3].".".$mifecha[2].".".$mifecha[1];
    return $lafecha;
}

function cambiaf_a_normal_sinespacios($fecha){
    ereg( "([0-9]{1,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[1].$mifecha[2].$mifecha[3];
    return $lafecha;
}

function cambiaf_a_normalG($fecha){
    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

function cambiaf_a_mysql($fecha){
    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{1,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

function cambiafyh_a_normal($fecha){
    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[4].":".$mifecha[5].":".$mifecha[6]." ".$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

//funcion para agregar a los numeros ceros a la izquierda 
function add_ceros($numero,$ceros) {
$order_diez = explode(".",$numero); 
$dif_diez = $ceros - strlen($order_diez[0]); 
for($m = 0; $m < $dif_diez; $m++) 
	{ 
        @$insertar_ceros .= 0;
	} 
	return $insertar_ceros .= $numero; 
	}
	
//funcion para determinar el numero de palabras en las introducciones de los textos
function palabras_intro_num($var,$palabras_intro_pag)
{
		$tok_not = strtok ($var," ");
		$n_not=0;
		while ($tok_not) {
		$n_not++;
		if ($n_not  < $palabras_intro_pag)
			{echo stripslashes("$tok_not ");}
		$tok_not= strtok (" ");
		}	
		echo "...";				
}

function urls_amigables($url) {
	// Tranformamos todo a minusculas
	$url = strtolower($url);
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'è', 'ê', 'à', 'ô', 'â', 'ü', 'ä', 'ö', 'Ü','Á','É','Í','Ó','Ú');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n', 'e', 'e', 'a', 'o', 'a', 'ue', 'ae', 'oe', 'ue','a','e','i','o','u');
	$url = str_replace ($find, $repl, $url);
	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+',':',';');
	$url = str_replace ($find, '-', $url);
	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	return $url;
}

function quitar_guiones($texto) {
	$texto = ucfirst(str_replace ('-', ' ', $texto));
	return $texto;
}

function quitar_guiones_mayusculas($texto) {
	$texto = strtoupper(str_replace ('-', ' ', $texto));
	return $texto;
}

//codigo de pagina
function codigo_pagina($tipo,$idioma,$nombre,$nivel,$orden,$pertenece) {
  //Mayuscula
  $t=strtoupper($tipo);
  //La primera 3 letras del tipo
  $ti=str_split($t,3);
  $tipo=$ti[0];

  $idioma=strtoupper($idioma);
  //La primera 1 letra del nombre
  $n=strtoupper($nombre);
  $no=str_split($n,1);
  $nombre=$no[0];

  $nivel=$nivel;

  $orden=add_ceros($orden,4);

  $pertenece=add_ceros($pertenece,4);

  $txt=$tipo.$nombre.$nivel.$orden.$pertenece.$idioma;
  $texto=str_split($txt,5);

  $codigo=$texto[0].'-'.$texto[1].'-'.$texto[2];


  return $codigo;
}


//funcion para leer, editar las paginas anidadas 
function paginas($dbname,$idioma,$id)
{
  $query = "SELECT * FROM pagina WHERE id_idioma='$idioma' && per_pagina='$id' ORDER BY CAST(ord_pagina AS UNSIGNED)";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){

    $ids = $row["id_pagina"];
    $ord = $row["ord_pagina"];
    $niv = $row["niv_pagina"];
    $per = $row["per_pagina"];
    $codigo = $row["cod_pagina"];
    $tit_pos_pag = $row["tit_pos_pagina"];

    $n_menu = "SELECT COUNT(ord_pagina) FROM pagina WHERE id_idioma='$idioma' && niv_pagina='$niv' && per_pagina='$per'";
    $orden = mysql_db_query($dbname, $n_menu);
    $orden = mysql_result($orden, 0);
?>



    <div class="accordion-group">
      <div class="accordion-titulo maps<?=$niv?>">
        
        
          <p class="numero"><strong><?=$ord?></strong></p>
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#orden<?=$per?>-<?=$niv?>-<?=$ord?>"><strong> <?=$tit_pos_pag?></strong></a>           

<?php
    if ($ids!=0) {
?>
          <a href="paginas_eli.php?id=<?=$ids?>" onclick='return confirm("¿ESTA SEGURO QUE DEAS ELIMINAR ESTA PAGINA? eliminara todas las paginas que dependan de ella")'><div class="pull-right icono"><i class="icon-remove"></i></div></a>
          <?php if($ord!=$orden) { ?>
          <a href="paginas_ord.php?id=<?=$ids?>&sig=0"><div class="pull-right icono"><i class="icon-chevron-down"></i></div></a>
          <?php } else { ?>
          <div class="pull-right icono"><i class="esp-ico"></i></div>
          <?php } ?>

          <?php if($ord!=1) { ?>
          <a href="paginas_ord.php?id=<?=$ids?>&sig=1"><div class="pull-right icono"><i class="icon-chevron-up"></i></div></a>
          <?php } else { ?>
          <div class="pull-right icono"><i class="esp-ico"></i></div>
          <?php } ?>

          <a href="paginas_edit.php?id=<?=$ids?>" target="edicion"><div class="pull-right icono"><i class="icon-file"></i></div></a>

          <a href="paginas_new.php?id=<?=$ids?>" target="edicion"><div class="pull-right icono"><i class="icon-plus"></i></div></a>        

<?php
    } else {
?>
          <div class="pull-right icono"><i class="esp-ico"></i></div>
          <div class="pull-right icono"><i class="esp-ico"></i></div>
          <div class="pull-right icono"><i class="esp-ico"></i></div>
          <a href="paginas_edit.php?id=<?=$ids?>" target="edicion"><div class="pull-right icono"><i class="icon-file"></i></div></a>
          <a href="paginas_new.php?id=<?=$ids?>" target="edicion"><div class="pull-right icono"><i class="icon-plus"></i></div></a>
<?php
    }
?>
      </div>

      <div id="orden<?=$per?>-<?=$niv?>-<?=$ord?>" class="accordion-body collapse">
        <div class="accordion-inner">

<?php
    $n_interno = "SELECT COUNT(id_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids' && per_pagina!='0'";
    $interno = mysql_db_query($dbname, $n_interno);
    $interno = mysql_result($interno, 0);

    if ($interno > 0) {
      paginas($dbname,1,$ids);
    }
?>    



        </div>
      </div>
    </div>


<?php     
  }mysql_free_result($conf);
}


function pagInternas($dbname,$id)
{
  global $cad_ids;
  $query = "SELECT * FROM pagina WHERE per_pagina='$id' ORDER BY ord_pagina";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){

    $ids = $row["id_pagina"];

    $cad_ids= $cad_ids."'".$ids."',";

    $n_interno = "SELECT COUNT(id_pagina) FROM pagina WHERE per_pagina='$ids'";
    $interno = mysql_db_query($dbname, $n_interno);
    $interno = mysql_result($interno, 0);
    
    if ($interno > 0) {

      pagInternas($dbname,$ids);

    }
    
  }mysql_free_result($conf);

    return $cad_ids;
}


function pagPadreDestino($dbname,$id)
{
  global $pad_id;
   
  $query = "SELECT * FROM pagina WHERE id_pagina='$id'";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){

    $per = $row["per_pagina"];
    $niv = $row["niv_pagina"];


    if ($niv > 2) {

      $pad_id= $pad_id."'".$per."',";
      pagPadreDestino($dbname,$per);

    }
    
  }mysql_free_result($conf);

    return $pad_id;

}

function pagUrl($dbname,$id)
{
  global $pagurl;
  $query = "SELECT * FROM pagina WHERE id_pagina='$id'";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){

    $per = $row["per_pagina"];
    $niv = $row["niv_pagina"];
    $url = $row["url_pagina"];
    $tit_pos = $row["tit_pos_pagina"];

    if ($niv > 0) {
      $pagurl= $url."/".$pagurl;
      pagUrl($dbname,$per);
    }
    
  }mysql_free_result($conf);

   return $pagurl;
}

function edicion($dbname,$idioma,$id)
{
  $query = "SELECT * FROM pagina WHERE id_idioma='$idioma' && per_pagina='$id' ORDER BY CAST(ord_pagina AS UNSIGNED)";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){
    
    $dise = $row["dise_pagina"];
    $ids = $row["id_pagina"];
    $ord = $row["ord_pagina"];
    $niv = $row["niv_pagina"];
    $per = $row["per_pagina"];
    $codigo = $row["cod_pagina"];
    $tit_pos_pag = $row["tit_pos_pagina"];
    $url_pag = $row["url_pagina"];

    $n_menu = "SELECT COUNT(ord_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids'";
    $orden = mysql_db_query($dbname, $n_menu);
    $orden = mysql_result($orden, 0);

?>



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

                //Sitio Turistico
                case "Actividad Turistica":       
              ?>
                href="dise_actividad.php?id=<?=$ids?>"
              <?php
                break;

                //Recomendacion - Tip Turistico
                case "Recomendaciones":

                  if ($url_pag=="recomendaciones-tips-turisticos") {
              ?>
                    href="dise_tic.php?id=<?=$ids?>"
              <?php
                  } else {
              ?>
                    href="dise_top_tic.php?id=<?=$ids?>"
              <?php
                  }
                break;

                //Galeria
                case "Galeria":
              ?>
                  href="dise_galeria.php?id=<?=$ids?>"
              <?php
                break;

                //Amigos
                case "Amigos":
              ?>
              <?php
                break;

                //Mapa del Sitio
                case "Mapa del Sitio":
              ?>
                  href="sitemap.php?id=<?=$ids?>"
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

      <div id="orden<?=$per?>-<?=$niv?>-<?=$ord?>" class="accordion-body collapse">
        <div class="accordion-inner">

<?php
    $n_interno = "SELECT COUNT(id_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids' && per_pagina!='0'";
    $interno = mysql_db_query($dbname, $n_interno);
    $interno = mysql_result($interno, 0);

    if ($interno > 0) {
      edicion($dbname,$idioma,$ids);
    }
?>    

        </div>
      </div>
    </div>


<?php     
  }mysql_free_result($conf);
}



//funcion donde se pueden observar la Cantidad de los comentarios de las distintas paginas
function Comentarios($dbname,$idioma,$id)
{
  $query = "SELECT * FROM pagina WHERE id_idioma='$idioma' && per_pagina='$id' ORDER BY CAST(ord_pagina AS UNSIGNED)";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){
    
    $dise = $row["dise_pagina"];
    $ids = $row["id_pagina"];
    $ord = $row["ord_pagina"];
    $niv = $row["niv_pagina"];
    $per = $row["per_pagina"];
    $codigo = $row["cod_pagina"];
    $tit_pos_pag = $row["tit_pos_pagina"];

    $n_menu = "SELECT COUNT(ord_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids'";
    $orden = mysql_db_query($dbname, $n_menu);
    $orden = mysql_result($orden, 0);  

    $n_men = "SELECT COUNT(id_tic) FROM tic WHERE id_pagina='$ids'";
    $n_men = mysql_db_query($dbname, $n_men);
    $n_men = mysql_result($n_men, 0);  
    
    $n_lei = "SELECT COUNT(id_tic) FROM tic WHERE id_pagina='$ids' && vist_tic='1'";
    $n_lei = mysql_db_query($dbname, $n_lei);
    $n_lei = mysql_result($n_lei, 0);  

    $n_nol = "SELECT COUNT(id_tic) FROM tic WHERE id_pagina='$ids' && vist_tic='0'";
    $n_nol = mysql_db_query($dbname, $n_nol);
    $n_nol = mysql_result($n_nol, 0);  

    $n_fav = "SELECT COUNT(fav_tic) FROM tic WHERE id_pagina='$ids' && fav_tic='1'";
    $n_fav = mysql_db_query($dbname, $n_fav);
    $n_fav = mysql_result($n_fav, 0); 

?>
    <div class="tic maps<?=$niv?> text-center">
     
      <p class="pull-left"><small><strong><?=$ord?></strong></small></p>
      <?php if($orden!=0 && $ids!=0) { ?>
      <a href="dise_tic.php?id=<?=$ids?>">
        <div class="pull-right icono"><i class="icon-th"></i></div>
      </a>
      <?php } else { ?>
      <div class="pull-right icono"><i class="esp-ico"></i></div>
      <?php } ?>
      <hr>
      <div class="text-center">
        <a href="dise_tic_general.php?id=<?=$ids?>">
          <strong><small><?=$tit_pos_pag?></small></strong> 
          <br><br><?=$n_men?> <i class="icon-comment"></i>
        </a>
        
      </div>
      <!-- href="dise_tic_leido.php?id=<?=$ids?>" 
      href="dise_tic_leido.php?id=<?=$ids?>"
      href="dise_tic_noleido.php?id=<?=$ids?>" -->
      <p  class="pull-right icono"> <?=$n_fav?> <i class="icon-heart"></i> </p>
      <hr>

      <p class="pull-right icono"> <?=$n_lei?> <i class="icon-eye-open"></i> </p>

      <p  class="pull-left icono"> <?=$n_nol?> <i class="icon-eye-close"></i> </p>


    </div>


<?php     
  }mysql_free_result($conf);
}


//funcion donde se pueden observar la Cantidad de los comentarios de las distintas paginas
function ComentariosPagina($dbname,$pagina,$id)
{
  $query = "SELECT * FROM tic WHERE per_tic='$id' && id_pagina='$pagina' ORDER BY CAST(ord_tic AS UNSIGNED)";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){
    
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
                <h5>Nueva Recomendacion - Tic's »</h5>
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
                  <input type="checkbox" name="like_<?=$ids?>" id="like_<?=$ids?>" value="1"> 
                  Desea que le Enviemos Informacion 
                </label>
                <button class="btn btn-primary btn-sitio pull-right" onclick="Coment('<?=$ids?>','<?=$pagina?>')">Guardar</button>
              </form>
            </div>          
          </div>

        </div>
        <br>




<?php

    if ($interno > 0) {
      ComentariosPagina($dbname,$pagina,$ids);
    }
?>         

      </div>
    </div>


<?php     
  }mysql_free_result($conf);
}

//funcion donde se pueden observar la Cantidad de los comentarios de las distintas paginas
function ComentPag($dbname,$pagina,$id)
{
  $query = "SELECT * FROM tic WHERE per_tic='$id' && id_pagina='$pagina' ORDER BY CAST(ord_tic AS UNSIGNED)";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){
    
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
                <a class="btn btn-primary btn-sitio pull-right" onclick="Coment('<?=$ids?>','<?=$pagina?>')">Guardar</a>
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
  }mysql_free_result($conf);
}


function sitemap($dbname,$idioma,$id)
{
  $query = "SELECT * FROM pagina WHERE id_idioma='$idioma' && per_pagina='$id' ORDER BY CAST(ord_pagina AS UNSIGNED)";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){
    
    $dise = $row["dise_pagina"];
    $ids = $row["id_pagina"];
    $ord = $row["ord_pagina"];
    $niv = $row["niv_pagina"];
    $per = $row["per_pagina"];
    $codigo = $row["cod_pagina"];
    $tit_pos_pag = $row["tit_pos_pagina"];
    $url_pag = $row["url_pagina"];

    $n_menu = "SELECT COUNT(ord_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids'";
    $orden = mysql_db_query($dbname, $n_menu);
    $orden = mysql_result($orden, 0);

?>



    <div class="accordion-group">
      <div class="accordion-titulo maps<?=$niv?>">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#orden" href="#orden<?=$per?>-<?=$niv?>-<?=$ord?>">│<?php for ($n=0; $n < $niv; $n++) { ?>---<?php } ?></a>
        <a href=""><?=$tit_pos_pag?></a>
      </div>

      <div id="orden<?=$per?>-<?=$niv?>-<?=$ord?>" class="accordion-body collapse in">
        <div class="">

<?php
    $n_interno = "SELECT COUNT(id_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids' && per_pagina!='0'";
    $interno = mysql_db_query($dbname, $n_interno);
    $interno = mysql_result($interno, 0);

    if ($interno > 0) {
      sitemap($dbname,$idioma,$ids);
    }
?>    

        </div>
      </div>
    </div>


<?php     
  }mysql_free_result($conf);
}

function UrlMap($dbname,$id)
{ 
  global $pagurl;
  $pagurl="";
  echo substr(pagUrl($dbname,$id), 0, -1);
}


function MapaSitio($dbname,$idioma,$id)
{ 
  $query = "SELECT * FROM pagina WHERE id_idioma='$idioma' && per_pagina='$id' ORDER BY CAST(ord_pagina AS UNSIGNED)";
  $conf = mysql_db_query($dbname, $query);

  while ($row = mysql_fetch_array($conf)){
    
    $dise = $row["dise_pagina"];
    $ids = $row["id_pagina"];
    $ord = $row["ord_pagina"];
    $niv = $row["niv_pagina"];
    $per = $row["per_pagina"];
    $codigo = $row["cod_pagina"];
    $url_pag = $row["url_pagina"];
    $tit_pos_pag = $row["tit_pos_pagina"];

    $n_menu = "SELECT COUNT(ord_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids'";
    $orden = mysql_db_query($dbname, $n_menu);
    $orden = mysql_result($orden, 0);


?>
    <div class="text-left">
      <div class="maps<?=$niv?>">
        <a class="" data-toggle="collapse" data-parent="#orden" href="#orden<?=$per?>-<?=$niv?>-<?=$ord?>">│<?php for ($n=0; $n < $niv; $n++) { ?>----<?php } ?></a>
        <a href="<?=UrlMap($dbname,$ids)?>"><?=$tit_pos_pag?></a>
      </div>

      <div id="orden<?=$per?>-<?=$niv?>-<?=$ord?>" class="collapse in">
        <div class=""> 
          

        <?php
            $n_interno = "SELECT COUNT(id_pagina) FROM pagina WHERE id_idioma='$idioma' && per_pagina='$ids' && per_pagina!='0'";
            $interno = mysql_db_query($dbname, $n_interno);
            $interno = mysql_result($interno, 0);

            if ($interno > 0) {
              MapaSitio($dbname,$idioma,$ids);
            }
        ?>    

        </div>
      </div>
    </div>


<?php     
  }mysql_free_result($conf);
}

?>