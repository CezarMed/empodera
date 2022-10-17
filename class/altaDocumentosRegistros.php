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
$nombreArchivo=$arrayDatos['tipoDocumento'].'-biblioteca-'.$codigoP;
$codigo=$archivo['name'];
$url121 ='documentosempodera/registros/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/registros/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url121);
 } else {
    $url121='';
 }

 $concepto=$arrayDatos['tipoDocumento'];
if ($concepto=='Otro'){
 $concepto=$concepto." / ".$arrayDatos['otro'];
}


$query="INSERT INTO registrosdocumentos (idRegistro,concepto,archivo,idSubio,fechaSubida,estatus)
        values 
        ('" . $arrayDatos['idRegistro'] ."','" . $concepto ."','" . $url121 ."',". $idUsuario .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "agregaDocumentosProveedor?do=2&id=<?php echo $arrayDatos['idRegistro'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
              window.location="agregaDocumentosProveedor?do=11&id=<?php echo $arrayDatos['idRegistro'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaArchivo', $_POST)) {
                $datos_getpost['altaArchivo'] = $_POST['altaArchivo'];
            }
            if (array_key_exists('tipoDocumento', $_POST)) {
                $datos_getpost['tipoDocumento'] =  $_POST['tipoDocumento'];
            } 
            if (array_key_exists('otro', $_POST)) {
                $datos_getpost['otro'] =  $_POST['otro'];
            } 
            if (array_key_exists('idRegistro', $_POST)) {
                $datos_getpost['idRegistro'] =  $_POST['idRegistro'];
            }          
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>