<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $idCliente=$_POST['idCliente']; 
  $query = "SELECT * FROM montosclientes WHERE idCliente=$idCliente GROUP BY nombreAcuerdo";
  $row= mysqli_query($conn,$query);
  $municipios .= "<option value=''>Elije un programa</option>";
  while($result = mysqli_fetch_array($row)){
    $municipios .= "<option value='$result[nombreAcuerdo]'>$result[nombreAcuerdo]</option>";
  }
  return $municipios;
}

echo getMunicipios(); 