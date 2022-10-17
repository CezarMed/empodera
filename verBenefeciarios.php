<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaBeneficiarios.php');
//creamo el objeto de la orde de venta class
$NuUs = new AltaBenefeciarios_class();
if ($_POST) {
$NuUs->editaBenefeciarios();
}
$folio=$_GET['id'];

$query = "SELECT * from beneficiarios where codigoBenefeciario='$folio'";
$res = mysqli_query($con,$query);
$registros= mysqli_fetch_array($res);
$idBenefeciario=$registros['idBenefeciario'];
$nombreBeneficiario=$registros['nombreBeneficiario'];
$folioBeneficiario=$registros['folioBeneficiario'];
$calle=$registros['calle'];
$colonia=$registros['colonia'];
$noExteriorInterior=$registros['noExteriorInterior'];
$codigoPostal=$registros['codigoPostal'];
$telefonoBeneficiario=$registros['telefonoBeneficiario'];
$nombreRecibe=$registros['nombreRecibe'];
$telefonoRecibe=$registros['telefonoRecibe'];
$fechaNacimiento=$registros['fechaNacimiento'];
$referencias=$registros['referencias'];
$sexo=$registros['sexo'];
if ($sexo=='M'){$sexo1='Masculino';} else {$sexo1='Femenino';}
$genero=$registros['genero'];
if ($genero=='M'){$genero1='Masculino';} else {$genero1='Femenino';}
$entidadFederativa=$registros['entidadFederativa'];
$municipioDelegacion=$registros['municipioDelegacion'];


?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CONSULTA DE BENEFICIARIO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Consulta de benefeciario</li>
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
                  El beneficiario se actualizo correctamente.
        </div>
      </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  El beneficiario no se actualizo correctamente, si lo deseas contacta con un administrador</a>
        </div>
      </div>
  <?php } ?>


    <!-- Main content -->
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Edicion de beneficiarios</h3>
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
                  <label>Nombre Completo</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nombreBeneficiario" name="nombreBeneficiario" value="<?php echo $nombreBeneficiario ?>" readonly>
                  </div>                
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Folio del Beneficiario</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="folioBeneficiario" name="folioBeneficiario" value="<?php echo $folioBeneficiario ?>" readonly>
                  </div>                
                </div>
              </div>
            </div>
          </div>          
        </div>

          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del domicilio</h3>
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
                  <label>Sexo</label>
                  <select class="custom-select form-control-border" id="sexo" name="sexo">
                    <option value="<?php echo $sexo ?>"><?php echo $sexo1 ?></option>
                    </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Genero</label>
                  <select class="custom-select form-control-border" id="genero" name="genero">
                    <option value="<?php echo $genero ?>"><?php echo $genero1 ?></option>
                    </select>
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
                  ?>
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa">
                    <?php if ($entidadFederativa!=0) { ?>
                    <option value="<?php echo $entidadFederativa ?>"><?php echo $nombreEstado ?></option>
                  <?php }  ?>
                  </select>
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
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Calle</label>
                  <input type="text" class="form-control" id="calle" name="calle" value="<?php echo $calle ?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Numero interior o exterior</label>
                  <input type="text" class="form-control" id="noExteriorInterior" name="noExteriorInterior" value="<?php echo $noExteriorInterior ?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Colonia (Barrio)</label>
                  <input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo $colonia ?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Codigo Postal</label>
                  <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" value="<?php echo $codigoPostal ?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (beneficiario)</label>
                  <input type="text" class="form-control" name="telefonoBeneficiario" id="telefonoBeneficiario" value="<?php echo $telefonoBeneficiario ?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de quien recibe</label>
                  <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe" value="<?php echo $nombreRecibe ?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (Recibe)</label>
                  <input type="text" class="form-control" name="telefonoRecibe" id="telefonoRecibe" value="<?php echo $telefonoRecibe ?>" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de nacimiento</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaNac" name="fechaNac" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $fechaNacimiento ?>" readonly>
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
              <?php 
              $query = "SELECT * from telefonosbeneficiarios where idBeneficiario=$idBenefeciario and estatus=1";
              $res = mysqli_query($con,$query);
                while ($estados = mysqli_fetch_array($res)) { ?>
              <tr>
                <td><input type="text" name="tipoTelefono[]" value="<?php echo $estados['tipoTelefono'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="telefonoadic[]" value="<?php echo $estados['telefono'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="extension[]" value="<?php echo $estados['extension'] ?>" class="form-control name_list" readonly/></td>
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
                  <label>Referencias</label>
                  <textarea class="form-control" rows="3" id="referencias" name="referencias" placeholder="Referencias del domicilio" readonly><?php echo $referencias ?></textarea>                
                </div>
              </div>
            </div>

              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <div class="alert alert-primary alert-dismissible">
                  Las cuentas asignadas al beneficiario son las siguientes:
                </div>
                               
                </div>
              </div>
            </div>


                <div class="row">
    <div class="col-12 col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <?php 
              $query = "SELECT * from beneficiarioscuentas bc 
              inner join montosclientes mc on mc.idMontoCliente=bc.idPrograma
              where bc.idBeneficiario=$idBenefeciario and bc.estatusCuenta=1";
              $res = mysqli_query($con,$query);
                while ($estados = mysqli_fetch_array($res)) { ?>
              <tr>
                <td><input type="text" name="tipoTelefono[]" value="<?php echo $estados['nombreAcuerdo'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="telefonoadic[]" value="<?php echo $estados['subgrupo'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="extension[]" value="<?php echo $estados['montoautorizadocliente'] ?>" class="form-control name_list" readonly/></td>
              </tr>
            <?php } ?>
            </table>
          </div>
      </div>
    </div>
  </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <div class="alert alert-info alert-dismissible">
                  Las fechas siguientes son aplicadas para el periodo de validación de solicitud de servicios
                </div>
                               
                </div>
              </div>
            </div>

            <?php 
            $query = "SELECT * from periodosbeneficiarios where idBeneficiario=$idBenefeciario and estatus=1";
            $res = mysqli_query($con,$query);
            $registros= mysqli_fetch_array($res);
            $fechaInicial=$registros['fechaInicial'];
            $fechaFin=$registros['fechaFin'];
            $hoy=date('Y-m-d');
            ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de inicio de cobertura</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaInicio1" name="fechaInicio1" class="form-control" value="<?php echo $fechaInicial ?>" readonly>
                  </div>                
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de fin de cobertura</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaFin1" name="fechaFin1" class="form-control"value="<?php echo $fechaFin ?>" readonly>
                  </div>                
                </div>
              </div>
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
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
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

<script type="text/javascript">
function showContent() {
    element = document.getElementById("nuevoPeriodo");
    check = document.getElementById("checkboxPrimary2");
    if (checkboxPrimary2.checked) {
        element.style.display='block';
    }
    else {
        element.style.display='none';
    }
}
</script>

<script type="text/javascript">
    $('#idCliente').on('change', function(){   
    var idCliente = $('#idCliente').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasClientesGrupos.php',
      data: {'idCliente': idCliente}
    })
    .done(function(listas_municipios){
      $('#subGrupoCliente').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>

<script type="text/javascript">
    $('#subGrupoCliente').on('change', function(){   
    var subGrupoCliente = $('#subGrupoCliente').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasClientesSubgrupos.php',
      data: {'subGrupoCliente': subGrupoCliente}
    })
    .done(function(listas_municipios){
      $('#subGrupoPrograma').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>
