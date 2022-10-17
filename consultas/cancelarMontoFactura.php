<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $idComplemento=$_POST['idComplemento'];

  $query = "UPDATE servicioscomplementos SET estatus=5 WHERE idComplemento=$idComplemento";
  $row= mysqli_query($conn,$query);
  return $query;
}

echo getMunicipios(); 