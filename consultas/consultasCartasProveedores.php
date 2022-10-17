<?php 
error_reporting(0);
include('../class/conexion.php'); 
if (array_key_exists('idRegistro', $_POST)) {
	$conn=conexion();
	$idRegistro=$_POST['idRegistro'];

	$sql="SELECT * from servicioscerradosproveedor scp
  inner join beneficiarios b on b.idBenefeciario=scp.idBeneficiario
  inner join servicios s on s.idServicio=scp.idServicio 
  where scp.proveedorname=$idRegistro and scp.estatus=1 and s.estatus!=4 and s.monto!=0";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);

	if ($filas>0) {
		$datos='';
	$datos.= '<table class="table table-striped projects">
                                <thead>
                                        <tr>
                                                <th></th>
                                                <th>Folio de carta</th>
                                                <th>Folio de servicio</th>
                                                <th>Observaciones</th>
                                                <th>Nombre del beneficiario</th>
                                                <th>Monto total</th>
                                        </tr>
                                </thead><tbody>';

                                 while ($fila = mysqli_fetch_array($res)) {
                        $datos.= '<tr><td></td><td><input type="checkbox" class="form-check-input" id="idServicio" name="idServicio[]" value="'.$fila['idServicio'].'">'.$fila['folioCierre'].'</td><td>'.$fila['folioEmpodera'].'</td><td>'.$fila['observaciones'].'</td><td>'.$fila['nombreBeneficiario'].'</td><td>$'.number_format($fila['monto'],2,'.',',').'</td></tr>';
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
              El proveedor no tiene Cartas autorizadas para cobro, esto no bloquea el envio de la factura
              </p>
              </div>';
 }

}
?>