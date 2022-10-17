<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaProveedorAsignacion_class {

function accionesCieCpt() {
    $datosCmb = $this->GETPOST();
    // llamar las funciones 
    if (array_key_exists('altaCierreServicio', $datosCmb)) {
       $resp= $this->altaCierreServicio();
    }
}

// funcion para dar de alta registro
function altaCierreServicio() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuaio=$_SESSION['idUsuario'];
        // OBTENGO EL NOMBRE DEL USUARIO
        $queryUsuario="SELECT * FROM usuarios where idUsuario=$idUsuario";
        $res=mysqli_query($con, $queryUsuario);
        $extraidoUsuario=mysqli_fetch_array($res);
        $nombreUsuario=$extraidoUsuario['usuario'];
        $hoy=date('Y-m-d H:i:s');
        $idBeneficiario=$arrayDatos['idBeneficiario'];
        $idServicio=$arrayDatos['idServicio'];
        $idCuenta=$arrayDatos['idCuenta'];
        $folioServicio=$arrayDatos['folioServicio'];
        $siglas="EMP-";
        $idRegistro=$arrayDatos["proveedorname"];
        // obtengo el rfc del proveedor
        $query="SELECT * FROM registros where idRegistro=$idRegistro";
        $res = mysqli_query($con,$query);
        $registro = mysqli_fetch_array($res);
        $rfcCedula=$registro['rfcCedula'];
        $nombreComercial=$registro['nombreComercial'];
        $siglasProveedor=substr($rfcCedula,0,3);

        // Creo el folio unico del servicio para carta
        $folioUnico=$siglas.''.$folioServicio.'-'.$siglasProveedor;

        // insertamos la informacion enviada por el formulario
        $sql1 = "UPDATE servicioscerradosproveedor SET folioCierre='".$folioUnico."', fechaAsignacion='".$arrayDatos["fechaAsignacion"]."', proveedorname=".$arrayDatos["proveedorname"].", fechaServicio='".$arrayDatos["fechaServicio"]."', contenidonota='".$arrayDatos["contenidonota"]."' WHERE idCierre=".$arrayDatos["idAsignacion"]."";
        $crea=mysqli_query($con, $sql1);

        // agrego la nota automatica
        /*
        $insertarNota="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$idServicio.",'SE ASIGNA PROVEEDOR ".$nombreComercial."','".$hoy."',1)";
            mysqli_query($con,$insertarNota);  
            */

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "detalleDeServicio?do=2&idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="detalleDeServicio?do=1&idBeneficiario=<?php echo $idBeneficiario ?>&idServicio=<?php echo $idServicio ?>&idCuenta=<?php echo $idCuenta ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaCierreServicio', $_POST)) {
                $datos_getpost['altaCierreServicio'] = $_POST['altaCierreServicio'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] = $_POST['idBeneficiario'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('folioServicio', $_POST)) {
                $datos_getpost['folioServicio'] = $_POST['folioServicio'];
            }
            if (array_key_exists('fechaAsignacion', $_POST)) {
                $datos_getpost['fechaAsignacion'] = $_POST['fechaAsignacion'];
            }
            if (array_key_exists('fechaServicio', $_POST)) {
                $datos_getpost['fechaServicio'] = $_POST['fechaServicio'];
            }
            if (array_key_exists('proveedorname', $_POST)) {
                $datos_getpost['proveedorname'] = $_POST['proveedorname'];
            }
            if (array_key_exists('contenidonota', $_POST)) {
                $datos_getpost['contenidonota'] = $_POST['contenidonota'];
            }
            if (array_key_exists('idAsignacion', $_POST)) {
                $datos_getpost['idAsignacion'] = $_POST['idAsignacion'];
            } 
            if (array_key_exists('idCuenta', $_POST)) {
                $datos_getpost['idCuenta'] = $_POST['idCuenta'];
            }     
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>