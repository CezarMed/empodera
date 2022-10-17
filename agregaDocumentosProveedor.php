<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaDocumentosRegistros.php');
//creamo el objeto de la orde de venta class
$NuUs = new Altaarchivos_class();
if ($_POST) {
$NuUs->altaArchivo();
}
$idRegistro=$_GET['id'];
// conculto para obtenet el tipoRegimen
$queryRegistros="SELECT * from registros where idRegistro=$idRegistro";
$res=mysqli_query($con,$queryRegistros);
$registros=mysqli_fetch_array($res);
$tipoRegimen=$registros['tipoRegimen'];
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>BIBLIOTECA DE ARCHIVOS DEL PROVEEDOR</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Servicios</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
         <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
          <div class="card-header">
            <h3 class="card-title">Archivos importantes del proveedor</h3>
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
                 <label>Descripción del archivo</label>
                 <?php if ($tipoRegimen=='02') {?>
                 <select class="custom-select form-control-border" id="tipoDocumento" name="tipoDocumento" required>
                  <option value="">Selecciona un tipo de Documento</option>
                  <option value="RFC actualizada por el SAT o en su caso Constancia de Situación Fiscal (antigüedad mínima de 6 meses de inscripción al SAT)">RFC actualizada por el SAT o en su caso Constancia de Situación Fiscal (antigüedad mínima de 6 meses de inscripción al SAT)</option>
                  <option value="Curriculum Vitae en formato libre que contenga lo siguiente (fotografía del Representante Legal, datos generales, evolución de la empresa, organigrama, capacidad que tiene la empresa para desempeñar sus actividades y sucursales, cartera de clientes)">Curriculum Vitae en formato libre que contenga lo siguiente (fotografía del Representante Legal, datos generales, evolución de la empresa, organigrama, capacidad que tiene la empresa para desempeñar sus actividades y sucursales, cartera de clientes)</option>
                  <option value="Carta Compromiso">Carta Compromiso</option>
                  <option value="Carta Transparencia">Carta Transparencia</option>
                  <option value="Acta Constitutiva de la sociedad con sello del Registro Público de Comercio">Acta Constitutiva de la sociedad con sello del Registro Público de Comercio</option>
                  <option value="Última modificación al Acta Constitutiva">Última modificación al Acta Constitutiva</option>
                  <option value="Declaración del Servicio de Administración Tributaria (ejercicio anterior y vigente)">Declaración del Servicio de Administración Tributaria (ejercicio anterior y vigente)</option>
                  <option value="Identificación Oficial vigente del Representante Legal (credencial de elector, pasaporte o cédula profesional)">Identificación Oficial vigente del Representante Legal (credencial de elector, pasaporte o cédula profesional)</option>
                  <option value="Poder Notarial que acredita al Representante Legal">Poder Notarial que acredita al Representante Legal</option>
                  <option value="Fotografía tamaño infantil del Representante Legal">Fotografía tamaño infantil del Representante Legal</option>
                  <option value="Catálogo de Productos y Servicios">Catálogo de Productos y Servicios</option>
                  <option value="Otro">Otro</option>
                  </select>
                  <?php } else { ?>
                    <select class="custom-select form-control-border" id="tipoDocumento" name="tipoDocumento" required>
                  <option value="">Selecciona un tipo de Documento</option>
                  <option value="RFC actualizada por el SAT o en su caso Constancia de Situación Fiscal (antigüedad mínima de 6 meses de inscripción al SAT)">RFC actualizada por el SAT o en su caso Constancia de Situación Fiscal (antigüedad mínima de 6 meses de inscripción al SAT)</option>
                  <option value="Curriculum Vitae en formato libre que contenga lo siguiente (fotografía, datos generales, formación académica, experiencia laboral, idiomas e informática).">Curriculum Vitae en formato libre que contenga lo siguiente (fotografía, datos generales, formación académica, experiencia laboral, idiomas e informática).</option>
                  <option value="Constancia de Situación Fiscal">Constancia de Situación Fiscal</option>
                  <option value="Identificación Oficial vigente (credencial de elector, pasaporte o cédula profesional)">Identificación Oficial vigente (credencial de elector, pasaporte o cédula profesional)</option>
                  <option value="Catálogo de Productos y Servicios">Catálogo de Productos y Servicios</option>
                  <option value="Cedula profesional">Cedula profesional</option>
                  <option value="Otro">Otro</option>
                  </select>
                  <?php } ?>
                 <input type="hidden" id="altaArchivo" name="altaArchivo" value="altaArchivo">
                 <input type="hidden" id="idRegistro" name="idRegistro" value="<?php echo $idRegistro ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo </label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
                      </div>
                    </div>
                  </div>
              </div>
            </div>

            <div class="row" id="divotro" style="display: none">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Descripción del archivo</label>
                 <input type="text" class="form-control" id="otro" name="otro" placeholder="Concepto del Archivo">
                </div>
              </div>
            </div>

          </div> 
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Subir archivos</button>
          </div>          
        </div>
      </form>
        </div>
    </section>


        <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Biblioteca del proveedor</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                    <th>
                          Concepto del archivo
                      </th>
                      <th>
                          Fecha de subida
                      </th>
                      <th>
                          Quien subio
                      </th>
                      <th>
                          
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php
                
                  $query = "SELECT * from registrosdocumentos s
                            INNER JOIN usuarios u on u.idUsuario=s.idSubio
                            where s.idRegistro=$idRegistro";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                  ?>
                  <tr>
                    <td>
                          <?php echo $registro['concepto'] ?>
                      </td>
                      <td>
                          <?php echo $registro['fechaSubida'] ?>
                      </td>
                      <td>
                          <?php echo $registro['usuario'] ?>
                      </td>
                      <td>
                          <a class="btn btn-info btn-sm" href="<?php echo $registro['archivo'] ?>" target="_blanck">
                              <i class="fas fa-edit">
                              </i>
                              ver archivo
                          </a>
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
$('#tipoDocumento').on('change', function(){   
var tipoDocumento = $('#tipoDocumento').val();
if (tipoDocumento=='Otro'){
  $('#divotro').show();
} else {
  $('#divotro').hide();
  $('#otro').val('');
}
});
</script>