<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $idFacturaGrupo=$_POST['idFacturaGrupo'];
  $idFactura=$_POST['idFactura'];

  $query="UPDATE gruposfacturas SET estatus=7 WHERE idGrupoFactura=$idFacturaGrupo";
  $row= mysqli_query($conn,$query);
  return $query;
}

echo getMunicipios(); 