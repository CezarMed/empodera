<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaBeneficiarios.php');
//creamos el objeto de la orde de venta class
$NuUs = new AltaBenefeciarios_class();
if ($_POST) {
$NuUs->altaBenefeciarios();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ALTA DE BENEFICIARIO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Alta de benefeciario</li>
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
                  El beneficiario se genero correctamente</b> con el número <b><?php echo $_GET['folio']; ?></b> para consultar la información clic <a href="editaBenefeciarios?id=<?php echo $_GET['folio']; ?>">Aquí</a>
        </div>
      </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  El beneficiario no se genero correctamente, si lo deseas contacta con un administrador</a>
        </div>
      </div>
  <?php } ?>


    <!-- Main content -->
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Alta de beneficiarios</h3>
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
                  <label>Nombre(s)</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nombreBeneficiario" name="nombreBeneficiario" placeholder="Nombre del beneficiario">
                    <input type="hidden" id="altaBenefeciarios" name="altaBenefeciarios" value="altaBenefeciarios">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Apellido Paterno</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="apeliidoPaternoBeneficiario" name="apeliidoPaternoBeneficiario" placeholder="Apellido del beneficiario">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Apellido Materno</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="apeliidoMaternoBeneficiario" name="apeliidoMaternoBeneficiario" placeholder="Apellido del beneficiario">
                  </div>                
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Buscar</label>
                  <div class="input-group">
                    <button type="button" class="btn btn-success"  onclick="buscaBeneficiario()">Buscar coincidencias</button>
                  </div>                
                </div>
              </div>
            </div>
            <div class="row" id="tablaListado">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-sm-12" id="tabladatos">
                  </div>
                  </div>                
                </div>
              </div>
          </div>          
        </div>

          <div class="card card-default" id="datosDomicilio" style="display: none">
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
                  <label>Cliente</label>
                  <?php 
                  $query='SELECT idCliente, nombreCliente from clientes where estatus=1';
                            $res = mysqli_query($con,$query);
                  ?>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="idCliente" name="idCliente" onchange="buscaCuentas()">
                    <option value="">- Selecciona un Cliente -</option>
                  <?php
                    while ($estados = mysqli_fetch_array($res)) {
                       echo '<option value="' . $estados['idCliente'] . '">'.$estados['nombreCliente']. '</option>';
                    }
                  ?>
                  </select>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                 <div class="col-sm-12" id="tablaResult">
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sexo</label>
                  <select class="custom-select form-control-border" id="sexo" name="sexo">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Genero</label>
                  <select class="custom-select form-control-border" id="genero" name="genero">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
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
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa">
                    <option value="">- Selecciona un Estado -</option>
                                <?php
                                header("Content-Type: text/html;charset=utf-8");
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
                  <label>Calle</label>
                  <input type="text" class="form-control" id="calle" name="calle" placeholder="Nombre de la calle">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Numero interior o exterior</label>
                  <input type="text" class="form-control" id="noExteriorInterior" name="noExteriorInterior" placeholder="Numero interior o exterior (Mz, Lt, etc)">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Colonia (Barrio)</label>
                  <input type="text" class="form-control" name="colonia" id="colonia" placeholder="Nombre de la colonia">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Codigo Postal</label>
                  <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" placeholder="Codigo postal">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (beneficiario)</label>
                  <input type="text" class="form-control" name="telefonoBeneficiario" id="telefonoBeneficiario" placeholder="Telefono del beneficiario">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de quien recibe</label>
                  <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe" placeholder="Nombre de quien recibe">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (Recibe)</label>
                  <input type="text" class="form-control" name="telefonoRecibe" id="telefonoRecibe" placeholder="Telefono de quien recibe">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de nacimiento</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaNac" name="fechaNac" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                  </div>                
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tipo de Programa</label>
                  <select class="custom-select form-control-border" id="tipoPrograma" name="tipoPrograma">
                    <option value="Programa de Salud modelo 1">Programa de Salud modelo 1</option>
                    <option value="Programa de Salud modelo 2">Programa de Salud modelo 2</option>
                    <option value="Programa de Salud modelo 3">Programa de Salud modelo 3</option>
                    <option value="Programa de Salud modelo 4">Programa de Salud modelo 4</option>
                    </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub-grupo</label>
                  <select class="custom-select form-control-border" id="subgrupo" name="subgrupo">
                    <option value="Norte 1">Norte 1</option>
                    <option value="Norte 2">Norte 2</option>
                    </select>
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
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referencias del domicilio</label>
                  <textarea class="form-control" rows="3" id="referencias" name="referencias" placeholder="Referencias del domicilio"></textarea>                
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

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de inicio de cobertura</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaInicio" name="fechaInicio" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
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
                    <input type="text" id="fechaFin" name="fechaFin" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                  </div>                
                </div>
              </div>
            </div>

            

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Generar expediente del beneficiario</button>
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
    function buscaCuentas() { 
    var idCliente = $('#idCliente').val()
        $.ajax({
            url: 'consultas/consultasClientesGrupos',
            type: "POST",
            data: {"idCliente":idCliente},
            success: function (cmb) {
                     //alert(cmb);
                     $('#tablaResult').html(cmb);
                }
        });  
  }
</script>

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
    function buscaBeneficiario() {
      var nombreBeneficiario=$('#nombreBeneficiario').val();
      var apeliidoPaternoBeneficiario=$('#apeliidoPaternoBeneficiario').val();
      var apeliidoMaternoBeneficiario=$('#apeliidoMaternoBeneficiario').val();            
        $.ajax({
            url: 'consultas/consultasBeneficiarios',
            type: "POST",
            data: {"consultasSocios":nombreBeneficiario,"apeliidoPaternoBeneficiario":apeliidoPaternoBeneficiario, "apeliidoMaternoBeneficiario": apeliidoMaternoBeneficiario},
            success: function (cmb) {
                     // alert(cmb);
                     $('#tabladatos').html(cmb);
                
            }
        });      
}
</script>


<script type="text/javascript">
function nuevoBeneficiario() {
  $('#datosDomicilio').show('show');
  $('#avisoSinResultados').hide('hide');
  $('#tablaListado').hide('hide');
}
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



