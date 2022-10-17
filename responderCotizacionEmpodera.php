<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/respondeCotizacion.php');
$NuUs = new respondeCotizacion_class();
if ($_POST) {
$NuUs->responderCotizacionEmpodera();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ELEGIR COTIZACIÓN DE MEDICAMENTOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Medicamentos solicitud (Cotización)</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <?php 
    $idRegistro=$_GET['idSolicitudMedicamentos'];
    $query5 = "SELECT count(*) as totalmedicamentos from medicamentossolicitados where idSolicitudMedicamento=$idRegistro";
    $res5 = mysqli_query($con,$query5);
    $extraido5= mysqli_fetch_array($res5);
    $totalmedicamentos=$extraido5['totalmedicamentos'];

    $query2 = "SELECT * from solicitudmedicamentos sm 
    INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
    INNER JOIN servicios s on s.idServicio=sm.idServicio 
    where idSolicitudMedicamentos=$idRegistro";
    $res2 = mysqli_query($con,$query2);
    $extraido22= mysqli_fetch_array($res2);
    $idSolicitudMedicamentos=$extraido22['idSolicitudMedicamentos'];
    $folioSolicitud=$extraido22['folioSolicitud'];
    $nombreSolicitante=$extraido22['nombreBeneficiario'];
    $fechaSolicitud=$extraido22['fechaAlta'];
    $calle=$extraido22['calle'];
    $noExteriorInterior=$extraido22['noExteriorInterior']; 
    $folioEmpodera=$extraido22['folioEmpodera'];  
    $idServicio=$extraido22['idServicio'];    
    ?>

  <form action="" method="POST" autocomplete="off">
    <section class="content">
      <div class="container-fluid">

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos de la solicitud de medicamentos</h3>
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
                  <label>Datos del Servicio</label>
                  <p>Solicitud del servicio <b><?php echo $folioEmpodera ?></b> para el solicitante <b><?php echo $nombreSolicitante ?></b> con fecha de solicitud <b><?php echo $fechaSolicitud ?></b></p>
                  
                </div>
              </div>
            </div>
            </div> 
          </div>
          

          

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos de la solicitud de medicamentos</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            
            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped projects">
                  <tr>
                    <input type="hidden" name="totalmedicamentos" id="totalmedicamentos" value="<?php  echo $totalmedicamentos ?>">
              <input type="hidden" name="idSolicitudMedicamentos" id="idSolicitudMedicamentos" value="<?php  echo $idRegistro ?>">
              <input type="hidden" name="idServicio" id="idServicio" value="<?php  echo $idServicio ?>">
              <input type="hidden" name="responderCotizacionEmpodera" id="responderCotizacionEmpodera" value="responderCotizacionEmpodera">
                    <td>Re-cotizar</td>
                    <td>Nombre del Medicamento</td>
                    <?php 
                    $queryProveedores="SELECT * from solicitudcotizaciones sc 
                    inner join registros r  on r.idRegistro=sc.idProveedor
                    where sc.idSolicitudMedicamentos=$idSolicitudMedicamentos";
                    $resproveedores=mysqli_query($con,$queryProveedores); 
                     while ($registromedicamentos=mysqli_fetch_array($resproveedores)) {
                       $idCotizacion=$registromedicamentos['idCotizacion']; 
                    ?>
                    <td align="right"><?php echo $registromedicamentos['nombreComercial'] ?></td>
                  <?php } ?>

                  </tr>
                <?php
                $queryMedicamentos="SELECT * from medicamentossolicitados ms where ms.idSolicitudMedicamento=$idSolicitudMedicamentos";
                $res=mysqli_query($con,$queryMedicamentos); 
                while ($registromedicamentos=mysqli_fetch_array($res)) { 
                  $idProducto=$registromedicamentos['idMedicamento'];
                  ?>
            <tr>
              <td><center>
                      <input type="checkbox" class="form-check-input" id="recotizar" name="recotizar[]" value="<?php echo $registromedicamentos['idMedicamento'] ?>"></center>
                      </td>
              <td><b><?php echo $registromedicamentos['medicamento'] ?></b>  - <?php echo $registromedicamentos['gramaje'] ?> - <?php echo $registromedicamentos['presentacion'] ?> - <?php echo $registromedicamentos['cantidad'] ?>
              </td>

              <td align="right">
                <?php 
                $idCotizacion1=$idCotizacion-2;
                $idCotizacion2=$idCotizacion-1;
                $queryCostos="SELECT * from solicitudcotizacionesmedicamentos sm where sm.idCotizacion=$idCotizacion1 and sm.idProductosolicitud=$idProducto";
                  $resCostos=mysqli_query($con,$queryCostos); 
                  while ($registrocostos=mysqli_fetch_array($resCostos)) {
                    $disponibilidad=$registrocostos['existencias'];
                    if ($disponibilidad=='Con Existencias') { $disabled=''; } else { $disabled='disabled'; }
                    
                ?>
                <input type="checkbox" class="form-check-input" id="check<?php echo $i ?>" name="activar[]" value="<?php echo $registrocostos['idMedicamentoSolicitud'] ?>" <?php echo $disabled?>>
                $<?php echo number_format($registrocostos['costototal'],2,'.',','); ?>
                <?php if ($disponibilidad=='Con Existencias') { ?><font color="green"><i class="fas fa-check"></i></font><?php } else { ?><font color="red"><i class="fas fa-times"></i></font><?php } ?>
            </td>
          <?php } ?>

          <td align="right">
          <?php 
          $queryCostos="SELECT * from solicitudcotizacionesmedicamentos sm where sm.idCotizacion=$idCotizacion2 and sm.idProductosolicitud=$idProducto";
                  $resCostos=mysqli_query($con,$queryCostos); 
                  while ($registrocostos=mysqli_fetch_array($resCostos)) {
                    $disponibilidad=$registrocostos['existencias'];
                    if ($disponibilidad=='Con Existencias') { $disabled=''; } else { $disabled='disabled'; }
                    
                ?>
                <input type="checkbox" class="form-check-input" id="check<?php echo $i ?>" name="activar[]" value="<?php echo $registrocostos['idMedicamentoSolicitud'] ?>" <?php echo $disabled?>>
                $<?php echo number_format($registrocostos['costototal'],2,'.',','); ?>
                <?php if ($disponibilidad=='Con Existencias') { ?><font color="green"><i class="fas fa-check"></i></font><?php } else { ?><font color="red"><i class="fas fa-times"></i></font><?php } ?>
                 
            </td>
          <?php } ?>

          <td align="right"><?php
          $queryCostos="SELECT * from solicitudcotizacionesmedicamentos sm where sm.idCotizacion=$idCotizacion and sm.idProductosolicitud=$idProducto";
                  $resCostos=mysqli_query($con,$queryCostos); 
                  while ($registrocostos=mysqli_fetch_array($resCostos)) {
                    $disponibilidad=$registrocostos['existencias'];
                    if ($disponibilidad=='Con Existencias') { $disabled=''; } else { $disabled='disabled'; }
                    
                ?>
                <input type="checkbox" class="form-check-input" id="check<?php echo $i ?>" name="activar[]" value="<?php echo $registrocostos['idMedicamentoSolicitud'] ?>" <?php echo $disabled?>>
                $<?php echo number_format($registrocostos['costototal'],2,'.',','); ?>
                <?php if ($disponibilidad=='Con Existencias') { ?><font color="green"><i class="fas fa-check"></i></font><?php } else { ?><font color="red"><i class="fas fa-times"></i></font><?php } ?>
                 
            </td>
          <?php } ?>
            </tr>
          <?php } ?>
          <tr>
            <td colspan="2">TOTALES</td>
            <td align="right">
                <?php 
                $queryCostos="SELECT SUM(costototal) as totales from solicitudcotizacionesmedicamentos sm where sm.idCotizacion=$idCotizacion1";
                  $resCostos=mysqli_query($con,$queryCostos); 
                  $registrocostos=mysqli_fetch_array($resCostos);
                ?>
                
                $<?php echo number_format($registrocostos['totales'],2,'.',','); 
               ?>
              
            </td>
            <td align="right">
                <?php 
                $queryCostos="SELECT SUM(costototal) as totales from solicitudcotizacionesmedicamentos sm where sm.idCotizacion=$idCotizacion2";
                  $resCostos=mysqli_query($con,$queryCostos); 
                  $registrocostos=mysqli_fetch_array($resCostos);
                ?>
                
                $<?php echo number_format($registrocostos['totales'],2,'.',','); 
               ?>
              
            </td>
            <td align="right">
                <?php 
                $queryCostos="SELECT SUM(costototal) as totales from solicitudcotizacionesmedicamentos sm where sm.idCotizacion=$idCotizacion";
                  $resCostos=mysqli_query($con,$queryCostos); 
                  $registrocostos=mysqli_fetch_array($resCostos);
                ?>
                
                $<?php echo number_format($registrocostos['totales'],2,'.',','); 
               ?>
              
            </td>
          </tr>
          <tr>
            <td colspan="2">COTIZACIONES</td>

                    <?php 
                    $queryProveedores="SELECT * from solicitudcotizaciones sc 
                    inner join registros r  on r.idRegistro=sc.idProveedor
                    where sc.idSolicitudMedicamentos=$idSolicitudMedicamentos";
                    $resproveedores=mysqli_query($con,$queryProveedores); 
                      while ($registromedicamentos=mysqli_fetch_array($resproveedores)) {
                       $idCotizacion=$registromedicamentos['idCotizacion'];
                       $archivo=$registromedicamentos['archivoCotizacion']; 
                    ?>
                    <td align="right">
                      <?php if ($archivo!=''){ ?><i class="fas fa-file-pdf"> <a href="<?php echo $registromedicamentos['archivoCotizacion'] ?>" target="_blanck">Ver Archivo</a><?php } ?></td>
                  <?php } ?>
          </tr>
          <tr>
            <td colspan="2">FECHA DE ENTREGA</td>

                    <?php 
                    $queryProveedores="SELECT * from solicitudcotizaciones sc 
                    inner join registros r  on r.idRegistro=sc.idProveedor
                    where sc.idSolicitudMedicamentos=$idSolicitudMedicamentos";
                    $resproveedores=mysqli_query($con,$queryProveedores); 
                     while ($registromedicamentos=mysqli_fetch_array($resproveedores)) {
                       $idCotizacion=$registromedicamentos['idCotizacion']; 
                    ?>
                    <td align="right"><?php echo $registromedicamentos['fechaEntrega'] ?></td>
                  <?php } ?>
          </tr>
          <tr>
                    <td colspan="2">COMENTARIOS PROVEEDOR</td>
                    <?php 
                    $queryProveedores="SELECT * from solicitudcotizaciones sc 
                    inner join registros r  on r.idRegistro=sc.idProveedor
                    where sc.idSolicitudMedicamentos=$idSolicitudMedicamentos";
                    $resproveedores=mysqli_query($con,$queryProveedores); 
                     while ($registromedicamentos=mysqli_fetch_array($resproveedores)) {
                       $idCotizacion=$registromedicamentos['idCotizacion']; 
                    ?>
                    <td align="right"><?php echo $registromedicamentos['comentariosProveedor'] ?></td>
                  <?php } ?>
          </tr>
          
          <tr>
                      <td colspan="2"></td>
                      <td>
                    <select class="custom-select form-control-border" id="tipoeleccion" name="tipoeleccion[]" required>
                    <option value="">Elegi una opcion</option>
                    <option value="Sin elegir">No elegida</option>
                    <option value="Costo">Por Costo</option>
                    <option value="Existencia">Por Existencia</option>
                    <option value="Oportunidad">Por Oportunidad</option>
                    <option value="Costo y Existencia">Por Costo y Existencia</option>
                    <option value="Costo y Oportunidad">Por Costo y Oportunidad</option>
                    <option value="Existencia y Oportunidad">Por Existencia y Oportunidad</option>
                    <option value="Por Costo, Existencia y Oportunidad">Por Costo, Existencia y Oportunidad</option>
                  </select>
                  <input type="hidden" name="idCotizacion[]" id="idCotizacion" value="<?php  echo $idCotizacion1 ?>">
                      </td>
                      <td>
                  <select class="custom-select form-control-border" id="tipoeleccion" name="tipoeleccion[]" required>
                   <option value="">Elegi una opcion</option>
                    <option value="Sin elegir">No elegida</option>
                    <option value="Costo">Por Costo</option>
                    <option value="Existencia">Por Existencia</option>
                    <option value="Oportunidad">Por Oportunidad</option>
                    <option value="Costo y Existencia">Por Costo y Existencia</option>
                    <option value="Costo y Oportunidad">Por Costo y Oportunidad</option>
                    <option value="Existencia y Oportunidad">Por Existencia y Oportunidad</option>
                    <option value="Por Costo, Existencia y Oportunidad">Por Costo, Existencia y Oportunidad</option>
                  </select>
                  <input type="hidden" name="idCotizacion[]" id="idCotizacion" value="<?php  echo $idCotizacion2 ?>">
                    </td>
                    <td>
                  <select class="custom-select form-control-border" id="tipoeleccion" name="tipoeleccion[]" required>
                    <option value="">Elegi una opcion</option>
                    <option value="Sin elegir">No elegida</option>
                    <option value="Costo">Por Costo</option>
                    <option value="Existencia">Por Existencia</option>
                    <option value="Oportunidad">Por Oportunidad</option>
                    <option value="Costo y Existencia">Por Costo y Existencia</option>
                    <option value="Costo y Oportunidad">Por Costo y Oportunidad</option>
                    <option value="Existencia y Oportunidad">Por Existencia y Oportunidad</option>
                    <option value="Por Costo, Existencia y Oportunidad">Por Costo, Existencia y Oportunidad</option>
                  </select>
                  <input type="hidden" name="idCotizacion[]" id="idCotizacion" value="<?php  echo $idCotizacion ?>">
                    </td>
                    </tr>
          </table>
              </div>
            </div>

            <div class="card-footer">
                  <button type="submit" class="btn btn-success" id="btnEnv" id="btnEnv" name="btnEnv">Responder Cotizaciones</button>
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
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
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

<!--script>
$('input[type=checkbox]').on('change', function() {
        var cantidadPedida=$('#totalmedicamentos').val();
        if ($(this).is(':checked')) {
            var equiposSeleccionados = new Array();
            // alert("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Seleccionado");
            $('input[type=checkbox]:checked').each(function() {
                equiposSeleccionados.push($(this).val());
                //console.log(diasSeleccionados);
            });
            var seleccionados=equiposSeleccionados.length;
            seleccionados=seleccionados-2;
        }
        // valido las cantidades seleccionadas vs solicitadas
        
        if (seleccionados==cantidadPedida) {
            $("#btnEnv").show("show");
        } else {
            $("#btnEnv").hide("hide");
        } 
        
    });
</script-->





