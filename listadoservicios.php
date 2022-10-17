<div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Últimos servicios generados en plataforma</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Folio Servicio</th>
                      <th>Tipo de Servicio</th>
                      <th>Beneficiario</th>
                      <th>Estatus</th>
                      <th>Tiempo transcurrido</th>
                      <th>Usuario alta</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    function dateDiff($start, $end) {
    
                    $datetime1 = new DateTime($start);
                    $datetime2 = new DateTime($end);
                    $interval = $datetime1->diff($datetime2);
                        //return $interval->format('%R%a days');
                        return $interval->format("%a dia(s) con %H:%I:%S (hrs)");
                    }

                    $date2 = new DateTime("now");
                    $queryservicios="SELECT te.descripcionEstatus, s.servicioprincipal,  s.observaciones, s.idBeneficiario, s.idServicio, s.folioEmpodera, b.nombreBeneficiario, s.servicio, s.estatus, s.fechaAlta, u.usuario from servicios s
                    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario
                    INNER JOIN tipoestatus te on te.idEstatus=s.estatus
                    INNER JOIN usuarios u on u.idUsuario=s.idUsuario
                    ORDER BY s.idServicio DESC LIMIT 10";
                    $resservicios = mysqli_query($con,$queryservicios);
                    while ($extraidoservicios= mysqli_fetch_array($resservicios)) {
                      $idServicio=$extraidoservicios['idServicio'];
                      $idBeneficiario=$extraidoservicios['idBeneficiario'];
                      $descripcionEstatus=$extraidoservicios['descripcionEstatus'];
                      $fechaAlta=$extraidoservicios['fechaAlta'];
                      $servicioprincipal=$extraidoservicios['servicioprincipal'];
                      $observaciones=$extraidoservicios['observaciones'];
                      $hoy=date('Y-m-d H:i:s');
                      $tiempo_atencion = dateDiff($extraidoservicios['fechaAlta'],$hoy);
                    ?>
                    <tr>
                      <td><a href="detalleDeServicio?idServicio=<?php echo $idServicio ?>&idBeneficiario=<?php echo $idBeneficiario ?>"><?php echo $extraidoservicios['folioEmpodera'] ?></a>
                        
                      </td>
                      <td><?php echo $extraidoservicios['servicio'] ?> <small class="text-success mr-1"><?php if ($servicioprincipal!=0) { echo $observaciones; } ?></small>
                      </td>
                      <td><?php echo $extraidoservicios['nombreBeneficiario'] ?></td>
                      <?php 
                      if ($descripcionEstatus=='Cotizaciones Entregadas'){
                        $queryCotizaciones="SELECT count(*) as total FROM solicitudmedicamentos sm
                        INNER JOIN solicitudcotizaciones sc ON sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos 
                        WHERE sm.idServicio=$idServicio and sc.estatus=2";
                        $resserviciosCot = mysqli_query($con,$queryCotizaciones);
                        $extraidoserviciosCot= mysqli_fetch_array($resserviciosCot);
                        $totalCoti=$extraidoserviciosCot['total'];
                      }
                      ?>
                      <td><span class="badge badge-success"><?php echo strtoupper($descripcionEstatus) ?> <?php if ($descripcionEstatus=='Cotizaciones Entregadas') { echo "($totalCoti)"; } ?></span></td>
                      <td><?php echo $tiempo_atencion ?></td>
                      <td><font color="red"><?php echo strtoupper($extraidoservicios['usuario']) ?></font></td>
                    </tr>
                    <?php
                      }
                    ?>                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>