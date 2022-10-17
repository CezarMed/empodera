        <legend>Solicitud de Medicamentos</legend>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php 
                  $query2 = 'SELECT * from solicitudmedicamentos where estatus=1';
                  $res2 = mysqli_query($con,$query2);
                  $total2 = $res2->num_rows;
                  ?>
                <h3><?php echo $total2; ?></h3>
                <p>Activos</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="vistaSolicitudMedicamentos?estatus=1" class="small-box-footer">+ info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php 
                  $query = 'SELECT * from solicitudmedicamentos where estatus=3';
                  $res = mysqli_query($con,$query);
                  $total = $res->num_rows;
                  ?>
                <h3><?php echo $total; ?></h3>
                <p>Completados</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="vistaSolicitudMedicamentos?estatus=3" class="small-box-footer">+ info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <?php 
                  $query = 'SELECT * from solicitudmedicamentos where estatus=2 GROUP BY idsolicitudMedicamentos';
                  $res = mysqli_query($con,$query);
                  $total = $res->num_rows;
                  ?>
                <h3><?php echo $total; ?></h3>

                <p>En espera de validación</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="vistaSolicitudMedicamentos?estatus=2" class="small-box-footer">+ info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php 
                  $query = 'SELECT * from solicitudcotizaciones where estatus=1 GROUP BY idsolicitudMedicamentos';
                  $res = mysqli_query($con,$query);
                  $total = $res->num_rows;
                  ?>
                <h3><?php echo $total; ?></h3>

                <p>En Cotización</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="vistaCotizacionesPendientes?estatus=1" class="small-box-footer">+ info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>