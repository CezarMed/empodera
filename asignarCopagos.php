<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaCopagosCuentas.php');
//creamo el objeto de la orde de venta class
$NuUs = new Altacopagos_class();
if ($_POST) {
$NuUs->accionesCopagos();
}
$idBeneficiario=$_GET['idBeneficiario'];
$idCuenta=$_GET['idCuenta'];
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Asignar Copago a un servicio del beneficiario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Cuenta del beneficiario</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

        <?php
    $idBeneficiario=$_GET['idBeneficiario'];
    $idServicio=$_GET['idServicio']; 
    $idCuenta=$_GET['idCuenta']; 
    $query = "SELECT s.montoFacturable,s.servicioprincipal,s.folioEmpodera, s.estatus, s.monto, b.nombreBeneficiario, s.servicio, s.idCuenta from servicios s
    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario 
    where s.idServicio=$idServicio";
    $res = mysqli_query($con,$query);
    $registro = mysqli_fetch_array($res);
    $estatus=$registro['estatus'];
    $servicioprincipal=$registro['servicioprincipal'];
    $pago=$registro['archivoPago'];
    $montoFacturable=$registro['montoFacturable'];
    $idCuenta=$registro['idCuenta'];

    $queryProvee = "SELECT * from servicioscerradosproveedor
                where idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $proveedorname=$extraidoProvee['proveedorname'];

    // OBTENGO EL NOMBRE DEL PROVEEDOR
    $queryProvee = "SELECT * from registros
                where idRegistro=$proveedorname";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $nombreComercial=$extraidoProvee['nombreComercial'];


    $queryProvee = "SELECT * from ordenesdecompra
                where idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $acuseArchivo=$extraidoProvee['acuseArchivo'];

    $queryProvee = "SELECT count(*) totalFacturas from servicioscomplementos
                where idServicio=$idServicio and idFactura!=0";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $totalFacturas=$extraidoProvee['totalFacturas'];

    $queryProvee = "SELECT count(*) totalPagos from pagosfacturas pf
    inner join facturasdatosxml fxml on fxml.idFacturas=pf.idFactura
    inner join servicioscomplementos sc on sc.idFactura=fxml.idFacturas
    where sc.idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $totalPagos=$extraidoProvee['totalPagos'];

    $queryProvee = "SELECT * from dictamenesgenerados
                where idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoDictamen= mysqli_fetch_array($resProvee);
    $totalDictamen=mysqli_num_rows($resProvee);


                              $queryS = "SELECT count(*) totalnotas from notasmedicas
                              where idServicio=$idServicio and estatus=1";
                              $resN = mysqli_query($con,$queryS);
                              $extraidoN= mysqli_fetch_array($resN);
                              $totalnotas=$extraidoN['totalnotas'];
                              // cuento las notas pre operatorias
                              $queryS2 = "SELECT count(*) totalnotas2 from notaspreoperatorias
                              where idServicio=$idServicio and estatus=1";
                              $resN2 = mysqli_query($con,$queryS2);
                              $extraidoN2= mysqli_fetch_array($resN2);
                              $totalnotas2=$extraidoN2['totalnotas2'];
                              // cuento las notas administrstivas
                              $queryS2 = "SELECT count(*) totalnotas3 from notasadministrativas
                              where idServicio=$idServicio and estatus=1";
                              $resN2 = mysqli_query($con,$queryS2);
                              $extraidoN2= mysqli_fetch_array($resN2);
                              $totalnotas3=$extraidoN2['totalnotas3'];
                              // consulto las notas automaticas para sumarlas
                              $queryS2 = "SELECT count(*) totalnotas4 from notasautomaticas
                              where idServicio=$idServicio and estatus=1";
                              $resN2 = mysqli_query($con,$queryS2);
                              $extraidoN2= mysqli_fetch_array($resN2);
                              $totalnotas4=$extraidoN2['totalnotas4'];
                              $notasno= $totalnotas+$totalnotas2+$totalnotas3+$totalnotas4;
      ?>
      <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  El registro se <b>AGREGO</b> correctamente</a>
                </div>
                </div>
  <?php } ?>
        <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Ups!</h5>
                  El registro <b>NO</b> se <b>AGREGO</b> correctamente</a>
                </div>
                </div>
  <?php } ?>
   <?php require_once ("encabezadoServicios.php"); ?>


    <section class="content" id="datosCopagos">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Copagos enviados a la cuenta del Beneficiario</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                    <th>
                          Tipo de Copago
                      </th>
                      <th>
                          Fecha de subida
                      </th>
                      <th>
                          Archivo
                      </th>
                      <th>
                          Monto aprobado
                      </th>
                      <th>
                          Monto disponible
                      </th>
                      <th>
                          Estatus
                      </th>
                      <th>Asignar
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $query="SELECT * from archivoscopagos ac
                            where ac.idBeneficiario=$idBeneficiario and ac.idCuenta=$idCuenta and estatus=2";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $estatus=$registro['estatus'];
                              $datos=$registro[0]."||".
                                     $registro[1]."||".
                                     $registro[2]."||".
                                     $registro[3]."||".
                                     $registro[4]."||".
                                     $registro[5]."||".
                                     $registro[6]."||".
                                     $registro[7]."||".
                                     $registro[8]."||".
                                     $registro[9]."||".
                                     $registro[10]."||".
                                     $registro[11];
                        ?>
                  <tr>
                    <td><?php echo $registro['tipocopago'] ?></td>
                    <td><?php echo $registro['fechaSubida'] ?></td>
                    <td><a href="<?php echo $registro['archivo'] ?>" target="_new"><img src="dist/img/iconfile.png"></a></td>
                    <td><b>$<?php echo number_format($registro['montoAprobado'], 2, '.', ',') ?></b></td>
                    <td><b>$<?php echo number_format($registro['montoSaldo'], 2, '.', ',') ?></b></td>
                    <td><?php if ($estatus==1){echo "Activo";} ?>
                        <?php if ($estatus==2){echo "En proceso";} ?>
                        <?php if ($estatus==3){echo "Asignado";} ?>
                        <?php if ($estatus==4){echo "<font color='red'>Cancelado</font>";} ?>
                    </td>
                    <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#aprobarCopago" id="btnActivate" onclick="agregaform('<?php echo $datos ?>')"> <i class="fas fa-edit">
                              </i>
                      </button>
                    </td>

                  </tr>
                <?php } ?>                  
              </tbody>
          </table>
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
<?php 
if ($_GET['do']=='1') { ?>
echo '<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'success',
        title: ' El copago se envio correctamente aun esta pendiente por autorizar y asignar'
      })
    });
    });
</script>
<?php } ?>

<script type="text/javascript">
  function agregaform(datos){
    d=datos.split('||');
    $('#idCopago').val(d[0]);    
    $('#montoAutoriza').val(d[9]);
  }
</script>

<div id="aprobarCopago" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>ASIGNAR MONTO AL SERVICIO</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="form-group">
                  <label>Monto disponible</label>
                 <input type="number" class="form-control" id="montoAutoriza" name="montoAutoriza"  readonly>
                 <input type="hidden" class="form-control" id="idCopago" name="idCopago">
                 <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                  </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Monto a asignar</label>
                 <input type="text" class="form-control"id="montoAsigna" name="montoAsigna" placeholder="Asigna un monto" onkeyup="eliminarEspacio()">
                  </div>
        </div>

        <button type="button" class="btn btn-success" onclick="asignarCopago()">Asignar</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  function asignarCopago(){
    var montoAsigna=$('#montoAsigna').val();
    var idCopago=$('#idCopago').val();
    var montoAutoriza=$('#montoAutoriza').val();
    var idServicio=$('#idServicio').val();
    

                $.ajax({
            url: 'consultas/asignarCopago.php',
            type: "POST",
            data: {"idCopago":idCopago,"montoAsigna":montoAsigna, "montoAutoriza":montoAutoriza, "idServicio":idServicio},
            success: function (cmb) {
               // alert(cmb);
               $("#datosCopagos").load(" #datosCopagos");
               $('#aprobarCopago').modal('hide');
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