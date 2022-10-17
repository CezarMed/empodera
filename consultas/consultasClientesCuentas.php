<?php 
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $subGrupoPrograma=$_POST['subGrupoPrograma']; 
  $query = "SELECT * FROM montosclientes WHERE idMontoCliente=$subGrupoPrograma";
  $row= mysqli_query($conn,$query);
  while($datos = mysqli_fetch_array($row)){
    $opciones=$datos['contribucion'].'-'.$datos['copago'].'-'.$datos['montoautorizadocliente'];
  }
  return $opciones;
}

echo getMunicipios(); 