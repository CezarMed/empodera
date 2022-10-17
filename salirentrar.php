<?php
// inicio la sesion de usuario
session_start();
// valido que la sesion esta en uso sino direcciono al index
if ($_SESSION["usuario"] != true) {
    header("Location: index");
    exit;
}
// incluimos el archivo de conexion para hacer las consultas
include('class/conexion.php');
$con = conexion();
// cargo las sesiones a utilizar
$id = $_SESSION['idUsuario'];
$tipo = $_SESSION['tipousuario'];
$usuario = $_SESSION['usuario'];
if($_GET['id']){
$idEmpresa =$_GET['id'];
$tipousuario = $_SESSION['tipousuario'];
// $idEmpresa=$_SESSION['idEmpresa'];
// creo la consulta para actualizar en que clinica se encuentra el supervisor
$query="UPDATE usuarios SET idEmpresa=$idEmpresa WHERE idUsuario=".$id;
$res=mysqli_query($con,$query);
$query = "UPDATE usuarios SET  tipousuario='$tipo' WHERE  idUsuario=".$id;
//$res = mysqli_query($query);

//Comienzo el inicio de sesion de el supervisor en la nueva clinica selecciona
$nombre = mysqli_real_escape_string($_POST['username']);
$password = mysqli_real_escape_string($_POST['password']);
}
if($_GET['tipo']){

$tipo =$_GET['tipo'];
$tipousuario = $_SESSION['tipousuario'];
// creo la consulta para actualizar en que clinica se encuentra el supervisor
$query = "UPDATE usuarios SET  tipousuario='$tipo' WHERE idUsuario=".$id;
$res = mysqli_query($con,$query);

//Comienzo el inicio de sesion de el supervisor en la nueva clinica selecciona
$nombre = mysqli_real_escape_string($_POST['username']);
$password = mysqli_real_escape_string($_POST['password']);
}
//realizamos la consulta sql 

if($totalPerfiles==0){
    $query = "SELECT * FROM usuarios WHERE idUsuario=".$id;
    //ejecutamos la consulta y guardamos el resultado en la variable resultado
    $resultado = mysqli_query($con,$query);
    if ($reg = mysqli_fetch_array($resultado)) {
        // session_destroy();
        $_SESSION['idUsuario'] = $reg["idUsuario"];
        $_SESSION['usuario'] = $reg["usuario"];
        $_SESSION['tipousuario'] = $reg["tipousuario"];
        $_SESSION['password'] = $password;
        $_SESSION['idEmpresa']=$reg["idEmpresa"];
        $_SESSION['Tipo'] = $reg["Tipo"];

        header("Location: panelPrincipal");
    } else {
        header("Location:index?usuario=no_existe");
    }
}
?>