<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
//consulto para obtener el nombre del beneficiario
$idBeneficiario=$_GET['idBeneficiario'];
$idServicio=$_GET['idServicio'];
$idCuenta=$_GET['idCuenta'];

if ($_POST){
// print_r ($_POST);
$motivocancela=$_POST['motivocancela'];
$idServicio=$_POST['idServicio'];
$query="UPDATE servicios SET estatus=5, motivocancela='$motivocancela' where idServicio=$idServicio";
mysqli_query($con,$query);
// cancelo los copagos
$queryCopagosCount="SELECT * FROM copagosasignados ca 
                  inner join archivoscopagos ac on ac.idCopago=ca.idCopago  
                  where ca.idServicio=$idServicio and ca.estatus=1";
$resCopagosCount = mysqli_query($con,$queryCopagosCount); 
while ($copagosCount = mysqli_fetch_array($resCopagosCount)){
    $idCopagoAsignado=$copagosCount['idCopagoAsignado'];
    $idCopago=$copagosCount['idCopago'];
    $montoActual=$copagosCount['montoSaldo'];
    $montoAsignado=$copagosCount['montoAsignado'];
    $saldoNuevo=$montoActual+$montoAsignado;
    // cancelo los copagos
    $cancelaCopago="UPDATE copagosasignados SET estatus=5 where idCopagoAsignado=$idCopagoAsignado";
    $resCopagoAsignado=mysqli_query($con,$cancelaCopago);
    // regreso el dinero
    $updateCopago="UPDATE archivoscopagos SET montoSaldo='$saldoNuevo' where idCopago=$idCopago";
    $resUpdateCopago=mysqli_query($con,$updateCopago);
}

// cancelo las contribuciones iniciales
$queryCopagosCount="SELECT * FROM contribucionesasignadas ca 
                  inner join archivoscontribucion ac on ac.idCopago=ca.idCopago  
                  where ca.idServicio=$idServicio and ca.estatus=1";
$resCopagosCount = mysqli_query($con,$queryCopagosCount); 
while ($copagosCount = mysqli_fetch_array($resCopagosCount)){
    $idCopagoAsignado=$copagosCount['idCopagoAsignado'];
    $idCopago=$copagosCount['idCopago'];
    $montoActual=$copagosCount['montoSaldo'];
    $montoAsignado=$copagosCount['montoAsignado'];
    $saldoNuevo=$montoActual+$montoAsignado;
    // cancelo los copagos
    $cancelaCopago="UPDATE contribucionesasignadas SET estatus=5 where idCopagoAsignado=$idCopagoAsignado";
    $resCopagoAsignado=mysqli_query($con,$cancelaCopago);
    // regreso el dinero
    $updateCopago="UPDATE archivoscontribucion SET montoSaldo='$saldoNuevo' where idContribucion=$idCopago";
    $resUpdateCopago=mysqli_query($con,$updateCopago);
}
?>
<script type="text/javascript">
  window.location = "agregarServiciosBeneficiario?do=6&idBeneficiario=<?php echo $idBeneficiario ?>&idCuenta=<?php echo $idCuenta ?>";
</script> 
<?php } ?>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CANCELACIÓN DE SERVICIO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Cancelar Servicio</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
<?php require_once ("encabezadoServicios.php"); ?>

    <form action="" method="POST" autocomplete="off">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Cancelar servicio</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body">


           <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <div class="callout callout-warning">
                    <h5><i class="fas fa-credit-card"></i> Contribuciones Iniciales que se van a cancelar</h5>
            <table class="table table-striped projects" id="datosContribucion">
              <thead>
                <?php 

                  $queryCopagosCount = "SELECT count(*) totalPagados FROM contribucionesasignadas ca 
                  inner join archivoscontribucion ac on ac.idContribucion=ca.idCopago  
                  where ca.idServicio=$idServicio and ac.tipocopago='Pagado' and ca.estatus=1";
                  $resCopagosCount = mysqli_query($con,$queryCopagosCount); 
                  $copagosCount = mysqli_fetch_array($resCopagosCount);
                  $totalcontribucionpagadas=$copagosCount['totalPagados'];

                  $queryCopagosCount = "SELECT sum(montoAsignado) totalcontribuciones FROM contribucionesasignadas ca 
                  inner join archivoscontribucion ac on ac.idContribucion=ca.idCopago  
                  where ca.idServicio=$idServicio and ca.estatus=1";
                  $resCopagosCount = mysqli_query($con,$queryCopagosCount); 
                  $copagosCount = mysqli_fetch_array($resCopagosCount);
                  $totalcontribuciones=$copagosCount['totalcontribuciones'];



                  $queryCopagos = "SELECT * FROM contribucionesasignadas ca 
                  inner join archivoscontribucion ac on ac.idContribucion=ca.idCopago  
                  where ca.idServicio=$idServicio";
                  $resCopagos = mysqli_query($con,$queryCopagos); 
                ?>
                  <tr>
                      <th>
                          Tipo de Contribucion
                      </th>
                      <th>
                          Archivo
                      </th>
                      <th>
                          Monto
                      </th>
                      <th>
                          Fecha de asignación
                      </th>                      
                  </tr>
              </thead>
              <tbody>
                  <?php
                  while ($copagos = mysqli_fetch_array($resCopagos)) {
                             $datos2=$copagos[0]."||".
                             $copagos[1]."||".
                             $copagos[2]."||".
                             $copagos[3]."||".
                             $copagos[4]."||".
                             $copagos[5]."||".
                             $copagos[6]."||".
                             $copagos[7]."||".
                             $copagos[8]."||".
                             $copagos[9]."||".
                             $copagos[10]."||".
                             $copagos[11]."||".
                             $copagos[12];

                  ?>
                  <tr>
                    <td><?php echo $copagos['tipocopago'] ?>
                      </td>
                    <td><?php if ($copagos['archivo']!='-'){ ?><a href="<?php echo $copagos['archivo'] ?>" target="_blanck"><img src="dist/img/iconfile.png"></a><?php } ?>
                      </td>
                      <td>$<?php echo $copagos['montoAsignado'] ?><?php if ($copagos['tipocopago']=='Pagado') { ?><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editaContribucion" id="btnView" data-id="<?php echo $registro['idCopago'] ?>" onclick="agregaform2('<?php echo $datos2 ?>')"> <i class="fas fa-edit">
                              </i>
                      </button><?php } ?></td>
                      <td><?php echo $copagos['fechaSubida'] ?></td>
                  </tr>
                <?php } ?>
                </tbody>
          </table>
                  </div>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <div class="callout callout-warning">
                    <h5><i class="fas fa-credit-card"></i> Copagos que se cancelarian</h5>
                    <table class="table table-striped projects" id="datosCopagos">
              <thead>
                <?php
                  $queryCopagosCount = "SELECT count(*) totalPagados FROM copagosasignados ca 
                  inner join archivoscopagos ac on ac.idCopago=ca.idCopago  
                  where ca.idServicio=$idServicio and ac.tipocopago='Pagado' and ca.estatus=1";
                  $resCopagosCount = mysqli_query($con,$queryCopagosCount); 
                  $copagosCount = mysqli_fetch_array($resCopagosCount);
                  $totalPagados=$copagosCount['totalPagados'];

                  $queryCopagos = "SELECT * FROM copagosasignados ca 
                  inner join archivoscopagos ac on ac.idCopago=ca.idCopago  
                  where ca.idServicio=$idServicio and ca.estatus=1";
                  $resCopagos = mysqli_query($con,$queryCopagos); 
                ?>
                  <tr>
                      <th>
                          Tipo de Copago
                      </th>
                      <th>
                          Archivo
                      </th>
                      <th>
                          Monto asignado
                      </th>
                      <th>
                          Fecha de asignación
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                  <?php
                  while ($copagos = mysqli_fetch_array($resCopagos)) {
                    $datos=$copagos[0]."||".
                             $copagos[1]."||".
                             $copagos[2]."||".
                             $copagos[3]."||".
                             $copagos[4]."||".
                             $copagos[5]."||".
                             $copagos[6]."||".
                             $copagos[7]."||".
                             $copagos[8]."||".
                             $copagos[9]."||".
                             $copagos[10]."||".
                             $copagos[11]."||".
                             $copagos[12];
                  ?>
                    <tr>
                    <td><?php echo $copagos['tipocopago'] ?>
                      </td>
                    <td><?php if ($copagos['archivo']!='-'){ ?><a href="<?php echo $copagos['archivo'] ?>" target="_blanck"><img src="dist/img/iconfile.png"></a><?php } ?>
                      </td>
                      <td>$<?php echo $copagos['montoAsignado'] ?>
                      </td>
                      <td><?php echo $copagos['fechaAsigna'] ?></td>
                  </tr>
                <?php } ?>
                </tbody>
          </table>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
              
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Cancelar servicio por:</label>
                  <select class="custom-select form-control-border" id="motivocancela" name="motivocancela" required>
                  <option value="">Elige una opción</option>
                  <option value="Falta de información">Falta de información</option>
                  <option value="Termino de cobertura">Termino de cobertura</option>
                  <option value="Solicitud del beneficiario">Solicitud del beneficiario</option>
                  <option value="Omisiones o inexactas precisiones">Omisiones o inexactas precisiones</option>
                  <option value="Declinado por exclusiones">Declinado por exclusiones</option>
                  <option value="Declinado por enfermedad no cubierta">Declinado por enfermedad no cubierta</option>
                  </select>
                  <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                </div>
              </div>
            </div> 
            <div class="card-footer" id="btnCancelar">
            <button type="submit" class="btn btn-success">Cancelar Servicio</button>
            </div> 
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

<script>
$(document).ready(function(){
  var i=1;
  $('#add').click(function(){
    i++;
    $('#dynamic_field').append('<div class="card-body" id="row'+i+'"><div class="row"><div class="col-md-6"><div class="input-group"><input type="text" class="form-control" name="cie10[]" placeholder="CIE10"></div></div><div class="col-md-4"><div class="input-group"><input type="text" class="form-control" name="diagnosticocie10[]" placeholder="Diagnostico CIE10"></div></div><div class="col-md-2"><div class="input-group"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div></div>');  
  });

  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
});
</script>

<script>
$(document).ready(function(){
  var i=1;
  $('#add2').click(function(){
    i++;
    $('#dynamic_field2').append('<div class="card-body" id="row'+i+'"><div class="row"><div class="col-md-6"><div class="input-group"><input type="text" class="form-control" name="cpt4[]" placeholder="CPT4"></div></div><div class="col-md-4"><div class="input-group"><input type="text" class="form-control" name="tratamientocpt4[]" placeholder="Tratamiento CPT4"></div></div><div class="col-md-2"><div class="input-group"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div></div>');  
  });

  $(document).on('click', '.btn_remove2', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
});
</script>
