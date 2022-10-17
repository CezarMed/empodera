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
            <h1>VISTA DE SOLICITUD DE MEDICAMENTOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Vista de Solicitud de Medicamentos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de Solicitudes de Medicamentos</h3>
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
                      <th>
                          
                      </th>
                      <th>
                          Folio de Servicio
                      </th>
                      <th>
                          Nombre del beneficiario
                      </th>
                      <th>
                          Fecha de solicitud
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
                $estatus=$_GET['estatus'];
                $item=0; 
                  $query = "SELECT * from solicitudmedicamentos sm 
                            INNER JOIN servicios s on s.idServicio=sm.idServicio
                            INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario
                            INNER JOIN tipoestatus te on te.idEstatus=sm.estatus
                            where sm.estatus=$estatus";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idCotizacion=$registro['idCotizacion'];
                              $item=$item+1;
                  ?>
                  <tr>
                    <td>
                        
                              <?php echo $item ?>
                          
                      </td>
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
                          <?php echo $registro['fechaSolicitud'] ?>
                      </td>
                      <td>
                          <font color="red"><b><?php echo $registro['descripcionEstatus'] ?></b></font>
                      </td>
                      <td>
                            <a class="btn btn-info btn-sm" href="detalleDeServicio?idServicio=<?php echo $registro['idServicio'] ?>&idBeneficiario=<?php echo $registro['idBeneficiario'] ?>">
                              <i class="fas fa-info">
                              </i>
                              Ir al detalle
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


 

