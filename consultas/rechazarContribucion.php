<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $idContribucion=$_POST['idContribucion'];
  $observaciones=$_POST['observaciones'];
  $idUser = $_SESSION['idUsuario'];

  $query = "UPDATE archivoscontribucion SET comentarios='$observaciones', idUsuarioAprobo=$idUser, estatus=5 WHERE idContribucion=$idContribucion";
  $row= mysqli_query($conn,$query);
  return $query;
}

echo getMunicipios(); 