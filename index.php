<?php 
error_reporting(0);
// realizamos conexion a bd
require_once ("class/conexion.php");
$conexion=conexion();
#Para el logueo
include ('class/class_login.php');
//creo el nuevo acceso
$acceso = new login();
if (isset($_POST['grabar']) and $_POST['grabar'] == 'si') {
    //accesando de manera correcta
    $acceso->nueva_sesion();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Empodera | Acceso plataforma</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="shortcut icon" href="dist/img/favicon.ico">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><img src="dist/img/logo_empodera.png" width="80%"></p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" id="username" placeholder="Usuario" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          <input type="hidden" name="grabar" value="si" />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
              <?php if ($_GET['usuario']=="EL_USUARIO_NO_EXISTE") { ?>
      <div class="col-sm-12">
      <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Ups!</h5>
                  Datos de acceso no validos
                </div>
                </div>
        <?php } ?>
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-block bg-gradient-dark btn-lg">Ingresar a plataforma</button>
          </div>
          <div class="col-12">
            <p><center>
              <font size="2px">Versión 4.0</font></center></p>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
