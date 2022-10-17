<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>
<?php
if ($_GET['iduser3']!=''&&$_GET['borrar']=='si') {
    $idRegister=$_GET['iduser3'];
    $idUsuaio=$_SESSION['idUsuario'];
    $query = "UPDATE registros SET estatus=5 WHERE idRegistro=$idRegister";
    mysqli_query($con,$query);
    $queryUpdate="INSERT INTO movimientosregistros (idRegistro,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idRegister,$idUsuaio,'BORRAR','" . date('Y-m-d H:i:s') ."')";
         $actualizar=mysqli_query($con,$queryUpdate); ?>
         <script type="text/javascript">
              window.location="registrosGR?do=5";
        </script>
<?php } ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión de Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Registros de Clientes</li>
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
                  El registro se <b>BORRO</b> correctamente</a>
                </div>
                </div>
  <?php } ?>
    <?php
    if ($_GET['noCliente']) {
    $noCliente=$_GET['noCliente'];
    $criterio="where idCliente=$noCliente";
    } else {
    $noCliente="where estatus=1";
    }
    ?>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del cliente </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">          

            <form action="" method="GET">

        <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Cliente</label>
                  <?php 
                  $query='SELECT idCliente, nombreCliente from clientes where estatus=1';
                            $res = mysqli_query($con,$query);
                  ?>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="noCliente" name="noCliente">
                    <option value="">- Selecciona un Cliente -</option>
                  <?php
                    while ($estados = mysqli_fetch_array($res)) {
                       echo '<option value="' . $estados['idCliente'] . '">'.$estados['nombreCliente']. '</option>';
                    }
                  ?>
                  </select>
                </div>
              </div>
            </div> 
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Buscar datos del cliente</button>
          </div>
        </form>

          </div>          
        </div>
        </div>
    </section>
    <?php if ($_GET) { ?>

    <!-- Main content -->
    <section class="content" id="reporte">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Clientes en estatus Activo</h3>
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
                          Nombre Comercial
                      </th>
                      <th>
                          Acciones
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query = 'SELECT * from clientes '.$criterio;
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idCliente=$registro['idCliente'];
                  ?>
                  <tr>
                      <td>
                          <?php echo $registro['nombreCliente'] ?>
                      </td>
                      
                      <td>
                        <?php if($tipousuario=='Administrador'){ ?>
                          <a class="btn btn-warning btn-sm" href="consultarDatosCliente?idCliente=<?php echo $idCliente; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Consultar
                          </a>
                          <a class="btn btn-info btn-sm" href="editarDatosCliente?idCliente=<?php echo $idCliente; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar
                          </a>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#borrarRegistro" id="btnDelete" data-id="<?php echo $idCliente ?>"> <i class="fas fa-trash">
                              </i>
                            Borrar</button>
                          
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#verActualizaciones" id="btnView" data-id="<?php echo $idCliente ?>"> <i class="fas fa-search">
                              </i>
                            Ver cambios</button>
                            
                            <a class="btn btn-success btn-sm" href="verBeneficiariosClientes?idCliente=<?php echo $idCliente; ?>">
                              <i class="fas fa-book">
                              </i>
                              Ver beneficiarios
                          </a>
                            <a class="btn btn-success btn-sm" href="agregaDocumentosClientes?idCliente=<?php echo $idCliente; ?>">
                                <i class="fas fa-book">
                                </i>
                                Biblioteca Cliente
                            </a>
                          <?php } ?>
                          <?php if($tipousuario=='Medico'||$tipousuario=='GestorRed'||$tipousuario=='ConciliacionPagos'||$tipousuario=='CoordinadorRed'){ ?>
                           <a class="btn btn-warning btn-sm" href="consultarDatosCliente?idCliente=<?php echo $idCliente; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Consultar
                          </a>
                          <?php } ?>
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
        var idcliente = $(this).data('id'); 
        // alert(uid);
        $.ajax({
            url: 'consultas/consultasActualizacionesClientes',
            type: "POST",
            data: {"idcliente":idcliente},
            success: function (cmb) {
                     //alert(cmb);
                     $('#tablaResult').html(cmb);
                }
        });
      });  
    });
</script>

    <div id="verActualizaciones" class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
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

<div id="borrarRegistro" class="modal fade" role="dialog">

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
        Eliminar Cliente <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
      </button>
      </form>

          <script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnDelete', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        // alert(uid);
        document.fl3.iduser3.value = uid;
      });  
    });
</script>
      </div>
    </div>
  </div>
</div>

<!-- se dejo de ocupar en la busqueda del cliente
<script type="text/javascript">
    $('#namecliente').on('change', function(){   
    var namecliente = $('#namecliente').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasClientesDatos.php',
      data: {'namecliente': namecliente}
    })
    .done(function(listas_municipios){
      $('#noCliente').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>
-->

 

