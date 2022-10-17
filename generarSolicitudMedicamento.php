<?php 
header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=cotizacionEmpodera.doc");
header("Pragma: no-cache");
header("Expires: 0"); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>contenido</title>
    <meta charset="UTF-8">
    <style type='text/css'>
    body {
    margin: 0;
    padding: 0;
    background-color: #fff;
    font: 12pt 'Calibri';
    color: rgb(0, 0, 0);
    font-size: 12px;
    }
</style>
</head>
<body>
<?php
error_reporting(0);
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();
//recibo los datos por POST
$idSolicitudMedicamentos=$_GET['idSolicitudMedicamentos'];
$idProveedor=$_GET['idProveedor'];

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

$QRDATOS=$nombreBeneficiario.'/';
$QRDATOS.=$nombreComercial.'/';

?>
<!-- INICIA CONTENIDO DEL CONTRATO -->
<img src='http://sysadmin.empoderasalud.mx/logo_empodera2.png'><hr>
<b><?php echo $nombreComercial; ?><br>
PRESENTE,<br><br></b>
Reciba un cordial saludo, envío para cotización:</b><br>
<br><b><?php echo $nombreBeneficiario; ?></b>
<br><b><?php echo $folioSolicitud; ?></b><br><br>
<b>DOMICILIO DE ENTREGA:</b> <?php echo $calle; ?> <?php echo $noExteriorInterior; ?>, <?php echo $colonia; ?>, <?php echo strtoupper($nombreEstado)  ?>, <?php echo strtoupper($nombreMunicipio)  ?>, <?php echo $codigoPostal; ?><br> 
REFERENCIAS: <?php echo $referencias; ?><br><br>

<table width="1200px" border="1">
    <tr>
        <td width="300px" align="center" style="background-color:#336BFF">
            <font color="white">MEDICAMENTO</font>
        </td>
        <td width="300px" align="center" style="background-color:#336BFF">
            <font color="white">GRAMAJE</font>
        </td>
        <td width="300px" align="center" style="background-color:#336BFF">
            <font color="white">PRESENTACION</font>
        </td>
        <td width="300px" align="center" style="background-color:#336BFF">
            <font color="white">CANTIDAD</font>
        </td>
    </tr>
    <?php 
    // genero la lista de medicamentos solicitados
    $query4 = "SELECT * from medicamentossolicitados where idSolicitudMedicamento=$idSolicitudMedicamentos";
    $res4 = mysqli_query($con,$query4);
    while ($registros=mysqli_fetch_array($res4)) {
    ?>
    <tr>
        <td><?php echo $registros['medicamento']; ?></td>
        <td><?php echo $registros['gramaje']; ?></td>
        <td><?php echo $registros['presentacion']; ?> </td>
        <td><?php echo $registros['cantidad']; ?></td>
    </tr>
<?php } ?>
</table><br><br>
Quedamos pendientes a la cotización.<br><br><br>
<center><b><font color="#336BFF">FIRMA</font></b>
<br><br>
<img src='http://chart.googleapis.com/chart?chs=130x130&cht=qr&chl=".$QRDATOS."'><br>
Torre Reforma 180, Piso 14,<br>
 Col. Juárez, 06600, CDMX<br>
5541240309 / contacto@empoderasalud.mx</center>
</body>
</html>

