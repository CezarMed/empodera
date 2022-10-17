<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idCopago=$_POST['idCopago'];
  $montoAutoriza=$_POST['montoAutoriza'];
  $montoAsigna=$_POST['montoAsigna'];
  $idUser = $_SESSION['idUsuario'];
  $idServicio = $_POST['idServicio'];
  $montoAsigna=str_replace( ',', '', $montoAsigna );
  $montoAsigna=str_replace( '$', '', $montoAsigna );
  $saldo=$montoAutoriza-$montoAsigna;
  

  if ($saldo=='0'){
  $queryEstatus = "UPDATE archivoscopagos SET estatus=4 where idCopago=$idCopago";
  $row= mysqli_query($conn,$queryEstatus);
  }

  $queryInserta="INSERT INTO copagosasignados (idCopago,idServicio,montoAsignado,idUser,fechaAsigna,estatus) values ($idCopago,$idServicio,'$montoAsigna',$idUser,'$hoy',1)";
  mysqli_query($conn,$queryInserta);

  $query="UPDATE archivoscopagos SET montoSaldo='$saldo' where idCopago=$idCopago";
  $row= mysqli_query($conn,$query);  
  return $row;

}

echo getMunicipios(); 