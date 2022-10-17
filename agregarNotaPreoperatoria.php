<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// agrego la clase
include('class/altaNotaMedica.php');
$NuUs = new AltaNotaMedicas_class();
if ($_POST) {
$NuUs->altaNotaPreoperatoria();
}

//consulto para obtener el nombre del beneficiario
$idBeneficiario=$_GET['idBeneficiario'];
$idServicio=$_GET['idServicio'];
$idCuenta=$_GET['idCuenta'];
$query="SELECT * FROM beneficiarios where idBenefeciario=$idBeneficiario";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$nombreBene=$registro['nombreBeneficiario'];
$hoy=date('Y-m-d');

// obtengo el registro si ya tiene proveedor asignado el servicio
$query="SELECT * FROM servicioscerradosproveedor where idServicio=$idServicio";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$idProveedorServicio=$registro['proveedorname'];

$query="SELECT * FROM registros where idRegistro=$idProveedorServicio";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$entidadFederativa=$registro['entidadFederativa'];

$queryProvee = "SELECT * from servicioscerradosproveedor
                where idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $proveedorname=$extraidoProvee['proveedorname'];

    // OBTENGO EL NOMBRE DEL PROVEEDOR
    $queryProvee = "SELECT * from registros where idRegistro=$proveedorname";
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
            <h1>CREACIÓN DE NOTAS PRE-OPERATORIAS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Notas Pre-operatorias</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
<?php require_once ("encabezadoServicios.php"); ?>

      <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La nota se genero correctamente</b> para consultar la información clic <a href="reporteMinutas?id=<?php echo $_GET['id']; ?>">Aquí</a>
                </div>
                </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  La nota no se genero correctamente, si lo deseas contacta con un administrador</a>
                </div>
                </div>
  <?php } ?>

    <?php
    if ($servicio=='MEDICAMENTOS'){
      $grupocpt='X';
    } 

    if ($grupocpt!='') { ?>
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
    <section class="content">
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
                 <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                 <input type="hidden" class="form-control" id="altaNotaPreoperatoria" name="altaNotaPreoperatoria" value="altaNotaPreoperatoria">
                 <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Fecha de cirugia</label>
                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?php echo $hoy ?>" id="fechaCirugia" name="fechaCirugia"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>               
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Hora de cirugia</label>
                  <div class="input-group">
                    <input type="time" class="form-control" id="horaCirugia" name="horaCirugia">
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Diagnóstico pre-operatorio</label>
                 <textarea class="form-control" rows="3" id="diagnostico" name="diagnostico" placeholder="Diagnóstico pre-operatorio" maxlength="3000" onkeyup="countChars(this);"></textarea>
                 <p id="charNum">3000 caracteres</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Plan quirúrgico</label>
                  <div class="form-group">
                  <textarea class="form-control" rows="3" id="planqui" name="planqui" placeholder="Plan quirúrgico" maxlength="3000" onkeyup="countChars2(this);"></textarea>
                  <p id="charNum2">3000 caracteres</p>
                  </div>                
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Riesgo quirúrgico</label>
                <textarea class="form-control" rows="3" id="riesgoqui" name="riesgoqui" placeholder="Riesgo quirúrgico" maxlength="3000" onkeyup="countChars3(this);"></textarea>
                <p id="charNum3">3000 caracteres</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Cuidados y plan terapéutico preoperatorio</label>
                  <div class="form-group">
                  <textarea class="form-control" rows="3" id="cuidados" name="cuidados" placeholder="Cuidados y plan terapéutico preoperatorio" maxlength="3000" onkeyup="countChars4(this);"></textarea>
                  <p id="charNum4">3000 caracteres</p>
                  </div>                
                </div>
              </div>
            </div>
            <hr>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Fecha de estudio</label>
                  <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2" value="<?php echo $hoy ?>" id="fechaEstudio" name="fechaEstudio"/>
                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>               
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Hora de estudio</label>
                  <div class="input-group">
                    <input type="time" class="form-control" id="horaEstudio" name="horaEstudio">
                  </div>                
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Estudio solicitado</label>
                 <input type="text" class="form-control" id="estudiosolicitado" name="estudiosolicitado" placeholder="Estudio solicitado">
                </div>
              </div>

              
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Problema clínico en estudio</label>
                 <input type="text" class="form-control" id="problemaclinico" name="problemaclinico" placeholder="Problema clínico en estudio">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Especifica incidentes o accidentes</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="incidentesaccidentes" name="incidentesaccidentes" placeholder="Especifica incidentes o accidentes">
                  </div>                
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

            <?php 
            if ($servicio=='MEDICAMENTOS'){
                      $idProveedorServicio='X';
                    } 
            if ($idProveedorServicio!='') { ?>
            <!-- div class="row">
              <div class="col-lg-12">
                   <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="verDatos" name="verDatos" value="1" onchange="javascript:showContent()">
                    <label class="form-check-label" for="exampleCheck1">Si requiere pago por este servicio, favor de activar la casilla.</label>
                  </div>
                  </div>
            </div-->
          <?php } else { ?>
            <div class="row">
              <div class="col-lg-12">
                   <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="verDatos" name="verDatos" value="1" disabled>
                    <label class="form-check-label" for="exampleCheck1">Para agregar un costo a esta nota es necesario agregar un proveedor al servicio</label>
                  </div>
                    <!-- /input-group -->
                  </div>
            </div>
          <?php } ?>

            <div id="datosDoctor">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Elije un Cpt</label>
                  <select class="custom-select form-control-border" id="cambiaCPt" name="cambiaCPt" onchange="buscaValorCpt()">
                  <?php 
                    $queryCpt = "SELECT * from datoscpt where idServicio=$idServicio";
                    $resCpt = mysqli_query($con,$queryCpt);
                    while ($extraidoCpt= mysqli_fetch_array($resCpt)) { ?>
                  <option value="<?php echo $extraidoCpt['tratamientocpt4']  ?>"><?php echo $extraidoCpt['tratamientocpt4']  ?></option>
                  <?php } ?>
                  </select>
                  <input type="hidden" class="form-control" id="entidadFederativa" name="entidadFederativa" value="<?php echo $entidadFederativa ?>">
                </div>
              </div>               
            </div>

            <?php if ($servicio!='MEDICAMENTOS') {
            // echo $entidadFederativa;
            if ($entidadFederativa==9||$entidadFederativa==15||$entidadFederativa==21||$entidadFederativa==17||$entidadFederativa==2||$entidadFederativa==25) {  
            $honorarios='honorarios';
            $cirujano='cirujano';
            $anesteciologo='anesteciologo';
            $ayudante='ayudante'; 
            } else{
            $honorarios='honorariosforaneo';
            $cirujano='cirujanoforaneo';
            $anesteciologo='anesteciologoforaneo';
            $ayudante='ayudanteforaneo';
            }

            $query="SELECT $honorarios as honorarios, $cirujano as cirujano, $anesteciologo as anesteciologo, $ayudante as ayudante FROM cpttratamientos where titulo='$grupocpt'";
            $res = mysqli_query($con,$query);
            $registro = mysqli_fetch_array($res);
            ?>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre Cirujano</label>
                 <input type="text" class="form-control" id="nombrecirujano" name="nombrecirujano" placeholder="Nombre completo">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Cirujano</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="cirujano" name="cirujano" value="<?php echo $registro['cirujano'] ?>" onkeyup="eliminarEspacio()">
                  </div>                
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre Anestesiologo</label>
                 <input type="text" class="form-control" id="nombreanesteciologo" name="nombreanesteciologo" placeholder="Nombre completo">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Anestesiologo</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="anesteciologo" name="anesteciologo" value="<?php echo $registro['anesteciologo'] ?>" onkeyup="eliminarEspacio()">
                  </div>                
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre 1er ayudante</label>
                 <input type="text" class="form-control" id="nombreayudante" name="nombreayudante" placeholder="Nombre completo">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>1er Ayudante</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="ayudante" name="ayudante" value="<?php echo $registro['ayudante'] ?>" onkeyup="eliminarEspacio()">
                  </div>                
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre Enfermeria</label>
                 <input type="text" class="form-control" id="nombreenfermeria" name="nombreenfermeria" placeholder="Nombre completo">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Enfermeria</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="enfermeria" name="enfermeria" value="0" onkeyup="eliminarEspacio()">
                  </div>                
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre 2do Ayudante</label>
                 <input type="text" class="form-control" id="nombreayudante2" name="nombreayudante2" placeholder="Nombre completo">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>2do Ayudante</label>
                  <div class="input-group">
                  <input type="text" class="form-control" id="ayudante2" name="ayudante2" value="0" onkeyup="eliminarEspacio()">
                  </div>                
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">  
                  <label>Total honorarios</label>
                 <input type="text" class="form-control" id="honorarios" name="honorarios" value="<?php echo $registro['honorarios'] ?>" readonly>
                </div>
              </div>
              
              
              
            </div>


            <?php } ?>
            </div>
            <hr>

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Generar nota preoperatoria</button>
            </div> 

          </div>          
        </div>
        </div>
    </section>
    </form>
  <?php } else { ?>
          <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Ups!</h5>
                  Es necesario agregar el CPT4 al servicio para poder crear una nota quirurgica.
                </div>
                </div>
  <?php } ?>

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
<script type="text/javascript">
function countChars(obj){
    document.getElementById("charNum").innerHTML = 3000-obj.value.length+' caracteres';
}
function countChars2(obj){
    document.getElementById("charNum2").innerHTML = 3000-obj.value.length+' caracteres';
}
function countChars3(obj){
    document.getElementById("charNum3").innerHTML = 3000-obj.value.length+' caracteres';
}
function countChars4(obj){
    document.getElementById("charNum4").innerHTML = 3000-obj.value.length+' caracteres';
}

</script>

</body>
</html>

<script type="text/javascript">
function eliminarEspacio(){
 $('input').val(function(_, value) {
       return $.trim(value);
    });
 $('input').val(function($, value) {
       return $.trim(value);
    });
}
</script>

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
function buscaValorCpt() {
    var cambiaCPt=$('#cambiaCPt').val();
    var entidadFederativa=$('#entidadFederativa').val();

    // alert(cambiaCPt);

        $.ajax({
            url: 'consultas/consultasCptCostos.php',
            type: "POST",
            data: {"cambiaCPt":cambiaCPt, "entidadFederativa":entidadFederativa},
            success: function (cmb) {
                    // alert(cmb);
                    var Data=cmb.split("-");
                    $("#honorarios").val(Data[0]);
                    $("#cirujano").val(Data[1]);
                    $("#anesteciologo").val(Data[2]);
                    $("#ayudante").val(Data[3]);
                
            }
        });
}
</script>
