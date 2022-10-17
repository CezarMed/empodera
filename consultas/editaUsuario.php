<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idUsuario=$_POST['idUsuario'];
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


$query="UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', sexo='$sexo', telefono='$telefono', usuario='$usuario', contrasena='$contrasena', email='$email', tipousuario='$tipousuario', idEmpresa='$idempresa' where idUsuario=$idUsuario";
$row=mysqli_query($con,$query);

return $row;
}

echo getMunicipios(); 