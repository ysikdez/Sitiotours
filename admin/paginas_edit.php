<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

$ids = $_GET['id'];
$ingresada = $_GET['error'];



//Datos de la Pagina
$pos_pag = "SELECT * FROM pagina WHERE id_pagina='$ids'";
$posi_pag = mysql_db_query($dbname, $pos_pag); 
if ($row = mysql_fetch_array($posi_pag)){ 

	$id_idi = $row["id_idioma"];

	$cod_pag = $row["cod_pagina"];

	$niv_pag = $row["niv_pagina"];
	$ord_pag = $row["ord_pagina"];
	$per_pag = $row["per_pagina"];

	$dise_pag = $row["dise_pagina"];
	$ico_pag = $row["ico_pagina"];

	$tit_pag = $row["tit_pagina"];
	$url_pag = $row["url_pagina"];

	$tit_pos_pag = $row["tit_pos_pagina"];
	$tit_com_pag = $row["tit_com_pagina"];
	
	$des_pag = $row["des_pagina"];
	$key_pag = $row["key_pagina"];
	$map_pag = $row["map_pagina"];
	$ima_def_pag = $row["ima_def_pagina"];

}

//Datos de la Pagina Padre
$pos_pag_pad = "SELECT * FROM pagina WHERE id_pagina='$per_pag'";
$posi_pag_pad = mysql_db_query($dbname, $pos_pag_pad); 
if ($row = mysql_fetch_array($posi_pag_pad)){ 
	$id_idioma = $row["id_idioma"];
	$tit_pos_pag_pad = $row["tit_pos_pagina"];
}


if (!$_POST) {
	
} else {
	$id=$_POST["id"];
	$idi=$_POST["idi"];
	$niv=$_POST["niv"];
	$ord=$_POST["ord"];
	$per=$_POST["per"];

	$dise=$_POST["dise"];
	$ico=$_POST["ico"];
	
	$tit=$_POST["tit"];

	$tit_pos=$_POST["tit_pos"];
	$tit_com=$_POST["tit_com"];
	
	$des=$_POST["des"];
	$key=$_POST["key"];
	$map=$_POST["map"];
	$ima_def=$_POST["ima_def"];

	//Datos de la Pagina
	$pos_pag = "SELECT abre_idioma FROM idioma WHERE id_idioma='$idi'";
	$posi_pag = mysql_db_query($dbname, $pos_pag); 
	if ($row = mysql_fetch_array($posi_pag)){ 

		$abre_idioma = $row["abre_idioma"];
	}

	if ($ima_def==on) {
		$def=1;

		$ima_prin = "UPDATE letrero_ima_prin SET tip_letrero_ima_prin = 'Inicio' WHERE id_pagina='$id'";
		$cab_ima_prin = mysql_db_query($dbname, $ima_prin);

		$editar_pagina = "UPDATE pagina SET	ima_def_pagina = '$def' WHERE id_pagina='$id'";
		$cab_editar_pagina = mysql_db_query($dbname, $editar_pagina);	

	}

	$url=urls_amigables($tit_pos);
		
	$codigo=codigo_pagina($dise,$abre_idioma,$tit_pos,$niv,$ord,$per);

	$editar_pagina = "UPDATE pagina SET

						id_idioma = '$idi',

						niv_pagina = '$niv',
						ord_pagina = '$ord',
						per_pagina = '$per',

						cod_pagina = '$codigo',
						url_pagina = '$url',
						dise_pagina = '$dise',

						ico_pagina = '$ico',

						des_pagina = '$des',
						key_pagina = '$key',

						tit_pagina = '$tit',
						map_pagina = '$map',
						
						tit_pos_pagina = '$tit_pos',
						tit_com_pagina = '$tit_com'
						
						WHERE id_pagina='$id'";

	$cab_editar_pagina = mysql_db_query($dbname, $editar_pagina);		

	if ($dise_pag!=$dise) {

			switch ($dise) {

				//General
				case "General":
					$tipo_general = "INSERT INTO general (id_pagina) VALUES ('$id_new_pag')";
					$cab_tipo_general = mysql_db_query($dbname, $tipo_general);

					//***********************************************************************//

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);
					
				break;

				//Tour
				case "Tour":
					//**********************************************//
						//CODIGO DEL TOUR
					//**********************************************//
						$titulo=urls_amigables($tit_pos_pag_pad);//padre
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='TOU'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_tour=$texto[0].'-'.$texto[1];
					//**********************************************//
					$nuevo_tour = "INSERT INTO tour (id_pagina,cod_tour,tipo_tour) VALUES ('$id_new_pag','$codigo_tour','$tit_pos_pag_pad')";
					$cab_nuevo_tour = mysql_db_query($dbname, $nuevo_tour);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);					

				break;

				//Destino
				case "Destino":
					//**********************************************//
						//CODIGO DEL DESTINO
					//**********************************************//
						$titulo=urls_amigables($tit_pos_pag);//padre
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='DES'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_destino=$texto[0].'-'.$texto[1];
					//**********************************************//
					$niv_destino=$niv-1;
					$tipo_destino = "INSERT INTO destino (id_pagina,cod_destino) VALUES ('$id_new_pag','$codigo_destino')";
					$cab_tipo_destino = mysql_db_query($dbname, $tipo_destino);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Opcion de Viaje
				case "Opcion de Viaje":
					//**********************************************//
						//CODIGO DE LA OPCION DE VIAJE
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='OPC'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_opcion=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_opcion = "INSERT INTO opcion (id_pagina,cod_opcion) VALUES ('$id_new_pag','$codigo_opcion')";
					$cab_tipo_opcion = mysql_db_query($dbname, $tipo_opcion);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);			

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Agencia de Viaje
				case "Agencia de Viaje":
					//**********************************************//
						//CODIGO DE LA AGENCIA DE VIAJE
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='AGEN'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_agencia=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_agencia = "INSERT INTO agencia (id_pagina,cod_agencia) VALUES ('$id_new_pag','$codigo_agencia')";
					$cab_tipo_agencia = mysql_db_query($dbname, $tipo_agencia);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Alojamiento - Hotel
				case "Alojamiento - Hotel":
					//**********************************************//
						//CODIGO DEL ALOJAMIENTO
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='ALO'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_alojamiento=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_alojamiento = "INSERT INTO alojamiento (id_pagina,cod_alojamiento) VALUES ('$id_new_pag','$codigo_alojamiento')";
					$cab_tipo_alojamiento = mysql_db_query($dbname, $tipo_alojamiento);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Restaurante
				case "Restaurante":
					//**********************************************//
						//CODIGO DEL RESTAURANTE
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='RES'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_restaurante=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_restaurante = "INSERT INTO restaurante (id_pagina,$cod_restaurante) VALUES ('$id_new_pag','$codigo_restaurante')";
					$cab_tipo_restaurante = mysql_db_query($dbname, $tipo_restaurante);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Tienda
				case "Tienda":
					//**********************************************//
						//CODIGO DE LA TIENDA
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='TIE'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_tienda=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_tienda = "INSERT INTO tienda (id_pagina,cod_tienda) VALUES ('$id_new_pag','$codigo_tienda')";
					$cab_tipo_tienda = mysql_db_query($dbname, $tipo_tienda);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Regalo - Souvenir
				case "Regalo - Souvenir":
					//**********************************************//
						//CODIGO DEL REGALO - SOUVENIR
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='SOU'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_souvenir=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_souvenir = "INSERT INTO souvenir (id_pagina,cod_souvenir) VALUES ('$id_new_pag','$codigo_souvenir')";
					$cab_tipo_souvenir = mysql_db_query($dbname, $tipo_souvenir);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Comida Tipica
				case "Comida Tipica":
					//**********************************************//
						//CODIGO DE LA COMIDA TIPICA
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='TIP'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_tipica=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_tipica = "INSERT INTO tipica (id_pagina,cod_tipica) VALUES ('$id_new_pag','$codigo_tipica')";
					$cab_tipo_tipica = mysql_db_query($dbname, $tipo_tipica);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Sitio Turistico
				case "Sitio Turistico":
					//**********************************************//
						//CODIGO DEL SITIO TURISTICO
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='SIT'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_sitio=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_sitio = "INSERT INTO sitio (id_pagina,cod_sitio) VALUES ('$id_new_pag','$codigo_sitio')";
					$cab_tipo_sitio = mysql_db_query($dbname, $tipo_sitio);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Actividad Turistica
				case "Actividad Turistica":
					//**********************************************//
						//CODIGO DEL SITIO TURISTICO
					//**********************************************//
						$titulo=urls_amigables($tit_pos);
						//Mayuscula
						$t=strtoupper($titulo);
						//La primera 3 letras del tipo de tour
						$ti=str_split($t,3);
						$tipo=$ti[0];

						$orden=add_ceros($ord_new_pag,4);

						$idioma=strtoupper($abre_idioma);

						$txt='ACT'.$tipo.$orden.$idioma;
						$texto=str_split($txt,6);

						$codigo_actividad=$texto[0].'-'.$texto[1];
					//**********************************************//		
					$tipo_actividad = "INSERT INTO actividad (id_pagina,cod_actividad) VALUES ('$id_new_pag','$codigo_actividad')";
					$cab_tipo_actividad = mysql_db_query($dbname, $tipo_actividad);

					//***********************************************************************//

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);					

				break;

				//Recomendacion - Tic Turistico
				case "Recomendaciones":

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

				break;

				//Galeria
				case "Galeria":

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

				break;

				//Amigos
				case "Amigos":

					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

				break;

				//Mapa del Sitio
				case "Mapa del Sitio":
				
					$modificar = "DELETE FROM general WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tour WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM destino WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM opcion WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM agencia WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM alojamiento WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM restaurante WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tienda WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM souvenir WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);

					$modificar = "DELETE FROM tipica WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

					$modificar = "DELETE FROM sitio WHERE id_pagina='$id'";
					$result = mysql_db_query($dbname, $modificar);				

				break;

			}

	}
	header("location: paginas_edit.php?id=$id&error=$error");
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

		<!-- Titulo de la pagina: entre 60 a 70 caracteres -->		
		<title>Editar Paginas</title>
	</head>
	<body onload="cuentaTitulo();cuentaPosicionamiento();cuentaDescripcion();cuentaKeyword();imaPrincipal();">
		<div class="row contorno">
			<form method="post" enctype="multipart/form-data" name="formulario" action="">
				<h4 class="pull-right">Codigo : <?=$cod_pag?></h4>
				<br><br>					
				<h3>Editar Pagina » <?=$tit_pos_pag?></h3>						
				<h4>Configuración SEO » </h4>
				<p class="text-justify">Para Añadir una nueva Página debemos rellenar el siguiente formulario para el adecuado posicionamiento: El llenado debe ser lo mas conciso posible y debe reflejar contenido de la pagina..</p>
				<br>
				<label>
					<h5>Tipo de Diseño de la Pagina »</h5>
					<input list="dise_newpag" name="dise" type="text" class="span5" required title="Se necesita un Tipo de Diseño" value="<?=$dise_pag?>">
					<datalist id="dise_newpag">
						<option value="General">
						<option value="Tour">
						<option value="Destino">
						<option value="Opcion de viaje">
						<option value="Agencia">
						<option value="Alojamiento">
						<option value="Restaurante">
						<option value="Tienda">
						<option value="Regalo">
						<option value="Comida">
						<option value="Sitio Turistico">
						<option value="Recomendaciones">
						<option value="Galeria">
						<option value="Amigos">
						<option value="Mapa del Sitio">
					</datalist>
				</label>

				<h5>Icono del la Pagina</h5>
				<select name="ico">
					<option value="Sin Icono" <?php if ("Sin Icono"==$ico_pag) { ?> selected <?php } ?>>Sin Icono</option>
					<option value="icon-tour" <?php if ("icon-tour"==$ico_pag) { ?> selected <?php } ?>>Tour</option>
					<option value="icon-destino" <?php if ("icon-destino"==$ico_pag) { ?> selected <?php } ?>>Destino</option>
					<option value="icon-opcion" <?php if ("icon-opcion"==$ico_pag) { ?> selected <?php } ?>>Opcion de Viaje</option>
					<option value="icon-agencia" <?php if ("icon-agencia"==$ico_pag) { ?> selected <?php } ?>>Agencia</option>
					<option value="icon-hotel" <?php if ("icon-hotel"==$ico_pag) { ?> selected <?php } ?>>Alojamiento</option>
					<option value="icon-restaurante" <?php if ("icon-restaurante"==$ico_pag) { ?> selected <?php } ?>>Restaurante</option>
					<option value="icon-tienda" <?php if ("icon-tienda"==$ico_pag) { ?> selected <?php } ?>> Tienda</option>
					<option value="icon-souvenir" <?php if ("icon-souvenir"==$ico_pag) { ?> selected <?php } ?>>Souvenir</option>
					<option value="icon-comida" <?php if ("icon-comida"==$ico_pag) { ?> selected <?php } ?>>Comida Tipica</option>
					<option value="icon-sitio" <?php if ("icon-sitio"==$ico_letrero) { ?> selected <?php } ?>>Sitio Turistico</option>
					<option value="icon-actividad" <?php if ("icon-actividad"==$ico_pag) { ?> selected <?php } ?>>Actividad Turistica</option>
					<option value="icon-tic" <?php if ("icon-tic"==$ico_pag) { ?> selected <?php } ?>>Recomendacion Turistica</option>
				</select>

				<input type="hidden" name="id" value="<?=$ids?>">
				<input type="hidden" name="idi" value="<?=$id_idi?>">
				<input type="hidden" name="niv" value="<?=$niv_pag?>">
				<input type="hidden" name="ord" value="<?=$ord_pag?>">
				<input type="hidden" name="per" value="<?=$per_pag?>">

				<br>

				<h5>Nombre Pagina / Titulo</h5>
				<label>
					<h5>
						Titulo de la Pagina » 
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Pal.</small></small></span>
							<input type="text" id="pal_ti" class="jerarquia" value="0">
						</div>
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Car.</small></small></span>
							<input type="text" id="car_ti" class="jerarquia" value="0">
						</div>
					</h5>
					<input type="text" id="tex_ti" name="tit" class="span5" onKeyDown="cuentaTitulo()" onKeyUp="cuentaTitulo()" placeholder="Titulo de la Pagina" required title="Se necesita un Titulo de la Página" value="<?=$tit_pag?>">
				</label>

				<label>
					<h5>
						Titulo para el Posicionamiento » 
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Pal.</small></small></span>
							<input type="text" id="pal_posi" class="jerarquia" value="0">
						</div>
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Car.</small></small></span>
							<input type="text" id="car_posi" class="jerarquia" value="0">
						</div>
					</h5>
					<input type="text" id="tex_posi" name="tit_pos" class="span5" onKeyDown="cuentaPosicionamiento()" onKeyUp="cuentaPosicionamiento()" placeholder="Titulo para el Posicionamiento" required title="Se necesita un Titulo para el Posicionamiento" value="<?=$tit_pos_pag?>">
				</label>

				<label>
					<h5>Titulo Comercial »</h5>
					<input type="text" name="tit_com" class="span5" placeholder="Titulo Comercial" value="<?=$tit_com_pag?>">
				</label>

				<label>
					<h5>
						Descripcion de la Pagina »

						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Pal.</small></small></span>
							<input type="text" id="pal_des" class="jerarquia" value="0">
						</div>
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Car.</small></small></span>
							<input type="text" id="car_des" class="jerarquia" value="0">
						</div>
					</h5>
					<textarea rows="3" id="tex_des" name="des" class="span5" onKeyDown="cuentaDescripcion()" onKeyUp="cuentaDescripcion()" placeholder="Descripcion" required title="Se necesita una Descripcion para la Página"><?=$des_pag?></textarea>
				</label>

				<label>
					<h5>
						Palabras Claves de la Pagina »
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Pal.</small></small></span>
							<input type="text" id="pal_key" class="jerarquia" value="0">
						</div>
						<div class="input-prepend pull-right">
							<span class="add-on"><small><small>Car.</small></small></span>
							<input type="text" id="car_key" class="jerarquia" value="0">
						</div>
					</h5>
					<textarea rows="3" id="tex_key" name="key" class="span5" onKeyDown="cuentaKeyword()" onKeyUp="cuentaKeyword()" placeholder="Palabras Claves" required title="Se necesita Palabras Claves para la Página"><?=$key_pag?></textarea>
				</label>

				<label>
					<h5>
						Codigo del Mapa »
					</h5>
					<textarea rows="3" id="tex_map" name="map" class="span5" placeholder="Mapa de la Ubicacion"><?=$map_pag?></textarea>
				</label>



				<label>
					<input type="checkbox" name="ima_def" id="ima_def" <?php if ($ima_def_pag==1) { ?> checked="checked" <?php } ?> onclick="imaPrincipal()"> Imagenes Principales por Defecto
				</label>

				<div id="n_ima">
					<a class="btn btn-sitio pull-left" href="imagen_prin.php?id=<?=$ids?>"><i class="icon-picture"></i></a>

				</div>

				<button class="btn btn-primary btn-sitio pull-right">Guardar</button>
			</form>
		</div>
	</body>
</html>