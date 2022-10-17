<?php 
error_reporting(0);
include('../class/conexion.php'); 
if ($_POST) {
  $conn=conexion();
  $grupocpt=$_POST['grupocpt'];
  

  $sql="SELECT * from gruposcpt where idCpt=$grupocpt";
  $res = mysqli_query($conn,$sql);
  $filas = mysqli_num_rows($res);

  if ($filas>=1) {
  
  $datos='';
  while ($fila = mysqli_fetch_array($res)) {
    $titulo=$fila['Titulo'];
  $datos.= '<div class="alert alert-block alert-info">
              <p>
              <strong>
              <i class="ace-icon fa fa-check"></i>
              Titulo!
              </strong>
              <br>'.$titulo.'
              </div>';
              } 
echo $datos;
} 
else  
{
      echo '<div class="alert alert-block alert-danger">
              <p>
              <strong>
              <i class="ace-icon fa fa-check"></i>
              Ups.!
              </strong>
              <p>No encontramos resultados.
              </p>
              </div>';
 }

}

?>