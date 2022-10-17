<?php
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();
//recibo el idminuta
$idMinuta=$_GET['id'];

$query = "SELECT * from minutas where idMinuta=$idMinuta";
$res = mysqli_query($con,$query);
$extraido= mysqli_fetch_array($res);
$idRegistro=$extraido['idRegistro'];
$medio=$extraido['medio'];
$fechaMinuta=$extraido['fechaMinuta'];
$nombreElabora=$extraido['nombreElabora'];
$emailElabora=$extraido['emailElabora'];
$acuerdos=$extraido['acuerdos'];
if ($acuerdos==''){$acuerdos="- - - - - - - - - - - - - - - -";}
$asuntos=$extraido['asuntos'];
if ($asuntos==''){$asuntos="- - - - - - - - - - - - - - - -";}
$anuncios=$extraido['anuncios'];
if ($anuncios==''){$anuncios="- - - - - - - - - - - - - - - -";}
$nuevosAsuntos=$extraido['nuevosAsuntos'];
if ($nuevosAsuntos==''){$nuevosAsuntos="- - - - - - - - - - - - - - - -";}
$firmas=$extraido['firmas'];

$QRDATOS='https://sysadmin.empoderasalud.mx/generarMinutaPDF?id=';
$QRDATOS.=$idMinuta;

$query2 = "SELECT * from registros where idRegistro=$idRegistro";
$res2 = mysqli_query($con,$query2);
$extraido2= mysqli_fetch_array($res2);
$rfcCedula=$extraido2['rfcCedula'];
$nombreComercial=$extraido2['nombreComercial'];

$html="";
$html.="<style type='text/css'>
    body {
    margin: 0;
    padding: 0;
    background-color: #fff;
    font: 10pt 'Calibri';
    color: rgb(0, 0, 0);
    font-size: 10px;
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

</style>";
$html.="
<img src='http://sysadmin.empoderasalud.mx/logo_empodera.png' width='179px' height='110px'><hr>
<center><font size='14'>MINUTA DE REUNIÓN</font></center><br>
<table class='bordered'>
<tr>
<td bgcolor='#06A779'><font color='white'><b>LLAMADA AL ORDEN</b><br></font></td>
</tr>
<tr>
<td>Tuvo lugar una reunión de <b>EMPODERA</b> en <b>".$medio."</b> el <b>".$fechaMinuta."</b><br></td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>DATOS DEL PROVEEDOR</b></font></td>
</tr>
<tr>
<td>".$rfcCedula."<br> ".$nombreComercial."<br><br></td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>MIEMBROS ASISTENTES</b></font></td>
</tr>
<tr>
<td>";
$queryAsistentes = "SELECT * from asistentesminutas where idMinuta=$idMinuta";
$resultAsistentes = mysqli_query($con,$queryAsistentes);
while ($datosAsistentes = mysqli_fetch_array($resultAsistentes)){
    $nombreAsistente=$datosAsistentes['nombre'];
    $emailAsistente=$datosAsistentes['email'];
    $puestoAsistente=$datosAsistentes['puesto'];
    $telefonoAsistente=$datosAsistentes['telefono'];
    $html.="".$nombreAsistente." <a href='mailto: ".$emailAsistente."'>".$emailAsistente."</a> ".$puestoAsistente." ".$telefonoAsistente."<br><br>";
}
$html.="</td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>CORREO DE ELABORACIÓN DE MINUTA</b></font></td>
</tr>
<tr>
<td>".$nombreElabora." <a href='mailto: ".$emailElabora."'>".$emailElabora."</a><br><br></td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>Miembros No asistentes</b></font></td>
</tr>
<td>";
$queryAsistentes = "SELECT * from noasistentesminutas where idMinuta=$idMinuta";
$resultAsistentes = mysqli_query($con,$queryAsistentes);
while ($datosAsistentes = mysqli_fetch_array($resultAsistentes)){
    $nombreAsistente=$datosAsistentes['nombre'];
    $emailAsistente=$datosAsistentes['email'];
    $puestoAsistente=$datosAsistentes['puesto'];
    $telefonoAsistente=$datosAsistentes['telefono'];
    $html.="".$nombreAsistente." <a href='mailto: ".$emailAsistente."'>".$emailAsistente."</a> ".$puestoAsistente." ".$telefonoAsistente."<br><br>";
}
$html.="</td>
</tr>
</table>";
$html.="<table class='bordered'>
<tr>
<td bgcolor='#06A779'><font color='white'><b>ACUERDOS EN REUNIÓN</b><br></font></td>
</tr>
<tr>
<td>".$acuerdos."<br></td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>ASUNTOS PENDIENTES</b><br></font></td>
</tr>
<tr>
<td>".$asuntos."<br><br></td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>ANUNCIOS</b></font></td>
</tr>
<tr>
<td>".$anuncios."<br><br></td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>NUEVOS ASUNTOS</b></font></td>
</tr>
<tr>
<td>".$nuevosAsuntos."<br><br></td>
</tr>
<tr>
<td bgcolor='#06A779'><font color='white'><b>FIRMA DE CONFORMIDAD DE LOS ASISTENTES</b></font></td>
</tr>
<tr>
<td>";
$array = explode(",", $firmas);
foreach($array as $key) {
$html.="".$key."<br>";
}
$html.="<br></td>
</tr>
</table>";

$html.="<br>
<center>
<img src='http://chart.googleapis.com/chart?chs=130x130&cht=qr&chl=".$QRDATOS."'><br>
Torre Reforma 180, Piso 14,<br>
 Col. Juárez, 06600, CDMX<br>
5573233693  / contacto@empoderasalud.mx</center>

";

 /* $html.="<br><b>ACUERDOS EN REUNIÓN</b><br><br>".$acuerdos."
<br><br><b>ASUNTOS PENDIENTES </b><br><br>".$asuntos."
<br><br><b>ANUNCIOS </b><br><br>".$anuncios."
<br><br><b>NUEVOS ASUNTOS </b><br><br>".$nuevosAsuntos."
<br><br><b>FIRMA DE CONFORMIDAD DE LOS ASISTENTES</b><br><br>
"; 
$array = explode(",", $firmas);
foreach($array as $key) {    
    $html.= "".$key."<br/>";    
}
*/
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
$dompdf->stream("minuta_".$nombreComercial.".pdf", ["Attachment" => false]);

?>