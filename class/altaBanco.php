<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altabanco_class {

function accionesBancos() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaBanco', $datosCmb)) {
         $resp= $this->altaBanco();
    }
    if (array_key_exists('actualizaBanco', $datosCmb)) {
         $resp= $this->actualizaBanco();
    }
}

// funcion para dar de alta registro
function altaBanco() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$query="INSERT INTO bancos (nombreBanco,idUsuario,fechaAlta,estatus)
        values 
        ('" . $arrayDatos['nombreBanco'] ."',". $idUsuaio .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregarBanco?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="agregarBanco?do=11";
        </script>
        <?php }
}


function actualizaBanco() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idBanco=$arrayDatos['idBanco'];

$query="UPDATE bancos SET nombreBanco='" . $arrayDatos['nombreBanco'] ."' where idBanco=$idBanco";
         $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "agregarBanco?do=2";
        </script> 
        <?php } else {
        $queryUpdate="INSERT INTO movimientosbancos (idBanco,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idBanco,$idUsuaio,'EDITAR NOMBRE','" . $hoy ."')";
         $actualizar=mysqli_query($con,$queryUpdate); 
        ?>
        <script type="text/javascript">
              window.location="agregarBanco?do=1";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('nombreBanco', $_POST)) {
                $datos_getpost['nombreBanco'] = $_POST['nombreBanco'];
            }
            if (array_key_exists('idBanco', $_POST)) {
                $datos_getpost['idBanco'] =  $_POST['idBanco'];
            }          
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>