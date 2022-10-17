<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaMontoServicio_class {

function accionesMontoServicio() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaMontoServicio', $datosCmb)) {
         $resp= $this->altaMontoServicio();
    }
    if (array_key_exists('editarMontoServicio', $datosCmb)) {
         $resp= $this->editarMontoServicio();
    }
}

// funcion para dar de alta registro
function altaMontoServicio() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$monto=$arrayDatos['monto'];
$monto = str_replace( ',', '', $monto );
$monto = str_replace( '$', '', $monto );

        // agrego el monto autorizado al servicio, actualizo tabla
        $query="UPDATE servicios SET monto='" . $monto ."' where idServicio=" . $arrayDatos['idServicio'] ."";
         $crea=mysqli_query($con,$query);


        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "detalleDeServicio?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="detalleDeServicio?do=11&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>
        <?php }
}


function editarMontoServicio() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$monto=$arrayDatos['monto'];
$monto = str_replace( ',', '', $monto );
$monto = str_replace( '$', '', $monto );
$query="UPDATE servicios SET monto='" . $monto."' where idServicio=" . $arrayDatos['idServicio'] ."";
         $crea=mysqli_query($con,$query);



        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "detalleDeServicio?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="detalleDeServicio?do=11&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>
        <?php }
}




function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('monto', $_POST)) {
                $datos_getpost['monto'] = $_POST['monto'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] =  $_POST['idServicio'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] =  $_POST['idBeneficiario'];
            }                      
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>