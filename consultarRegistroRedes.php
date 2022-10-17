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
            <h1>CONSULTA DE PROVEEDOR</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Consulta proovedor</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php 
    $idRegistro=$_GET['id'];
    $query2 = "SELECT * from registros where idRegistro=$idRegistro";
    $res2 = mysqli_query($con,$query2);
    $extraido22= mysqli_fetch_array($res2);
    $tipoRegimen=$extraido22['tipoRegimen'];
     if ($tipoRegimen=='01') {$tipoRegimenNombre='Fisica';} else {$tipoRegimenNombre='Moral';}
    $rfcCedula=$extraido22['rfcCedula'];
    $idBanco=$extraido22['idBanco'];
    $cuentaBancaria=$extraido22['cuentaBancaria'];
    $cuentaClabe=$extraido22['cuentaClabe'];
    $rfcRepresentante=$extraido22['rfcRepresentante'];
    $nombreComercial=$extraido22['nombreComercial'];
    $nombreLegal=$extraido22['nombreLegal'];
    $tipoSucursal=$extraido22['tipoSucursal'];
     if ($tipoSucursal=='UN') {$tipoSucursalNombre='Sucursal única';}
     if ($tipoSucursal=='MU') {$tipoSucursalNombre='Más de una sucursal';}
     if ($tipoSucursal=='') {$tipoSucursalNombre='Elije un tipo de sucursal';} 
    $situacionProveedor=$extraido22['situacionProveedor'];
     if ($situacionProveedor=='1') {$situacionProveedorNombre='Activo';} else {$situacionProveedorNombre='Inactivo';}
    $situacionContrato=$extraido22['situacionContrato'];
    $modoAtencion=$extraido22['modoAtencion'];
     if ($modoAtencion=='N') {$modoAtencionNombre='Nacional';}
     if ($modoAtencion=='E') {$modoAtencionNombre='Estatal';}
     if ($modoAtencion=='') {$modoAtencionNombre='Elije un tipo de atención';}
    $noSucursal=$extraido22['noSucursal'];
    $fechaInicioOperaciones=$extraido22['fechaInicioOperaciones'];
    if ($fechaInicioOperaciones=='0000-00-00') {$fechaInicioOperaciones='';} 
    $fechaUltimoCambio=$extraido22['fechaUltimoCambio'];
    if ($fechaUltimoCambio=='0000-00-00') {$fechaUltimoCambio='';} 
    $entidadFederativa=$extraido22['entidadFederativa'];
    $municipioDelegacion=$extraido22['municipioDelegacion'];
    $colonia=$extraido22['colonia'];
    $tipoVialidad=$extraido22['tipoVialidad'];
    $nombreVialidad=$extraido22['nombreVialidad'];
    $noExterior=$extraido22['noExterior'];
    $noInterior=$extraido22['noInterior'];
    $codigoPostal=$extraido22['codigoPostal'];
    $email=$extraido22['email'];
    $emailCor=$extraido22['emailCor'];
    $emailDir=$extraido22['emailDir'];
    $telefonoOpe=$extraido22['telefonoOpe'];
    $telefonoCor=$extraido22['telefonoCor'];
    $telefonoDir=$extraido22['telefonoDir'];
    $administradorLocal=$extraido22['administradorLocal'];  
    $ejecutivoCuenta=$extraido22['ejecutivoCuenta'];
    $tipoAtencion=$extraido22['tipoAtencion'];
    $fechaAltaRed=$extraido22['fechaAltaRed'];
    if ($fechaAltaRed=='0000-00-00') {$fechaAltaRed='';}

    ?>
    <!-- Main content -->
    <form action="" method="POST" autocomplete="off">
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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Regimen de contribuyente</label>
                  <select class="custom-select form-control-border" id="tipoRegimen" name="tipoRegimen">
                    <option value="<?php echo $tipoRegimen ?>"><?php echo $tipoRegimenNombre ?></option>
                  </select>
                  <input type="hidden" id="actualizaGestionRedes" name="actualizaGestionRedes" value="actualizaGestionRedes">
                  <input type="hidden" id="idRegistro" name="idRegistro" value="<?php echo $idRegistro ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="card-body" id="rfcCuenta">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>RFC</label>
                  <input type="text" class="form-control" id="rfcCedula" name="rfcCedula" value="<?php  echo $rfcCedula ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Cuenta Bancaria</label>
                  <input type="text" class="form-control" id="cuentaBancaria" name="cuentaBancaria" value="<?php echo $cuentaBancaria ?>" readonly>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Banco</label>
                  <?php
                  $queryBancos1 = "SELECT idBanco,NombreBanco from bancos where idBanco=$idBanco";
                  $resBancos1 = mysqli_query($con,$queryBancos1);
                  $bancoSingular= mysqli_fetch_array($resBancos1);
                  $NombreBanco=$bancoSingular['NombreBanco'];

                  $queryBancos = "SELECT idBanco, NombreBanco from bancos where idBanco!=$idBanco";
                  $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="idBanco" name="idBanco">
                  <option value="<?php echo $idBanco ?>"><?php echo $NombreBanco ?></option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Cuenta CLABE</label>
                  <input type="text" class="form-control" id="cuentaClabe" name="cuentaClabe" value="<?php echo $cuentaClabe ?>" readonly>
                </div>
                </div>
              </div>
            </div>
        </div>

        <div class="card card-default" id="segundoOrden" >
          <div class="card-header">
            <h3 class="card-title">Segundo orden (detalle)</h3>
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
                  <input type="text" class="form-control" id="rfcRepresentante" name="rfcRepresentante" value="<?php echo $rfcRepresentante?>" readonly>
                </div>
                <div class="form-group">
                  <label>Nombre legal del proveedor</label>
                  <input type="text" class="form-control" id="nombreLegal" name="nombreLegal" value="<?php echo $nombreLegal?>" readonly>
                </div>
                <div class="form-group">
                  <label>Situación del proveedor</label>
                  <select class="custom-select form-control-border" id="situacionProveedor" name="situacionProveedor">
                    <?php if ($situacionProveedor==1) { ?>
                    <option value="1">Activo</option><?php } ?>
                    <?php if ($situacionProveedor==2) { ?>
                    <option value="2">Inactivo</option><?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Modo de atención</label>
                  <select class="custom-select form-control-border" id="modoAtencion" name="modoAtencion">
                    <option value=""><?php echo $modoAtencionNombre ?></option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Fecha de inicio de operaciones</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaInicioOperaciones" name="fechaInicioOperaciones" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $fechaInicioOperaciones ?>" readonly>
                  </div>                
                </div>
                <div class="form-group">
                  <label>Entidad Federativa</label>
                  <?php
                  $queryEstados = "SELECT clave, nombreEstado from estados where idEstado=$entidadFederativa";
                  $resEstados = mysqli_query($con,$queryEstados);
                  $estadosResult= mysqli_fetch_array($resEstados);
                  $nombreEstado=$estadosResult['nombreEstado'];
                  ?>
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa">
                    <?php if ($entidadFederativa!=0) { ?>
                    <option value="<?php echo $entidadFederativa ?>"><?php echo $nombreEstado ?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Colonia</label>
                  <input type="text" class="form-control" id="colonia" name="colonia" value="<?php  echo $colonia ?>" readonly>
                </div>

                <div class="form-group">
                  <label>Nombre de la vialidad</label>
                  <input type="text" class="form-control" id="nombreVialidad" name="nombreVialidad" value="<?php echo $nombreVialidad ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Número interior</label>
                  <input type="text" class="form-control" id="noInterior" name="noInterior" value="<?php echo $noInterior ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Email operativo</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Email dirección</label>
                  <input type="email" class="form-control" id="emailDir" name="emailDir" value="<?php echo $emailDir ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Teléfono Coordinador</label>
                  <input type="number" class="form-control" id="telefonoCor" name="telefonoCor" value="<?php echo $telefonoCor ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Ejecutivo de cuenta</label>
                  <input type="text" class="form-control" id="ejecutivoCuenta" name="ejecutivoCuenta" value="<?php echo $ejecutivoCuenta ?>" readonly>
                </div>

                <div class="form-group">
                  <label>Fecha de alta en red </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaAltaRed" name="fechaAltaRed" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $fechaAltaRed ?>" readonly>
                  </div>
                </div>

              </div>


              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre comercial del proveedor</label>
                  <input type="text" class="form-control" id="nombreComercial" name="nombreComercial" value="<?php echo $nombreComercial?>" readonly>
                </div>
                <div class="form-group">
                  <label>Tipo de sucursal</label>
                  <select class="custom-select form-control-border" id="tipoSucursal" name="tipoSucursal">
                    <option value=""><?php echo $tipoSucursalNombre ?></option> </select>
                </div>
                <div class="form-group">
                  <label>Situación del contrato</label>
                  <?php
                  $queryContratos = "SELECT idSituacionContrato,situacion from situacioncontrato where idSituacionContrato=$situacionContrato";
                  $resContratos = mysqli_query($con,$queryContratos);
                  $Contratos= mysqli_fetch_array($resContratos);
                  $situacion=$Contratos['situacion'];
                  ?>
                  <select class="custom-select form-control-border" id="situacionContrato" name="situacionContrato">
                  <option value="<?php echo $situacionContrato ?>"><?php echo $situacion ?></option>
                  </select>
                </div>
                <div class="form-group">
                  <label># Sucursal</label>
                  <input type="text" class="form-control" id="noSucursal" name="noSucursal" value="<?php echo $noSucursal?>" readonly>
                </div>


                <div class="form-group">
                  <label>Fecha de ultimo cambio de situación </label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaUltimoCambio" name="fechaUltimoCambio" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $fechaUltimoCambio?>" readonly>
                  </div>
                  <!-- /.input group -->
                </div>

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
                </div>

                <div class="form-group">
                  <label>Tipo de vialidad</label>
                  <input type="text" class="form-control" id="tipoVialidad" name="tipoVialidad" value="<?php  echo $tipoVialidad ?>" readonly>
                </div>
                
                <div class="form-group">
                  <label>Número exterior</label>
                  <input type="number" class="form-control" id="noExterior" name="noExterior" value="<?php echo $noExterior ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Código postal</label>
                  <input type="number" class="form-control" id="codigoPostal" name="codigoPostal" value="<?php  echo $codigoPostal ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Email Coordinador</label>
                  <input type="email" class="form-control" id="emailCor" name="emailCor" value="<?php echo $emailCor ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Teléfono operativo</label>
                  <input type="number" class="form-control" id="telefonoOpe" name="telefonoOpe" value="<?php echo $telefonoOpe ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Teléfono Dirección</label>
                  <input type="number" class="form-control" id="telefonoDir" name="telefonoDir" value="<?php echo $telefonoDir ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Administrador local</label>
                  <input type="text" class="form-control" id="administradorLocal" name="administradorLocal" value="<?php echo $administradorLocal ?>" readonly>
                </div>
              </div>
            </div>

  <div class="row">
    <div class="col-12 col-md-12"> 
      <label>Teléfonos adicionales</label>
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <?php 
            $query2 = "SELECT * from telefonosproveedores where idRegistro=$idRegistro";
            $res2 = mysqli_query($con,$query2);
            while ($extraido22= mysqli_fetch_array($res2)) {
            ?>
              <tr>
                <td>
                  <input type="text" name="tipoTelefono[]" value="<?php echo $extraido22['tipoTelefono'] ?>" class="form-control name_list" readonly></td>
                <td><input type="text" name="telefonoadic[]" value="<?php echo $extraido22['telefono'] ?>"  class="form-control name_lis" readonly/></td>
                <td><input type="text" name="extension[]" value="<?php echo $extraido22['extension'] ?>" class="form-control name_list" readonly/></td>
              </tr>
            <?php } ?>
            </table>
          </div>
      </div>
    </div>
  </div>





            <div class="row">
              <div class="col-md-6">
                 <div class="form-group">
                  <label>Tipo de atención</label>
                  <input type="text" class="form-control" id="administradorLocal" name="administradorLocal" value="<?php echo $tipoAtencion ?>" readonly>
                
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