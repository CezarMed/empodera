<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $montoGasto=$_POST['montoGasto'];
  $conceptoGasto=$_POST['conceptoGasto'];
  $idServicio=$_POST['idServicioGM'];
  $montoGasto = str_replace( ',', '', $montoGasto );
  $montoGasto = str_replace( '$', '', $montoGasto );

$query="INSERT INTO gastosmedicos 
(idServicio,concepto,monto,idSubio,fechaSubida,estatus)
values 
(".$idServicio.",'". $conceptoGasto."','".$montoGasto."',".$idUsuario.",'".$hoy."',1)";
$row=mysqli_query($con,$query);
  return $row;
}

echo getMunicipios(); 