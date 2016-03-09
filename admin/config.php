<?php
$dbhost = "localhost";	

$dbusername = "sitiotou_1";

$dbpassword = "hcyp107";

$dbname = "sitiotou_00";

$conexion = mysql_connect($dbhost , $dbusername, $dbpassword)
or die("No pudo conectarse : " . mysql_error());
mysql_select_db($dbname, $conexion) or die("No pudo seleccionarse la BD.");
?>