<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $montoAutoriza2=$_POST['montoAutoriza'];
  $montoAutoriza=str_replace( ',', '', $montoAutoriza2 );
  $montoAutoriza=str_replace( '$', '', $montoAutoriza );
  $idCuenta=$_POST['idCuenta'];
  $idBeneficiario=$_POST['idBeneficiario'];
  $idServicio = $_POST['idServicio'];
  $observaciones = $_POST['observaciones'];

$query="INSERT INTO archivoscontribucion 
(idCuenta,idBeneficiario,tipocopago,archivo,monto,montoAprobado,idSubio,fechaSubida,comentarios,estatus)
values 
(".$idCuenta.",". $idBeneficiario.",'Pagado','-','".$montoAutoriza."','".$montoAutoriza."',".$idUsuario.",'".$hoy."','".$observaciones."',4)";
$row=mysqli_query($con,$query);

$sqlC="SELECT * from archivoscontribucion ORDER BY idContribucion DESC";
$resC = mysqli_query($con,$sqlC);
$extraer=mysqli_fetch_array($resC);
$idContribucion=$extraer['idContribucion'];


$queryInserta="INSERT INTO contribucionesasignadas (idCopago,idServicio,montoAsignado,idUser,fechaAsigna,estatus) values ($idContribucion,$idServicio,'$montoAutoriza',$idUsuario,'$hoy',1)";
  mysqli_query($con,$queryInserta);

  return $row;
}

echo getMunicipios(); 