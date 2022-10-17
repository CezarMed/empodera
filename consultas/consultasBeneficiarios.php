<?php 
error_reporting(0);
include('../class/conexion.php'); 
if ($_POST) {
  $conn=conexion();
  $nombreBeneficiario=$_POST['consultasSocios'];
  if ($nombreBeneficiario==''){$nombreBeneficiario='%';}

  $apeliidoPaternoBeneficiario=$_POST['apeliidoPaternoBeneficiario'];
  if ($apeliidoPaternoBeneficiario==''){$apeliidoPaternoBeneficiario='%';}

  $apeliidoMaternoBeneficiario=$_POST['apeliidoMaternoBeneficiario'];
  if ($apeliidoMaternoBeneficiario==''){$apeliidoMaternoBeneficiario='%';}

  $apellidos=$apeliidoPaternoBeneficiario." ".$apeliidoMaternoBeneficiario;

  $apellidos=trim($apellidos);
  $nombrecom=$apellidos." ".$nombreBeneficiario;

  $sql="SELECT idBenefeciario,codigoBenefeciario,folioBeneficiario,nombreBeneficiario,fechaNacimiento from beneficiarios where nombreBeneficiario LIKE '%$nombrecom%' ";
  $res = mysqli_query($conn,$sql);
  $filas = mysqli_num_rows($res);

  if ($filas>=1) {
  $datos='';
  $datos.= '<table class="table table-striped projects">
                   <thead>
                       <tr>
                            <th>Número de beneficiario</th>
                             <th>Nombre del beneficiario</th>
                             <th>Acciones</th>
                       </tr>
                                </thead><tbody>';
                                 while ($fila = mysqli_fetch_array($res)) {
                        $datos.= '<tr><td>'.$fila['folioBeneficiario'].'</td><td>'.$fila['nombreBeneficiario'].'</td><td>
                          <a class="btn btn-success btn-sm" href="agregarServiciosBeneficiario?idBeneficiario='.$fila['idBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Servicios del Beneficiario
                          </a>
                          <a class="btn btn-info btn-sm" href="editaBenefeciarios?id='.$fila['codigoBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Editar datos
                          </a>
                          <a class="btn btn-warning btn-sm" href="verBenefeciarios?id='.$fila['codigoBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Consultar
                          </a>
                      </td></tr>
              ';
          }

$datos.='<tr><td></td><td></td><td>
                          <button type="button" class="btn btn-success" onclick="nuevoBeneficiario()">Agregar nuevo beneficiario</button>
                      </td></tr>';
$datos.='</tbody></table>'; 

echo $datos;
  } else  {
      echo '<div class="alert alert-block alert-danger" id="avisoSinResultados">
              <p>
              <strong>
              <i class="ace-icon fa fa-check"></i>
              Ups.!
              </strong>
              No encontramos resultados para tus datos de busqueda, agrega tu beneficiario desde este botón 
              <button type="button" class="btn btn-success" onclick="nuevoBeneficiario()">Agregar nuevo beneficiario</button>
              </p>
              </div>';
 }
}

?>