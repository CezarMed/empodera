<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $idCotizacion=$_POST['idCotizacion'];

  $query = "UPDATE solicitudcotizacionesmedicamentos SET estatus=5 WHERE idCotizacion=$idCotizacion";
  $row= mysqli_query($conn,$query);
  return $query;

  $query = "UPDATE solicitudcotizaciones SET estatus=5 WHERE idCotizacion=$idCotizacion";
  $row= mysqli_query($conn,$query);
  return $query;

}

echo getMunicipios(); 