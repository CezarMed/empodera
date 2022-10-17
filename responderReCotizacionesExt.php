<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cotizaciones de segundo ciclo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Cotizaciones de segundo ciclo</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
        <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La orden de compra se genero correctamente para el proveedor</a>
                </div>
                </div>
  <?php } ?>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Datos del servicio de cotizacion</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          Folio de Servicio
                      </th>
                      <th>
                          Nombre del beneficiario
                      </th>
                      <th>
                          Nombre del proveedor
                      </th>
                      <th>
                          Fecha de solicitud
                      </th>
                      <th>
                          Acciones
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query = 'SELECT s.folioEmpodera, sm.folioSolicitud, sc.idCotizacion, b.nombreBeneficiario, r.nombreComercial, sc.fechaSolicitud from solicitudcotizaciones sc 
                  INNER JOIN solicitudmedicamentos sm on sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                  INNER JOIN servicios s on s.idServicio=sm.idServicio
                  INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
                  INNER JOIN beneficiarios b ON b.idBenefeciario=sm.idBeneficiario
                  INNER JOIN registros r on r.idRegistro=sc.idProveedor where sc.estatus=15 and scm.estatus=1 GROUP BY scm.idCotizacion, sm.folioSolicitud ';
                        $res = mysqli_query($con,$query);
                          while ($registro = mysqli_fetch_array($res)) {
                            $idCotizacion=$registro['idCotizacion'];                            
                  ?>
                  <tr>
                    <td>
                          <a>
                              <?php echo $registro['folioEmpodera'] ?>
                          </a>
                      </td>
                      <td>
                          <a>
                              <?php echo $registro['nombreBeneficiario'] ?>
                          </a>
                      </td>
                      <td>
                          <?php echo $registro['nombreComercial'] ?>
                      </td>
                      <td>
                          <?php echo $registro['fechaSolicitud'] ?>
                      </td>                      
                      <td>
                            <a class="btn btn-info btn-sm" href="responderReCotizacionExt?idCotizacion=<?php echo $idCotizacion; ?>">
                              <i class="fas fa-check">
                              </i>
                              Responder Cotizacion de Segundo ciclo
                          </a>
                      </td>
                  </tr>

                <?php } ?>
                  
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

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
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</html>

<?php if ($_GET['do']==5){ ?>
<script type="text/javascript">
$(function() {
                  var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000
                  });

                  $(document).ready(function() {
                    Toast.fire({
                      icon: 'success',
                      title: ' La cotización se cancelo correctamente, ya no estara disponible'
                    })
                  });
                  });</script>
<?php } ?>