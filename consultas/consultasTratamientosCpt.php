<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getDiagnosticos(){
  $conn=conexion();
  $grupocpt=$_POST['grupocpt']; 
  list($a, $b) = explode("-", $grupocie);
  $query = "SELECT * FROM cpttratamientos WHERE grupocpt='$grupocpt'";
  $row= mysqli_query($conn,$query);
  $diagnosticos .= "<option value=''>Elige un diagnostico</option>";
  while($result = mysqli_fetch_array($row)){    
    $diagnosticos .= "<option value='$result[Titulo]'>$result[Titulo] / $result[Codigo]</option>";
  }
  return $diagnosticos;
}

echo getDiagnosticos(); 