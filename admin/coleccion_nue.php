<?php 
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

if (!$_POST) {
	
} else {
	$ids = $_POST["id"];
	$nom_coleccion = $_POST["nom_coleccion"];
	$ico_letrero = $_POST["ico_letrero"];
	$tit_letrero = $_POST["tit_letrero"];
	$des_letrero = $_POST["des_letrero"];
	$btn_letrero = $_POST["btn_letrero"];
	$link_letrero = $_POST["link_letrero"];

	$tit_ima_prin = $_POST["tit_ima_prin"];
	$des_ima_prin = $_POST["des_ima_prin"];
	$lug_ima_prin = $_POST["lug_ima_prin"];

	$fecha = $_POST["fecha"];
	$hora = $_POST["hora"];
	$fec_ima_prin = $fecha.'--'.$hora;

	$arch_ima_prin = $_POST["arch_ima_prin"];


	//Archivo
	$destino = $_SERVER['DOCUMENT_ROOT'].'/image/' ; //Destino donde se guardaran los archivos
	$tamano = $_FILES ['arch_ima_prin']['size']; //Tamaño del archivo 
	$val = intval($tamano);

	//Nombre con el que la imagen sera guardada
	$nombre = urls_amigables($tit_ima_prin); 
	$lugar = urls_amigables($lug_ima_prin);
	$fecha = urls_amigables($fec_ima_prin);

	//Cantidad de Imagenes Principales 
	$n_ima = "SELECT COUNT(id_ima_prin) FROM ima_prin";
	$max_ima = mysql_db_query($dbname, $n_ima);
	$max_ima = mysql_result($max_ima, 0);
	$sig_ima = $max_ima+1;
	$numero = add_ceros($sig_ima,3);
	
	//Tipo de Archivo 
	$arch=explode('.',$_FILES ['arch_ima_prin']['name']);
	$tipo_arch='.'.$arch[1];
	//Nombre de la Imagen Principal 
	$nom_ima_prin=$nombre.'-'.$lugar.'-'.$fecha.'-'.$numero.$tipo_arch;

	if( !empty($val)) {

		// Comprobamos el tamaño del archivo debe ser menor 600kb
		if( $tamano < 614400 ){
			
			move_uploaded_file ( $_FILES [ 'arch_ima_prin' ][ 'tmp_name' ], $destino.$nom_ima_prin); 
						
			//Nueva Imagen
			$nueva_imagen = "INSERT INTO ima_prin (

									arch_ima_prin,
									tit_ima_prin,
									lug_ima_prin,
									fec_ima_prin,
									des_ima_prin

								) VALUES(

									'$nom_ima_prin',
									'$tit_ima_prin',
									'$lug_ima_prin',
									'$fec_ima_prin',
									'$des_ima_prin'

								)";

			$cab_nueva_imagen = mysql_db_query($dbname, $nueva_imagen);

			//Nuevo Letrero
			$nueva_letrero = "INSERT INTO letrero (

									ico_letrero,
									tit_letrero,
									des_letrero,
									btn_letrero,
									link_letrero

								) VALUES(

									'$ico_letrero',
									'$tit_letrero',
									'$des_letrero',
									'$btn_letrero',
									'$link_letrero'

								)";
			$cab_nueva_letrero = mysql_db_query($dbname, $nueva_letrero);

			//Id de la Nueva Imagen Principal
			$let_pag = "SELECT * FROM ima_prin WHERE arch_ima_prin='$nom_ima_prin' AND tit_ima_prin='$tit_ima_prin' AND lug_ima_prin='$lug_ima_prin'";
			$posi_pag = mysql_db_query($dbname, $let_pag); 
			if ($row = mysql_fetch_array($posi_pag)){ $id_ima_prin = $row["id_ima_prin"]; }

			//Id del Letrero Nuevo
			$let_pag = "SELECT * FROM letrero WHERE ico_letrero='$ico_letrero' AND tit_letrero='$tit_letrero' AND  des_letrero='$des_letrero' AND  btn_letrero='$btn_letrero'";
			$posi_pag = mysql_db_query($dbname, $let_pag); 
			if ($row = mysql_fetch_array($posi_pag)){ $id_letrero = $row["id_letrero"]; }

			//Cantidad de Imagenes Principales (inicializara en 1) 
			$n_ima_colec = "SELECT COUNT(id_letrero_ima_prin) FROM letrero_ima_prin WHERE tip_letrero_ima_prin='$coleccion'";
			$max_ima_colec = mysql_db_query($dbname, $n_ima_colec);
			$max_ima_colec = mysql_result($max_ima_colec, 0);
			$sig_ima_colec = $max_ima_colec+1;


			//Nuevo Letrero de Imagen Principal de la Coleccion
			$nuevo_letrero_ima_prin = "INSERT INTO letrero_ima_prin (

									id_letrero,
									id_ima_prin,
									pos_letrero_ima_prin,
									tip_letrero_ima_prin

								) VALUES(

									'$id_letrero',
									'$id_ima_prin',
									'$sig_ima_colec',
									'$nom_coleccion'
									
								)";

			$cab_nuevo_letrero_ima_prin = mysql_db_query($dbname, $nuevo_letrero_ima_prin);				
					

		} else { $error = "El archivo pesa mas de lo determinado"; }
	} 
	header("location: imagen_prin.php?id=$ids");
}

?>