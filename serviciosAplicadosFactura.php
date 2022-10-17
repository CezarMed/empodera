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
            <h1>SERVICIOS ASIGNADOS A LA FACTURA</h1>
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
  
    <section class="content" id="datosFacturaMonto">
      <div class="container-fluid">
        <div class="card card-default">
         
          <div class="card-header">
            <h3 class="card-title">Servicios asignados a la factura</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
           <?php
            $idFactura=$_GET['idFactura']; 
            // consulto los datos del XML
            $queryBen= "SELECT * from facturasdatosxml fxml
            INNER JOIN formaspago fp on fp.clave=fxml.formaPago
            inner join metodopago mp on mp.clave=fxml.metodoPago
            inner join regimenfiscal rf on rf.clave=fxml.regimenFiscal
            inner join usocfdi cfdi on cfdi.clave=fxml.UsoCFDI
              where fxml.idFacturas=$idFactura";
              $resBen = mysqli_query($con,$queryBen);
              $extraidoBen= mysqli_fetch_array($resBen);
              $rfcEmisor=$extraidoBen['rfcEmisor'];
              $cpEmisor=$extraidoBen['cpEmisor'];
              $usoCFDI=$extraidoBen['descripcionCFDI'];
            // consuto si el CP es identico al de la base de datos, tabla registros
            $queryProveedor="SELECT * from registros where rfcCedula='$rfcEmisor'";
            $resultadoqueryProveedor=mysqli_query($con,$queryProveedor);
            $registros=mysqli_fetch_array($resultadoqueryProveedor);
            $cpRegistro=$registros['codigoPostal'];            
?>

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
                  <label>Fecha de timbrado</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['fechaTimbrado']; ?>" readonly>
                </div>
              </div>              
            </div>



                        <?php 
              // consulto los datos del XML
              $querySer= "SELECT * from servicioscomplementos sf
              INNER JOIN servicios s on s.idServicio=sf.idServicio
              INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario
              INNER JOIN usuarios u on u.idUsuario=sf.idUsuario
              where sf.idFactura=$idFactura and sf.estatus=1";
              $resSer= mysqli_query($con,$querySer);
              $filasSer = mysqli_num_rows($resSer);
          ?>
              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label><font color='red'>SERVICIOS ASIGNADOS A LA FACTURA</font></label>
                </div>
              </div>
            </div>

  <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-striped projects" >
                  <tr>
                    <th>Folio del Servicio</th>
                    <th>Beneficiario</th>
                    <th>Tipo de servicio</th>
                    <th>Observaciones</th>
                    <th>Monto Asociado</th>
                    <th>Asigno</th>
                    <th></th>
                  </tr>

             <?php
             $totalmonto=0;
            while ($extraidoSer= mysqli_fetch_array($resSer)) {
              $totalmonto=$totalmonto+$extraidoSer['montoComplemento'];
              $verdatos=$extraidoSer[0]."|".
                                      $extraidoSer[1]."|".
                                      $extraidoSer[2]."|".
                                      $extraidoSer[3]."|".
                                      $extraidoSer[4]."|".
                                      $extraidoSer[5];

            ?>
              <tr>
                <td><?php echo $extraidoSer['folioEmpodera'] ?></td>
                <td><?php echo $extraidoSer['nombreBeneficiario'] ?></td>
                <td><?php echo $extraidoSer['servicio'] ?></td>
                <td><?php echo $extraidoSer['observaciones'] ?></td>
                <td>$<?php echo number_format($extraidoSer['montoComplemento'], 2, '.', ',')  ?></td>
                <td><font color="red"><?php echo $extraidoSer['usuario'] ?></font></td>
                <td>
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editarFacturaMonto" onclick="agregaform2('<?php echo $verdatos ?>')"><i class="fas fa-edit"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#borrarFacturaMonto" onclick="agregaform('<?php echo $verdatos ?>')"><i class="fas fa-times"></i></button>            
                </td>
              </tr>
            <?php } ?>
            <tr>
                <td colspan="4"></td>
                <td><b>$<?php echo number_format($totalmonto, 2, '.', ',')  ?></b></td>
                <td colspan="2"></td>
              </tr>
            </table>
          </div>

      </div>
    </div>
  </div>

   <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
<a href="<?php echo $extraidoBen['ArchivoXML'] ?>" target="_blanck"><img src="dist/img/iconoxml.png" width="150px" height="250%"></a>
<a href="<?php echo $extraidoBen['ArchivoPDF'] ?>" target="_blanck"><img src="dist/img/iconopdf.png" width="120px" height="200%"></a>
      </div>
    </div>
  </div>

           
          </div>


        </div>
        </div>
    </section>
    

        

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

<script type="text/javascript">
  function agregaform(datos){
    d=datos.split('|');
    $('#idComplemento').val(d[0]);
  }
  function agregaform2(datos){
    d=datos.split('|');
    $('#idComplemento2').val(d[0]);
    $('#montoActual').val(d[4]);

  }
</script>

<div id="borrarFacturaMonto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" name="idComplemento" id="idComplemento">
        <button type="button" class="btn btn-danger" onclick="cancelarMonto()">Cancelar monto de factura</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function cancelarMonto(){
    var idComplemento=$('#idComplemento').val();
                $.ajax({
            url: 'consultas/cancelarMontoFactura.php',
            type: "POST",
            data: {"idComplemento":idComplemento},
            success: function (cmb) {
               // alert(cmb);
               $("#datosFacturaMonto").load(" #datosFacturaMonto");
               $('#borrarFacturaMonto').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' El monto de la factura fue eliminado correctamente'
                    })
                  });
                  });
            }
        });  
      }
</script>

<div id="editarFacturaMonto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD - EDICION DE MONTO -</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" name="idComplemento2" id="idComplemento2">
                <div class="col-md-12">
                <div class="form-group">
                  <label>Monto Asociado</label>
                 <input type="text" class="form-control" id="montoActual" name="montoActual"  readonly>
                  </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Monto nuevo asociado</label>
                 <input type="text" class="form-control"id="montoNuevo" name="montoNuevo" placeholder="Asigna un monto" onkeyup="eliminarEspacio()">
                  </div>
        </div>
        <button type="button" class="btn btn-success" onclick="asignarNuevoMonto()">Asignar nuevo monto</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function asignarNuevoMonto(){
    var idComplemento2=$('#idComplemento2').val();
    var montoActual=$('#montoActual').val();
    var montoNuevo=$('#montoNuevo').val();
    
    if (montoNuevo!=''){
            $.ajax({
            url: 'consultas/asignarNuevoMontoFactura.php',
            type: "POST",
            data: {"idComplemento2":idComplemento2,"montoActual":montoActual, "montoNuevo":montoNuevo},
            success: function (cmb) {
               // alert(cmb);
               $("#datosFacturaMonto").load(" #datosFacturaMonto");
               $('#editarFacturaMonto').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' El copago se ASIGNO correctamente, si queda pendiente aun podra seguir asignandose'
                    })
                  });
                  });
            }
        });
        } else {
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
                      title: ' Es necesario asignar un monto para poder editar'
                    })
                  });
                  });

        }  
 
      }

</script>

<script type="text/javascript">
function eliminarEspacio2(){
var inputs = $("input[type=text]");
 var texto2=$('#montoAsigna').val();
 procesado2=texto2.replace(/\s+/g, '');
 $('#montoAsigna').val(procesado2);
}

function eliminarEspacio(){
 $('input').val(function(_, value) {
       return $.trim(value);
    });
}
</script>

