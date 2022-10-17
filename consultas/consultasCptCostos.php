<?php
error_reporting(0); 
include('../class/conexion.php'); 
if (array_key_exists('cambiaCPt', $_POST)) {
	$conn=conexion();
	$cambiaCPt=$_POST['cambiaCPt'];
	$entidadFederativa=$_POST['entidadFederativa'];

	if ($entidadFederativa=='9'||$entidadFederativa=='15'||$entidadFederativa=='21'||$entidadFederativa=='17'||$entidadFederativa=='2'||$entidadFederativa=='25') {  
            $honorarios='honorarios';
            $cirujano='cirujano';
            $anesteciologo='anesteciologo';
            $ayudante='ayudante'; 
            } else{
            $honorarios='honorariosforaneo';
            $cirujano='cirujanoforaneo';
            $anesteciologo='anesteciologoforaneo';
            $ayudante='ayudanteforaneo';
            }

    $sql="SELECT $honorarios as honorarios, $cirujano as cirujano, $anesteciologo as anesteciologo, $ayudante as ayudante FROM cpttratamientos where Titulo='$cambiaCPt'";
	$res = mysqli_query($conn,$sql);
	$opciones='';
    while ($datos=mysqli_fetch_array($res)) {
        $opciones.=$datos['honorarios'].'-'.$datos['cirujano'].'-'.$datos['anesteciologo'].'-'.$datos['ayudante'];
    }
    echo $opciones;
}
?>