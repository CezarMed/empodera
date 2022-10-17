<?php 
include('../class/conexion.php'); 
if (array_key_exists('idFactura', $_POST)) {
	$conn=conexion();
	$idFactura=$_POST['idFactura'];
	$sql="SELECT * FROM servicioscomplementos sc
    INNER JOIN servicios s ON s.idServicio=sc.idServicio
    where sc.idFactura=$idFactura";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);
    
  if ($filas>0) {
	$opciones='';
	$opciones.= '<table class="table table-striped projects">
                  <thead>
                    <tr>
                    <th>Servicio</th>
                    <th>Tipo complemento</th> 
                    <th>Monto aplicado</th>
                    </tr>
                  </thead>
                 <tbody>';
    while ($fila=mysqli_fetch_array($res)) {
        $opciones.= '<tr><td>'.$fila['folioEmpodera'].'</td>
        <td>'.$fila['tipoComplemento'].'</td>
        <td>$'.$fila['montoComplemento'].'</td>';        
    }
    $opciones.='</tbody></table>';
    echo $opciones;
} else {
    echo '<div class="alert alert-block alert-danger">
<p>
<strong>
<i class="ace-icon fa fa-check"></i>
Ups.!
</strong>
La factura no tiene montos asignnados
</p>
</div>';
 } 
}
?>