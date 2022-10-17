<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $montoAutorizaActualiza2=$_POST['montoAutorizaActualiza'];
  $montoAutorizaActualiza=str_replace( ',', '', $montoAutorizaActualiza2 );
  $montoAutorizaActualiza=str_replace( '$', '', $montoAutorizaActualiza );
  $idCopago=$_POST['idCopago'];
  $idCopagoAsignado=$_POST['idCopagoAsignado'];
  $idUser = $_SESSION['idUsuario'];

  $query="UPDATE archivoscopagos SET montoAprobado='$montoAutorizaActualiza', monto='$montoAutorizaActualiza' WHERE idCopago=$idCopago";
  $row= mysqli_query($conn,$query);

   $query2="UPDATE copagosasignados SET montoAsignado='$montoAutorizaActualiza' WHERE idCopagoAsignado=$idCopagoAsignado";
  mysqli_query($conn,$query2);

  return $row;
}

echo getMunicipios(); 