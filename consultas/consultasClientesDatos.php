<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $namecliente=$_POST['namecliente']; 
  $query = "SELECT * FROM clientes WHERE nombreCliente  like '%$namecliente%'";
  $row= mysqli_query($conn,$query);
  // $municipios .= "<option value=''>Elije un programa</option>";
  while($result = mysqli_fetch_array($row)){
    $municipios .= "<option value='$result[idCliente]'>$result[nombreCliente]</option>";
  }
  return $municipios;
}

echo getMunicipios(); 