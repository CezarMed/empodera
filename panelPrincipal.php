<?php 
require_once ("header.php");
require_once ("menu.php");
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Panel principal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Panel Principal</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <?php if ($_SESSION['tipousuario']=='Administrador'||$_SESSION['tipousuario']=='Medico'||$_SESSION['tipousuario']=='GestorRed'||$_SESSION['tipousuario']=='AdaptacionUno'||$_SESSION['tipousuario']=='ConciliacionPagos'||$_SESSION['tipousuario']=='GestorMedicamentos'||$_SESSION['tipousuario']=='CoordinadorMed'||$_SESSION['tipousuario']=='CoordinadorRed'||$_SESSION['tipousuario']=='CoordinadorMedicamentos'||$_SESSION['tipousuario']=='Transicion'){ ?>
          <?php require_once "paneles.php" ?>
          <?php require_once "listadoservicios.php" ?>
        <?php } ?>

          <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Listado de servicios totales</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <!-- /.col -->
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Número de Servicios</strong>
                    </p>

                    <div class="progress-group">
                      MEDICAMENTOS
                      <?php
                      // total Servicios
                      $queryServicios="SELECT count(*) totalServicios from servicios";
                      $resServicios=mysqli_query($con,$queryServicios);
                      $regServicios=mysqli_fetch_array($resServicios);
                      $totalServicios=$regServicios['totalServicios']; 
                      // total medicamentos
                      $queryMedicamentos="SELECT count(*) totalMedicamentos from servicios where servicio='MEDICAMENTOS'";
                      $resMedicamentos=mysqli_query($con,$queryMedicamentos);
                      $regMedicamentos=mysqli_fetch_array($resMedicamentos);
                      $totalMedicamentos=$regMedicamentos['totalMedicamentos'];
                      $porMedicamentos=round($totalMedicamentos*100/$totalServicios);
                      ?>
                      <span class="float-right"><b><?php echo $totalMedicamentos ?></b>/<?php echo $totalServicios ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: <?php echo $porMedicamentos ?>%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                     CONSULTA MEDICA
                     <?php // total consulta medica
                      $queryConsulta="SELECT count(*) totalConsulta from servicios where servicio='CONSULTA MEDICA'";
                      $resConsulta=mysqli_query($con,$queryConsulta);
                      $regConsulta=mysqli_fetch_array($resConsulta);
                      $totalConsulta=$regConsulta['totalConsulta'];
                      $porConsulta=round($totalConsulta*100/$totalServicios); ?>
                      <span class="float-right"><b><?php echo $totalConsulta ?></b>/<?php echo $totalServicios ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: <?php echo $porConsulta ?>%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">SERVICIOS AUXILILARES</span>
                      <?php // total consulta medica
                      $queryAuxiliares="SELECT count(*) totalAuxiliares from servicios where servicio='SERVICIOS AUXILIARES'";
                      $resAuxiliares=mysqli_query($con,$queryAuxiliares);
                      $regAuxiliares=mysqli_fetch_array($resAuxiliares);
                      $totalAuxiliares=$regAuxiliares['totalAuxiliares'];
                      $porAuxiliares=round($totalAuxiliares*100/$totalServicios); ?>
                      <span class="float-right"><b><?php echo $totalAuxiliares ?></b>/<?php echo $totalServicios ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: <?php echo $porAuxiliares ?>%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      HOSPITALIZACION
                      <?php // total hospitalizacion
                      $queryHospital="SELECT count(*) totalHospital from servicios where servicio='HOSPITALIZACION'";
                      $resHospital=mysqli_query($con,$queryHospital);
                      $regHospital=mysqli_fetch_array($resHospital);
                      $totalHospital=$regHospital['totalHospital'];
                      $porHospital=round($totalHospital*100/$totalServicios); ?>
                      <span class="float-right"><b><?php echo $totalHospital ?></b>/<?php echo $totalServicios ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: <?php echo $porHospital ?>%"></div>
                      </div>
                    </div>

                    <div class="progress-group">
                      PROGRAMACION DE CIRUGIA
                      <?php // total programacion de cirugias
                      $queryCirugia="SELECT count(*) totalCirugia from servicios where servicio='PROGRAMACION DE CIRUGIA'";
                      $resCirugia=mysqli_query($con,$queryCirugia);
                      $regCirugia=mysqli_fetch_array($resCirugia);
                      $totalCirugia=$regCirugia['totalCirugia'];
                      $porCirugia=round($totalCirugia*100/$totalServicios); ?>
                      <span class="float-right"><b><?php echo $totalCirugia ?></b>/<?php echo $totalServicios ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-info" style="width: <?php echo $porCirugia ?>%"></div>
                      </div>
                    </div>

                    <div class="progress-group">
                      SOLICITUD DE APOYO
                      <?php
                      // total medicamentos
                      $queryApoyos="SELECT count(*) totalApoyos from servicios where servicio='SOLICITUD DE APOYO'";
                      $resApoyos=mysqli_query($con,$queryApoyos);
                      $regApoyos=mysqli_fetch_array($resApoyos);
                      $totalApoyos=$regApoyos['totalApoyos'];
                      $porApoyos=round($totalApoyos*100/$totalServicios);
                      ?>
                      <span class="float-right"><b><?php echo $totalApoyos ?></b>/<?php echo $totalServicios ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: <?php echo $porApoyos ?>%"></div>
                      </div>
                    </div>

                    <div class="progress-group">
                      REVISIÓN MEDICA BÁSICA
                      <?php
                      // total medicamentos
                      $queryRevision="SELECT count(*) totalRevision from servicios where servicio='REVISION MEDICA BASICA'";
                      $resRevision=mysqli_query($con,$queryRevision);
                      $regRevision=mysqli_fetch_array($resRevision);
                      $totalRevision=$regRevision['totalRevision'];
                      $porRevision=round($totalRevision*100/$totalServicios);
                      ?>
                      <span class="float-right"><b><?php echo $totalRevision?></b>/<?php echo $totalServicios ?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: <?php echo $porRevision ?>%"></div>
                      </div>
                    </div>
                    
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <?php if ($_SESSION['tipousuario']=='Administrador'||$_SESSION['tipousuario']=='Medico'||$_SESSION['tipousuario']=='GestorRed'||$_SESSION['tipousuario']=='AdaptacionUno'||$_SESSION['tipousuario']=='ConciliacionPagos'||$_SESSION['tipousuario']=='GestorMedicamentos'||$_SESSION['tipousuario']=='CoordinadorMed'||$_SESSION['tipousuario']=='CoordinadorRed'||$_SESSION['tipousuario']=='CoordinadorMedicamentos'||$_SESSION['tipousuario']=='Transicion'){ ?>
          <?php require_once "paneles.php" ?>
          <?php require_once "listadoservicios.php" ?>
        <?php } ?>

          <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Listado de medicamentos a solicitar</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <!-- /.col -->
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Listado de benefeciarios pendientes para solicitar medicamentos</strong>
                    </p>

                    <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Nombre Beneficiario</th>
                      <th>Total de medicamentos</th>
                      <th>Estado</th>
                       <th>Programa</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php 
                  $hoy=date('Y-m-d');
                  // $hoy2=date("Y-m-d",strtotime($hoy."- 90 days"));
                  $sietedias=date("Y-m-d",strtotime($hoy."+ 7 days"));
                  $query = "SELECT b.nombreBeneficiario, count(*) totalmedicamentos, est.nombreEstado, b.tipoPrograma FROM medicamentossolicitados ms
                  inner join solicitudmedicamentos sm on sm.idSolicitudMedicamentos=ms.idSolicitudMedicamento
                  inner join beneficiarios b on b.idBenefeciario=sm.idBeneficiario
                  inner join estados est on est.idEstado=b.entidadFederativa 
                  where ms.fechaTermina BETWEEN '$hoy' and '$sietedias' GROUP BY b.nombreBeneficiario";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                  ?>
                      <tr>
                        <td><?php echo $registro['nombreBeneficiario'] ?></td>
                        <td><?php echo $registro['totalmedicamentos'] ?></td>
                        <td><?php echo $registro['nombreEstado'] ?></td>
                        <td><?php echo $registro['tipoPrograma'] ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>

                  <br>
                      <a class="btn btn-btn bg-warning" href="verMedicamentosPendientesParaSolicitar?hoy=<?php echo $hoy ?>&diasdespues=<?php echo $sietedias ?>">
                  <i class="fas fa-search"></i> Ver listado de medicamentos para solicitar
                </a>
                   
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
