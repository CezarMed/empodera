
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

    $query = "SELECT * from servicioscerradosproveedor scp
    INNER JOIN beneficiarios b on b.idBenefeciario=scp.idBeneficiario
    INNER JOIN registros r on r.idRegistro=scp.proveedorname
    INNER JOIN servicios s on s.idServicio=scp.idServicio
    INNER JOIN estados e on e.idEstado=r.entidadFederativa
    where scp.idServicio=$idServicio and r.idRegistro=$idProveedor";
    $res = mysqli_query($con,$query);
    $extraido= mysqli_fetch_array($res);
    $idCliente=$extraido['idCliente'];
    $folioEmpodera=$extraido['folioEmpodera'];
    $folioCierre=$extraido['folioCierre'];
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
    $contenidoonota=$extraido['contenidonota'];
    $tipoPrograma=$extraido['tipoPrograma'];
    $fechaAlta=$extraido['fechaAlta'];
    $fechaRespuesta=$extraido['fechaAsignacion'];
    $fechaEleccion=$extraido['fechaServicio'];
    $res2 = mysqli_query($con,$query);

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
 
<img src='http://sysadmin.empoderasalud.mx/logo_empodera.png' width='179px' height='110px'><hr>
<center><font size='14'>CARTA FINAL GARANTIA DE PAGO</font></center><br>

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
        <td colspan='3'>Estao</td>
        <td colspan='2'>Municipio / Delegación</td>
    </tr>

</table>";

$html.="
    <br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779'><font color='white'><b>GASTOS HOSPITALARIOS</b></font></td>
    </tr>
    ";
    $querynotas="SELECT * from gastosmedicos gm 
    where gm.estatus=1 and gm.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    while ($extraidonotas= mysqli_fetch_array($resnotas)) {
        $totalGastosHospitalarios=$extraidonotas['monto'];
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

    $html.="   
    <tr>
        <td colspan='3'><b>TOTAL DE GASTOS HOSPITALARIOS</b></td>
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
    if ($extraidonotas['costonota']!='0'){    
    $html.="
    <tr>
        <td colspan='3'>".$extraidonotas['nombredr']." (".$extraidonotas['especialidad'].")</td>
        <td colspan='2'  align='center'>$".$extraidonotas['costonota']."</td>
    </tr>";
    } }

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
    $extraidonotas=mysqli_fetch_array($resnotas);
    $totalmedicos=$extraidonotas['totalmedico'];

    // total consultas
    $querynotas="SELECT sum(monto) as toalconsultas from montosconsultas mc
    where mc.estatus=1 and mc.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    $extraidonotas=mysqli_fetch_array($resnotas);
    $toalconsultas=$extraidonotas['toalconsultas'];
    

    $querynotas2="SELECT * from notaspreoperatorias nm 
    where nm.estatus=1 and nm.idServicio=$idServicio";
    $resnotas2 = mysqli_query($con,$querynotas2);
    while ($extraidonotas2= mysqli_fetch_array($resnotas2)) {
    if ($extraidonotas2['cptAsignado']!=''){
    $html.="
    <tr>
        <td colspan='3'>".$extraidonotas2['cptAsignado']."</td>
    </tr>";
    }
    if ($extraidonotas2['cirujano']!=0){
    $html.="
    <tr>
        <td colspan='3'>".$extraidonotas2['nombrecirujano']." - CIRUJANO</td>
        <td colspan='2'  align='center'>$".$extraidonotas2['cirujano']."</td>
    </tr>";
    }
    if ($extraidonotas2['anestesiologo']!=0){
    $html.="<tr>
        <td colspan='3'>".$extraidonotas2['nombreanestesiologo']." - ANESTESIOLOGO</td>
        <td colspan='2'  align='center'>$".$extraidonotas2['anestesiologo']."</td>
    </tr>";
    }
    if ($extraidonotas2['ayudante']!=0){
    $html.="<tr>
        <td colspan='3'>".$extraidonotas2['nombreayudante']." - PRIMER AYUDANTE</td>
        <td colspan='2'  align='center'>$".$extraidonotas2['ayudante']."</td>
    </tr>";
    }
    if ($extraidonotas2['enfermeria']!=0){
    $html.="<tr>
        <td colspan='3'>".$extraidonotas2['nombreenfermeria']." - ENFERMERIA</td>
        <td colspan='2'  align='center'>$".$extraidonotas2['enfermeria']."</td>
    </tr>";
    }
    if ($extraidonotas2['ayudante2']!=0){
    $html.="<tr>
        <td colspan='3'>".$extraidonotas2['nombreayudante2']." - SEGUNDO AYUDANTE</td>
        <td colspan='2'  align='center'> $".$extraidonotas2['ayudante2']."</td>
    </tr>";
    }
    }
    $querytotalmed2="SELECT sum(cirujano+anestesiologo+ayudante+enfermeria+ayudante2) as totalhonorarios from notaspreoperatorias np  where idServicio=$idServicio and estatus=1";
    $restotalnotas2 = mysqli_query($con,$querytotalmed2);
    $extraidotot2= mysqli_fetch_array($restotalnotas2);
    $totalhonorarios=$extraidotot2['totalhonorarios'];
    $html.="
    <tr>
        <td colspan='3'><b>TOTAL DE HONORARIOS AUTORIZADOS</b></td>
        <td colspan='2' align='center'><b>$".number_format(($totalhonorarios+$totalmedicos+$toalconsultas), 2, '.', ',') ."</b></td>
    </tr></table>";

    // total de la contribucion
    $querycopago="SELECT sum(montoAsignado) totalContribucion
    from contribucionesasignadas ca 
    inner join archivoscontribucion ac on ac.idContribucion=ca.idCopago 
    where ca.estatus=1 and ca.idServicio=$idServicio and ac.tipocopago='Pagado'";
    $rescopago = mysqli_query($con,$querycopago);
    $extraidocopago= mysqli_fetch_array($rescopago);
    $totalContribucion=$extraidocopago['totalContribucion'];

    // total del copago
    $querycopago="SELECT sum(montoAsignado) totalCopago
    from copagosasignados ca 
    inner join archivoscopagos ac on ac.idCopago=ca.idCopago 
    where ca.estatus=1 and ca.idServicio=$idServicio and ac.tipocopago='Pagado'";
    $rescopago = mysqli_query($con,$querycopago);
    $extraidocopago= mysqli_fetch_array($rescopago);
    $totalcopago=$extraidocopago['totalCopago'];

    if ($totalcopago>='1' or $totalContribucion>='1') {
    $html.="
    <br><table class='bordered'>
    <tr>
    <td colspan='5' bgcolor='#06A779 '><font color='white'><b>CARGOS A CUENTA DEL BENEFICIARIO (COPAGO)</b></font></td>
    </tr>";
    if ($totalContribucion>='1') {
    $html.="<tr>
        <td colspan='3'>CONTRIBUCIÓN INICIAL</td>
        <td colspan='2'  align='center'><b>$".$totalContribucion."</b></td>
    </tr>";
    }
    if ($totalcopago>='1') {
    $html.="<tr>
        <td colspan='3'>COPAGO</td>
        <td colspan='2'  align='center'><b>$".$totalcopago."</b></td></tr>";
    $html.="</table>";
    }
    }
    
    //hago la suma de las notas
    $totalapagar=($totalmedicos+$totalhonorarios);
    $totabenpa=($totalgastosmedicos+$totalapagar+$toalconsultas)-$totalcopago-$totalContribucion;

    $querynotas="SELECT * from montosservicios ms 
    where ms.estatus=1 and ms.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    while ($extraidonotas= mysqli_fetch_array($resnotas)) {
    $html.="<tr>
        <td colspan='3' align='center'>".$extraidonotas['concepto']."</td>
        <td colspan='2' align='center'>$".$extraidonotas['monto']."</td>
    </tr>";
    }


  $html.="</table>    
    <br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779'><font color='white'><b>TOTAL MONTO AUTORIZADO</b></font></td>
    </tr>
    <tr>
        <td colspan='5' align='center'><b>$".number_format(($totalhonorarios+$totalmedicos+$toalconsultas+$totalGastosHospitalarios), 2, '.', ',') ."</b></td>
    </tr>
    </table>";

    $html.="
<br><table class='bordered'>
    <tr>
        <td colspan='3' align='center' bgcolor='#D0D6D5'><font size='20'>MONTO TOTAL POR FACTURAR</font></td>
        <td colspan='2' align='center' bgcolor='#D0D6D5'><font size='20'><b>$".number_format($totabenpa, 2, '.', ',')."</b></font></td>
    </tr>
    </table>";

$html.="
    <br><table class='bordered'>
    <tr>
        <td colspan='5' bgcolor='#06A779 '><font color='white'><b>COMENTARIOS DEL PROVEEDOR / SERVICIO</b></font></td>
    </tr>
    <tr>
        <td>".$contenidoonota."</td>
    </tr>"; 
    $html.="
    <tr>
        <td colspan='5' bgcolor='#06A779 '><font color='white'><b>OBSERVACIONES</b></font></td>
    </tr>
    <tr>";

    $querynotas="SELECT * from dictamenesgenerados nm 
    where nm.estatus=1 and nm.idServicio=$idServicio";
    $resnotas = mysqli_query($con,$querynotas);
    $extraidonotas= mysqli_fetch_array($resnotas);
    $notaDictamen=$extraidonotas['observaciones'];

        $html.="<td colspan='5'>".$notaDictamen."</td>
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