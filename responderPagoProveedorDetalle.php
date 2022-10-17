<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
$grupo=$_GET['grupo'];
$idGrupo=$_GET['idGrupo'];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Grupos de facturas para validar</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Facturación</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>  

    <!-- Main content -->
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de grupos de facturas a validar</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0" id="datosListado">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>Servicio</th>
                      <th>Beneficiario</th>
                      <th>Tipo de apoyo</th>
                      <th>Monto autorizado</th>
                      <th>Nombre Emisor</th>
                      <th>RFC Emisor</th>
                      <th>Fecha Emisión</th>
                      <th>Folio Fiscal</th>
                      <th>Neto a liquidar</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                <?php 
                  $query = "SELECT gf.idGrupoFactura, gf.idFactura, s.folioEmpodera, b.nombreBeneficiario, fxml.tipoPagoFactura, s.servicio, gf.estatus, u.usuario, s.monto, fxml.nombreEmisor, fxml.rfcEmisor, fxml.FechaFactura, fxml.Folio, fxml.UUID, fxml.moneda, fxml.Total, imp.TotalImpuestosTrasladados, isr.TotalImpuestosRetenidos, reg.idBanco, reg.cuentaBancaria, reg.cuentaClabe, reg.idRegistro, gf.grupo, gf.idGrupoConsecutivo from gruposfacturas gf 
                  inner join facturasdatosxml fxml on fxml.idFacturas=gf.idFactura
                  inner join serviciosfacturasproveedor sfp on sfp.idFactura=fxml.idFacturas
                  inner join servicios s on s.idServicio=sfp.idServicio
                  inner join beneficiarios b on b.idBenefeciario=s.idBeneficiario
                  inner join usuarios u on u.idUsuario=s.idUsuario
                  left join facturasdatosxmlimpuestostotales imp on imp.UUID=fxml.UUID
                  left join facturasdatosxmlretencionestotales isr on isr.UUID=fxml.UUID
                  left join registros reg on reg.rfcCedula=fxml.rfcEmisor
                  where gf.grupo='$grupo' and gf.idGrupoConsecutivo=$idGrupo and gf.estatus=8";
                  $res = mysqli_query($con,$query);
                      while ($registro = mysqli_fetch_array($res)) {
                        $verdatos=$registro[0]."|".
                                  $registro[1];
                        // sumo el copago
                  ?>
                      <tr>
                       <td><?php echo $registro['folioEmpodera'] ?></td>
                       <td><?php echo $registro['nombreBeneficiario'] ?></td>
                       <td><?php echo $registro['tipoPagoFactura'] ?>-<?php echo $registro['servicio'] ?></td>
                       <td>$<?php echo $registro['monto'] ?></td>
                       <td><?php echo $registro['nombreEmisor'] ?></td>
                       <td><?php echo $registro['rfcEmisor'] ?></td>
                       <td><?php echo $registro['FechaFactura'] ?></td>
                       <td><?php echo $registro['UUID'] ?></td>
                       <td>$<?php echo $registro['Total'] ?></td>
                       <td><a class="btn btn-info btn-sm" href="enviarPagoFacturaCliente?idFactura=<?php echo $registro['idFactura'] ?>&idGruposFacturas=<?php echo $registro['idGrupoFactura'] ?>"><i class="fas fa-check"></i>
                              Agregar Pago
                          </a></td>
                  </tr>
                <?php } ?>
                  
              </tbody>
          </table>
        </div>
         <div class="card-footer">
              <a class="btn btn-info" href="verFacturasGruposExcel?grupo=<?php echo $grupo ?>&idGrupo=<?php echo $idGrupo ?>">
                              <i class="fas fa-file-excel"></i>
                              Descargar excel para el Grupo <?php echo $grupo ?>_<?php echo $idGrupo ?>
                          </a>
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
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<script type="text/javascript">
  function agregadatos(datos){
    d=datos.split('|');    
    $('#idFacturaGrupo').val(d[0]);
    $('#idFactura').val(d[1]);
  }
  function agregadatos2(datos){
    d=datos.split('|');    
    $('#idFacturaGrupo2').val(d[0]);
    $('#idFactura2').val(d[1]);
  }
</script>

<div id="recibirFactura" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>VALIDACION DE FACTURAS</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="tablaResult">
              <div class="col-md-12">
                  <input type="hidden" id="idFacturaGrupo" name="idFacturaGrupo">
                  <input type="hidden" id="idFactura" name="idFactura">
              </div>

              <div class="card-footer">
            <button type="button" class="btn btn-success" onclick="recibirFacturaF()">Recibir</button>
            </div>
          </div>   
    </div>
  </div>
</div>

<script type="text/javascript">
  function recibirFacturaF(){
    var idFacturaGrupo=$('#idFacturaGrupo').val();
    var idFactura=$('#idFactura').val(); 
        $.ajax({
            url: 'consultas/recibirFacturaGrupo.php',
            type: "POST",
            data: {"idFacturaGrupo":idFacturaGrupo,"idFactura":idFactura},
            success: function (cmb) {
              // alert(cmb);
              // window.location="verFacturasGrupos";
              $("#datosListado").load(" #datosListado");
               $('#recibirFactura').modal('hide');
               $('.modal-backdrop').remove();
                 $(function() {
                  var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                  });

                  $(document).ready(function() {
                    Toast.fire({
                      icon: 'success',
                      title: ' La factura se envio correctamente'
                    })
                  });
                  });                
            }
        });        
  }
</script>

<div id="rechazarFactura" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>VALIDACION DE FACTURAS</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="tablaResult">
              <div class="col-md-12">
                  <input type="hidden" id="idFacturaGrupo2" name="idFacturaGrupo2">
                  <input type="hidden" id="idFactura2" name="idFactura2">
              </div>

              <div class="card-footer">
            <button type="button" class="btn btn-danger" onclick="rechazarFacturaF()">Rechazar</button>
            </div>
          </div>   
    </div>
  </div>
</div>