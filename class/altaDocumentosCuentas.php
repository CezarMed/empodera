<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class Altaarchivos_class {

function accionesArchivos() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaArchivo', $datosCmb)) {
         $resp= $this->altaArchivo();
    }
}

// funcion para dar de alta registro
function altaArchivo() {
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
$nombreArchivo=$arrayDatos['concepto'].'-biblioteca-'.$codigoP;
$codigo=$archivo['name'];
$url121 ='documentosempodera/cuentas/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/cuentas/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url121);
 } else {
    $url121='';
 }


$query="INSERT INTO documentoscuentas (idCuenta,idBeneficiario,concepto,archivo,idSubio,fechaSubida,estatus)
        values 
        ('" . $arrayDatos['idCuenta'] ."','" . $arrayDatos['idBeneficiario'] ."','" . $arrayDatos['concepto'] ."','" . $url121 ."',". $idUsuario .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregarArchivosCuenta?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="agregarArchivosCuenta?do=11&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaArchivo', $_POST)) {
                $datos_getpost['altaArchivo'] = $_POST['altaArchivo'];
            }
            if (array_key_exists('concepto', $_POST)) {
                $datos_getpost['concepto'] =  $_POST['concepto'];
            } 
            if (array_key_exists('idCuenta', $_POST)) {
                $datos_getpost['idCuenta'] =  $_POST['idCuenta'];
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