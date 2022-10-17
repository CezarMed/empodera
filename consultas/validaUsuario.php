<?php 
error_reporting(0);
include('../class/conexion.php'); 
  $conn=conexion();
  $usuario=$_POST['usuario'];

  $sql="SELECT * from usuarios u where u.usuario='$usuario'";
  $res = mysqli_query($conn,$sql);
  $filas = mysqli_num_rows($res);

  if ($filas>=1) {
  {
  $datos='<div class="alert alert-block alert-success">
              <p>
              <strong>
              <i class="ace-icon fa fa-check"></i>
              Ups.!
              </strong>
              El usuario si es valido
              </p>
              </div>';
   echo $datos;
 }
} 


?>