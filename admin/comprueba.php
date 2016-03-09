<?php
session_start();
include("config.php");
$user = $_POST['user'];
$pass = $_POST['pass'];

$query_usuarios = "SELECT * FROM usuario WHERE nick_usuario='$user'";
$usuarios = mysql_db_query($dbname, $query_usuarios);
 
if (mysql_num_rows($usuarios)!=0)
{	

	if ($row = mysql_fetch_array($usuarios))
	{
		$usuario = $row["nick_usuario"];
		$contrasena = $row["pass_usuario"];

		if ($usuario==$user && $contrasena==$pass)
		{
			$_SESSION['permiso'] = "1";
			header("location: principal.php");
		}
		else if ($usuario==$user && $contrasena<>$pass)
		{
			$_SESSION['permiso'] = "0";
			$error = "usuario y/o contraseña incorrectos";
			header("location: index.php");
		}
		else
		{
			$_SESSION['permiso'] = "0";
		}
	}
}
else 
{
	$_SESSION['permiso'] = "0";
	$error = "usuario y/o contraseña incorrectos";
	header("location: index.php");
}

mysql_free_result($usuarios);

?>