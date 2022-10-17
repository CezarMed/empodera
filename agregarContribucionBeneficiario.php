<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaContribucionCuentas.php');
//creamo el objeto de la orde de venta class
$NuUs = new Altacontribucion_class();
if ($_POST) {
$NuUs->accionesContribucion();
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
            <h1>Agregar Contribución a la cuenta del beneficiario</h1>
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
    $query="SELECT b.nombreBeneficiario, b.folioBeneficiario, cli.nombreCliente, mc.subgrupo, bc.contribucion, bc.copago from beneficiarios b 
    INNER JOIN beneficiarioscuentas bc on bc.idBeneficiario=b.idBenefeciario
    INNER JOIN montosclientes mc on mc.idmontoCliente=bc.idPrograma
    INNER JOIN clientes cli on cli.idCliente=mc.idCliente
    where b.idBenefeciario=$idBeneficiario and bc.idCuenta=$idCuenta";
    $res=mysqli_query($con,$query);
    $extraido=mysqli_fetch_array($res);
    ?>
<section class="content">
       <div class="callout callout-info">
       <h5><i class="fas fa-check"></i> Datos de la Cuenta</h5>
       Nombre y folio del Beneficiario: <b><?php echo $extraido['nombreBeneficiario']; ?> / <?php echo $extraido['folioBeneficiario']; ?></b><br>
       Cliente al que pertenece: <b><?php echo $extraido['nombreCliente']; ?></b><br>
       Subgrupo asignado: <b><?php echo $extraido['subgrupo'] ?></b><br>
       Contribución inicial: <b>$<?php echo $extraido['contribucion'] ?></b><br>
       Contribución (anexos): <b>$<?php 
                  $queryCopago="SELECT sum(montoAprobado) as montoAprobado from archivoscontribucion
                  where idBeneficiario=$idBeneficiario and idCuenta=$idCuenta";
                  $resCopago=mysqli_query($con,$queryCopago);
                  $extraidoCopago=mysqli_fetch_array($resCopago);
                  echo $totalContribucion=$extraidoCopago['montoAprobado'];?></b><br>
       Copago: <b>$<?php 
                  $queryCopago="SELECT sum(montoAprobado) as montoAprobado from archivoscopagos
                  where idBeneficiario=$idBeneficiario and idCuenta=$idCuenta";
                  $resCopago=mysqli_query($con,$queryCopago);
                  $extraidoCopago=mysqli_fetch_array($resCopago);
                  echo $totalCopago=$extraidoCopago['montoAprobado'];
                  ?></b><br>
                  Servicios: <b>$0</b><br>
       Saldo actual: <b><?php echo ($extraido['contribucion']+$extraido['copago']) ?></b><br>
       </div>
    </section>
    
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
         <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
          <div class="card-header">
            <h3 class="card-title">Los archivos serán autorizados despues de enviarlos</h3>
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
                  <label>Tipo de contribución</label>
                 <select class="custom-select form-control-border" id="tipocontribucion" name="tipocontribucion">
                  <option value="Acreditado">Acreditado</option>
                  <option value="Depositado">Depositado</option>
                  </select>
                 <input type="hidden" id="altaContribucion" name="altaContribucion" value="altaContribucion">
                 <input type="hidden" id="idCuenta" name="idCuenta" value="<?php echo $idCuenta ?>">
                 <input type="hidden" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Archivo </label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="archivo" name="archivo" accept="application/pdf" required>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Monto de la contribución</label>
                 <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto de la contribución" onkeyup="eliminarEspacio()" required>
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Enviar contribución</button>
          </div>
          </div> 
                    
        </div>
      </form>
      </div>
    </section>


    <section class="content" id="datosContribucion">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Contribuciones enviados a la cuenta del Beneficiario</h3>
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
                          Monto solicitado
                      </th>
                      <th>
                          Monto autorizado
                      </th>
                      <th>
                          Monto disponible
                      </th>
                      <th>
                          Estatus
                      </th>
                      <th>
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $query="SELECT * from archivoscontribucion ac
                            where ac.idBeneficiario=$idBeneficiario and ac.idCuenta=$idCuenta";
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
                    <td><b>$<?php echo number_format($registro['monto'], 2, '.', ',') ?></b></td>
                    <td><b>$<?php echo number_format($registro['montoAprobado'], 2, '.', ',') ?></b></td>
                    <td><b>$<?php echo number_format($registro['montoSaldo'], 2, '.', ',') ?></b></td>
                    <td><?php if ($estatus==1){echo "Activo";} ?>
                        <?php if ($estatus==2){echo "En proceso";} ?>
                        <?php if ($estatus==4){echo "<font color='green'>Terminado</font>";} ?>
                        <?php if ($estatus==5){echo "<font color='red'>Cancelado</font>";} ?>
                    </td>
                    <td><?php if ($estatus==1){ ?><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#aprobarCopago" id="btnActivate" onclick="agregaform('<?php echo $datos ?>')"> <i class="fas fa-edit">
                              </i>
                      </button><?php } ?>
                      <?php if ($estatus==2 or $estatus==4) { ?><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#datosCopago" id="btnView" data-id="<?php echo $registro['idCopago'] ?>" onclick="agregaform2('<?php echo $datos ?>')"> <i class="fas fa-search">
                              </i>
                      </button><?php } ?>
                      <?php if ($estatus!=5) { ?>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#datosCopagoCancelar" id="btnView2" data-id="<?php echo $registro['idCopago'] ?>" onclick="agregaform3('<?php echo $datos ?>')"> <i class="fas fa-times">
                              </i>
                      </button><?php } ?>
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
        title: ' La contribución se envio correctamente aun esta pendiente por autorizar y asignar'
      })
    });
    });
</script>
<?php } ?>

<script type="text/javascript">
  function agregaform(datos){
    d=datos.split('||');
    $('#idContribucion').val(d[0]);    
    $('#montoAutoriza').val(d[5]);
  }

    function agregaform2(datos){
    d=datos.split('||');
    $('#idCopago2').val(d[0]);    
    $('#montoSolicitado2').val(d[5]);
    $('#montoAutoriza2').val(d[8]);
    $('#montoDispo2').val(d[9]);
    $('#comentariosDispo').val(d[10]);
  }

    function agregaform3(datos){
    d=datos.split('||');
    $('#idCopago3').val(d[0]);    
    $('#montoSolicitado3').val(d[5]);
    $('#montoAutoriza3').val(d[8]);
    $('#montoDispo3').val(d[9]);
    $('#comentariosDispo3').val(d[10]);
  }
</script>

<div id="aprobarCopago" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>CONTRIBUCIÓN ASIGNADA A LA CUENTA</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="form-group">
                  <label>Monto</label>
                 <input type="text" class="form-control"id="montoAutoriza" name="montoAutoriza" onkeyup="eliminarEspacio2()">
                 <input type="hidden" class="form-control"id="idContribucion" name="idContribucion">
                  </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <textarea class="form-control" rows="2" cols="50" id="observaciones" name="observaciones"></textarea>
                </div>
        </div>

        <button type="button" class="btn btn-success" onclick="aprobarContribucion()">Procedente</button>
            <button type="button" class="btn btn-danger" onclick="rechazarCopago()">No procedente</button>
      </div>
    </div>
  </div>
</div>

<div id="datosCopago" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>DATOS DE LA CONTRIBUCION</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="form-group">
                  <label>Monto solicitado</label>
                 <input type="text" class="form-control"id="montoSolicitado2" name="montoSolicitado2" readonly>
                 <input type="hidden" class="form-control"id="idCopago2" name="idCopago2">
                  </div>
        </div>
        <div class="col-md-12">
                  <div class="form-group">
                  <label>Monto autorizado</label>
                 <input type="text" class="form-control"id="montoAutoriza2" name="montoAutoriza2" readonly>
                  </div>
        </div>
        <div class="col-md-12">
                  <div class="form-group">
                  <label>Monto disponible</label>
                 <input type="text" class="form-control"id="montoDispo2" name="montoDispo2" readonly>
                  </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <textarea class="form-control" rows="2" cols="50" id="comentariosDispo" name="comentariosDispo" readonly></textarea>
                </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="datosCopagoCancelar" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>CANCELAR COPAGO</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="form-group">
                  <label>Monto solicitado</label>
                 <input type="text" class="form-control"id="montoSolicitado3" name="montoSolicitado3" readonly>
                 <input type="hidden" class="form-control"id="idCopago3" name="idCopago3">
                  </div>
        </div>
        <div class="col-md-12">
                  <div class="form-group">
                  <label>Monto autorizado</label>
                 <input type="text" class="form-control"id="montoAutoriza3" name="montoAutoriza3" readonly>
                  </div>
        </div>
        <div class="col-md-12">
                  <div class="form-group">
                  <label>Monto disponible</label>
                 <input type="text" class="form-control"id="montoDispo3" name="montoDispo3" readonly>
                  </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <textarea class="form-control" rows="2" cols="50" id="comentariosDispo3" name="comentariosDispo" readonly></textarea>
                </div>
        </div>
        <div class="modal-body" id="tablaResult2">
      </div>
            <button type="button" class="btn btn-danger" onclick="cancelarContribucion()">Cancelar Contribución</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function rechazarCopago(){
    var observaciones=$('#observaciones').val();
    var idContribucion=$('#idContribucion').val();
    
        $.ajax({
            url: 'consultas/rechazarContribucion',
            type: "POST",
            data: {"idContribucion":idContribucion,"observaciones":observaciones},
            success: function (cmb) {
              // window.location="agregarPuntosPrograma?idPrograma="+idProgramaP;
               $("#datosContribucion").load(" #datosContribucion");
               $('#aprobarCopago').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' La contribucion se CANCELO correctamente, ya no estara disponible'
                    })
                  });
                  });
            }
        });        
  }
</script>

<script type="text/javascript">
  function aprobarContribucion(){
    var observaciones=$('#observaciones').val();
    var idContribucion=$('#idContribucion').val();
    var montoAutoriza=$('#montoAutoriza').val();
    
        $.ajax({
            url: 'consultas/aprobarContribucion',
            type: "POST",
            data: {"idContribucion":idContribucion,"observaciones":observaciones, "montoAutoriza":montoAutoriza},
            success: function (cmb) {
               $("#datosContribucion").load(" #datosContribucion");
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
                      title: ' La contribucion se AUTORIZO correctamente'
                    })
                  });
                  });
            }
        });        
  }
</script>

<script type="text/javascript">
function eliminarEspacio(){
 var texto=$('#monto').val();
 procesado=texto.replace(/\s+/g, '');
 $('#monto').val(procesado);
}
function eliminarEspacio2(){
 var texto2=$('#montoAutoriza').val();
 procesado2=texto2.replace(/\s+/g, '');
 $('#montoAutoriza').val(procesado2);
}
</script>

<script type="text/javascript">
  function cancelarContribucion(){
    var idContribucion=$('#idCopago3').val();
    
        $.ajax({
            url: 'consultas/cancelarContribucion.php',
            type: "POST",
            data: {"idContribucion":idContribucion},
            success: function (cmb) {
               // alert(cmb);
               $("#datosContribucion").load(" #datosContribucion");
               $('#datosCopagoCancelar').modal('hide');
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
                      title: ' La contribucion se CANCELO correctamente, en este momento ya no esta disponible en la cuenta general del beneficiario'
                    })
                  });
                  });
            }
        });        
  }
</script>

