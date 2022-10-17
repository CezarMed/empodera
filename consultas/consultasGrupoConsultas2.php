<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getDiagnosticos(){
  $conn=conexion();
  $tratamientocpt=$_POST['tratamientocptconsulta22']; 
  $query = "SELECT * FROM consultasdescripcion WHERE Titulo='$tratamientocpt'";
  $row= mysqli_query($conn,$query);
  while($result = mysqli_fetch_array($row)){    
    $diagnosticos .= "<option value='$result[Codigo]'>$result[Codigo]</option>";
  }
  return $diagnosticos;
}

echo getDiagnosticos(); 