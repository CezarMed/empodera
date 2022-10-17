<?php 
include('../class/conexion.php'); 
if (array_key_exists('idCopago', $_POST)) {
	$conn=conexion();
	$idCopago=$_POST['idCopago'];
	$sql="SELECT * from copagosasignados ca 
    inner join servicios s on s.idServicio=ca.idServicio
    inner join usuarios u on u.idUsuario=ca.idUser
    where ca.idCopago=$idCopago ";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);
    
  if ($filas>0) {
	$opciones='';
	$opciones.= '<table class="table table-striped projects">
                  <thead>
                    <tr>
                    <th>Servicio</th>
                    <th>Monto</th> 
                    <th>Fecha</th>
                    <th>Asigno</th>
                    </tr>
                  </thead>
                 <tbody>';
    while ($fila=mysqli_fetch_array($res)) {
        $opciones.= '
        <tr><td>'.$fila['folioEmpodera'].'</td>
        <td>$'.$fila['montoAsignado'].'</td>
        <td>'.$fila['fechaAsigna'].'</td>
        <td>'.strtoupper($fila['usuario']).'</td>';        
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
No tiene servicios asignados el copago
</p>
</div>';
 } 
}
?>