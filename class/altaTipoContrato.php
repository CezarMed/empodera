<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altatipocontrato_class {

function accionesTipoContrato() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaTipoContrato', $datosCmb)) {
         $resp= $this->altaTipoContrato();
    }
    if (array_key_exists('actualizaContrato', $datosCmb)) {
         $resp= $this->actualizaContrato();
    }
}

// funcion para dar de alta registro
function altaTipoContrato() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$query="INSERT INTO situacioncontrato (situacion,estatus)
        values 
        ('" . $arrayDatos['tipoContrato'] ."',1)";
		    $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregarTipoContrato?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="agregarTipoContrato?do=11";
        </script>
        <?php }
}


function actualizaContrato() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$idBanco=$arrayDatos['idBanco'];

$query="UPDATE situacioncontrato SET situacion='" . $arrayDatos['nombreBanco'] ."' where idSituacionContrato=$idBanco";
         $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "agregarTipoContrato?do=2";
        </script> 
        <?php } else {
        $queryUpdate="INSERT INTO movimientostiposcontrato (idBanco,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idBanco,$idUsuaio,'EDITAR NOMBRE','" . $hoy ."')";
         $actualizar=mysqli_query($con,$queryUpdate); 
        ?>
        <script type="text/javascript">
              window.location="agregarTipoContrato?do=1";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaTipoContrato', $_POST)) {
                $datos_getpost['altaTipoContrato'] = $_POST['altaTipoContrato'];
            }
            if (array_key_exists('tipoContrato', $_POST)) {
                $datos_getpost['tipoContrato'] = $_POST['tipoContrato'];
            }
            if (array_key_exists('idBanco', $_POST)) {
                $datos_getpost['idBanco'] =  $_POST['idBanco'];
            }
            if (array_key_exists('actualizaContrato', $_POST)) {
                $datos_getpost['actualizaContrato'] =  $_POST['actualizaContrato'];
            } 
            if (array_key_exists('nombreBanco', $_POST)) {
                $datos_getpost['nombreBanco'] =  $_POST['nombreBanco'];
            }  

        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>