<?php
error_reporting(0);
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();
// print_r($_POST);
$idServicio=$_GET['idServicio'];
$idBeneficiario=$_GET['idBeneficiario'];
$idProveedor=$_GET['idProveedor'];
$servicioprincipal=$_GET['servicioprincipal'];  
    
if ($servicioprincipal==0){
    $query = "SELECT * from solicitudmedicamentos sm
    INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
    INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
    INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
    INNER JOIN medicamentossolicitados ms on ms.idMedicamento=scm.idProductoSolicitud
    INNER JOIN registros r on r.idRegistro=sc.idProveedor
    INNER JOIN servicios s on s.idServicio=sm.idServicio
    INNER JOIN servicioscerradosproveedor scp on scp.idServicio=s.idServicio
    INNER JOIN estados e on e.idEstado=r.entidadFederativa
    where sm.idServicio=$idServicio and sc.idProveedor=$idProveedor and scm.elegido=1";
} else {
    $query = "SELECT * from solicitudmedicamentos sm
    INNER JOIN beneficiarios b on b.idBenefeciario=sm.idBeneficiario 
    INNER JOIN solicitudcotizaciones sc on sc.idSolicitudMedicamentos=sm.idSolicitudMedicamentos
    INNER JOIN solicitudcotizacionesmedicamentos scm on scm.idCotizacion=sc.idCotizacion
    INNER JOIN medicamentossolicitados ms on ms.idMedicamento=scm.idProductoSolicitud
    INNER JOIN registros r on r.idRegistro=sc.idProveedor
    INNER JOIN servicios s on s.idServicio=sm.idServicio
    INNER JOIN servicioscerradosproveedor scp on scp.idServicio=s.idServicio
    INNER JOIN estados e on e.idEstado=r.entidadFederativa
    where sm.idServicio=$servicioprincipal and sc.idProveedor=$idProveedor and scm.elegido=1";
}
    $res = mysqli_query($con,$query);
    $res2 = mysqli_query($con,$query);
    $extraido= mysqli_fetch_array($res);
    $idCliente=$extraido['idCliente'];
    $idCotizacion=$extraido['idCotizacion'];
    $folioEmpodera=$extraido['folioEmpodera'];
    $nombreBeneficiario=$extraido['nombreBeneficiario'];
    $servicio=$extraido['servicio'];
    $fechaNac=$extraido['fechaNacimiento'];
    $sexo=$extraido['sexo'];
    list($anio, $mes, $dia) = explode("-", $fechaNac);
    $yearh=date('Y');
    $edad=$yearh-$anio;
    $nombreComercial=$extraido['nombreComercial'];
    $nombreLegal=$extraido['nombreLegal'];
    $RFC=$extraido['rfcCedula'];
    $nombreEstado=$extraido['nombreEstado'];
    $tipoPrograma=$extraido['tipoPrograma'];
    $fechaAlta=$extraido['fechaAlta'];
    $fechaRespuesta=$extraido['fechaRespuesta'];
    $fechaEleccion=$extraido['fechaEleccion'];
    $montoautorizado=$extraido['monto'];
    // obtengo el folio empodera del servicio
    if ($servicioprincipal!=0) {
    $queryfolio = "SELECT * from servicios
    where idServicio=$idServicio";
    $resCie = mysqli_query($con,$queryfolio);
    $extraidofolio= mysqli_fetch_array($resCie);
    $folioEmpodera=$extraidofolio['folioEmpodera'];
    $montoautorizado=$extraidofolio['monto'];    
    }

    // datos para el CIE
    $queryCie = "SELECT * from datoscie
    where idServicio=$idServicio";
    $resCie = mysqli_query($con,$queryCie);
    $extraidoCie= mysqli_fetch_array($resCie);
    $cie10=$extraidoCie['cie10'];
    $diagnosticocie10=$extraidoCie['diagnosticocie10'];

    // datos para el CPT
    $queryCie = "SELECT * from datoscpt
    where idServicio=$idServicio";
    $resCie = mysqli_query($con,$queryCie);
    $extraidoCie= mysqli_fetch_array($resCie);
    $tratamientocpt4=$extraidoCie['tratamientocpt4'];
    $cpt4=$extraidoCie['cpt4'];

    // datos para el folio del Servicio
    $queryCie = "SELECT * from servicioscerradosproveedor
    where idServicio=$idServicio";
    $resCie = mysqli_query($con,$queryCie);
    $extraidoCie= mysqli_fetch_array($resCie);
    $folioCierre=$extraidoCie['folioCierre'];

    // datos de facturacion del cliente
    $queryFac = "SELECT * from beneficiarios b
    INNER JOIN beneficiarioscuentas bc on bc.idBeneficiario=b.idBenefeciario
    inner join datosfacturacioncliente dfc on dfc.idDatosFacturacion=bc.idPrograma
    where b.idBenefeciario=$idBeneficiario";
    $resFac = mysqli_query($con,$queryFac);
    $extraidoFac= mysqli_fetch_array($resFac);
    $razonSocial=$extraidoFac['razonSocial'];
    $rfcCliente=$extraidoFac['rfc'];
    $direccionCliente=$extraidoFac['direccion'];
    $cpCliente=$extraidoFac['cp'];
    $entidadFederativaC=$extraidoFac['entidadFederativa'];
    $municipioDelegacionC=$extraidoFac['municipioDelegacion'];

    //obtengo el estao del cliente para datos de factura
    $queryCie = "SELECT * from estados
    where idEstado=$entidadFederativaC";
    $resCie = mysqli_query($con,$queryCie);
    $extraidoCie= mysqli_fetch_array($resCie);
    $entidadFederativaCliente=$extraidoCie['nombreEstado'];
    //obtengo el municipio del cliente para datos de factura
    $queryCie = "SELECT * from municipios
    where id=$municipioDelegacionC";
    $resCie = mysqli_query($con,$queryCie);
    $extraidoCie= mysqli_fetch_array($resCie);
    $municipioDelegacionCliente=$extraidoCie['nombre'];



$QRDATOS=$idServicio.'/';
$QRDATOS.=$idBeneficiario.'/';
$QRDATOS.=$idProveedor.'/';

$html="";
$html.="<style type='text/css'>
    body {
    margin: 0;
    padding: 0;
    background-color: #fff;
    font: 8pt 'Arial';
    color: rgb(0, 0, 0);
    font-size: 8px;
    }
    table {
border-spacing: 0;
width: 750px;
}
.bordered {
border: solid #ccc 1px;
-moz-border-radius: 0px;
-webkit-border-radius: 0px;
border-radius: 0px;
-webkit-box-shadow: 0 3px 3px #ccc;
-moz-box-shadow: 0 3px 3px #ccc;
box-shadow: 0 3px 3px #ccc;
}
#watermark {
                position: fixed;

                /** 
                    Establece una posición en la página para tu imagen
                    Esto debería centrarlo verticalmente
                **/
                bottom:   10cm;
                left:     5.5cm;

                /** Cambiar las dimensiones de la imagen **/
                width:    8cm;
                height:   8cm;

                /** Tu marca de agua debe estar detrás de cada contenido **/
                z-index:  -1000;
            }
</style>";
$html.="
<div id='watermark'>
<img src='http://sysadmin.empoderasalud.mx/sello.png' width='100%' height='100%'>
 </div>

<img src='http://sysadmin.empoderasalud.mx/logo_empodera.png' width='179px' height='110px'><hr>
<center><font size='14'>CARTA PRELIMINAR DE GARANTIA DE PAGO</font></center><br>
<table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779'><font color='white'><b>DATOS DE LA AUTORIZACIÓN</b></font></td>
    </tr>
    <tr align='center'>
        <td><b>".$folioEmpodera."</td>
        <td><b>".$folioCierre."</td>
        <td><b>".$folioEmpodera."</td>
        <td><b>".$nombreEstado."</b></td>
        <td><b>".$tipoPrograma."</b></td>
    </tr>
    <tr align='center'>
        <td colspan='2'>Siniestro</td>
        <td>Número de evento</td>
        <td>Ciudad de Atención</td>
        <td>Tipo de programa</td>
    </tr>
    <tr>
        <td colspan='5'  bgcolor='#06A779 '><font color='white'><b>DATOS DEL BENEFICIARIO</b></font></td>
    </tr>
    <tr>
        <td colspan='2'><b>".$nombreBeneficiario."</b></td>
        <td align='center'><b>".$fechaNac."</b></td>
        <td align='center'><b>".$edad."</b></td>
        <td align='center'><b>".$sexo."</b></td>
    </tr>
    <tr>
        <td colspan='2'>Nombre del paciente</td>
        <td align='center'>Fecha. Nac.</td>
        <td align='center'>Edad</td>
        <td align='center'>Sexo</td>
    </tr>
    <tr>
        <td colspan='5'  bgcolor='#06A779 '><font color='white'><b>INFORMACIÓN MÉDICA</b></font></td>
    </tr>
    <tr>
        <td colspan='4'><b>Diagnóstico</b></td>
        <td align='center'><b>ICD</b></td>
    </tr>
    <tr>
        <td colspan='4'>".$diagnosticocie10."</td>
        <td align='center'>".$cie10."</td>
    </tr>
    <tr>
        <td colspan='5'><font color='white'>.</font></td>
    </tr>

    <tr>
        <td colspan='4'><b>Tratamiento médico o procedimiento</b></td>
        <td align='center'><b>CPT</b></td>
    </tr>
    <tr>
        <td colspan='4'>".$tratamientocpt4."</td>
        <td align='center'>".$cpt4."</td>
    </tr>
    <tr>
        <td colspan='5'  bgcolor='#06A779 '><font color='white'><b>DATOS DEL PROVEEDOR</b></font></td>
    </tr>
    <tr>
        <td colspan='4'><b>".$nombreComercial."</b></td>
        <td align='center'><b>N/A</b></td>
    </tr>
    <tr>
        <td colspan='4'>Prestador del Servicio</td>
        <td align='center'>Habitación</td>
    </tr>
    <tr>
        <td colspan='3'><b>".$nombreLegal."</b></td>
        <td colspan='2'><b>".$RFC."</b></td>
    </tr>
    <tr>
        <td colspan='3'>Nombre de Razón social</td>
        <td colspan='2'>RFC Prestador (Hospital o servicio auxiliar)</td>
    </tr>
    <tr>
        <td colspan='5'>Tipo de servicio: <b>".$servicio."</b> </td>

    </tr>
    <tr align='center'>
        <td><b>".$fechaAlta."</b></td>
        <td><b>".$fechaRespuesta."</b></td>
        <td><b>".$fechaEleccion."</b></td>
        <td colspan='2'><b>30 días a partir de su emisión</b></td>
    </tr>
        <tr align='center'>
        <td>Ingreso</td>
        <td>Egreso</td>
        <td>Ocurrido</td>
        <td colspan='2'>Vigencia de la carta</td>
    </tr>

    <tr>
        <td colspan='5'  bgcolor='#06A779 '><font color='white'><b>DATOS DEL CLIENTE PARA EMITIR FACTURA</b></font></td>
    </tr>
    <tr>
        <td colspan='3'><b>".$razonSocial."</b></td>
        <td colspan='2'><b>".$rfcCliente."</b></td>
    </tr>
    <tr>
        <td colspan='3'>Razón social</td>
        <td colspan='2'>RFC</td>
    </tr>
    <tr>
        <td colspan='3'><b>".$direccionCliente."</b></td>
        <td colspan='2'><b>".$cpCliente."</b></td>
    </tr>
    <tr>
        <td colspan='3'>Dirección</td>
        <td colspan='2'>Código Postal</td>
    </tr>
    <tr>
        <td colspan='3'><b>".$entidadFederativaCliente."</b></td>
        <td colspan='2'><b>".$municipioDelegacionCliente."</b></td>
    </tr>
    <tr>
        <td colspan='3'>Estado</td>
        <td colspan='2'>Municipio / Delegación</td>
    </tr>

</table>";


$html.="<br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779 '><font color='white'><b>TOTAL MONTO AUTORIZADO</b></font></td>
    </tr>
    <tr>
        <td colspan='5' align='center'><b>$".number_format($montoautorizado, 2, '.', ',')."</b></td>
    </tr>
    </table>
    <br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779 '><font color='white'><b>GASTOS MEDICOS</b></font></td>
    </tr>
    ";
   $querynotas="SELECT * from gastosmedicos gm 
    where gm.estatus=1 and gm.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    while ($extraidonotas= mysqli_fetch_array($resnotas)) {
    $html.="
    <tr>
        <td colspan='3'>".$extraidonotas['nombredr']." (".$extraidonotas['concepto'].")</td>
        <td colspan='2'  align='center'>$".$extraidonotas['monto']."</td>
    </tr>";
    }
    $querynotas="SELECT sum(monto) as totalmedico from gastosmedicos nm 
    where nm.estatus=1 and nm.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    $extraidonotas= mysqli_fetch_array($resnotas);
    $totalgastosmedicos=$extraidonotas['totalmedico'];
    ;
    $html.="   
    <tr>
        <td colspan='3'><b>TOTAL DE GASTOS MEDICOS</b></td>
        <td colspan='2' align='center'><b>$".number_format($totalgastosmedicos, 2, '.', ',')."</b></td>
    </tr";
    $html.="</table>
    <br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779'><font color='white'><b>HONORARIOS MEDICOS</b></font></td>
    </tr>
    ";
    $querynotas="SELECT * from notasmedicas nm 
    where nm.estatus=1 and nm.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    while ($extraidonotas= mysqli_fetch_array($resnotas)) {
     $html.="
    <tr>
        <td colspan='3'>".$extraidonotas['nombredr']." (".$extraidonotas['especialidad'].")</td>
        <td colspan='2'  align='center'>$".number_format($extraidonotas['costonota'], 2, '.', ',')."</td>
    </tr>";
    }

    $queryconsultas="SELECT * from montosconsultas mc
    inner join datosconsultas dc on dc.idConsulta=mc.idConsulta 
    where mc.estatus=1 and mc.idServicio=$idServicio";
    $resconsultas = mysqli_query($con,$queryconsultas);
    while ($extraidoconsultas= mysqli_fetch_array($resconsultas)) {
    if ($extraidoconsultas['monto']!='0'){    
    $html.="
    <tr>
        <td colspan='3'>".$extraidoconsultas['consultacpt4']." (".$extraidoconsultas['medico'].")</td>
        <td colspan='2'  align='center'>$".$extraidoconsultas['monto']."</td>
    </tr>";
    } }

    $querynotas="SELECT sum(costonota) as totalmedico from notasmedicas nm 
    where nm.estatus=1 and nm.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    $extraidonotas= mysqli_fetch_array($resnotas);
    $totalmedicos=$extraidonotas['totalmedico'];

    // total consultas
    $querynotas="SELECT sum(monto) as toalconsultas from montosconsultas mc
    where mc.estatus=1 and mc.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    $extraidonotas=mysqli_fetch_array($resnotas);
    $toalconsultas=$extraidonotas['toalconsultas'];

    $querynotas="SELECT * from notaspreoperatorias nm 
    where nm.estatus=1 and nm.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    while ($extraidonotas= mysqli_fetch_array($resnotas)) {
    $html.="
    <tr>
        <td colspan='3'>".$extraidonotas['nombredr']." (CIRUJANO)</td>
        <td colspan='2'  align='center'>$".number_format($extraidonotas['cirujano'], 2, '.', ',')."</td>
    </tr>
    <tr>
        <td colspan='3'>ANESTESIOLOGO</td>
        <td colspan='2'  align='center'>$".number_format($extraidonotas['anestesiologo'], 2, '.', ',')."</td>
    </tr>
    <tr>
        <td colspan='3'>PRIMER AYUDANTE</td>
        <td colspan='2'  align='center'>$".number_format($extraidonotas['ayudante'], 2, '.', ',')."</td>
    </tr>";
    }
    $querytotalmed2="SELECT sum(cirujano+anestesiologo+ayudante) as totalhonorarios from notaspreoperatorias np  where idServicio=$idServicio and estatus=1";
    $restotalnotas2 = mysqli_query($con,$querytotalmed2);
    $extraidotot2= mysqli_fetch_array($restotalnotas2);
    $totalhonorarios=$extraidotot2['totalhonorarios'];
    $html.="
    <tr>
        <td colspan='3'><b>TOTAL DE HONORARIOS AUTORIZADO</b></td>
        <td colspan='2'  align='center'><b>$".number_format(($totalhonorarios+$totalmedicos+$toalconsultas), 2, '.', ',')."</b></td>
    </tr>";
   
    $html.="></table>";

    
    $html.="
    <br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779 '><font color='white'><b>PROGRAMACIÓN DE MEDICAMENTOS / ESTUDIOS</b></font></td>
    </tr>
    <tr>
        <td>Nombre del medicamento</td>
        <td align='center'>Gramaje</td>
        <td align='center'>Presentación</td>
        <td align='center'>Cantidad</td>
        <td align='center'>Total</td>
    </tr>";
    $total=0;
    while ($extraido2= mysqli_fetch_array($res2)) {
            $total=$total+$extraido2['costototal'];
        $html.="
    <tr>
        <td>".$extraido2['medicamento']."</td>
        <td align='center'>".$extraido2['gramaje']."</td>
        <td align='center'>".$extraido2['presentacion']."</td>
        <td align='center'>".$extraido2['cantidad']."</td>
        <td align='center'>$".number_format($extraido2['costototal'], 2, '.', ',')."</td>
    </tr>";
    }
    $html.="
    <tr>
        <td colspan='4'>COSTO TOTAL DE MEDICAMENTOS</td>
        <td align='center'><B>$".number_format($total, 2, '.', ',')."</B></td>
    </tr></table>";
    $totalapagar=($totalgastosmedicos+$totalmedicos+$totalhonorarios+$toalconsultas+$total);



    $html.="
    <br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779 '><font color='white'><b>CARGOS A CUENTA DEL BENEFICIARIO</b></font></td>
    </tr>";
    $querynotas="SELECT sum(monto) totalmonto from montosservicios ms 
    where ms.estatus=1 and ms.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    $extraidonotas= mysqli_fetch_array($resnotas);
    $totalben=$extraidonotas['totalmonto'];
    $totabenpa=$totalapagar-$totalben;

    $querynotas="SELECT * from montosservicios ms 
    where ms.estatus=1 and ms.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    while ($extraidonotas= mysqli_fetch_array($resnotas)) {
        
    $html.="<tr>
        <td colspan='3' align='center'>".$extraidonotas['concepto']."</td>
        <td colspan='2' align='center'><b>$".$extraidonotas['monto']."</b></td>
    </tr>";
    }
    $html.="
    </table>";

        $html.="
        <br><table class='bordered'><tr>
    <td colspan='3' align='center' bgcolor='#D0D6D5'><font size='20'>MONTO TOTAL POR FACTURAR</font></td>
        <td colspan='2' align='center' bgcolor='#D0D6D5'><font size='20'><b>$".number_format($totabenpa, 2, '.', ',')."</b></font></td></tr></table>";
    $html.="
<br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779 '><font color='white'><b>OBSERVACIONES</b></font></td>
    </tr>
    <tr>";
    $queryob="SELECT * from serviciosobservaciones so 
    where so.estatus=1 and so.idServicio=$idServicio";
   $resob = mysqli_query($con,$queryob);
    $extraidoob= mysqli_fetch_array($resob);

        $html.="<td colspan='5'>".$extraidoob['observaciones']."</td>
    </tr></table>";

$html.="<br>
<center>
<img src='http://chart.googleapis.com/chart?chs=130x130&cht=qr&chl=".$QRDATOS."'><br>
Torre Reforma 180, Piso 14,<br>
 Col. Juárez, 06600, CDMX<br>
5541240309 / contacto@empoderasalud.mx</center>

";

// echo $html;

// Jalamos las librerias de dompdf

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
// Inicializamos dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
// Colocamos als propiedades de la hoja
$dompdf->setPaper("letter", "portrait");
// Le pasamos el html a dompdf
$dompdf->loadHtml($html, 'UTF-8');
// Escribimos el html en el PDF
$dompdf->render();
// Ponemos el PDF en el browser;
$dompdf->stream("cartaServicioDemo".$folioEmpodera.".pdf", ["Attachment" => false]);

?>