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
    $query = "SELECT * from servicios s
    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario 
    where s.idServicio=$idServicio";
    $res = mysqli_query($con,$query);
    while ($registro = mysqli_fetch_array($res)) {
    ?>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-info"></i>Datos del servicio</h5>
                  Folio de solicitud <b><?php echo $registro['folioEmpodera'] ?></b> para el benefeciario <b><?php echo $registro['nombreBeneficiario'] ?></b> con el servicio solicitado de <b><?php echo $registro['servicio'] ?></b>
                </div>
                </div>
            </div>
      </div>
    </section>
  <?php } ?>

<form action="autorizarNotas.php" method="POST">
    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Notas médicas</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
        <div class="row">
          <table class="table table-striped projects">
              <tbody>
                <?php 
                  $query = "SELECT * from notasmedicas nm
                  INNER JOIN beneficiarios b on b.idBenefeciario=nm.idBeneficiario 
                  where nm.idServicio=$idServicio and nm.idBeneficiario=$idBeneficiario and nm.estatus=1";
                  $res = mysqli_query($con,$query);
                  while ($registro = mysqli_fetch_array($res)) {
                         $idNota=$registro['idNota'];
                         $resumen=$registro['resumen'];
                         $exploracionfis=$registro['exploracionfis'];
                         $resultadoestudios=$registro['resultadoestudios'];
                         $diagnostico=$registro['diagnostico'];
                         $planestudios=$registro['planestudios'];
                         $pronostico=$registro['pronostico'];
                  ?>
                  <tr>
                    <td>
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" id="idnotacheck" name="idnotacheck[]" value="<?php echo $idNota?>">
                          <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio?>">
                          <input type="hidden" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario?>">
                        </span>
                      </div>

                    </td>
                    <td>Con fecha de elaboración <?php echo $registro['fechaElaboracion']; ?> siendo las <?php echo $registro['horaElbaora']; ?> se recibe <?php echo $registro['tipoComunicacion']; ?> de <?php echo $registro['nombrecomunica']; ?> petición para seguimiento del Beneficiario <?php echo $registro['nombreBeneficiario']; ?> por motivo de <?php echo $registro['motivoatencion']; ?> <?php if ($resumen!=''){echo $resumen;} ?> <?php if ($exploracionfis!=''){echo $exploracionfis;} ?> <?php if ($resultadoestudios!=''){echo $resultadoestudios;} ?> <?php if ($diagnostico!=''){echo $diagnostico;} ?> <?php if ($planestudios!=''){echo $planestudios;} ?> <?php if ($pronostico!=''){echo $pronostico;} ?> 
                    <br>El costo del servicio es de: <b>$<?php echo $registro['costonota']; ?></b><br>
                    <a class="btn btn-info btn-sm" href="editarCostoNota?idNota=<?php echo $idNota; ?>&idBeneficiario=<?php echo $idBeneficiario; ?>&idServicio=<?php echo $idServicio; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar Costo
                          </a>
                    
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Notas preoperatorias</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <tbody>
                <?php 
                  $query = "SELECT * from notaspreoperatorias np
                  INNER JOIN beneficiarios b on b.idBenefeciario=np.idBeneficiario 
                  where np.idServicio=$idServicio and np.idBeneficiario=$idBeneficiario and np.estatus=1";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $diagnostico=$registro['diagnostico'];
                              $planqui=$registro['planqui'];
                              $riesgoqui=$registro['riesgoqui'];
                              $cuidados=$registro['cuidados'];
                              $estudiosolicitado=$registro['estudiosolicitado'];
                              $problemaclinico=$registro['problemaclinico'];
                              $incidentesaccidentes=$registro['incidentesaccidentes'];
                              $idNotaPreoperatoria=$registro['idNotaPreoperatoria'];

                  ?>
                  <tr>
                    <td><div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" id="idnotaprecheck" name="idnotaprecheck[]" value="<?php echo $idNotaPreoperatoria?>">
                        </span>
                      </div></td>
                    <td>Con fecha de elaboración <?php echo $registro['fechaElaboracion']; ?> siendo las <?php echo $registro['horaElbaora']; ?> se recibe <?php echo $registro['tipoComunicacion']; ?> de <?php echo $registro['nombrecomunica']; ?> petición para seguimiento del Beneficiario <?php echo $registro['nombreBeneficiario']; ?> por motivo de <?php echo $registro['motivoatencion']; ?> con fecha de cirugia <?php echo $registro['fechaCirugia']; ?> y hora de cirugia <?php echo $registro['horaCirugia']; ?>. <?php if ($diagnostico!=''){echo $diagnostico;} ?> <?php if ($planqui!=''){echo $planqui;} ?> <?php if ($riesgoqui!=''){echo $riesgoqui;} ?> <?php if ($cuidados!=''){echo $cuidados;} ?>
                      
                      <?php if ($estudiosolicitado!='') {?>
                        <br>
                        Se solicito con fecha <?php echo $registro['fechaEstudio']; ?> un estudio de <?php echo $estudiosolicitado ?> <?php if ($problemaclinico!=''){echo $problemaclinico;} ?> <?php if ($incidentesaccidentes!=''){echo $incidentesaccidentes;} ?>
                      <?php } ?>
                      <br>El costo del servicio es de: <b>$<?php echo $registro['costonota']; ?></b><br>
                      <a class="btn btn-info btn-sm" href="editarCostoNotaPre?idNota=<?php echo $idNotaPreoperatoria; ?>&idBeneficiario=<?php echo $idBeneficiario; ?>&idServicio=<?php echo $idServicio; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar Costo
                          </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
          </table>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">AUTORIZACIÓN DE PAGO</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Autorizar Notas</button>
          </div>
        </div>
      </div>
    </section>

    <form>

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




 

