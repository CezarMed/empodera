<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>
<?php
if ($_GET['iduser3']!=''&&$_GET['borrar']=='si') {
    $idRegister=$_GET['iduser3'];
    $idUsuario=$_SESSION['idUsuario'];
    $query = "UPDATE solicitudmedicamentos SET estatus=5 WHERE idSolicitudMedicamentos=$idRegister";
    mysqli_query($con,$query);
    $queryUpdate="INSERT INTO movimientossolicitudmedicamentos (idSolicitudMedicamentos,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idRegister,$idUsuario,'BORRAR','" . date('Y-m-d H:i:s') ."')";
         $actualizar=mysqli_query($con,$queryUpdate); ?>
         <script type="text/javascript">
              window.location="reporteSolicitudMedicamentos?do=5";
        </script>
<?php } ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Solicitar cotizaciones a proveedores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Solicitud de Medicamentos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
        <?php if ($_GET['do']==5) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La solicitud se <b>BORRO</b> correctamente</a>
                </div>
                </div>
  <?php } ?>
    <?php
    if ($_GET['folio']) {
    $folio=$_GET['folio'];
    $criterio="where sm.folioSolicitud='$folio' and s.estatus!=5";
    } else {
    $criterio="where sm.estatus=1 and s.estatus!=5";
    }
    ?>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Servicios de medicamentos disponibles para solicitar cotización</h3>
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
                          Folio del Servicio
                      </th>
                      <th>
                          Nombre beneficiario
                      </th>
                      <th>
                          Observaciones
                      </th>
                      <th>
                          Fecha Solicitud
                      </th>
                      <th>
                          Receta(s)
                      </th>
                      <th>
                          Acciones
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query = 'SELECT s.observaciones, s.folioEmpodera, sm.*, b.nombreBeneficiario from solicitudmedicamentos sm 
                  INNER JOIN beneficiarios b ON b.idBenefeciario=sm.idBeneficiario
                  INNER JOIN servicios s ON s.idServicio=sm.idServicio 
                   '.$criterio;
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                            $idSolicitudMedicamentos=$registro['idSolicitudMedicamentos'];
                            $sqlFile="SELECT * from archivosrecetasmedicamentos ar
                                  where ar.idsolicitudMedicamento=$idSolicitudMedicamentos and ar.estatus=1";
                                  $resFile = mysqli_query($con,$sqlFile);

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
                          <a>
                              <?php echo $registro['observaciones'] ?>
                          </a>
                      </td>
                      <td>
                          <?php echo $registro['fechaSolicitud'] ?>
                      </td>
                      <td>
                        <?php while ($filaFile = mysqli_fetch_array($resFile)) { ?>
                        <a href="<?php echo $filaFile['archivo'] ?>" target="_new">
                          <img src="dist/img/iconfile.png"></a> 
                        <?php } ?>                    

                      </td>
                      
                      <td>
                        <?php 
                            // echo $idSolicitudMedicamentos 
                            $query2 = "SELECT count(*) as totalcot from solicitudcotizaciones where idSolicitudMedicamentos=$idSolicitudMedicamentos";
                            $res2 = mysqli_query($con,$query2);
                            $registro2 = mysqli_fetch_array($res2);
                            $totalc=$registro2['totalcot'];
                            if ($totalc==0){
                            ?>
                              <a class="btn btn-info btn-sm" href="solicitudMedicamentosCotizacion?id=<?php echo $idSolicitudMedicamentos; ?>">
                              <i class="fas fa-info">
                              </i>
                              Solicitar Cotización
                          </a>
                        <?php } else { ?>
                          <a class="btn btn-info btn-sm" href="impresionArchivosCotizaciones?idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos; ?>">
                              <i class="fas fa-check">
                              </i>
                            Re-imprimir cotizaciones
                          </a>
                        <?php } ?>
                        
                          <a class="btn btn-warning btn-sm" href="editarSolicitudMedicamentos?idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos; ?>">
                              <i class="fas fa-check">
                              </i>
                            Editar solicitud
                          </a>
                          <a class="btn btn-info btn-sm" href="verSolicitudMedicamentos?idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos; ?>">
                              <i class="fas fa-check">
                              </i>
                            Ver datos de solicitud
                          </a>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#borrarSolicitud" id="btnDelete" data-id="<?php echo $idSolicitudMedicamentos ?>"> <i class="fas fa-trash">
                              </i>
                            Cancelar solicitud</button>
                          
                            


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


