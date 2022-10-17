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

 <?php require_once ("encabezadoServicios.php"); ?>


    <section class="content">
      <form action="generarReporteNotasPDF.php" method="POST">
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
            <input type="hidden" id="idServicio" name="idServicio" value="<?php echo $idServicio?>">
            <input type="hidden" id="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario?>">
              <tbody>
                <?php 
                  $nota=0; 
                  $query = "SELECT * from notasmedicas nm
                  INNER JOIN beneficiarios b on b.idBenefeciario=nm.idBeneficiario
                  inner join usuarios u on u.idUsuario=nm.idUsuario 
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
                         $nota=$nota+1;
                  ?>
                  <tr>
                    <td>
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" id="idnotacheck" name="idnotacheck[]" value="<?php echo $idNota?>">
                        </span>
                      </div>

                    </td>
                    <td><font color="red">Nota <?php echo $nota ?>: <?php echo $registro['usuario'] ?></font>  Con fecha de elaboración <?php echo $registro['fechaElaboracion']; ?> siendo las <?php echo $registro['horaElbaora']; ?> se recibe <?php echo $registro['tipoComunicacion']; ?> de <?php echo $registro['nombrecomunica']; ?> petición para seguimiento del Beneficiario <?php echo $registro['nombreBeneficiario']; ?> por motivo de <?php echo $registro['motivoatencion']; ?> <?php if ($resumen!=''){echo $resumen;} ?> <?php if ($exploracionfis!=''){echo $exploracionfis;} ?> <?php if ($resultadoestudios!=''){echo $resultadoestudios;} ?> <?php if ($diagnostico!=''){echo $diagnostico;} ?> <?php if ($planestudios!=''){echo $planestudios;} ?> <?php if ($pronostico!=''){echo $pronostico;} ?> 
                    <br>El costo del servicio es de: <b>$<?php echo $registro['costonota']; ?></b><br>
                    <?php if ($estatus!=4) { ?>
                    <a class="btn btn-info btn-sm" href="editarCostoNota?idNota=<?php echo $idNota; ?>&idBeneficiario=<?php echo $idBeneficiario; ?>&idServicio=<?php echo $idServicio; ?>&idCuenta=<?php echo $idCuenta; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar Costo
                          </a>
                        <?php } ?>
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
                  $nota=0; 
                  $query = "SELECT * from notaspreoperatorias np
                  INNER JOIN beneficiarios b on b.idBenefeciario=np.idBeneficiario
                  inner join usuarios u on u.idUsuario=np.idUsuario  
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
                              $nota=$nota+1;
                  ?>
                  <tr>
                    <td><div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" id="idnotaprecheck" name="idnotaprecheck[]" value="<?php echo $idNotaPreoperatoria?>">
                        </span>
                      </div></td>
                    <td><font color="red">Nota <?php echo $nota ?>: <?php echo $registro['usuario'] ?></font> Con fecha de elaboración <?php echo $registro['fechaElaboracion']; ?> siendo las <?php echo $registro['horaElbaora']; ?> se recibe <?php echo $registro['tipoComunicacion']; ?> de <?php echo $registro['nombrecomunica']; ?> petición para seguimiento del Beneficiario <?php echo $registro['nombreBeneficiario']; ?> por motivo de <?php echo $registro['motivoatencion']; ?> con fecha de cirugia <?php echo $registro['fechaCirugia']; ?> y hora de cirugia <?php echo $registro['horaCirugia']; ?>. <?php if ($diagnostico!=''){echo $diagnostico;} ?> <?php if ($planqui!=''){echo $planqui;} ?> <?php if ($riesgoqui!=''){echo $riesgoqui;} ?> <?php if ($cuidados!=''){echo $cuidados;} ?>
                      
                      <?php if ($estudiosolicitado!=''){?>
                        <br>
                        Se solicito con fecha <?php echo $registro['fechaEstudio']; ?> un estudio de <?php echo $estudiosolicitado ?> <?php if ($problemaclinico!=''){echo $problemaclinico;} ?> <?php if ($incidentesaccidentes!=''){echo $incidentesaccidentes;} ?>
                      <?php } ?>
                      <br>El costo del Servicio es de: <b><font color="red">$<?php echo $registro['honorarios']; ?></font></b>
                      <br>El costo del Cirujano es de: <b>$<?php echo $registro['cirujano']; ?></b>
                      <br>El costo del Anestesiologo es de: <b>$<?php echo $registro['anestesiologo']; ?></b>
                      <br>El costo del Ayudante es de: <b>$<?php echo $registro['ayudante']; ?></b>
                      <br>El costo de enfemeria es de: <b>$<?php echo $registro['enfermeria']; ?></b>
                      <br>El costo del Segundo Ayudante es de: <b>$<?php echo $registro['ayudante2']; ?></b><br>
                      <?php if ($estatus!=4) { ?>
                      <a class="btn btn-info btn-sm" href="editarCostoNotaPre?idNota=<?php echo $idNotaPreoperatoria; ?>&idBeneficiario=<?php echo $idBeneficiario; ?>&idServicio=<?php echo $idServicio; ?>&idCuenta=<?php echo $idCuenta; ?>">
                              <i class="fas fa-edit">
                              </i>
                              Editar Costo
                          </a>
                        <?php } ?>
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
          <h3 class="card-title">Notas administrativas</h3>
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
                $nota=0;
                  $query = "SELECT np.idNotaAdministrativa, np.fechaAlta, np.importancia, np.nota, u.usuario from notasadministrativas np
                  INNER JOIN beneficiarios b on b.idBenefeciario=np.idBeneficiario
                  inner join usuarios u on u.idUsuario=np.idUsuario   
                  where np.idServicio=$idServicio and np.idBeneficiario=$idBeneficiario";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idNotaAdmin=$registro['idNotaAdministrativa'];
                              $nota=$nota+1;
                  ?>
                  <tr>
                    <td><div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" id="idnotaadminheck" name="idnotaadminheck[]" value="<?php echo $idNotaAdmin?>">
                        </span>
                      </div></td>
                    <td><font color="red">Nota <?php echo $nota ?>: <?php echo $registro['usuario'] ?></font> Con fecha de elaboración <?php echo $registro['fechaAlta']; ?> se crea la nota con importancia de tipo <?php echo $registro['importancia']; ?> con el siguiente detalle: <?php echo $registro['nota']; ?>
                      
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
          <h3 class="card-title">Notas Consultas</h3>
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
                $nota=0;
                  $query = "SELECT * from montosconsultas mc
                            inner join datosconsultas dc on dc.idConsulta=mc.idConsulta
                            inner join gruposconsultas gc on gc.Codigo=dc.grupocpt  
                            where mc.estatus=1 and mc.idServicio=$idServicio";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idConsulta=$registro['idConsulta'];
                              $nota=$nota+1;
                  ?>
                  <tr>
                    <td><div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" id="idnotaconsultacheck" name="idnotaconsultacheck[]" value="<?php echo $idConsulta?>">
                        </span>
                      </div></td>
                    <td><font color="red">Nota <?php echo $nota ?>: <?php echo $registro['usuario'] ?></font> Con fecha de elaboración <?php echo $registro['fechaAgrega']; ?> se crea <?php echo $registro['Titulo']; ?> para el medico <?php echo $registro['medico']; ?> por el concepto de <?php echo $registro['consultacpt4']; ?>
                      
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
          <h3 class="card-title">Notas Automáticas</h3>
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
                  $nota=0;
                  $query = "SELECT * from notasautomaticas np
                  inner join usuarios u on u.idUsuario=np.idUsuario
                  where idServicio=$idServicio";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idNotaAdmin=$registro['idNotaAdministrativa'];
                  ?>
                  <tr>
                    <td><div class="input-group-prepend">
                        <span class="input-group-text">
                          <!--input type="checkbox" id="idnotaadminheck" name="idnotaadminheck[]" value="<?php echo $idNotaAdmin?>"-->
                        </span>
                      </div></td>
                    <td><font color="red"><b><?php echo strtoupper($registro['usuario']); ?></b></font> <b> - <?php echo $registro['nota']; ?></b> el día <?php 
                    $fechaCurso=$registro['fechaAlta'];
                    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                    $fecha = strftime("%d %B %Y", strtotime("$fechaCurso"));
                    // echo $registro['fechaAlta']; 
                    echo $fecha ?>
                      
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
          <h3 class="card-title">Notas Conciliación de Pagos</h3>
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
                  $query = "SELECT * from notaspagos np
                  inner join usuarios u on u.idUsuario=np.idUsuarioAgrega  
                  where idServicio=$idServicio";
                  $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $idNotaAdmin=$registro['idNotaAdministrativa'];
                              $nota=$nota+1;

                  ?>
                  <tr>
                    <td><div class="input-group-prepend">
                        <span class="input-group-text">
                          <!--input type="checkbox" id="idnotaadminheck" name="idnotaadminheck[]" value="<?php echo $idNotaAdmin?>"-->
                        </span>
                      </div></td>
                    <td><b><font color="red">Nota <?php echo $nota ?>: <?php echo $registro['usuario'] ?></font> <?php echo $registro['nota']; ?></b> con fecha <?php 
                    $fechaCurso=$registro['fechaAlta'];
                    setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                    $fecha = strftime("%d %B %Y", strtotime("$fechaCurso"));
                    // echo $registro['fechaAlta']; 
                    echo $fecha ?>
                      
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
          <h3 class="card-title">DESCARGAR PDF</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Generar PDF</button>
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




 

