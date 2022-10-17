<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getProveedores(){
  $conn=conexion();
  $name=$_POST['name'];
  $rfc=$_POST['rfc'];
  $tipoatencion=$_POST['tipoatencion']; 
  $id=$_POST['id'];
  $situacionProveedor=$_POST['situacionProveedor'];
   $situacionContrato=$_POST['situacionContrato'];
  
  if ($id!='') {$criterio="and r.entidadFederativa=".$id."";} else {$criterio='';}

  
  if ($situacionProveedor!='') {$criterio2="and r.situacionProveedor=".$situacionProveedor."";} else {$criterio2='';}

 
  if ($situacionContrato!='') {$criterio3="and r.situacionContrato=".$situacionContrato."";} else {$criterio3='';}

  if($name!=''){
  $query = "SELECT * FROM registros r WHERE r.nombrecomercial like '%$name%' $criterio $criterio2 $criterio3";
  }
  if($rfc!=''){
  $query = "SELECT * FROM registros r WHERE r.rfcCedula like '%$rfc%' $criterio $criterio2 $criterio3";
  }

   
  if ($tipoatencion!='') {
    $query = "SELECT * FROM registrostipoatencion ra
    inner join registros r on r.idRegistro=ra.idRegistro
    WHERE ra.idAtencion=$tipoatencion and ra.estatus=1 $criterio $criterio2 $criterio3";
  }


  $row= mysqli_query($conn,$query);
  while($result = mysqli_fetch_array($row)){
    $municipios .= "<option value='$result[rfcCedula]'>$result[nombreComercial]</option>";
  }
  return $municipios;
}

echo getProveedores(); 