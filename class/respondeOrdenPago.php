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

function estatusFactura($datos){

        $emisor=$datos[0];
        $receptor=$datos[1];
        $total=$datos[2];
        $uuid=$datos[3];

        $soap = sprintf('<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/"><soapenv:Header/><soapenv:Body><tem:Consulta><tem:expresionImpresa>?re=%s&amp;rr=%s&amp;tt=%s&amp;id=%s</tem:expresionImpresa></tem:Consulta></soapenv:Body></soapenv:Envelope>', $emisor,$receptor,$total,$uuid);

        //encabezados
        $headers = [
        'Content-Type: text/xml;charset=utf-8',
        'SOAPAction: http://tempuri.org/IConsultaCFDIService/Consulta',
        'Content-length: '.strlen($soap)
        ];

        $url = 'https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soap);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($res);
        $data = $xml->children('s', true)->children('', true)->children('', true);
        $data = json_encode($data->children('a', true), JSON_UNESCAPED_UNICODE);
        return json_decode($data);
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
// print_r($_POST);

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
$nombreArchivo1='factura-'.$codigoP;
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
 
 
//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA 
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
$nombreArchivo='factura-'.$codigoP;
$codigo=$archivo['name'];
$url12 ='documentosempodera/facturas/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url12 ='documentosempodera/facturas/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url12);
 } else {
    $url12='';
 }

// valido que el uuid no exita ya en la base de datos
 $queryConsultaUUID="SELECT count(*) totalUUID FROM facturasdatosxml where UUID='".$datosTimbreFiscal['UUID']."' ";
 $res=mysqli_query($con,$queryConsultaUUID);
 $extraidoUUID=mysqli_fetch_array($res);
 $existeUUID=$extraidoUUID['totalUUID'];
 if ($existeUUID>=1) { ?>
<script type="text/javascript">
             window.location="responderOrdenPago?do=5&idServicio=<?php echo $idServicio1 ?>&UUID=<?php echo $datosTimbreFiscal['UUID'] ?>";
        </script>
 <?php 
exit;
}

//validamos que la factura esté disponible

            $datos=array();
            array_push($datos, $datosEmisor['Rfc'], $datosReceptor['Rfc'], $datosComprobante['Total'], $datosTimbreFiscal['UUID']);
            var_dump($datos[0]);
            var_dump($datos[1]);
            var_dump($datos[2]);
            var_dump($datos[3]);
            $estatus=$this->estatusFactura($datos);
            if($estatus->Estado!='Vigente'){
                 unlink($datosXML);
                ?>
               <script type="text/javascript">
            // window.location="responderOrdenPago?do=10&idServicio=<?php echo $idServicio1 ?>&UUID=<?php echo $datosTimbreFiscal['UUID'] ?>";
        </script>
                <?php
                // exit();
            }
            $estatus->Estatus;
            //Ternmina validacion de factura
// obtengo el tipo de servicio
            $idServicio=$_POST["idServicio"][0];
$queryservicio="SELECT * from servicios where idServicio=$idServicio";
$rest=mysqli_query($con,$queryservicio);
$registroservicios=mysqli_fetch_array($rest);
$tiposervicio=$registroservicios['servicio'];

if ($tiposervicio=='MEDICAMENTOS'){
    $grupo="FACPROMED";
} else {
    $grupo="FACPROGRAL";
}
// consulto los datos para saber cual es el siguiente id de grupo
$selectGrupo="SELECT * from facturasdatosxml where grupo='$grupo' ORDER BY idFacturas DESC LIMIT 1";
$resgrupo=mysqli_query($con,$selectGrupo);
$registrosfactura=mysqli_fetch_array($resgrupo);
$numeroGrupo=$registrosfactura['numeroGrupo'];
$idGrupoConsecutivo=$registrosfactura['idGrupoConsecutivo'];

if ($numeroGrupo==''){
    $numeroGrupo=1;
}

if ($idGrupoConsecutivo<=5){
    $idGrupoConsecutivo=$idGrupoConsecutivo+1;
}

if ($idGrupoConsecutivo==6){
    $idGrupoConsecutivo=1;
    $numeroGrupo=$numeroGrupo+1;
}


// inserto los datos en la base de datos
$insertoDatosXML="INSERT INTO facturasdatosxml (UUID, Total, Subtotal, Folio, FechaFactura, metodoPago, formaPago, moneda, rfcEmisor, regimenFiscal, cpEmisor, rfcReceptor, nombreEmisor, nombreReceptor, regimenFiscalReceptor, cpReceptor, UsoCFDI, fechaTimbrado, ArchivoXML, archivoPDF, idProveedor, idUsuarioSubeFactura, comentarios, tipoPagoFactura, fechaSubeFactura, grupo, numeroGrupo, estatus) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$datosComprobante['Total']."', '".$datosComprobante['SubTotal']."', '".$datosComprobante['Folio']."', '".$datosComprobante['Fecha']."', '".$datosComprobante['MetodoPago']."', '".$datosComprobante['FormaPago']."', '".$datosComprobante['Moneda']."', '".$datosEmisor['Rfc']."', '".$datosEmisor['RegimenFiscal']."', '".$datosComprobante['LugarExpedicion']."', '".$datosReceptor['Rfc']."', '".$datosEmisor['Nombre']."', '".$datosReceptor['Nombre']."', '".$datosReceptor['RegimenFiscalReceptor']."', '".$datosReceptor['DomicilioFiscalReceptor']."', '".$datosReceptor['UsoCFDI']."', '".$datosTimbreFiscal['FechaTimbrado']."', '".$url121."', '".$url12."', ".$arrayDatos['idRegistro'].", ".$idUsuario.", '".$arrayDatos['comentarios']."', '".$arrayDatos['tipoPago']."', '".$hoy."', '$grupo', $numeroGrupo, 10)";
$crea=mysqli_query($con,$insertoDatosXML);

// agrego los conceptos
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){ 
if ($Concepto['ObjetoImp']!=''){                                
$insertoDatosXML2="INSERT INTO facturasdatosxmlconceptos (UUID, ObjetoImp, ClaveProdServ, Cantidad, ClaveUnidad, Unidad, Descripcion, ValorUnitario, Importe) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$Concepto['ObjetoImp']."', '".$Concepto['ClaveProdServ']."', '".$Concepto['Cantidad']."', '".$Concepto['ClaveUnidad']."', '".$Concepto['Unidad']."', '".$Concepto['Descripcion']."',  '".$Concepto['ValorUnitario']."', '".$Concepto['Importe']."')";
mysqli_query($con,$insertoDatosXML2);
}
}

// agrego los impuestos
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $Impuestos){ 
if ($Impuestos['Base']!=''){                                
$insertoDatosXML2="INSERT INTO facturasdatosxmlimpuestos (UUID, impuesto, TipoFactor, tasa, importe, estatus) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$Impuestos['Impuesto']."', '".$Impuestos['TipoFactor']."', '".$Impuestos['TasaOCuota']."', '".$Impuestos['Importe']."', 1)";
mysqli_query($con,$insertoDatosXML2);
}
}

// agrego los impuestos totales
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $Impuestostotales){ 
if ($Impuestostotales['TotalImpuestosTrasladados']!=''){                                
$insertoDatosXML4="INSERT INTO facturasdatosxmlimpuestostotales (UUID, TotalImpuestosTrasladados, estatus) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$Impuestostotales['TotalImpuestosTrasladados']."', 1)";
mysqli_query($con,$insertoDatosXML4);
}
}

//a grego las retenciones
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $Retencion){ 
if ($Retencion['TasaOCuota']!=''){                                
$insertoDatosXML3="INSERT INTO facturasdatosxmlretenciones (UUID, impuesto, TipoFactor, tasa, importe, estatus) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$Retencion['Impuesto']."', '".$Retencion['TipoFactor']."', '".$Retencion['TasaOCuota']."', '".$Retencion['Importe']."', 1)";
mysqli_query($con,$insertoDatosXML3);
}
}

// agrego el total de impuestos retenidos
foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $Impuestostotalesretenidos){ 
if ($Impuestostotalesretenidos['TotalImpuestosRetenidos']!=''){                                
$insertoDatosXML4="INSERT INTO facturasdatosxmlretencionestotales (UUID, TotalImpuestosRetenidos, estatus) 
VALUES 
('".$datosTimbreFiscal['UUID']."', '".$Impuestostotalesretenidos['TotalImpuestosRetenidos']."', 1)";
mysqli_query($con,$insertoDatosXML4);
}
}

$queryIdFatura="SELECT * FROM facturasdatosxml where UUID='".$datosTimbreFiscal['UUID']."'";
$resultadoXML=mysqli_query($con, $queryIdFatura);
$extradioXML=mysqli_fetch_array($resultadoXML);
$idFactura=$extradioXML['idFacturas'];


$number = count($_POST["idServicio"]);
if($number >= 1)
{
  for($i=0; $i<$number; $i++)
    {
      if(trim($_POST["idServicio"][$i]!= ''))
        {
                // Insertamos la informacion enviada por el formulario
            $sqlInsert = "INSERT INTO serviciosfacturasproveedor (idServicio, idFactura, estatus) VALUES(".$_POST["idServicio"][$i].", ".$idFactura.", 1)";
            mysqli_query($con, $sqlInsert);

            // creo la nota automatica de pagos
                $insertarNota2="INSERT INTO notaspagos (idServicio,nota,fechaAlta,idUsuarioAgrega,estatus) VALUES (".$_POST["idServicio"][$i].",'".$arrayDatos['comentarios']."','".$hoy."','".$idUsuario."',1)";
                mysqli_query($con,$insertarNota2);

               
        }
    }
}



if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "responderOrdenPago?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="responderOrdenPago?do=1";
        </script>
<?php }
}


function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('responderOrdenPago', $_POST)) {
                $datos_getpost['responderOrdenPago'] = $_POST['responderOrdenPago'];
            }
            if (array_key_exists('idRegistro', $_POST)) {
                $datos_getpost['idRegistro'] = $_POST['idRegistro'];
            }
            if (array_key_exists('tipoPago', $_POST)) {
                $datos_getpost['tipoPago'] = $_POST['tipoPago'];
            }
            if (array_key_exists('comentarios', $_POST)) {
                $datos_getpost['comentarios'] = $_POST['comentarios'];
            }  

        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>