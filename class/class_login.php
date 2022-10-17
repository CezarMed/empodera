<?php
date_default_timezone_set ('America/Mexico_City');
session_start();
class login {
    function nueva_sesion(){
        require_once ('conexion.php');
        $conn=conexion();
        // recogemos las variables post del formulario
        $nombre = $_POST['username'];
        $password = $_POST['password'];
        //$pass=sha1($password);
        // realizamos la consulta sql 
        $queryDa="SELECT * FROM usuarios WHERE estatus=1 and usuario='$nombre' AND contrasena='$password'";
        // consulto los datos de geoplugin para conocer los datos
        $IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
        $regs=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
        $ciudad=$regs['geoplugin_city'];
        $region=$regs['geoplugin_region'];
        $pais=$regs['geoplugin_countryName'];
        $latitud=$regs['geoplugin_latitude'];
        $longitud=$regs['geoplugin_longitude'];
        $resultado1=mysqli_query($conn,$queryDa);
        $reg=mysqli_fetch_array($resultado1);
        if ($reg['idUsuario']>0)
        {
          $_SESSION['idUsuario'] = $reg["idUsuario"];
          $_SESSION['usuario'] = $reg["usuario"];
          $_SESSION['nombre'] = $reg["nombre"];
          $_SESSION['tipousuario'] = $reg["tipousuario"];
          $_SESSION['Imagen'] = $reg["Imagen"];
          $_SESSION['idEmpresa'] = $reg["idEmpresa"];
          // agrego datos a la bitacora
          $sql="call sp_bitacoralogin('".$nombre."','".$password."',".$_SESSION['idUsuario'].",'".$_SESSION['tipousuario']."','".$IP_ADDRESS."','".$pais."','".$ciudad."','".$region."','".$latitud."','".$longitud."','".$IP_ADDRESS."',15)";
          $insert = mysqli_query($conn,$sql);
          // direcciono al panel principal
          header("location: panelPrincipal");
        }
        else
        {
           $sql1="call sp_bitacoralogin('".$nombre."','".$password."',0,0,'".$IP_ADDRESS."','".$pais."','".$ciudad."','".$region."','".$latitud."','".$longitud."','".$_POST['ipLocal']."',16)";
           $insert = mysqli_query($conn,$sql1);
           // direcciono al index
           header("location: index?usuario=EL_USUARIO_NO_EXISTE");
        }
    }

    private function varSession() 
    {
        session_name("usuario");        
        session_name("idUsuario");
        session_name("nombre");
        session_name("tipousuario");
        session_name("correo");
        session_name("ultimoAcceso");
        session_start();
    }

    /**
     *  funcion cerrarSession
     * 
     * destruye la sesion creada  
     * 
     */
    public function cerrarSession() 
    {
    $this->varSession();
    if ($_SESSION['nombre'] == '') { ?>
    <script type="text/javascript">
      window.location = "index";
    </script>    
    <?php 
    }
    session_start(); 
    $queryActivos = "UPDATE usuarios SET Activo=0 WHERE idUsuario=".$_SESSION['idUsuario'];
    $resultadoActivos = mysqli_query($conn,$queryActivos);
    session_destroy(); 
    unset($_SESSION);
    $this->_status;
    header("Location: index");
    }

}
?>