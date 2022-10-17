<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $subGrupoCliente=$_POST['subGrupoCliente']; 
  $query = "SELECT * FROM montosclientes WHERE nombreAcuerdo='$subGrupoCliente'";
  $row= mysqli_query($conn,$query);
  $municipios .= "<option value=''>Elije un Sub-programa</option>";
  while($result = mysqli_fetch_array($row)){
    $municipios .= "<option value='$result[idMontoCliente]'>$result[subgrupo]</option>";
  }
  return $municipios;
}

echo getMunicipios(); 