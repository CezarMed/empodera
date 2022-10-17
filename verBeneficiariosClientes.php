<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>
<?php
if ($_GET['iduser3']!=''&&$_GET['borrar']=='si') {
    $idRegister=$_GET['iduser3'];
    $idUsuaio=$_SESSION['idUsuario'];
    $query = "UPDATE minutas SET estatus=5 WHERE idMinuta=$idRegister";
    mysqli_query($con,$query);
    $queryUpdate="INSERT INTO movimientosminutas (idMinuta,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idRegister,$idUsuaio,'BORRAR','" . date('Y-m-d H:i:s') ."')";
         $actualizar=mysqli_query($con,$queryUpdate); ?>
         <script type="text/javascript">
              window.location="reporteMinutas?do=5";
        </script>
<?php } ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reporte de Beneficiarios del cliente</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Beneficiarios del Cliente</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Listado de Beneficiarios por cliente</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                      <th>Folio beneficiario</th>
                      <th>Nombre completo</th>
                      <th>Cuenta</th>
                      <th>Subgrupo</th>
                      <th>Monto</th>
                      <th>Servicios</th>
                      <th>Fecha alta</th>
                    </tr>
              </thead>
              <tbody>
                <?php 
                  $idCliente=$_GET['idCliente'];
                  $query="SELECT b.folioBeneficiario,b.nombreBeneficiario,mc.nombreAcuerdo,mc.subgrupo,mc.montoautorizadocliente,b.fechaAlta,mc.idMontoCliente,b.idBenefeciario from montosclientes mc 
                  inner join beneficiarioscuentas bc on bc.idPrograma=mc.idMontoCliente
                  inner join beneficiarios b on b.idBenefeciario=bc.idBeneficiario
                  where mc.idCliente=$idCliente and bc.estatusCuenta=1";
                  $res = mysqli_query($con,$query);
                  while ($registro = mysqli_fetch_array($res)) {
                    $idBeneficiario=$registro['idBenefeciario'];
                    $idCuenta=$registro['idMontoCliente'];
                  // cuento los servicios
                      $sqlServicios="SELECT count(*) as totalServicios  FROM servicios where idBeneficiario=$idBeneficiario and idCuenta=$idCuenta";
                      $resServicios=mysqli_query($con,$sqlServicios);
                      while ($registroServicios = mysqli_fetch_array($resServicios)) {
                  ?>
                  <tr>
                      <td><?php echo $registro['folioBeneficiario'] ?></td>                      
                      <td><?php echo $registro['nombreBeneficiario'] ?></td>
                      <td><?php echo $registro['nombreAcuerdo'] ?></td>
                      <td><?php echo $registro['subgrupo'] ?></td>
                      <td>$<?php echo number_format($registro['montoautorizadocliente'], 2, '.', ',') ?></td>
                      <td><?php echo $registroServicios['totalServicios'] ?></td>
                      <td><?php echo $registro['fechaAlta'] ?></td>
                  </tr>
                <?php } } ?>
                  
              </tbody>
          </table>
</div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
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
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="dist/js/pages/dashboard.js"></script>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>

<script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnView', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        // alert(uid);
        $.ajax({
            url: 'consultas/consultasActualizacionesMinutas',
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



<div id="borrarMinuta" class="modal fade" role="dialog">
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
        Eliminar Minuta <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
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


 

