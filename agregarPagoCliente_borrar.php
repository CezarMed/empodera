<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");

include('class/respondeOrdenPago2.php');
$NuUs = new respondeOrdenPago2_class();
if ($_POST) {
$NuUs->responderOrdenPago2();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ORDEN DE PAGO - COMPROBANTE DE PAGO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Orden de Pago - Comprobante de pago -</li>
            </ol>
          </div>
        </div>
      </div>
    </section>


    <!-- Main content -->
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <?php
            $idServicio=$_GET['idServicio'];
            $idFactura=$_GET['idFactura'];
            $query2 = "SELECT s.idServicio, s.folioEmpodera, s.observaciones, b.nombreBeneficiario, r.nombreComercial from servicios s 
                            INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario
                            INNER JOIN servicioscerradosproveedor sc on sc.idServicio=s.idServicio
                            INNER JOIN registros r on r.idRegistro=sc.proveedorname
                            where s.idServicio=$idServicio";
            $res2 = mysqli_query($con,$query2);
            $extraido2= mysqli_fetch_array($res2);
            $folioEmpodera=$extraido2['folioEmpodera'];
            $beneficiario=$extraido2['nombreBeneficiario'];
          ?>    
        </div>

        <div class="card card-default">
          <div class="card-body">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                 El servicio con folio <font color="red"><?php echo $folioEmpodera?></font>  del beneficiario <b><?php echo $beneficiario ?></b> será enviado para cierre de servicio y enviar comprobante de pago.</div>
              </div>
            </div>

          </div>  
        </div>
        
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Enviar comprobante de pago al proveedor</h3>
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
                    <label for="exampleInputFile">Archivo (comprobante de pago)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept="application/pdf">
                        <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                        <input type="hidden" id="folioServicio" name="folioServicio" value="<?php echo $folioEmpodera ?>">
                        <input type="hidden" id="responderOrdenPago2" name="responderOrdenPago2" value="responderOrdenPago2">
                        <input type="hidden" id="beneficiario" name="beneficiario" value="<?php echo $beneficiario ?>">
                        <input type="hidden" id="idFactura" name="idFactura" value="<?php echo $idFactura ?>">
                      </div>
                    </div>
                  </div>
              </div>
             
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referencia de pago</label>
                 <input type="text" class="form-control" id="referenciaPago" name="referenciaPago" placeholder="Referencia de Pago" required>
                </div>
              </div>

              </div>

              <?php
              $queryServicios = "SELECT * from servicios where estatus=10 and idServicio!=$idServicio";
              $resServicios = mysqli_query($con,$queryServicios);
              $filas = mysqli_num_rows($resServicios);
              if ($filas>=1) {
              ?>
              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
              <div class="table-responsive">

                
              <table class="table table-striped projects" id="dynamic_field" >
                  <tr>
                    <th>Elegir<div style="display: none;"><input type="checkbox" class="form-check-input" id="idServicio" name="idServicio[]" value="<?php echo $idServicio ?>" checked></div></th>
                    <th>Folio del Servicio</th>
                    <th>Tipo de Servicio</th>
                    <th>Fecha de alta</th>
                  </tr>
              <?php while ($registros = mysqli_fetch_array($resServicios)) { ?>
                <tr>
                    <td align="center"><input type="checkbox" class="form-check-input" id="idServicio" name="idServicio[]" value="<?php echo $registros['idServicio'] ?>"></td>
                    <td><?php echo $registros['folioEmpodera'] ?></td>
                    <td><?php echo $registros['servicio'] ?></td>
                    <td><?php echo $registros['fechaAlta'] ?></td>
                </tr>
              <?php } ?>
            </table>
              </div>
              </div>
              </div>
              </div>
              <?php } ?>

          </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Enviar comprobante de pago</button>
          </div> 
          </div>
      </form>

        </div>



        
    </section>
  </div>


    <!-- /.content -->
  </div>
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
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
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
      format: 'LT'
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

</body>
</html>
