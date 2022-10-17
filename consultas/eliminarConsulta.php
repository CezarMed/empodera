<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idConsulta=$_POST['idConsultaEliminar'];
// edito los datos de la consulta
  $query = "UPDATE datosconsultas SET estatus=5 where idConsulta=$idConsulta";
  $row= mysqli_query($conn,$query);

    $query2 = "UPDATE montosconsultas SET estatus=5 where idConsulta=$idConsulta";
  $row2= mysqli_query($conn,$query2);

  return $row;
}

echo getMunicipios(); 