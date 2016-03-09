<?php
session_start();
if ($_SESSION['permiso']=="0" or empty($_SESSION['permiso'])){echo "<script>window.open('index.php','_parent','')</script>";}
include ("config.php");
include ("functions.php");

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
      <title>Mapa del Sitio</title>
   </head>

   <body>
      <div class="row contorno">
         <h3>Mapa del Sitio</h3>
         <div class="accordion text-justify">

<?php

   for ($i=0; $i <= 1 ; $i++) {
      sitemap($dbname,1,$i);
   }

?>

         </div>
      </div>

<!-- <?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

   <url>

      <loc>http://www.example.com/</loc>

      <lastmod>2005-01-01</lastmod>

      <changefreq>monthly</changefreq>

      <priority>0.8</priority>

   </url>

   <url>

      <loc>http://www.example.com/catalog?item=12&amp;desc=vacation_hawaii</loc>

      <changefreq>weekly</changefreq>

   </url>

   <url>

      <loc>http://www.example.com/catalog?item=73&amp;desc=vacation_new_zealand</loc>

      <lastmod>2004-12-23</lastmod>

      <changefreq>weekly</changefreq>

   </url>

   <url>

      <loc>http://www.example.com/catalog?item=74&amp;desc=vacation_newfoundland</loc>

      <lastmod>2004-12-23T18:00:15+00:00</lastmod>

      <priority>0.3</priority>

   </url>

   <url>

      <loc>http://www.example.com/catalog?item=83&amp;desc=vacation_usa</loc>

      <lastmod>2004-11-23</lastmod>

   </url>

</urlset>
 -->
   </body>
</html>



























