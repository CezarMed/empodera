<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idConsulta=$_POST['idConsulta'];
  $grupocpt=$_POST['grupocpt'];
  $tratamientocpt=$_POST['tratamientocpt'];
  $cpt4=$_POST['cpt4'];
  $montonuevo=$_POST['montonuevo'];
  $mediconuevo=$_POST['mediconuevo'];

// edito los datos de la consulta
if ($tratamientocpt!=''){
  $query = "UPDATE datosconsultas SET grupocpt='$grupocpt', consultacpt4='$tratamientocpt', cpt4='$cpt4' where idConsulta=$idConsulta";
  $row= mysqli_query($conn,$query);  
}

//edito el monto de la consulta
if ($montonuevo!=''){
  $query = "UPDATE montosconsultas SET monto='$montonuevo' where idConsulta=$idConsulta";
  $row= mysqli_query($conn,$query);  
}

//edito el medico de la consulta
if ($mediconuevo!=''){
  $query = "UPDATE montosconsultas SET medico='$mediconuevo' where idConsulta=$idConsulta";
  $row= mysqli_query($conn,$query);  
}


  return $row;
}

echo getMunicipios(); 