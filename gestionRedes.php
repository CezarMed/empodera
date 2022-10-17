<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// traemos la clase para agregar el proveedor
include('class/altaGestionRedes.php');
//creamo el objeto de la orde de venta class
$NuUs = new AltaGestion_class();
if ($_POST) {
$NuUs->altaGestion();
}
?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>MODULO DE GESTIÓN DE PROVEEDORES </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Registro</li>
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
                  El registro se cargo correctamente con el folio <b><?php echo $_GET['folio']; ?></b> para consultar la información clic <a href="registrosGR?noProveedor=<?php echo $_GET['folio']; ?>">Aquí</a>
        </div>
      </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  El registro no se cargo correctamente, si lo deseas contacta con un administrador</a>
        </div>
      </div>
  <?php } ?>
      <?php if ($_GET['do']==5) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  El beneficiario no se genero correctamente, porque el RFC <b><?php echo $_GET['rfc']; ?></b> ya existe</a>
        </div>
      </div>
  <?php } ?>



    <!-- Main content -->
    
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Primer orden (minimos) </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
       <div class="alert alert-danger counter_input" id="rfcNoDisponible" style="display: none">
    <strong><center>    EL RFC YA TIENE REGISTRO EN PLATAFORMA POR LO CUAL NO PODRA SER PROCESADO, CONTACTA A UN ADMINISTRADOR. 
    <form action="registrosGR.php" method="GET">
    <input type="hidden" name="noProveedor" id="noProveedor">
    <button type="submit" class="btn btn-success">Buscar información del proveedor</button>
    <button type="button" class="btn btn-info" onclick="mostrarSegundoOrden()">Agregar sucursal</button>
  </form>
</center>
  </strong>
</div>
<form action="" method="POST" autocomplete="off">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Regimen de contribuyente</label>
                  <select class="custom-select form-control-border" id="tipoRegimen" name="tipoRegimen">
                    <option value="">Selecciona una opción</option>
                    <option value="01">Fisica</option>
                    <option value="02">Moral</option>
                  </select>
                  <input type="hidden" id="altaGestionRedes" name="altaGestionRedes" value="altaGestionRedes">
                </div>
              </div>
            </div>
          </div>



            <div class="card-body" id="rfcCuenta" style="display: none">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>RFC</label>
                  <input type="text" class="form-control" id="rfcCedula" name="rfcCedula" placeholder="Cédula de identificación fiscal" onchange='buscaSocio()'>
                  <input type="hidden" id="altaGestionRedes" name="altaGestionRedes" value="altaGestionRedes">  
                  <input type="hidden" id="tipoRegistro" name="tipoRegistro" value="1">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Banco</label>
                  <?php 
                  $queryBancos = 'SELECT idBanco, NombreBanco from bancos where estatus=1';
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="idBanco" name="idBanco">
                  <option value="">Selecciona un Banco</option>
                                <?php
                                while ($bancos = mysqli_fetch_array($resBancos)) {
                                    echo '<option value="' . $bancos['idBanco'] . '">'.$bancos['NombreBanco']. '</option>';
                                }
                                ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Cuenta Bancaria</label>
                  <input type="text" class="form-control" id="cuentaBancaria" name="cuentaBancaria" placeholder="Cuenta Bancaria">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Cuenta CLABE</label>
                  <input type="text" class="form-control" id="cuentaClabe" name="cuentaClabe" placeholder="Cuenta CLABE">
                </div>
              </div>
            </div>

                        <div class="alert alert-success counter_input" id="rfcDisponible" style="display: none">
    <strong><center>    EL RFC NO TIENE REGISTRO EN PLATAFORMA PUEDES CONTINUAR CON EL REGISTRO  </center></strong>
</div>
            <div class="alert alert-success counter_input" id="divTipoSucursal" style="display: none">
    <strong><center>    EL RFC TIENE REGISTRO EN PLATAFORMA PUEDES CONTINUAR CON EL REGISTRO POR MEDIO DE UN TIPO DE REGISTRO SUCURSAL </center></strong>
</div>
        </div>
            </section>


    <section class="content">
        <div class="card card-default" id="segundoOrden" style="display: none">
          <div class="card-header">
            <h3 class="card-title">Segundo orden (detalle) </h3>

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
                  <label>RFC</label>
                  <input type="text" class="form-control" id="rfcRepresentante" name="rfcRepresentante" placeholder="RFC a 13 posiciones del Representante Legal">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre comercial del proveedor</label>
                  <input type="text" class="form-control" id="nombreComercial" name="nombreComercial" placeholder="Nombre comercial" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre legal del proveedor</label>
                  <input type="text" class="form-control" id="nombreLegal" name="nombreLegal" placeholder="Nombre legal del proveedor">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Tipo de sucursal</label>
                  <select class="custom-select form-control-border" id="tipoSucursal" name="tipoSucursal">
                    <option value="">Elije un tipo de sucursal</option>
                    <option value="UN">Sucursal única</option>
                    <option value="MU">Más de una sucursal</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Situación del proveedor</label>
                  <select class="custom-select form-control-border" id="situacionProveedor" name="situacionProveedor">
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Situación del contrato</label>
                  <?php
                  $queryContratos2 = "SELECT idSituacionContrato,situacion from situacioncontrato where estatus=1";
                  $resContratos2 = mysqli_query($con,$queryContratos2);
                  ?>
                  <select class="custom-select form-control-border" id="situacionContrato" name="situacionContrato">
                          <?php
                           while ($contratos2 = mysqli_fetch_array($resContratos2)) {
                              echo '<option value="' . $contratos2['idSituacionContrato'] . '">'.$contratos2['situacion']. '</option>';
                            }
                          ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Modo de atención</label>
                  <select class="custom-select form-control-border" id="modoAtencion" name="modoAtencion">
                    <option value="">Elije un tipo de atención</option>
                    <option value="N">Nacional</option>
                    <option value="E">Estatal</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label># Sucursal</label>
                  <input type="text" class="form-control" id="noSucursal" name="noSucursal" placeholder="Número de Sucursal a 4 digitos">
                </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de inicio de operaciones</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaInicioOperaciones" name="fechaInicioOperaciones" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                  </div>                
                </div>
              </div>

              <div class="col-md-6">
                                <div class="form-group">
                  <label>Fecha de ultimo cambio de situación </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaUltimoCambio" name="fechaUltimoCambio" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                  </div>
                  <!-- /.input group -->
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
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa">
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
                  <label>Colonia</label>
                  <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia">
                </div>
              </div>

              <div class="col-md-6">
         <div class="form-group">
                  <label>Tipo de vialidad</label>
                  <input type="text" class="form-control" id="tipoVialidad" name="tipoVialidad" placeholder="Tipo de vialidad">
                </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de la vialidad</label>
                  <input type="text" class="form-control" id="nombreVialidad" name="nombreVialidad" placeholder="Nombre de la vialidad">
                </div>
              </div>

              <div class="col-md-6">
              <div class="form-group">
                  <label>Número exterior</label>
                  <input type="text" class="form-control" id="noExterior" name="noExterior" placeholder="Número exterior">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Número interior</label>
                  <input type="text" class="form-control" id="noInterior" name="noInterior" placeholder="Número interior">
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
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email operativo</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico">
                </div>
              </div>
              <div class="col-md-6">
             <div class="form-group">
                  <label>Email Coordinador</label>
                  <input type="email" class="form-control" id="emailCor" name="emailCor" placeholder="Correo electrónico coorporativo">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                  <label>Email dirección</label>
                  <input type="email" class="form-control" id="emailDir" name="emailDir" placeholder="Correo electrónico directivo">
                </div>
              </div>
              <div class="col-md-6">
                             
                <div class="form-group">
                  <label>Teléfono operativo</label>
                  <input type="text" class="form-control" id="telefonoOpe" name="telefonoOpe" placeholder="Teléfono operativo">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                  <label>Teléfono Coordinador</label>
                  <input type="text" class="form-control" id="telefonoCor" name="telefonoCor" placeholder="Teléfono coordinador">
                </div>
              </div>
              <div class="col-md-6">

                <div class="form-group">
                  <label>Teléfono Dirección</label>
                  <input type="text" class="form-control" id="telefonoDir" name="telefonoDir" placeholder="Teléfono dirección">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                  <label>Ejecutivo de cuenta</label>
                  <input type="text" class="form-control" id="ejecutivoCuenta" name="ejecutivoCuenta" placeholder="Ejecutivo de cuenta">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Administrador local</label>
                  <input type="text" class="form-control" id="administradorLocal" name="administradorLocal" placeholder="Administrador local">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de alta en red </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaAltaRed" name="fechaAltaRed" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                  </div>
                </div>
              </div>
            </div>

                <div class="row">
    <div class="col-12 col-md-12"> 
      <label>Teléfonos adicionales</label>
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <tr>
                <td><input type="text" name="tipoTelefono[]" placeholder="Ingrese el tipo de Telefono" class="form-control name_list" /></td>
                <td><input type="text" name="telefonoadic[]" placeholder="Ingrese su telefono" class="form-control name_list" /></td>
                <td><input type="text" name="extension[]" placeholder="Ingrese su extension" class="form-control name_list" /></td>
                <td><button type="button" name="add" id="add" class="btn btn-success">Agregar +</button></td>
              </tr>
            </table>
          </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-6 col-md-6"> 
      <label>Tipos de Atención del proveedor</label>
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <tr>
              <td>MEDICAMENTOS</td>
              <td>
              <input type="hidden" name="tipoAtencionValor[]" value="1">
              <select class="custom-select form-control-border" id="tipoAtencion" name="tipoAtencion[]">
              <option value="5">No</option>
              <option value="1">Si</option>
              </select></td>
              </tr>
              <tr>
              <td>CONSULTA MEDICA</td>
              <td>
              <input type="hidden" name="tipoAtencionValor[]" value="2">
              <select class="custom-select form-control-border" id="tipoAtencion" name="tipoAtencion[]">
              <option value="5">No</option>
              <option value="1">Si</option>
              </select></td>
              </tr>
              <tr>
              <td>SERVICIOS AUXILIARES</td>
              <td>
              <input type="hidden" name="tipoAtencionValor[]" value="3">
              <select class="custom-select form-control-border" id="tipoAtencion" name="tipoAtencion[]">
              <option value="5">No</option>
              <option value="1">Si</option>
              </select></td>
              </tr>
              <tr>
              <td>HOSPITALIZACION</td>
              <td>
              <input type="hidden" name="tipoAtencionValor[]" value="4">
              <select class="custom-select form-control-border" id="tipoAtencion" name="tipoAtencion[]">
              <option value="5">No</option>
              <option value="1">Si</option>
              </select></td>
              </tr>
              <tr>
              <td>ENFERMERIA</td>
              <td>
              <input type="hidden" name="tipoAtencionValor[]" value="5">  
              <select class="custom-select form-control-border" id="tipoAtencion" name="tipoAtencion[]">
              <option value="5">No</option>
              <option value="1">Si</option>
              </select></td>
              </tr>
            </table>
          </div>
      </div>
    </div>
  </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Guardar proveedor</button>
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
<!-- script para mostrar el rfc y cuenta bancaria si elige o no tipo de contribuyente-->
<script type="text/javascript">
$( function() {
    $("#tipoRegimen").change( function() {
        if ($(this).val() == "") {
            //$("#btnEnv").prop("disabled", true);
            $("#rfcCuenta").hide("slow");
        } else {
            //$("#btnEnv").prop("disabled", false);
            
            $("#rfcCuenta").show("show");
        }
    });
});
</script>


<!-- script para validar el rfc cargado -->
<script type="text/javascript">
    function buscaSocio() {
    var rfc= $('#rfcCedula').val();
    var tiporegimen= $('#tipoRegimen').val();
    var tamano=rfc.length;

    if (tiporegimen==='01'){
      if (tamano===13){
        $.ajax({
            url: 'consultas/consultasSocios',
            type: "POST",
            data: {"consultasSocios":rfc},
            success: function (cmb) {
                // alert(cmb);
                if (cmb!='') {
                    var Data=cmb.split("-");
                    $('#rfcDisponible').hide('hide');
                    $('#rfcNoDisponible').show('show');
                    $('#segundoOrden').hide('hide');
                    $("#noProveedor").val(Data[0]);
                } if (cmb==''){
                  // alert(cmb);
                    $('#rfcDisponible').show('show');
                    $('#rfcNoDisponible').hide('hide');
                    $('#segundoOrden').show('show');
                }
            }
        });
      }  else {
        $("#miModal").modal("show");
        $('#segundoOrden').hide('hide');
        $('#rfcDisponible').hide('hide');
        //alert("El numero de caracteres deben de ser 13");
    }

    } 

    if (tiporegimen==='02'){
      if (tamano===12){
        $.ajax({
            url: 'consultas/consultasSocios',
            type: "POST",
            data: {"consultasSocios":rfc},
            success: function (cmb) {
                // alert(cmb);
                if (cmb!='') {
                    var Data=cmb.split("-");
                    $('#rfcDisponible').hide('hide');
                    $('#rfcNoDisponible').show('show');
                    $('#segundoOrden').hide('hide');
                    $("#noProveedor").val(Data[0]);
                } if (cmb==''){
                  // alert(cmb);
                    $('#rfcDisponible').show('show');
                    $('#rfcNoDisponible').hide('hide');                    
                    $('#segundoOrden').show('show');
                }
            }
        });
      }  else {
        $("#miModal2").modal("show");
        $('#segundoOrden').hide('hide');
        $('#rfcDisponible').hide('hide');
      // alert("El numero de caracteres deben de ser 12");
    }

    } 

}

function mostrarSegundoOrden() {
$('#segundoOrden').show('show');
$('#rfcNoDisponible').hide('hide');
$('#divTipoSucursal').show('show');
$("#tipoRegistro").val(2);
}   
</script>

</body>
</html>


<div id="miModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>El RFC del registro debe de contar con <b>13 caracateres</b> alfanumericos para el Regimen <b>Persona fisica</b>, es necesario colocarlo para continuar con el registro.</p>
      </div>
    </div>
    </div>
    </div>

    <div id="miModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>El RFC del registro debe de contar con <b>12 caracateres</b> alfanumericos para el Regimen <b>Persona Moral</b>, es necesario colocarlo para continuar con el registro.</p>
      </div>
    </div>
    </div>
    </div>

   <script>
    // con este script evito que se envie el formulario por medio del enter
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('input[type=text]').forEach( node => node.addEventListener('keypress', e => {
        if(e.keyCode == 13) {
          e.preventDefault();
        }
      }))
    });
  </script>


  <script>
$(document).ready(function(){
  var i=1;
  $('#add').click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"> <td><input type="text" name="tipoTelefono[]" placeholder="Ingrese el tipo de Telefono" class="form-control name_list" /></td><td><input type="text" name="telefonoadic[]" placeholder="Ingrese su telefono" class="form-control name_list" /></td><td><input type="text" name="extension[]" placeholder="Ingrese su extension" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
});
</script>
