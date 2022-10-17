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
            <h1>Edición de CPT</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">CPT</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" >
      <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de CPT</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0" >
          <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>TITULO DEL CPT</th>
                    <th colspan="3"><center>D.F. / AREA METRP./ FRONTERA</center></th> 
                    <th colspan="3"><center>RESTO DE LA REPUBLICA</center></th> 
                    <th></th>                        
                  </tr>
                  <tr>
                    <th>Titulo</th>
                    <th>Total honorarios </th> 
                    <th>Cirujano</th> 
                    <th>Anesteciologo</th> 
                    <th>Total honorarios </th> 
                    <th>Cirujano</th> 
                    <th>Anesteciologo</th> 
                    <th></th>                        
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query="SELECT * FROM cpttratamientos";
                  $res = mysqli_query($con,$query);
                  while ($registro = mysqli_fetch_array($res)) {
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
                                     $registro[11]."||".
                                     $registro[12]."||".
                                     $registro[13]."||".
                                     $registro[14];
                  ?>
                  <tr>
                    <td><?php echo $registro['Titulo'] ?></td>
                    <td><?php echo $registro['honorarios'] ?></td>
                    <td><?php echo $registro['cirujano'] ?></td>
                    <td><?php echo $registro['anesteciologo'] ?></td>
                    <td><?php echo $registro['honorariosforaneo'] ?></td>
                    <td><?php echo $registro['cirujanoforaneo'] ?></td>
                    <td><?php echo $registro['anesteciologoforaneo'] ?></td>
                    <td>
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-info" onclick="agregaform('<?php echo $datos ?>')">                  <i class="fas fa-edit"></i> 
                        </button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
          </table>
        </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

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
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>

<script type="text/javascript">
  function agregaform(datos){
    d=datos.split('||');
    $('#idCpt').val(d[0]); 
    $('#totalhonorarios1').val(d[4]);    
    $('#cirujano1').val(d[5]);
    $('#anesteciologo1').val(d[6]);
    $('#ayudante1').val(d[7]);
    $('#totalhonorariosforaneo').val(d[8]);    
    $('#cirujanoforaneo').val(d[9]);
    $('#anesteciologoforaneo').val(d[10]);
    $('#ayudanteforaneo').val(d[11]);
    $('#consulta').val(d[12]);
    $('#consultaforaneo').val(d[13]);
    $('#titulo').val(d[3]);
  }
</script>

      <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">EMPODERA SALUD</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="GET">
            <div class="modal-body">
              <div class="row">
              <div class="col-12 col-sm-12">
                <div class="form-group">
                  <label>Titulo</label>
                  <input type="text" class="form-control" id="titulo" name="titulo">
                </div>
                <div class="form-group">
                  <label>Total de honorarios (CDMX y Área Metropilitana)</label>
                  <input type="text" class="form-control" id="totalhonorarios1" name="totalhonorarios1" onkeyup="eliminarEspacio()">
                  <input type="hidden" id="idCpt" name="idCpt">
                </div>
                <div class="form-group">
                  <label>Cirujano</label>
                  <input type="text" class="form-control" id="cirujano1" name="cirujano1" onkeyup="eliminarEspacio()">
                </div>
                <div class="form-group">
                  <label>Anesteciologo</label>
                  <input type="text" class="form-control" id="anesteciologo1" name="anesteciologo1" onkeyup="eliminarEspacio()">
                </div>
                <div class="form-group">
                  <label>Ayudante</label>
                  <input type="text" class="form-control" id="ayudante1" name="ayudante1" onkeyup="eliminarEspacio()">
                </div>
              </div>
              <div class="col-12 col-sm-12">
                <div class="form-group">
                  <label>Total de honorarios (Resto de la Republica)</label>
                  <input type="text" class="form-control" id="totalhonorariosforaneo" name="totalhonorariosforaneo" onkeyup="eliminarEspacio()">
                </div>
                <div class="form-group">
                  <label>Cirujano</label>
                  <input type="text" class="form-control" id="cirujanoforaneo" name="cirujanoforaneo" onkeyup="eliminarEspacio()">
                </div>
                <div class="form-group">
                  <label>Anesteciologo</label>
                  <input type="text" class="form-control" id="anesteciologoforaneo" name="anesteciologoforaneo" onkeyup="eliminarEspacio()">
                </div>
                <div class="form-group">
                  <label>Ayudante</label>
                  <input type="text" class="form-control" id="ayudanteforaneo" name="ayudanteforaneo" onkeyup="eliminarEspacio()">
                </div>
              </div>
            </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-success" onclick="editaCpt()">Guardar edición</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


<script type="text/javascript">
  function editaCpt(){
    var idCpt=$('#idCpt').val();
    var totalhonorarios1=$('#totalhonorarios1').val();
    var cirujano1=$('#cirujano1').val();    
    var anesteciologo1=$('#anesteciologo1').val();    
    var ayudante1=$('#ayudante1').val(); 
    var totalhonorariosforaneo=$('#totalhonorariosforaneo').val();
    var cirujanoforaneo=$('#cirujanoforaneo').val();    
    var anesteciologoforaneo=$('#anesteciologoforaneo').val();    
    var ayudanteforaneo=$('#ayudanteforaneo').val();
    var consulta=$('#consulta').val();
    var consultaforaneo=$('#consultaforaneo').val();   
    var titulo=$('#titulo').val(); 
            $.ajax({
            url: 'consultas/editarCptTratamientos.php',
            type: "POST",
            data: {"idCpt":idCpt,"totalhonorarios1":totalhonorarios1, "cirujano1":cirujano1, "anesteciologo1":anesteciologo1, "ayudante1":ayudante1, "totalhonorariosforaneo":totalhonorariosforaneo, "cirujanoforaneo":cirujanoforaneo, "anesteciologoforaneo":anesteciologoforaneo, "ayudanteforaneo":ayudanteforaneo, "titulo":titulo},
            success: function (cmb) {
               // alert(cmb);
               window.location="editarCPT?do=1";
            }
        });  
 
      }
</script>

<?php 
if ($_GET['do']=='1') { ?>
<script>
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
        title: ' El CPT se actualizo correctamente'
      })
    });
    });
</script>
<?php } ?>

<script type="text/javascript">
function eliminarEspacio(){
 $('input').val(function(_, value) {
       return $.trim(value);
    });
 $('input').val(function($, value) {
       return $.trim(value);
    });
}
</script>