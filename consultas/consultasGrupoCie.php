<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getDiagnosticos(){
  $conn=conexion();
  $diagnostico=$_POST['diagnosticocie10']; 
  $query = "SELECT * FROM ciediagnosticos WHERE diagnostico='$diagnostico'";
  $row= mysqli_query($conn,$query);
  while($result = mysqli_fetch_array($row)){    
    $diagnosticos .= "<option value='$result[cie]'>$result[cie]</option>";
  }
  return $diagnosticos;
}

echo getDiagnosticos(); 