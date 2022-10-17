<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idCpt=$_POST['idCpt'];
  $titulo=$_POST['titulo'];

  $query="UPDATE consultasdescripcion SET Titulo='$titulo' where idCpt=$idCpt";
  $row= mysqli_query($conn,$query);  
  return $row;

}

echo getMunicipios(); 