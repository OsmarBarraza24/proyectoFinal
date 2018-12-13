<?php
// Definimos variables con los datos necesarios para la conexión
$servidor = "192.168.0.3";
$baseDatos = "gentlefy";
$usuarioBd = "root";
$passwordBd = "perron11";

// Creamos la conexión
$conexionBd = mysql_connect($servidor, $usuarioBd, $passwordBd) or trigger_error(mysql_error(), E_USER_ERROR);
//$conexionLocalhost = mysqli_connect($servidor, $usuarioBd, $passwordBd) or trigger_error(mysql_error(), E_USER_ERROR);


// Definimos el cotejamiento para la conexion (igual al cotejamiento de la BD)
mysql_query("SET NAMES 'utf8'");
//mysqli_query($conexionLocalhost, "SET NAMES 'utf8'");

// Seleccionamos la base de datos por defecto para el proyecto
mysql_select_db($baseDatos, $conexionBd);
//mysqli_select_db($conexionLocalhost, $baseDatos);


?>