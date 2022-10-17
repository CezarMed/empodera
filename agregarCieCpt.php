<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// mando llamar la clase
include('class/altaCieCpt.php');
$NuUs = new AltaCieCpt_class();
if ($_POST) {
$NuUs->altaCIE();
}

//consulto para obtener el nombre del beneficiario
$idBeneficiario=$_GET['idBeneficiario'];
$idServicio=$_GET['idServicio'];
$idCuenta=$_GET['idCuenta'];
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

    // OBTENGO EL NOMBRE DEL PROVEEDOR
    $queryProvee = "SELECT * from registros
                where idRegistro=$proveedorname";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $nombreComercial=$extraidoProvee['nombreComercial'];
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ASIGNACIÓN DE CIE Y CPT</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">CIE10 / CPT4</li>
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
            <h3 class="card-title">Agregar CIE10</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <?php 
          $querys="SELECT * FROM datoscie where idServicio=$idServicio";
          $ress1 = mysqli_query($con,$querys);
          $filasCie = mysqli_num_rows($ress1);
          if ($filasCie==0){
          ?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Grupo CIE</label>
                  <?php 
                  $queryBancos = 'SELECT * from gruposcie where estatus=1';
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocie" name="grupocie">
                  <option value="">Selecciona un Grupo CIE</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Codigo']. ' - '.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                  <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                 <input type="hidden" class="form-control" id="altaCIE" name="altaCIE" value="altaCIE">
                </div>
              </div>
            </div> 

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Diagnostico  CIE10</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="diagnosticocie10" name="diagnosticocie10[]">
                  </select>
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub-grupo CIE10</label>
                  <select class="custom-select form-control-border" id="cie10" name="cie10[]">
                  </select>
                </div>
              </div>
            </div>


          </div>          
        </div>
      <?php } else { ?>
          <div class="card-body">
                        <div class="row">
              <div class="col-md-12">
            <table class="table table-striped projects" id="divdatoscie">
              <thead>
                  <tr>
                    <th>Grupo</th>
                    <th>Diagnostico</th>
                    <th>CIE10</th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                   while ($registrosCie=mysqli_fetch_array($ress1)) {
                      $datosCie=$registrosCie[0]."||".
                                $registrosCie[1]."||".
                                $registrosCie[2]."||".
                                $registrosCie[3]."||".
                                $registrosCie[4]."||".
                                $registrosCie[5]."||".
                                $registrosCie[6]."||".
                                $registrosCie[7]."||".
                                $registrosCie[8]."||".
                                $registrosCie[9]."||".
                                $registrosCie[10]."||".
                                $registrosCie[11];
                ?>
                  <tr>
                    <td><?php echo $registrosCie['grupocie'] ?></td>
                    <td><?php echo $registrosCie['diagnosticocie10'] ?></td>
                    <td><?php echo $registrosCie['cie10'] ?></td>
                    <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editarcie" id="btnEditCpt" onclick="agregaform2('<?php echo $datosCie ?>')"> <i class="fas fa-edit"></i></button>
                      </td>
                  </tr> 
                  <?php } ?>                
              </tbody>
          </table>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Grupo CIE</label>
                  <?php 
                  $queryBancos = 'SELECT * from gruposcie where estatus=1';
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocie" name="grupocie">
                  <option value="">Selecciona un Grupo CIE</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Codigo']. ' - '.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                  <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                 <input type="hidden" class="form-control" id="altaCIE" name="altaCIE" value="altaCIE">
                </div>
              </div>
            </div> 

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Diagnostico  CIE10</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="diagnosticocie10" name="diagnosticocie10[]">
                  </select>
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub-grupo CIE10</label>
                  <select class="custom-select form-control-border" id="cie10" name="cie10[]">
                  </select>
                </div>
              </div>
            </div>


          </div>          
        </div>
      <?php } ?>
        </div>
    </section>

  <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Agregar CPT4</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <?php 
          $querys="SELECT * FROM datoscpt where idServicio=$idServicio";
          $ress = mysqli_query($con,$querys);
          $filasCPT = mysqli_num_rows($ress);
          if ($filasCPT==0){
          ?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Grupo CPT</label>
                  <?php if ($servicio=='MEDICAMENTOS') {
                  $queryBancos = 'SELECT * from gruposcpt where idCpt!=23 and estatus=1';
                } else {
                  $queryBancos = 'SELECT * from gruposcpt where idCpt!=24 and estatus=1';
                }
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocpt" name="grupocpt">
                  <option value="">Selecciona un Grupo CPT</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                  <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                 <input type="hidden" class="form-control" id="altaCIE" name="altaCIE" value="altaCIE">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tratamiento  CPT4</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="tratamientocpt" name="tratamientocpt[]">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub-grupo CPT4</label>
                  <select class="custom-select form-control-border" id="cpt4" name="cpt4[]">
                  </select>
                </div>
              </div>
            </div> 
          </div>
        </div>
    <?php } else { ?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
            <table class="table table-striped projects" id="divdatoscpt">
              <thead>
                  <tr>
                    <th>Tratamiento</th>
                    <th>Subgrupo</th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                   while ($registrosCpt=mysqli_fetch_array($ress)) {
                                $datos=$registrosCpt[0]."||".
                                $registrosCpt[1]."||".
                                $registrosCpt[2]."||".
                                $registrosCpt[3]."||".
                                $registrosCpt[4]."||".
                                $registrosCpt[5]."||".
                                $registrosCpt[6]."||".
                                $registrosCpt[7]."||".
                                $registrosCpt[8]."||".
                                $registrosCpt[9]."||".
                                $registrosCpt[10]."||".
                                $registrosCpt[11];
                ?>
                  <tr>
                    <td><?php echo $registrosCpt['tratamientocpt4'] ?></td>
                    <td><?php echo $registrosCpt['cpt4'] ?></td>
                    <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editarcpt" id="btnEditCpt" onclick="agregaform('<?php echo $datos ?>')"> <i class="fas fa-edit"></i></button></td>
                  </tr> 
                  <?php } ?>                
              </tbody>
          </table>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Grupo CPT Consultas</label>
                  <?php if ($servicio=='MEDICAMENTOS') {
                  $queryBancos = 'SELECT * from gruposcpt where idCpt!=23 and estatus=1';
                  } else {
                  $queryBancos = 'SELECT * from gruposcpt where idCpt!=24 and estatus=1';
                  }
                  $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocpt" name="grupocpt">
                  <option value="">Selecciona un Grupo CPT</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                  <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                 <input type="hidden" class="form-control" id="altaCIE" name="altaCIE" value="altaCIE">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tratamiento  CPT4</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="tratamientocpt" name="tratamientocpt[]">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub-grupo CPT4</label>
                  <select class="custom-select form-control-border" id="cpt4" name="cpt4[]">
                  </select>
                </div>
              </div>
            </div> 

          </div>
            

        </div>
      <?php } ?>
        </div>
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Agregar CPT4 con costo</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <?php 
          $querys="SELECT dc.idConsulta, dc.grupocpt, dc.cpt4, dc.consultacpt4,mc.monto,mc.medico, gc.Titulo FROM datosconsultas dc 
          inner join montosconsultas mc on mc.idConsulta=dc.idConsulta
          inner join gruposconsultas gc on gc.Codigo=dc.grupocpt
          where dc.idServicio=$idServicio and dc.estatus=1 and mc.estatus=1";
          $ress = mysqli_query($con,$querys);
          $filasCPT = mysqli_num_rows($ress);
          if ($filasCPT==0){
          ?>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Grupo CPT4</label>
                  <?php if ($servicio=='MEDICAMENTOS') {
                  $queryBancos = 'SELECT * from gruposconsultas where estatus=1';
                } else {
                  $queryBancos = 'SELECT * from gruposconsultas where estatus=1';
                }
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocpt2" name="grupocpt2">
                  <option value="">Selecciona un Grupo CPT</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                  <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                 <input type="hidden" class="form-control" id="altaConsulta" name="altaConsulta" value="altaConsulta">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tratamiento CPT4</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="tratamientocptconsulta" name="tratamientocptconsulta[]">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub-grupo CPT4</label>
                  <select class="custom-select form-control-border" id="cpt4consulta" name="cpt4consulta[]">
                  </select>
                </div>
              </div>
            </div> 

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Monto</label>
                  <input type="text" class="form-control" name="montoconsulta[]" id="montoconsulta" placeholder="Monto" onkeyup="eliminarEspacio()">
                </div>
              </div>
            </div> 

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Médico</label>
                  <input type="text" class="form-control" name="nombremedico[]" id="nombremedico" placeholder="Nombre del medico">
                </div>
              </div>
            </div> 

          </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Generar CIE / CPT / Consulta</button>
            </div>  

        </div>
    <?php } else { ?>

          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
            <table class="table table-striped projects" id="divdatosconsulta">
              <thead>
                  <tr>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Subgrupo</th>
                    <th>Medico</th>
                    <th>Costo</th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                   while ($registrosCpt=mysqli_fetch_array($ress)) {
                                $datos=$registrosCpt[0]."||".
                                $registrosCpt[1]."||".
                                $registrosCpt[2]."||".
                                $registrosCpt[3]."||".
                                $registrosCpt[4]."||".
                                $registrosCpt[5]."||".
                                $registrosCpt[6]."||".
                                $registrosCpt[7]."||".
                                $registrosCpt[8]."||".
                                $registrosCpt[9]."||".
                                $registrosCpt[10]."||".
                                $registrosCpt[11];
                ?>
                  <tr>
                    <td><?php echo $registrosCpt['Titulo'] ?></td>
                    <td><?php echo $registrosCpt['consultacpt4'] ?></td>
                    <td><?php echo $registrosCpt['cpt4'] ?></td>
                    <td><?php echo $registrosCpt['medico'] ?></td>
                    <td>$<?php echo $registrosCpt['monto'] ?></td>
                    <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editarconsulta" id="btnEditConsulta" onclick="agregaform3('<?php echo $datos ?>')"> <i class="fas fa-edit"></i></button>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarConsultaModal" id="btnEditConsulta" onclick="agregaform4('<?php echo $datos ?>')"> <i class="fas fa-times"></i></button></td>
                  </tr> 
                  <?php } ?>                
              </tbody>
          </table>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Grupo CPT</label>
                  <?php if ($servicio=='MEDICAMENTOS') {
                  $queryBancos = 'SELECT * from gruposconsultas where estatus=1';
                  } else {
                  $queryBancos = 'SELECT * from gruposconsultas where estatus=1';
                  }
                  $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocpt2" name="grupocpt2">
                  <option value="">Selecciona un Grupo CPT</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                  <input type="hidden" class="form-control" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario ?>">
                  <input type="hidden" class="form-control" id="idServicio" name="idServicio" value="<?php echo $idServicio ?>">
                 <input type="hidden" class="form-control" id="altaConsulta" name="altaConsulta" value="altaConsulta">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tratamiento  Consulta</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="tratamientocptconsulta" name="tratamientocptconsulta[]">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub-grupo CPT4</label>
                  <select class="custom-select form-control-border" id="cpt4consulta" name="cpt4consulta[]">
                  </select>
                </div>
              </div>
            </div> 

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Monto</label>
                  <input type="text" class="form-control" name="montoconsulta[]" id="montoconsulta" placeholder="Monto de la consulta" onkeyup="eliminarEspacio()">
                </div>
              </div>
            </div> 

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Médico</label>
                  <input type="text" class="form-control" name="nombremedico[]" id="nombremedico" placeholder="Nombre del medico">
                </div>
              </div>
            </div> 
          </div>
          
          <div class="card-footer">
          <button type="submit" class="btn btn-success">Generar CIE / CPT / Consulta</button>
          </div>  

        </div>
      <?php } ?>
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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>

<script type="text/javascript">
    $('#grupocie').on('change', function(){   
    var grupocie = $('#grupocie').val()
    var filtrocie = $('#filtrocie').val()
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasDiagnosticoCie',
      data: {'grupocie': grupocie}
    })
    .done(function(listas_usuarios){
      $('#diagnosticocie10').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
    $('#diagnosticocie10').on('change', function(){   
    var diagnosticocie10 = $('#diagnosticocie10').val()
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasGrupoCie',
      data: {'diagnosticocie10': diagnosticocie10}
    })
    .done(function(listas_usuarios){
      $('#cie10').html(listas_usuarios)
    })

  })
</script>


<script type="text/javascript">
    $('#grupocpt').on('change', function(){   
    var grupocpt = $('#grupocpt').val();
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasTratamientosCpt',
      data: {'grupocpt': grupocpt}
    })
    .done(function(listas_usuarios){
      $('#tratamientocpt').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
    $('#grupocpt2').on('change', function(){   
    var grupocpt2 = $('#grupocpt2').val();
    // alert(grupocpt2);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasTratamientosCpt2.php',
      data: {'grupocpt2': grupocpt2}
    })
    .done(function(listas_usuarios){
      // alert(listas_usuarios);
      $('#tratamientocptconsulta').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
    $('#tratamientocptconsulta').on('change', function(){   
    var tratamientocptconsulta = $('#tratamientocptconsulta').val()
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasGrupoCptconsultas',
      data: {'tratamientocptconsulta': tratamientocptconsulta}
    })
    .done(function(listas_usuarios){
      $('#cpt4consulta').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
    $('#tratamientocpt').on('change', function(){   
    var tratamientocpt = $('#tratamientocpt').val()
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasGrupoCpt',
      data: {'tratamientocpt': tratamientocpt}
    })
    .done(function(listas_usuarios){
      $('#cpt4').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
  function agregaform(datos){
    d=datos.split('||');
    $('#tratamientocptactual').val(d[5]);    
    $('#grupocptactual').val(d[4]);
    $('#idCpt4').val(d[0]);
  }
    function agregaform2(datos){
    d=datos.split('||');
    $('#diagnosticociectual').val(d[5]);    
    $('#grupocieactual').val(d[3]);
    $('#cie10actual').val(d[4]);
    $('#idCie').val(d[0]);
  }

  function agregaform3(datos){
    d=datos.split('||');
    $('#idConsulta').val(d[0]);
    $('#consultaActual').val(d[3]);    
    $('#grupoconsultactual').val(d[2]);
    $('#montoconsultaactual').val(d[4]);
    $('#medicoactual').val(d[5]);
  }

  function agregaform4(datos){
    d=datos.split('||');
    $('#idConsultaEliminar').val(d[0]);
  }
</script>

<div id="editarcpt" class="modal fade" role="dialog">
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
                  <label>Tratamiento CPT4 Actual</label>
                  <input type="text" class="form-control" id="tratamientocptactual" name="tratamientocptactual" readonly>
                </div>
              </div>
            </div>
             <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Grupo CPT4 Actual</label>
                  <input type="text" class="form-control" id="grupocptactual" name="grupocptactual" readonly>
                </div>
              </div>
            </div>
        <hr>
          <form action="" method="POST"></form>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color="red">ELEGIR SI DESEAS CAMBIAR EL CPT4</font></label><br>
                  <label>Grupo CPT4</label>
                  <?php if ($servicio=='MEDICAMENTOS') {
                  $queryBancos = 'SELECT * from gruposcpt where idCpt!=23 and estatus=1';
                } else {
                  $queryBancos = 'SELECT * from gruposcpt where idCpt!=24 and estatus=1';
                }
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocpt2" name="grupocpt2">
                  <option value="">Selecciona un Grupo CPT</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                 <input type="hidden" class="form-control" id="idCpt4" name="idCpt4">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Tratamiento  CPT4</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="tratamientocpt2" name="tratamientocpt2">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Sub-grupo CPT4</label>
                  <select class="custom-select form-control-border" id="cpt42" name="cpt42">
                  </select>
                </div>
              </div>

              <button type="button" class="btn btn-success" onclick="editarCPT()">Guardar Actualización</button>
            </div> 
      </div>
    </div>
  </form>
  </div>
</div>

<script type="text/javascript">
    $('#grupocpt2').on('change', function(){   
    var grupocpt = $('#grupocpt2').val();
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasTratamientosCpt',
      data: {'grupocpt': grupocpt}
    })
    .done(function(listas_usuarios){
      $('#tratamientocpt2').html(listas_usuarios)
    })

  })
</script>

<div id="editarconsulta" class="modal fade" role="dialog">
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
                  <label>Consulta Actual</label>
                  <input type="text" class="form-control" id="consultaActual" name="consultaActual" readonly>
                </div>
              </div>
            </div>
             <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Grupo CPT4 Actual</label>
                  <input type="text" class="form-control" id="grupoconsultactual" name="grupoconsultactual" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Monto</label>
                  <input type="text" class="form-control" id="montoconsultaactual" name="montoconsultaactual" readonly>
                  
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Medico</label>
                  <input type="text" class="form-control" id="medicoactual" name="medicoactual" readonly>
                
              </div>
              </div>
              </div>
        <hr>
          <form action="" method="POST"></form>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color="red">ELEGIR SI DESEAS CAMBIAR LA CONSULTA</font></label><br>
                  <label>Grupo CPT4</label>
                  <?php if ($servicio=='MEDICAMENTOS') {
                  $queryBancos='SELECT * from gruposconsultas where estatus=1';
                    } else {
                  $queryBancos='SELECT * from gruposconsultas where estatus=1';
                    }
                  $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocpt22" name="grupocpt22">
                  <option value="">Selecciona un Grupo CPT</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                 <input type="hidden" class="form-control" id="idConsulta" name="idConsulta">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Tratamiento  CPT4</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="tratamientocptconsulta22" name="tratamientocptconsulta22">
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Sub-grupo CPT4</label>
                  <select class="custom-select form-control-border" id="cpt422" name="cpt422">
                  </select>
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Monto</label>
                  <input type="text" class="form-control" id="montonuevo" name="montonuevo">
                
              </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Medico</label>
                  <input type="text" class="form-control" id="mediconuevo" name="mediconuevo">
                
              </div>
              </div>
              </div>

              <button type="button" class="btn btn-success" onclick="editarConsulta()">Guardar Actualización</button>
            </div> 
      </div>
    </div>
  </form>
  </div>
</div>

<script type="text/javascript">
    $('#grupocpt22').on('change', function(){   
    var grupocpt22 = $('#grupocpt22').val();
    // alert(grupocpt22);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasTratamientosCpt22.php',
      data: {'grupocpt22': grupocpt22}
    })
    .done(function(listas_usuarios){
      // alert(listas_usuarios);
      $('#tratamientocptconsulta22').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
    $('#tratamientocptconsulta22').on('change', function(){   
    var tratamientocptconsulta22 = $('#tratamientocptconsulta22').val()
    // alert(tratamientocptconsulta22);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasGrupoConsultas2.php',
      data: {'tratamientocptconsulta22': tratamientocptconsulta22}
    })
    .done(function(listas_usuarios){
      $('#cpt422').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
  function editarConsulta(){
    var idConsulta=$('#idConsulta').val();
    var grupocpt=$('#grupocpt22').val();
    var tratamientocpt=$('#tratamientocptconsulta22').val();
    var cpt4=$('#cpt422').val();
    var montonuevo=$('#montonuevo').val();
    var mediconuevo=$('#mediconuevo').val();
    
        $.ajax({
            url: 'consultas/editarConsultaFinal.php',
            type: "POST",
            data: {"idConsulta":idConsulta,"grupocpt":grupocpt, "tratamientocpt":tratamientocpt, "cpt4":cpt4, "montonuevo":montonuevo, "mediconuevo":mediconuevo},
            success: function (cmb) {
               // alert(cmb);
               $("#divdatosconsulta").load(" #divdatosconsulta");
               $('#editarconsulta').modal('hide');
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
                      title: ' La consulta se actualizo correctamente'
                    })
                  });
                  });
            }
        });        
  }
</script>

<div id="eliminarConsultaModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row" >
              <div class="col-md-12">
                  <input type="hidden" class="form-control" id="idConsultaEliminar" name="idConsultaEliminar">
                  <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-info"></i> Importante!</h5>
                  Seguro que deseas eliminar el registro? afectara el monto autorizado del beneficiario.
                </div>
                
              </div>
            </div>
              <button type="button" class="btn btn-danger" onclick="eliminarConsulta()">Eliminar Consulta</button>
            </div> 
      </div>
    </div>
  </form>
  </div>
</div>

<script type="text/javascript">
  function eliminarConsulta(){
    var idConsultaEliminar=$('#idConsultaEliminar').val();
    
        $.ajax({
            url: 'consultas/eliminarConsulta.php',
            type: "POST",
            data: {"idConsultaEliminar":idConsultaEliminar},
            success: function (cmb) {
               // alert(cmb);
               $("#divdatosconsulta").load(" #divdatosconsulta");
               $('#eliminarConsultaModal').modal('hide');
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
                      title: ' El registro se elimino correctamente'
                    })
                  });
                  });
            }
        });        
  }
</script>


<script type="text/javascript">
    $('#tratamientocpt2').on('change', function(){   
    var tratamientocpt = $('#tratamientocpt2').val()
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasGrupoCpt',
      data: {'tratamientocpt': tratamientocpt}
    })
    .done(function(listas_usuarios){
      $('#cpt42').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
  function editarCPT(){
    var idCpt4=$('#idCpt4').val();
    var grupocpt=$('#grupocpt2').val();
    var tratamientocpt=$('#tratamientocpt2').val();
    var cpt4=$('#cpt42').val();
    
        $.ajax({
            url: 'consultas/editarCpt4.php',
            type: "POST",
            data: {"idCpt4":idCpt4,"grupocpt":grupocpt, "tratamientocpt":tratamientocpt, "cpt4":cpt4},
            success: function (cmb) {
               // alert(cmb);
               $("#divdatoscpt").load(" #divdatoscpt");
               $('#editarcpt').modal('hide');
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
                      title: ' El CPT4 se actualizo correctamente'
                    })
                  });
                  });
            }
        });        
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
                  <label>Grupo Cie10 Actual</label>
                  <input type="text" class="form-control" id="grupocieactual" name="grupocieactual" readonly>
                </div>
              </div>
            </div>
             <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Diagnostico CIE10 Actual</label>
                  <input type="text" class="form-control" id="diagnosticociectual" name="diagnosticociectual" readonly>
                </div>
              </div>
            </div>
            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>CIE10 Actual</label>
                  <input type="text" class="form-control" id="cie10actual" name="cie10actual" readonly>
                </div>
              </div>
            </div>
        <hr>
          <form action="" method="POST"></form>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color="red">ELEGIR SI DESEAS CAMBIAR EL CIE10</font></label><br>
                  <label>Grupo CIE10</label>
                  <?php 
                  $queryBancos = 'SELECT * from gruposcie where estatus=1';
                            $resBancos = mysqli_query($con,$queryBancos);
                  ?>
                  <select class="custom-select form-control-border" id="grupocie2" name="grupocie2">
                  <option value="">Selecciona un Grupo CIE</option>
                  <?php
                        while ($bancos = mysqli_fetch_array($resBancos)) {
                        echo '<option value="' . $bancos['Codigo'] . '">'.$bancos['Codigo']. ' - '.$bancos['Titulo']. '</option>';
                      }
                  ?>
                  </select>
                 <input type="hidden" class="form-control" id="idCie" name="idCie">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Diagnostico  CIE10</label>
                  <select class="form-control select2 select2" data-dropdown-css-class="select2" id="diagnosticocie102" name="diagnosticocie102">
                  </select>
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-12">
                <div class="form-group">
                  <label>Sub-grupo CIE10</label>
                  <select class="custom-select form-control-border" id="cie102" name="cie102">
                  </select>
                </div>
              </div>
            </div>

              <button type="button" class="btn btn-success" onclick="editarCie()">Guardar Actualización</button>
            </div> 
      </div>
    </div>
  </form>
  </div>
</div>

<script type="text/javascript">
    $('#grupocie2').on('change', function(){   
    var grupocie = $('#grupocie2').val();
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasDiagnosticoCie',
      data: {'grupocie': grupocie}
    })
    .done(function(listas_usuarios){
      $('#diagnosticocie102').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
    $('#diagnosticocie102').on('change', function(){   
    var diagnosticocie10 = $('#diagnosticocie102').val()
    // alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasGrupoCie',
      data: {'diagnosticocie10': diagnosticocie10}
    })
    .done(function(listas_usuarios){
      $('#cie102').html(listas_usuarios)
    })

  })
</script>

<script type="text/javascript">
  function editarCie(){
    var idCie=$('#idCie').val();
    var grupocie=$('#grupocie2').val();
    var diagnosticocie10=$('#diagnosticocie102').val();
    var cie10=$('#cie102').val();
    
        $.ajax({
            url: 'consultas/editarCie.php',
            type: "POST",
            data: {"idCie":idCie,"grupocie":grupocie, "diagnosticocie10":diagnosticocie10, "cie10":cie10},
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
                      title: ' El CPT4 se actualizo correctamente'
                    })
                  });
                  });
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