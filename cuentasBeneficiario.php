<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
include('class/altaServicio.php');
//creamo el objeto de la orde de venta class
$NuUs = new Altaservicio_class();
if ($_POST) {
$NuUs->altaServicio();
}
$hoy=date('Y-m-d');
$idBeneficiario=$_GET['idBeneficiario'];
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Resumen de cuentas del beneficiario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Cuentas generales del beneficiario</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <?php 
$queryCuentas="SELECT * from beneficiarioscuentas where idBeneficiario=$idBeneficiario";
$res44=mysqli_query($con,$queryCuentas);
$registros=mysqli_fetch_array($res44);
$idCuenta=$registros['idCuenta'];
?>
<section class="content">
    <div class="callout callout-success">
       <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="green">Datos de la cuenta</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <?php 
                  $query="SELECT sum(mc.montoautorizadocliente) as totalMonto, mc.nombreacuerdo, b.nombreBeneficiario, b.folioBeneficiario, cli.nombreCliente, mc.subgrupo, sum(bc.contribucion) totalContribucion, sum(bc.copago) totalCopagopo from beneficiarios b 
                  INNER JOIN beneficiarioscuentas bc on bc.idBeneficiario=b.idBenefeciario
                  INNER JOIN montosclientes mc on mc.idmontoCliente=bc.idPrograma
                  INNER JOIN clientes cli on cli.idCliente=mc.idCliente
                  where b.idBenefeciario=$idBeneficiario";
                  $res=mysqli_query($con,$query);
                  $extraido=mysqli_fetch_array($res);
                  ?>
                  <dt class="col-sm-4">Nombre y folio del Beneficiario</dt>
                  <dd class="col-sm-8"><?php echo $extraido['nombreBeneficiario']; ?> / <?php echo $extraido['folioBeneficiario']; ?></dd>
                  <dt class="col-sm-4">Cliente al que pertenece</dt>
                  <dd class="col-sm-8"><?php echo $extraido['nombreCliente']; ?></dd>
                  <dt class="col-sm-4">Montos de la cuentas</dt>
                  <dd class="col-sm-8"><b><font color="red">$<?php echo number_format($extraido['totalMonto'], 2, '.', ',') ?></font></b></dd>
                  <dt class="col-sm-4">Subgrupo asignado</dt>
                  <dd class="col-sm-8"><?php echo $extraido['subgrupo'] ?></dd>
                  <dt class="col-sm-4">Contribución Inicial</dt>
                  <dd class="col-sm-8">$<?php echo number_format($extraido['totalContribucion'], 2, '.', ',') ?></dd>
                  <dt class="col-sm-4">Copago</dt>
                  <dd class="col-sm-8"><?php echo $extraido['totalCopagopo'] ?>%</dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="green">Contabilidad de la cuenta</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Gasto Total</dt>
                  <dd class="col-sm-8">$<?php 
                  // obtengo la suma de los montos de los servicios  
                  $queryServicios="SELECT sum(monto) as montoservicios from servicios s
                  where s.idBeneficiario=$idBeneficiario and s.servicio='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalservicios=$extraidoServicios['montoservicios'];

                  //obtengo al suma de las notas medicas
                  $queryServicios="SELECT sum(costonota) as totalmedicas from notasmedicas nm               
                  INNER JOIN servicios s on s.idServicio=nm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalmedicas=$extraidoServicios['totalmedicas'];

                  //obtengo al suma de las consultas
                  $queryServicios="SELECT sum(mc.monto) as totalconsultas from montosconsultas mc               
                  INNER JOIN servicios s on s.idServicio=mc.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalconsultas=$extraidoServicios['totalconsultas'];

                  // obtengo el total de notas pre operatorias
                  $queryServicios="SELECT sum(cirujano+anestesiologo+ayudante+enfermeria+ayudante2) as totalpreoperatorias from notaspreoperatorias nm               
                  INNER JOIN servicios s on s.idServicio=nm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalpreoperatorias=$extraidoServicios['totalpreoperatorias'];

                  //obtengo la suma de los gastos medicos                  
                  $queryServicios="SELECT sum(gm.monto) as totalhonorarios from gastosmedicos gm               
                  INNER JOIN servicios s on s.idServicio=gm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalhonorarios=$extraidoServicios['totalhonorarios'];
                  
                  //obtengo el total de copago a los servicios
                  $queryServicios="SELECT sum(ca.montoAsignado) as totalCopagoAplicable 
                  from copagosasignados ca               
                  INNER JOIN servicios s on s.idServicio=ca.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalCopagoAplicable=$extraidoServicios['totalCopagoAplicable'];
                  ;
                  //obtengo el total de contribucion a los servicios para restar al monto autorizado
                  $queryServicios="SELECT sum(ca.montoAsignado) as totalComisionAplicable 
                  from contribucionesasignadas ca               
                  INNER JOIN servicios s on s.idServicio=ca.idservicio
                  where s.idBeneficiario=$idBeneficiario and ca.tipocopago='Pagado' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalComisionAplicable=$extraidoServicios['totalComisionAplicable'];

                  //obtengo el copago depositado
                  $queryCIP="SELECT sum(montoAprobado) montoDepositado from archivoscopagos where tipocopago='Depositado' and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoDepositado=$exrtraerTotal['montoDepositado'];

                  //obtengo el monto copago acreditado
                  $queryCIP="SELECT sum(montoAprobado) montoAcreditado from archivoscopagos where tipocopago='Acreditado' and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoAcreditado=$exrtraerTotal['montoAcreditado'];

                   //obtengo el monto copago pagado
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscopagos where tipocopago='Pagado' and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoPagado=$exrtraerTotal['montoPagado'];

                  //total del copago (solo sumo depositado y acreditado)
                  $totalCopago=($montoDepositado+$montoAcreditado+$montoPagado);

                  // obtengo la contribucion acreditada
                  $queryCIP="SELECT sum(montoAprobado) montoAcreditado from archivoscontribucion where tipocopago='Acreditado' and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoAcreditadoCI=$exrtraerTotal['montoAcreditado'];

                  // obtengo la contribucion pagada
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscontribucion where tipocopago='Pagado' and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoPagadoCI=$exrtraerTotal['montoPagado'];

                  // obtengo la contribucion depositada
                  $queryCIP="SELECT sum(montoAprobado) montoDepositada from archivoscontribucion where tipocopago='Depositado' and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoDepositadaCI=$exrtraerTotal['montoDepositada'];

                  $totalContribucion=$montoAcreditadoCI+$montoPagadoCI+$montoDepositadaCI;

                  // imprimo el gasto toal
                  echo number_format($total=$totalservicios+$totalmedicas+$totalpreoperatorias+$totalhonorarios+$totalconsultas, 2, '.', ',');
                  ?></dd>

                  <dt class="col-sm-4">Monto autorizado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($total-$totalCopagoAplicable-$totalComisionAplicable, 2, '.', ',')  ?></dd>

                  <dt class="col-sm-4">Monto Remante</dt>
                  <dd class="col-sm-8">$<?php echo number_format($extraido['totalMonto']-$total, 2, '.', ',') ?></dd>                  

                  <dt class="col-sm-4">Copago aplicable</dt>
                  <dd class="col-sm-8">$<?php echo number_format(($total*$extraido['totalCopagopo']), 2, '.', ',') ?></dd>

                  <dt class="col-sm-4">Copago acumulado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($totalCopago, 2, '.', ',') ?></dd>

                  <dt class="col-sm-4">Diferencia de Copago</dt>
                  <dd class="col-sm-8">$<?php echo number_format(($totalCopago-($total*$extraido['totalCopagopo'])), 2, '.', ',') ?></dd> 
                  <dt class="col-sm-4">Diferencia de Contribución</dt>
                  <dd class="col-sm-8">$<?php echo number_format($extraido['contribucion']-$totalContribucion, 2, '.', ',') ?></dd>                  
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
        </div>                 
       </div>
    </section>
 

    <section class="content">
       <div class="callout callout-success">
       <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="green">Copago</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Pagado</dt>
                  <dd class="col-sm-8">$<?php 
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscopagos where tipocopago='Pagado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  echo number_format($totalPagado=$exrtraerTotal['montoPagado'], 2, '.', ',');
                ?></dd>
                  <dt class="col-sm-4">Depositado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($montoDepositado, 2, '.', ','); ?></dd>
                  <dt class="col-sm-4">Acreditado</dt>
                  <dd class="col-sm-8">$<?php   echo number_format($montoAcreditado, 2, '.', ',');?></dd>
                <dt class="col-sm-4">TOTAL COPAGO</dt>
                  <dd class="col-sm-8"><b>$<?php
                  echo number_format($totalCopago, 2, '.', ',');
                ?>
              </b></dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="green">Contribución Inicial</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Pagada</dt>
                  <dd class="col-sm-8">$<?php 
                  echo number_format($montoPagadoCI, 2, '.', ',');
                  ?></dd>
                  <dt class="col-sm-4">Depositada</dt>
                  <dd class="col-sm-8">$<?php
                  echo number_format($montoDepositadaCI, 2, '.', ',');
                  ?></dd>
                  <dt class="col-sm-4">Acreditada</dt>
                  <dd class="col-sm-8">$<?php 
                  echo number_format($montoAcreditadoCI, 2, '.', ',');
                  ?></dd>
                 <dt class="col-sm-4">TOTAL Contribución</dt>
                  <dd class="col-sm-8">$<?php
                  echo number_format(($montoTotalCI+$montoDepositadaCI+$montoAcreditadoCI+$montoPagadoCI), 2, '.', ',');
                ?></dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->


        </div>                 
       </div>
       <hr color="green">
  </section>


<?php 
$queryCuentas="SELECT * from beneficiarioscuentas where idBeneficiario=$idBeneficiario";
$res44=mysqli_query($con,$queryCuentas);
while ($registros=mysqli_fetch_array($res44)){
$idCuenta=$registros['idCuenta'];
?>
<section class="content">
    <div class="callout callout-danger">
       <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Datos de la cuenta</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <?php 
                  $query="SELECT mc.montoautorizadocliente, mc.nombreacuerdo, b.nombreBeneficiario, b.folioBeneficiario, cli.nombreCliente, mc.subgrupo, bc.contribucion, bc.copago from beneficiarios b 
                  INNER JOIN beneficiarioscuentas bc on bc.idBeneficiario=b.idBenefeciario
                  INNER JOIN montosclientes mc on mc.idmontoCliente=bc.idPrograma
                  INNER JOIN clientes cli on cli.idCliente=mc.idCliente
                  where b.idBenefeciario=$idBeneficiario and bc.idCuenta=$idCuenta";
                  $res=mysqli_query($con,$query);
                  $extraido=mysqli_fetch_array($res);
                  ?>
                  <dt class="col-sm-4">Nombre y folio del Beneficiario</dt>
                  <dd class="col-sm-8"><?php echo $extraido['nombreBeneficiario']; ?> / <?php echo $extraido['folioBeneficiario']; ?></dd>
                  <dt class="col-sm-4">Cliente al que pertenece</dt>
                  <dd class="col-sm-8"><?php echo $extraido['nombreCliente']; ?></dd>
                  <dt class="col-sm-4">Cuenta</dt>
                  <dd class="col-sm-8"><b><font color="blue"><?php echo $extraido['nombreacuerdo'] ?></font></b></dd>
                  <dt class="col-sm-4">Monto de la cuenta</dt>
                  <dd class="col-sm-8"><b><font color="red">$<?php echo number_format($extraido['montoautorizadocliente'], 2, '.', ',') ?></font></b></dd>
                  <dt class="col-sm-4">Subgrupo asignado</dt>
                  <dd class="col-sm-8"><?php echo $extraido['subgrupo'] ?></dd>
                  <dt class="col-sm-4">Contribución Inicial</dt>
                  <dd class="col-sm-8">$<?php echo $extraido['contribucion'] ?></dd>
                  <dt class="col-sm-4">Copago</dt>
                  <dd class="col-sm-8"><?php echo $extraido['copago'] ?>%</dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Contabilidad de la cuenta</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Gasto Total</dt>
                  <dd class="col-sm-8">$<?php 
                  // obtengo la suma de los montos de los servicios  
                  $queryServicios="SELECT sum(monto) as montoservicios from servicios s
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalservicios=$extraidoServicios['montoservicios'];

                  //obtengo al suma de las notas medicas
                  $queryServicios="SELECT sum(costonota) as totalmedicas from notasmedicas nm               
                  INNER JOIN servicios s on s.idServicio=nm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalmedicas=$extraidoServicios['totalmedicas'];

                  //obtengo al suma de las consultas
                  $queryServicios="SELECT sum(mc.monto) as totalconsultas from montosconsultas mc               
                  INNER JOIN servicios s on s.idServicio=mc.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalconsultas=$extraidoServicios['totalconsultas'];

                  // obtengo el total de notas pre operatorias
                  $queryServicios="SELECT sum(cirujano+anestesiologo+ayudante+enfermeria+ayudante2) as totalpreoperatorias from notaspreoperatorias nm               
                  INNER JOIN servicios s on s.idServicio=nm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalpreoperatorias=$extraidoServicios['totalpreoperatorias'];

                  //obtengo la suma de los gastos medicos                  
                  $queryServicios="SELECT sum(gm.monto) as totalhonorarios from gastosmedicos gm               
                  INNER JOIN servicios s on s.idServicio=gm.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.servicio!='MEDICAMENTOS' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalhonorarios=$extraidoServicios['totalhonorarios'];
                  
                  //obtengo el total de copago a los servicios
                  $queryServicios="SELECT sum(ca.montoAsignado) as totalCopagoAplicable 
                  from copagosasignados ca               
                  INNER JOIN servicios s on s.idServicio=ca.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalCopagoAplicable=$extraidoServicios['totalCopagoAplicable'];
                  ;
                  //obtengo el total de contribucion a los servicios para restar al monto autorizado
                  $queryServicios="SELECT sum(ca.montoAsignado) as totalComisionAplicable 
                  from contribucionesasignadas ca               
                  INNER JOIN servicios s on s.idServicio=ca.idservicio
                  where s.idBeneficiario=$idBeneficiario and s.idCuenta=$idCuenta and ca.tipocopago='Pagado' and s.estatus!=5";
                  $resServicios=mysqli_query($con,$queryServicios);
                  $extraidoServicios=mysqli_fetch_array($resServicios);
                  $totalComisionAplicable=$extraidoServicios['totalComisionAplicable'];

                  //obtengo el copago depositado
                  $queryCIP="SELECT sum(montoAprobado) montoDepositado from archivoscopagos where tipocopago='Depositado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoDepositado=$exrtraerTotal['montoDepositado'];

                  //obtengo el monto copago acreditado
                  $queryCIP="SELECT sum(montoAprobado) montoAcreditado from archivoscopagos where tipocopago='Acreditado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoAcreditado=$exrtraerTotal['montoAcreditado'];

                   //obtengo el monto copago pagado
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscopagos where tipocopago='Pagado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoPagado=$exrtraerTotal['montoPagado'];

                  //total del copago (solo sumo depositado y acreditado)
                  $totalCopago=($montoDepositado+$montoAcreditado+$montoPagado);

                  // obtengo la contribucion acreditada
                  $queryCIP="SELECT sum(montoAprobado) montoAcreditado from archivoscontribucion where tipocopago='Acreditado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoAcreditadoCI=$exrtraerTotal['montoAcreditado'];

                  // obtengo la contribucion pagada
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscontribucion where tipocopago='Pagado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoPagadoCI=$exrtraerTotal['montoPagado'];

                  // obtengo la contribucion depositada
                  $queryCIP="SELECT sum(montoAprobado) montoDepositada from archivoscontribucion where tipocopago='Depositado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario and estatus!=5";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  $montoDepositadaCI=$exrtraerTotal['montoDepositada'];

                  $totalContribucion=$montoAcreditadoCI+$montoPagadoCI+$montoDepositadaCI;

                  // imprimo el gasto toal
                  echo number_format($total=$totalservicios+$totalmedicas+$totalpreoperatorias+$totalhonorarios+$totalconsultas, 2, '.', ',');
                  ?></dd>

                  <dt class="col-sm-4">Monto autorizado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($total-$totalCopagoAplicable-$totalComisionAplicable, 2, '.', ',')  ?></dd>

                  <dt class="col-sm-4">Monto Remante</dt>
                  <dd class="col-sm-8">$<?php echo number_format($extraido['montoautorizadocliente']-$total, 2, '.', ',') ?></dd>                  

                  <dt class="col-sm-4">Copago aplicable</dt>
                  <dd class="col-sm-8">$<?php echo number_format(($total*$extraido['copago']), 2, '.', ',') ?></dd>

                  <dt class="col-sm-4">Copago acumulado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($totalCopago, 2, '.', ',') ?></dd>

                  <dt class="col-sm-4">Diferencia de Copago</dt>
                  <dd class="col-sm-8">$<?php echo number_format(($totalCopago-($total*$extraido['copago'])), 2, '.', ',') ?></dd> 
                  <dt class="col-sm-4">Diferencia de Contribución</dt>
                  <dd class="col-sm-8">$<?php echo number_format($extraido['contribucion']-$totalContribucion, 2, '.', ',') ?></dd>                  
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
        </div>                 
       </div>
    </section>
 

    <section class="content">
       <div class="callout callout-danger">
       <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Copago</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Pagado</dt>
                  <dd class="col-sm-8">$<?php 
                  $queryCIP="SELECT sum(montoAprobado) montoPagado from archivoscopagos where tipocopago='Pagado' and idCuenta=$idCuenta and idBeneficiario=$idBeneficiario";
                  $res=mysqli_query($con,$queryCIP);
                  $exrtraerTotal=mysqli_fetch_array($res);
                  echo number_format($totalPagado=$exrtraerTotal['montoPagado'], 2, '.', ',');
                ?></dd>
                  <dt class="col-sm-4">Depositado</dt>
                  <dd class="col-sm-8">$<?php echo number_format($montoDepositado, 2, '.', ','); ?></dd>
                  <dt class="col-sm-4">Acreditado</dt>
                  <dd class="col-sm-8">$<?php   echo number_format($montoAcreditado, 2, '.', ',');?></dd>
                <dt class="col-sm-4">TOTAL COPAGO</dt>
                  <dd class="col-sm-8"><b>$<?php
                  echo number_format($totalCopago, 2, '.', ',');
                ?>
              </b></dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- ./col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-text-width"></i>
                 <font color="red">Contribución Inicial</font>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-4">Pagada</dt>
                  <dd class="col-sm-8">$<?php 
                  echo number_format($montoPagadoCI, 2, '.', ',');
                  ?></dd>
                  <dt class="col-sm-4">Depositada</dt>
                  <dd class="col-sm-8">$<?php
                  echo number_format($montoDepositadaCI, 2, '.', ',');
                  ?></dd>
                  <dt class="col-sm-4">Acreditada</dt>
                  <dd class="col-sm-8">$<?php 
                  echo number_format($montoAcreditadoCI, 2, '.', ',');
                  ?></dd>
                 <dt class="col-sm-4">TOTAL Contribución</dt>
                  <dd class="col-sm-8">$<?php
                  echo number_format(($montoTotalCI+$montoDepositadaCI+$montoAcreditadoCI+$montoPagadoCI), 2, '.', ',');
                ?></dd>
                </dl>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <a class="btn btn-warning btn-sm" href="agregarServiciosBeneficiario?idBeneficiario=<?php echo $idBeneficiario; ?>&idCuenta=<?php echo $idCuenta; ?>">
                          <i class="fas fa-arrow-right "></i> Ir a cuenta <?php echo $extraido['nombreacuerdo'] ?>
                          </a>
          </div>
          <!-- ./col -->


        </div>                 
       </div>
       <hr color="red">
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
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>

<div id="borrarSolicitud" class="modal fade" role="dialog">
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
        Eliminar Solicitud de Medicamento <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
      </button>
      </form>
        <script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnDelete', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        //alert(uid);
        document.fl3.iduser3.value = uid;
      });  
    });
</script>
      </div>
    </div>
  </div>
</div>

<?php 
if ($_GET['do']=='1') { ?>
echo '<script>
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
        title: ' El servicio se dio de alta con éxito, ya esta asignado al beneficiario y en el subgrupo correspondiente'
      })
    });
    });
</script>
<?php } ?>

<?php 
if ($_GET['do']=='6') { ?>
echo '<script>
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
        title: ' El servicio se cancelo correctamente, a partir de este momento ya no esta aplicado al beneficiario ni en su subgrupo'
      })
    });
    });
</script>
<?php } ?>








 

