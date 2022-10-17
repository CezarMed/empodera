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
  $idUser = $_SESSION['idUsuario'];

  $query = "UPDATE archivoscopagos SET comentarios='$observaciones', idUsuarioAprobo=$idUser, estatus=5 WHERE idCopago=$idCopago";
  $row= mysqli_query($conn,$query);
  return $query;
}

echo getMunicipios(); 