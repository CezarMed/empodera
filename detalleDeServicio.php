<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalles del Servicio del Beneficiario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Servicios del beneficiario</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <?php
    $idBeneficiario=$_GET['idBeneficiario'];
    $idServicio=$_GET['idServicio']; 
    $idCuenta=$_GET['idCuenta'];     

    $query="SELECT s.montoFacturable,s.servicioprincipal,s.folioEmpodera, s.estatus, s.monto, b.nombreBeneficiario, s.servicio, s.idCuenta, s.estatus from servicios s
    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario 
    where s.idServicio=$idServicio";
    $res = mysqli_query($con,$query);
    $registro = mysqli_fetch_array($res);
    $estatus=$registro['estatus'];
    $servicioprincipal=$registro['servicioprincipal'];
    $pago=$registro['archivoPago'];
    $montoFacturable=$registro['montoFacturable'];
    $monto=$registro['monto'];
    $idCuenta=$registro['idCuenta'];
    $servicio=$registro['servicio'];
    $estatus=$registro['estatus'];

    $queryProvee="SELECT * from archivosacuses where idServicio=$idServicio";
    $resProvee=mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $acuseArchivo=$extraidoProvee['archivo'];

    $queryProvee="SELECT count(*) totalFacturas from servicioscomplementos
                where idServicio=$idServicio and idFactura!=0";
    $resProvee = mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $totalFacturas=$extraidoProvee['totalFacturas'];

    $queryProvee="SELECT count(*) totalPagos from pagosfacturas pf
    inner join facturasdatosxml fxml on fxml.idFacturas=pf.idFactura
    inner join servicioscomplementos sc on sc.idFactura=fxml.idFacturas
    where sc.idServicio=$idServicio";
    $resProvee=mysqli_query($con,$queryProvee);
    $extraidoProvee=mysqli_fetch_array($resProvee);
    $totalPagos=$extraidoProvee['totalPagos'];


    $queryProvee="SELECT * from solicitudmedicamentos where idservicio=$idServicio";
    $resProvee=mysqli_query($con,$queryProvee);
    $extraidoProvee= mysqli_fetch_array($resProvee);
    $idSolicitudMedicamentos=$extraidoProvee['idSolicitudMedicamentos'];

    $queryProvee="SELECT * from dictamenesgenerados
                where idServicio=$idServicio";
    $resProvee=mysqli_query($con,$queryProvee);
    $extraidoDictamen= mysqli_fetch_array($resProvee);
    $totalDictamen=mysqli_num_rows($resProvee);

                              $queryS="SELECT count(*) totalnotas from notasmedicas
                              where idServicio=$idServicio and estatus=1";
                              $resN = mysqli_query($con,$queryS);
                              $extraidoN= mysqli_fetch_array($resN);
                              $totalnotas=$extraidoN['totalnotas'];
                              // cuento las notas pre operatorias
                              $queryS2 = "SELECT count(*) totalnotas2 from notaspreoperatorias
                              where idServicio=$idServicio and estatus=1";
                              $resN2 = mysqli_query($con,$queryS2);
                              $extraidoN2= mysqli_fetch_array($resN2);
                              $totalnotas2=$extraidoN2['totalnotas2'];
                              // cuento las notas administrstivas
                              $queryS2 = "SELECT count(*) totalnotas3 from notasadministrativas
                              where idServicio=$idServicio and estatus=1";
                              $resN2 = mysqli_query($con,$queryS2);
                              $extraidoN2= mysqli_fetch_array($resN2);
                              $totalnotas3=$extraidoN2['totalnotas3'];
                              // consulto las notas automaticas para sumarlas
                              $queryS2 = "SELECT count(*) totalnotas4 from notasautomaticas
                              where idServicio=$idServicio and estatus=1";
                              $resN2 = mysqli_query($con,$queryS2);
                              $extraidoN2= mysqli_fetch_array($resN2);
                              $totalnotas4=$extraidoN2['totalnotas4'];
                              $notasno= $totalnotas+$totalnotas2+$totalnotas3+$totalnotas4;
      ?>
      <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  El registro se <b>AGREGO</b> correctamente</a>
                </div>
                </div>
  <?php } ?>
        <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-times"></i> Ups!</h5>
                  El registro <b>NO</b> se <b>AGREGO</b> correctamente</a>
                </div>
                </div>
  <?php } ?>
  <?php require_once ("encabezadoServicios.php"); ?>

    <section class="content">
      <form action="" method="POST" autocomplete="off">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Asignar servicio al beneficiario</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?php if ($estatus!=5){ ?>
                <?php if ($tipousuario=='Administrador'||$tipousuario=='Medico'||$tipousuario=='CoordinadorMed'||$tipousuario=='Transicion') { ?>
                  
                <?php if ($servicio=='MEDICAMENTOS') { 
                  if ($estatus==1) { ?>
                <a class="btn btn-app bg-info" href="solicitudMedicamentos?id=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&servicioprincipal=<?php echo $servicioprincipal?>">
                  <i class="fas fa-ambulance"></i> Solicitar Medicamentos
                </a>
                <?php } } ?>

                <?php if ($servicio!='MEDICAMENTOS') {
                  if ($estatus==1) {
                ?>
                <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-ambulance"></i> Asignar proveedor
                </a>
                <?php } } else { 
                  if ($proveedorname!=''){
                  ?>
                  <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>&idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos?>">
                  <i class="fas fa-ambulance"></i> Cambiar proveedor
                </a>
                <?php } } ?>
                <a class="btn btn-app bg-info" href="asignarCopagos?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-credit-card"></i> Asignar Copagos
                </a>
                <a class="btn btn-app bg-info" href="asignarContribucion?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-credit-card"></i> Asignar Contribución
                </a>                
                <a class="btn btn-app bg-success" href="agregarCieCpt?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Agregar CIE / CPT
                </a>
                <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <a class="btn btn-app bg-info" href="agregarComprobantePago?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-credit-card"></i> Agregar complemento de pago
                </a>
                  <a class="btn btn-app bg-success" href="agregarNotaMedica?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota médica
                </a>
                <a class="btn btn-app bg-success" href="agregarNotaPreoperatoria?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota preoperatoria
                </a>
                <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>

                <?php if ($registro['monto']=='0') { ?>
                <a class="btn btn-app bg-danger" href="agregarMontoServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-credit-card"></i> Agregar Montos
                </a><?php } else { 
                  if ($estatus!=4) { ?>
                <a class="btn btn-app bg-danger" href="editarMontoServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-info">$<?php echo $monto ?></span>
                  <i class="fas fa-credit-card"></i> Editar Montos
                </a><?php } } ?>
                <?php if ($notasno>=1) { ?>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <?php } ?>
               
                <?php if ($proveedorname!='') { ?>
                <a class="btn btn-app bg-warning"  href="dictamenServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-check"></i> Dictamen
                </a>
                <?php }
                if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
                  <?php } }  ?>
                  <?php if ($totalDictamen==0) { 
                ?>
                  <a class="btn btn-app bg-danger" href="cancelarServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-times"></i> Cancelar servicio
                </a>
                 <?php } ?>

                <?php if ($totalFacturas>=1) { ?>
                  <a class="btn btn-app bg-danger" href="facturasEnviada?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Ver facturas
                </a>
                 <?php } ?>
                 <?php if ($totalPagos>=1) { 
                ?>
                  <a class="btn btn-app bg-danger" href="pagosEnviados?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>" >
                  <i class="fas fa-file-pdf"></i> Ver comprobantes de pago
                </a>
                 <?php } ?>
                 <a class="btn btn-app bg-warning"  href="contabilidadServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-check"></i> Contabilidad
                </a>
              <?php } ?>

              <?php if ($tipousuario=='GestorRed') { ?>
                 <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <?php if ($notasno>=1) { ?>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <?php } ?>
                <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>
                <?php if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } }  ?>

              <?php } ?>

              <?php if ($tipousuario=='GestorMedicamentos') { ?>
                <?php if ($registro['servicio']!='MEDICAMENTOS') {
                  if ($estatus==1) {
                ?>
                <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-ambulance"></i> Asignar proveedor
                </a>
                <?php } } else { 
                  if ($proveedorname!=''){
                  ?>
                  <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>&idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos?>">
                  <i class="fas fa-ambulance"></i> Cambiar proveedor
                </a>
                <?php } } ?>

                 <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <?php if ($notasno>=1) { ?>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <?php } ?>
                <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>
                <?php if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
                  <?php } }  ?>


              <?php } ?>

              <?php if ($tipousuario=='ConciliacionPagos') { ?>
                <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <a class="btn btn-app bg-info" href="agregarComprobantePago?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-credit-card"></i> Agregar complemento de pago
                </a>
                <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <?php if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
                  <?php } }  ?>
                <?php if ($totalFacturas>=1) { ?>
                  <a class="btn btn-app bg-danger" href="facturasEnviada?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Ver facturas
                </a>
                 <?php } ?>
                 <a class="btn btn-app bg-warning"  href="contabilidadServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-check"></i> Contabilidad
                </a>
                  <?php if ($totalPagos>=1) { 
                ?>
                  <a class="btn btn-app bg-danger" href="pagosEnviados?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>" >
                  <i class="fas fa-file-pdf"></i> Ver comprobantes de pago
                </a>
                 <?php } ?>
                <?php } ?>

                <?php if ($tipousuario=='CoordinadorRed') { ?>
                  <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <?php if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
                  <?php } }  ?>

                <?php } ?>

                <?php if ($tipousuario=='CoordinadorMedicamentos') { ?>

                <?php if ($servicio=='MEDICAMENTOS') { 
                  if ($estatus==1) { ?>
                <a class="btn btn-app bg-info" href="solicitudMedicamentos?id=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&servicioprincipal=<?php echo $servicioprincipal?>">
                  <i class="fas fa-ambulance"></i> Solicitar Medicamentos
                </a>
                <?php } } ?>

                <?php if ($servicio!='MEDICAMENTOS') {
                  if ($estatus==1) {
                ?>
                <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-ambulance"></i> Asignar proveedor
                </a>
                <?php } } else { 
                  if ($proveedorname!=''){
                  ?>
                  <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>&idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos?>">
                  <i class="fas fa-ambulance"></i> Cambiar proveedor
                </a>
                <?php } } ?>
                <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <?php if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
                  <?php } }  ?>
              <?php } ?>
            <?php } else { ?>
              <?php if ($tipousuario=='Administrador'||$tipousuario=='CoordinadorRed'||$tipousuario=='CoordinadorMed'||$tipousuario=='CoordinadorMedicamentos'){ ?>
<?php if ($servicio=='MEDICAMENTOS') { 
                  if ($estatus==1) { ?>
                <a class="btn btn-app bg-info" href="solicitudMedicamentos?id=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&servicioprincipal=<?php echo $servicioprincipal?>">
                  <i class="fas fa-ambulance"></i> Solicitar Medicamentos
                </a>
                <?php } } ?>

                <?php if ($servicio!='MEDICAMENTOS') {
                  if ($estatus==1) {
                ?>
                <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-ambulance"></i> Asignar proveedor
                </a>
                <?php } } else { 
                  if ($proveedorname!=''){
                  ?>
                  <a class="btn btn-app bg-info" href="asignarProveedorServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta?>&idSolicitudMedicamentos=<?php echo $idSolicitudMedicamentos?>">
                  <i class="fas fa-ambulance"></i> Cambiar proveedor
                </a>
                <?php } } ?>
                <a class="btn btn-app bg-info" href="asignarCopagos?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-credit-card"></i> Asignar Copagos
                </a>
                <a class="btn btn-app bg-info" href="asignarContribucion?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-credit-card"></i> Asignar Contribución
                </a>                
                <a class="btn btn-app bg-success" href="agregarCieCpt?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Agregar CIE / CPT
                </a>
                <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <a class="btn btn-app bg-info" href="agregarComprobantePago?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-credit-card"></i> Agregar complemento de pago
                </a>
                  <a class="btn btn-app bg-success" href="agregarNotaMedica?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota médica
                </a>
                <a class="btn btn-app bg-success" href="agregarNotaPreoperatoria?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota preoperatoria
                </a>
                <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>

                <?php if ($registro['monto']=='0') { ?>
                <a class="btn btn-app bg-danger" href="agregarMontoServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-credit-card"></i> Agregar Montos
                </a><?php } else { 
                  if ($estatus!=4) { ?>
                <a class="btn btn-app bg-danger" href="editarMontoServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-info">$<?php echo $monto ?></span>
                  <i class="fas fa-credit-card"></i> Editar Montos
                </a><?php } } ?>
                <?php if ($notasno>=1) { ?>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <?php } ?>
               
                <?php if ($proveedorname!='') { ?>
                <a class="btn btn-app bg-warning"  href="dictamenServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-check"></i> Dictamen
                </a>
                <?php }
                if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
                  <?php } }  ?>
                  <?php if ($totalDictamen==0) { 
                ?>
                  <a class="btn btn-app bg-danger" href="cancelarServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta?>">
                  <i class="fas fa-times"></i> Cancelar servicio
                </a>
                 <?php } ?>

                <?php if ($totalFacturas>=1) { ?>
                  <a class="btn btn-app bg-danger" href="facturasEnviada?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Ver facturas
                </a>
                 <?php } ?>
                 <?php if ($totalPagos>=1) { 
                ?>
                  <a class="btn btn-app bg-danger" href="pagosEnviados?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>" >
                  <i class="fas fa-file-pdf"></i> Ver comprobantes de pago
                </a>
                 <?php } ?>
                 <a class="btn btn-app bg-warning"  href="contabilidadServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-check"></i> Contabilidad
                </a>
              <?php } ?>

              <?php if ($tipousuario=='GestorRed') { ?>
                 <a class="btn btn-app bg-primary" href="agregaDocumentosServicio?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-file-pdf"></i> Biblioteca del servicio
                </a>
                <?php if ($notasno>=1) { ?>
                <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
                <?php } ?>
                <a class="btn btn-app bg-success" href="agregarNotaAdministrativa?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <i class="fas fa-edit"></i> Crear nota administrativa
                </a>
                <?php if ($totalDictamen==0) {
                if ($servicio=='MEDICAMENTOS') {  ?>
                <a class="btn btn-app bg-info" href="garantiaDePagoServicioPDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } else { ?>
                  <a class="btn btn-app bg-info" href="garantiaDePagoServicio2PDF?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago (DEMO)
                </a>
                <?php } ?>                
                <?php } ?>
                <?php if ($totalDictamen>=1) {
                 if ($servicio=='MEDICAMENTOS') { 
                ?>
                <a class="btn btn-app bg-success" href="garantiaDePagoServicioPDFFinal?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } else { ?>
                  <a class="btn btn-app bg-success" href="garantiaDePagoServicio2PDFFinal?idBeneficiario==<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idProveedor=<?php echo $proveedorname ?>&servicioprincipal=<?php echo $servicioprincipal?>&idCuenta=<?php echo $idCuenta ?>" target="_blanck">
                  <i class="fas fa-tag"></i> Garantia de Pago
                </a>
              <?php } }  ?>
              <?php } else { ?>
              <a class="btn btn-app bg-warning"  href="reporteNotas?idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>">
                  <span class="badge bg-danger"><?php echo $notasno ?></span>
                  <i class="fas fa-file"></i> Ver notas
                </a>
            <?php } } ?>

                 
                </div>
              </div>
            </div>
        </div>
      </div>
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

<script type="text/javascript">
        $(document).ready(function(){
        $(document).on('click', '#btnView', function(e){
        // alert((this).data('id'));
        e.preventDefault();
        var uid = $(this).data('id'); 
        // alert(uid);
        $.ajax({
            url: 'consultas/consultasSeguimientos',
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


 

