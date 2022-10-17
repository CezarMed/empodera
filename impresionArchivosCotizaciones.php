<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
$idSolicitudMedicamentos=$_GET['idSolicitudMedicamentos'];
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Solicitud de Cotizaciones</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Solicitud de Cotizaciones</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Reporte de Solicitud de Cotizaciones</h3>
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
                          Nombre beneficiario
                      </th>
                      <th>
                          Nombre del proveedor
                      </th>
                      <th>
                          Archivos
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query = "SELECT s.idServicio, scm.idMedicamentoSolicitud, s.folioEmpodera, r.nombreComercial, sm.folioSolicitud, b.nombreBeneficiario, sc.idProveedor from solicitudcotizaciones sc 
                  INNER JOIN registros r on r.idRegistro=sc.idProveedor
                  INNER JOIN solicitudmedicamentos sm on sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                  INNER JOIN servicios s on s.idServicio=sm.idServicio
                  LEFT JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
                  inner join beneficiarios b on b.idBenefeciario=sm.idBeneficiario
                  where sc.idSolicitudMedicamentos=$idSolicitudMedicamentos GROUP BY sc.idCotizacion";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                  ?>
                  <tr>
                    <td>
                          <?php echo $registro['folioEmpodera'] ?>
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
                            <a class="btn btn-success btn-sm" href="generarSolicitudMedicamento?idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos; ?>&idProveedor=<?php echo $registro['idProveedor']; ?>" target="_new">
                              <i class="fas fa-download">
                              </i>
                              DESCARGAR WORD
                          </a>
                            <a class="btn btn-success btn-sm" href="generarSolicitudMedicamentoPDF?idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos; ?>&idProveedor=<?php echo $registro['idProveedor']; ?>" target="_blank">
                              <i class="fas fa-download">
                              </i>
                              DESCARGAR PDF
                          </a><?php if ($registro['idMedicamentoSolicitud']!='') {?>
                          <a class="btn btn-warning btn-sm" href="editarCotizacioncostos?idServicio=<?php echo $registro['idServicio'] ?>&idProveedor=<?php echo $registro['idProveedor']; ?>" target="_blank">
                              <i class="fas fa-edit">
                              </i>
                              EDITAR COTIZACION
                          </a>
                        <?php } ?>


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

  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="https://adminlte.io">EMPODERA SALUD</a>.</strong>
    Todos los derechos reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

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


<script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnView', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        // alert(uid);
        $.ajax({
            url: 'consultas/consultasActualizacionesSolicitudMedicamentos',
            type: "POST",
            data: {"consultasActualizaciones":uid},
            success: function (cmb) {
                     //alert(cmb);
                     $('#tablaResult').html(cmb);
                }
        });
      });  
    });
</script>

<div id="verActualizaciones" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="tablaResult">
      </div>
    </div>
  </div>
</div>


 

