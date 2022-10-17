<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idCpt4=$_POST['idCpt4'];
  $grupocpt=$_POST['grupocpt'];
  $tratamientocpt=$_POST['tratamientocpt'];
  $cpt4=$_POST['cpt4'];

  $query = "UPDATE datoscpt SET grupocpt='$grupocpt', tratamientocpt4='$tratamientocpt', cpt4='$cpt4' where idCie=$idCpt4";
  $row= mysqli_query($conn,$query);  
  return $row;

}

echo getMunicipios(); 