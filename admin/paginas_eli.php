<?php
include ("config.php");

$id= $_GET['id'];


if (!empty($id)){

	$pos = "SELECT * FROM pagina WHERE id_pagina='$id'";
	$posi = mysql_db_query($dbname, $pos); 
	if ($row = mysql_fetch_array($posi)){ 

		$ord_pagina = $row["ord_pagina"];
		$niv_pagina = $row["niv_pagina"];
		$per_pagina = $row["per_pagina"];
		$dise_pagina = $row["dise_pagina"];
		$id_idioma = $row["id_idioma"];

	}

	$indice = "SELECT COUNT(id_pagina) FROM pagina WHERE per_pagina='$per_pagina' && id_idioma='$id_idioma' && niv_pagina='$niv_pagina'";
    $max = mysql_db_query($dbname, $indice);
    $max = mysql_result($max, 0);

	$sig = $ord_pagina + 1;
				
	for ($i = $sig ; $i <= $max ; $i++) {
		
		$act = $i - 1 ;
		
		if ( $act > 0 ){
			//Cambia la posicion de las paginas que no son borradas
			$cam_posi = "UPDATE pagina SET
					ord_pagina='$act'
					WHERE per_pagina='$per_pagina' && id_idioma='$id_idioma' && niv_pagina='$niv_pagina' && ord_pagina='$i'";
			$cab_actual = mysql_db_query($dbname, $cam_posi);	
		}
	}

	switch ($dise_pagina) {

		//General
		case "General":
			//**************************************************************//
			//					Eliminar Pagina General						//
			//**************************************************************//
				$dato_general = "SELECT id_general FROM general WHERE id_pagina='$id'";
				$dato_general = mysql_db_query($dbname, $dato_general); 
				if ($row = mysql_fetch_array($dato_general)){ $id_general = $row["id_general"];}

			//--------------------------------------------------------------//
			//					   Eliminar Detalle							//
			//--------------------------------------------------------------//
				$modificar = "DELETE FROM detalle WHERE id_general='$id_general'";
				$result = mysql_db_query($dbname, $modificar);

			//--------------------------------------------------------------//
			//					 Eliminar  Contacto							//
			//--------------------------------------------------------------//
				$modificar = "DELETE FROM contacto WHERE id_pagina='$id'";
				$result = mysql_db_query($dbname, $modificar);

			//--------------------------------------------------------------//

			$eliminar_general = "DELETE FROM general WHERE id_pagina='$id'";
			$cab_eliminar_general = mysql_db_query($dbname, $eliminar_general);

		break;

		//Tour
		case "Tour":
			//**************************************************************//
			//					Eliminar Pagina Tour 						//
			//**************************************************************//
				$dato_tour = "SELECT id_tour FROM tour WHERE id_pagina='$id'";
				$dato_tour = mysql_db_query($dbname, $dato_tour); 
				if ($row = mysql_fetch_array($dato_tour)){ $id_tour = $row["id_tour"];}

			//--------------------------------------------------------------//
			//					   Eliminar Salida 							//
			//--------------------------------------------------------------//
				$modificar = "DELETE FROM salida WHERE id_tour='$id_tour'";
				$result = mysql_db_query($dbname, $modificar);

			//--------------------------------------------------------------//
			//					  Eliminar Precio 							//
			//--------------------------------------------------------------//
				$modificar = "DELETE FROM tprecio WHERE id_tour='$id_tour'";
				$result = mysql_db_query($dbname, $modificar);

			//--------------------------------------------------------------//
			//					Eliminar Itinerario							//
			//--------------------------------------------------------------//
				$dato_itinerario = "SELECT id_itinerario FROM itinerario WHERE id_tour='$id_tour'";
				$dato_itinerario = mysql_db_query($dbname, $dato_itinerario); 
				while ($row = mysql_fetch_array($dato_itinerario)){

					$id_itinerario = $row["id_itinerario"];
		
					$eliminar_serv_incluye = "DELETE FROM iincluye WHERE id_itinerario='$id_itinerario'";
					$cab_eliminar_serv_incluye = mysql_db_query($dbname, $eliminar_serv_incluye);

				}

				$eliminar_itinerario = "DELETE FROM itinerario WHERE id_tour='$id_tour'";
				$cab_eliminar_itinerario = mysql_db_query($dbname, $eliminar_itinerario);

			//--------------------------------------------------------------//
			$eliminar_tour = "DELETE FROM tour WHERE id_pagina='$id'";
			$cab_eliminar_tour = mysql_db_query($dbname, $eliminar_tour);

		break;

		//Destino
		case "Destino":
			$eliminar_destino = "DELETE FROM destino WHERE id_pagina='$id'";
			$cab_eliminar_destino = mysql_db_query($dbname, $eliminar_destino);
		break;
		//Opcion de Viaje
		case "Opcion de Viaje":
			$eliminar_opcion = "DELETE FROM opcion WHERE id_pagina='$id'";
			$cab_eliminar_opcion = mysql_db_query($dbname, $eliminar_opcion);
		break;
		//Agencia de Viaje
		case "Agencia de Viaje":
			$eliminar_agencia = "DELETE FROM agencia WHERE id_pagina='$id'";
			$cab_eliminar_agencia = mysql_db_query($dbname, $eliminar_agencia);
		break;
		//Alojamiento - Hotel
		case "Alojamiento - Hotel":
			$eliminar_alojamiento = "DELETE FROM alojamiento WHERE id_pagina='$id'";
			$cab_eliminar_alojamiento = mysql_db_query($dbname, $eliminar_alojamiento);
		break;
		//Restaurante
		case "Restaurante":
			$eliminar_restaurante = "DELETE FROM restaurante WHERE id_pagina='$id'";
			$cab_eliminar_restaurante = mysql_db_query($dbname, $eliminar_restaurante);
		break;
		//Tienda
		case "Tienda":
			$eliminar_tienda = "DELETE FROM tienda WHERE id_pagina='$id'";
			$cab_eliminar_tienda = mysql_db_query($dbname, $eliminar_tienda);
		break;
		//Regalo - Souvenir
		case "Regalo - Souvenir":
			$eliminar_souvenir = "DELETE FROM souvenir WHERE id_pagina='$id'";
			$cab_eliminar_souvenir = mysql_db_query($dbname, $eliminar_souvenir);
		break;
		//Comida Tipica
		case "Comida Tipica":
			$eliminar_tipica = "DELETE FROM tipica WHERE id_pagina='$id'";
			$cab_eliminar_tipica = mysql_db_query($dbname, $eliminar_tipica);
		break;
		//Sitio Turistico
		case "Sitio Turistico":
			$eliminar_sitio = "DELETE FROM sitio WHERE id_pagina='$id'";
			$cab_eliminar_sitio = mysql_db_query($dbname, $eliminar_sitio);
		break;

	}



//--------------------------------------------------------------//
//				Eliminar Contacto de la pagina 					//
//--------------------------------------------------------------//
	$dato_contacto = "SELECT id_contacto FROM contacto WHERE id_pagina='$id'";
	$dato_contacto = mysql_db_query($dbname, $dato_contacto); 
	if ($row = mysql_fetch_array($dato_contacto)){ $id_contacto = $row["id_contacto"];}

	$modificar = "DELETE FROM info WHERE id_contacto='$id_contacto'";
	$result = mysql_db_query($dbname, $modificar);

	$modificar = "DELETE FROM contacto WHERE id_pagina='$id'";
	$result = mysql_db_query($dbname, $modificar);

//--------------------------------------------------------------//
//		 	Eliminar Tic - Recomendaciones de la Pagina 		//
//--------------------------------------------------------------//
	$modificar = "DELETE FROM tic WHERE id_pagina='$id'";
	$result = mysql_db_query($dbname, $modificar);

//--------------------------------------------------------------//	
//			Eliminar Valoracion / Puntaje de la Pagina 			//
//--------------------------------------------------------------//
	$modificar = "DELETE FROM valoracion WHERE id_pagina='$id'";
	$result = mysql_db_query($dbname, $modificar);

//--------------------------------------------------------------//	
//			Eliminar Coleccion de Imagenes Principales 			//
//--------------------------------------------------------------//
	$modificar = "DELETE FROM coleccion WHERE id_pagina='$id'";
	$result = mysql_db_query($dbname, $modificar);

//**************************************************************//
//					Eliminar La paginas 			 			//
//**************************************************************//	
	$modificar = "DELETE FROM pagina WHERE id_pagina='$id'";
	$result = mysql_db_query($dbname, $modificar);

//--------------------------------------------------------------//	

}else $error = $error."No se pudo borrar archivo :".$id;


header("location: paginas.php?error=$error");



































?>

