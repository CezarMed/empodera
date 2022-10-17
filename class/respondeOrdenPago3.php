<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class respondeOrdenPago3_class {

// funcion para actualizar los datos de cotizacion
function responderOrdenPago3() {
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

// agrego los archivos a la base de datos
 $insertarNota="UPDATE pagosfacturas set  archivo='".$url12."', folioPago='".$arrayDatos['referenciaPago']."' where idFactura=".$arrayDatos['idFactura']."";
$crea=mysqli_query($con,$insertarNota);


        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "pagadasGruposFacturasPagos?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="pagadasGruposFacturasPagos?do=1";
        </script>
        <?php }
}


function quitarPagoFactura() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$estatusFac=$arrayDatos['tipoCancel'];

// actualizo el pago de la factura
$insertarNota="UPDATE pagosfacturas set estatus=5 where idPagoFactura=".$arrayDatos['idPagosFacturas']."";
$crea=mysqli_query($con,$insertarNota);

// aactualizo el grupo facturas
$insertarNota="UPDATE gruposfacturas set estatus=$estatusFac where idGrupoFactura=".$arrayDatos['idGruposFacturas']."";
$crea=mysqli_query($con,$insertarNota);


        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "pagadasGruposFacturasPagos?do=22";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="pagadasGruposFacturasPagos?do=11";
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
            if (array_key_exists('idPagosFacturas', $_POST)) {
                $datos_getpost['idPagosFacturas'] = $_POST['idPagosFacturas'];
            }
            if (array_key_exists('tipoCancel', $_POST)) {
                $datos_getpost['tipoCancel'] = $_POST['tipoCancel'];
            } 
            

        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>