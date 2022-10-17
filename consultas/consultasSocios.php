<?php
error_reporting(0); 
include('../class/conexion.php'); 
if (array_key_exists('consultasSocios', $_POST)) {
	$conn=conexion();
	$rfc=$_POST['consultasSocios'];
	$sql="SELECT rfcCedula,noProveedor,nombreComercial from registros where rfcCedula='$rfc' Limit 1";
	$res = mysqli_query($conn,$sql);
	$opciones='';
    while ($datos=mysqli_fetch_array($res)) {
        $opciones.=$datos['rfcCedula'].'-'.$datos['noProveedor'].'-'.$datos['nombreComercialfrom'];
    }
    echo $opciones;
}
?>