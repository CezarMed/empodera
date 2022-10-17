<?php
session_start();
date_default_timezone_set ('America/Mexico_City');
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
function getMunicipios(){
  $conn=conexion();
  $hoy=date('Y-m-d H:i:s');
  $idCpt=$_POST['idCpt'];
  $totalhonorarios1=$_POST['totalhonorarios1'];
  $totalhonorarios1 = str_replace( ',', '', $totalhonorarios1 );
  $totalhonorarios1 = str_replace( '$', '', $totalhonorarios1 );
  $cirujano1=$_POST['cirujano1'];
  $cirujano1 = str_replace( ',', '', $cirujano1 );
  $cirujano1 = str_replace( '$', '', $cirujano1 );
  $anesteciologo1=$_POST['anesteciologo1'];
  $anesteciologo1 = str_replace( ',', '', $anesteciologo1 );
  $anesteciologo1 = str_replace( '$', '', $anesteciologo1 );
  $ayudante1=$_POST['ayudante1'];
  $ayudante1 = str_replace( ',', '', $ayudante1 );
  $ayudante1 = str_replace( '$', '', $ayudante1 );
  $totalhonorariosforaneo=$_POST['totalhonorariosforaneo'];
  $totalhonorariosforaneo = str_replace( ',', '', $totalhonorariosforaneo );
  $totalhonorariosforaneo = str_replace( '$', '', $totalhonorariosforaneo );
  $cirujanoforaneo=$_POST['cirujanoforaneo'];
  $cirujanoforaneo = str_replace( ',', '', $cirujanoforaneo );
  $cirujanoforaneo = str_replace( '$', '', $cirujanoforaneo );
  $anesteciologoforaneo=$_POST['anesteciologoforaneo'];
  $anesteciologoforaneo = str_replace( ',', '', $anesteciologoforaneo );
  $anesteciologoforaneo = str_replace( '$', '', $anesteciologoforaneo );
  $ayudanteforaneo=$_POST['ayudanteforaneo'];
  $ayudanteforaneo = str_replace( ',', '', $ayudanteforaneo );
  $ayudanteforaneo = str_replace( '$', '', $ayudanteforaneo );
  $titulo=$_POST['titulo'];

  $query="UPDATE cpttratamientos SET Titulo='$titulo', honorarios='$totalhonorarios1', cirujano='$cirujano1', anesteciologo='$anesteciologo1', ayudante='$ayudante1', honorariosforaneo='$totalhonorariosforaneo', cirujanoforaneo='$cirujanoforaneo', anesteciologoforaneo='$anesteciologoforaneo', ayudanteforaneo='$ayudanteforaneo' where idCpt=$idCpt";
  $row= mysqli_query($conn,$query);  
  return $row;

}

echo getMunicipios(); 