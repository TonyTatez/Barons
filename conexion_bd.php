<?php



// Configuración de zona horaria en el servidor
date_default_timezone_set('America/Guayaquil');

 $db_host = "localhost";
 $db_name = "u230879413_comunicaapp";
 $db_user = "root";
 $db_pass = "";
 
 try{
  
  $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
  $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 }
 catch(PDOException $e){
  echo $e->getMessage();
 }

$conn = mysqli_connect($db_host, $db_user, $db_pass , $db_name) or die($conn);
$conexion = mysqli_connect($db_host, $db_user, $db_pass , $db_name) or die($conn);
$mysqli = new mysqli($db_host,$db_user,$db_pass,$db_name);



// Configuración de caracteres en los textos extraidos de la base
mysqli_query ($conexion,"SET NAMES 'utf8'");

?>