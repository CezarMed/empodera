<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idAsignacion=$_POST['idAsignacion'];
  $proveedor2=$_POST['proveedor2'];
  $contenidonota2=$_POST['contenidonota2'];
  $fechaServicio2=$_POST['fechaServicio2'];
  $tipoServicio=$_POST['tipoServicio'];
  $proveedorAnterior=$_POST['proveedorAnterior'];
  $idSolicitudMedicamentos=$_POST['idSolicitudMedicamentos'];

  if ($proveedor2!=''){
  $query="UPDATE servicioscerradosproveedor SET proveedorname=$proveedor2 where idcierre=$idAsignacion";
  $row=mysqli_query($conn,$query);
  }
  if ($contenidonota2!=''){
  $query="UPDATE servicioscerradosproveedor SET contenidonota='$contenidonota2' where idcierre=$idAsignacion";
  $row=mysqli_query($conn,$query);
  }
  if ($fechaServicio2!=''){
  $query="UPDATE servicioscerradosproveedor SET fechaServicio='$fechaServicio2' where idcierre=$idAsignacion";
  $row=mysqli_query($conn,$query);
  }
  if ($tipoServicio=='MEDICAMENTOS'){  
  $query="UPDATE solicitudcotizaciones SET idProveedor=$proveedor2 where idProveedor=$proveedorAnterior and idSolicitudMedicamentos=$idSolicitudMedicamentos ";
  $row2=mysqli_query($conn,$query);
  }

  return $row;

}

echo getMunicipios(); 