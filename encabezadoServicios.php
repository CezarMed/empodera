 <?php
    $idBeneficiario=$_GET['idBeneficiario'];
    $idServicio=$_GET['idServicio']; 

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

    $query = "SELECT * from servicios s
    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario 
    where s.idServicio=$idServicio";
    $res = mysqli_query($con,$query);
    while ($registro = mysqli_fetch_array($res)) {
    $servicio=$registro['servicio'];
    ?>
    <section class="content">
       <div class="callout callout-info">
       <h5><i class="fas fa-info"></i> Datos del Servicio</h5>
       Folio de solicitud <b><?php echo $registro['folioEmpodera'] ?></b> para el benefeciario <b><?php echo $registro['nombreBeneficiario'] ?></b> con el servicio solicitado de <b><?php echo $registro['servicio'] ?></b> con un monto autorizado de: <b>$<?php echo number_format($registro['monto'], 2, '.', ',') ?></b>
       <?php 
        $queryPrograma = "SELECT * from montosclientes mc
        INNER JOIN clientes cli on cli.idCliente=mc.idCliente
        where mc.idMontoCliente=$idCuenta and estatus=1";
        $resPrograma = mysqli_query($con,$queryPrograma);
        ?>
       <br><b>GRUPO ASIGNADO:</b> <br>
       <?php 
       $extraidoPrograma= mysqli_fetch_array($resPrograma); 
       echo $extraidoPrograma['nombreCliente'] ?> / <?php echo $extraidoPrograma['nombreAcuerdo'] ?> / <?php echo $extraidoPrograma['subgrupo'] ?> / $<?php echo $extraidoPrograma['montoautorizadocliente'] ?> / $<?php echo $extraidoPrograma['contribucion'] ?> / $<?php echo $extraidoPrograma['copago'] ?><br>

        <?php 
        $queryCie = "SELECT * from datoscie where idServicio=$idServicio and estatus=1";
        $resCie = mysqli_query($con,$queryCie);
        ?>
        <br><b>DATOS CIE10:</b> <br><?php while ($extraidoCie= mysqli_fetch_array($resCie)) { echo $extraidoCie['cie10'] ?>, <?php echo $extraidoCie['diagnosticocie10'] ?><br>
        <?php } ?>
        <?php 
        $queryCie = "SELECT * from datoscpt where idServicio=$idServicio";
              $resCie = mysqli_query($con,$queryCie);
         $queryConsulta = "SELECT * from datosconsultas where idServicio=$idServicio and estatus=1";
              $resConsulta = mysqli_query($con,$queryConsulta);
        ?>
        <br><b>DATOS CPT4:</b><br>
        <?php while ($extraidoCie= mysqli_fetch_array($resCie)) {
         $grupocpt=$extraidoCie['tratamientocpt4']; 
         echo $extraidoCie['cpt4'] ?>, <?php echo $extraidoCie['tratamientocpt4'] ?><br>
        <?php } ?>
        <?php while ($extraidoConsulta= mysqli_fetch_array($resConsulta)) { echo $extraidoConsulta['cpt4'] ?>, <?php echo $extraidoConsulta['consultacpt4'] ?><br>
        <?php } ?>
        <?php if ($proveedorname!='') { ?>
           <br><b>PROVEEDOR ASIGNADO: </b><?php echo $nombreComercial ?><br>
        <?php } ?>
        <?php if ($totalDictamen>=1) { ?>
           <br><b>DICTAMEN GENERADO: </b><?php echo $extraidoDictamen['observaciones'] ?> POR UN MONTO DE: $<?php echo $montoFacturable ?><br>
        <?php } ?>
        <hr>
        <a class="btn btn-warning btn-sm" href="detalleDeServicio?idBeneficiario=<?php echo $idBeneficiario; ?>&idServicio=<?php echo $idServicio; ?>&idCuenta=<?php echo $idCuenta; ?>">
                              <i class="fas fa-check">
                              </i>
                             Ir al panel de servicio
                          </a>
        <a class="btn btn-success btn-sm" href="agregarServiciosBeneficiario?idBeneficiario=<?php echo $idBeneficiario; ?>&idCuenta=<?php echo $idCuenta; ?>">
                              <i class="fas fa-check">
                              </i>
                             Ir a la cuenta seleccionada
                          </a>
       </div>
    </section>
<?php } ?>