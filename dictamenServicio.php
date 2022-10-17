<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
// agrego la clase
include('class/altaDictamen.php');
$NuUs = new Altadictamen_class();
if ($_POST) {
$NuUs->altaDictamen();
}
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DICTAMEN DEL SERVICIO</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Dictamen</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <?php 
    $idServicio=$_GET['idServicio'];
    $idBeneficiario=$_GET['idBeneficiario'];
    $idProveedor=$_GET['idProveedor'];
    $servicioprincipal=$_GET['servicioprincipal'];
    $idCuenta=$_GET['idCuenta'];

    //consulto datos del servicio
    $queryCie = "SELECT * from servicios
    where idServicio=$idServicio";
    $resCie = mysqli_query($con,$queryCie);
    $extraidoCie= mysqli_fetch_array($resCie);
    $servicio=$extraidoCie['servicio'];
    $folioEmpodera=$extraidoCie['folioEmpodera'];
    $fechaAlta=$extraidoCie['fechaAlta'];
    $monto=$extraidoCie['monto'];
    $notasCarta=$extraidoCie['notasCarta'];

    // creo la consulta si es recotizacion mando a 0 el servicio principal para que consulte por el servicio normal
    $queryCie = "SELECT count(*) totalReg from servicios
    where idServicio=$idServicio and observaciones like '%RECOTIZAR %'";
    $resCie = mysqli_query($con,$queryCie);
    $extraidoCie= mysqli_fetch_array($resCie);
    $totalReg=$extraidoCie['totalReg'];
    if ($totalReg>=1){
     $servicioprincipal=0; 
    }
    ?>
    <?php require_once ("encabezadoServicios.php"); ?>
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">         
          <div class="card-header">
            <h3 class="card-title">Dictamen del servicio</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Folio del servicio</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $folioEmpodera ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo del servicio</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $servicio ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Fecha de solicitud del servicio</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $fechaAlta ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Monto autorizado</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $monto ?>" readonly>
                </div>
              </div>
            </div>

                <?php 

              //consulto datos del beneficiario
              $queryBen= "SELECT * from beneficiarios
              where idBenefeciario=$idBeneficiario";
              $resBen = mysqli_query($con,$queryBen);
              $extraidoBen= mysqli_fetch_array($resBen);
              $nombreBeneficiario=$extraidoBen['nombreBeneficiario'];
              $fechaNac=$extraidoBen['fechaNacimiento'];
              list($anio, $mes, $dia) = explode("-", $fechaNac);
              $yearh=date('Y');
              $edad=$yearh-$anio;
              ?>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nombre del Beneficiario</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $nombreBeneficiario ?>" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Fecha de Nacimiento</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $fechaNac ?>" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Edad</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="<?php echo $edad ?>" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Sexo</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="H" readonly>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Genero</label>
                 <input type="text" class="form-control" id="folio" name="folio" value="H" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">       
                  <div class="callout callout-info">
                    <h5><i class="fas fa-file"></i> Gastos Hospitalarios</h5>
                    <table class="table table-striped projects" id="datosGastosMedicos">
              <thead>
                <?php 
                  $queryCopagos = "SELECT * FROM gastosmedicos gm  
                  where gm.idServicio=$idServicio";
                  $resCopagos = mysqli_query($con,$queryCopagos); 
                ?>
                  <tr>
                      <th>
                          Concepto
                      </th>
                      <th>
                          Monto
                      </th>
                      <th>
                          Fecha de Carga
                      </th>
                      <th>
                          
                      </th>  

                  </tr>
              </thead>
              <tbody>
                  <?php
                  while ($copagos = mysqli_fetch_array($resCopagos)) {
                    $montoGaasto=$copagos['monto'];
                             $datos3=$copagos[0]."||".
                             $copagos[1]."||".
                             $copagos[2]."||".
                             $copagos[3]."||".
                             $copagos[4]."||".
                             $copagos[5];

                  ?>
                  <tr>
                      <td><?php echo $copagos['concepto'] ?>
                      </td>
                      <td>$<?php echo number_format($copagos['monto'], 2, '.', ',')  ?></td>
                      <td><?php echo $copagos['fechaSubida'] ?></td>
                      <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editaGastoMedico" id="btnView" data-id="<?php echo $registro['idCopago'] ?>" onclick="agregaform3('<?php echo $datos3 ?>')"> <i class="fas fa-edit">
                              </i>
                      </button></td>
                  </tr>
                <?php } ?>
                </tbody>
          </table>
                  <?php if ($montoGaasto=='') { ?>
                 <button type="button" class="btn btn-app bg-info" data-toggle="modal" data-target="#agregarGastoMedico" id="btnView" data-id="<?php echo $registro['idCopago'] ?>"> <i class="fas fa-credit-card">
                              </i>
                      </button>
                      <?php } ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">       
                  <div class="callout callout-success">
                    <h5><i class="fas fa-file"></i> Honorarios Médicos</h5>
                    <?php 
                  $query = "SELECT * from notasmedicas nm
                  INNER JOIN beneficiarios b on b.idBenefeciario=nm.idBeneficiario 
                  where nm.idServicio=$idServicio and nm.idBeneficiario=$idBeneficiario";
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
                   <i class="fas fa-check"></i> Con fecha de elaboración <?php echo $registro['fechaElaboracion']; ?> siendo las <?php echo $registro['horaElbaora']; ?> se recibe <?php echo $registro['tipoComunicacion']; ?> de <?php echo $registro['nombrecomunica']; ?> petición para seguimiento del Beneficiario <?php echo $registro['nombreBeneficiario']; ?> por motivo de <?php echo $registro['motivoatencion']; ?> <?php if ($resumen!=''){echo $resumen;} ?> <?php if ($exploracionfis!=''){echo $exploracionfis;} ?> <?php if ($resultadoestudios!=''){echo $resultadoestudios;} ?> <?php if ($diagnostico!=''){echo $diagnostico;} ?> <?php if ($planestudios!=''){echo $planestudios;} ?> <?php if ($pronostico!=''){echo $pronostico;} ?> 
                    <br>El costo del servicio es de: <b>$<?php echo number_format($registro['costonota'], 2, '.', ',')  ?></b><br>
                  <?php } ?>

                  <?php 
                  $query = "SELECT * from montosconsultas mc
                            inner join datosconsultas dc on dc.idConsulta=mc.idConsulta
                            inner join gruposconsultas gc on gc.Codigo=dc.grupocpt 
                            where mc.estatus=1 and mc.idServicio=$idServicio";
                  $res = mysqli_query($con,$query);
                  while ($registro = mysqli_fetch_array($res)) {
                  ?>
                   <i class="fas fa-check"></i> Con fecha de elaboración <?php echo $registro['fechaAgrega']; ?> se crea <?php echo $registro['Titulo']; ?> para el medico <?php echo $registro['medico']; ?> por el concepto de <?php echo $registro['consultacpt4']; ?>
                    <br>El costo del servicio es de: <b>$<?php echo number_format($registro['monto'], 2, '.', ',')  ?></b><br>
                  <?php } ?>

                 <?php 
                  $query = "SELECT * from notaspreoperatorias np
                  INNER JOIN beneficiarios b on b.idBenefeciario=np.idBeneficiario 
                  where np.idServicio=$idServicio and np.idBeneficiario=$idBeneficiario";
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
                   <i class="fas fa-check"></i> Con fecha de elaboración <?php echo $registro['fechaElaboracion']; ?> siendo las <?php echo $registro['horaElbaora']; ?> se recibe <?php echo $registro['tipoComunicacion']; ?> de <?php echo $registro['nombrecomunica']; ?> petición para seguimiento del Beneficiario <?php echo $registro['nombreBeneficiario']; ?> por motivo de <?php echo $registro['motivoatencion']; ?> con fecha de cirugia <?php echo $registro['fechaCirugia']; ?> y hora de cirugia <?php echo $registro['horaCirugia']; ?>. <?php if ($diagnostico!=''){echo $diagnostico;} ?> <?php if ($planqui!=''){echo $planqui;} ?> <?php if ($riesgoqui!=''){echo $riesgoqui;} ?> <?php if ($cuidados!=''){echo $cuidados;} ?>
                      
                      <?php if ($estudiosolicitado!='') {?>
                        <br>
                        Se solicito con fecha <?php echo $registro['fechaEstudio']; ?> un estudio de <?php echo $estudiosolicitado ?> <?php if ($problemaclinico!=''){echo $problemaclinico;} ?> <?php if ($incidentesaccidentes!=''){echo $incidentesaccidentes;} ?>
                      <?php } ?>
                      <br>El costo del Cirujano es de: <b>$<?php echo number_format($registro['cirujano'], 2, '.', ','); ?></b>
                      <br>El costo del Anestesiologo es de: <b>$<?php echo number_format($registro['anestesiologo'], 2, '.', ','); ?></b>
                      <br>El costo del Ayudante es de: <b>$<?php echo number_format($registro['ayudante'], 2, '.', ','); ?></b>
                      <br>El costo de Enfermeria es de: <b>$<?php echo number_format($registro['enfermeria'], 2, '.', ','); ?></b>
                      <br>El costo del Segundo Ayudante es de: <b>$<?php echo number_format($registro['ayudante2'], 2, '.', ','); ?></b><br>
                    <?php } ?>
                    <br><label>Total de honorarios autorizados</label>
                 <?php 
                  $querytotalmed="SELECT sum(gm.monto) as gastosmedicos from gastosmedicos gm  where gm.idServicio=$idServicio and estatus=1";
                  $restotalnotas = mysqli_query($con,$querytotalmed);
                  $extraidotot= mysqli_fetch_array($restotalnotas);
                  $gastosmedicos=$extraidotot['gastosmedicos'];
                  $querytotalmed="SELECT sum(nm.costonota) as totalmedicas from notasmedicas nm  where idServicio=$idServicio and estatus=1";
                  $restotalnotas = mysqli_query($con,$querytotalmed);
                  $extraidotot= mysqli_fetch_array($restotalnotas);
                  $totalmedicas=$extraidotot['totalmedicas'];
                  $querytotalmed2="SELECT sum(np.cirujano)+(np.anestesiologo)+(np.ayudante)+(np.enfermeria)+(np.ayudante2) as totalmedicas2 from notaspreoperatorias np  where idServicio=$idServicio and estatus=1";
                  $restotalnotas2 = mysqli_query($con,$querytotalmed2);
                  $extraidotot2= mysqli_fetch_array($restotalnotas2);
                  $totalmedicas2=$extraidotot2['totalmedicas2'];
                  $querynotas="SELECT sum(monto) as toalconsultas from montosconsultas mc
                                where mc.estatus=1 and mc.idServicio=$idServicio";
                  $resnotas = mysqli_query($con,$querynotas);
                  $extraidonotas=mysqli_fetch_array($resnotas);
                  $totalconsultas=$extraidonotas['toalconsultas'];
                  $total=$gastosmedicos+$totalmedicas+$totalmedicas2+$totalconsultas;
                  ?>
                 <P> El total de las notas autorizadas hasta este momento es de: <b><font color="red">$<?php echo number_format($total, 2, '.', ',') ?></font></b></p>
                  <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>" target="_blanck">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Editar notas
                </a>
                  </div>                 
                </div>
              </div>
            </div>

             <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="callout callout-danger">
                    <h5><i class="fas fa-credit-card"></i> Notas Administrativas</h5>
                    <?php 
                  $query = "SELECT np.idNotaAdministrativa, np.fechaAlta, np.importancia, np.nota from notasadministrativas np
                  INNER JOIN beneficiarios b on b.idBenefeciario=np.idBeneficiario 
                  where np.idServicio=$idServicio and np.idBeneficiario=$idBeneficiario and np.importancia='Alta'";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {

                  ?> 
                   <i class="fas fa-check"></i> Con fecha de elaboración <?php echo $registro['fechaAlta']; ?>  se registro la siguiente nota: <?php echo $registro['nota']; ?><br> 
                 <?php } ?>
                  </div>
                </div>
              </div>
              </div>

            

            <?php if ($servicio=='MEDICAMENTOS') { ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="callout callout-danger">
                    <h5><i class="fas fa-credit-card"></i> Solicitud de medicamentos</h5>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
              <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          Proveedor
                      </th>
                      <th>
                          Medicamento
                      </th>
                      <th>
                          Gramaje
                      </th>
                      <th>
                          Presentación
                      </th>
                      <th>
                          Cantidad
                      </th>
                      <th>
                          Costo total
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                  <?php
if ($servicioprincipal==0){
    $query = "SELECT * from solicitudmedicamentos sm
    INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
    INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
    INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
    INNER JOIN medicamentossolicitados ms on ms.idMedicamento=scm.idProductoSolicitud
    INNER JOIN registros r on r.idRegistro=sc.idProveedor
    INNER JOIN servicios s on s.idServicio=sm.idServicio
    INNER JOIN servicioscerradosproveedor scp on scp.idServicio=s.idServicio
    INNER JOIN estados e on e.idEstado=r.entidadFederativa
    where sm.idServicio=$idServicio and sc.idProveedor=$idProveedor and scm.elegido=1";
} else {
    $query = "SELECT * from solicitudmedicamentos sm
    INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
    INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
    INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
    INNER JOIN medicamentossolicitados ms on ms.idMedicamento=scm.idProductoSolicitud
    INNER JOIN registros r on r.idRegistro=sc.idProveedor
    INNER JOIN servicios s on s.idServicio=sm.idServicio
    INNER JOIN servicioscerradosproveedor scp on scp.idServicio=s.idServicio
    INNER JOIN estados e on e.idEstado=r.entidadFederativa
    where sm.idServicio=$servicioprincipal and sc.idProveedor=$idProveedor and scm.elegido=1";
}
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $proveedormedicamento=$registro['nombreComercial'] ;
                              $totalmEDI=$totalmEDI+$registro['costototal'];
                  ?>
                    <tr>
                    <td><?php echo $registro['nombreComercial'] ?>
                      </td>
                    <td><?php echo $registro['medicamento'] ?>
                      </td>
                      <td><?php echo $registro['gramaje'] ?>
                      </td>
                      <td>
                          <?php echo $registro['presentacion'] ?>
                      </td>
                      <td>
                          <?php echo $registro['cantidad'] ?>
                      </td>
                      <td>
                          $<?php echo $registro['costototal'] ?>
                      </td>
                  </tr>
                <?php } ?>
                <tr>
                    <td colspan="5">TOTAL DE MEDICAMENTOS
                      </td>
                      <td>
                          <?php echo $totalmEDI ?>
                      </td>
                  </tr>
                </tbody>
          </table>
                </div>
              </div>
            </div>
          <?php } ?>

           <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <div class="callout callout-warning">
                    <h5><i class="fas fa-credit-card"></i> Copagos Asignados</h5>
                    <table class="table table-striped projects" id="datosCopagos">
              <thead>
                <?php
                  $queryCopagosCount = "SELECT count(*) totalPagados FROM copagosasignados ca 
                  inner join archivoscopagos ac on ac.idCopago=ca.idCopago  
                  where ca.idServicio=$idServicio and ac.tipocopago='Pagado' and ca.estatus=1";
                  $resCopagosCount = mysqli_query($con,$queryCopagosCount); 
                  $copagosCount = mysqli_fetch_array($resCopagosCount);
                  $totalPagados=$copagosCount['totalPagados'];

                  $queryCopagosCount = "SELECT sum(montoAsignado) copagosasignados FROM copagosasignados ca 
                  inner join archivoscopagos ac on ac.idCopago=ca.idCopago  
                  where ca.idServicio=$idServicio and ca.estatus=1";
                  $resCopagosCount = mysqli_query($con,$queryCopagosCount); 
                  $copagosCount = mysqli_fetch_array($resCopagosCount);
                  $copagosasignados=$copagosCount['copagosasignados'];

                  $queryCopagos = "SELECT * FROM copagosasignados ca 
                  inner join archivoscopagos ac on ac.idCopago=ca.idCopago  
                  where ca.idServicio=$idServicio";
                  $resCopagos = mysqli_query($con,$queryCopagos); 
                ?>
                  <tr>
                      <th>
                          Tipo de Copago
                      </th>
                      <th>
                          Archivo
                      </th>
                      <th>
                          Monto asignado
                      </th>
                      <th>
                          Fecha de asignación
                      </th>
                      
                  </tr>
              </thead>
              <tbody>
                  <?php
                  while ($copagos = mysqli_fetch_array($resCopagos)) {
                    $datos=$copagos[0]."||".
                             $copagos[1]."||".
                             $copagos[2]."||".
                             $copagos[3]."||".
                             $copagos[4]."||".
                             $copagos[5]."||".
                             $copagos[6]."||".
                             $copagos[7]."||".
                             $copagos[8]."||".
                             $copagos[9]."||".
                             $copagos[10]."||".
                             $copagos[11]."||".
                             $copagos[12];
                  ?>
                    <tr>
                    <td><?php echo $copagos['tipocopago'] ?>
                      </td>
                    <td><?php if ($copagos['archivo']!='-'){ ?><a href="<?php echo $copagos['archivo'] ?>" target="_blanck"><img src="dist/img/iconfile.png"></a><?php } ?>
                      </td>
                      <td>$<?php echo number_format($copagos['montoAsignado'], 2, '.', ',') ?>
                      <?php if ($copagos['tipocopago']=='Pagado') { ?><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editaCopago" id="btnView" data-id="<?php echo $registro['idCopago'] ?>" onclick="agregaform('<?php echo $datos ?>')"> <i class="fas fa-edit">
                              </i>
                      </button><?php } ?>
                      </td>
                      <td><?php echo $copagos['fechaAsigna'] ?></td>
                  </tr>
                <?php } ?>
                </tbody>
          </table>
          <?php if ($totalPagados<=0) { ?>
          <button type="button" class="btn btn-app bg-warning" data-toggle="modal" data-target="#agregarCopago" id="btnView" data-id="<?php echo $registro['idCopago'] ?>"> <i class="fas fa-credit-card">
                              </i>
                      </button>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
              
                </div>
              </div>
            </div>



           <div class="row">
              <div class="col-md-12">
                <div class="form-group" >
                  <div class="callout callout-warning">
                    <h5><i class="fas fa-credit-card"></i> Contribución Inicial</h5>
            <table class="table table-striped projects" id="datosContribucion">
              <thead>
                <?php 

                  $queryCopagosCount = "SELECT count(*) totalPagados FROM contribucionesasignadas ca 
                  inner join archivoscontribucion ac on ac.idContribucion=ca.idCopago  
                  where ca.idServicio=$idServicio and ac.tipocopago='Pagado' and ca.estatus=1";
                  $resCopagosCount = mysqli_query($con,$queryCopagosCount); 
                  $copagosCount = mysqli_fetch_array($resCopagosCount);
                  $totalcontribucionpagadas=$copagosCount['totalPagados'];

                  $queryCopagosCount = "SELECT sum(montoAsignado) totalcontribuciones FROM contribucionesasignadas ca 
                  inner join archivoscontribucion ac on ac.idContribucion=ca.idCopago  
                  where ca.idServicio=$idServicio and ca.estatus=1";
                  $resCopagosCount = mysqli_query($con,$queryCopagosCount); 
                  $copagosCount = mysqli_fetch_array($resCopagosCount);
                  $totalcontribuciones=$copagosCount['totalcontribuciones'];



                  $queryCopagos = "SELECT * FROM contribucionesasignadas ca 
                  inner join archivoscontribucion ac on ac.idContribucion=ca.idCopago  
                  where ca.idServicio=$idServicio";
                  $resCopagos = mysqli_query($con,$queryCopagos); 
                ?>
                  <tr>
                      <th>
                          Tipo de Contribucion
                      </th>
                      <th>
                          Archivo
                      </th>
                      <th>
                          Monto
                      </th>
                      <th>
                          Fecha de asignación
                      </th>                      
                  </tr>
              </thead>
              <tbody>
                  <?php
                  while ($copagos = mysqli_fetch_array($resCopagos)) {
                             $datos2=$copagos[0]."||".
                             $copagos[1]."||".
                             $copagos[2]."||".
                             $copagos[3]."||".
                             $copagos[4]."||".
                             $copagos[5]."||".
                             $copagos[6]."||".
                             $copagos[7]."||".
                             $copagos[8]."||".
                             $copagos[9]."||".
                             $copagos[10]."||".
                             $copagos[11]."||".
                             $copagos[12];

                  ?>
                  <tr>
                    <td><?php echo $copagos['tipocopago'] ?>
                      </td>
                    <td><?php if ($copagos['archivo']!='-'){ ?><a href="<?php echo $copagos['archivo'] ?>" target="_blanck"><img src="dist/img/iconfile.png"></a><?php } ?>
                      </td>
                      <td>$<?php echo number_format($copagos['montoAsignado'], 2, '.', ',') ?><?php if ($copagos['tipocopago']=='Pagado') { ?><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editaContribucion" id="btnView" data-id="<?php echo $registro['idCopago'] ?>" onclick="agregaform2('<?php echo $datos2 ?>')"> <i class="fas fa-edit">
                              </i>
                      </button><?php } ?></td>
                      <td><?php echo $copagos['fechaSubida'] ?></td>
                  </tr>
                <?php } ?>
                </tbody>
          </table>
          <?php if ($totalcontribucionpagadas<=0) { ?>
          <button type="button" class="btn btn-app bg-warning" data-toggle="modal" data-target="#agregarContribucion" id="btnView" data-id="<?php echo $registro['idCopago'] ?>" onclick="agregaform2('<?php echo $datos ?>')"> <i class="fas fa-credit-card">
                              </i>
                      </button>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>



            <?php if ($servicio!='MEDICAMENTOS') { ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="callout callout-danger">
                    <h5><i class="fas fa-credit-card"></i> Proveedor Asignado</h5>
                    <div class="col-md-12">
                <div class="form-group">
                  <?php 
                  $query = "SELECT * FROM servicioscerradosproveedor scp
                  INNER JOIN registros r on r.idRegistro=scp.proveedorname
                  where scp.idServicio=$idServicio and scp.estatus=1";
                            $res = mysqli_query($con,$query);
                            while ($registro = mysqli_fetch_array($res)) {
                              $proveedorservicio=$registro['nombreComercial'];
                  ?>
                  El servicio ya fue asignado al proveedor <b><?php echo $registro['nombreComercial'] ?></b> con fecha <?php echo $registro['fechaRegistro'] ?> con las siguientes notas: <?php echo $registro['contenidonota'] ?>
                <?php } ?>

                </div>
              </div>
                  </div>
                </div>
              </div>
              
            </div>
          <?php } ?>

          <?php 
          $totalFacturar=$totalmEDI+$total-$totalAbonos-$totalcontribuciones-$copagosasignados;
          ?>

          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="callout callout-success">
                    <h5><i class="fas fa-credit-card"></i> TOTAL A FACTURAR <br><font color="red" size="18">$<?php echo number_format($totalFacturar, 2, '.', ',') ?></font></h5>
                    
                  </div>
                </div>
              </div>
            </div>


            <?php
            //consulto datos del servicio
            $queryDic = "SELECT count(*) totalDictamen, fechaGeneraDictamen, idDictamenGenerado from dictamenesgenerados
            where idServicio=$idServicio and estatus=1";
            $resDic = mysqli_query($con,$queryDic);
            $extraidoDic= mysqli_fetch_array($resDic);
            $totalDictamen=$extraidoDic['totalDictamen'];
            $fechaGeneraDictamen=$extraidoDic['fechaGeneraDictamen'];
            $idDictamenGenerado=$extraidoDic['idDictamenGenerado'];
            if ($totalDictamen==0) {
            ?>
            <form id="formOne" action="" method="POST" autocomplete="off">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Observaciones en Carta</label>
                 <textarea class="form-control" rows="3" id="observaciones" name="observaciones" placeholder="Comentarios para la carta"><?php echo $notasCarta ?></textarea>
                 <input type="hidden" name="altaDictamen" name="altaDictamen" value="altaDictamen">
                 <input type="hidden" name="idServicio" name="idServicio" value="<?php echo $idServicio?>">
                 <input type="hidden" name="idBeneficiario" name="idBeneficiario" value="<?php echo $idBeneficiario?>">
                 <input type="hidden" name="idCuenta" name="idCuenta" value="<?php echo $idCuenta?>">
                 <input type="hidden" name="totalFacturar" value="<?php echo $totalFacturar ?>">
                 <br><button type="button" class="btn btn-info" onclick="agregaNotaCarta()">Guardar nota</button>
                </div>
              </div>
            </div>
          </div>


          <?php if ($servicio=='MEDICAMENTOS') { 
                if ($proveedormedicamento!='') {
            ?> 
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Aprobar dictamen</button>
          </div>
         <?php  } else { ?>
          <div class="col-sm-12">
        <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> UPS!</h5>
                  Es necesario tener un proveedor asignado a los medicamentos para concluir el dictamen
                </div>
                </div>
        <?php } } ?>  
        

          <?php if ($servicio!='MEDICAMENTOS') { 
                if ($proveedorservicio!='') {
            ?> 
          <div class="card-footer">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#crearDictamen" id="btnView"> <i class="fas fa-check"> Generar Dictamen
                              </i>
                      </button>
          </div>
          <?php }  else { ?>
            <div class="col-sm-12">
            <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-times"></i> UPS!</h5>
                  Es necesario asignar un proveedor al Servicio para concluir con el dictamen.
                </div>
                </div>
          <?php } } ?>  

        <?php } else { ?>
              <div class="col-sm-12">
        <div class="alert alert-info alert-dismissible">
                  <h5><i class="icon fas fa-check"></i> IMPORTANTE!</h5>
                  El dicatamen ya fue generado <?php echo $fechaGeneraDictamen; ?><hr>
                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#eliminarDictamen" id="btnView"> <i class="fas fa-times"> Eliminar Dictamen
                              </i>
                      </button>
                </div>
                </div>

        <?php } ?>
        </div>
      </form>
        </div>
    </section>


        

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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
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

<div id="agregarCopago" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>COPAGO ASIGNADO A LA CUENTA</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" autocomplete="off" id="copagoPo">
        <div class="col-md-12">
                <div class="form-group">
                 <label>Monto a Aplicar</label>
                 <input type="text" class="form-control"id="montoAutoriza" name="montoAutoriza" onkeyup="eliminarEspacio()">
                 <input type="hidden" name="idServicio2" id="idServicio2" value="<?php echo $idServicio?>">
                 <input type="hidden" name="idBeneficiario2" id="idBeneficiario2" value="<?php echo $idBeneficiario?>">
                 <input type="hidden" name="idCuenta2" id="idCuenta2" value="<?php echo $idCuenta ?>">
                </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <textarea class="form-control" rows="2" cols="50" id="observaciones2" name="observaciones2"></textarea>
                </div>
        </div>
      </form>
        <button type="button" class="btn btn-success" onclick="agregarCopagoFinal()">Aplicar copago</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function agregarCopagoFinal(){
    var montoAutoriza=$('#montoAutoriza').val();
    var idCuenta=$('#idCuenta2').val();
    var idBeneficiario=$('#idBeneficiario2').val();
    var idServicio=$('#idServicio2').val();
    var observaciones=$('#observaciones2').val();


        if (montoAutoriza!=''){
        $.ajax({
            url: 'consultas/agregarCopago.php',
            type: "POST",
            data: {"montoAutoriza":montoAutoriza,"idCuenta":idCuenta, "idBeneficiario":idBeneficiario, "idServicio":idServicio, "observaciones":observaciones},
            success: function (cmb) {
              // alert(cmb);
               $("#datosCopagos").load(" #datosCopagos");
               $('#agregarCopago').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' El copago se AUTORIZO correctamente, ya esta siendo aplicado al servicio'
                    })
                  });
                  });
                 location.reload();
            }
        });
        } else {
            $(function() {
            var Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });

            $(document).ready(function() {
              Toast.fire({
                icon: 'error',
                title: ' Es necesario colocar un monto mayor a $1 para poder agregar el concepto'
              })
            });
            });
        }        
  }
</script>

<div id="agregarContribucion" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>CONTRIBUCION ASIGNADA A LA CUENTA</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" autocomplete="off" id="copagoPo">
        <div class="col-md-12">
                <div class="form-group">
                 <label>Monto a Aplicar</label>
                 <input type="text" class="form-control"id="montoAutoriza3" name="montoAutoriza3" onkeyup="eliminarEspacio()">
                </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Comentarios</label>
                  <textarea class="form-control" rows="2" cols="50" id="observaciones3" name="observaciones3"></textarea>
                </div>
        </div>
      </form>
        <button type="button" class="btn btn-success" onclick="agregarContribucionFinal()">Aplicar contribución</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function agregarContribucionFinal(){
    var montoAutoriza=$('#montoAutoriza3').val();
    var idCuenta=$('#idCuenta2').val();
    var idBeneficiario=$('#idBeneficiario2').val();
    var idServicio=$('#idServicio2').val();
    var observaciones=$('#observaciones3').val();

          if (montoAutoriza!=''){
          $.ajax({
            url: 'consultas/agregarContribucion.php',
            type: "POST",
            data: {"montoAutoriza":montoAutoriza,"idCuenta":idCuenta, "idBeneficiario":idBeneficiario, "idServicio":idServicio, "observaciones":observaciones},
            success: function (cmb) {
              // alert(cmb);
               $("#datosContribucion").load(" #datosContribucion");
               $('#agregarContribucion').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' La contribucion se AUTORIZO correctamente, ya esta siendo aplicado al servicio'
                    })
                  });
                  });
                 location.reload();
            }
        });
            } else {
            $(function() {
            var Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });

            $(document).ready(function() {
              Toast.fire({
                icon: 'error',
                title: ' Es necesario colocar un monto mayor a $1 para poder agregar el concepto'
              })
            });
            });
        } 


  }
</script>


<script type="text/javascript">
  function agregaform(datos){
    d=datos.split('||');    
    $('#idCopago').val(d[1]);
    $('#idCopagoAsignado').val(d[0]);
    $('#montoAutorizaActualiza').val(d[3]);
}
  function agregaform2(datos){
    d=datos.split('||');    
    $('#idContribucion').val(d[1]);
    $('#idContribucionAsignado').val(d[0]);
    $('#montoAutorizaActualizaF').val(d[3]);
}

  function agregaform3(datos){
    d=datos.split('||');    
    $('#montoGastoActualiza').val(d[3]);
    $('#editarMontoServicio2').val(d[0]);
}
</script>

<div id="editaCopago" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b> MODIFICAR COPAGO ASIGNADO A LA CUENTA</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" autocomplete="off" id="copagoPo">
        <div class="col-md-12">
                <div class="form-group">
                 <label>Nuevo monto</label>
                 <input type="text" class="form-control"id="montoAutorizaActualiza" name="montoAutorizaActualiza" onkeyup="eliminarEspacio()">
                 <input type="hidden" class="form-control"id="idCopago" name="idCopago">
                 <input type="hidden" class="form-control"id="idCopagoAsignado" name="idCopagoAsignado">
                </div>
        </div>
      </form>
        <button type="button" class="btn btn-success" onclick="editaCopagoFinal()">Editar copago pagado</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function editaCopagoFinal(){
    var montoAutorizaActualiza=$('#montoAutorizaActualiza').val();
    var idCopago=$('#idCopago').val();
    var idCopagoAsignado=$('#idCopagoAsignado').val();

        $.ajax({
            url: 'consultas/editaCopagoFinal.php',
            type: "POST",
            data: {"montoAutorizaActualiza":montoAutorizaActualiza,"idCopago":idCopago, "idCopagoAsignado":idCopagoAsignado},
            success: function (cmb) {
               // alert(cmb);
               $("#datosCopagos").load(" #datosCopagos");
               $('#editaCopago').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' El copago se EDITO correctamente, ya esta siendo aplicado al servicio'
                    })
                  });
                  });
                 location.reload();
            }
        });
       
  }
</script>

<div id="editaContribucion" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b> MODIFICAR CONTRIBUCION ASIGNADO A LA CUENTA</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" autocomplete="off" id="copagoPo">
        <div class="col-md-12">
                <div class="form-group">
                 <label>Nuevo monto</label>
                 <input type="text" class="form-control"id="montoAutorizaActualizaF" name="montoAutorizaActualizaF" onkeyup="eliminarEspacio()">
                 <input type="hidden" class="form-control"id="idContribucion" name="idContribucion">
                 <input type="hidden" class="form-control"id="idContribucionAsignado" name="idContribucionAsignado">
                </div>
        </div>
      </form>
        <button type="button" class="btn btn-success" onclick="editaContribucionFinal()">Editar contribucion pagado</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function editaContribucionFinal(){
    var montoAutorizaActualizaF=$('#montoAutorizaActualizaF').val();
    var idContribucion=$('#idContribucion').val();
    var idContribucionAsignado=$('#idContribucionAsignado').val();
        $.ajax({
            url: 'consultas/editaContribucionFinal.php',
            type: "POST",
            data: {"montoAutorizaActualizaF":montoAutorizaActualizaF,"idContribucion":idContribucion, "idContribucionAsignado":idContribucionAsignado},
            success: function (cmb) {
               // alert(cmb);
               $("#datosContribucion").load(" #datosContribucion");
               $('#editaContribucion').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' La contribucion se EDITO correctamente, ya esta siendo aplicado al servicio'
                    })
                  });
                  });
                 location.reload();
            }
        });       
  }
</script>

<div id="agregarGastoMedico" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>GASTOS MEDICOS ASIGNADOS A LA CUENTA</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
                <div class="form-group">
                 <label>Monto a Aplicar</label>
                 <input type="text" class="form-control" id="montoGasto" name="montoGasto" placeholder="Monto del gasto medico" onkeyup="eliminarEspacio()">
                 <input type="hidden" id="idServicioGM" name="idServicioGM" value="<?php echo $idServicio?>">
                </div>
        </div>
        <div class="col-md-12">
                <div class="form-group">
                  <label>Concepto</label>
                  <textarea class="form-control" rows="2" cols="50" id="conceptoGasto" name="conceptoGasto" placeholder="Concepto del cargo por gasto medico"></textarea>
                </div>
        </div>
  
        <button type="button" class="btn btn-success" onclick="agregarGastoMedicoFinal()">Aplicar gasto medico</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function agregarGastoMedicoFinal(){
    var montoGasto=$('#montoGasto').val();
    var conceptoGasto=$('#conceptoGasto').val();
    var idServicioGM=$('#idServicioGM').val();
    var idBeneficiario=$('#idBeneficiario').val();

        $.ajax({
            url: 'consultas/agregaGastoMedico.php',
            type: "POST",
            data: {"montoGasto":montoGasto,"conceptoGasto":conceptoGasto,"idServicioGM":idServicioGM},
            success: function (cmb) {
               // alert(cmb);               
               $("#datosGastosMedicos").load(" #datosGastosMedicos");
               $('#agregarGastoMedico').modal('hide');
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
                      title: ' El monto por concepto de Gastos Medicos se agrego correctamente'
                    })
                  });
                  });
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
<div id="editaGastoMedico" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>MODIFICAR GASTOS HOSPITALARIOS</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" autocomplete="off">
        <div class="col-md-12">
                <div class="form-group">
                 <label>Nuevo monto</label>
                 <input type="text" class="form-control"id="montoGastoActualiza" name="montoGastoActualiza"  onkeyup="eliminarEspacio()">
                 <input type="hidden" class="form-control"id="editarMontoServicio2" name="editarMontoServicio2">
                </div>
        </div>
      </form>
        <button type="button" class="btn btn-success" onclick="editaGastoMedicoFinal()">Editar Gasto Médico</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function editaGastoMedicoFinal(){
    var montoGastoActualiza=$('#montoGastoActualiza').val();
    var editarMontoServicio2=$('#editarMontoServicio2').val();
        $.ajax({
            url: 'consultas/editaGastoMedicoFinal.php',
            type: "POST",
            data: {"editarMontoServicio2":editarMontoServicio2,"montoGastoActualiza":montoGastoActualiza},
            success: function (cmb) {
               // alert(cmb);
               $("#datosContribucion").load(" #datosContribucion");
               $('#editaContribucion').modal('hide');
               $('.modal-backdrop').remove();
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
                      title: ' La contribucion se EDITO correctamente, ya esta siendo aplicado al servicio'
                    })
                  });
                  });
                 location.reload();
            }
        });       
  }
</script>

<div id="crearDictamen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>ESTAS SEGURO DE CREAR EL DICTAMEN?</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Al crear este dictamenten ya no es posible editar montos del sevicio<br><br>

      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="aprobarDictamen()">Generar Dictamen</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function aprobarDictamen(){
    document.forms["formOne"].submit();
  }
</script>

<script type="text/javascript">
  function agregaNotaCarta(){
    var observaciones=$('#observaciones').val();
    var idServicio=$('#idServicio2').val();
    // alert (idServicio);
        $.ajax({
            url: 'consultas/agregaNotaCarta.php',
            type: "POST",
            data: {"idServicio":idServicio,"observaciones":observaciones},
            success: function (cmb) {
              // alert(cmb);
                 location.reload();
            }
        });       
  }
</script>

<div id="eliminarDictamen" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Contenido del modal -->
    <div class="modal-content">
      <div class="modal-header"><b>ESTAS SEGURO DE ELIMINAR EL DICTAMEN?</b>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDictamen" id="idDictamen" value="<?php echo $idDictamenGenerado ?>">
        Al eliminar el dictamen, el servicio vuelve al estatus Abierto, deberá de crear de nuevo el dictamen para cerrarlo.<br><br>

      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" onclick="eliminarDictamen()">Eliminar Dictamen</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function eliminarDictamen(){
    var idDictamen=$('#idDictamen').val();
    // alert (idServicio);
        $.ajax({
            url: 'consultas/eliminarDictamen.php',
            type: "POST",
            data: {"idDictamen":idDictamen},
            success: function (cmb) {
              // alert(cmb);
                 location.reload();
            }
        });       
  }
</script>




