<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getDiagnosticos(){
  $conn=conexion();
  $grupocie=$_POST['grupocie']; 
  list($a, $b) = explode("-", $grupocie);
  $query ="SELECT * FROM ciediagnosticos where codigo BETWEEN '$a' and '$b'";
  $row= mysqli_query($conn,$query);
  $diagnosticos .= "<option value=''>Elige un diagnostico</option>";
  while($result = mysqli_fetch_array($row)){    
    $diagnosticos .= "<option value='$result[diagnostico]'>$result[diagnostico] / $result[codigo]</option>";
  }
  return $diagnosticos;
}

echo getDiagnosticos(); 