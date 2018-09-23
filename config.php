<?php

//Variable de Conexion
$host = "localhost";
$username = "root";
$password = "";
$database = "maxil";

//Conexion al Servidor
$link = mysqli_connect($host, $username, $password) or die ("error de servidor");

//Conexion a la base de datos
mysqli_select_db($link, $database);

//Uso de tildes
//$tildes = $link->query("SET NAMES 'utf8'");



?>