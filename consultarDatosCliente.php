<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// agrego la clase
include('class/altaCliente.php');
//creamo el objeto de la orde de venta class
$NuUs = new AltaCliente_class();
if ($_POST) {
$NuUs->editaCliente();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CONSULTA DE CLIENTE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Clientes consulta</li>
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
                  El cliente se actualizo correctamente</b> para consultar la información clic <a href="reporteClientes?id=<?php echo $_GET['folioCliente']; ?>">Aquí</a>
                </div>
                </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  El cliente no se actualizo correctamente, si lo deseas contacta con un administrador</a>
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
            <?php 
                  $idCliente=$_GET['idCliente'];
                  $query1 = "SELECT * from clientes where idCliente=$idCliente";
                  $res1 = mysqli_query($con,$query1);
                  $datoscliente = mysqli_fetch_array($res1);
                  $entidadFederativa=$datoscliente['entidadFederativa'];
                  $municipioDelegacion=$datoscliente['municipioDelegacion'];
                  $situacionCliente=$datoscliente['situacionCliente'];
                  if ($situacionCliente=='1') {$situacionClienteNombre='Activo';} else {$situacionClienteNombre='Inactivo';}

                  ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre comercial Cliente</label>
                 <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" value="<?php echo $datoscliente['nombreCliente'] ?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Situación del cliente</label>
                  <select class="custom-select form-control-border" id="situacionCliente" name="situacionCliente" required>
                    <?php if ($situacionCliente==1) { ?>
                    <option value="1">Activo</option><?php } ?>
                    <?php if ($situacionCliente==2) { ?>
                    <option value="2">Inactivo</option><?php } ?>
                  </select>
                  <input type="hidden" class="form-control" id="situacionClienteAnt" name="situacionClienteAnt" value="<?php echo $situacionCliente ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Entidad Federativa</label>
                  <?php
                  $queryEstados = "SELECT clave, nombreEstado from estados where idEstado=$entidadFederativa";
                  $resEstados = mysqli_query($con,$queryEstados);
                  $estadosResult= mysqli_fetch_array($resEstados);
                  $nombreEstado=$estadosResult['nombreEstado'];

                  $query = "SELECT clave, nombreEstado from estados where idEstado!=$entidadFederativa";
                  $res = mysqli_query($con,$query);
                  ?>
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa">
                    
                    <option value="<?php echo $entidadFederativa ?>"><?php echo $nombreEstado ?></option>
                                   
                  </select>
                  <input type="hidden" class="form-control" id="entidadFederativaAnt" name="entidadFederativaAnt" value="<?php echo $entidadFederativa ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Municipio o Delegación</label>
                  <?php
                  $queryMunicipios = "SELECT clave, nombre from municipios where id=$municipioDelegacion";
                  $resMunicipios = mysqli_query($con,$queryMunicipios);
                  $municipiosResult= mysqli_fetch_array($resMunicipios);
                  $nombreMunicipio=$municipiosResult['nombre'];
                  
                  ?>
                  <select class="custom-select form-control-border" id="municipioDelegacion" name="municipioDelegacion">
                    <?php if ($municipioDelegacion!=0) { ?>
                    <option value="<?php echo $municipioDelegacion ?>"><?php echo $nombreMunicipio ?></option>
                  <?php } ?>
                  </select>
                  <input type="hidden" class="form-control" id="municipioDelegacionAnt" name="municipioDelegacionAnt" value="<?php echo $municipioDelegacion ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Dirección Completa</label>
                  <input type="text" class="form-control" id="direccionCompleta" name="direccionCompleta" value="<?php echo $datoscliente['direccionCompleta'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                  <label>Código postal</label>
                  <input type="number" class="form-control" id="codigoPostal" name="codigoPostal" value="<?php echo $datoscliente['codigoPostal'] ?>" readonly>
                </div>
              </div>
            </div>

              <div class="row">
    <div class="col-12 col-md-12"> 
      <label>Teléfono y email</label>
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field2">
              <?php 
                  $queryCuentas="SELECT * FROM telefonosclientes where idCliente=$idCliente";
                  $resultado=mysqli_query($con,$queryCuentas);
                  while ($extraidoCuentas=mysqli_fetch_array($resultado)) {
                  ?>
                  <tr>
                <td>
                  <input type="hidden" name="idTelefono[]" value="<?php echo $extraidoCuentas['idTelefono'] ?>" class="form-control name_list" readonly/>
                  <input type="text" name="telefonox[]" value="<?php echo $extraidoCuentas['telefono'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="emailx[]" value="<?php echo $extraidoCuentas['email'] ?>" class="form-control name_list" readonly/></td>
                <td></td>
              </tr>
                  <?php } ?>
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
                    <th> Contribución Inicial</th>
                    <th>Co-pago</th>
                    <th></th>
                  </tr>
                  <?php 
                  $queryCuentas="SELECT * FROM montosclientes where idCliente=$idCliente";
                  $resultado=mysqli_query($con,$queryCuentas);
                  while ($extraidoCuentas=mysqli_fetch_array($resultado)){
                  ?>
              <tr>
                <td>
                  <input type="text" name="programaant[]" value="<?php echo $extraidoCuentas['nombreAcuerdo'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="subgrupoant[]" value="<?php echo $extraidoCuentas['subgrupo'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="montoautorizadoclienteant[]" value="<?php echo $extraidoCuentas['montoautorizadocliente'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="contribucionant[]" value="<?php echo $extraidoCuentas['contribucion'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="copagoant[]" value="<?php echo $extraidoCuentas['copago'] ?>" class="form-control name_list" readonly/></td>
                <td></td>
              </tr>
              <?php } ?>
            
            </table>
          </div>
        </form>
      </div>
    
    </div>
  </div>

  <div class="row">
        <div class="col-sm-12">
        <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-check"></i> Importante!</h5>
                  Los datos siguientes son los datos de facturación del Cliente, también puedes editarlos.
                </div>
                </div>
        </div>
            <?php
            $queryFactura="SELECT * FROM datosfacturacioncliente where idCliente=$idCliente";
            $resFactura = mysqli_query($con,$queryFactura);
            $datosfactura = mysqli_fetch_array($resFactura);
            $entidadFederativaFacturacion=$datosfactura['entidadFederativa'];
            $municipioDelegacionFacturacion=$datosfactura['municipioDelegacion'];
            $regimen=$datosfactura['regimen'];
            ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Razón social</label>
                 <input type="text" class="form-control" id="razonSocial" name="razonSocial" value="<?php echo $datosfactura['razonSocial'] ?>" readonly>
                 <input type="hidden" class="form-control" id="razonSocialAnt" name="razonSocialAnt" value="<?php echo $datosfactura['razonSocial'] ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>RFC</label>
                  <input type="text" class="form-control" id="rfc" name="rfc" value="<?php echo $datosfactura['rfc'] ?>" readonly>
                  <input type="hidden" class="form-control" id="rfcAnt" name="rfcAnt" value="<?php echo $datosfactura['rfc'] ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Entidad Federativa</label>
                  <?php
                  $queryEstados = "SELECT clave, nombreEstado from estados where idEstado=$entidadFederativaFacturacion";
                  $resEstados = mysqli_query($con,$queryEstados);
                  $estadosResult= mysqli_fetch_array($resEstados);
                  $nombreEstado=$estadosResult['nombreEstado'];

                  $query = "SELECT clave, nombreEstado from estados where idEstado!=$entidadFederativaFacturacion";
                  $res = mysqli_query($con,$query);
                  ?>
                  <select class="custom-select form-control-border" id="entidadFederativa2" name="entidadFederativa2">
                    <option value="<?php echo $entidadFederativaFacturacion ?>"><?php echo $nombreEstado ?></option>
                  
                  
                  </select>
                  <input type="hidden" class="form-control" id="entidadFederativa2Ant" name="entidadFederativa2Ant" value="<?php echo $entidadFederativaFacturacion ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Municipio o Delegación</label>
                  <?php
                  $queryMunicipios = "SELECT clave, nombre from municipios where id=$municipioDelegacionFacturacion";
                  $resMunicipios = mysqli_query($con,$queryMunicipios);
                  $municipiosResult= mysqli_fetch_array($resMunicipios);
                  $nombreMunicipio=$municipiosResult['nombre'];
                  
                  ?>
                  <select class="custom-select form-control-border" id="municipioDelegacion2" name="municipioDelegacion2">
                    <?php if ($municipioDelegacionFacturacion!=0) { ?>
                    <option value="<?php echo $municipioDelegacion ?>"><?php echo $nombreMunicipio ?></option>
                  <?php } ?>
                  </select>
                  <input type="hidden" class="form-control" id="municipioDelegacion2Ant" name="municipioDelegacion2Ant" value="<?php echo $municipioDelegacion ?>">
                </div>
              </div>
            </div>

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Dirección Completa</label>
                  <input type="text" class="form-control" id="direccionCompleta2" name="direccionCompleta2" value="<?php echo $datosfactura['direccion'] ?>" readonly>
                  <input type="hidden" class="form-control" id="direccionCompleta2Ant" name="direccionCompleta2Ant" value="<?php echo $datosfactura['direccion'] ?>">
                </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                  <label>Código postal</label>
                  <input type="number" class="form-control" id="codigoPostal2" name="codigoPostal2" value="<?php echo $datosfactura['cp'] ?>" readonly>
                  <input type="hidden" class="form-control" id="codigoPostal2Ant" name="codigoPostal2Ant" value="<?php echo $datosfactura['cp'] ?>">
                </div>
              </div>
            </div>

           <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Regimen de contribuyente</label>
                  <select class="custom-select form-control-border" id="tipoRegimen" name="tipoRegimen" required>
                    <?php if ($regimen=='01') { ?>
                    <option value="01">Fisica</option><?php } ?>
                    <?php if ($regimen=='02') { ?>
                    <option value="02">Moral</option><?php } ?>
                  </select>
                  <input type="hidden" class="form-control" id="tipoRegimenAnt" name="tipoRegimenAnt" value="<?php echo $regimen ?>">
                </div>
              </div>
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


