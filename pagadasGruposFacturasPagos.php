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
            <h1>Grupos de facturas pagadas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Facturación</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>  
    
<section class="content">
      <div class="container-fluid">
        <div class="card card-default">
         <form action="" method="POST" autocomplete="off">
          <div class="card-header">
            <h3 class="card-title">Elije un mes para consultar</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Mes a consultar</label>
                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?php echo $hoy ?>" id="mes" name="mes"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>               
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Buscar facturas</button>
          </div> 
          </div> 
                   
        </div>
      </form>
        </div>
    </section>

<?php if ($_POST) { ?>
    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de grupos de facturas pagadas</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0" id="datosListado">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>Servicio</th>
                      <th>Beneficiario</th>
                      <th>Tipo de apoyo</th>
                      <th>Monto Autorizado</th>
                      <th>Nombre Emisor</th>
                      <th>RFC Emisor</th>
                      <th>Fecha Emisión</th>
                      <th>Folio Fiscal</th>
                      <th>Neto a Liquidar</th>
                      <th></th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $mes=$_POST['mes'];
                  $datames=preg_split("/\-/", $mes,0);
                  $MesConsulta=$datames[0].'-'.$datames[1];   
                  $query = "SELECT gf.idGrupoFactura, gf.idFactura, s.folioEmpodera, b.nombreBeneficiario, fxml.tipoPagoFactura, s.servicio, gf.estatus, u.usuario, s.monto, fxml.nombreEmisor, fxml.rfcEmisor, fxml.FechaFactura, fxml.Folio, fxml.UUID, fxml.moneda, fxml.Total, imp.TotalImpuestosTrasladados, isr.TotalImpuestosRetenidos, reg.idBanco, reg.cuentaBancaria, reg.cuentaClabe, reg.idRegistro, gf.grupo, gf.idGrupoConsecutivo from gruposfacturas gf 
                  inner join facturasdatosxml fxml on fxml.idFacturas=gf.idFactura
                  inner join serviciosfacturasproveedor sfp on sfp.idFactura=fxml.idFacturas
                  inner join servicios s on s.idServicio=sfp.idServicio
                  inner join beneficiarios b on b.idBenefeciario=s.idBeneficiario
                  inner join usuarios u on u.idUsuario=s.idUsuario
                  left join facturasdatosxmlimpuestostotales imp on imp.UUID=fxml.UUID
                  left join facturasdatosxmlretencionestotales isr on isr.UUID=fxml.UUID
                  left join registros reg on reg.rfcCedula=fxml.rfcEmisor
                  where gf.estatus in (9) and fxml.FechaFactura like '$MesConsulta%' ";
                  $res = mysqli_query($con,$query);
                      while ($registro = mysqli_fetch_array($res)) {
                        $verdatos=$registro[0]."|".
                                  $registro[1];
                        // sumo el copago
                  ?>  
                    
                      <tr>
                       <td><?php echo $registro['folioEmpodera'] ?></td>
                       <td><?php echo $registro['nombreBeneficiario'] ?></td>
                       <td><?php echo $registro['tipoPagoFactura'] ?>-<?php echo $registro['servicio'] ?></td>
                       <td>$<?php echo $registro['monto'] ?></td>
                       <td><?php echo $registro['nombreEmisor'] ?></td>
                       <td><?php echo $registro['rfcEmisor'] ?></td>
                       <td><?php echo $registro['FechaFactura'] ?></td>
                       <td><?php echo $registro['UUID'] ?></td>
                       <td>$<?php echo $registro['Total'] ?></td>
                       <td><a class="btn btn-info btn-sm" href="editarPagoFacturaCliente?idFactura=<?php echo $registro['idFactura'] ?>&idGruposFacturas=<?php echo $registro['idGrupoFactura'] ?>"><i class="fas fa-edit"></i>
                          </a></td>
                          <td>
                        <a class="btn btn-danger btn-sm" href="eliminarPagoFacturaCliente?idFactura=<?php echo $registro['idFactura'] ?>&idGruposFacturas=<?php echo $registro['idGrupoFactura'] ?>"><i class="fas fa-times"></i>
                          </a></td>
                  </tr>
                <?php } ?>
                  
              </tbody>
          </table>
        </div>
         
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <?php } ?>
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

<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#reservationdate2').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'YYYY-MM-DD hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'YYYY-MM-DDs'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>

<?php 
if ($_GET['do']=='1') { ?>
<script>
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
        title: ' El pago de la factura se actualizo correctamente'
      })
    });
    });
</script>
<?php } ?>


<?php 
if ($_GET['do']=='2') { ?>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'error',
        title: ' El pago de la factura no se pudo actualizar, favor de validar'
      })
    });
    });
</script>
<?php } ?>
