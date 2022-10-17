<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $con=conexion();
  $idUsuario=$_SESSION['idUsuario'];
  $hoy=date('Y-m-d H:i:s');
  $grupocpt=$_POST['grupocpt'];
  $codigo=$_POST['codigo'];
  $titulo=$_POST['titulo'];
  $totalhonorarios=$_POST['totalhonorarios'];
  $totalhonorarios = str_replace( ',', '', $totalhonorarios );
  $totalhonorarios = str_replace( '$', '', $totalhonorarios );
  $cirujano=$_POST['cirujano'];
  $cirujano = str_replace( ',', '', $cirujano );
  $cirujano = str_replace( '$', '', $cirujano );
  $anesteciologo=$_POST['cirujano'];
  $anesteciologo = str_replace( ',', '', $anesteciologo );
  $anesteciologo = str_replace( '$', '', $anesteciologo );
  $ayudante=$_POST['ayudante'];
  $ayudante = str_replace( ',', '', $ayudante );
  $ayudante = str_replace( '$', '', $ayudante );
  // para foraneo
  $totalhonorariosforaneo=$_POST['totalhonorariosforaneo'];
  $totalhonorariosforaneo = str_replace( ',', '', $totalhonorariosforaneo );
  $totalhonorariosforaneo = str_replace( '$', '', $totalhonorariosforaneo );
  $cirujanoforaneo=$_POST['cirujanoforaneo'];
  $cirujanoforaneo = str_replace( ',', '', $cirujanoforaneo );
  $cirujanoforaneo = str_replace( '$', '', $cirujanoforaneo );
  $anesteciologoforaneo=$_POST['cirujanoforaneo'];
  $anesteciologoforaneo = str_replace( ',', '', $anesteciologoforaneo );
  $anesteciologoforaneo = str_replace( '$', '', $anesteciologoforaneo );
  $ayudanteforaneo=$_POST['ayudanteforaneo'];
  $ayudanteforaneo = str_replace( ',', '', $ayudanteforaneo);
  $ayudanteforaneo = str_replace( '$', '', $ayudanteforaneo);

$query="INSERT INTO cpttratamientos (grupocpt, Codigo, Titulo, honorarios, cirujano, anesteciologo, ayudante, honorariosforaneo, cirujanoforaneo, anesteciologoforaneo, ayudanteforaneo, estatus) VALUES ('$grupocpt','$codigo', '$titulo', '$totalhonorarios', '$cirujano', '$anesteciologo', '$ayudante', '$totalhonorariosforaneo', '$cirujanoforaneo', '$anesteciologoforaneo', '$ayudanteforaneo', 1)";
$row=mysqli_query($con,$query);

return $row;
}

echo getMunicipios(); 