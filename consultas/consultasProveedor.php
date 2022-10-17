<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getProveedores(){
  $conn=conexion();
  $id=$_POST['id']; 
  $query = "SELECT * FROM registros WHERE modoAtencion='$id' and nombreComercial!='' ORDER BY nombreComercial ASC";
  $row= mysqli_query($conn,$query);
  while($result = mysqli_fetch_array($row)){
    $proveedores .= "<option value='$result[idRegistro]'>$result[nombreComercial]</option>";
  }
  return $proveedores;
}

echo getProveedores(); 