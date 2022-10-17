<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $grupocpt=$_POST['grupocpt'];
  $codigo=$_POST['codigo'];
  $titulo=$_POST['titulo'];

$query="INSERT INTO consultasdescripcion (grupocpt, Codigo, Titulo, estatus) VALUES ('$grupocpt','$codigo', '$titulo', 1)";
$row=mysqli_query($con,$query);

return $row;
}

echo getMunicipios(); 