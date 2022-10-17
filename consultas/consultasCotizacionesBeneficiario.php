<?php 
error_reporting(0);
include('../class/conexion.php'); 
if (array_key_exists('consultasSocios', $_POST)) {
	$conn=conexion();
	$nombreBeneficiario=$_POST['consultasSocios'];
	$sql="SELECT s.folioEmpodera, sm.idSolicitudMedicamentos, sm.folioSolicitud, b.nombreBeneficiario, sm.fechaSolicitud, sm.estatus 
  FROM beneficiarios b 
  INNER JOIN solicitudmedicamentos sm on sm.idBeneficiario=b.idBenefeciario
  INNER JOIN servicios s on s.idServicio=sm.idServicio
  where b.nombreBeneficiario like '%$nombreBeneficiario%' ORDER BY sm.fechaSolicitud DESC";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);
	if ($filas>0) {
		$datos='';
	$datos.= '<table class="table table-striped projects">
                                <thead>
                                        <tr>
                                                <th>Folio de Servicio</th>
                                                <th>Nombre del beneficiario</th>
                                                <th>Fecha de solicitud</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead><tbody>';

                                 while ($fila = mysqli_fetch_array($res)) {
                                  $estatus=$fila['estatus'];
                                  if ($estatus==1){ $estatus='En proceso';
                                                    $boton='<a class="btn btn-info btn-sm" href="responderCotizacionEmpodera?idSolicitudMedicamentos='.$fila['idSolicitudMedicamentos'].'">
                              <i class="fas fa-edit">
                              </i>
                              Ver cotizaciones
                          </a>';}
                                  if ($estatus==2){ $estatus='Recibido';
                                                    $boton='Cotizacion ya elegida';}
                          if ($estatus==3){ $estatus='Terminado';
                                                    $boton='Ya fue elegida';}
                                                    if ($estatus==5){ $estatus='Cancelado';
                                                    $boton='';}
          
      $datos.= '<tr><td>'.$fila['folioEmpodera'].'</td><td>'.$fila['nombreBeneficiario'].'</td><td>'.$fila['fechaSolicitud'].'</td><td>'.$estatus.'</td><td>
                          '.$boton.'
                         


                      </td></tr>
              ';
          }
     $datos.='</tbody></table>'; 

	echo $datos;
	} else 	{
      echo '<div class="alert alert-block alert-danger">

<p>
<strong>
<i class="ace-icon fa fa-check"></i>
Ups.!
</strong>
El beneficiario no cuenta con cotizaciones pendientes por responder
</p>
</div>';
 }

}
?>