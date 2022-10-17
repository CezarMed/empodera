<?php
error_reporting(0);
@session_start();
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();
// print_r($_POST);

$idSolicitudMedicamentos=$_POST['idSolicitudMedicamentos'];
$idServicio=$_POST['idServicio'];
$idBeneficiario=$_POST['idBeneficiario'];

$query="SELECT * from servicios s INNER JOIN beneficiarios b on b.idBenefeciario=s.idBeneficiario 
        where s.idServicio=$idServicio";
$res=mysqli_query($con,$query);
$extraido= mysqli_fetch_array($res);
$folioEmpodera=$extraido['folioEmpodera'];
$nombreBeneficiario=$extraido['nombreBeneficiario'];
$servicio=$extraido['servicio'];

$QRDATOS=$idServicio.'/';
$QRDATOS.=$idBeneficiario.'/';

$html="";
$html.="<style type='text/css'>
    body {
    margin: 0;
    padding: 0;
    background-color: #fff;
    font: 10pt 'Calibri';
    color: rgb(0, 0, 0);
    font-size: 12px;
    }
</style>";
$html.="
<img src='http://sysadmin.empoderasalud.mx/logo_empodera.png' width='179px' height='110px'><hr>
<br><b>DATOS DEL SERVICIO.</b><br><br></b>
Folio de solicitud: <b>".$folioEmpodera."</b> para el benefeciario <b>".$nombreBeneficiario."</b> con el servicio solicitado <b>".$servicio."</b><br><br>
";

$number = count($_POST["idnotacheck"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idnotacheck"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "SELECT * from notasmedicas nm
                  INNER JOIN beneficiarios b on b.idBenefeciario=nm.idBeneficiario 
                  where nm.idnota='".$_POST["idnotacheck"][$i]."'";
                $res=mysqli_query($con, $sql1);
                $registros = mysqli_fetch_array($res);
                $resumen=$registros['resumen'];
                if ($resumen==''){$resumen='No referido';}
                $exploracionfis=$registros['exploracionfis'];
                if ($exploracionfis==''){$exploracionfis='No referido';}
                $resultadoestudios=$registros['resultadoestudios'];
                if ($resultadoestudios==''){$resultadoestudios='No referido';}
                $diagnostico=$registros['diagnostico'];
                if ($diagnostico==''){$diagnostico='No referido';}
                $planestudios=$registros['planestudios'];
                if ($planestudios==''){$planestudios='No referido';}
                $pronostico=$registros['pronostico'];
                if ($pronostico==''){$pronostico='No referido';}

                $html.="<table>
    <tr>
        <td>
            <b>NOTA MEDICAS - ".$registros['fechaElaboracion']." -</b>
        </td>
    </tr><tr>
            <td>Con fecha de elaboración ".$registros['fechaElaboracion']." siendo las ".$registros['horaElbaora']." se recibe ".$registros['tipoComunicacion']." de ".$registros['nombrecomunica']." petición para seguimiento del Beneficiario ".$registros['nombreBeneficiario']." por motivo de ".$registros['motivoatencion']."</td></tr>
            <tr><td><b>Resumen Medico</b> ".$resumen." </td></tr>
            <tr><td><b>Exploración física</b> ".$exploracionfis." </td></tr>
            <tr><td><b>Resultado de Estudios auxiliares</b> ".$resultadoestudios." </td></tr>
            <tr><td><b>Análisis de diagnóstico y problemas clínicos/medico-administrativos</b> ".$diagnostico." </td></tr>
            <tr><td><b>Plan de estudio y/o tratamiento</b> ".$planestudios." </td></tr>
            <tr><td><b>Pronóstico</b> ".$pronostico." </td></tr>
            </table><br>";

            }
            }
            }



            $number = count($_POST["idnotaprecheck"]);
            if($number >= 1)
            {
                $html.="";
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idnotaprecheck"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "SELECT * from notaspreoperatorias nm
                  INNER JOIN beneficiarios b on b.idBenefeciario=nm.idBeneficiario 
                  where nm.idNotaPreoperatoria='".$_POST["idnotaprecheck"][$i]."'";
                $res=mysqli_query($con, $sql1);
                $registros = mysqli_fetch_array($res);
                              $diagnostico=$registros['diagnostico'];
                              if ($diagnostico==''){$diagnostico='No referido';}
                              $planqui=$registros['planqui'];
                              if ($planqui==''){$planqui='No referido';}
                              $riesgoqui=$registros['riesgoqui'];
                              if ($riesgoqui==''){$riesgoqui='No referido';}
                              $cuidados=$registros['cuidados'];
                              if ($cuidados==''){$cuidados='No referido';}
                              $estudiosolicitado=$registros['estudiosolicitado'];
                              $problemaclinico=$registros['problemaclinico'];
                              $incidentesaccidentes=$registros['incidentesaccidentes'];
                              
                $html.="<table>
    <tr>
        <td>
            <b>NOTA PREOPERATORIA - ".$registros['fechaElaboracion']." -</b>
        </td>
    </tr><tr>
        <td>Con fecha de elaboración ".$registros['fechaElaboracion']." siendo las ".$registros['horaElbaora']." se recibe ".$registros['tipoComunicacion']." de ".$registros['nombrecomunica']." petición para seguimiento del Beneficiario ".$registros['nombreBeneficiario']." por motivo de ".$registros['motivoatencion']." con fecha de cirugia ".$registros['fechaCirugia']." y hora de cirugia ".$registros['horaCirugia']." </td></tr>
              <tr><td><b>Diagnóstico pre-operatorio</b> ".$diagnostico." </td></tr>
              <tr><td><b>Plan quirúrgico</b> ".$planqui." </td></tr>
              <tr><td><b>Riesgo quirúrgico</b> ".$riesgoqui." </td></tr>
              <tr><td><b>Cuidados y plan terapéutico preoperatorio</b> ".$cuidados." </td></tr>
              </table><br>";            

            }
            };
            }


             $number = count($_POST["idnotaconsultacheck"]);
            if($number >= 1)
            {
                $html.="";
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idnotaconsultacheck"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "SELECT * from montosconsultas mc
                            inner join datosconsultas dc on dc.idConsulta=mc.idConsulta 
                            where mc.idConsulta='".$_POST["idnotaconsultacheck"][$i]."'";
                $res=mysqli_query($con, $sql1);
                $registros = mysqli_fetch_array($res);
                $html.="<table>
    <tr>
        <td>
            <b>NOTA CONSULTA MEDICA - ".$registros['fechaAgrega']." -</b>
        </td>
    </tr><tr>
        <td>Con fecha de elaboración ".$registros['fechaAgrega']." se crea una consulta para el medico ".$registros['medico']." por el concepto de ".$registros['consultacpt4']." por un monto de  $".$registros['monto']." </td></tr>
              </table><br>";            

            }
            };
            }

            



$number = count($_POST["idnotaadminheck"]);
            if($number >= 1)
            {
                $html.="";
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idnotaadminheck"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "SELECT np.idNotaAdministrativa, np.fechaAlta, np.importancia, np.nota from notasadministrativas np
                  INNER JOIN beneficiarios b on b.idBenefeciario=np.idBeneficiario 
                  where np.idNotaAdministrativa='".$_POST["idnotaadminheck"][$i]."'";
                $res=mysqli_query($con, $sql1);
                $registros = mysqli_fetch_array($res);
                $html.="<table>
    <tr>
        <td>
            <b>NOTA ADMINISTRATIVA - ".$registros['fechaAlta']." -</b>
        </td>
    </tr><tr>
        <td>Con fecha de elaboración ".$registros['fechaAlta']."  se crea la nota con importancia de tipo ".$registros['importancia']." con el siguiente detalle: ".$registros['nota']."";

            }
            }
            }

$html.="</table><br><br>
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
$dompdf->stream("notas".$folioEmpodera.".pdf", ["Attachment" => false]);

?>