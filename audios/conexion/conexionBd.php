<?php 

$servidor = "192.168.0.3";
$baseDatos = "gentlefy";
$usuarioBd = "root";
$passwordBd = "perron11";

$conexionBd = mysql_connect($servidor , $usuarioBd, $passwordBd) or trigger_error(mysql_error(), E_USER_ERROR);

mysql_query("SET NAMES 'utf8'");

mysql_select_db($baseDatos, $conexionBd);

?>