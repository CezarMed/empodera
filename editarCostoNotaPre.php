<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");

if ($_POST){
    $honorarios=$_POST['honorarios'];
    $idNota=$_POST['idNota'];
    $idBeneficiario=$_POST['idBeneficiario'];
    $idServicio=$_POST['idServicio'];
    $idCuenta=$_POST['idCuenta'];
    $cirujano=$_POST['cirujano'];
    $anestesiologo=$_POST['anestesiologo'];
    $ayudante=$_POST['ayudante'];
    $enfermeria=$_POST['enfermeria'];
    $ayudante2=$_POST['ayudante2'];
    $estatus=$_POST['estatus'];
    $query = "UPDATE notaspreoperatorias SET honorarios=$honorarios, cirujano=$cirujano, anestesiologo=$anestesiologo, ayudante=$ayudante, enfermeria=$enfermeria, ayudante2=$ayudante2, estatus=$estatus WHERE idNotaPreoperatoria=$idNota";
    mysqli_query($con,$query); 
    ?>
         <script type="text/javascript">
              window.location="reporteNotas?idBeneficiario=<?php echo $idBeneficiario?>&idServicio=<?php echo $idServicio?>&idCuenta=<?php echo $idCuenta?>";
        </script>  
<?php }

?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>EDICIÓN DE NOTAS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Notas preoperatorias</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <?php 
    $idNota=$_GET['idNota'];
    $idBeneficiario=$_GET['idBeneficiario'];
    $idServicio=$_GET['idServicio'];
    $idCuenta=$_GET['idCuenta'];
    $query = "SELECT * from notaspreoperatorias where idNotaPreoperatoria=$idNota";
    $res = mysqli_query($con,$query);
    $extraido= mysqli_fetch_array($res);
    $honorarios=$extraido['honorarios'];
    $cirujano=$extraido['cirujano'];
    $anestesiologo=$extraido['anestesiologo'];
    $ayudante=$extraido['ayudante'];
    $enfermeria=$extraido['enfermeria'];
    $ayudante2=$extraido['ayudante2'];
    ?>

    <!-- Main content -->
    
    <section class="content">

      <div class="container-fluid">

        <div class="card card-default">
         <form action="" method="POST" autocomplete="off">
          <div class="card-header">
            <h3 class="card-title">Edición de costo de la nota </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label>Honorarios</label>
                 <input type="text" class="form-control" id="honorarios" name="honorarios" value="<?php echo $honorarios ?>">
                 <input type="hidden" id="idNota" name="idNota" value="<?php echo $idNota ?>">
                 <input type="hidden" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                 <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                 <input type="hidden" id="idCuenta" name="idCuenta" value="<?php echo $idCuenta ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Cirujano</label>
                 <input type="text" class="form-control" id="cirujano" name="cirujano" value="<?php echo $cirujano ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Anestesiologo</label>
                 <input type="text" class="form-control" id="anestesiologo" name="anestesiologo" value="<?php echo $anestesiologo ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Ayudante</label>
                 <input type="text" class="form-control" id="ayudante" name="ayudante" value="<?php echo $ayudante ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Enfermeria</label>
                 <input type="text" class="form-control" id="enfermeria" name="enfermeria" value="<?php echo $enfermeria ?>">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Segundo Ayudante</label>
                 <input type="text" class="form-control" id="ayudante2" name="ayudante2" value="<?php echo $ayudante2 ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Procedente</label>
                 <select class="custom-select form-control-border" id="estatus" name="estatus">
                  <option value="1">Procedente</option>
                  <option value="5">No Procedente</option>
                  </select>
                </div>
              </div>
            </div>

          </div> 
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Actualizar costos de la nota</button>
          </div>          
        </div>
      </form>
        </div>
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


<div id="borrarBanco" class="modal fade" role="dialog">
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
        Desactivar Banco <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
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

<div id="activarBanco" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="GET" id="fl3" name="fl4">
            <input type="hidden" name="iduser" name="iduser" value="">
            <input type="hidden" value="si" name="actualizar" name="actualizar">
        <button type="submit" class="btn btn-sm btn-success" >
        Activar Banco <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
      </button>
      </form>
        <script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnActivate', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        //alert(uid);
        document.fl4.iduser.value = uid;
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
            url: 'consultas/consultasActualizacionesBancos',
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
