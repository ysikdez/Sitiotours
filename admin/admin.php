<?
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<link href="css/estilo.css" type="text/css" rel="stylesheet" />
		<link href="imagenes/logo.png" rel="shortcut icon">
		<meta name="Description" content="" />
		<meta name="Keywords" content="" />
            	<title>Sistema Coca Tours AT</title>

</head>

<frameset cols="200,*" frameborder="no" border="0" framespacing="0">
  <frame src="menu.php" name="menu" scrolling="no" noresize="noresize" id="menu" />
  <frame src="inicio.php" name="main" id="main" />

  <noframes>
    Sorry, your browser does not handle frames!
  </noframes>

</frameset>



</html>