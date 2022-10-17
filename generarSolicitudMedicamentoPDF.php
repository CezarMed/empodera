<?php
error_reporting(0);
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();

$idSolicitudMedicamentos=$_GET['idSolicitudMedicamentos'];
$idProveedor=$_GET['idProveedor'];
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');

// obtengo los datos de la solicitud
$query = "SELECT * from solicitudmedicamentos where idSolicitudMedicamentos=$idSolicitudMedicamentos";
$res = mysqli_query($con,$query);
$extraido= mysqli_fetch_array($res);
$idBeneficiario=$extraido['idBeneficiario'];
$folioSolicitud=$extraido['folioSolicitud'];
$calle=$extraido['calle'];
$noExteriorInterior=$extraido['noExteriorInterior'];
$telefonoBeneficiario=$extraido['telefonoBeneficiario'];
$colonia=$extraido['colonia'];
$codigoPostal=$extraido['codigoPostal'];
$referencias=$extraido['referencias'];
$entidadFederativa=$extraido['entidadFederativa'];
$municipioDelegacion=$extraido['municipioDelegacion'];

// obtengo el nombre del proveedor
$query2 = "SELECT * from registros where idRegistro=$idProveedor";
$res2 = mysqli_query($con,$query2);
$extraido2= mysqli_fetch_array($res2);
$nombreComercial=$extraido2['nombreComercial'];

// obtengo el nombre del beneficiario
$query3 = "SELECT * from beneficiarios where idBenefeciario=$idBeneficiario";
$res3 = mysqli_query($con,$query3);
$extraido3= mysqli_fetch_array($res3);
$nombreBeneficiario=$extraido3['nombreBeneficiario'];

//obtengo el estado de envio de medicamentos
$queryEstados = "SELECT clave, nombreEstado from estados where idEstado=$entidadFederativa";
$resEstados = mysqli_query($con,$queryEstados);
$estadosResult= mysqli_fetch_array($resEstados);
$nombreEstado=$estadosResult['nombreEstado'];

//obtengo el municipio
$queryMunicipios = "SELECT clave, nombre from municipios where id=$municipioDelegacion";
$resMunicipios = mysqli_query($con,$queryMunicipios);
$municipiosResult= mysqli_fetch_array($resMunicipios);
$nombreMunicipio=$municipiosResult['nombre'];

$query3 = "SELECT * from solicitudcotizaciones where idProveedor=$idProveedor and idSolicitudMedicamentos=$idSolicitudMedicamentos";
$res3 = mysqli_query($con,$query3);
$extraido3= mysqli_fetch_array($res3);
$idCotizacion=$extraido3['idCotizacion'];

$QRDATOS="http://sysadmin.empoderasalud.mx/generarSolicitudMedicamentoPDF?editarSolicitudMedicamentos=";
$QRDATOS.=$idSolicitudMedicamentos.'&idProveedor=';
$QRDATOS.=$idProveedor;

$html="";
$html.="<style type='text/css'>
    body {
    margin: 0;
    padding: 0;
    background-color: #fff;
    font: 12pt 'Calibri';
    color: rgb(0, 0, 0);
    font-size: 12px;
    }
</style>";
$html.="
<img src='http://sysadmin.empoderasalud.mx/logo_empodera.png' width='179px' height='110px'><hr>
<br><b>".$nombreComercial."<br>
PRESENTE,<br><br></b>
Reciba un cordial saludo, envío para cotización:</b>
<br><b>".$nombreBeneficiario."</b>
<br><b>".$folioSolicitud."</b><br><br>
<b>DOMICILIO DE ENTREGA:</b> ".$calle." ".$noExteriorInterior.", ".$colonia.", ".strtoupper($nombreEstado).", ".strtoupper($nombreMunicipio).", ".$codigoPostal."<br> 
REFERENCIAS: ".$referencias."<br><br>

<table width='600px' border='1'>
    <tr>
        <td align='center' style='background-color:#336BFF'>
            <font color='white'>MEDICAMENTO</font>
        </td>
        <td align='center' style='background-color:#336BFF'>
            <font color='white'>GRAMAJE</font>
        </td>
        <td align='center' style='background-color:#336BFF'>
            <font color='white'>PRESENTACION</font>
        </td>
        <td align='center' style='background-color:#336BFF'>
            <font color='white'>CANTIDAD</font>
        </td>
    </tr>
";
// genero la lista de medicamentos solicitados
$query4 = "SELECT * from medicamentossolicitados where idSolicitudMedicamento=$idSolicitudMedicamentos";
$res4 = mysqli_query($con,$query4);
while ($registros=mysqli_fetch_array($res4)) {
$html.="<tr>
        <td>".$registros['medicamento']."</td>
        <td>".$registros['gramaje']."</td>
        <td>".$registros['presentacion']."</td>
        <td>".$registros['cantidad']."</td>
    </tr>";
}
$html.="</table><br><br>
Quedamos pendientes a la cotización.<br><br><br>
<center><b><font color='#336BFF'>FIRMA</font></b>
<br><br>
<img src='http://chart.googleapis.com/chart?chs=130x130&cht=qr&chl=".$QRDATOS."'><br>
Torre Reforma 180, Piso 14,<br>
 Col. Juárez, 06600, CDMX<br>
5541240309 / contacto@empoderasalud.mx</center>

";

// echo $html;

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
$dompdf->stream("minuta_".$nombreComercial.".pdf", ["Attachment" => false]);

?>