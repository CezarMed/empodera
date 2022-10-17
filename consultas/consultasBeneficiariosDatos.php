<?php 
error_reporting(0);
include('../class/conexion.php'); 
if (array_key_exists('consultasSocios', $_POST)) {
	$conn=conexion();
	$nombreBeneficiario=$_POST['consultasSocios'];
	$sql="SELECT idBenefeciario, codigoBenefeciario, nombreBeneficiario, fechaNacimiento from beneficiarios where nombreBeneficiario like '%$nombreBeneficiario%'";
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
          
      $datos.= '<tr><td>'.$fila['codigoBenefeciario'].'</td><td>'.$fila['nombreBeneficiario'].'</td><td>
                          <a class="btn btn-info btn-sm" href="solicitudMedicamentos?id='.$fila['idBenefeciario'].'">
                              <i class="fas fa-edit">
                              </i>
                              Solicitar medicamentos
                          </a>
                         


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
El beneficiario no se encuentra registrado, registralo desde el panel Alta de Beneficiario
</p>
</div>';
 }

}
?>