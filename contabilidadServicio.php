<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaComplementoPago.php');
//creamo el objeto de la orde de venta class
$NuUs = new altaComplemento_class();
if ($_POST) {
$NuUs->altaComplemento();
}
// recojo el id servicio
$idServicio=$_GET['idServicio'];

//consulto para obtener el nombre del beneficiario
$idBeneficiario=$_GET['idBeneficiario'];
$idServicio=$_GET['idServicio'];
$query="SELECT * FROM beneficiarios where idBenefeciario=$idBeneficiario";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$nombreBene=$registro['nombreBeneficiario'];
$fechaNac=$registro['fechaNacimiento'];
$sexo=$registro['sexo'];
$genero=$registro['genero'];
list($anio, $mes, $dia) = explode("-", $fechaNac);
$yearh=date('Y');
//obtengo los datos del servicio
$querys="SELECT * FROM servicios where idServicio=$idServicio";
$ress = mysqli_query($con,$querys);
$registros = mysqli_fetch_array($ress);
$folioServicio=$registros['folioEmpodera'];
$servicio=$registros['servicio'];
$montoAutorizadoServicio=$registros['monto'];
$hoy=date('Y-m-d');

$queryProvee="SELECT * from servicioscerradosproveedor where idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $proveedorname=$extraidoProvee['proveedorname'];

    // OBTENGO EL NOMBRE DEL PROVEEDOR
    $queryProvee = "SELECT * from registros
                where idRegistro=$proveedorname";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $nombreComercial=$extraidoProvee['nombreComercial']; 
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CONTABILIDAD DEL SERVICIO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Contabilidad del Servicio</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
<?php require_once ("encabezadoServicios.php"); ?>
      <!-- Main content -->
    <section class="content" id="datosFacturaMonto">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos contables del servicio</h3>
          </div>
            <?php
              $querys="SELECT * FROM beneficiarios b 
              INNER JOIN clientes cli ON cli.idCliente=b.idCliente
              INNER JOIN montosclientes mc ON mc.idMontoCliente=b.subGrupoCliente
              where b.idBenefeciario=$idBeneficiario";
              $resd = mysqli_query($con,$querys);
              $registros = mysqli_fetch_array($resd);
            ?>
          <form action="" method="POST" autocomplete="off">
          <div class="card-body">
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                <font color="red"><label>DATOS DEL SERVICIO</label></font>
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" class="form-control" id="monto" name="monto" value="Monto Autorizado para el Servicio" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" class="form-control" id="monto" name="monto" value="$<?php echo $montoAutorizadoServicio ?>" readonly>
                </div>
              </div>
              </div>        

            <div class="row" >
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" class="form-control" id="monto" name="monto" value="Dictamen generado por:" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" class="form-control" id="monto" name="monto" value="$<?php echo $montoFacturable ?>" readonly>
                </div>
              </div>
              </div>
              <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                <hr>
                </div>
              </div>
            </div>


            
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                <hr>
                </div>
              </div>
            </div>
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                <font color="red"><label>DATOS DE FACTURACIÓN</label></font>
                </div>
              </div>
            </div>

             <div class="row" >
              <div class="col-md-12">
                        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          Monto aplicado
                      </th>
                      <th>
                          Monto de la factura
                      </th>
                      <th>
                          UUID
                      </th>
                      <th>
                          Concepto
                      </th>
                      <th>
                          
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                <?php 
                $totalfacturado=0;
                   $queryFac="SELECT * FROM servicioscomplementos sc 
                   left join facturasdatosxml fxml on fxml.idFacturas=sc.idFactura
                   where sc.idServicio=$idServicio and sc.estatus=1";
                   $res = mysqli_query($con,$queryFac);
                          while ($registro = mysqli_fetch_array($res)) {
                          $totalfacturado=$totalfacturado+$registro['montoComplemento'];  
                          $verdatos=$registro[0]."|".
                                      $registro[1]."|".
                                      $registro[2]."|".
                                      $registro[3]."|".
                                      $registro[4]."|".
                                      $registro[5];
                  ?>
                  <tr>
                    <td>
                          <a>
                              $<?php echo $registro['montoComplemento'] ?>
                          </a>
                      </td>
                      <td>
                          <a>
                              $<?php echo $registro['Total'] ?>
                          </a>
                      </td>
                      <td>
                          <a>
                              <?php echo $registro['UUID'] ?>
                          </a>
                      </td>
                      <td>
                          <?php echo $registro['tipoComplemento'] ?>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#borrarFacturaMonto" onclick="agregaform('<?php echo $verdatos ?>')"><i class="fas fa-times"></i></button>
                      </td>
                  </tr>

                <?php } ?>
                  <tr>
                      <th>$<?php echo $totalfacturado ?></th>
                      <th colspan="4"><font color="green">MONTO TOTAL APLICADO EN FACTURAS</font></th>
                  </tr>
              </tbody>
          </table>
          
        </div>
              </div>
            </div>
<br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="callout callout-success">
                    <h5><i class="fas fa-credit-card"></i> MONTO PENDIENTE POR FACTURAR <br><font color="red" size="18">$<?php echo number_format($montoAutorizadoServicio-$totalfacturado, 2, '.', ',') ?></font></h5>
                    
                  </div>
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

</script>
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



