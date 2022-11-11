<?php
$idBene=$_GET['id']; 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>
<style type="text/css">
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  background: #ddeefc;
  font-family: 'Lato', sans-serif;
}

.contenedor {
  width: 90%;
  max-width: 1000px;
  padding: 40px 20px;
  margin: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* ---------- Estilos Generales de las Tarjetas ----------*/
.tarjeta {
  width: 100%;
  max-width: 550px;
  position: relative;
  color: #fff;
  transition: .3s ease all;
  transform: rotateY(0deg);
  transform-style: preserve-3d;
  cursor: pointer;
  z-index: 2;
}

.tarjeta.active {
  transform: rotateY(180deg);
}

.tarjeta > div {
  padding: 30px;
  border-radius: 15px;
  min-height: 315px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0 10px 10px 0 rgba(90,116,148,0.3);
}

/* ---------- Tarjeta Delantera ----------*/

.tarjeta .delantera {
  width: 100%;
  background: url(img/bg-tarjeta/bg-tarjeta-02.jpg);
  background-size: cover;
}

.delantera .logo-marca {
  text-align: right;
  min-height: 50px;
}

.delantera .logo-marca img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  max-width: 180px;
}

.delantera .chip {
  width: 100%;
  max-width: 50px;
  margin-bottom: 20px;
}

.delantera .oceas {
  width: 100%;
  max-width: 50px;
  margin-bottom: 120px;
}

.delantera .logo {
  width: 100%;
  max-width: 50px;
  margin-bottom: 20px;
}

.delantera .grupo .label {
  font-size: 16px;
  color: #7d8994;
  margin-bottom: 1px;
}

.delantera .grupo .numero,
.delantera .grupo .nombre,
.delantera .grupo .expiracion {
  color: #fff;
  font-size: 22px;
  text-transform: uppercase;
}

.delantera .flexbox {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

</style>
<?php 
// consulto los datos del beneficiario
$queryBene="SELECT * from beneficiarios b 
INNER join beneficiarioscuentas bc on bc.idBeneficiario=b.idBenefeciario
inner join montosclientes mc on mc.idMontoCliente=bc.idPrograma
where b.idBenefeciario=$idBene";
$res=mysqli_query($con,$queryBene);
$registros=mysqli_fetch_array($res);
$nombreBeneficiario=$registros['nombreBeneficiario'];
$folioEmpodera=$registros['folioBeneficiario'];
$diocesis=$registros['subgrupo'];
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VER CREDENCIAL</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Credencial del Beneficiario</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <div class="contenedor">

    <!-- Tarjeta -->
    <section class="tarjeta" id="tarjeta">
      <div class="delantera">
        
        <div class="datos">
          <div class="logo-marca" id="logo-marca">
          <img src="img/logos/logo_completo.png" alt="">
        </div>
          <div class="grupo" id="numero">
            <p class="label"><b>Asistencia Médica</b></p>
            <p class="numero"><font color="red">55 4160 2780<br>55 5514 5591</font></p>
          </div>
          <div class="flexbox">
            <div class="grupo" id="nombre">
              <p class="label"><b>Beneficiario</b></p>
              <p class="nombre"><b><?php echo $nombreBeneficiario ?></b></p>
              <p class="label">Diócesis: <b><font size="4px"><?php echo $diocesis ?></font></b></p>
              <p class="label">Afliado: <b><font size="4px"><?php echo $folioEmpodera ?></font></b></p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
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