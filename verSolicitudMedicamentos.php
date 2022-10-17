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
            <h1>CONSULTA DE SOLICITUD DE MEDICAMENTOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Medicamentos solicitud consulta</li>
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
                  <?php } ?>
                                
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
                  <input type="text" class="form-control" id="calle" name="calle" value="<?php echo $calle?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Numero interior o exterior</label>
                  <input type="text" class="form-control" id="noExteriorInterior" name="noExteriorInterior" value="<?php echo $noExteriorInterior?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Colonia (Barrio)</label>
                  <input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo $colonia?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Codigo Postal</label>
                  <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" value="<?php echo $codigoPostal?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (beneficiario)</label>
                  <input type="text" class="form-control" name="telefonoBeneficiario" id="telefonoBeneficiario" value="<?php echo $telefonoBeneficiario?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de quien recibe</label>
                  <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe" value="<?php echo $nombreRecibe?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (Recibe)</label>
                  <input type="text" class="form-control" name="telefonoRecibe" id="telefonoRecibe" value="<?php echo $telefonoRecibe?>"  readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referencias</label>
                  <textarea class="form-control" rows="3" id="referencias" name="referencias" readonly><?php echo $referencias ?></textarea>                
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
            <div class="row" id="dynamic_field">
            <?php 
            $queryMedicamento2 = "SELECT ms.* FROM solicitudmedicamentos sm
              INNER JOIN medicamentossolicitados ms on ms.idSolicitudMedicamento=sm.idSolicitudMedicamentos
              where sm.idSolicitudMedicamentos=$idSolicitudMedicamentos";
            $resMedicamento2 = mysqli_query($con,$queryMedicamento2);
            $i=0; 
            while ($medicamentos22 = mysqli_fetch_array($resMedicamento2)) {
              $i++;
              ?>
              <div class="card-body" id="<?php echo "row".$i; ?>">
                <div class="row">
                <div class="col-md-4">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="nombre[]" value="<?php echo $medicamentos22['medicamento']; ?>" readonly>
                   
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="gramaje[]" value="<?php echo $medicamentos22['gramaje']; ?>" readonly>
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="presentacion[]" value="<?php echo $medicamentos22['presentacion']; ?>" readonly>
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="cantidad[]" value="<?php echo $medicamentos22['cantidad']; ?>" readonly>
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" id="fechaTermina" name="fechaTermina[]" value="<?php echo $medicamentos22['fechaTermina']; ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask readonly>
                  </div>                
                </div>
              </div>
              </div>
              </div>
             <?php }  ?>
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
          <div class="card-body">
                      <?php 
          $sqlFile="SELECT * from archivosrecetasmedicamentos ar
                    where ar.idsolicitudMedicamento=$idSolicitudMedicamentos and ar.estatus=1";
          $resFile = mysqli_query($con,$sqlFile);
          $archivosnum=mysqli_num_rows($resFile);
          if ($archivosnum==0) { ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo(s) de receta</label>
                    <div class="input-group">
                      <div class="custom-file">
                        SIN ARCHIVOS CARGADOS A LA SOLICITUD                  
                      </div>
                    </div>
                  </div>
              </div>
              </div>
              <?php } else { ?>
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo(s) de receta</label>
                    <div class="input-group">
                     <?php while ($filaFile = mysqli_fetch_array($resFile)) { ?>
                        <a href="<?php echo $filaFile['archivo'] ?>" target="_new">
                          <img src="dist/img/iconfile.png"></a> 
                        <?php } ?> 
                    </div>
                  </div>
              </div>
              </div>
              <?php } ?>

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

</body>
</html>

