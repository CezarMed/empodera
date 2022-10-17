<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $idCopago=$_POST['idCopago'];
  $observaciones=$_POST['observaciones'];
  $montoAutoriza=$_POST['montoAutoriza'];
  $idUser = $_SESSION['idUsuario'];
  $montoAutoriza = str_replace( ',', '', $montoAutoriza );
  $montoAutoriza = str_replace( '$', '', $montoAutoriza );

  $query = "UPDATE archivoscopagos SET montoAprobado='$montoAutoriza', montoSaldo='$montoAutoriza', comentarios='$observaciones', idUsuarioAprobo=$idUser, estatus=2 WHERE idCopago=$idCopago";
  $row= mysqli_query($conn,$query);
  return $query;
}

echo getMunicipios(); 