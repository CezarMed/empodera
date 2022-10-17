<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $id=$_POST['id']; 
  $query = "SELECT * FROM municipios WHERE estado_id=$id ORDER BY nombre ASC";
  $row= mysqli_query($conn,$query);
  while($result = mysqli_fetch_array($row)){
    $municipios .= "<option value='$result[id]'>$result[nombre]</option>";
  }
  return $municipios;
}

echo getMunicipios(); 