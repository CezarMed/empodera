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
            <h1>CREACIÓN DE USUARIOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <form action="" method="POST" autocomplete="off">
    <section class="content">

      <div class="container-fluid">

        <div class="card card-default">

          <div class="card-header">
            <h3 class="card-title">Datos del usuario</h3>
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
                  <label>Nombre(s)</label>
                 <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del usuario">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Apellidos</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos del usuario">
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sexo</label>
                 <select class="custom-select form-control-border" id="sexo" name="sexo">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono</label>
                  <div class="input-group">
                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Telefono del usuario">
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email</label>
                 <input type="email" class="form-control" id="email" name="email" placeholder="Email del usuario">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Tipo de Usuario</label>
                  <div class="input-group">
                    <?php
                  $queryContratos2 = "SELECT * from tipousuario where estatus=1";
                  $resContratos2 = mysqli_query($con,$queryContratos2);
                  ?>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="tipousuario" name="tipousuario">
                          <?php
                           while ($contratos2 = mysqli_fetch_array($resContratos2)) {
                              echo '<option value="' . $contratos2['Nombre'] . '">'.$contratos2['Descripcion']. '</option>';
                            }
                          ?>
                  </select>
                  </div>                
                </div>
              </div>
            </div>


              <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label>Empresa</label>
                  <div class="input-group">
                    <?php
                  $queryContratos2 = "SELECT * from registros where estatus=1";
                  $resContratos2 = mysqli_query($con,$queryContratos2);
                  ?>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="idempresa" name="idempresa"><option value="0">Empodera</option>
                          <?php
                           while ($contratos2 = mysqli_fetch_array($resContratos2)) {
                              echo '<option value="' . $contratos2['idRegistro'] . '">'.$contratos2['nombreComercial']. '</option>';
                            }
                          ?>
                  </select>
                  </div>                
                </div>
              </div>
            </div>



            <div class="row">


              <div class="col-sm-12">
        <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-info"></i> Importante!</h5>
                  Los datos a continuación solicitados son para el acceso a Plataforma Empodera, se valida el usuario antes de registrar.
        </div>
      </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Usuario</label>
                 <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario para plataforma" pattern="[a-z]{1,15}" onchange="validaUsuario()">
                </div>
              </div>

              <div class="col-md-6">
               <div class="form-group">
                  <label>Contraseña</label>
                 <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Password">
                </div>
              </div>
            </div>
            <div class="card-footer" id="botonenviar" style="display:none">
            <button type="button" class="btn btn-success" onclick="generaUsuario()">Generar usuario</button>
          </div>

            </div>


          </div>       


        </div>
          
        </div>

<?php
require_once ("footer.php");
?>

        
    </section>
  </div>
</form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


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
    function validaUsuario() {
      var usuario=$('#usuario').val();
        $.ajax({
            url: 'consultas/validaUsuario',
            type: "POST",
            data: {"usuario":usuario},
            success: function (cmb) {
                     // alert(cmb);
                     if (cmb=='') {
                     $('#botonenviar').show('show');
                     var Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000
                    });

                    $(document).ready(function() {
                      Toast.fire({
                        icon: 'success',
                        title: 'El nombre de usuario es valido'
                      })
                    });

                   } if (cmb!='') {
                    var Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000
                    });

                    $(document).ready(function() {
                      Toast.fire({
                        icon: 'error',
                        title: 'El nombre de usuario ya existe, intenta con otro'
                      })
                    });
                    $('#botonenviar').hide('hide');

                   }
                
            }
        });
      

  }
</script>

<script type="text/javascript">
  function generaUsuario(){
    var nombre=$('#nombre').val();
    var apellidos=$('#apellidos').val();
    var sexo=$('#sexo').val();
    var telefono=$('#telefono').val();
    var email=$('#email').val();
    var tipousuario=$('#tipousuario').val();
    var idempresa=$('#idempresa').val();
    var usuario=$('#usuario').val();
    var contrasena=$('#contrasena').val();

            $.ajax({
            url: 'consultas/altaUsuario.php',
            type: "POST",
            data: {"nombre":nombre, "apellidos":apellidos, "sexo":sexo, "telefono":telefono, "email":email, "tipousuario":tipousuario, "idempresa":idempresa, "usuario":usuario, "contrasena":contrasena},
            success: function (cmb) {
                     // alert(cmb);
                     window.location="agregarUsuario?do=1"       
            }
        });

  }
</script>

<?php if ($_GET['do']==1){ ?>
  <script type="text/javascript">
    var Toast = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000
                    });

                    $(document).ready(function() {
                      Toast.fire({
                        icon: 'success',
                        title: 'El usuario se ha creado con éxito, en este momento ya pudes ser utilizado'
                      })
                    });
  </script>
<?php } ?>
