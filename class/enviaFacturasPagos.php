<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class enviaFacturaPago_class {

function accionesFacturas() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('autorizarPago', $datosCmb)) {
         $resp= $this->autorizarPago();
    }
}

// funcion para dar de alta registro
function autorizarPago() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];

            $number = count($_POST["idGruposFacturas"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idGruposFacturas"][$i]!= ''))
            {
                // agrego los costos de los medicamentos a la cotizacion del proveedor
                $sql12 = "UPDATE gruposfacturas SET estatus=8 where idGrupoFactura='".$_POST['idGruposFacturas'][$i]."'";
                $crea=mysqli_query($con, $sql12);

            }
            }
            }


        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "validarGruposFacturasPagos?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
             window.location="validarGruposFacturasPagos?do=1";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('autorizarPago', $_POST)) {
                $datos_getpost['autorizarPago'] =  $_POST['autorizarPago'];
            }          
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>