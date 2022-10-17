<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
$uuid=$_POST['uuid'];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Busqueda de Facturación</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Modulo de facturación</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Listado de facturas del proveedor</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          Monto de factura
                      </th>
                      <th>
                          UUID
                      </th>
                      <th>
                          Comentarios del proveedor
                      </th>
                      <th>
                          Estatus
                      </th>
                      <th>
                          Acciones
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                <?php 
                   $queryFac="SELECT * FROM facturasdatosxml fxml
INNER joiN registros r On r.idRegistro=fxml.idProveedor 
INNER joiN tipoestatus te On te.idEstatus=fxml.estatus
                   where fxml.UUID='$uuid'";
                            $res = mysqli_query($con,$queryFac);
                              while ($registro = mysqli_fetch_array($res)) {
                                $totalfacturado=$totalfacturado+$registro['montoAplicado'];
                  ?>
                  <tr>
                      <td>
                          <a>
                              $<?php echo $registro['Total'] ?>
                          </a>
                      </td>
                      <td>
                          <a>
                              <?php echo $registro['UUID'] ?>
                          </a>
                      </td>
                      <td>
                          <?php echo $registro['comentarios'] ?>
                      </td>
                      <td>
                          <?php echo $registro['descripcionEstatus'] ?>
                      </td>
                      <td><a class="btn btn-info btn-sm" href="detalleFacturaProveedorDatos?idFactura=<?php echo $registro['idFacturas']; ?>">
                              <i class="fas fa-info">
                              </i>
                              Ver detalles
                          </a> 
                          <a class="btn btn-warning btn-sm" href="serviciosAplicadosFactura?idFactura=<?php echo $registro['idFacturas']; ?>">
                              <i class="fas fa-search">
                              </i>
                              Ver servicios
                          </a>
                      </td>
                  </tr>

                <?php } ?>                  
              </tbody>
          </table>
        </div>         
        </div>
        </div>
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

<script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnView', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var idFactura = $(this).data('id'); 
        // alert(idFactura);
        $.ajax({
            url: 'consultas/consultasFacturasServicios',
            type: "POST",
            data: {"idFactura":idFactura},
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
      <div class="modal-header"><b>EMPODERA SALUD - DETALLE FACTURACIÓN -</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="tablaResult">
      </div>
    </div>
  </div>
</div>






 

