<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>
<?php
if ($_GET['iduser3']!=''&&$_GET['borrar']=='si') {
    $idRegister=$_GET['iduser3'];
    $idUsuaio=$_SESSION['idUsuario'];
    $query = "UPDATE minutas SET estatus=5 WHERE idMinuta=$idRegister";
    mysqli_query($con,$query);
    $queryUpdate="INSERT INTO movimientosminutas (idMinuta,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idRegister,$idUsuaio,'BORRAR','" . date('Y-m-d H:i:s') ."')";
         $actualizar=mysqli_query($con,$queryUpdate); ?>
         <script type="text/javascript">
              window.location="reporteMinutas?do=5";
        </script>
<?php } ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reporte de minutas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Minutas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php if ($_GET['do']==5) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La minuta se <b>BORRO</b> correctamente
                </div>
                </div>
    <?php } ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del proveedor </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="" method="POST">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Elige un proveedor</label>
                 <?php 
                  $query = 'SELECT * from registros where estatus=1';
                            $res = mysqli_query($con,$query);
                  ?>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="idproveedor" name="idproveedor">
                    <option value="">- Todos los proveedores -</option>
                                <?php
                                header("Content-Type: text/html;charset=utf-8");
                                while ($estados = mysqli_fetch_array($res)) {
                                    echo '<option value="' . $estados['idRegistro'] . '">'.$estados['nombreComercial']. '</option>';
                                }
                                ?>
                  </select>          
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de inicio</label>
                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"  id="fechaInicio" name="fechaInicio"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" >
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div><font color="red">* Ningún campo es obligatorio</font>              
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
            <button type="submit" class="btn btn-success">Buscar minutas</button>
          </div>
        </form>

          </div>          
        </div>
        </div>
    </section>
<?php if ($_POST) { ?>
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Reporte de Minutas</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                    <th>
                          Enviar minuta a:
                      </th>
                      <th>
                          Nombre comercial
                      </th>
                      <th>
                          Fecha Minuta
                      </th>
                      <th>
                          Acciones
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                  
                  if ($_POST['idproveedor']!='') {
                    $idProvedor=$_POST['idproveedor'];
                    if ($idProvedor!=''){
                    $criterio1="and m.idRegistro=$idProvedor";
                  } else {
                    $criterio1='';
                  }
                  }

                  if ($_POST['fechaInicio']!='') {
                    $fechaInicio=$_POST['fechaInicio'];
                    $fechaFin=$_POST['fechaFin'];
                    $criterio="and m.fechaMinuta BETWEEN '$fechaInicio' and '$fechaFin'";
                  } 
                  $query = "SELECT m.idMinuta,m.idRegistro, r.nombreComercial, m.fechaMinuta, m.emailEnviar, m.asuntos from minutas m
                            INNER JOIN registros r on r.idRegistro=m.idRegistro where m.estatus=1 $criterio1 $criterio";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idMinuta=$registro['idMinuta'];
                  ?>
                  <tr>
                    <td>
                          <?php echo $registro['emailEnviar'] ?>
                      </td>
                      <td>
                          <a>
                              <?php echo $registro['nombreComercial'] ?>
                          </a>
                      </td>
                      <td>
                          <?php echo $registro['fechaMinuta'] ?>
                      </td>
                      
                      <td>
                          <a class="btn btn-info btn-sm" href="editarMinuta?id=<?php echo $idMinuta; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar
                          </a>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#borrarMinuta" id="btnDelete" data-id="<?php echo $idMinuta ?>"> <i class="fas fa-trash">
                              </i>
                            Eliminar minuta</button>
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#verActualizaciones" id="btnView" data-id="<?php echo $idMinuta ?>"> <i class="fas fa-search">
                              </i>
                            Ver cambios</button>
                            <a class="btn btn-info btn-sm" href="generarMinutaPDF?id=<?php echo $idMinuta; ?>" target="_blank">
                              <i class="fas fa-file-pdf">
                              </i>
                              PDF
                          </a>


                      </td>
                  </tr>

                <?php } ?>
                  
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
  <?php } ?>
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
    $('#reservationdate2').datetimepicker({
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
        $(document).ready(function(){
        $(document).on('click', '#btnView', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        // alert(uid);
        $.ajax({
            url: 'consultas/consultasActualizacionesMinutas',
            type: "POST",
            data: {"consultasActualizaciones":uid},
            success: function (cmb) {
                     //alert(cmb);
                     $('#tablaResult').html(cmb);
                }
        });
      });  
    });
</script>

<div id="verActualizaciones" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="tablaResult">
      </div>
    </div>
  </div>
</div>



<div id="borrarMinuta" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="GET" id="fl3" name="fl3">
            <input type="hidden" name="iduser3" name="iduser3" value="">
            <input type="hidden" value="si" name="borrar" name="borrar">
        <button type="submit" class="btn btn-sm btn-danger" >
        Eliminar Minuta <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
      </button>
      </form>
        <script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnDelete', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        //alert(uid);
        document.fl3.iduser3.value = uid;
      });  
    });
</script>
      </div>
    </div>
  </div>
</div>


 

