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
            <h1>Busqueda de Medicamentos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Empodera</a></li>
              <li class="breadcrumb-item active">Medicamentos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Coloca el nombre o parte del medicamento</h3>
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
                  <label>Nombre del medicamento (busca por coincidencia)</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nombreMedicamento" name="nombreMedicamento" placeholder="Nombre del medicamento">
                  </div>                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label> </label>
                  <div class="input-group">
                    <button type="button" class="btn btn-success"  onclick="buscarMedicamento()">Encontrar medicamento</button>
                  </div>                
                </div>
              </div>
            </div>

            <div class="row" id="divloading" style="display: none;">
              <div class="col-md-12">
                <div class="form-group">
                  <center><div class="spinner-border text-primary"></div></center>
                  </div>                
                </div>                
              </div>

            <div class="row" id="tablaListado">
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

<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>

<script type="text/javascript">
    function buscarMedicamento() {
      var nombreMedicamento=$('#nombreMedicamento').val();

      if (nombreMedicamento!=''){
        $.ajax({
            url: 'consultas/consultasMedicamentosListado.php',
            type: "POST",
            data: {"nombreMedicamento":nombreMedicamento},  
            beforeSend: function () {
              $('#divloading').show();
            },          
            success: function (cmb) {
                     // alert(cmb);
                     $('#nombreMedicamento').val('');
                     $('#divloading').hide();
                     $('#tabladatos').html(cmb); 

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
        title: ' Es necesario colocar el nombre de un medicamento para realizar la busqueda'
      })
    });
    });
      }
  }
</script>



 

