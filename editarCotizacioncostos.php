<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");

include('class/editaMedicamentosFinal.php');
$NuUs2 = new editaMedicamento_class();
if ($_POST['actualizaMedicamentosCoti']) {
$NuUs2->actualizaMedicamentosCoti();
}
//consulto para obtener el nombre del beneficiario
$idServicio=$_GET['idServicio'];
$proveedoranterior=$_GET['idProveedor'];

?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>EDICIÓN DE COSTOS DE COTIZACIÓN DEL PROVEEDOR</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Cotizaciones</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content-header">
      <div class="container-fluid">

    <form action="" method="POST">
    <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <thead>
              <tr>
                <td><label>Medicamento</label></td>
                <td><label>Gramaje</label></td>
                <td><label>Presentación</label></td>
                <td><label>Cantidad</label></td>
                <td><label>Costo unitario</label></td>
                <td><label>Costo Total</label></td>
              </tr>
              </thead>
              <tbody>
                <?php         
            $queryMedicamento2 = "SELECT * from solicitudmedicamentos sm
            INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
            INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
            INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
            INNER JOIN medicamentossolicitados ms on ms.idMedicamento=scm.idProductoSolicitud
            INNER JOIN registros r on r.idRegistro=sc.idProveedor
            INNER JOIN servicios s on s.idServicio=sm.idServicio
            INNER JOIN estados e on e.idEstado=r.entidadFederativa
            where sm.idServicio=$idServicio and sc.idProveedor=$proveedoranterior and scm.estatus=1";
            $resMedicamento2 = mysqli_query($con,$queryMedicamento2);
            $i=0; 
            while ($medicamentos22 = mysqli_fetch_array($resMedicamento2)) {

              $i++;
              ?>
              <tr>
                <td>
                  <input type="hidden" id="actualizaMedicamentosCoti" name="actualizaMedicamentosCoti" value="actualizaMedicamentosCoti">
                  <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                  <input type="hidden" id="proveedoranterior" name="proveedoranterior" value="<?php echo $proveedoranterior ?>">
                  <input type="hidden" id="idSolicitudMedicamentos" name="idSolicitudMedicamentos" value="<?php echo $idSolicitudMedicamentos ?>">
                  <input type="hidden" class="form-control" name="idMedicamento[]" value="<?php echo $medicamentos22['idMedicamento']; ?>">
                  <input type="hidden" class="form-control" name="idMedicamentoSolicitud[]" value="<?php echo $medicamentos22['idMedicamentoSolicitud']; ?>">
                  <input type="text" class="form-control" name="nombre[]" placeholder="Medicamento" value="<?php echo $medicamentos22['medicamento']; ?>" readonly>
                </td>
                <td><input type="text" class="form-control" name="gramaje[]" value="<?php echo $medicamentos22['gramaje']; ?>" readonly></td>
                <td><input type="text" class="form-control" name="presentacion[]" value="<?php echo $medicamentos22['presentacion']; ?>" readonly></td>
                <td><input type="text" class="form-control" name="cantidad[]" value="<?php echo $medicamentos22['cantidad']; ?>" readonly></td>
                <td><input type="text" class="form-control" name="costo[]" value="<?php echo $medicamentos22['costo']; ?>"></td>
                <td><input type="text" class="form-control" name="costototal[]" value="<?php echo $medicamentos22['costototal']; ?>"></td>
              </tr>
            <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Guardar cambios en solicitud de medicamentos</button>
            </div>         
      </div>
    </div>
  </div>
  </form>

      </div><!-- /.container-fluid -->
    </section>
    
    
  </div>

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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

</body>
</html>

        <?php if ($_GET['do']==1) { ?>
<script>
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
        title: ' La solicitud de medicamentos se actualizo correctamente'
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
      timer: 4000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'error',
        title: ' La solicitud de medicamentos no pudo actualizarse, revisa no contenga comillas simples o dobles'
      })
    });
    });
</script>
<?php } ?>