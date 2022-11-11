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
            <h1>Busqueda de cuentas del beneficiario</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Servicios del beneficiario</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <?php if ($_GET['do']==1) { ?>
      <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> En hora buena!</h5>
                  La nota se genero correctamente
                </div>
                </div>
  <?php } ?>

  <?php if ($_GET['do']==2) { ?>
      <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> UPS!</h5>
                  La nota no se genero correctamente, si lo deseas contacta con un administrador
                </div>
                </div>
  <?php } ?>
  
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">FILTROS PARA LA BUSQUEDA</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Buscar por:</label>
                  <div class="input-group">
                    <select class="custom-select form-control-border" id="buscapor" name="buscapor">
                  <option value="nombreBeneficiario">Nombre del beneficiario</option>
                  <option value="folioBeneficiario">Número del beneficiario</option>
                  <option value="folioEmpodera">Folio de Servicio</option>
                  </select>
                  </div>                
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Ordenar por:</label>
                  <div class="input-group">
                    <select class="custom-select form-control-border" id="ordenarpor" name="ordenarpor">
                  <option value="ASC">ASCENDENTE A-Z</option>
                  <option value="DESC">DESCENDENTE Z-A</option>
                  </select>
                  </div>                
                </div>
              </div>
              </div>

              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Escribe el nombre del beneficiario</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nombreBeneficiario" name="nombreBeneficiario" placeholder="Puedes ocupar solo nombres, apellidos o ambos, encontraremos todas las coincidencias" >
                  </div>                
                </div>
              </div>

               
              </div>
              <div class="card-footer">
                  <button type="button" class="btn btn-success" onclick='buscaBeneficiario()'>Buscar</button>
                </div>

              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-sm-12" id="tabladatos">
                  </div>
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
    function buscaBeneficiario() {
      var buscarpor=$('#buscapor').val();
      var nombreBeneficiario=$('#nombreBeneficiario').val();

      if (nombreBeneficiario!='') {
        // alert(nombreBeneficiario);
        $.ajax({
            url: 'consultas/consultasBeneficiariosNotas',
            type: "POST",
            data: {"consultasSocios":nombreBeneficiario,"buscarpor":buscarpor},
            success: function (cmb) {
                     // alert(cmb);
                     $('#tabladatos').html(cmb);
                
            }
        });
      }

  }

</script>

 

