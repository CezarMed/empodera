<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notas del servicio</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Notas médicas</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php
    $idBeneficiario=$_GET['idBeneficiario'];
    $idServicio=$_GET['idServicio'];
    $idProveedor=$_GET['idProveedor'];
    $servicioprincipal=$_GET['servicioprincipal'];

    $query = "SELECT * from servicios s
    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario 
    where s.idServicio=$idServicio";
    $res = mysqli_query($con,$query);
    while ($registro = mysqli_fetch_array($res)) {
      $folioEmpodera=$registro['folioEmpodera'];
    ?>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-info"></i>Datos del servicio</h5>
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
      </div>
    </section>
  <?php } ?>


    <?php
    if ($servicioprincipal==0) { 
    $query2 = "SELECT * from solicitudmedicamentos sm
    INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
    INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
    INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
    INNER JOIN registros r on r.idRegistro=sc.idProveedor
    INNER JOIN servicios s on s.idServicio=sm.idServicio
    where sm.idServicio=$idServicio and sc.idProveedor=$idProveedor and scm.elegido=1  GROUP BY r.idRegistro";
    } else {
    $query2 = "SELECT * from solicitudmedicamentos sm
    INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
    INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
    INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
    INNER JOIN registros r on r.idRegistro=sc.idProveedor
    INNER JOIN servicios s on s.idServicio=sm.idServicio
    where sm.idServicio=$servicioprincipal and sc.idProveedor=$idProveedor and scm.elegido=1  GROUP BY r.idRegistro";
    }
    $res2 = mysqli_query($con,$query2);
    while ($registros = mysqli_fetch_array($res2)) {
      $idProveedor=$registros['idProveedor'];
    ?>
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Generar Carta Garantía de Pago</h3>
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
                  <label>Datos del servicio con el proveedor</label>
                  <p>El proveedor <b><?php echo $registros['nombreComercial'] ?></b> fue el seleccionado para el servicio del beneficiario <b><?php echo $registros['nombreBeneficiario'] ?></b> con el folio del servicio <b><?php echo $folioEmpodera ?></b></p>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
          <div class="card-footer">
            <a class="btn btn-success btn-sm" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $idProveedor ?>&servicioprincipal=<?php echo $servicioprincipal ?>" target="_blank" >                              
                              Generar Carta Garantía de Pago 
                          </a>
          </div>
        </div>  
          </div> 
        </div>
        </div>
    </section>
  <?php } ?>

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




 

