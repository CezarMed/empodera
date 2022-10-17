<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getProveedores(){
  $conn=conexion();
  $id=$_POST['id'];
  $tipoatencion=$_POST['tipoatencion'];  
  if ($tipoatencion!='') {$criterio1="and tipoAtencion like '%".$tipoatencion."%'";} else {$criterio1='';}
  $situacionProveedor=$_POST['situacionProveedor'];
  if ($situacionProveedor!='') {$criterio2="and situacionProveedor=".$situacionProveedor."";} else {$criterio2='';}
  $situacionContrato=$_POST['situacionContrato'];
  if ($situacionContrato!='') {$criterio3="and situacionContrato=".$situacionContrato."";} else {$criterio3='';}


  $query = "SELECT * FROM registros WHERE entidadFederativa=$id $criterio1 $criterio2 $criterio3";
  $row= mysqli_query($conn,$query);
  while($result = mysqli_fetch_array($row)){
    $municipios .= "<option value='$result[idRegistro]'>$result[nombreComercial]</option>";
  }
  return $municipios;
}

echo getProveedores(); 