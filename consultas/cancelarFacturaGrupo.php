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
  $tipoCancel=$_POST['tipoCancel'];
  // actualizo el grupos factura
  $query="UPDATE gruposfacturas SET estatus=$tipoCancel WHERE idGrupoFactura=$idFacturaGrupo";
  $row= mysqli_query($conn,$query);
  // actualizo el xml de la factura
  $query2="UPDATE facturasdatosxml SET estatus=$tipoCancel WHERE idFacturas=$idFactura";
  $row2= mysqli_query($conn,$query2);
  return $query;
}

echo getMunicipios(); 