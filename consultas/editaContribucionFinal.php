<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $montoAutorizaActualiza2=$_POST['montoAutorizaActualizaF'];
  $montoAutorizaActualiza=str_replace( ',', '', $montoAutorizaActualiza2 );
  $montoAutorizaActualiza=str_replace( '$', '', $montoAutorizaActualiza );
  $idContribucion=$_POST['idContribucion'];
  $idContribucionAsignado=$_POST['idContribucionAsignado'];
  $idUser = $_SESSION['idUsuario'];

  $query="UPDATE archivoscontribucion SET montoAprobado='$montoAutorizaActualiza', monto='$montoAutorizaActualiza' WHERE idContribucion=$idContribucion";
  $row= mysqli_query($conn,$query);

   $query2="UPDATE contribucionesasignadas SET montoAsignado='$montoAutorizaActualiza' WHERE idCopagoAsignado=$idContribucionAsignado";
  mysqli_query($conn,$query2);

  return $row;
}

echo getMunicipios(); 