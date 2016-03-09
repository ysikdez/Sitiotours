<?php
include ("admin/config.php");

$id = $_GET["id"];
$mail = $_GET["mail"];
$mensaje = $_GET["mensaje"];

//Pagina
$dato_pagina = "SELECT * FROM pagina WHERE id_pagina='$id'";
$dato_pagina = mysql_db_query($dbname, $dato_pagina); 
if ($row = mysql_fetch_array($dato_pagina)){ 

	// $id_idioma = $row["id_idioma"];
	// $des = $row["des_pagina"];
	// $key = $row["key_pagina"];
	// $tit = $row["tit_pagina"];
	// $url = $row["url_pagina"];

	$tit_pos = $row["tit_pos_pagina"];
	$tit_com = $row["tit_com_pagina"];

	// $logo = $row["logo_pagina"];
	// $alt_logo = $row["alt_logo_pagina"];
	// $des_logo = $row["des_logo_pagina"];
}

$fecha =date("Y-m-d H:i:s");

//Nuevo voto
$nuevo_consulta = "INSERT INTO consulta (

						id_pagina,
						mail_consulta,
						men_consulta,
						date_consulta
						

					) VALUES(

						'$id',
						'$mail',
						'$mensaje',
						'$fecha'

					)";

$nuevo_consulta = mysql_db_query($dbname, $nuevo_consulta);



$destinatario = $mail; 
$asunto = "Consulta de ".$tit_pos." :: Sitiotours.com"; 
$cuerpo = ' 
<html> 
<head> 
   <title>Gracias por Consultarnos :: Sitiotours.com </title> 
</head> 
<body> 
<h1>Muchas Gracias por tu Consulta : '.$mail.'</h1>
<p> 
<img src="http://sitiotours.com/img/sitio-logo.png" alt="Logo Sitiotours.com" width="100" height="58"><br>
<b>Te brindaremos una respuesta lo mas pronto posible a tu Consulta de:</b><br><br>
'.$tit_pos.'<br><br>
'.$mensaje.' 
</p> 
</body> 
</html> 
'; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: ".$mail." <".$mail.">\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To: info@sitiotours.com\r\n"; 

//ruta del mensaje desde origen a destino 
// $headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

//direcciones que recibián copia 
$headers .= "Cc: info@sitiotours.com\r\n"; 

//direcciones que recibirán copia oculta 
// $headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

mail($destinatario,$asunto,$cuerpo,$headers);
?>


<div class="text-center">
<?=$mail?><br>
Gracias por tu consulta <br>
<a href="http://sitiotours.com/"> Sitiotours.com</a>
</div>

