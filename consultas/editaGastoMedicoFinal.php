<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d');
  $editarMontoServicio2=$_POST['editarMontoServicio2'];
  $montoGastoActualiza=$_POST['montoGastoActualiza'];
  $montoGastoActualiza=str_replace( ',', '', $montoGastoActualiza );
  $montoGastoActualiza=str_replace( '$', '', $montoGastoActualiza );

  $query="UPDATE gastosmedicos SET monto='$montoGastoActualiza' WHERE idMontoServicio=$editarMontoServicio2";
  $row= mysqli_query($conn,$query);

  return $row;
}

echo getMunicipios(); 