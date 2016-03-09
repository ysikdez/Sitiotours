<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

//Site
$dato_site = "SELECT * FROM site WHERE id_site='1'";
$dato_site = mysql_db_query($dbname, $dato_site); 
if ($row = mysql_fetch_array($dato_site)){ 
  $url_site = $row["url_site"];
  $mail_site = $row["mail_site"];
  $fech_site = $row["fech_site"];
  $auto_site = $row["auto_site"];
  $copy_site = $row["copy_site"];
}

if (!$_POST) {
  
} else {

  $url = $_POST["url"];
  $mail = $_POST["mail"];
  $fech = $_POST["fech"];
  $auto = $_POST["auto"];
  $copy = $_POST["copy"];

  $editar_site = "UPDATE site SET
        
            url_site = '$url',
            mail_site = '$mail',
            fech_site = '$fech',         
            auto_site = '$auto',
            copy_site = '$copy'
            
            WHERE id_site='1'";

  $editar_site = mysql_db_query($dbname, $editar_site); 

  header("location: configuracion.php");

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
    <title>Configuaración</title>
  </head>
  <body>
    <div class="row contorno">
        <h3><strong><em>Configuración </em></strong></h3>
                
        <form method="post" enctype="multipart/form-data" name="formulario" action="">
          <label>
            <h5>Url del Sitio »</h5>
            <input type="text" name="url" class="span5" placeholder="sitiotours.com" value="<?=$url_site?>">
          </label>
          <label>
            <h5>Email del Sitio »</h5>
            <input type="text" name="mail" class="span5" placeholder="info@sitiotours.com" value="<?=$mail_site?>">
          </label>
          <label>
            <h5>Fecha » </h5>
            <input type="date" name="fech" class="span5" placeholder="" value="<?=$fech_site?>">
          </label>
          <label>
            <h5>Autor » </h5>
            <input type="text" name="auto" class="span5" placeholder="" value="<?=$auto_site?>">
          </label>
          <label>
            <h5>Copy Right » </h5>
            <input type="text" name="copy" class="span5" placeholder="" value="<?=$copy_site?>">
          </label>
          <button class="btn btn-primary btn-sitio pull-right">Guardar</button>
        </form>
        <br>
        <hr>
        <h5>Usuarios del Sistema »
          <a class="btn btn-sitio pull-right" href="usuario.php"><i class="icon-arrow-right"></i></a>
        <hr>
        <h5>Afiliados »
          <a class="btn btn-sitio pull-right" href="afiliado.php"><i class="icon-arrow-right"></i></a>
        </h5>
        </h5>
        <hr>
    </div>
  </body>
</html>