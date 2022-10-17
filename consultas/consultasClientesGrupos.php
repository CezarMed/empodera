<?php 
error_reporting(0);
include('../class/conexion.php');
//funcion para llenar los modulos dependientes de estados
  $conn=conexion();
  $idCliente=$_POST['idCliente']; 
  $query = "SELECT * FROM montosclientes WHERE idCliente=$idCliente";
  $row= mysqli_query($conn,$query);
  $filas = mysqli_num_rows($row);

  if ($filas>0) {
  $opciones='';
  $opciones.= '<table class="table table-striped projects">
                  <thead>
                    <tr>
                    <th>Grupo</th>
                    <th>Sub-grupo</th>
                    <th>Contribución</th> 
                    <th>Co-pago</th>
                    </tr>
                  </thead>
                 <tbody>';
    while ($fila=mysqli_fetch_array($row)) {
        $opciones.= '
        <tr>
        <td><input type="hidden" id="idprograma" name="idprograma[]" value="'.$fila['idMontoCliente'].'">'.$fila['nombreAcuerdo'].'</td>
        <td>'.$fila['subgrupo'].'</td>
        <td><input type="hidden" id="contribucion" name="contribucion[]" value="'.$fila['contribucion'].'">$'.$fila['contribucion'].'</td>
        <td><input type="hidden" id="copago" name="copago[]" value="'.$fila['copago'].'">$'.$fila['copago'].'</td>
        </tr>';
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
El cliente no tiene cuentas asignadas
</p>
</div>';
}

?>