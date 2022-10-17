<?php 
error_reporting(0);
include('../class/conexion.php'); 
if (array_key_exists('consultasSocios', $_POST)) {
	$conn=conexion();
	$nombreBeneficiario=$_POST['consultasSocios'];
  $buscarpor=$_POST['buscarpor'];

  if ($buscarpor=='nombreBeneficiario') {
	$sql="SELECT idBenefeciario, folioBeneficiario, nombreBeneficiario, fechaNacimiento 
  from beneficiarios where nombreBeneficiario like '%$nombreBeneficiario%'";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);
	if ($filas>0) {
	$datos='';
	$datos.= '<table class="table table-striped projects">
                                <thead>
                                        <tr>
                                          <th>Numero de Beneficiario</th>
                                          <th>Nombre del beneficiario</th>
                                          <th>Cuentas</th>
                                        </tr>
                                </thead>
                              <tbody>';
                  while ($fila = mysqli_fetch_array($res)) {
                  $idBeneficiario=$fila['idBenefeciario'];                                  
                  $sqlservices="SELECT * from beneficiarioscuentas bc 
                  INNER JOIN montosclientes mc on mc.idMontoCliente=bc.idPrograma
                  where bc.idBeneficiario=$idBeneficiario and bc.estatusCuenta=1";
                  $resServices = mysqli_query($conn,$sqlservices);           
                  $datos.= '<tr><td>'.$fila['folioBeneficiario'].'</td><td>'.$fila['nombreBeneficiario'].'</td><td>';
                  while ($filasServices = mysqli_fetch_array($resServices)) {            
                          $datos.= '<a class="btn btn-info btn-sm" href="agregarServiciosBeneficiario?idBeneficiario='.$fila['idBenefeciario'].'&idCuenta='.$filasServices['idCuenta'].'">
                              <i class="fas fa-edit">
                              </i>
                              '.$filasServices['nombreAcuerdo'].'-'.$filasServices['subgrupo'].'
                          </a>';
                        }
                  $datos.= '</td></tr>';
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
              El beneficiario no se encuentra registrado, registralo desde el panel Alta de Beneficiario, o bien buscalo por el folio de Servicio
              </p>
              </div>';
 }
}

  if ($buscarpor=='folioBeneficiario') {
  $sql="SELECT idBenefeciario, folioBeneficiario, nombreBeneficiario, fechaNacimiento from beneficiarios where folioBeneficiario like '%$nombreBeneficiario%'";
  $res = mysqli_query($conn,$sql);
  $filas = mysqli_num_rows($res);

  if ($filas>0) {
    $datos='';
  $datos.= '<table class="table table-striped projects">
            <thead>
            <thead>
                                        <tr>
                                          <th>Numero de Beneficiario</th>
                                          <th>Nombre del beneficiario</th>
                                          <th>Cuentas</th>
                                        </tr>
                                </thead>
                                </thead><tbody>';
                  while ($fila = mysqli_fetch_array($res)) {
                  $idBeneficiario=$fila['idBenefeciario'];                                  
                  $sqlservices="SELECT * from beneficiarioscuentas bc 
                  INNER JOIN montosclientes mc on mc.idMontoCliente=bc.idPrograma
                  where bc.idBeneficiario=$idBeneficiario";
                  $resServices = mysqli_query($conn,$sqlservices);           
                  $datos.= '<tr><td>'.$fila['folioBeneficiario'].'</td><td>'.$fila['nombreBeneficiario'].'</td><td>';
                  while ($filasServices = mysqli_fetch_array($resServices)) {            
                          $datos.= '<a class="btn btn-info btn-sm" href="agregarServiciosBeneficiario?idBeneficiario='.$fila['idBenefeciario'].'&idCuenta='.$filasServices['idCuenta'].'">
                              <i class="fas fa-edit">
                              </i>
                              '.$filasServices['subgrupo'].'
                          </a>';
                        }
                  $datos.= '</td></tr>';
          }
            
     $datos.='</tbody></table>'; 

  echo $datos;
  } else  {
      echo '<div class="alert alert-block alert-danger">
              <p>
              <strong>
              <i class="ace-icon fa fa-check"></i>
              Ups.!
              </strong>
              El beneficiario no se encuentra registrado, registralo desde el panel Alta de Beneficiario, o bien buscalo por el folio de Servicio
              </p>
              </div>';
 }
}


if ($buscarpor=='folioEmpodera') {
  $sql2="SELECT s.fechaAlta, s.estatus, folioEmpodera, nombreBeneficiario, servicio, idServicio, idBeneficiario from servicios s
  INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario
  where s.folioempodera like '%$nombreBeneficiario%'";
  $res2 = mysqli_query($conn,$sql2);
  $filas2= mysqli_num_rows($res2);
  if ($filas2>0) {
  $datos2='';
  $datos2.= '<table class="table table-striped projects">
                                <thead>
                                        <tr>
                                                <th>Folio de servicio</th>
                                                <th>Nombre del beneficiario</th>
                                                <th>Tipo de Servicio</th>
                                                <th>Fecha de Solicitud</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead><tbody>';

                                 while ($fila2 = mysqli_fetch_array($res2)) {
                                  $estatus=$fila2['estatus'];
          
                        $datos2.= '<tr><td>'.$fila2['folioEmpodera'].'</td><td>'.$fila2['nombreBeneficiario'].'</td><td>'.$fila2['servicio'].'</td><td>'.$fila2['fechaAlta'].'</td><td>';
                          if ($estatus!=5) {
                          $datos2.= '<a class="btn btn-success btn-sm" href="detalleDeServicio?idServicio='.$fila2['idServicio'].'&idBeneficiario='.$fila2['idBeneficiario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Ingresar al detalle
                          </a>';
                        } else { 
                          $datos2.='CANCELADO';
                        }
                         


                      $datos2.= '</td></tr>';
          }
     $datos2.='</tbody></table>'; 

  echo $datos2;
  } else  {
      echo '<div class="alert alert-block alert-danger">
              <p>
              <strong>
              <i class="ace-icon fa fa-check"></i>
              Ups.!
              </strong>
              El numero de folio no arrojo resultados, recuerda que puedes buscar por nombre de Beneficiario
              </p>
              </div>';
 }


}

}
?>