<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altacontribucion_class {

function accionesContribucion() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaContribucion', $datosCmb)) {
         $resp= $this->altaContribucion();
    }
}

// funcion para dar de alta registro
function altaContribucion() {
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
$url121 ='documentosempodera/contribucion/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/contribucion/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url121);
 } else {
    $url121='';
 }

$monto=$arrayDatos['monto'];
$monto = str_replace( ',', '', $monto );
$monto = str_replace( '$', '', $monto );

$query="INSERT INTO archivoscontribucion (idCuenta,idBeneficiario,tipocopago,archivo,monto,idSubio,fechaSubida,estatus)
        values 
        (" . $arrayDatos['idCuenta'] ."," . $arrayDatos['idBeneficiario'] .",'" . $arrayDatos['tipocontribucion'] ."','" . $url121 ."','" . $monto ."',". $idUsuario .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregarContribucionBeneficiario?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
             window.location="agregarContribucionBeneficiario?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaContribucion', $_POST)) {
                $datos_getpost['altaContribucion'] = $_POST['altaContribucion'];
            }
            if (array_key_exists('idCuenta', $_POST)) {
                $datos_getpost['idCuenta'] =  $_POST['idCuenta'];
            } 
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] =  $_POST['idBeneficiario'];
            }
            if (array_key_exists('tipocontribucion', $_POST)) {
                $datos_getpost['tipocontribucion'] =  $_POST['tipocontribucion'];
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