<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $idCopago=$_POST['idCopago'];
  $query = "UPDATE archivoscopagos SET estatus=5 WHERE idCopago=$idCopago";
  $row= mysqli_query($conn,$query);
  return $row;
}

echo getMunicipios(); 