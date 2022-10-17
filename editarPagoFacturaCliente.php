<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/respondeOrdenPago3.php');
$NuUs = new respondeOrdenPago3_class();
if ($_POST) {
$NuUs->responderOrdenPago3();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VALIDACIÓN DE DATOS DE FACTURACIÓN</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Facturación</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
         
          <div class="card-header">
            <h3 class="card-title">Datos de facturación en XML</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
           <?php
            $idFactura=$_GET['idFactura'];
            $idGruposFacturas=$_GET['idGruposFacturas']; 
            // consulto los datos del XML
            $queryBen= "SELECT * from facturasdatosxml fxml
            INNER JOIN formaspago fp on fp.clave=fxml.formaPago
            inner join metodopago mp on mp.clave=fxml.metodoPago
            inner join regimenfiscal rf on rf.clave=fxml.regimenFiscal
            inner join usocfdi cfdi on cfdi.clave=fxml.UsoCFDI
            inner join pagosfacturas pfac on pfac.idFactura=fxml.idFacturas
              where fxml.idFacturas=$idFactura and pfac.estatus=1";
              $resBen = mysqli_query($con,$queryBen);
              $extraidoBen= mysqli_fetch_array($resBen);
            ?>

            <?php if ($extraidoBen['comentarios']!=''){ ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">       
                  <div class="callout callout-success">
                    <h5><i class="fas fa-file"></i> <?php echo $extraidoBen['comentarios'] ?></h5>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color='red'>DATOS DE FACTURA</font></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Total</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['Total'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sub-Total</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['SubTotal']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Fecha de emisión</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['FechaFactura'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Concepto</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['Concepto'] ?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              
              
              <div class="col-md-3">
                <div class="form-group">
                  <label>Folio CFDI</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['Folio'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>UUID</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['UUID'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Fecha de timbrado</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['fechaTimbrado']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Método de Pago</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['descripcion']; ?>" readonly>
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-md-3">
                <div class="form-group">
                  <label>Forma de Pago</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['formaPago'] ?>" readonly>
                </div>
              </div>
              
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color='red'>DATOS DE EMISOR</font></label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>RFC Emisor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['rfcEmisor'] ?>" readonly>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre del emisor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['nombreEmisor']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Regimen fiscal</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['regimenFiscalDescripcion'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Código Postal</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['cpEmisor']; ?>" readonly>
                </div>
              </div>
              
              
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color='red'>DATOS DE RECEPTOR</font></label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>RFC Receptor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['rfcReceptor']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre del receptor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['nombreReceptor']; ?>" readonly>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-group">
                  <label>Uso CFDI</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['descripcionCFDI']; ?>" readonly>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label><font color='red'>IMPUESTOS</font></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tipo de Impuesto</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tasa</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Importe</label>
                </div>
              </div>
            </div>
            <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from facturasdatosxmlimpuestos fi
              inner join impuestos i on i.clave=fi.impuesto
              where fi.UUID='".$extraidoBen['UUID']."'";
              $resBen = mysqli_query($con,$queryBen);
              while ($extraidoImp= mysqli_fetch_array($resBen)) {
            ?>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['descripcionImpuesto'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['tasa'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['importe'] ?>" readonly>
                </div>
              </div>
            </div>
          <?php } ?>
          <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from facturasdatosxmlretenciones xmlr
              inner join impuestos i on i.clave=xmlr.impuesto
              where xmlr.UUID='".$extraidoBen['UUID']."'";
              $resBen = mysqli_query($con,$queryBen);
              $filasRet = mysqli_num_rows($resBen);
              if ($filasRet>=1) { 
          ?>

          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label><font color='red'>RETENCIONES</font></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tipo de Impuesto</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Tasa</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Importe</label>
                </div>
              </div>
            </div>
            <?php
                while ($extraidoImp= mysqli_fetch_array($resBen)) {
            ?>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['descripcionImpuesto'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['tasa'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['importe'] ?>" readonly>
                </div>
              </div>
            </div>
          <?php } } ?>

                        <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from servicioscomplementos sc
              INNER JOIN servicios s on s.idServicio=sc.idServicio
              where sc.idFactura=$idFactura";
              $resSer= mysqli_query($con,$queryBen);
          ?>
              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label>SERVICIOS ELEGIDOS POR EL PROVEEDOR</label>
                </div>
              </div>
            </div>

  <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-striped projects" id="dynamic_field">
                  <tr>
                    <th>Folio del Servicio</th>
                    <th>Tipo de servicio</th>
                    <th>Monto Autorizado</th>
                  </tr>

             <?php
            while ($extraidoSer= mysqli_fetch_array($resSer)) {
            ?>
              <tr >
                <td>
                  <input type="text" name="folioservicio[]" value="<?php echo $extraidoSer['folioEmpodera'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="servicio[]" value="<?php echo $extraidoSer['tipoComplemento'] ?>" class="form-control name_list" readonly/></td>
                <td><input type="text" name="montofacturable[]" value="<?php echo $extraidoSer['montoComplemento'] ?>" class="form-control name_list" readonly/></td>
                <td>
                </td>
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
                  <hr>
                  <label>DATOS DEL PAGO (CONSULTA)</label>
                </div>
              </div>
            </div>

            <div class="row">
              
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo (comprobante de pago)</label>
                    <div class="input-group">
                      <div class="custom-file">

                        <a class="btn btn-warning btn-sm" href="<?php echo $extraidoBen['archivo'] ?>" target="_blanck"><i class="fas fa-file-pdf"></i> Ver archivo
                          </a>
                      </div>
                    </div>
                  </div>
              </div>
             
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referencia de pago</label>
                 <input type="text" class="form-control" id="referenciaPagoAnt" name="referenciaPagoAnt" value="<?php echo $extraidoBen['folioPago'] ?>" readonly>
                </div>
              </div>

              </div>

                <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label>CARGAR ARCHIVO Y FOLIO DEL PAGO (SOLO PARA ACTUALIZAR)</label>
                </div>
              </div>
            </div>
          
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
              
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo (comprobante de pago)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept="image/*,application/pdf" required>
                        <input type="hidden" id="idFactura" name="idFactura" value="<?php echo $idFactura ?>">
                      </div>
                    </div>
                  </div>
              </div>
             
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referencia de pago</label>
                 <input type="text" class="form-control" id="referenciaPago" name="referenciaPago" placeholder="Referencia de Pago" required>
                </div>
              </div>

              </div>

           
          </div>
          <div class="card-footer">
            <input type="hidden" id="autorizaFactura" name="autorizaFactura" value="autorizaFactura">
            <input type="hidden" id="idFactura" name="idFactura" value="<?php echo $idFactura ?>">
            <input type="hidden" id="idGruposFacturas" name="idGruposFacturas" value="<?php echo $idGruposFacturas ?>">
            <button type="submit" class="btn btn-success">Actualizar pago factura</button>
          </div>
        </div>
        </div>
    </section>
    </form>


        

  </div>

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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>