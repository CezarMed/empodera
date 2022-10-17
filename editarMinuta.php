<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaMinuta.php');
//creamo el objeto de la orde de venta class
$NuUs = new Altaminuta_class();
if ($_POST) {
$NuUs->actualizaMinuta();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>EDICIÓN DE MINUTAS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Minutas</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

        <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La minuta se ACTUALIZO correctamente</b> para consultar la información clic <a href="reporteMinutas?id=<?php echo $_GET['id']; ?>">Aquí</a>
                </div>
                </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  La minuta no se actualizo correctamente, si lo deseas contacta con un administrador</a>
                </div>
                </div>
  <?php } ?>

    <?php 
    $idMinuta=$_GET['id'];
    $query = "SELECT * from minutas where idMinuta=$idMinuta";
    $res = mysqli_query($con,$query);
    $extraido= mysqli_fetch_array($res);
    $idRegistro=$extraido['idRegistro'];
    $medio=$extraido['medio'];
    $fechaMinuta=$extraido['fechaMinuta'];
    $nombreElabora=$extraido['nombreElabora'];
    $emailElabora=$extraido['emailElabora'];
    $emailEnviar=$extraido['emailEnviar'];
    $acuerdos=$extraido['acuerdos'];
    $asuntos=$extraido['asuntos'];
    $anuncios=$extraido['anuncios'];
    $nuevosAsuntos=$extraido['nuevosAsuntos'];
    $firmas=$extraido['firmas'];




    $query2= "SELECT * from registros where idRegistro=$idRegistro";
    $res2 = mysqli_query($con,$query2);
    $extraido22= mysqli_fetch_array($res2);
    $rfcCedula=$extraido22['rfcCedula'];
    $rfcRepresentante=$extraido22['rfcRepresentante'];
    $nombreLegal=$extraido22['nombreLegal'];
    $nombreComercial=$extraido22['nombreComercial'];     
    ?>
    <!-- Main content -->
    <form action="" method="POST" autocomplete="off">
    <section class="content">

      <div class="container-fluid">

        <div class="card card-default">

          <div class="card-header">
            <h3 class="card-title">Llamada al orden </h3>
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
                  <label>Datos del Proveedor</label>
                  <p><b><?php echo $rfcCedula ?></b> con nombre comercial <b><?php echo $nombreComercial ?></b></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de minuta</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaMinuta" name="fechaMinuta" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $fechaMinuta ?>">
                    <input type="hidden" id="actualizaMinuta" name="actualizaMinuta" value="actualizaMinuta">
                  <input type="hidden" id="idMinuta" name="idMinuta" value="<?php echo $idMinuta ?>">
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de quien elabora minuta</label>
                 <input type="text" class="form-control" id="nombreElabora" name="nombreElabora" value="<?php echo $nombreElabora ?>">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Correo de elaboración de minuta</label>
                  <div class="input-group">
                    <input type="email" class="form-control" id="emailElabora" name="emailElabora" value="<?php echo $emailElabora?>">
                  </div>                
                </div>
              </div>
            </div>  

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email a donde se enviara la minuta</label>
                 <input type="email" class="form-control" id="emailEnviar" name="emailEnviar" value="<?php echo $emailEnviar ?>">
                </div>
              </div>
            </div>
        </div>
        </div>


        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Asistentes a la reunión</h3>
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
          <div class="table-responsive">
            <table class="table table-striped projects" id="dynamic_field">

                        <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from asistentesminutas
              where idMinuta=$idMinuta";
              $resSer= mysqli_query($con,$queryBen);
                 while ($extraidoSer= mysqli_fetch_array($resSer)) {
            ?>
              <tr>
                <td>
                  <input type="hidden" name="idasistenteA[]" value="<?php echo $extraidoSer['idAsistente'] ?>"" class="form-control name_list" />
                  <input type="text" name="nombreA[]" value="<?php echo $extraidoSer['nombre'] ?>"" class="form-control name_list" /></td>
                <td><input type="text" name="puestoA[]" value="<?php echo $extraidoSer['puesto'] ?>" class="form-control name_list" /></td>
                <td><input type="text" name="emailA[]" value="<?php echo $extraidoSer['email'] ?>" class="form-control name_list" /></td>
                <td><input type="text" name="telefonoA[]" value="<?php echo $extraidoSer['telefono'] ?>" class="form-control name_list" /></td>
                <td>
                  <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success" checked>
                </td>
              </tr>
            <?php  } ?>
            </table>
          </div>

      </div>
    </div>
  </div>
            </div>  
        </div>

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Asistentes</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row" id="dynamic_field2">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="nombre[]" placeholder="Nombre">
                  </div>                
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Puesto</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="puesto[]" placeholder="Puesto">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                    <input type="email" class="form-control" name="emailAsistente[]" placeholder="Email">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>telefono</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="telefono[]" placeholder="Telefono">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>.</label>
                  <div class="input-group">
                    <button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button>
                  </div>                
                </div>
              </div>
              </div>
            </div>
          </div>  

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">NO Asistentes a la reunión</h3>
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
          <div class="table-responsive">
            <table class="table table-striped projects" id="dynamic_field">
            <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from noasistentesminutas
              where idMinuta=$idMinuta";
              $resSer= mysqli_query($con,$queryBen);
                 while ($extraidoSer= mysqli_fetch_array($resSer)) {
            ?>
              <tr>
                <td>
                  <input type="hidden" name="idasistenteN[]" value="<?php echo $extraidoSer['idAsistente'] ?>"" class="form-control name_list" />
                  <input type="text" name="nombreN[]" value="<?php echo $extraidoSer['nombre'] ?>"" class="form-control name_list" /></td>
                <td><input type="text" name="puestoN[]" value="<?php echo $extraidoSer['puesto'] ?>" class="form-control name_list" /></td>
                <td><input type="text" name="emailN[]" value="<?php echo $extraidoSer['email'] ?>" class="form-control name_list" /></td>
                <td><input type="text" name="telefonoN[]" value="<?php echo $extraidoSer['telefono'] ?>" class="form-control name_list" /></td>
                <td>
                  <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success" checked>
                </td>
              </tr>
            <?php  } ?>
            </table>
          </div>

      </div>
    </div>
  </div>
            </div>  
        </div>

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">No asistentes</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row" id="dynamic_field3">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="nombre1[]" placeholder="Nombre">
                  </div>                
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Puesto</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="puesto1[]" placeholder="Puesto">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                    <input type="email" class="form-control" name="emailAsistente1[]" placeholder="Email">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>telefono</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="telefono1[]" placeholder="Telefono">
                  </div>                
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>.</label>
                  <div class="input-group">
                    <button type="button" name="add1" id="add1" class="btn btn-success">Agregar Más</button>
                  </div>                
                </div>
              </div>
              </div>
            </div>
          </div>


        <div class="card card-default">
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Acuerdos en reunión</label>
                  <textarea class="form-control" rows="3" id="acuerdos" name="acuerdos"><?php echo $acuerdos ?></textarea>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Asuntos pendientes</label>
                  <textarea class="form-control" rows="3" id="asuntos" name="asuntos"><?php echo $asuntos ?></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Anuncios</label>
                  <textarea class="form-control" rows="3" id="anuncios" name="anuncios"><?php echo $anuncios ?></textarea>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nuevos asuntos</label>
                  <textarea class="form-control" rows="3" id="nuevosAsuntos" name="nuevosAsuntos"><?php echo $nuevosAsuntos ?></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Firmas (ejemplo AB,CD,EF)</label>
                  <input type="text" class="form-control" name="firmas" id="firmas" value="<?php echo $firmas ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Medio en que llevo acabo</label>
                  <input type="text" class="form-control" name="medio" id="medio" value="<?php echo $medio ?>">
                </div>
              </div>
            </div>

          </div>  
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Actualizar minuta</button>
          </div>        
        </div
    </section>
  </div>
</form>
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

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

<script>
$(document).ready(function(){
  var i=1;
  $('#add').click(function(){
    i++;
    $('#dynamic_field2').append('<div class="card-body" id="row'+i+'"><div class="row"><div class="col-md-3"><div class="input-group"><input type="text" class="form-control" name="nombre[]" placeholder="Nombre"></div></div><div class="col-md-3"><div class="input-group"><input type="text" class="form-control" name="puesto[]" placeholder="Puesto"></div></div><div class="col-md-2"><div class="input-group"><input type="text" class="form-control" name="emailAsistente[]" placeholder="Email"></div></div><div class="col-md-2"><div class="input-group"><input type="text" class="form-control" name="telefono[]" placeholder="Telefono"></div></div><div class="col-md-2"><div class="input-group"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div></div>');
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
  $('#add1').click(function(){
    i++;
    $('#dynamic_field3').append('<div class="card-body" id="arow'+i+'"><div class="row"><div class="col-md-3"><div class="input-group"><input type="text" class="form-control" name="nombre1[]" placeholder="Nombre"></div></div><div class="col-md-3"><div class="input-group"><input type="text" class="form-control" name="puesto1[]" placeholder="Puesto"></div></div><div class="col-md-2"><div class="input-group"><input type="text" class="form-control" name="emailAsistente1[]" placeholder="Email"></div></div><div class="col-md-2"><div class="input-group"><input type="text" class="form-control" name="telefono1[]" placeholder="Telefono"></div></div><div class="col-md-2"><div class="input-group"><button type="button" name="remove1" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div></div>');
  });
  
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#arow'+button_id+'').remove();
  });
  
});
</script>
