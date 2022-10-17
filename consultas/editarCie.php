<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idCie=$_POST['idCie'];
  $grupocie=$_POST['grupocie'];
  $diagnosticocie10=$_POST['diagnosticocie10'];
  $cie10=$_POST['cie10'];

  $query = "UPDATE datoscie SET grupocie='$grupocie', diagnosticocie10='$diagnosticocie10', cie10='$cie10' where idCie=$idCie";
  $row= mysqli_query($conn,$query);  
  return $row;

}

echo getMunicipios(); 