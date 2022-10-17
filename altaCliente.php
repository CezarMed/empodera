<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// agrego la clase
include('class/altaCliente.php');
//creamo el objeto de la orde de venta class
$NuUs = new AltaCliente_class();
if ($_POST) {
$NuUs->altaCliente();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ALTA DE CLIENTES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Clientes</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

  <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  El cliente se genero correctamente</b> para consultar la información clic <a href="reporteClientes?id=<?php echo $_GET['folioCliente']; ?>">Aquí</a>
                </div>
                </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  El cliente no se genero correctamente, si lo deseas contacta con un administrador</a>
                </div>
                </div>
  <?php } ?>
    <!-- Main content -->
    <form action="" method="POST" autocomplete="off">
    <section class="content">

      <div class="container-fluid">

        <div class="card card-default">

          <div class="card-header">
            <h3 class="card-title">Datos del cliente</h3>
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
                  <label>Nombre comercial Cliente</label>
                 <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" placeholder="Nombre del cliente">
                 <input type="hidden" id="altaCliente" name="altaCliente" value="altaCliente">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Situación del cliente</label>
                  <select class="custom-select form-control-border" id="situacionCliente" name="situacionCliente" required>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Entidad Federativa</label>
                  <?php 
                  $query = 'SELECT clave, nombreEstado from estados';
                            $res = mysqli_query($con,$query);
                  ?>
                  <select class="form-control select2 select2" id="entidadFederativa" name="entidadFederativa">
                    <option value="">- Selecciona un Estado -</option>
                                <?php
                                while ($estados = mysqli_fetch_array($res)) {
                                    echo '<option value="' . $estados['clave'] . '">'.$estados['nombreEstado']. '</option>';
                                }
                                ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Municipio o Delegación</label>
                  <select class="custom-select form-control-border" id="municipioDelegacion" name="municipioDelegacion">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Dirección Completa</label>
                  <input type="text" class="form-control" id="direccionCompleta" name="direccionCompleta" placeholder="Calle, colonia, municipio y Estado">
                </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                  <label>Código postal</label>
                  <input type="number" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="Código postal a 5 digitos numericos">
                </div>
              </div>
            </div>

  <div class="row">
    <div class="col-12 col-md-12"> 
      <label>Teléfono y email</label>
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field2">
              <tr>
                <td><input type="text" name="telefono[]" placeholder="Ingrese su telefono" class="form-control name_list" /></td>
                <td><input type="text" name="email[]" placeholder="Ingrese su email" class="form-control name_list" /></td>
                <td><button type="button" name="add2" id="add2" class="btn btn-success">Agregar +</button></td>
              </tr>
            </table>
          </div>
      </div>
    </div>
  </div>


 <div class="row">
    <div class="col-md-12"> 
      <!-- Contenido -->
      <div class="form-group">
        <form name="add_name" id="add_name">
          <div class="table-responsive">
            <table class="table table-striped projects" id="dynamic_field">
                  <tr>
                    <th>Nombre del programa</th>
                    <th>Sub-grupo</th>
                    <th>Monto Autorizado</th>
                    <th>Contribución Inicial</th>
                    <th>Co-pago</th>
                    <th></th>
                  </tr>

              <tr>
                <td><input type="text" name="programa[]" placeholder="Nombre del Programa" class="form-control name_list" /></td>
                <td><input type="text" name="subgrupo[]" placeholder="Sub-grupo" class="form-control name_list" /></td>
                <td><input type="text" name="montoautorizadocliente[]" placeholder="Ingrese monto autorizado" class="form-control name_list" /></td>
                <td><input type="text" name="contribucion[]" placeholder="Ingrese el monto de la contribución inicial" class="form-control name_list" /></td>
                <td><input type="text" name="copago[]" placeholder="Ingrese el monto de Co-pago" class="form-control name_list" /></td>
                <td><button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
              </tr>
            </table>
          </div>
        </form>
      </div>

    </div>
  </div>

  <div class="row">
        <div class="col-sm-12">
        <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Importante!</h5>
                  A continuación coloca los datos de facturación del cliente
                </div>
                </div>. </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Razón social</label>
                 <input type="text" class="form-control" id="razonSocial" name="razonSocial" placeholder="Razón social">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>RFC</label>
                  <input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Entidad Federativa</label>
                  <?php 
                  $query = 'SELECT clave, nombreEstado from estados';
                            $res = mysqli_query($con,$query);
                  ?>
                  <select class="custom-select form-control-border" id="entidadFederativa2" name="entidadFederativa2">
                    <option value="">- Selecciona un Estado -</option>
                                <?php
                                while ($estados = mysqli_fetch_array($res)) {
                                    echo '<option value="' . $estados['clave'] . '">'.$estados['nombreEstado']. '</option>';
                                }
                                ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Municipio o Delegación</label>
                  <select class="custom-select form-control-border" id="municipioDelegacion2" name="municipioDelegacion2">
                  </select>
                </div>
              </div>
            </div>

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Dirección Completa</label>
                  <input type="text" class="form-control" id="direccionCompleta2" name="direccionCompleta2" placeholder="Calle, colonia, municipio y Estado">
                </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                  <label>Código postal</label>
                  <input type="number" class="form-control" id="codigoPostal2" name="codigoPostal2" placeholder="Código postal a 5 digitos numericos">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Regimen de contribuyente</label>
                  <select class="custom-select form-control-border" id="tipoRegimen" name="tipoRegimen" required>
                    <option value="">Selecciona una opción</option>
                    <option value="01">Fisica</option>
                    <option value="02">Moral</option>
                  </select>
                </div>
              </div>
            </div>

            
            <div class="card-footer">
            <button type="submit" class="btn btn-success  ">Generar cliente</button>
            </div>

          </div>
          </div>
        </div>
        </div>

<?php
require_once ("footer.php");
?>

        
    </section>
  </div>
</form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


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

</body>
</html>

<!-- script para cargar los municipios -->
<script type="text/javascript">
    $('#entidadFederativa').on('change', function(){   
    var id = $('#entidadFederativa').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasMunicipios.php',
      data: {'id': id}
    })
    .done(function(listas_municipios){
      $('#municipioDelegacion').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>


<script>
$(document).ready(function(){
  var i=1;
  $('#add').click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="programa[]" placeholder="Nombre del Programa" class="form-control name_list" /></td><td><input type="text" name="subgrupo[]" placeholder="Sub-grupo" class="form-control name_list" /></td><td><input type="text" name="montoautorizadocliente[]" placeholder="Ingrese monto autorizado" class="form-control name_list" /></td><td><input type="text" name="contribucion[]" placeholder="Ingrese el monto de la contribución inicial" class="form-control name_list" /></td><td><input type="text" name="copago[]" placeholder="Ingrese el monto de Co-pago" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });

  
});
</script>

  <script>
$(document).ready(function(){
  var i=1;
  $('#add2').click(function(){
    i++;
    $('#dynamic_field2').append('<tr id="row'+i+'"> <td><input type="text" name="telefono[]" placeholder="Ingrese su telefono" class="form-control name_list" /></td><td><input type="text" name="email[]" placeholder="Ingrese su email" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  
  $(document).on('click', '.btn_remove2', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
});
</script>

<script type="text/javascript">
    $('#entidadFederativa2').on('change', function(){   
    var id = $('#entidadFederativa2').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasMunicipios.php',
      data: {'id': id}
    })
    .done(function(listas_municipios){
      $('#municipioDelegacion2').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>


