<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaAsignacionProveedor.php');
//creamo el objeto de la orde de venta class
$NuUs = new AltaProveedorAsignacion_class();
if ($_POST['altaCierreServicio']) {
$NuUs->altaCierreServicio();
}
include('class/editaMedicamentosFinal.php');
$NuUs2 = new editaMedicamento_class();
if ($_POST['actualizaMedicamentos']) {
$NuUs2->actualizaMedicamentos();
}
//consulto para obtener el nombre del beneficiario
$idBeneficiario=$_GET['idBeneficiario'];
$idServicio=$_GET['idServicio'];
$idCuenta=$_GET['idCuenta'];
$idSolicitudMedicamentos=$_GET['idSolicitudMedicamentos'];

$query="SELECT * FROM beneficiarios where idBenefeciario=$idBeneficiario";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$nombreBene=$registro['nombreBeneficiario'];
//obtengo los datos del servicio
$querys="SELECT * FROM servicios where idServicio=$idServicio";
$ress = mysqli_query($con,$querys);
$registros = mysqli_fetch_array($ress);
$folioServicio=$registros['folioServicio'];
$servicio=$registros['servicio'];
$hoy=date('Y-m-d');

$queryProvee = "SELECT * from servicioscerradosproveedor
                where idServicio=$idServicio";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $proveedorname=$extraidoProvee['proveedorname'];
    $idAsignacion=$extraidoProvee['idCierre'];

    // OBTENGO EL NOMBRE DEL PROVEEDOR
    $queryProvee = "SELECT * from registros
                where idRegistro=$proveedorname";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $nombreComercial=$extraidoProvee['nombreComercial'];
 
$query = "SELECT * FROM servicioscerradosproveedor scp
inner join registros r on r.idRegistro=scp.proveedorname
where scp.idServicio=$idServicio and scp.estatus=1";
$result = mysqli_query($con,$query);
$row_cnt = mysqli_num_rows($result);
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ASIGNACIÓN DE PROVEEDOR AL SERVICIO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Servicios asignar proveedor</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

   <?php require_once ("encabezadoServicios.php"); ?>

    <?php 
    $idRegistro=$_GET['id'];
    $idServicio=$_GET['idServicio'];
    $query="SELECT * FROM beneficiarios where idBenefeciario=$idBeneficiario";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$nombreBene=$registro['nombreBeneficiario'];
$fechaNac=$registro['fechaNacimiento'];
list($anio, $mes, $dia) = explode("-", $fechaNac);
$yearh=date('Y');
//obtengo los datos del servicio
$querys="SELECT * FROM servicios where idServicio=$idServicio";
$ress = mysqli_query($con,$querys);
$registros = mysqli_fetch_array($ress);
$folioServicio=$registros['folioEmpodera'];
$servicio=$registros['servicio'];
$hoy=date('Y-m-d');   
    ?>
    <!-- Main content -->



    <section class="content-header">
      <div class="container-fluid">
                                <div class="row">
              <div class="col-md-12">
            <table class="table table-striped projects" id="divdatoscie">
              <thead>
                  <tr>
                    <th>Proveedor Asignado</th>
                    <th>Comentarios</th>
                    <th>Fecha de Servicio</th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php                 
                   while ($registrosProveedor=mysqli_fetch_array($result)) {
                      $proveedoranterior=$registrosProveedor['proveedorname'];
                      $datosCie=$registrosProveedor[0]."||".
                                $registrosProveedor[1]."||".
                                $registrosProveedor[2]."||".
                                $registrosProveedor[3]."||".
                                $registrosProveedor[4]."||".
                                $registrosProveedor[5]."||".
                                $registrosProveedor[6]."||".
                                $registrosProveedor[7]."||".
                                $registrosProveedor[8]."||".
                                $registrosProveedor[9]."||".
                                $registrosProveedor[10]."||".
                                $registrosProveedor[11]."||".
                                $registrosProveedor[12]."||".
                                $registrosProveedor[13]."||".
                                $registrosProveedor[14]."||".
                                $registrosProveedor[15]."||".
                                $registrosProveedor[16]."||".
                                $registrosProveedor[17]."||".
                                $registrosProveedor[18]."||".
                                $registrosProveedor[19];
                ?>
                  <tr>
                    <td><?php echo $registrosProveedor['nombreComercial'] ?></td>
                    <td><?php echo $registrosProveedor['contenidonota'] ?></td>
                    <td><?php echo $registrosProveedor['fechaServicio'] ?></td>
                    <td><?php if ($proveedorname!='108'){ ?><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editarcie" id="btnEditCpt" onclick="agregaform('<?php echo $datosCie ?>')"> <i class="fas fa-edit"></i>Cambio proveedor</button>  
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#pedircotinueva" id="btnNewCot" onclick="agregaform2('<?php echo $datosCie ?>')"> <i class="fas fa-edit"></i>Segundo ciclo</button><?php } ?></td>
                  </tr> 
                  <?php } ?>                
              </tbody>
          </table>
                </div>
            </div>
  <?php if ($servicio=='MEDICAMENTOS'){?>
    <form action="" method="POST">
    <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <thead>
              <tr>
                <td><label>Medicamento</label></td>
                <td><label>Gramaje</label></td>
                <td><label>Presentación</label></td>
                <td><label>Cantidad</label></td>
                <td><label>Costo unitario</label></td>
                <td><label>Costo Total</label></td>
                <td><label>Acciones</label></td>
              </tr>
              </thead>
              <tbody>
                <?php         
            $queryMedicamento2 = "SELECT * from solicitudmedicamentos sm
            INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
            INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
            INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
            INNER JOIN medicamentossolicitados ms on ms.idMedicamento=scm.idProductoSolicitud
            INNER JOIN registros r on r.idRegistro=sc.idProveedor
            INNER JOIN servicios s on s.idServicio=sm.idServicio
            INNER JOIN servicioscerradosproveedor scp on scp.idServicio=s.idServicio
            INNER JOIN estados e on e.idEstado=r.entidadFederativa
            where sm.idServicio=$idServicio and sc.idProveedor=$proveedoranterior and scm.elegido=1";
            $resMedicamento2 = mysqli_query($con,$queryMedicamento2);
            $i=0; 
            while ($medicamentos22 = mysqli_fetch_array($resMedicamento2)) {

              $i++;
              ?>
              <tr>
                <td>
                  <input type="hidden" id="actualizaMedicamentos" name="actualizaMedicamentos" value="actualizaMedicamentos">
                  <input type="hidden" id="idCotizacion" name="idCotizacion" value="<?php echo $medicamentos22['idCotizacion']; ?>">
                  <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                  <input type="hidden" id="idCuenta" name="idCuenta" value="<?php echo $idCuenta ?>">
                  <input type="hidden" id="idSolicitudMedicamentos" name="idSolicitudMedicamentos" value="<?php echo $idSolicitudMedicamentos ?>">
                  <input type="hidden" class="form-control" name="idMedicamento[]" value="<?php echo $medicamentos22['idMedicamento']; ?>">
                  <input type="hidden" class="form-control" id="fechaTerminaNuevo" name="fechaTerminaNuevo" value="<?php echo $medicamentos22['fechaTermina']; ?>">
                  <input type="hidden" class="form-control" name="idMedicamentoSolicitud[]" value="<?php echo $medicamentos22['idMedicamentoSolicitud']; ?>">
                  <input type="text" class="form-control" name="nombre[]" placeholder="Medicamento" value="<?php echo $medicamentos22['medicamento']; ?>">
                </td>
                <td><input type="text" class="form-control" name="gramaje[]" value="<?php echo $medicamentos22['gramaje']; ?>"></td>
                <td><input type="text" class="form-control" name="presentacion[]" value="<?php echo $medicamentos22['presentacion']; ?>"></td>
                <td><input type="text" class="form-control" name="cantidad[]" value="<?php echo $medicamentos22['cantidad']; ?>"></td>
                <td><input type="text" class="form-control" name="costo[]" value="<?php echo $medicamentos22['costo']; ?>" onkeyup="eliminarEspacio()"></td>
                <td><input type="text" class="form-control" name="costototal[]" value="<?php echo $medicamentos22['costototal']; ?>" onkeyup="eliminarEspacio()"></td>
                  <td><select class="custom-select form-control-border" id="elegido" name="elegido[]" required>
                    <option value="1">Activo</option>
                    <option value="5">Quitar de la lista</option>
                  </select></td>
              </tr>
            <?php } ?>

            <tr>
                <td><input type="text" class="form-control" name="nombreNuevo" id="nombreNuevo" placeholder="Medicamento"></td>
                <td><input type="text" class="form-control" name="gramajeNuevo" id="gramajeNuevo" placeholder="Gramaje"></td>
                <td><input type="text" class="form-control" name="presentacionNuevo" id="presentacionNuevo" placeholder="Presentacion"></td>
                <td><input type="text" class="form-control" name="cantidadNuevo" id="cantidadNuevo" placeholder="Cantidad"></td>
                <td><input type="text" class="form-control" name="costoNuevo" value="0" readonly>
                </td>
                <td><input type="text" class="form-control" name="costototalNuevo" value="0" readonly></td>
                <td><button type="button" class="btn btn-warning" onclick="agregarMedicamentoNuevo()">Agregar</button></td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Guardar cambios en solicitud de medicamentos</button>
            
            </div>         
      </div>
    </div>
  </div>
  </form>
<?php } ?>
      </div><!-- /.container-fluid -->
    </section>
    <?php if ($proveedorname=='108'){ ?>
    <form action="" method="POST" autocomplete="off">
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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de asignación</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaAsignacion" name="fechaAsignacion" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo date('Y-m-d H:i:s')?>" >
                    <input type="hidden" id="altaCierreServicio" name="altaCierreServicio" value="altaCierreServicio">
                    <input type="hidden" id="idAsignacion" name="idAsignacion" value="<?php echo $idAsignacion ?>">
                    <input type="hidden" id="folioServicio" name="folioServicio" value="<?php echo $folioServicio ?>">
                    <input type="hidden" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                    <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                    <input type="hidden" id="idCuenta" name="idCuenta" value="<?php echo $idCuenta ?>">
                  </div>                
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha en la que se dio el servicio</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaServicio" name="fechaServicio" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Estado</label>
                  <?php 
                  $query = 'SELECT clave, nombreEstado from estados';
                            $res = mysqli_query($con,$query);
                  ?>
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa">
                    <option value="">- Selecciona un Estado -</option>
                                <?php
                                header("Content-Type: text/html;charset=utf-8");
                                while ($estados = mysqli_fetch_array($res)) {
                                    echo '<option value="' . $estados['clave'] . '">'.$estados['nombreEstado']. '</option>';
                                }
                                ?>
                  </select>              
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tipo de atención</label>
                  <select class="custom-select form-control-border" id="tipoatencion" name="tipoatencion">
                  <option value="">Elige una opción</option>
                  <option value="Medicamentos">Medicamentos</option>
                  <option value="Consulta Medica">Consulta Medica</option>
                  <option value="Servicios Auxiliares">Servicios Auxiliares</option>
                  <option value="Hospitalizacion">Hospitalización</option>
                  </select>            
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Situación del proveedor</label>
                  <select class="custom-select form-control-border" id="situacionProveedor" name="situacionProveedor">
                    <option value="">Elige una situación</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                  </select>              
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Situación del contrato</label>
                  <?php
                  $queryContratos2 = "SELECT idSituacionContrato,situacion from situacioncontrato where estatus=1";
                  $resContratos2 = mysqli_query($con,$queryContratos2);
                  ?>
                  <select class="custom-select form-control-border" id="situacionContrato" name="situacionContrato">
                    <option value="">Elige una situación</option>
                          <?php
                           while ($contratos2 = mysqli_fetch_array($resContratos2)) {
                              echo '<option value="' . $contratos2['idSituacionContrato'] . '">'.$contratos2['situacion']. '</option>';
                            }
                          ?>
                  </select>          
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <button type="button" class="btn btn-info" onclick='buscarproveedor()'>Encontrar proveedor</button>              
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nombre del proveedor</label>
                  <select class="custom-select form-control-border" id="proveedorname" name="proveedorname">
                  </select>               
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Descripción del servicio ofrecido</label>
                  <textarea class="form-control" rows="3" id="contenidonota" name="contenidonota" placeholder="Agregar las notas correspondientes" maxlength="500" onkeyup="countChars(this);"></textarea>
                 <p id="charNum">500 caracteres</p>               
                </div>
              </div>
            </div>
           <div class="card-footer">
            <button type="submit" class="btn btn-success">Asignar proveedor real</button>
          </div>
          </div>
          </form>          
        </div>
        </div>
    </section>
  <?php } ?>
    
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
    $('#entidadFederativa').on('change', function(){   
    var id = $('#entidadFederativa').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasMunicipios.php',
      data: {'id': id}
    })
    .done(function(listas_municipios){
      $('#municipioDelegacion').html(listas_municipios)
    })
    .fail(function(){
      alert('Hubo un errror al cargar los municipios')
    })
  })
</script>
<script type="text/javascript">
function countChars(obj){
    document.getElementById("charNum").innerHTML = 500-obj.value.length+' caracteres';
}
</script>

<script type="text/javascript">
    function buscarproveedor() { 
    var id = $('#entidadFederativa').val();
    var tipoatencion = $('#tipoatencion').val();
    var situacionProveedor = $('#situacionProveedor').val();
    var situacionContrato = $('#situacionContrato').val();
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasproveedorservicio.php',
      data: {'id': id,'tipoatencion': tipoatencion,'situacionProveedor':situacionProveedor,'situacionContrato':situacionContrato}
    })
    .done(function(listas_proveedores){
      $('#proveedorname').html(listas_proveedores)
    })
    .fail(function(){
      alert('No se encontraron proveedores con el filtrado de busqueda')
    })
  }

</script>

<script type="text/javascript">
  function agregaform(datos){
    d=datos.split('||');
    $('#proveedornombre').val(d[19]);    
    $('#comentariosproveedor').val(d[7]);
    $('#fechaservicio').val(d[5]);
    $('#idAsignacion').val(d[0]);

  }
   function agregaform2(datos){
    d=datos.split('||');
    $('#proveedornombre2').val(d[19]);    
    $('#comentariosproveedor2').val(d[7]);
    $('#fechaservicio2').val(d[5]);
    $('#idAsignacion2').val(d[0]);

  }
</script>

<div id="editarcie" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Proveedor asignado</label>
                  <input type="text" class="form-control" id="proveedornombre" name="proveedornombre" readonly>
                </div>
              </div>
            </div>
             <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <input type="text" class="form-control" id="comentariosproveedor" name="comentariosproveedor" readonly>
                </div>
              </div>
            </div>
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Fecha de Servicio</label>
                  <input type="text" class="form-control" id="fechaservicio" name="fechaservicio" readonly>
                </div>
              </div>
            </div>
        <hr>
          <form action="" method="POST"></form>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color="red">ELEGIR SI DESEAS CAMBIAR EL PROVEEDOR</font></label><br>
                  <label>Proveedor</label>
                  <?php 
                  $queryBancos = 'SELECT * from registros where estatus=1';
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="proveedor2" name="proveedor2">
                  <option value="">Selecciona un proveedor</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['idRegistro'] . '">'.$bancos['nombreComercial'].'</option>';
                      }
                  ?>
                  </select>
                 <input type="hidden" id="idAsignacion" name="idAsignacion">
                 <input type="hidden" id="tipoServicio" name="tipoServicio" value="<?php echo $servicio ?>">
                 <input type="hidden" id="proveedorAnterior" name="proveedorAnterior" value="<?php echo $proveedoranterior ?>">
                 <input type="hidden" id="idSolicitudMedicamentos" name="idSolicitudMedicamentos" value="<?php echo $idSolicitudMedicamentos ?>">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <textarea class="form-control" rows="3" id="contenidonota2" name="contenidonota2" placeholder="Agregar las notas correspondientes" maxlength="500" onkeyup="countChars(this);"></textarea>
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Fecha de servicio</label>
                  <input type="text" id="fechaServicio2" name="fechaServicio2" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                </div>
              </div>
            </div>

              <button type="button" class="btn btn-success" onclick="editarProveedor()">Guardar Actualización</button>
            </div> 
      </div>
    </div>
  </form>
  </div>
</div>


<div id="pedircotinueva" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>SOLICITAR COTIZACION DE SEGUNDO CICLO</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Proveedor asignado</label>
                  <input type="text" class="form-control" id="proveedornombre2" name="proveedornombre2" readonly>
                </div>
              </div>
            </div>
             <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <input type="text" class="form-control" id="comentariosproveedor2" name="comentariosproveedor2" readonly>
                </div>
              </div>
            </div>
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Fecha de Servicio</label>
                  <input type="text" class="form-control" id="fechaservicio2" name="fechaservicio2" readonly>
                </div>
              </div>
            </div>
        <hr>
          <form action="generarSolicitudCotizacionesExtemporaneas" method="POST">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color="red">ELEGIR SI DESEAS SOLICTAR COTIZACION NUEVA</font></label><br>
                  <label>Proveedor</label>
                  <?php 
                  $queryBancos = 'SELECT * from registros where estatus=1';
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="proveedor2" name="proveedor2">
                  <option value="">Selecciona un proveedor</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['idRegistro'] . '">'.$bancos['nombreComercial'].'</option>';
                      }
                  ?>
                  </select>
                 <input type="hidden" id="idSolicitudMedicamentos2" name="idSolicitudMedicamentos2" value="<?php echo $idSolicitudMedicamentos ?>">
                </div>
              </div>
            </div>


              <button type="submit" class="btn btn-success">Pedir cotización nuevamente</button>
            </div> 
      </div>
    </div>
  </form>
  </div>
</div>

<script type="text/javascript">
  function editarProveedor(){
    var idAsignacion=$('#idAsignacion').val();
    var proveedor2=$('#proveedor2').val();
    var contenidonota2=$('#contenidonota2').val();
    var fechaServicio2=$('#fechaServicio2').val();
    var tipoServicio=$('#tipoServicio').val();
    var proveedorAnterior=$('#proveedorAnterior').val();
    var idSolicitudMedicamentos=$('#idSolicitudMedicamentos').val();
    
        $.ajax({
            url: 'consultas/editarProveedorAsignado.php',
            type: "POST",
            data: {"idAsignacion":idAsignacion,"proveedor2":proveedor2, "contenidonota2":contenidonota2, "fechaServicio2":fechaServicio2, "tipoServicio":tipoServicio, "proveedorAnterior":proveedorAnterior, "idSolicitudMedicamentos":idSolicitudMedicamentos},
            success: function (cmb) {
               // alert(cmb);
               $("#divdatoscie").load(" #divdatoscie");
               $('#editarcie').modal('hide');
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
                      title: ' El Proveedor asignado se actualizo correctamente'
                    })
                  });
                  });
            }
        });        
  }
</script>

<?php if ($_GET['do']==1) { ?>
<script>
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
        title: ' La solicitud de medicamentos se actualizo correctamente'
      })
    });
    });
</script>
  <?php } ?>

  <?php 
if ($_GET['do']=='2') { ?>
<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 4000
    });

    $(document).ready(function() {
      Toast.fire({
        icon: 'error',
        title: ' La solicitud de medicamentos no pudo actualizarse, revisa no contenga comillas simples o dobles'
      })
    });
    });
</script>
<?php } ?>

<script type="text/javascript">
    function agregarMedicamentoNuevo() { 
    var idSolicitudMedicamentos = $('#idSolicitudMedicamentos').val();
    var nombreNuevo = $('#nombreNuevo').val();
    var gramajeNuevo = $('#gramajeNuevo').val();
    var presentacionNuevo= $('#presentacionNuevo').val();
    var cantidadNuevo = $('#cantidadNuevo').val();
    var fechaTerminaNuevo = $('#fechaTerminaNuevo').val();
    var idCotizacion = $('#idCotizacion').val();
    // alert(idSolicitudMedicamentos+nombreNuevo+gramajeNuevo+presentacionNuevo+cantidadNuevo+fechaTerminaNuevo);

        $.ajax({
            url: 'consultas/agregaMedicamentoNuevo.php',
            type: "POST",
            data: {"idSolicitudMedicamentos":idSolicitudMedicamentos,"nombreNuevo":nombreNuevo,"gramajeNuevo":gramajeNuevo,"presentacionNuevo":presentacionNuevo,"cantidadNuevo":cantidadNuevo,"fechaTerminaNuevo":fechaTerminaNuevo,"idCotizacion":idCotizacion},
            success: function (cmb) {
                     //alert(cmb);
                     //$('#tablaResult').html(cmb);
                     location.reload();
                }
        });
  }

</script>

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
