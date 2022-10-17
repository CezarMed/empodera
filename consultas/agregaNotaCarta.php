<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $notasCarta=$_POST['observaciones'];
  $idServicio=$_POST['idServicio'];


$query="UPDATE servicios SET notasCarta='$notasCarta' where idServicio=$idServicio";
$row=mysqli_query($con,$query);

  return $row;
}

echo getMunicipios(); 