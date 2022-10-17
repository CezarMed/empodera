<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idComplemento=$_POST['idComplemento2'];
  $montoNuevo=$_POST['montoNuevo'];
  $montoNuevo = str_replace( ',', '', $montoNuevo );
  $montoNuevo = str_replace( '$', '', $montoNuevo );

  $query = "UPDATE servicioscomplementos SET montoComplemento='$montoNuevo' where idComplemento=$idComplemento";
  $row= mysqli_query($conn,$query);  
  return $row;

}

echo getMunicipios(); 