<?php 
include('../class/conexion.php'); 
if (array_key_exists('consultasActualizaciones', $_POST)) {
	$conn=conexion();
	$idRegister=$_POST['consultasActualizaciones'];
	$sql="SELECT * from notasmedicas nm 
    INNER JOIN beneficiarios b on b.idBenefeciario=nm.idBeneficiario
    where nm.idServicio=$idRegister ORDER BY nm.idNota DESC";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);
    
  if ($filas>0) {
	$opciones='';
    while ($fila=mysqli_fetch_array($res)) {
        $fechaElaboracion=$fila['fechaElaboracion'];
        $horaElbaora=$fila['horaElbaora'];
    	  $tipoComunicacion=$fila['tipoComunicacion'];
    	  $nombrecomunica=$fila['nombrecomunica']; 
          $nombreBeneficiario=$fila['nombreBeneficiario']; 
          $motivoatencion=$fila['motivoatencion'];
          $resumeninterrogatorio=$fila['resumen'];
          $exploracionfis=$fila['exploracionfis'];
          $diagnostico=$fila['diagnostico']; 
          $planestudios=$fila['planestudios'];       
    $opciones.='<div class="alert alert-block alert-info">
<p>
Se recibe con fecha '.$fechaElaboracion.' y hora '.$horaElbaora.' un(a) '.$tipoComunicacion.' de '.$nombrecomunica.' con peticion para '.$nombreBeneficiario.' por motivo de '.$motivoatencion.'. El beneficiario actualmente '.$resumeninterrogatorio.', '.$exploracionfis.' ,'.$diagnostico.' ,'.$planestudios.'
</p>
</div>';
}
    echo $opciones;
} else {
    echo '<div class="alert alert-block alert-danger">
<p>
<strong>
<i class="ace-icon fa fa-check"></i>
Ups.!
</strong>
El servicio no tiene notas medicas agregadas
</p>
</div>';
 } 
}
?>