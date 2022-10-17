<?php 
date_default_timezone_set ('America/Mexico_City');
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// 
include('class/respondeOrdenPago.php');
$NuUs = new respondeOrdenPago_class();
if ($_POST) {
$NuUs->responderOrdenPago();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ENVIO DE FACTURA PARA VALIDACION</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Orden de Pago solicitud</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php if ($_GET['do']==5) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Ups!</h5>
                  El UUID <b><?php echo $_GET['UUID'] ?></b> ya se encuentra registrado, favor de ponerse en contacto con Empodera.
        </div>
      </div>
    <?php } ?>

    <?php if ($_GET['do']==6) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Ups!</h5>
                  El RFC <b><?php echo $_GET['RFC'] ?></b> emitido en la factura no coincide con el registrado en plataforma.
        </div>
      </div>
    <?php } ?>

        <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La factura se envio correctamente.
        </div>
      </div>
    <?php } ?>


    <!-- Main content -->
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
    <section class="content">
      <div class="container-fluid">
      
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Enviar factura de pago a cliente</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body">

                <div class="col-sm-12">
                <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-check"></i> IMPORTANTE !!</h5>
                  Es necesario agregar ambos archivos de factura <b>XML</b> y <b>PDF</b>, de manera simultanea.
                </div>
                </div>

              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">Elije un proveedor</label>
                  <?php
                  $idProveedor=$_SESSION['idEmpresa'];
                  if ($_SESSION['tipousuario']=='Administrador'){                  
                  $queryBancos="SELECT * from registros";
                  }
                  if ($_SESSION['tipousuario']=='ProveedorMedicamentos'){                  
                  $queryBancos="SELECT * from registros where idRegistro=$idProveedor";
                  }
                  $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                    <select class="form-control select2 select2" data-dropdown-css-class="select2"  id="idRegistro" name="idRegistro">
                      <?php if ($_SESSION['tipousuario']=='Administrador'){   ?>
                      <option value="">- Elige un proveedor -</option>
                    <?php } ?>
                          <?php
                           while ($bancos = mysqli_fetch_array($resBancos)) {
                              echo '<option value="' . $bancos['idRegistro'] . '">'.$bancos['nombreComercial']. '</option>';
                            }
                          ?>
                    </select>
                </div>
              </div>
              </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo (factura XML)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo1" name="archivo1" accept=".xml">
                      </div>
                    </div>
                  </div>
               </div>
               <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo (factura PDF)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept="application/pdf">
                      </div>
                    </div>
                  </div>
              </div>
            </div> 

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Tipo de Pago elegido para el servicio</label>
                    <select class="custom-select form-control-border" id="tipoPago" name="tipoPago" required>
                      <option value="">Elige el tipo de pago</option>
                      <option value="Completo">Completo</option>
                      <option value="Parcial">Parcial</option>
                  </select>
                  </div>
              </div>
               <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Comentarios</label>
                    <textarea class="form-control" rows="3" id="comentarios" name="comentarios" placeholder="Comentarios anexados a la factura" maxlength="2000" onkeyup="countChars(this);"></textarea>
                 <p id="charNum">2000 caracteres</p>
                  </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12" id="tabladatos">
                <label for="exampleInputFile">Cartas disponibles para asignar factura</label>
                </div> 
              </div>    

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Enviar factura a Empodera</button>
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
<script type="text/javascript">
function countChars(obj){
    document.getElementById("charNum").innerHTML = 2000-obj.value.length+' caracteres';
}
</script>

<script type="text/javascript">
    $('#idRegistro').on('change', function(){  
      var idRegistro=$('#idRegistro').val();

      if (idRegistro!='') {
        // alert(idRegistro);
        $.ajax({
            url: 'consultas/consultasCartasProveedores',
            type: "POST",
            data: {"idRegistro":idRegistro},
            success: function (cmb) {
                     // alert(cmb);
                     $('#tabladatos').html(cmb);
                
            }
        });
      }
  })

</script>
