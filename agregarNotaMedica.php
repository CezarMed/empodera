<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// agrego la clase
include('class/altaNotaMedica.php');
$NuUs = new AltaNotaMedicas_class();
if ($_POST) {
$NuUs->altaNotaMedica();
}

//consulto para obtener el nombre del beneficiario
$idBeneficiario=$_GET['idBeneficiario'];
$idServicio=$_GET['idServicio'];
$idCuenta=$_GET['idCuenta'];
$query="SELECT * FROM beneficiarios where idBenefeciario=$idBeneficiario";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$nombreBene=$registro['nombreBeneficiario'];
$fechaNac=$registro['fechaNacimiento'];
$sexo=$registro['sexo'];
$genero=$registro['genero'];
list($anio, $mes, $dia) = explode("-", $fechaNac);
$yearh=date('Y');
//obtengo los datos del servicio
$querys="SELECT * FROM servicios where idServicio=$idServicio";
$ress = mysqli_query($con,$querys);
$registros = mysqli_fetch_array($ress);
$folioServicio=$registros['folioEmpodera'];
$servicio=$registros['servicio'];
$hoy=date('Y-m-d');

$queryProvee = "SELECT * from servicioscerradosproveedor
                where idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $proveedorname=$extraidoProvee['proveedorname'];

    // OBTENGO EL NOMBRE DEL PROVEEDOR
    $queryProvee = "SELECT * from registros
                where idRegistro=$proveedorname";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $nombreComercial=$extraidoProvee['nombreComercial'];
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CREACIÓN DE NOTAS MEDICAS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Notas Medicas</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
 <?php require_once ("encabezadoServicios.php"); ?>
    <section class="content">
      <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">CRITERIOS Y CUMPLIMIENTO NORMATIVO</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tipo de entrada</label>
                  <select class="custom-select form-control-border" id="tipoComunicacion" name="tipoComunicacion">
                  <option value="Correo electronico">Correo electrónico</option>
                  <option value="Notificacion de App">Aplicación</option>                  
                  <option value="Llamada telefonica">Llamada telefónica</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Nombre de quien se comunica</label>
                  <input type="text" class="form-control" id="nombrecomunica" name="nombrecomunica" placeholder="Nombre de quien se comunica" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Motivo de atención</label>
                  <input type="text" class="form-control" id="motivoatencion" name="motivoatencion" placeholder="Motivo de atención" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre del paciente</label>
                 <input type="text" class="form-control" id="nombrePaciente" name="nombrePaciente" value="<?php echo $nombreBene ?>" readonly>
                 <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>" readonly>
                 <input type="hidden" class="form-control" id="altaNotaMedica" name="altaNotaMedica" value="altaNotaMedica">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo de Servicio</label>
                  <input type="text" class="form-control" id="servicio" name="servicio" value="<?php echo $servicio ?>" readonly>
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">               
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Folio de servicio</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="folioservicio" name="folioservicio" value="<?php echo $folioServicio ?>" readonly>
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Edad</label>
                 <input type="number" class="form-control" id="edad" name="edad" value="<?php echo ($yearh-$anio) ?>" readonly>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Sexo</label>
                  <div class="input-group">
                  <select class="custom-select form-control-border" id="sexo" name="sexo">
                    <?php if ($sexo=='M') {$sexo1='Masculino';} else {$sexo1='Femenino';} ?>
                  <option value="<?php echo $sexo ?>"><?php echo $sexo1 ?></option>
                  </select>
                  </div>                
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Genero</label>
                  <div class="input-group">
                  <select class="custom-select form-control-border" id="sexo" name="sexo">
                    <?php if ($genero=='M') {$genero1='Masculino';} else {$genero1='Femenino';} ?>
                  <option value="<?php echo $genero ?>"><?php echo $genero1 ?></option>
                  </select>
                  </div>                
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Peso</label>
                 <input type="text" class="form-control" id="peso" name="peso" placeholder="Peso">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Talla</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="talla" name="talla" placeholder="Talla">
                  </div>                
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Tensión arterial</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="tension" name="tension" placeholder="Tensión arterial">
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Frecuencia cardiaca</label>
                 <input type="text" class="form-control" id="frecuenciacar" name="frecuenciacar" placeholder="Frecuencia Cardiaca">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Frecuencia respiratoria</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="frecuenciares" name="frecuenciares" placeholder="Frecuencia Respiratoria">
                  </div>                
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Temperatura</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="temperatura" name="temperatura" placeholder="Temperatura">
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Resumen interrogatorio</label>
                 <textarea class="form-control" rows="3" id="resumen" name="resumen" placeholder="Resumen del interrogatorio" maxlength="2000" onkeyup="countChars(this);"></textarea>
                 <p id="charNum">2000 caracteres</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Exploración física</label>
      <textarea class="form-control" rows="3" id="exploracionfis" name="exploracionfis" placeholder="Exploración física" maxlength="2000" onkeyup="countChars2(this);"></textarea>
                  <p id="charNum2">2000 caracteres</p>
                </div>
              </div>
            </div>
            <hr>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Resultado de Estudios auxiliares</label>
                 <textarea class="form-control" rows="3" id="resultadoestudios" name="resultadoestudios" placeholder="Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento" maxlength="2000" onkeyup="countChars3(this);"></textarea><p id="charNum3">2000 caracteres</p>
                </div>
                 
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Análisis de diagnóstico y problemas clínicos/medico-administrativos</label>
                  <textarea class="form-control" rows="3" id="diagnostico" name="diagnostico" placeholder="Análisis de diagnóstico y problemas clínicos/medico-administrativos" maxlength="2000" onkeyup="countChars4(this);"></textarea><p id="charNum4">2000 caracteres</p>
                                 
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Plan de estudio y/o tratamiento</label>
                 <textarea class="form-control" rows="3" id="planestudios" name="planestudios" placeholder="Plan de estudio y/o Tratamiento (indicaciones médicas, vía, dosis, periodicidad)" maxlength="2000" onkeyup="countChars5(this);"></textarea><p id="charNum5">2000 caracteres</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Pronóstico</label>
                  <textarea class="form-control" rows="3" id="pronostico" name="pronostico" placeholder="Pronóstico"  maxlength="2000" onkeyup="countChars6(this);"></textarea><p id="charNum6">2000 caracteres</p>               
                </div>
              </div>
            </div>
                        <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Descripción del archivo</label>
                 <input type="text" class="form-control" id="concepto" name="concepto" placeholder="Concepto del Archivo">
                 <input type="hidden" id="altaArchivo" name="altaArchivo" value="altaArchivo">
                 <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo </label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept="application/pdf">
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-lg-6">
                   <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="verDatos" name="verDatos" value="1" onchange="javascript:showContent()">
                    <label class="form-check-label" for="exampleCheck1">Si requiere pago por este servicio, favor de activar la casilla.</label>
                  </div>
                    <!-- /input-group -->
                  </div>
            </div>
            <div id="datosDoctor" style="display: none">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre completo del médico</label>
                 <input type="text" class="form-control" id="nombredr" name="nombredr" placeholder="Nombre completo">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Especialidad</label>
                 <input type="text" class="form-control" id="especialidad" name="especialidad" placeholder="Ejemplo: Internista, Oftalmologo, cardiologo,etc.">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Cédula profesional</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula profesional ">
                  </div>                
                </div>
              </div>
              <?php if ($servicio!='MEDICAMENTOS') { ?>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Costo del servicio</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="costonota" name="costonota" placeholder="Colocar el costo del servicio" onkeyup="eliminarEspacio()">
                  </div>                
                </div>
              </div>
            <?php } ?>
            </div>
            </div>

          </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Generar nota médica</button>
            </div> 

          </div>          
        </div>
        </div>
        </form>
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
function showContent() {
    element = document.getElementById("datosDoctor");
    check = document.getElementById("verDatos");
    if (verDatos.checked) {
        element.style.display='block';
    }
    else {
        element.style.display='none';
    }
}
</script>

<script type="text/javascript">
function countChars(obj){
    document.getElementById("charNum").innerHTML = 2000-obj.value.length+' caracteres';
}
function countChars2(obj){
    document.getElementById("charNum2").innerHTML = 2000-obj.value.length+' caracteres';
}
function countChars3(obj){
    document.getElementById("charNum3").innerHTML = 2000-obj.value.length+' caracteres';
}
function countChars4(obj){
    document.getElementById("charNum4").innerHTML = 2000-obj.value.length+' caracteres';
}
function countChars5(obj){
    document.getElementById("charNum5").innerHTML = 2000-obj.value.length+' caracteres';
}
function countChars6(obj){
    document.getElementById("charNum6").innerHTML = 2000-obj.value.length+' caracteres';
}
</script>

<script type="text/javascript">
function eliminarEspacio(){
 var texto2=$('#costonota').val();
 procesado2=texto2.replace(/\s+/g, '');
 $('#costonota').val(procesado2);
}
</script>

