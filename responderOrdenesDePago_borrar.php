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
            <h1>Ordenes de Pago</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Responder Ordenes de Pago</li>
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
                  La orden de pago se envio correctamente al Cliente</a>
                </div>
                </div>
  <?php } ?>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Envio de factura para servicio</h3>
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
                          Folio del servicio
                      </th>
                      <th>
                          Nombre del beneficiario
                      </th>
                      <th>
                          Nombre del proveedor
                      </th>
                      <th>
                          Observaciones
                      </th>
                      <th>
                          Acciones
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                <?php 
                     $query = "SELECT sc.proveedorname, s.idBeneficiario, s.idServicio, s.folioEmpodera, s.observaciones, b.nombreBeneficiario, r.nombreComercial 
                     from servicios s 
                     INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario
                     INNER JOIN servicioscerradosproveedor sc on sc.idServicio=s.idServicio
                     INNER JOIN registros r on r.idRegistro=sc.proveedorname
                     where s.estatus=9";
                     $res = mysqli_query($con,$query);
                     while ($registro = mysqli_fetch_array($res)) {
                     $idServicio=$registro['idServicio'];
                     $idBeneficiario=$registro['idBeneficiario'];
                     $proveedorname=$registro['proveedorname'];
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
                          <?php echo $registro['observaciones'] ?>
                      </td>
                      
                      <td>
                          
                            <a class="btn btn-success btn-sm" href="responderOrdenPago?idServicio=<?php echo $idServicio; ?>&idBeneficiario=<?php echo $idBeneficiario; ?>&idProveedor=<?php echo $proveedorname; ?>">
                              <i class="fas fa-info">
                              </i>
                              Adjuntar factura para pago (completo)
                          </a>
                              <a class="btn btn-info btn-sm" href="responderOrdenPagoParcial?idServicio=<?php echo $idServicio; ?>&idBeneficiario=<?php echo $idBeneficiario; ?>&idProveedor=<?php echo $proveedorname; ?>">
                              <i class="fas fa-info">
                              </i>
                              Adjuntar factura para pago (parcial)
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


 

