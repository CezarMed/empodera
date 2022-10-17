<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>SOLICITUD DE COTIZACION</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Medicamentos solicitud (Cotización)</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php 
    $idRegistro=$_GET['id'];
    $query2 = "SELECT sm.*, s.idServicio, b.nombreBeneficiario, s.folioEmpodera from solicitudmedicamentos sm
    INNER JOIN beneficiarios b ON b.idBenefeciario=sm.idBeneficiario
    INNER JOIN servicios s ON s.idServicio=sm.idServicio
    where sm.idSolicitudMedicamentos=$idRegistro";
    $res2 = mysqli_query($con,$query2);
    $extraido22= mysqli_fetch_array($res2);
    $idSolicitudMedicamentos=$extraido22['idSolicitudMedicamentos'];
    $folioSolicitud=$extraido22['folioEmpodera'];
    $nombreSolicitante=$extraido22['nombreBeneficiario'];
    $fechaSolicitud=$extraido22['fechaSolicitud'];
    $calle=$extraido22['calle'];
    $noExteriorInterior=$extraido22['noExteriorInterior']; 
    $idServicio=$extraido22['idServicio'];
    $entidadFederativa=$extraido22['entidadFederativa'];
    $municipioDelegacion=$extraido22['municipioDelegacion'];
    ?>
    <!-- Main content -->
    <form action="generarSolicitudCotizaciones" method="POST" name="formulario1">
    <section class="content">

      <div class="container-fluid">

        <div class="card card-default">

          <div class="card-header">
            <h3 class="card-title">Solicitud de Cotización para proveedor</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Datos de la Solicitud</label>
                  <p>Solicitud del servicio <b><font color="red"><?php echo $folioSolicitud ?></font></b> para el beneficiario <b><font color="red"><?php echo $nombreSolicitante ?></font></b> con fecha de solicitud <b><?php echo $fechaSolicitud ?></b></p>
                   <input type="hidden" id="idSolicitudMedicamentos" name="idSolicitudMedicamentos" value="<?php echo $idRegistro ?>">
                </div>
                <div class="form-group">
                  <?php
                  $queryEstados = "SELECT clave, nombreEstado from estados where idEstado=$entidadFederativa";
                  $resEstados = mysqli_query($con,$queryEstados);
                  $estadosResult= mysqli_fetch_array($resEstados);
                  $nombreEstado=$estadosResult['nombreEstado'];

                  $queryMunicipios = "SELECT clave, nombre from municipios where id=$municipioDelegacion";
                  $resMunicipios = mysqli_query($con,$queryMunicipios);
                  $municipiosResult= mysqli_fetch_array($resMunicipios);
                  $nombreMunicipio=$municipiosResult['nombre'];
                  ?>
                  <label>Dirección de envio para medicamentos</label>
                  <p><?php echo $extraido22['calle'] ?> <?php echo $extraido22['noExteriorInterior'] ?>, <?php echo $extraido22['colonia'] ?>,  <?php echo strtoupper($nombreEstado) ?>, <?php echo strtoupper($nombreMunicipio) ?>, <?php echo $extraido22['codigoPostal']  ?></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Medicamentos solicitados</label>
                  <div class="card-body p-0">
            <table class="table table-striped projects">
              <thead>
                  <tr>
                    <th>
                          Medicamento
                      </th>
                      <th>
                          Gramaje
                      </th>
                      <th>
                          Presentacion
                      </th>
                      <th>
                          Cantidad
                      </th>
                      <th>
                          Fecha Termino
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query4 = "SELECT * from medicamentossolicitados where idSolicitudMedicamento=$idRegistro";
                $res4 = mysqli_query($con,$query4);
                while ($registro=mysqli_fetch_array($res4)) {
                  ?>
                  <tr>
                    <td>
                          <?php echo $registro['medicamento'] ?>
                      </td>
                      <td>
                          <a>
                              <?php echo $registro['gramaje'] ?>
                          </a>
                      </td>
                      <td>
                          <?php echo $registro['presentacion'] ?>
                      </td>
                      <td>
                          <?php echo $registro['cantidad'] ?>
                      </td>
                       <td>
                          <?php echo $registro['fechaTermina'] ?>
                      </td>
                  </tr>

                <?php } ?>
                  
              </tbody>
          </table>
        </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6"><div class="form-group">
                  <label>Modo de atención</label>
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa" required>
                    <option value="">Elije un tipo de atención</option>
                    <option value="N">Nacional</option>
                    <option value="E">Estatal</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Proveedor</label>
                  <div class="input-group">
                    <select class="form-control select2 select2" data-dropdown-css-class="select2" id="idProveedor" name="idProveedor[]" >
                      <option value="0">Elije un proveedor</option>
                  </select>
                  </div>                
                </div>
              </div>
            </div> 

            <div class="row">
              <div class="col-md-6"><div class="form-group">
                  <label>Modo de atención</label>
                  <select class="custom-select form-control-border" id="entidadFederativa2" name="entidadFederativa" required>
                    <option value="">Elije un tipo de atención</option>
                    <option value="N">Nacional</option>
                    <option value="E">Estatal</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Proveedor</label>
                  <div class="input-group">
                    <select class="form-control select2 select2" data-dropdown-css-class="select2" id="idProveedor2" name="idProveedor[]">
                      <option value="0">Elije un proveedor</option>
                  </select>
                  </div>                
                </div>
              </div>
            </div> 

            <div class="row">
              <div class="col-md-6"><div class="form-group">
                  <label>Modo de atención</label>
                  <select class="custom-select form-control-border" id="entidadFederativa3" name="entidadFederativa" required>
                    <option value="">Elije un tipo de atención</option>
                    <option value="N">Nacional</option>
                    <option value="E">Estatal</option>
                  </select>
                  <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Proveedor</label>
                  <div class="input-group">
                    <select class="form-control select2 select2" data-dropdown-css-class="select2" id="idProveedor3" name="idProveedor[]">
                      <option value="0">Elije un proveedor</option>
                  </select>
                  </div>                
                </div>
              </div>
            </div> 

            </div> 


            <div class="card-footer">
            <button type="button" class="btn btn-success" id="btn" name="btn" value="word" >Generar cotizaciones</button>
            
          </div> 
          </div>          
        </div>




          


        </div>



        
    </section>
  </div>
</form>
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
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

</body>
</html>


<script type="text/javascript">
    $('#entidadFederativa').on('change', function(){   
    var id = $('#entidadFederativa').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasProveedor.php',
      data: {'id': id}
    })
    .done(function(listas_municipios){
      $('#idProveedor').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>

<script type="text/javascript">
    $('#entidadFederativa2').on('change', function(){   
    var id = $('#entidadFederativa2').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasProveedor.php',
      data: {'id': id}
    })
    .done(function(listas_municipios){
      $('#idProveedor2').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>

<script type="text/javascript">
    $('#entidadFederativa3').on('change', function(){   
    var id = $('#entidadFederativa3').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasProveedor.php',
      data: {'id': id}
    })
    .done(function(listas_municipios){
      $('#idProveedor3').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>

<script type="text/javascript">
$(document).ready(function(){
$("#btn").click(function(){
var id1 = $('#idProveedor').val();
var id2 = $('#idProveedor2').val();
var id3 = $('#idProveedor3').val();

if (id1>=1&&id2>=1&&id3>=1){
// alert(id1+id2+id3);
if (id1!=id2&&id1!=id3&&id2!=id3) {
 // alert('Los proveedores no son iguales')
document.formulario1.submit();
} else {
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
                      title: ' Los proveedores no pueden ser iguales'
                    })
                  });
                  });
}
} else {
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
                      title: ' Debes elegir los 3 proveedores, para complementar puedes usar SIN ASIGNAR'
                    })
                  });
                  });
}

});
}); 
</script>
