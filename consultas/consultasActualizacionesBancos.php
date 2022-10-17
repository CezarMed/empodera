<?php 
include('../class/conexion.php'); 
if (array_key_exists('consultasActualizaciones', $_POST)) {
	$conn=conexion();
	$idRegister=$_POST['consultasActualizaciones'];
	$sql="SELECT u.nombre, u.apellidos, mr.fechaMovimiento, mr.tipoMovimiento from movimientosbancos mr
INNER JOIN usuarios u on u.idUsuario=mr.idUsuario
where mr.idBanco=$idRegister";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);
    
  if ($filas>0) {
	$opciones='';
	$opciones.= '<table class="table table-striped projects">
                  <thead>
                    <tr>
                    <th>Nombre del Usuario</th>
                    <th>Movimiento</th> 
                    <th>Fecha de modifación</th>
                    </tr>
                  </thead>
                 <tbody>';
    while ($fila=mysqli_fetch_array($res)) {
    	  $idUsuario=$fila['nombre'];
    	  $apellidos=$fila['apellidos'];
        $fechaMovimiento=$fila['fechaMovimiento'];
        $movimiento=$fila['tipoMovimiento'];
        $opciones.= '<tr><td>'.$idUsuario.' '.$apellidos.'</td>
        <td>'.$movimiento.'</td>
        <td>'.$fechaMovimiento.'</td>';        
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
El banco no tiene movimientos
</p>
</div>';
 } 
}
?>