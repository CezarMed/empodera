<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
$usuario=$_SESSION['usuario'];
include('class/autorizarFacturas.php');
//creamo el objeto de la orde de venta class
$NuUs = new autorizaFacturacion_class();
if ($_POST) {
$NuUs->autorizaFactura();
}

if ($_GET['idFactura']!=''&&$_GET['cancelar']=='si') {
    $idFactura=$_GET['idFactura'];
    $idUsuaio=$_SESSION['idUsuario'];
    $motivoCancela=$_GET['motivoCancela'];
    $query = "UPDATE facturasdatosxml SET estatus=5, motivoCancela='$motivoCancela', canceladopor='$usuario' WHERE idFacturas=$idFactura";
    mysqli_query($con,$query);
    $queryUpdate="INSERT INTO movimientosfacturas (idFactura,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idFactura,$idUsuaio,'CANCELAR FACTURA','" . date('Y-m-d H:i:s') ."')";
         $actualizar=mysqli_query($con,$queryUpdate); ?>
         <script type="text/javascript">
              // window.location="validarFacturaProveedor?do=5";
        </script>
<?php } ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VALIDACIÓN DE DATOS DE FACTURACIÓN</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Facturación</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
         
          <div class="card-header">
            <h3 class="card-title">Datos de facturación en XML</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
           <?php
            $idFactura=$_GET['idFactura']; 
            // consulto los datos del XML
            $queryBen= "SELECT * from facturasdatosxml fxml
            INNER JOIN formaspago fp on fp.clave=fxml.formaPago
            inner join metodopago mp on mp.clave=fxml.metodoPago
            inner join regimenfiscal rf on rf.clave=fxml.regimenFiscal
            inner join usocfdi cfdi on cfdi.clave=fxml.UsoCFDI
              where fxml.idFacturas=$idFactura";
              $resBen = mysqli_query($con,$queryBen);
              $extraidoBen= mysqli_fetch_array($resBen);
              $rfcEmisor=$extraidoBen['rfcEmisor'];
              $cpEmisor=$extraidoBen['cpEmisor'];
              $usoCFDI=$extraidoBen['descripcionCFDI'];
            // consuto si el CP es identico al de la base de datos, tabla registros
            $queryProveedor="SELECT * from registros where rfcCedula='$rfcEmisor'";
            $resultadoqueryProveedor=mysqli_query($con,$queryProveedor);
            $registros=mysqli_fetch_array($resultadoqueryProveedor);
            $cpRegistro=$registros['codigoPostal'];            
            ?>

            <?php if ($extraidoBen['comentarios']!=''){ ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">       
                  <div class="callout callout-success">
                    <h5><i class="fas fa-file"></i> <?php echo $extraidoBen['comentarios'] ?></h5>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>


            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color='red'>DATOS DE EMISOR</font></label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>RFC Emisor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['rfcEmisor'] ?>" readonly>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre del emisor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['nombreEmisor']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Regimen fiscal</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['regimenFiscalDescripcion'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Código Postal <?php if ($cpRegistro==$cpEmisor){ ?><font color="green"><i class="fas fa-check"></i></font><?php } else { ?><font color="red"><i class="fas fa-times"></i></font><?php } ?></label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['cpEmisor']; ?>" readonly>
                </div>
              </div>              
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color='red'>DATOS DE RECEPTOR</font></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>RFC Receptor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['rfcReceptor']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Nombre del receptor</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['nombreReceptor']; ?>" readonly>
                </div>
              </div>              
              <div class="col-md-3">
                <div class="form-group">
                  <label>Uso CFDI <?php if ($usoCFDI=='Gastos en general.'){ ?><font color="green"><i class="fas fa-check"></i></font><?php } else { ?><font color="red"><i class="fas fa-times"></i></font><?php } ?></label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['descripcionCFDI']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Código Postal</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['cpReceptor']; ?>" readonly>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color='red'>DATOS DE CONCEPTOS</font></label>
                </div>
              </div>
            </div>
                        <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from facturasdatosxmlconceptos fc
              inner join clavesproductos cp on cp.clave=fc.claveProdServ
              where fc.UUID='".$extraidoBen['UUID']."'";
              $resBen = mysqli_query($con,$queryBen);
              $filasRet = mysqli_num_rows($resBen);
              while ($extraidoCon= mysqli_fetch_array($resBen)) {


            ?>
            <div class="row">
              <div class="col-md-1">
                <div class="form-group">
                  <label>Cantidad</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoCon['Cantidad'] ?>" readonly>
                </div>
              </div> 
              <div class="col-md-1">
                <div class="form-group">
                  <label>Unidad</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoCon['Unidad'] ?>" readonly>
                </div>
              </div> 
              <div class="col-md-2">
                <div class="form-group">
                  <label>Clave</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoCon['clave'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Concepto</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoCon['descripcionProdServ'] ?>" readonly>
                </div>
              </div> 
              <div class="col-md-2">
                <div class="form-group">
                  <label>P/U</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoCon['ValorUnitario'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Importe</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoCon['Importe'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Descripción</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoCon['Descripcion'] ?>" readonly>
                </div>
              </div> 
              
                           
            </div>
          <?php } ?>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label><font color='red'>DATOS DE FACTURA</font></label>
                </div>
              </div>
            </div>

            <div class="row">              
              <div class="col-md-3">
                <div class="form-group">
                  <label>UUID</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['UUID'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Método de Pago</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['descripcion']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Forma de Pago</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['formaPago'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Folio CFDI</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['Folio'] ?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Total</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['Total'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Sub-Total</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['SubTotal']; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Fecha de emisión</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['FechaFactura'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Fecha de timbrado</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoBen['fechaTimbrado']; ?>" readonly>
                </div>
              </div>              
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label><font color='red'>IMPUESTOS TRASLADADOS</font></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo de Impuesto</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo Factor</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tasa</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Importe</label>
                </div>
              </div>
            </div>
            <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from facturasdatosxmlimpuestos fi
              inner join impuestos i on i.clave=fi.impuesto
              where fi.UUID='".$extraidoBen['UUID']."'";
              $resBen = mysqli_query($con,$queryBen);
              $filasRet = mysqli_num_rows($resBen);
              while ($extraidoImp= mysqli_fetch_array($resBen)) {
            ?>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['descripcionImpuesto'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['TipoFactor'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['tasa'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['importe'] ?>" readonly>
                </div>
              </div>
            </div>
          <?php } ?>
          <?php // consulto el total de impuestos trasladados
              $queryBen= "SELECT * from facturasdatosxmlimpuestostotales xmlit
              where xmlit.UUID='".$extraidoBen['UUID']."'";
              $resBen = mysqli_query($con,$queryBen); 
              $registrototalimpuesto=mysqli_fetch_array($resBen);
              $totalImpuestostrasladados=$registrototalimpuesto['TotalImpuestosTrasladados'];
              ?>
          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label><font color='green'>TOTAL DE IMPUESTOS TRASLADADOS </font>$<?php echo $totalImpuestostrasladados ?></label>
                </div>
              </div>
            </div>
          <?php 
              // consulto los datos del XML
              $queryBen= "SELECT * from facturasdatosxmlretenciones xmlr
              inner join impuestos i on i.clave=xmlr.impuesto
              where xmlr.UUID='".$extraidoBen['UUID']."'";
              $resBen = mysqli_query($con,$queryBen);
              $filasRet = mysqli_num_rows($resBen);
          ?>

          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label><font color='red'>IMPUESTOS RETENIDOS</font></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo de Impuesto</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo Factor</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tasa</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Importe</label>
                </div>
              </div>
            </div>            
            <?php
                while ($extraidoImp= mysqli_fetch_array($resBen)) {
            ?>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['descripcionImpuesto'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['TipoFactor'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['tasa'] ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $extraidoImp['importe'] ?>" readonly>
                </div>
              </div>
            </div>
          <?php }  ?>
          <?php // consulto el total de impuestos trasladados
              $queryBen= "SELECT * from facturasdatosxmlretencionestotales xmlit
              where xmlit.UUID='".$extraidoBen['UUID']."'";
              $resBen = mysqli_query($con,$queryBen); 
              $registrototalimpuesto=mysqli_fetch_array($resBen);
              $TotalImpuestosRetenidos=$registrototalimpuesto['TotalImpuestosRetenidos'];
              ?>
          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                  <label><font color='green'>TOTAL DE IMPUESTOS RETENIDOS </font>$<?php echo $TotalImpuestosRetenidos ?></label>
                </div>
              </div>
            </div>
            <?php 
              // consulto los datos del XML
              $querySer= "SELECT * from serviciosfacturasproveedor sf
              INNER JOIN servicios s on s.idServicio=sf.idServicio
              where sf.idFactura=$idFactura";
              $resSer= mysqli_query($con,$querySer);
              $filasSer = mysqli_num_rows($resSer);
            ?>
              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <hr>
                   <label><font color='red'>SERVICIOS ELEGIDOS POR EL PROVEEDOR</font></label>
                </div>
              </div>
            </div>
<form action="" method="POST"> 
  <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
          <div class="table-responsive">
            <table class="table table-striped projects" id="dynamic_field">
                  <tr>
                    <th>Folio del Servicio</th>
                    <th>Tipo de servicio</th>
                    <th>Monto Asociado</th>
                    <th></th>
                  </tr>

             <?php
            $i=0;
            while ($extraidoSer= mysqli_fetch_array($resSer)) {
              $monto=$extraidoSer['montoFacturable'];
              $i++;
            ?>
              <tr id="<?php echo "row".$i.""?>">
                <td>
                  
                  <input type="text" name="folioservicio[]" value="<?php echo $extraidoSer['folioEmpodera'] ?>" class="form-control name_list" /></td>
                <td><input type="text" name="servicio[]" value="<?php echo $extraidoSer['servicio'] ?>" class="form-control name_list" /></td>
                <td><input type="text" name="montofacturable[]" value="<?php echo $extraidoSer['montoFacturable'] ?>" class="form-control name_list" onkeyup="eliminarEspacio()"></td>
                <td>
                  <?php 
                  if ($i<=1) { ?>
                    <button type="button" name="add" id="add" class="btn btn-success">+ Agregar Más</button>                  
                <?php } else { ?>
                  <button type="button" name="remove" id="<?php echo $i ?>" class="btn btn-danger btn_remove">X</button>
                <?php } ?>
                </td>
              </tr>
            <?php } ?>
            <?php if ($monto=='') { ?>
              <tr id="<?php echo "row".$i.""?>">
                <td>
                  
                  <input type="text" name="folioservicio[]" value="<?php echo $extraidoSer['folioEmpodera'] ?>"" class="form-control name_list" /></td>
                <td><input type="text" name="servicio[]" value="<?php echo $extraidoSer['servicio'] ?>" class="form-control name_list" /></td>
                <td><input type="text" name="montofacturable[]" value="<?php echo $extraidoSer['montoFacturable'] ?>" class="form-control name_list" onkeyup="eliminarEspacio()"></td>
                <td>
                    <button type="button" name="add" id="add" class="btn btn-success">+ Agregar Más</button>  
                </td>
              </tr>
            <?php } ?>
            </table>
          </div>

      </div>
    </div>
  </div>

   <div class="row">
    <div class="col-md-12"> 
      <div class="form-group">
<a href="<?php echo $extraidoBen['ArchivoXML'] ?>" target="_blanck"><img src="dist/img/iconoxml.png" width="150px" height="250%"></a>
<a href="<?php echo $extraidoBen['ArchivoPDF'] ?>" target="_blanck"><img src="dist/img/iconopdf.png" width="120px" height="200%"></a>
      </div>
    </div>
  </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                 <textarea class="form-control" placeholder="Colocar las anotaciones pertinenetes" cols="4" rows="3" id="comentariosfactura" name="comentariosfactura"></textarea>
                </div>
              </div>
            </div>
           
          </div>
          <div class="card-footer">
            <?php 
             if ($usoCFDI!='Gastos en general.') {
             $disabled='disabled';
             } else {
            $disabled='';
             }
             ?>
            <input type="hidden" id="autorizaFactura" name="autorizaFactura" value="autorizaFactura">
            <input type="hidden" id="idFactura" name="idFactura" value="<?php echo $idFactura ?>">
            <button type="submit" class="btn btn-success" <?php echo $disabled ?>><i class="fas fa-check">
                              </i> Aprobar factura</button>
                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">
                  <i class="fas fa-trash">
                              </i> Declinar factura
                </button>
            
          </div>

        </div>
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

</body>
</html>
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

<script>
$(document).ready(function(){
  var i=100;
  $('#add').click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="folioservicio[]" placeholder="folio del servicio" class="form-control name_list" /></td><td><input type="text" name="servicio[]" placeholder="Tipo de Servicio" class="form-control name_list" /></td><td><input type="text" name="montofacturable[]" placeholder="Monto aplicable al servicio" class="form-control name_list" onkeyup="eliminarEspacio()"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
  });
  
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });

  
});
</script>

      <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
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
                  <label>Al declinar la factura esta no puede ser enviada de nuevo por filtro de UUID</label>
                  <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" id="motivoCancela" name="motivoCancela" required>
                    <option value="" selected="selected">Elige una opción para cancelar la factura</option>
                    <option value="Falta de informacion">Falta de informacion</option>
                    <option value="Inexactas precisiones">Inexactas precisiones</option>
                    <option value="Cancelacion en SAT">Cancelación en SAT</option>
                    <option value="Pago previamente aplicado">Pago previamente aplicado</option>
                    <option value="Retenciones incorrectamente aplicadas">Retenciones incorrectamente aplicadas</option>
                    <option value="IVA incorrectamente aplicado">IVA incorrectamente aplicado</option>
                    <option value="Impuestos locales incorrectamente aplicados">Impuestos locales incorrectamente aplicados</option>
                    <option value="No correspondiente al año fiscal">No correspondiente al año fiscal</option>
                    <option value="Datos del receptor incorrectos">Datos del receptor incorrectos</option>
                    <option value="Otros">Otros (especifique)</option>
                  </select>
                  <input type="hidden" id="idFactura" name="idFactura" value="<?php echo $idFactura ?>">
                  <input type="hidden" id="cancelar" name="cancelar" value="si">
                </div>
              </div>
              <div class="col-12 col-sm-12" id="comentarios">
                <div class="form-group">
                  <label>Comentarios</label>
                    <textarea class="form-control" rows="3" id="comentariostext" name="comentariostext" required></textarea>
                </div>
              </div>
            </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-outline-light">Declinar factura</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
