<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $nombre=$_POST['nombre'];
  $apellidos=$_POST['apellidos'];
  $sexo=$_POST['sexo'];
  $telefono=$_POST['telefono'];
  $email=$_POST['email'];
  $tipousuario=$_POST['tipousuario'];
  $idempresa=$_POST['idempresa'];
  $imagen="dist/img/".$_POST['sexo'].".png";
  $usuario=$_POST['usuario'];
  $contrasena=$_POST['contrasena'];


$query="INSERT INTO usuarios (nombre, apellidos, sexo, telefono, usuario, contrasena, email, tipousuario, Imagen, idEmpresa, estatus) VALUES ('$nombre','$apellidos', '$sexo', '$telefono', '$usuario', '$contrasena', '$email', '$tipousuario', '$imagen', $idempresa, 1)";
$row=mysqli_query($con,$query);

return $row;
}

echo getMunicipios(); 