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
$url121 ='documentosempodera/servicios/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/servicios/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url121);
 } else {
    $url121='';
 }


$query="INSERT INTO serviciosdocumentos (idServicio,concepto,archivo,idSubio,fechaSubida,estatus)
        values 
        ('" . $arrayDatos['idServicio'] ."','" . $arrayDatos['concepto'] ."','" . $url121 ."',". $idUsuario .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregaDocumentosServicio?do=2&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="agregaDocumentosServicio?do=11&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
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
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] =  $_POST['idServicio'];
            }          
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>