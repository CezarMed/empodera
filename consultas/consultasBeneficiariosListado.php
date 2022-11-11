<?php 
error_reporting(0);
include('../class/conexion.php'); 
	$conn=conexion();
	$nombreBeneficiario=$_POST['nombreBene'];
	$sql="SELECT idBenefeciario, folioBeneficiario, nombreBeneficiario, fechaNacimiento, estatus from beneficiarios where nombreBeneficiario like '%$nombreBeneficiario%'";
	$res = mysqli_query($conn,$sql);
	$filas = mysqli_num_rows($res);

	if ($filas>0) {
		$datos='';
	$datos.= '<table class="table table-striped projects">
                                <thead>
                                        <tr>
                                                <th>Folio de registro</th>
                                                <th>Nombre del beneficiario</th>
                                                <th>Acciones</th>
                                        </tr>
                                </thead><tbody>';

                                 while ($fila = mysqli_fetch_array($res)) {
                                  $estatus=$fila['estatus'];
          
                      $datos.= '<tr><td>'.$fila['folioBeneficiario'].'</td><td>'.$fila['nombreBeneficiario'].'</td><td>
                      <a class="btn btn-dark btn-sm" href="solicitudMedicamentos?id='.$fila['idBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Solicitar medicamentos
                          </a>
                          ';
                          if ($estatus=='1'){
                            $datos.='
                            <a class="btn btn-info btn-sm" href="verCredencial?id='.$fila['idBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Ver credencial
                          </a>
                            <a class="btn btn-danger btn-sm" href="solicitudMedicamentos?id='.$fila['idBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Desactivar
                          </a>';
                          }
                          if ($estatus=='5'){
                            $datos.='
                            <a class="btn btn-success btn-sm" href="solicitudMedicamentos?id='.$fila['idBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Activar
                          </a>';
                          }
                         


                      $datos.='</td></tr>
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
El beneficiario no se encuentra registrado, registralo desde el panel Alta de Beneficiario
</p>
</div>';
 }


?>