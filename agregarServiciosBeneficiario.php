<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaServicio.php');
//creamo el objeto de la orde de venta class
$NuUs = new Altaservicio_class();
if ($_POST) {
$NuUs->altaServicio();
}
$hoy=date('Y-m-d');
$idBeneficiario=$_GET['idBeneficiario'];
$idCuenta=$_GET['idCuenta'];
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Resumen de la cuenta del beneficiario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Cuenta general del beneficiario</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php if ($_GET['do']==5) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-times"></i> En hora buena!</h5>
            La información NO se cargo correctamente, contacte a un administrador.
        </div>
      </div>
    <?php } ?>


  
        <section class="content">
       <div class="callout callout-danger">
       <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Datos de la cuenta</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <?php 
                  $query="SELECT mc.montoautorizadocliente, mc.nombreacuerdo, b.nombreBeneficiario, b.folioBeneficiario, cli.nombreCliente, mc.subgrupo, bc.contribucion, bc.copago from beneficiarios b 
                  INNER JOIN beneficiarioscuentas bc on bc.idBeneficiario=b.idBenefeciario
                  INNER JOIN montosclientes mc on mc.idmontoCliente=bc.idPrograma
                  INNER JOIN clientes cli on cli.idCliente=mc.idCliente
                  where b.idBenefeciario=$idBeneficiario and bc.idCuenta=$idCuenta";
                  $res=mysqli_query($con,$query);
                  $extraido=mysqli_fetch_array($res);
                  ?>
                  <dt class="col-sm-4">Nombre y folio del Beneficiario</dt>
                  <dd class="col-sm-8"><?php echo $extraido['nombreBeneficiario']; ?> / <?php echo $extraido['folioBeneficiario']; ?></dd>
                  <dt class="col-sm-4">Cliente al que pertenece</dt>
                  <dd class="col-sm-8"><?php echo $extraido['nombreCliente']; ?></dd>
                  <dt class="col-sm-4">Cuenta</dt>
                  <dd class="col-sm-8"><b><font color="blue"><?php echo $extraido['nombreacuerdo'] ?></font></b></dd>
                  <dt class="col-sm-4">Monto de la cuenta</dt>
                  <dd class="col-sm-8"><b><font color="red">$<?php echo number_format($extraido['montoautorizadocliente'], 2, '.', ',') ?></font></b></dd>
                  <dt class="col-sm-4">Subgrupo asignado</dt>
                  <dd class="col-sm-8"><?php echo $extraido['subgrupo'] ?></dd>
                  <dt class="col-sm-4">Contribución Inicial</dt>
                  <dd class="col-sm-8">$<?php echo $extraido['contribucion'] ?></dd>
                  <dt class="col-sm-4">Copago</dt>
                  <dd class="col-sm-8"><?php echo $extraido['copago'] ?>%</dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Contabilidad de la cuenta</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Gasto Total</dt>
                  <dd class="col-sm-8">$<?php 
                  // obtengo la suma de los montos de los servicios  
                  $queryServicios="SELECT sum(monto) as montoservicios from servicios s
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalservicios=$extraidoServicios['montoservicios'];

                  //obtengo al suma de las notas medicas
                  $queryServicios="SELECT sum(costonota) as totalmedicas from notasmedicas nm               
                  INNER JOIN servicios s on s.idServicio=nm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalmedicas=$extraidoServicios['totalmedicas'];

                  // obtengo el total de notas pre operatorias
                  $queryServicios="SELECT sum(cirujano+anestesiologo+ayudante+enfermeria+ayudante2) as totalpreoperatorias from notaspreoperatorias nm               
                  INNER JOIN servicios s on s.idServicio=nm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalpreoperatorias=$extraidoServicios['totalpreoperatorias'];

                  //obtengo la suma de los gastos medicos                  
                  $queryServicios="SELECT sum(gm.monto) as totalhonorarios from gastosmedicos gm               
                  INNER JOIN servicios s on s.idServicio=gm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalhonorarios=$extraidoServicios['totalhonorarios'];
                  
                  //obtengo el total de copago a los servicios
                  $queryServicios="SELECT sum(ca.montoAsignado) as totalCopagoAplicable 
                  from copagosasignados ca               
                  INNER JOIN servicios s on s.idServicio=ca.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalCopagoAplicable=$extraidoServicios['totalCopagoAplicable'];
                  ;
                  //obtengo el total de contribucion a los servicios para restar al monto autorizado
                  $queryServicios="SELECT sum(ca.montoAsignado) as totalComisionAplicable 
                  from contribucionesasignadas ca               
                  INNER JOIN servicios s on s.idServicio=ca.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and ca.tipocopago='Pagado' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalComisionAplicable=$extraidoServicios['totalComisionAplicable'];

                  //obtengo el copago depositado
                  $queryCIP="SELECT sum(montoAprobado) montoDepositado from archivoscopagos where tipocopago='Depositado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoDepositado=$exrtraerTotal['montoDepositado'];

                  //obtengo el monto copago acreditado
                  $queryCIP="SELECT sum(montoAprobado) montoAcreditado from archivoscopagos where tipocopago='Acreditado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoAcreditado=$exrtraerTotal['montoAcreditado'];

                   //obtengo el monto copago pagado
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscopagos where tipocopago='Pagado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoPagado=$exrtraerTotal['montoPagado'];

                  //total del copago (solo sumo depositado y acreditado)
                  $totalCopago=($montoDepositado+$montoAcreditado+$montoPagado);

                  // obtengo la contribucion acreditada
                  $queryCIP="SELECT sum(montoAprobado) montoAcreditado from archivoscontribucion where tipocopago='Acreditado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoAcreditadoCI=$exrtraerTotal['montoAcreditado'];

                  // obtengo la contribucion pagada
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscontribucion where tipocopago='Pagado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoPagadoCI=$exrtraerTotal['montoPagado'];

                  // obtengo la contribucion depositada
                  $queryCIP="SELECT sum(montoAprobado) montoDepositada from archivoscontribucion where tipocopago='Depositado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoDepositadaCI=$exrtraerTotal['montoDepositada'];

                  $totalContribucion=$montoAcreditadoCI+$montoPagadoCI+$montoDepositadaCI;

                  // imprimo el gasto toal
                  echo number_format($total=$totalservicios+$totalmedicas+$totalpreoperatorias+$totalhonorarios, 2, '.', ',');
                  ?></dd>

                  <dt class="col-sm-4">Monto autorizado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($total-$totalCopagoAplicable-$totalComisionAplicable, 2, '.', ',')  ?></dd>

                  <dt class="col-sm-4">Monto Remante</dt>
                  <dd class="col-sm-8">$<?php echo number_format($extraido['montoautorizadocliente']-$total, 2, '.', ',') ?></dd>                  

                  <dt class="col-sm-4">Copago aplicable</dt>
                  <dd class="col-sm-8">$<?php echo number_format(($total*$extraido['copago']), 2, '.', ',') ?></dd>

                  <dt class="col-sm-4">Copago acumulado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($totalCopago, 2, '.', ',') ?></dd>

                  <dt class="col-sm-4">Diferencia de Copago</dt>
                  <dd class="col-sm-8">$<?php echo number_format(($totalCopago-($total*$extraido['copago'])), 2, '.', ',') ?></dd> 
                  <dt class="col-sm-4">Diferencia de Contribución</dt>
                  <dd class="col-sm-8">$<?php echo number_format($extraido['contribucion']-$totalContribucion, 2, '.', ',') ?></dd>                  
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
        </div>                 
       </div>


    </section>

    <section class="content">
       <div class="callout callout-danger">
       <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Copago</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Pagado</dt>
                  <dd class="col-sm-8">$<?php 
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscopagos where tipocopago='Pagado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  echo number_format($totalPagado=$exrtraerTotal['montoPagado'], 2, '.', ',');
                ?></dd>
                  <dt class="col-sm-4">Depositado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($montoDepositado, 2, '.', ','); ?></dd>
                  <dt class="col-sm-4">Acreditado</dt>
                  <dd class="col-sm-8">$<?php   echo number_format($montoAcreditado, 2, '.', ',');?></dd>
                <dt class="col-sm-4">TOTAL COPAGO</dt>
                  <dd class="col-sm-8"><b>$<?php
                  echo number_format($totalCopago, 2, '.', ',');
                ?>
              </b></dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Contribución Inicial</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Pagada</dt>
                  <dd class="col-sm-8">$<?php 
                  echo number_format($montoPagadoCI, 2, '.', ',');
                  ?></dd>
                  <dt class="col-sm-4">Depositada</dt>
                  <dd class="col-sm-8">$<?php
                  echo number_format($montoDepositadaCI, 2, '.', ',');
                  ?></dd>
                  <dt class="col-sm-4">Acreditada</dt>
                  <dd class="col-sm-8">$<?php 
                  echo number_format($montoAcreditadoCI, 2, '.', ',');
                  ?></dd>
                 <dt class="col-sm-4">TOTAL Contribución</dt>
                  <dd class="col-sm-8">$<?php
                  echo number_format(($montoTotalCI+$montoDepositadaCI+$montoAcreditadoCI+$montoPagadoCI), 2, '.', ',');
                ?></dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->


        </div>                 
       </div>
    </section>

    <?php if($tipousuario=='Administrador'||$tipousuario=='Medico'){ ?>
    <section class="content">
      <form action="" method="POST" autocomplete="off">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Utilidades de la cuenta del beneficiario</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                 <a class="btn btn-app bg-info"  href="agregarCopagosCuentaBeneficiario?idBeneficiario=<?php echo $idBeneficiario ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-credit-card"></i> Agregar Copago
                </a>
                <a class="btn btn-app bg-warning"  href="agregarArchivosCuenta?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Agregar Documentos
                </a>
                <a class="btn btn-app bg-info"  href="agregarContribucionBeneficiario?idBeneficiario=<?php echo $idBeneficiario ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-credit-card"></i> Agregar Contribución
                </a> 
                <a class="btn btn-app bg-warning"  href="cuentasBeneficiario?idBeneficiario=<?php echo $idBeneficiario ?>">
                  <i class="fas fa-search"></i> Ver cuentas
                </a>                 
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>
  <?php } ?>

    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Servicios asignados al beneficiario</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>Tipo de servicio</th>
                      <th>Folio</th>
                      <th>Fecha de Solicitud</th>
                      <th>Observaciones</th>
                      <th>Monto Autorizado</th>
                      <th>Estatus</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query = "SELECT s.*, te.descripcionEstatus from servicios s
                  INNER JOIN tipoestatus te on te.idEstatus=s.estatus 
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta ORDER BY s.idServicio ASC";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idServicio=$registro['idServicio'];
                              $estatus=$registro['estatus'];
                              $descripcionEstatus=$registro['descripcionEstatus'];
                // cuento las notas medicass
                $queryS = "SELECT count(*) totalnotas from notasmedicas
                where idServicio=$idServicio";
                              $resN = mysqli_query($con,$queryS);
                              $extraidoN= mysqli_fetch_array($resN);
                              $totalnotas=$extraidoN['totalnotas'];
                // cuento las notas pre operatorias
                $queryS2 = "SELECT count(*) totalnotas2 from notaspreoperatorias
                              where idServicio=$idServicio";
                              $resN2 = mysqli_query($con,$queryS2);
                              $extraidoN2= mysqli_fetch_array($resN2);
                              $totalnotas2=$extraidoN2['totalnotas2'];
                              $notasno= $totalnotas+$totalnotas2;

                ?>
                    <tr>
                    <td><?php echo $registro['servicio']; ?></td>
                    <td><?php echo $registro['folioEmpodera']; ?></td>
                    <td><?php echo $registro['fechaAlta']; ?></td>
                    <td><?php echo strtoupper($registro['observaciones']) ?></td>
                    <td><b>$<?php echo number_format($registro['monto'], 2, '.', ','); ?></b></td>
                    <td><?php echo $descripcionEstatus ?></td>
                    <td>
                          <?php if ($estatus!=5) {  ?>
                          <a class="btn btn-success btn-sm" href="detalleDeServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">                              
                              Ingresar al detalle
                          </a>
                        <?php } else { ?>
                          <?php echo $registro['motivocancela']; ?>
                          <a class="btn btn-danger btn-sm" href="detalleDeServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">                              
                              Ingresar al detalle
                          </a> 
                        <?php } ?>
                    </td>
                    </tr>
                <?php } ?>
              </tbody>
          </table>
        </div>
      </div>
    </section>
    <?php 

    $query2 = "SELECT * from periodosbeneficiarios where '$hoy' between fechaInicial and fechaFin and idBeneficiario=$idBeneficiario";
            $res2 = mysqli_query($con,$query2);
            $filas = mysqli_num_rows($res2);
            if ($filas>=1) {
            ?>
    <?php if ($tipousuario=='Administrador'||$tipousuario=='Medico'||$tipousuario=='CoordinadorMed') { ?>
    <section class="content">
      <form action="" method="POST" autocomplete="off">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Asignar servicio al beneficiario</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Cuenta que aplica</label>
                    <?php
                    $idCuenta=$_GET['idCuenta'];
                    $query = "SELECT * from beneficiarioscuentas bc 
                    inner join montosclientes mc on mc.idMontoCliente=bc.idPrograma
                    where bc.idCuenta=$idCuenta";
                    $res = mysqli_query($con,$query);
                    ?>
                    <select class="custom-select form-control-border" id="idCuentas" name="idCuentas" required>
                    <?php
                    while ($registro = mysqli_fetch_array($res)) { ?>
                    <option value="<?php echo $registro['idMontoCliente']  ?>"><?php echo $registro['nombreAcuerdo'] ?> / <?php echo $registro['subgrupo'] ?></option>
                    <?php }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre del servicio</label>
                    <select class="custom-select form-control-border" id="servicio" name="servicio" required>
                    <option value="">Selecciona un servicio</option>
                    <option value="MEDICAMENTOS">MEDICAMENTOS</option>
                    <option value="CONSULTA MEDICA">CONSULTA MEDICA</option>
                    <option value="SERVICIOS AUXILIARES">SERVICIOS AUXILIARES</option>
                    <option value="HOSPITALIZACION">HOSPITALIZACION</option>
                    <option value="PROGRAMACION DE CIRUGIA">PROGRAMACION DE CIRUGIA</option>
                    <option value="SOLICITUD DE APOYO">SOLICITUD DE APOYO</option>
                    <option value="REVISION MEDICA BASICA">REVISION MEDICA BASICA</option>
                  </select>
                  <input type="hidden" id="altaServicio" name="altaServicio" value="altaServicio">
                  <input type="hidden" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" id="idCuenta" name="idCuenta" value="<?php echo $idCuenta ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Observaciones</label>
                  <input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones del servicio">
                </div>  
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Generar servicio</button>
          </div>
        </div>
      </div>
      </form>
    </section>
  <?php } ?>
    <?php } else { ?>
<div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  
                  <h5><i class="icon fas fa-times"></i> UPS!</h5>
                  El beneficiario no tiene periodo activo en plataforma por lo cual no se le puede agregar un servicio, para activar ir a la edición del beneficiario.
                </div>
                </div>
<?php } ?>
    


    </div>

  <!-- /.content-wrapper -->

<?php 
require_once ("footer.php");
?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>

<div id="borrarSolicitud" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="GET" id="fl3" name="fl3">
            <input type="hidden" name="iduser3" name="iduser3" value="">
            <input type="hidden" value="si" name="borrar" name="borrar">
        <button type="submit" class="btn btn-sm btn-danger" >
        Eliminar Solicitud de Medicamento <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
      </button>
      </form>
        <script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnDelete', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        //alert(uid);
        document.fl3.iduser3.value = uid;
      });  
    });
</script>
      </div>
    </div>
  </div>
</div>

<?php 
if ($_GET['do']=='1') { ?>
echo '<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'success',
        title: ' El servicio se dio de alta con éxito, ya esta asignado al beneficiario y en el subgrupo correspondiente'
      })
    });
    });
</script>
<?php } ?>

<?php 
if ($_GET['do']=='6') { ?>
echo '<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'success',
        title: ' El servicio se cancelo correctamente, a partir de este momento ya no esta aplicado al beneficiario ni en su subgrupo'
      })
    });
    });
</script>
<?php } ?>








 

