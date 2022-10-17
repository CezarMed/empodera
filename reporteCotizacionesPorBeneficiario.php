<?php 
error_reporting(0);
require_once ("header.php");
require_once ("menu.php");
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reporte de solicitud de Cotizaciones</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Cotizaciones</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

            <?php if ($_GET['do']==3) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La orden de compra se envio correctamente al proveedor</a>
                </div>
                </div>
  <?php } ?>




    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Cotizaciones realizadas </h3>
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
                  <label>Nombre del beneficiario</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nombreBeneficiario" name="nombreBeneficiario" placeholder="Nombre completo del beneficiario" onchange='buscaCotizaciones()'>
                  </div>                
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-12">
                  <div id="tabladatos">
                  </div>               
                </div>
              </div>
              

              


            </div>
          </div>          
        </div>



        </div>



        
    </section>



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
    function buscaCotizaciones() {
      var nombreBeneficiario=$('#nombreBeneficiario').val();

      if (nombreBeneficiario!='') {
        // alert(nombreBeneficiario);
        $.ajax({
            url: 'consultas/consultasCotizacionesBeneficiario',
            type: "POST",
            data: {"consultasSocios":nombreBeneficiario},
            success: function (cmb) {
                     // alert(cmb);
                     $('#tabladatos').html(cmb);
                
            }
        });
      }
  }
</script>

 

