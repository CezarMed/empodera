<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class editaAcuseFinal_class {

function accionesDictamen() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('editaAcuse', $datosCmb)) {
         $resp= $this->editaAcuse();
    }
}




// funcion para dar de alta registro
function editaAcuse() {
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

$queryUpdate="UPDATE archivosacuses SET fechaEntrega='".$arrayDatos['fechaEntregaActualiza']."' where idAcuse=".$arrayDatos['idAcuse']."";
$crea=mysqli_query($con,$queryUpdate);

// subo y creo el campo archivoXML
$codigoP=generarCodigo(10);
$archivo = $_FILES['archivo'];
$archivonombre = $_FILES["archivo"]["name"];
$nombreArchivo=$codigoP.'-'.$archivonombre;
$codigo=$archivo['name'];
$url121 ='documentosempodera/acuses/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/acuses/'.$nombreArchivo;
move_uploaded_file($archivo['tmp_name'], $url121);
$queryUpdate="UPDATE archivosacuses SET archivo='".$nombreArchivo."' where idAcuse=".$arrayDatos['idAcuse']."";
$crea=mysqli_query($con,$queryUpdate);
} else {
    $url121='';
 }

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "verAcusesServicio?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="verAcusesServicio?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>&idCuenta=<?php echo $arrayDatos['idCuenta'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('editaAcuse', $_POST)) {
                $datos_getpost['editaAcuse'] = $_POST['editaAcuse'];
            }
            if (array_key_exists('fechaEntregaActualiza', $_POST)) {
                $datos_getpost['fechaEntregaActualiza'] =  $_POST['fechaEntregaActualiza'];
            }
            if (array_key_exists('idAcuse', $_POST)) {
                $datos_getpost['idAcuse'] =  $_POST['idAcuse'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] =  $_POST['idServicio'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] =  $_POST['idBeneficiario'];
            } 
            if (array_key_exists('idCuenta', $_POST)) {
                $datos_getpost['idCuenta'] =  $_POST['idCuenta'];
            }        
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>