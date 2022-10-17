<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaMedicamentos.php');
$NuUs = new AltaMedicamentos_class();
if ($_POST) {
$NuUs->altaMedicamentos();
}
$hoy=date('Y-m-d');
$idBeneficiario=$_GET['id'];
$idServicio=$_GET['idServicio'];
$servicioprincipal=$_GET['servicioprincipal'];
if ($servicioprincipal!='0'){
  $idServicioPrincipal=$servicioprincipal;
} else {
  $idServicioPrincipal=$idServicio;
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>SOLICITUD DE MEDICAMENTOS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Medicamentos solicitud</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php 

    $query2 = "SELECT * from periodosbeneficiarios where '$hoy' between fechaInicial and fechaFin and idBeneficiario=$idBeneficiario";
            $res2 = mysqli_query($con,$query2);
            $filas = mysqli_num_rows($res2);
            if ($filas>=1) {
            ?>


        <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La solicitud se genero correctamente con el folio <b><?php echo $_GET['folio']; ?></b> para consultar la información clic <a href="reporteSolicitudMedicamentos?folio=<?php echo $_GET['folio']; ?>">Aquí</a>
                </div>
                </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> UPS!</h5>
                  La solicitud no se genero correctamente, si lo deseas contacta con un administrador</a>
                </div>
                </div>
  <?php } ?>

  <?php 
            $query22 = "SELECT * from solicitudmedicamentos where idServicio=$idServicioPrincipal";
            $res22 = mysqli_query($con,$query22);
            $filasMed = mysqli_num_rows($res22);
            if ($filasMed==0) {
  ?>


    <!-- Main content -->
    <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
    <section class="content">

      <div class="container-fluid">

        <div class="card card-default">
          <?php 

            $idBeneficiario=$_GET['id'];
            $query2 = "SELECT * from solicitudmedicamentos where idBeneficiario=$idBeneficiario ORDER BY idSolicitudMedicamentos DESC LIMIT 1";
            $res2 = mysqli_query($con,$query2);
            $filasM = mysqli_num_rows($res2);
            if ($filasM>=1) {
            $extraido2= mysqli_fetch_array($res2);
            $idSolicitudMedicamentos=$extraido2['idSolicitudMedicamentos'];
            $calle=$extraido2['calle'];
            $entidadFederativa=$extraido2['entidadFederativa'];
            $municipioDelegacion=$extraido2['municipioDelegacion'];
            $noExteriorInterior=$extraido2['noExteriorInterior'];
            $colonia=$extraido2['colonia'];
            $codigoPostal=$extraido2['codigoPostal'];
            $telefonoBeneficiario=$extraido2['telefonoBeneficiario'];
            $nombreRecibe=$extraido2['nombreRecibe'];
            $telefonoRecibe=$extraido2['telefonoRecibe'];
            $fechaCargo=$extraido2['fechaCargo'];
            $query3 = "SELECT * from beneficiarios where idBenefeciario=$idBeneficiario";
            $res3 = mysqli_query($con,$query3);
            $extraido3= mysqli_fetch_array($res3);
            $nombreBeneficiario=$extraido3['nombreBeneficiario'];
            $referencias=$extraido3['referencias'];
            } else {
            $query = "SELECT * from beneficiarios where idBenefeciario=$idBeneficiario";
            $res = mysqli_query($con,$query);
            $extraido= mysqli_fetch_array($res);
            $nombreBeneficiario=$extraido['nombreBeneficiario'];
            $calle=$extraido['calle'];
            $colonia=$extraido['colonia'];
            $noExteriorInterior=$extraido['noExteriorInterior'];
            $codigoPostal=$extraido['codigoPostal'];
            $telefonoBeneficiario=$extraido['telefonoBeneficiario'];
            $nombreRecibe=$extraido['nombreRecibe'];
            $telefonoRecibe=$extraido['telefonoRecibe'];
            $entidadFederativa=$extraido['entidadFederativa'];
            $municipioDelegacion=$extraido['municipioDelegacion'];
            $referencias=$extraido['referencias'];
            }
            $query2 = "SELECT * from servicios where idServicio=$idServicio";
            $res2 = mysqli_query($con,$query2);
            $extraido2= mysqli_fetch_array($res2);
            $folioEmpodera=$extraido2['folioEmpodera'];
            if ($folioEmpodera==''){$folioEmpodera='SIN SERVICIO ASIGNADO';}
            
          ?>

          <div class="card-header">
            <h3 class="card-title">Solicitud de Medicamentos </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <?php if ($idSolicitudMedicamentos!='') { ?>
            <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-info"></i> Aviso importante!</h5>
                  La información mostrada es la última solictada por el Beneficiario el dia <?php echo $fechaCargo ?>
                </div>
                </div>
            </div>
            <?php } ?>

                <?php
    $query = "SELECT * from servicios s
    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario 
    where s.idServicio=$idServicio";
    $res = mysqli_query($con,$query);
    while ($registro = mysqli_fetch_array($res)) {
    ?>
    
        <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-info"></i> Datos del servicio</h5>
                  Folio de solicitud <b><?php echo $registro['folioEmpodera'] ?></b> para el benefeciario <b><?php echo $registro['nombreBeneficiario'] ?></b> con el servicio solicitado de <b><?php echo $registro['servicio'] ?></b>
                                                                                                  <?php 
        $queryCie = "SELECT * from datoscie where idServicio=$idServicio";
              $resCie = mysqli_query($con,$queryCie);
        ?>
        <br><b>DATOS CIE10:</b> <br><?php while ($extraidoCie= mysqli_fetch_array($resCie)) { echo $extraidoCie['cie10'] ?>, <?php echo $extraidoCie['diagnosticocie10'] ?><br>
        <?php } ?>
        <?php 
        $queryCie = "SELECT * from datoscpt where idServicio=$idServicio";
              $resCie = mysqli_query($con,$queryCie);
        ?>
        <br><b>DATOS CPT4:</b> <br><?php while ($extraidoCie= mysqli_fetch_array($resCie)) { echo $extraidoCie['cpt4'] ?>, <?php echo $extraidoCie['tratamientocpt4'] ?><br>
        <?php } ?>
                </div>
                </div>
            </div>
  <?php } ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre completo</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nombreSolicitante" name="nombreSolicitante" value="<?php echo $nombreBeneficiario?>" readonly>
                    <input type="hidden" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                    <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                    <input type="hidden" id="altaMedicamentos" name="altaMedicamentos" value="altaMedicamentos">
                  </div>                
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Fecha de solicitud</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" id="fechaSolicitud" name="fechaSolicitud" class="form-control" value="<?php echo $hoy ?>" readonly>
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Folio de Servicio</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="folioEmpodera" name="folioEmpodera" value="<?php echo $folioEmpodera?>" readonly>
                  </div>                
                </div>
              </div>

            </div>
          </div>          
        </div>



        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Datos del envio</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
                    <div class="col-sm-12">
        <div class="alert alert-warning alert-dismissible">
                  <h5><i class="icon fas fa-check"></i> Importante!</h5>
                  En este momento puedes editar la direccion del envio de medicamentos para el beneficiario. 
                </div>
                </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Entidad Federativa</label>
                  <?php
                  $queryEstados = "SELECT clave, nombreEstado from estados where idEstado=$entidadFederativa";
                  $resEstados = mysqli_query($con,$queryEstados);
                  $estadosResult= mysqli_fetch_array($resEstados);
                  $nombreEstado=$estadosResult['nombreEstado'];

                  $query = "SELECT clave, nombreEstado from estados where idEstado!=$entidadFederativa";
                            $res = mysqli_query($con,$query);
                  ?>
                  <select class="custom-select form-control-border" id="entidadFederativa" name="entidadFederativa">
                    <?php if ($entidadFederativa!=0) { ?>
                    <option value="<?php echo $entidadFederativa ?>"><?php echo $nombreEstado ?></option>
                  <?php } else { ?>
                  <option value="">- Selecciona un Estado -</option>
                  <?php } ?>
                                <?php
                                while ($estados = mysqli_fetch_array($res)) {
                                    echo '<option value="' . $estados['clave'] . '">'.$estados['nombreEstado']. '</option>';
                                }
                                ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Municipio o Delegación</label>
                  <?php
                  $queryMunicipios = "SELECT clave, nombre from municipios where id=$municipioDelegacion";
                  $resMunicipios = mysqli_query($con,$queryMunicipios);
                  $municipiosResult= mysqli_fetch_array($resMunicipios);
                  $nombreMunicipio=$municipiosResult['nombre'];
                  ?>
                  <select class="custom-select form-control-border" id="municipioDelegacion" name="municipioDelegacion" required>
                    <?php if ($municipioDelegacion!=0) { ?>
                    <option value="<?php echo $municipioDelegacion ?>"><?php echo $nombreMunicipio ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Calle</label>
                  <input type="text" class="form-control" id="calle" name="calle" value="<?php echo $calle?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Numero interior o exterior</label>
                  <input type="text" class="form-control" id="noExteriorInterior" name="noExteriorInterior" value="<?php echo $noExteriorInterior?>" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Colonia (Barrio)</label>
                  <input type="text" class="form-control" name="colonia" id="colonia" value="<?php echo $colonia?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Codigo Postal</label>
                  <input type="text" class="form-control" name="codigoPostal" id="codigoPostal" value="<?php echo $codigoPostal?>" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (beneficiario)</label>
                  <input type="text" class="form-control" name="telefonoBeneficiario" id="telefonoBeneficiario" value="<?php echo $telefonoBeneficiario?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de quien recibe</label>
                  <input type="text" class="form-control" name="nombreRecibe" id="nombreRecibe" value="<?php echo $nombreRecibe?>" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Teléfono (Recibe)</label>
                  <input type="text" class="form-control" name="telefonoRecibe" id="telefonoRecibe" value="<?php echo $telefonoRecibe?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Referencias</label>
                  <textarea class="form-control" rows="3" id="referencias" name="referencias" placeholder="Referencias del domicilio" required><?php echo $referencias ?></textarea>                
                </div>
              </div>
            </div>

           



          </div>  
                 
        </div>


        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Medicamentos</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

             <?php if ($idSolicitudMedicamentos=='') { ?>

  <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <tr>
                <td><label>Medicamento</label><input type="text" class="form-control" name="nombre[]" placeholder="Medicamento"></td>
                <td><label>Gramaje</label><input type="text" class="form-control" name="gramaje[]" placeholder="Gramaje"></td>
                <td><label>Presentación</label><input type="text" class="form-control" name="presentacion[]" placeholder="Presentacion"></td>
                <td><label>Cantidad</label><input type="text" class="form-control" name="cantidad[]" placeholder="Cantidad"></td>
                <td><label>Fecha Termina</label><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fechaTermina" name="fechaTermina[]" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                  </div>
                </td>
                <td><button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
              </tr>
            </table>
          </div>        
      </div>
    </div>
  </div>

            <?php } else { 
              $queryMedicamento = "SELECT ms.* FROM solicitudmedicamentos sm
              INNER JOIN medicamentossolicitados ms on ms.idSolicitudMedicamento=sm.idSolicitudMedicamentos
              where sm.idBeneficiario=$idBeneficiario and ms.estatus=1";
              $resMedicamento = mysqli_query($con,$queryMedicamento);
              $medicamentoResult= mysqli_fetch_array($resMedicamento);
              $medicamento=$medicamentoResult['medicamento'];
              $gramaje=$medicamentoResult['gramaje'];
              $presentacion=$medicamentoResult['presentacion'];
              $cantidad=$medicamentoResult['cantidad'];
              $idMedicamento=$medicamentoResult['idMedicamento'];
              $fechaTermina=$medicamentoResult['fechaTermina'];
              ?>

  <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field">
              <tr>
                <td><label>Medicamento</label><input type="text" class="form-control" name="nombre[]" placeholder="Medicamento" value="<?php echo $medicamento ?>"></td>
                <td><label>Gramaje</label><input type="text" class="form-control" name="gramaje[]" value="<?php echo $gramaje ?>"></td>
                <td><label>Presentación</label><input type="text" class="form-control" name="presentacion[]" value="<?php echo $presentacion ?>"></td>
                <td><label>Cantidad</label><input type="text" class="form-control" name="cantidad[]" value="<?php echo $cantidad ?>"></td>
                <td><label>Fecha Termina</label><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fechaTermina" name="fechaTermina[]" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $fechaTermina ?>">
                  </div>
                </td>
                <td><button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
              </tr>
              <?php 
            $queryMedicamento2 = "SELECT ms.* FROM solicitudmedicamentos sm
              INNER JOIN medicamentossolicitados ms on ms.idSolicitudMedicamento=sm.idSolicitudMedicamentos
              where sm.idBeneficiario=$idBeneficiario and ms.estatus=1 and ms.idMedicamento not in ($idMedicamento) GROUP BY ms.medicamento";
            $resMedicamento2 = mysqli_query($con,$queryMedicamento2);
            $filasMedicamento = mysqli_num_rows($resMedicamento2);
            if ($filasMedicamento>=1) {
            $i=0; 
            while ($medicamentos22 = mysqli_fetch_array($resMedicamento2)) {
              $i++;
              ?>
              <tr id="<?php echo "row".$i; ?>">
                <td><input type="text" class="form-control" name="nombre[]" placeholder="Medicamento" value="<?php echo $medicamentos22['medicamento']; ?>"></td>
                <td><input type="text" class="form-control" name="gramaje[]" value="<?php echo $medicamentos22['gramaje']; ?>"></td>
                <td><input type="text" class="form-control" name="presentacion[]" value="<?php echo $presentacion ?>"></td>
                <td><input type="text" class="form-control" name="cantidad[]" value="<?php echo $cantidad ?>"></td>
                <td><div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fechaTermina" name="fechaTermina[]" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask value="<?php echo $fechaTermina ?>">
                  </div>
                </td>
                <td><button type="button" name="remove" id="<?php echo $i ?>" class="btn btn-danger btn_remove">X</button></td>
              </tr>
            <?php } } ?>
            </table>
          </div>        
      </div>
    </div>
  </div>
            <?php }  ?>


            
             

            </div>
          </div>  

          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Receta</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-12"> 
                <label>Carga de recetas</label>
                <div class="form-group">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="dynamic_field2">                     
                        <tr>
                          <td><input type="file" id="archivo[]" name="archivo[]" accept=".doc,.docx,.xls,.xlsx,.pdf,.jpg,.png" placeholder="Subir archivo"></td>
                          <td><button type="button" name="add2" id="add2" class="btn btn-success">Agregar +</button></td>
                        </tr>
                      </table>
                    </div>
                </div>
              </div>
          </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="exampleInputFile">Revisaste los siguientes datos?</label>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="confrimaciondatos[]" value="Listado de Medicamentos">
                    <label class="form-check-label" for="exampleCheck1">Listado de Medicamentos</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck2" name="confrimaciondatos[]" value="Datos de contacto">
                    <label class="form-check-label" for="exampleCheck2">Datos de contacto</label>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck3" name="confrimaciondatos[]" value="Datos del domicilio">
                    <label class="form-check-label" for="exampleCheck3">Datos del Domicilio</label>
                  </div>
                </div>  
              </div>
            </div>

            <div class="card-footer">
            <button type="submit" class="btn btn-success">Generar solicitud de medicamentos</button>
            </div> 
          </div>
        </div>
      </section>
      <?php } else { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <h5><i class="icon fas fa-times"></i> UPS!</h5>
                  Este servicio ya tiene agregada una solicitud de medicamentos</a>
                </div>
                </div>
<?php } ?>
  </div>
</form>
<?php } else { ?>
<div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  
                  <h5><i class="icon fas fa-times"></i> UPS!</h5>
                  El beneficiario no tiene periodo activo en plataforma</a>
                </div>
                </div>
<?php } ?>
    <!-- /.content -->
  </div>
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
    $('#datemask').inputmask('YYYY-MM-DD', { 'placeholder': 'yyyy-mm-dd' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('YYYY-MM-DD', { 'placeholder': 'yyyy-mm-dd' })
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
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="form-control" name="nombre[]" placeholder="Medicamento"></td><td><input type="text" class="form-control" name="gramaje[]" placeholder="Gramaje"></td><td><input type="text" class="form-control" name="presentacion[]" placeholder="Presentacion"></td><td><input type="text" class="form-control" name="cantidad[]" placeholder="Cantidad"></td><td><div class="input-group-prepend"></div>                    <input type="text" class="form-control" id="fechaTermina" name="fechaTermina[]" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask></div></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
});
</script>

<script type="text/javascript">
    $('#entidadFederativa').on('change', function(){   
    var id = $('#entidadFederativa').val()
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasMunicipios',
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

  <script>
$(document).ready(function(){
  var i=1;
  $('#add2').click(function(){
    i++;
    $('#dynamic_field2').append('<tr id="row'+i+'"> <td><input type="file" id="archivo[]" name="archivo[]" accept=".doc,.docx,.xls,.xlsx,.pdf,.jpg,.png" placeholder="Subir archivo"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });
  
});
</script>