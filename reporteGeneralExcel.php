<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteGeneral.xls");
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
$fechaInicio=$_POST['fechaInicio'];
$fechaFin=$_POST['fechaFin'];
?>
<table>
    <tr>
        <td>Grupo</td>
        <td>Folio</td>
        <td>Programa</td>
        <td>No. de Afiliacion modificado</td>
        <td>Folio Servicio Modificado</td>
        <td>Titulo Codi</td>
        <td>subgrupo</td>
        <td>Nombre</td>
        <td>Servicio</td>
        <td>Clasificacion</td>
        <td>Cie10</td>
        <td>Diagnostico Cie10</td>
        <td>Cpt4</td>
        <td>Tratamiento Cpt4</td>
        <td>Proveedor Codificado</td>
        <td>Fecha</td>
        <td>Monto Autorizado</td>
        <td>Gastos Atencion</td>
        <td>Honorarios Medicos</td>
        <td>Deducible acumulado</td>
        <td>Deducible Pagado</td>
        <td>Deducible Depositado</td>
        <td>Deducible Acreditado</td>
        <td>CoPago Acumulado</td>
        <td>Copago Acreditado</td>
        <td>Copago Pagado</td> 
        <td>Copago Depositado</td>
        <td>Monto facturado</td>
        <td>Estatus</td> 
        <td>Fecha Ultimo Movto</td>
        <td>Ultimo Movto (Notas)</td> 
        <td>Fecha Ultima Nota Médica</td>
        <td>Ultima Nota Médica (Notas)</td> 
    </tr>
    <?php 
    $i=0;
    $grupo="AAA";
    // genero la lista de servios solicitados
    $query4="SELECT mc.nombreAcuerdo, s.folioEmpodera,s.idServicio,s.servicio,s.monto,s.montoFacturable,b.fechaNacimiento, b.tipoPrograma, b.folioBeneficiario, mc.subgrupo, b.nombreBeneficiario, cie.grupocie, cie.cie10, cie.diagnosticocie10, cpt.cpt4, cpt.tratamientocpt4, scp.folioCierre, s.fechaAlta, te.descripcionEstatus, nm.fechaElaboracion, nm.motivoatencion  FROM servicios s 
    INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario
    INNER JOIN beneficiarioscuentas bc on bc.idBeneficiario=s.idBeneficiario
    INNER JOIN montosclientes mc on mc.idMontoCliente=bc.idPrograma
    LEFT JOIN datoscpt cpt on cpt.idServicio=s.idServicio
    LEFT JOIN datoscie cie on cie.idServicio=s.idServicio
    LEFT JOIN servicioscerradosproveedor scp on scp.idServicio=s.idServicio
    INNER JOIN tipoestatus te on te.idEstatus=s.estatus
    LEFT JOIN notasmedicas nm on nm.idServicio=s.idServicio
    where s.fechaAlta between '$fechaInicio 00:00:00' and '$fechaFin 23:59:59' GROUP BY s.idServicio";
    $res4=mysqli_query($con,$query4);
    while ($registros=mysqli_fetch_array($res4)) {
        $idServicioN=$registros['idServicio'];
        $i=$i+1;
    ?>
    <tr>
        <td><?php echo $grupo; ?></td>
        <td><?php echo $registros['folioEmpodera']; ?></td>
        <td><?php echo $registros['nombreAcuerdo']; ?></td>
        <td><?php echo $registros['folioBeneficiario']; ?>
            
        </td>
        <td><?php echo $grupo; ?><?php echo $registros['folioEmpodera']; ?></td>
        <td></td>
        <td><?php echo $registros['subgrupo']; ?></td>
        <td><?php echo $registros['nombreBeneficiario']; ?></td>
        <td><?php echo $registros['servicio'] ?></td>
        <td><?php echo $registros['grupocie']; ?></td>
        <td><?php echo $registros['cie10']; ?></td>
        <td><?php echo $registros['diagnosticocie10']; ?></td>
        <td><?php echo $registros['cpt4']; ?></td>
        <td><?php echo $registros['tratamientocpt4']; ?></td>
        <td><?php echo $registros['folioCierre']; ?></td>
        <td><?php echo $registros['fechaAlta']; ?></td>


        <?php 
        $querynotas="SELECT sum(monto) as totalmedico from gastosmedicos nm 
        where nm.estatus=1 and nm.idServicio=$idServicioN";
        $resnotas = mysqli_query($con,$querynotas);
        $extraidonotas= mysqli_fetch_array($resnotas);
        $totalgastosmedicos=$extraidonotas['totalmedico']; 

                $querynotas="SELECT sum(costonota) as totalmedico from notasmedicas nm 
    where nm.estatus=1 and nm.idServicio=$idServicioN";
    $resnotas = mysqli_query($con,$querynotas);
    $extraidonotas= mysqli_fetch_array($resnotas);
    $totalmedicos=$extraidonotas['totalmedico'];
        ?>

        <?php 
    $querytotalmed2="SELECT sum(cirujano+anestesiologo+ayudante+enfermeria+ayudante2) as totalhonorarios from notaspreoperatorias np  
    where idServicio=$idServicioN and estatus=1";
    $restotalnotas2 = mysqli_query($con,$querytotalmed2);
    $extraidotot2= mysqli_fetch_array($restotalnotas2);
    $totalhonorarios=$extraidotot2['totalhonorarios'];
        ?>
        <td><?php echo ($totalgastosmedicos+$totalmedicos+$totalhonorarios)  ?></td>
        <td><?php echo $totalgastosmedicos ?></td>
        <td><?php echo $totalhonorarios ?></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td><?php echo $registros['descripcionEstatus']; ?></td>
        <td></td>
        <td></td> 
        <td><?php echo $registros['fechaElaboracion']; ?></td>
        <td><?php echo $registros['motivoatencion']; ?></td>
    </tr>
<?php } ?>
</table>
</body>
</html>

