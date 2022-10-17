<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class respondeOrdenPago_class {

function accionesOrdenPago() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('responderOrdenPago', $datosCmb)) {
         $resp= $this->responderOrdenPago();
    }
}

// funcion para actualizar los datos de cotizacion
function responderOrdenPago() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
// OBTENGO EL NOMBRE DEL USUARIO
$queryUsuario="SELECT * FROM usuarios where idUsuario=$idUsuario";
$res=mysqli_query($con, $queryUsuario);
$extraidoUsuario=mysqli_fetch_array($res);
$nombreUsuario=$extraidoUsuario['usuario'];
$hoy=date('Y-m-d H:i:s');
print_r($_POST);
$idCotizacion=$arrayDatos['idCotizacion'];
$idServicio1=$arrayDatos['idServicio1'];
$folioServicio=$arrayDatos['folioServicio'];
$tipoPago=$arrayDatos['tipoPago'];


function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);


  //subo y creo el campo archivoXML
$archivo1 = $_FILES['archivo1'];
$nombreArchivo1=$folioServicio.'-factura-'.$codigoP;
$codigo1=$archivo1['name'];
$url121 ='documentosempodera/facturas/'.$archivo1['name'];
$extension1 = end(explode(".", $_FILES['archivo1']['name']));
if ($extension1!='') {
$url121 ='documentosempodera/facturas/'.$nombreArchivo1.'.'.$extension1;
move_uploaded_file($archivo1['tmp_name'], $url121);
 } else {
    $url121='';
 }


$xml = simplexml_load_file($url121); 
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);

foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){ 
$datosComprobante = $cfdiComprobante;
}

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor){ 
$datosEmisor = $Emisor;
} 

foreach ($xml->xpath('//cfdi:Conceptos//cfdi:Concepto') as $Conceptos){ 
$datosConceptos = $Conceptos;
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
$datosTraslados= $Traslado;
} 

foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){ 
$datosReceptor = $Receptor;
} 

foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
$datosTimbreFiscal= $tfd;
} 

//subo y creo el campo archivoPDF
$archivo = $_FILES['archivo'];
$nombreArchivo=$folioServicio.'-factura-'.$codigoP;
$codigo=$archivo['name'];
$url12 ='documentosempodera/facturas/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url12 ='documentosempodera/facturas/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url12);
 } else {
    $url12='';
 }


            $number = count($_POST["idServicio"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idServicio"][$i]!= ''))
            {   

                      // agrego los archivos a la base de datos
                      $insertarNota="INSERT INTO facturasservicios (idServicio, archivoXml, archivoPdf, tipoFactura,fechaSubeFactura, estatus) VALUES (".$_POST["idServicio"][$i].",'".$url121."','".$url12."', '".$arrayDatos['tipoPago']."', '".$hoy."',1)";
                       mysqli_query($con,$insertarNota);

                       //agrego la nota automatica para la carga de factura
                       $insertarNota2="INSERT INTO notasautomaticas (idServicio,nota,fechaAlta,estatus) VALUES (".$_POST["idServicio"][$i].",'SE ENVIA FACTURA A CLIENTE POR ".$nombreUsuario."','".$hoy."',1)";
                       mysqli_query($con,$insertarNota2);

                       // inserto los datos en la base de datos
                        echo $insertoDatosXML="INSERT INTO facturasdatosxml (idServicio, montoAplicado, UUID, Total, Subtotal, impuesto, Folio, FechaFactura, metodoPago, formaPago, moneda, rfcEmisor, rfcReceptor, nombreEmisor, fechaTimbrado, ArchivoXML, archivoPDF, Concepto, idUsuarioSubeFactura, estatus) 
                        VALUES 
                        (".$_POST["idServicio"][$i].", '".$_POST["montoFacturado"][$i]."', '".$datosTimbreFiscal['UUID']."', '".$datosComprobante['Total']."', '".$datosComprobante['SubTotal']."', '".$datosTraslados['Importe']."', '".$datosComprobante['Folio']."', '".$datosComprobante['Fecha']."', '".$datosComprobante['MetodoPago']."', '".$datosComprobante['FormaPago']."', '".$datosComprobante['Moneda']."', '".$datosEmisor['Rfc']."', '".$datosReceptor['Rfc']."', '".$datosEmisor['Nombre']."', '".$datosTimbreFiscal['FechaTimbrado']."', '".$url121."', '".$url12."', '".$datosConceptos['Descripcion']."', ".$idUsuario.", 1)";
                        $crea=mysqli_query($con,$insertoDatosXML); 
         
            }
            }
            }

// consulto no existan ya los impuestos
$queryImp="SELECT * from facturasdatosxmlimpuestos where UUID='".$datosTimbreFiscal['UUID']."'";            
$res=mysqli_query($con,$queryImp);
$filas=mysqli_num_rows($res);
if ($filas==0) {
// agrego los impuestos
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Traslado){ 
if ($Traslado['Base']!=''){                                
$insertoDatosXML2="INSERT INTO facturasdatosxmlimpuestos (UUID, impuesto, tasa, importe, estatus) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$Traslado['Impuesto']."', '".$Traslado['TasaOCuota']."', '".$Traslado['Importe']."', 1)";
mysqli_query($con,$insertoDatosXML2);
}
}
}

// consulto no existan ya las retenciones
$queryImp="SELECT * from facturasdatosxmlretenciones where UUID='".$datosTimbreFiscal['UUID']."'";            
$res=mysqli_query($con,$queryImp);
$filas=mysqli_num_rows($res);
if ($filas==0) {
//a grego las retenciones
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $Retencion){ 
if ($Retencion['TasaOCuota']!=''){                                
$insertoDatosXML2="INSERT INTO facturasdatosxmlretenciones (UUID, impuesto, tasa, importe, estatus) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$Retencion['Impuesto']."', '".$Retencion['TasaOCuota']."', '".$Retencion['Importe']."', 1)";
mysqli_query($con,$insertoDatosXML2);
}
}
}       




        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "responderOrdenesDePago?do=2&idServicio=<?php echo $idServicio1 ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="responderOrdenesDePago?do=1&idServicio=<?php echo $idServicio1 ?>";
        </script>
        <?php }
}




function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('responderOrdenPago', $_POST)) {
                $datos_getpost['responderOrdenPago'] = $_POST['responderOrdenPago'];
            }
            if (array_key_exists('beneficiario', $_POST)) {
                $datos_getpost['beneficiario'] = $_POST['beneficiario'];
            }
            if (array_key_exists('idServicio1', $_POST)) {
                $datos_getpost['idServicio1'] = $_POST['idServicio1'];
            }
            if (array_key_exists('folioServicio', $_POST)) {
                $datos_getpost['folioServicio'] = $_POST['folioServicio'];
            }
            if (array_key_exists('tipoPago', $_POST)) {
                $datos_getpost['tipoPago'] = $_POST['tipoPago'];
            }         
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>