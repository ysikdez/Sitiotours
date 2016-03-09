<?php
session_start();
if(isset($SESSION)){
header("location:principal.php"); 
} else {
$error="Ingrese su nombre de usuario y contrase&ntilde;a";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link href="../css/bootstrap.css" rel="stylesheet">
  <link href="css/estilos.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
  <style type="text/css">
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #FCEBBE;
    }
    .form-signin {
      max-width: 300px;
      padding: 19px 29px 29px;
      margin: 0 auto 20px;
      background-color: #fff;
      border: 1px solid #e5e5e5;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
      -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
      box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
      margin-bottom: 10px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
      font-size: 16px;
      height: auto;
      margin-bottom: 15px;
      padding: 7px 9px;
    }
  </style>
  <link href="../img/ico-sitiotours.png" rel="shortcut icon">
  <script src="../js/jquery.js"></script>
  <script src="../js/bootstrap.js"></script>
  <link href="css/estilo.css" type="text/css" rel="stylesheet" />
  <link href="imagenes/logo.png" rel="shortcut icon">
  <title>Sistema de Administracion de Sitio Tours</title>
</head>
<body>
  <div class="container text-center">
    <form method="post" action="comprueba.php" class="form-signin">
      <figure>
        <img src="../img/sitiotours-logo.png" alt="Logo Sitiotours.com" border="0" width="200" heigth="114">
      </figure>
      <br>
      <p><?=$error?></p>
      <input type="text" name="user" id="user" class="input-block-level" placeholder="Usuario">
      <input type="password" name="pass" id="pass" class="input-block-level" placeholder="Password">
      <button type="submit"  name="enviar" id="enviar" class="btn btn-large btn-sitio">Ingresar</button>
    </form>
<?php } ?>
  </div>

</body>
</html>
