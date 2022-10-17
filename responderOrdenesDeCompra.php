<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ordenes de Compra</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Responder Ordenes de Compra</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ordenes de Compra</h3>
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
                          Fecha de elección
                      </th>
                      <th>
                          Acciones
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                <?php
                    $idProveedor=$_SESSION['idEmpresa'];
                    if ($_SESSION['tipousuario']=='Administrador') {
                    $query = "SELECT * FROM solicitudcotizacionesmedicamentos scm
                    inner join solicitudcotizaciones sc on sc.idCotizacion=scm.idCotizacion
                    inner join registros r on r.idRegistro=sc.idProveedor
                    inner join solicitudmedicamentos sm on sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                    inner join servicios s on s.idServicio=sm.idServicio
                    inner join beneficiarios b on b.idBenefeciario=s.idBeneficiario
                    where scm.estatus=3 and s.estatus=8 and scm.elegido=1
                    GROUP BY sc.idCotizacion";
                    }

                    if ($_SESSION['tipousuario']=='ProveedorMedicamentos') {
                    $query = "SELECT * FROM solicitudcotizacionesmedicamentos scm
                    inner join solicitudcotizaciones sc on sc.idCotizacion=scm.idCotizacion
                    inner join registros r on r.idRegistro=sc.idProveedor
                    inner join solicitudmedicamentos sm on sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                    inner join servicios s on s.idServicio=sm.idServicio
                    inner join beneficiarios b on b.idBenefeciario=s.idBeneficiario
                    where scm.estatus=3 and s.estatus=8 and scm.elegido=1 and sc.idProveedor=$idProveedor
                    GROUP BY sc.idCotizacion";
                    }

                    $res = mysqli_query($con,$query);
                    while ($registro = mysqli_fetch_array($res)) {
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
                          <?php echo $registro['fechaAlta'] ?>
                      </td>
                      
                      <td>
                          
                            <a class="btn btn-info btn-sm" href="responderOrdenCompra?idCotizacion=<?php echo $registro['idCotizacion'] ?>&idProveedor=<?php echo $registro['idRegistro'] ?>&idBeneficiario=<?php echo $registro['idBeneficiario'] ?>&idOrden=<?php echo $registro['idOrden'] ?>">
                              <i class="fas fa-info">
                              </i>
                              Responder Orden de Compra
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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>
<?php 
if ($_GET['do']=='1') { ?>
echo '<script>
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
        title: ' El acuse en envio correctamente, en este momento ya se puede visualizar en el Detalle del servicio'
      })
    });
    });
</script>
<?php } ?>

<?php 
if ($_GET['do']=='2') { ?>
echo '<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 4000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'error',
        title: ' El acuse no pudo cargarse verifica que no tenga un peso mayor a 10MB y que no sea formato RAR'
      })
    });
    });
</script>
<?php } ?>
