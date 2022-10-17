<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altacopagos_class {

function accionesCopagos() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaCopago', $datosCmb)) {
         $resp= $this->altaCopago();
    }
}

// funcion para dar de alta registro
function altaCopago() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);

// subo y creo el campo archivoXML
$archivo = $_FILES['archivo'];
$nombreArchivo=$arrayDatos['tipocopago'].'-copago-'.$codigoP;
$codigo=$archivo['name'];
$url121 ='documentosempodera/copagos/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/copagos/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url121);
 } else {
    $url121='';
 }

$monto=$arrayDatos['monto'];
$monto = str_replace( ',', '', $monto );
$monto = str_replace( '$', '', $monto );

$query="INSERT INTO archivoscopagos (idCuenta,idBeneficiario,tipocopago,archivo,monto,idSubio,fechaSubida,estatus)
        values 
        (" . $arrayDatos['idCuenta'] ."," . $arrayDatos['idBeneficiario'] .",'" . $arrayDatos['tipocopago'] ."','" . $url121 ."','" . $monto ."',". $idUsuario .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregarCopagosCuentaBeneficiario?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
             window.location="agregarCopagosCuentaBeneficiario?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaCopago', $_POST)) {
                $datos_getpost['altaCopago'] = $_POST['altaCopago'];
            }
            if (array_key_exists('idCuenta', $_POST)) {
                $datos_getpost['idCuenta'] =  $_POST['idCuenta'];
            } 
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] =  $_POST['idBeneficiario'];
            }
            if (array_key_exists('tipocopago', $_POST)) {
                $datos_getpost['tipocopago'] =  $_POST['tipocopago'];
            }
            if (array_key_exists('monto', $_POST)) {
                $datos_getpost['monto'] =  $_POST['monto'];
            }         
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>