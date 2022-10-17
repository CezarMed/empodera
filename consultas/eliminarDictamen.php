<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idDictamen=$_POST['idDictamen'];
// desactivo el dictamen del servicio
  $query = "UPDATE dictamenesgenerados SET estatus=5 where idDictamenGenerado=$idDictamen";
  $row= mysqli_query($conn,$query);
  return $row;
}

echo getMunicipios(); 