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
            <h1>Gestion de Redes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Registros de Gestion de Redes</li>
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
  <?php }
    if ($_GET['noProveedor']) {
    $noProveedor=$_GET['noProveedor'];
    $criterio="where rfcCedula='$noProveedor'";
    } else {
    $criterio="where estatus=1";
    }
    ?>

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
              <div class="col-sm-6">
                      <!-- radio -->
                      <div class="form-group">
                        <label>Buscar por:</label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="pornombre" id="pornombre">
                          <label class="form-check-label">Nombre del proveedor</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="opciones" value="porrfc" id="porrfc">
                          <label class="form-check-label">RFC del proveedor</label>
                        </div>
                      </div>
                    </div>
            </div>

            <div class="row" id="divnameprovee" style="display: none">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nombre del proveedor</label>
                  <input type="text" class="form-control" id="nameprovee" name="nameprovee" placeholder="Coloca el nombre del proveedor">             
                </div>
              </div>
            </div>

            <div class="row" id="divrfcprovee" style="display: none">
              <div class="col-md-12">
                <div class="form-group">
                  <label>RFC del proveedor</label>
                  <input type="text" class="form-control" id="rfcprovee" name="rfcprovee" placeholder="Coloca el RFC del proveedor">             
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
                  <option value="1">Medicamentos</option>
                  <option value="2">Consulta Medica</option>
                  <option value="3">Servicios Auxiliares</option>
                  <option value="4">Hospitalización</option>
                  <option value="5">Enfermeria</option>
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
                    <div class="col-sm-12" id="target" style="display: none">
                    <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Ups!</h5>
                  No hay resultados en tu busqueda</a>
                </div>
                </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button type="button" class="btn btn-info" onclick='buscarproveedor()'>Encontrar proveedor</button>              
                </div>
              </div>
            </div>
            <form action="" method="GET">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nombre del proveedor</label>
                  <select class="custom-select form-control-border" id="noProveedor" name="noProveedor">
                  </select>               
                </div>
              </div>
            </div>
            <div class="card-footer">
            <button type="submit" class="btn btn-success">Buscar datos del proveedor</button>
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
          <h3 class="card-title">Registros en estatus Activo / Inicial</h3>
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
                          RFC
                      </th>
                      <th>
                          Tipo de sucursal
                      </th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query = 'SELECT * from registros '.$criterio;
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idRegistro=$registro['idRegistro'];
                              $tipoSucursal=$registro['tipoSucursal'];
                  ?>
                  <tr>
                      <td>
                          <?php echo $registro['nombreComercial'] ?>
                      </td>
                      <td>
                          <?php echo $registro['rfcCedula'] ?>
                      </td>
                      <td>
                          <?php 
                          if ($tipoSucursal=='UN') {$tipoSucursalNombre='Sucursal única';}
                          if ($tipoSucursal=='MU') {$tipoSucursalNombre='Más de una sucursal';} 
                          echo $tipoSucursalNombre;
                    ?>
                      </td>
                  <tr>
                  </tr>    
                      <td colspan="3">
                        <?php if($tipousuario=='Administrador'||$tipousuario=='CoordinadorRed'||$tipousuario=='CoordinadorMedicamentos'||$tipousuario=='CoordinadorRed'||$tipousuario=='CoordinadorMed'){ ?>
                          <a class="btn btn-info btn-sm" href="consultarRegistroRedes?id=<?php echo $idRegistro; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Consultar
                          </a>
                          <a class="btn btn-info btn-sm" href="editarRegistroRedes?id=<?php echo $idRegistro; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar
                          </a>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#borrarRegistro" id="btnDelete" data-id="<?php echo $idRegistro ?>"> <i class="fas fa-trash">
                              </i>
                            Borrar</button>
                          <a class="btn btn-success btn-sm" href="agregarMinuta?id=<?php echo $idRegistro; ?>">
                              <i class="fas fa-book">
                              </i>
                              Agregar minuta
                          </a>
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#verActualizaciones" id="btnView" data-id="<?php echo $idRegistro ?>"> <i class="fas fa-search">
                              </i>
                            Ver cambios</button>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#verContrato" id="btnContrato" data-id="<?php echo $idRegistro ?>"> <i class="fas fa-search">
                              </i>
                            Generar contrato</button>
                            <a class="btn btn-success btn-sm" href="verServiciosProveedor?id=<?php echo $idRegistro; ?>">
                              <i class="fas fa-book">
                              </i>
                              Ver servicios
                          </a>                            
                          <?php } ?>

                          <?php if($tipousuario=='Medico'||$tipousuario=='GestorRed'||$tipousuario=='ConciliacionPagos'||$tipousuario=='GestorMedicamentos'){ ?>
                            <a class="btn btn-info btn-sm" href="editarRegistroRedes?id=<?php echo $idRegistro; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar
                          </a>
                            <a class="btn btn-info btn-sm" href="consultarRegistroRedes?id=<?php echo $idRegistro; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Consultar
                          </a>
                          <a class="btn btn-success btn-sm" href="verServiciosProveedor?id=<?php echo $idRegistro; ?>">
                              <i class="fas fa-book">
                              </i>
                              Ver servicios
                          </a>    
                          <?php } ?>
                          <a class="btn btn-success btn-sm" href="agregaDocumentosProveedor?id=<?php echo $idRegistro; ?>">
                                <i class="fas fa-book">
                                </i>
                                Biblioteca
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

<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
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
            url: 'consultas/consultasActualizaciones',
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
        Eliminar Registro <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
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


<div id="verContrato" class="modal fade" role="dialog">

  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>EMPODERA SALUD</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="generarContrato" method="GET" id="flo" name="flo" onSubmit="CloseModal();">
        <input type="hidden" name="id" name="id" value="">
        <div class="form-group">
                  <label>Nombre Representante Legal</label>
                  <input type="text" class="form-control" id="repLegalEmpodera" name="repLegalEmpodera" placeholder="Representante Legal Empodera" required>
                </div>

                 <div class="form-group">
                  <label>Nombre Representante Legal</label>
                  <input type="text" class="form-control" id="repLegalProvee" name="repLegalProvee" placeholder="Representante Legal Proveedor" required>
                </div>
        <button type="submit" class="btn btn-sm btn-success" id="enviarDatosCon">
        Descargar contrato <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
      </button>
      </form>

          <script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnContrato', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        // alert(uid);
        document.flo.id.value = uid;
      });  
    });

        $('#enviarDatosCon').click(function() {
    setTimeout(function() {$('#verContrato').modal('hide');}, 4000);
});
</script>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function buscarproveedor() { 
    var name = $('#nameprovee').val();
    var rfc = $('#rfcprovee').val();
    var id = $('#entidadFederativa').val();
    var tipoatencion = $('#tipoatencion').val();
    var situacionProveedor = $('#situacionProveedor').val();
    var situacionContrato = $('#situacionContrato').val();
    //alert(id);
    $.ajax({
      type: 'POST',
      url: 'consultas/consultasproveedorservicio2.php',
      data: {'name': name,'rfc': rfc,'id': id,'tipoatencion': tipoatencion,'situacionProveedor':situacionProveedor,'situacionContrato':situacionContrato}
    })
    .done(function(listas_proveedores){
      $('#noProveedor').html(listas_proveedores);
    })
    .fail(function(){
     alert('Sin resultado en la busqueda');
    });
    

  }

</script>

<script>
  $(document).ready(function() {
    $("#pornombre").click(function() {
      $("#divnameprovee").show();
      $("#divrfcprovee").hide();

    });

    $("#porrfc").click(function() {
      $("#divrfcprovee").show();
      $("#divnameprovee").hide();

    });
  });
</script>

