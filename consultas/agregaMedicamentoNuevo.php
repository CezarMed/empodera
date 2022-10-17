<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $idSolicitudMedicamentos=$_POST['idSolicitudMedicamentos'];
  $nombreNuevo=$_POST['nombreNuevo'];
  $gramajeNuevo=$_POST['gramajeNuevo'];
  $presentacionNuevo = $_POST['presentacionNuevo'];
  $cantidadNuevo = $_POST['cantidadNuevo'];
  $fechaTerminaNuevo = $_POST['fechaTerminaNuevo'];
  $idCotizacion = $_POST['idCotizacion'];

$query="INSERT INTO medicamentossolicitados (idSolicitudMedicamento,medicamento,gramaje,presentacion,cantidad,fechaTermina,estatus)
values 
(".$idSolicitudMedicamentos.",'".$nombreNuevo."','".$gramajeNuevo."','".$presentacionNuevo."','".$cantidadNuevo."','".$fechaTerminaNuevo."',1)";
$row=mysqli_query($con,$query);

$queryProvee = "SELECT * from medicamentossolicitados ORDER BY idMedicamento DESC";
$resProvee = mysqli_query($con,$queryProvee);
$extraidoProvee= mysqli_fetch_array($resProvee);
$idMedicamento=$extraidoProvee['idMedicamento'];

$query2="INSERT INTO solicitudcotizacionesmedicamentos (idCotizacion,idProductoSolicitud,costo,costototal,existencias,elegido,estatus)
values 
(".$idCotizacion.",'".$idMedicamento."','0','0','Con Existencias',1,1)";
mysqli_query($con,$query2);



  return $row;
}

echo getMunicipios(); 