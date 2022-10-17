<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class respondeOrdenPago2_class {

function accionesOrdenPago() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('responderOrdenPago2', $datosCmb)) {
         $resp= $this->responderOrdenPago2();
    }
}

// funcion para actualizar los datos de cotizacion
function responderOrdenPago2() {
$con=conexion();
$arrayDatos = $this->GETPOST();
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

//subo y creo el campo arhivoOrdencompra
$archivo = $_FILES['archivo'];
$nombreArchivo='pagoFactura-'.$codigoP;
$codigo=$archivo['name'];
$url12 ='documentosempodera/pagos/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url12 ='documentosempodera/pagos/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url12);
 } else {
    $url12='';
 }

// cambio el estatus de la factura
$sql12 = "UPDATE facturasdatosxml SET estatus=4 where idFacturas=".$arrayDatos['idFactura']."";
$crea2=mysqli_query($con, $sql12);

// agrego los archivos a la base de datos
$insertarNota="INSERT INTO pagosfacturas (idFactura, archivo, folioPago, fechaSubePago, idSubePago, estatus) VALUES (".$arrayDatos['idFactura'].",'".$url12."', '".$arrayDatos['referenciaPago']."', '".$hoy."', ".$idUsuario.", 1)";
mysqli_query($con,$insertarNota);

// cambio el estatus de la factura en el gruposfactura
$sql122 = "UPDATE gruposfacturas SET estatus=9 where idGrupoFactura=".$arrayDatos['idGruposFacturas']."";
mysqli_query($con, $sql122);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "responderPagoProveedor?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
             window.location="responderPagoProveedor?do=1";
        </script>
        <?php }
}




function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('responderOrdenPago2', $_POST)) {
                $datos_getpost['responderOrdenPago2'] = $_POST['responderOrdenPago2'];
            }
            if (array_key_exists('beneficiario', $_POST)) {
                $datos_getpost['beneficiario'] = $_POST['beneficiario'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('folioServicio', $_POST)) {
                $datos_getpost['folioServicio'] = $_POST['folioServicio'];
            }
            if (array_key_exists('referenciaPago', $_POST)) {
                $datos_getpost['referenciaPago'] = $_POST['referenciaPago'];
            }
            if (array_key_exists('idFactura', $_POST)) {
                $datos_getpost['idFactura'] = $_POST['idFactura'];
            } 
            if (array_key_exists('idGruposFacturas', $_POST)) {
                $datos_getpost['idGruposFacturas'] = $_POST['idGruposFacturas'];
            }  

        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>