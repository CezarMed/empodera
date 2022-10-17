<?php 
error_reporting(0);
include('../class/conexion.php'); 
if ($_POST) {
  $conn=conexion();
  $nombreMedicamento=$_POST['nombreMedicamento'];

  $sql="SELECT * FROM medicamentossolicitados ms 
  LEFT JOIN solicitudcotizacionesmedicamentos scm on scm.idProductoSolicitud=ms.idMedicamento
  left join solicitudcotizaciones sc on sc.idCotizacion=scm.idCotizacion
  left join registros reg on reg.idRegistro=sc.idProveedor
  where ms.medicamento like '%$nombreMedicamento%' GROUP BY ms.idMedicamento";
  $res = mysqli_query($conn,$sql);
  $filas = mysqli_num_rows($res);

  if ($filas>=1) {
  $datos='';
  $datos.= '<table class="table table-striped projects">
                   <thead>
                         <tr>
                             <th>Medicamento</th>
                             <th>Gramaje</th>
                             <th>Presentación</th>
                             <th>Cantidad</th>
                             <th>Proveedor</th>
                             <th>Fecha cotizado</th>
                             <th>Costo unitario</th>
                             <th>Costo total</th>
                             <th>Elegido</th>
                         </tr>
                        </thead><tbody>';
                        while ($fila = mysqli_fetch_array($res)) {
                        $datos.= '<tr>
                        <td>'.$fila['medicamento'].'</td>
                        <td>'.$fila['gramaje'].'</td>
                        <td>'.$fila['presentacion'].'</td>
                        <td>'.$fila['cantidad'].'</td>
                        <td>'.$fila['nombreComercial'].'</td>
                        <td>'.$fila['fechaRespuesta'].'</td>
                        <td>$'.$fila['costo'].'</td>
                        <td>$'.$fila['costototal'].'</td>
                        <td>'.$fila['eleccionPor'].'</td>
                        </tr>
              ';
          }
          $datos.='</tbody></table>';

echo $datos;
  } else  {
      echo '<div class="alert alert-block alert-danger" id="avisoSinResultados">
              <p>
              <strong>
              <i class="ace-icon fa fa-check"></i>
              Ups.!
              </strong>
              No encontramos resultados para tus datos de busqueda, intenta con otro nombre de medicamento o bien solo una parte del nombre para obtener mejores resultados
              </p>
              </div>';
 }
}

?>