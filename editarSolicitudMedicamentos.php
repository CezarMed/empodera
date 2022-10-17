<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaMedicamentos.php');
$NuUs = new AltaMedicamentos_class();
if ($_POST) {
$NuUs->actualizaMedicamentos();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>EDICION DE SOLICITUD DE MEDICAMENTOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Medicamentos solicitud edición</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
    <section class="content">

      <div class="container-fluid">

        <div class="card card-default">
          <?php 
            $idSolicitudMedicamentos=$_GET['idSolicitudMedicamentos'];            
            $query2 = "SELECT sm.*, s.idServicio, b.nombreBeneficiario, s.folioEmpodera  from solicitudmedicamentos sm
            INNER JOIN servicios s on s.idServicio=sm.idServicio
            INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario
            where idSolicitudMedicamentos=$idSolicitudMedicamentos
            GROUP BY sm.idServicio";
            $res2 = mysqli_query($con,$query2);
            $extraido2= mysqli_fetch_array($res2);
            $idSolicitudMedicamentos=$extraido2['idSolicitudMedicamentos'];
            $calle=$extraido2['calle'];
            $entidadFederativa=$extraido2['entidadFederativa'];
            $municipioDelegacion=$extraido2['municipioDelegacion'];
            $noExteriorInterior=$extraido2['noExteriorInterior'];
            $colonia=$extraido2['colonia'];
            $codigoPostal=$extraido2['codigoPostal'];
            $telefonoBeneficiario=$extraido2['telefonoBeneficiario'];
            $nombreRecibe=$extraido2['nombreRecibe'];
            $telefonoRecibe=$extraido2['telefonoRecibe'];
            $fechaCargo=$extraido2['fechaCargo'];
            $recetaArchivo=$extraido2['recetaArchivo']; 
            $referencias=$extraido2['referencias']; 
          ?>

          <div class="card-header">
            <h3 class="card-title">Solicitud de Medicamentos </h3>
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
                  <label>Nombre completo</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nombreSolicitante" name="nombreSolicitante" value="<?php echo $extraido2['nombreBeneficiario'] ?>" readonly>
                    <input type="hidden" id="actualizaMedicamentos" name="actualizaMedicamentos" value="actualizaMedicamentos">
                    <input type="hidden" id="idSolicitudMedicamentos" name="idSolicitudMedicamentos" value="<?php echo $idSolicitudMedicamentos ?>">
                  </div>                
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de solicitud</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaSolicitud" name="fechaSolicitud" class="form-control" value="<?php echo $extraido2['fechaCargo'] ?>" readonly>
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Folio de Servicio</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="folioEmpodera" name="folioEmpodera" value="<?php echo $extraido2['folioEmpodera']?>" readonly>
                  </div>                
                </div>
              </div>

            </div>
          </div>          
        </div>



        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del envio</h3>
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
                    <?php if ($entidadFederativa!=0) { ?>
                    <option value="<?php echo $entidadFederativa ?>"><?php echo $nombreEstado ?></option>
                  <?php } else { ?>
                  <option value="">- Selecciona un Estado -</option>
                  <?php } ?>
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
                  <input type="text" class="form-control" id="calle" name="calle" value="<?php echo $calle?>">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Numero interior o exterior</label>
                  <input type="text" class="form-control" id="noExteriorInterior" name="noExteriorInterior" value="<?php echo $noExteriorInterior?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Colonia (Barrio)</label>
                  <input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo $colonia?>">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Codigo Postal</label>
                  <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" value="<?php echo $codigoPostal?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (beneficiario)</label>
                  <input type="text" class="form-control" name="telefonoBeneficiario" id="telefonoBeneficiario" value="<?php echo $telefonoBeneficiario?>" >
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de quien recibe</label>
                  <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe" value="<?php echo $nombreRecibe?>" >
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (Recibe)</label>
                  <input type="text" class="form-control" name="telefonoRecibe" id="telefonoRecibe" value="<?php echo $telefonoRecibe?>"  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referencias</label>
                  <textarea class="form-control" rows="3" id="referencias" name="referencias"><?php echo $referencias ?></textarea>                
                </div>
              </div>
            </div>
          </div>                 
        </div>


        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Medicamentos</h3>
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
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <thead>
              <tr>
                <td><label>Medicamento</label></td>
                <td><label>Gramaje</label></td>
                <td><label>Presentación</label></td>
                <td><label>Cantidad</label></td>
                <td><label>Fecha Termina</label>
                </td>
                <td></td>
              </tr>
              </thead>
              <tbody>
                <?php 
            $queryMedicamento2 = "SELECT ms.* FROM solicitudmedicamentos sm
              INNER JOIN medicamentossolicitados ms on ms.idSolicitudMedicamento=sm.idSolicitudMedicamentos
              where sm.idSolicitudMedicamentos=$idSolicitudMedicamentos and ms.estatus=1";
            $resMedicamento2 = mysqli_query($con,$queryMedicamento2);
            $i=0; 
            while ($medicamentos22 = mysqli_fetch_array($resMedicamento2)) {

              $i++;
              ?>
              <tr>
                <td>
                  <input type="hidden" class="form-control" name="idMedicamento[]" value="<?php echo $medicamentos22['idMedicamento']; ?>"><input type="text" class="form-control" name="nombre[]" placeholder="Medicamento" value="<?php echo $medicamentos22['medicamento']; ?>"></td>
                <td><input type="text" class="form-control" name="gramaje[]" value="<?php echo $medicamentos22['gramaje']; ?>"></td>
                <td><input type="text" class="form-control" name="presentacion[]" value="<?php echo $medicamentos22['presentacion']; ?>"></td>
                <td><input type="text" class="form-control" name="cantidad[]" value="<?php echo $medicamentos22['cantidad']; ?>"></td>
                <td><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fechaTermina" name="fechaTermina[]" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $medicamentos22['fechaTermina']; ?>">
                  </div></td>
                <td><select class="custom-select form-control-border" id="activoR" name="activoR[]" required>
                    <option value="1">Activo</option>
                    <option value="5">Quitar de la lista</option>
                  </select></td>
              </tr>
            <?php } ?>
            <tr>
                <td><input type="text" class="form-control" name="nombreNew[]" placeholder="Medicamento"></td>
                <td><input type="text" class="form-control" name="gramajeNew[]" placeholder="Gramaje"></td>
                <td><input type="text" class="form-control" name="presentacionNew[]" placeholder="Presentacion"></td>
                <td><input type="text" class="form-control" name="cantidadNew[]" placeholder="Cantidad"></td>
                <td><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fechaTerminaNew" name="fechaTerminaNew[]" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                  </div>
                </td>
                <td><button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
              </tr>
              </tbody>
            </table>
          </div>        
      </div>
    </div>
  </div>
          </div>
        </div>




          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Receta</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <?php 
          $sqlFile="SELECT * from archivosrecetasmedicamentos ar
                    where ar.idsolicitudMedicamento=$idSolicitudMedicamentos and ar.estatus=1";
          $resFile = mysqli_query($con,$sqlFile);
          $archivosnum=mysqli_num_rows($resFile);
          ?>
          <div class="card-body">
              <?php if ($archivosnum==0) { ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo(s) de receta (WORD,EXCEL,PDF,JPG,PNG)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept=".doc,.docx,.xls,.xlsx,.pdf,.jpg,.png" placeholder="Subir archivo">                        
                      </div>
                    </div>
                  </div>
              </div>
              </div>
              <?php } else { ?>
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo de receta actual</label>
                    <div class="input-group">
                      <?php while ($filaFile = mysqli_fetch_array($resFile)) { ?>
                        <a href="<?php echo $filaFile['archivo'] ?>" target="_new">
                          <img src="dist/img/iconfile.png"></a> 
                        <?php } ?> 
                    </div>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">Si requieres cambiar la Receta (WORD,EXCEL,PDF,JPG,PNG)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept=".doc,.docx,.xls,.xlsx,.pdf,.jpg,.png" placeholder="Subir archivo para reemplazar actual">                        
                      </div>
                    </div>
                  </div>
              </div>
              </div>
              <?php } ?>

            </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Guardar cambios en solicitud de medicamentos</button>
            </div> 
          </div>
        </div>
      </section>

  </div>
</form>
    <!-- /.content -->
  </div>
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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>

<script>
$(document).ready(function(){
  var i=1;
  $('#add').click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="form-control" name="nombreNew[]" placeholder="Medicamento"></td><td><input type="text" class="form-control" name="gramajeNew[]" placeholder="Gramaje"></td><td><input type="text" class="form-control" name="presentacionNew[]" placeholder="Presentacion"></td><td><input type="text" class="form-control" name="cantidadNew[]" placeholder="Cantidad"></td><td><div class="input-group-prepend"></div><input type="text" class="form-control" id="fechaTerminaNew" name="fechaTerminaNew[]" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
});
</script>

<script type="text/javascript">
    $('#entidadFederativa').on('change', function(){   
    var id = $('#entidadFederativa').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasMunicipios',
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


        <?php if ($_GET['do']==1) { ?>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 4000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'success',
        title: ' La solicitud de medicamentos se actualizo correctamente'
      })
    });
    });
</script>
  <?php } ?>

  <?php 
if ($_GET['do']=='2') { ?>
<script>
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
        title: ' La solicitud de medicamentos no pudo actualizarse, revisa no contenga comillas simples o dobles'
      })
    });
    });
</script>
<?php } ?>