<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $entidadFederativa=$_POST['entidadFederativa'];
  $nombremunicipio=$_POST['nombremunicipio'];

// OBTENGO LA CLAVE DEL ESTADO
$queryEstado="SELECT * FROM estados where clave='$entidadFederativa'";
$res=mysqli_query($con,$queryEstado);
$registrosestados=mysqli_fetch_array($res);
$idEstado=$registrosestados['idEstado'];

$query="INSERT INTO municipios (estado_id,clave,nombre) VALUES ('$idEstado','$entidadFederativa','$nombremunicipio')";
$row=mysqli_query($con,$query);

return $row;
}

echo getMunicipios(); 