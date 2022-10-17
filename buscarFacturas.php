<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Busqueda de Facturación</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Modulo de facturación</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del proveedor para buscar facturación</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-sm-6">
                      <!-- radio -->
                      <div class="form-group">
                        <label>Elije un tipo de busqueda</label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="pornombre" id="pornombre">
                          <label class="form-check-label">Nombre del proveedor</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="porrfc" id="porrfc">
                          <label class="form-check-label">RFC del proveedor</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="poruuid" id="poruuid">
                          <label class="form-check-label">UUID de factura</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="porestatus" id="porestatus">
                          <label class="form-check-label">Por estatus</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="porfecha" id="porfecha">
                          <label class="form-check-label">Por fecha de carga</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="porfechaexcel" id="porfechaexcel">
                          <label class="form-check-label">Grupos</label>
                        </div>
                      </div>
                    </div>
            </div>

            <div class="row" id="divnameprovee" style="display: none">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nombre del proveedor</label>
                  <input type="text" class="form-control" id="nameprovee" name="nameprovee" placeholder="Coloca el nombre del proveedor">             
                </div>
              </div>
            </div>

            <div class="row" id="divrfcprovee" style="display: none">
              <div class="col-md-12">
                <div class="form-group">
                  <label>RFC del proveedor</label>
                  <input type="text" class="form-control" id="rfcprovee" name="rfcprovee" placeholder="Coloca el RFC del proveedor">             
                </div>
              </div>
            </div>

            <div id="divdatos" style="display: none">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Estado</label>
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
                  <label>Tipo de atención</label>
                  <select class="custom-select form-control-border" id="tipoatencion" name="tipoatencion">
                  <option value="">Elige una opción</option>
                  <option value="Medicamentos">Medicamentos</option>
                  <option value="Consulta Medica">Consulta Medica</option>
                  <option value="Servicios Auxiliares">Servicios Auxiliares</option>
                  <option value="Hospitalizacion">Hospitalización</option>
                  </select>            
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Situación del proveedor</label>
                  <select class="custom-select form-control-border" id="situacionProveedor" name="situacionProveedor">
                    <option value="">Elige una situación</option>
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
                    <option value="">Elige una situación</option>
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
                    <div class="col-sm-12" id="target" style="display: none">
                    <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Ups!</h5>
                  No hay resultados en tu busqueda</a>
                </div>
                </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button type="button" class="btn btn-info" onclick='buscarproveedor()'>Encontrar proveedor</button>              
                </div>
              </div>
            </div>
            <form action="buscarFacturasDetalle" method="POST">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nombre del proveedor</label>
                  <select class="custom-select form-control-border" id="noProveedor" name="noProveedor" required>
                  </select>               
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Buscar facturas del proveedor</button>
          </div>
          </form>
          </div>
            
            <div id="divuuid" style="display: none">
            <form action="buscarFacturasDetalleUUID" method="POST">
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>UUID de la factura</label>
                  <input type="text" class="form-control" id="uuid" name="uuid" placeholder="Coloca el UUID de la factura">          
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Buscar facturas por uuid</button>
          </div>
          </form> 
          </div>

          <div id="divestatus" style="display: none">
            <form action="buscarFacturasDetalleEstatus" method="POST">
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Estatus de la factura</label>
                  <select class="custom-select form-control-border" id="estatus" name="estatus">
                    <option value="10">Validando datos factura</option>
                    <option value="11">Envio de factura</option>
                    <option value="13">En espera de Pago</option>
                    <option value="5">Cancelado</option>
                  </select>          
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Buscar facturas por estatus</button>
          </div>
          </form> 
          </div>

          <div id="divfecha" style="display: none">
            <form action="buscarFacturasDetalleFecha" method="POST">
            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de inicio</label>
                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"  id="fechaInicio" name="fechaInicio"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>             
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de fin</label>
                  <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2" id="fechaFin" name="fechaFin"/>
                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>               
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Buscar facturas por fechas de carga</button>
          </div>
          </form> 
          </div>

          <div id="divfechaexcel" style="display: none">
            <form action="buscarFacturasDetalleFechaExcel" method="POST">
            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de inicio</label>
                  <div class="input-group date" id="reservationdate3" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate3"  id="fechadesde" name="fechadesde"/>
                        <div class="input-group-append" data-target="#reservationdate3" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>             
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de fin</label>
                  <div class="input-group date" id="reservationdate4" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate4" id="fechahasta" name="fechahasta"/>
                        <div class="input-group-append" data-target="#reservationdate4" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>               
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Descargar Excel</button>
          </div>
          </form> 
          </div>
           


          </div>          
        </div>
        </div>
    </section>
 
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
        format: 'YYYY-MM-DD'
    });
    $('#reservationdate2').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#reservationdate3').datetimepicker({
        format: 'YYYY-MM-DD'
    });
      $('#reservationdate4').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'YYYY-MM-DD hh:mm A'
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
      format: 'YYYY-MM-DDs'
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
    function buscarproveedor() { 
    var name = $('#nameprovee').val();
    var rfc = $('#rfcprovee').val();
    var id = $('#entidadFederativa').val();
    var tipoatencion = $('#tipoatencion').val();
    var situacionProveedor = $('#situacionProveedor').val();
    var situacionContrato = $('#situacionContrato').val();
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasproveedorfacturas.php',
      data: {'name': name,'rfc': rfc,'id': id,'tipoatencion': tipoatencion,'situacionProveedor':situacionProveedor,'situacionContrato':situacionContrato}
    })
    .done(function(listas_proveedores){
      $('#noProveedor').html(listas_proveedores);
    })
    .fail(function(){
     alert('Sin resultado en la busqueda');
    });
    

  }

</script>
<script>
  $(document).ready(function() {
    $("#pornombre").click(function() {
      $("#divnameprovee").show();
      $("#divrfcprovee").hide();
      $("#divuuid").hide();
      $("#divdatos").show();
      $("#divestatus").hide();
      $("#divfecha").hide();
      $("#divfechaexcel").hide();
    });

    $("#porrfc").click(function() {
      $("#divnameprovee").hide();
      $("#divrfcprovee").show();
      $("#divuuid").hide();
      $("#divdatos").show();
      $("#divestatus").hide();
      $("#divfecha").hide();
      $("#divfechaexcel").hide();
    });

      $("#poruuid").click(function() {
      $("#divrfcprovee").hide();
      $("#divnameprovee").hide();
      $("#divuuid").show();
      $("#divdatos").hide();
      $("#divestatus").hide();
      $("#divfecha").hide();
      $("#divfechaexcel").hide();
    });

      $("#porestatus").click(function() {
      $("#divrfcprovee").hide();
      $("#divnameprovee").hide();
      $("#divuuid").hide();
      $("#divdatos").hide();
      $("#divestatus").show();
      $("#divfecha").hide();
      $("#divfechaexcel").hide();
    });

      $("#porfecha").click(function() {
      $("#divrfcprovee").hide();
      $("#divnameprovee").hide();
      $("#divuuid").hide();
      $("#divdatos").hide();
      $("#divestatus").hide();
      $("#divfecha").show();
      $("#divfechaexcel").hide();
    });

     $("#porfechaexcel").click(function() {
      $("#divrfcprovee").hide();
      $("#divnameprovee").hide();
      $("#divuuid").hide();
      $("#divdatos").hide();
      $("#divestatus").hide();
      $("#divfecha").hide();
      $("#divfechaexcel").show();
    });


  });
</script>

 

