<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $codigo=$_POST['codigo'];
  $diagnostico=$_POST['diagnostico'];
  $cie=$_POST['cie'];

$query="INSERT INTO ciediagnosticos (codigo, cie, diagnostico) VALUES ('$codigo','$cie', '$diagnostico')";
$row=mysqli_query($con,$query);

return $row;
}

echo getMunicipios(); 