<?php 
header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=contrato.doc");
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
    text-align: justify;
    }
</style>
</head>
<body>
<?php
error_reporting(0);
//creo la conexion
require_once ('class/conexion.php');
$con=conexion();
//recibo el idminuta
$idRegistro=$_GET['id'];
$repLegalEmpodera=$_GET['repLegalEmpodera'];
$repLegalProvee=$_GET['repLegalProvee'];

$query = "SELECT * from registros where idRegistro=$idRegistro";
$res = mysqli_query($con,$query);
$extraido= mysqli_fetch_array($res);
$idRegistro=$extraido['idRegistro'];
$nombreComercial=$extraido['nombreComercial'];
$nombreLegal=$extraido['nombreLegal'];
if ($nombreLegal==''){$nombreLegal='SIN ESPECIFICAR';}
$rfcCedula=$extraido['rfcCedula'];
$fechaInicioOperaciones=$extraido['fechaInicioOperaciones'];
$nuevafechaOperaciones = strtotime ( '+2 year' , strtotime ( $fechaInicioOperaciones ) ) ;
$nuevafechaOperaciones = date ( 'Y-m-j' , $nuevafechaOperaciones );
$tipoVialidad=$extraido['tipoVialidad'];
$nombreVialidad=$extraido['nombreVialidad'];
$noExterior=$extraido['noExterior'];
$colonia=$extraido['colonia'];
$cp=$extraido['codigoPostal'];

$municipio=$extraido['municipioDelegacion'];
if ($municipio!='') {
$query = 'SELECT nombre from municipios where id='.$municipio;
$res = mysqli_query($con,$query);
$extraido2= mysqli_fetch_array($res);
$nombreMun=$extraido2['nombre'];
} else { $nombreMun='Municipio'; }

$entidadFederativa=$extraido['entidadFederativa'];
if ($entidadFederativa!=0) {
$query2 = 'SELECT nombre from estados where idEstado='.$entidadFederativa;
$res2 = mysqli_query($con,$query2);
$extraido22= mysqli_fetch_array($res2);
$nombreEstado=$extraido22['nombreEstado'];
} else { $nombreEstado='Estado';}
?>
<!-- INICIA CONTENIDO DEL CONTRATO -->
CONTRATO DE PRESTACIÓN DE SERVICIOS MÉDICOS PROFESIONALES en adelante como el “Contrato”, que celebran por una parte <b><?php echo $nombreLegal; ?></b>, en su carácter como prestador, representada legalmente en este acto por ___(REPRESENTANTE LEGAL PROVEEDOR)_________, en lo sucesivo “<b><?php echo $nombreComercial; ?></b>” y por la otra parte ADMINISTRADORA DE SERVICIOS DE SALUD EMPODERA, S.A.P.I. DE C.V., en su carácter de cliente, representada legalmente en este acto por __(REPRESENTANTE LEGAL EMPODERA SALUD)_, en lo sucesivo la “EMPODERA SALUD”, y conjuntamente como las “PARTES” al tenor de las siguientes declaraciones y cláusulas:
<br><br>
<b><center>DECLARACIONES</center></b>
<ol type="I"> 
    <li>Declara “<b><?php echo $nombreComercial; ?></b>”, que,
        <ol type="a"> 
            <li>Es una sociedad debidamente constituida conforme a las leyes de los Estados Unidos Mexicanos, lo que acredita con la escritura pública número _____________________de fecha _____________________, otorgada ante la fe del Licenciado _____________________, titular de la Notaría Pública No______ de Municipio o Delegación, Entidad Federativa.
            <li>Dentro de su objeto social se encuentra la operación y administración SERVICIOS DE SALUD detallados en el Anexo 1.
            <li>Para una mejor comunicación designa los contactos enlistados en el Anexo 2 del presente instrumento.
            <li>Su Registro Federal de Contribuyentes es el <b><?php echo $rfcCedula; ?></b>.
            <li>Es su deseo celebrar el presente Contrato con <b>EMPODERA SALUD</b>, a efectos de prestar los servicios médicos en la forma y términos contenidos en el mismo.
        </ol>
<br><li>Declara <b>EMPODERA SALUD</b> que,
        <ol type="a"> 
            <li>Es una sociedad debidamente constituida conforme conforme a las leyes de los Estados Unidos Mexicanos, como consta en la escritura pública número 13,734 de fecha 15 de julio del 2020, pasada ante la fe del Licenciado Alfredo Domínguez Casas, titular de la Notaría Pública No. 74 de la Ciudad de México.
            <li>Requiere de los servicios de atención de salud que presta _____________________ detallados en el anexo 1 para sus agremiados, en lo sucesivo los “Beneficiarios” y responderá por todos los gastos que se originen por la prestación de los servicios objeto del presente Contrato.  
            <li>Para una mejor comunicación designa los contactos enlistados en el Anexo 2 del presente instrumento.
            <li>Para efectos del presente contrato su domicilio se encuentra ubicado en la calle 5 de mayo No. 29 1 Nezahualcóyotl y Fco. I Madero Barrio Santa Crucita. C.P. 16070 Xochimilco, Ciudad de México.
            <li>Su clave de Registro Federal de Contribuyentes es ASS2007299N8
        </ol>
</ol>
<br>
Las <b>PARTES</b> declaran que las manifestaciones expresadas en el presente capítulo son exactas, verdaderas y que no se ha omitido dato alguno que se requiera manifestar o informar; por tanto, están de acuerdo en sujetar su compromiso a la forma, términos y condiciones insertos en las siguientes:
<br><br>
<b><center>CLÁUSULAS</center></b><br>
<b>PRIMERA. OBJETO</b>.- “<b><?php echo $nombreComercial; ?></b>” se compromete a proporcionar atención médica hospitalaria (enunciativamente mas no limitativamente servicios como urgencias, hospitalización, cirugía de estancia corta y estudios auxiliares de diagnóstico) en adelante los “Servicios”, para los Beneficiarios, de conformidad con los términos y condiciones de este Contrato, sus Anexos y las políticas de operación del “<b><?php echo $nombreComercial; ?></b>”.
<br><br>
<b>SEGUNDA. LUGAR</b>.- “<b><?php echo $nombreComercial; ?></b>” se compromete a prestar los servicios materia del presente Contrato en (<?php echo $tipoVialidad ?> <?php echo $nombreVialidad ?>, <?php echo $noExterior ?>, <?php echo $colonia ?>, <?php echo $nombreMun?>, <?php echo $nombreEstado ?>, <?php echo $cp ?>)<br><br>

“<b><?php echo $nombreComercial; ?></b>”  proporcionará los servicios objeto del presente Contrato, en la misma forma, calidad y atención que los presta o pudiera prestar a cualquier otro paciente particular y en términos del reglamento de la Ley General de Salud en materia de prestación de servicios de atención médica<br><br>

<b>TERCERA. PRECIOS</b>.- El costo de los servicios médicos objeto de este Contrato será conforme a la lista de precios vigentes de “Nombre comercial del proveedor”, misma que se actualizará anualmente cada 01 de enero del año subsecuente a la suscripción del presente instrumento y durante la vigencia del mismo, lo anterior de acuerdo a las políticas de incremento de costos de “<b><?php echo $nombreComercial; ?></b>”; asimismo,  esta última deberá notificar con por lo menos 15 (quince) días naturales dicha actualización para que EMPODERA SALUD realice los ajustes operativos necesarios.<br><br>

“<b><?php echo $nombreComercial; ?></b>” se reserva el derecho de incrementar el costo de algún servicio en particular en cualquier momento, derivado de algún hecho extraordinario, mismo que se le notificará por escrito a EMPODERA SALUD y surtirá efectos a los 15 (quince) días naturales posteriores a la notificación.<br><br>

<b>CUARTA. VIGENCIA</b>. - La vigencia del presente Contrato será del ”<b><?php echo $fechaInicioOperaciones; ?></b>” al ”<b><?php echo $nuevafechaOperaciones; ?></b>” con renovación automática por el mismo periodo al término de este plazo. No obstante, cualquiera de las PARTES podrá darlo por terminado anticipadamente sin responsabilidad alguna, siempre y cuando medie aviso por escrito con 30 (treinta) días naturales de anticipación, y saldando todas y cada una de las obligaciones ya contraídas. Dicha terminación no deberá afectar cualesquier obligaciones asumidas previamente y al tiempo de dicha terminación.<br><br>

Para evitar cualquier duda, la terminación no afectará el cuidado continuado de cualquier Beneficiario que esté recibiendo servicios de emergencia y/o especializados bajo este Contrato, los cuales el Beneficiario requiera que sean continuados, y las PARTES acordaron previo a la terminación de este Contrato.<br><br>

<b>QUINTA. ADMISIÓN. - EMPODERA SALUD</b> se obliga a elaborar y entregar a sus Beneficiarios un instructivo donde se indiquen los lineamientos referentes a los servicios convenidos en el presente Contrato, procedimientos de ingreso al hospital y deberán sujetarse a los reglamentos internos de “<b><?php echo $nombreComercial; ?></b>”.<br><br>

Dentro de ese instructivo se informará claramente a los Beneficiarios que a su ingreso a “<b><?php echo $nombreComercial; ?></b>” deberán exhibir la <b>Carta Autorización Preliminar</b> emitida por <b>EMPODERA SALUD</b> como se establece en el Anexo 3  y debidamente firmada por algún funcionario autorizado de <b>EMPODERA SALUD</b>, mismos que aparecen en el <b>Anexo 4</b>; los Beneficiarios deberán sujetarse a los reglamentos internos de “<b><?php echo $nombreComercial; ?></b>” en su defecto pagar a este último todos los servicios o conceptos que no sean cubiertos o incluidos <b>Carta Autorización final</b> emitida por <b>EMPODERA SALUD</b> como se establece en el <b>Anexo 3</b><br><br>

Será condición para que “<b><?php echo $nombreComercial; ?></b>” cumpla frente a <b>EMPODERA SALUD</b> respecto a la obligación de prestar los Servicios, el que los Beneficiario cuenten con el instructivo de referencia y cumplan con los requisitos antes señalados.<br><br>

<b>SEXTA. REQUISITO DE ADMISIÓN Y EGRESO</b>. - Como consideración de la aceptación de “<b><?php echo $nombreComercial; ?></b>”  de prestar los servicios médicos objeto de este Contrato sin el requisito de depósitos, <b>EMPODERA SALUD</b> se compromete a entregar a sus Beneficiarios o a “<b><?php echo $nombreComercial; ?>” Carta Autorización Preliminar</b> emitida por EMPODERA SALUD amparando la totalidad o fracción especifica de los gastos originados por el Beneficiario derivado de la prestación de los Servicios realizados, y debidamente firmada por su representante legal, en la cual se establecerá de forma enunciativa y no limitativa lo siguiente:<br><br>

<ol>
  <li>El nombre del Beneficiario.</li>
  <li>El concepto o diagnostico materia del padecimiento motivo de la autorización.</li>
  <li>La cobertura de los gastos a cargo de <b>EMPODERA SALUD</b>.</li>
  <li>Los montos a cargo del <b>BENEFICIARIO</b>.</li>
</ol>

La <b>Carta Autorización Final</b> deberá ser obtenida <b>PREVIO AL EGRESO</b> hospitalario o término de la atención médica y en ella se estipularán el detalle final de la cobertura de gastos con cargo a <b>EMPODERA SALUD</b> y aquellos con cargo al BENEFICIARIO y se precisarán los datos de facturación.<br><br>

<b>SÉPTIMA. PROCEDIMIENTO</b>. - El procedimiento a seguir para llevar a cabo la prestación de servicios hospitalarios será:
<ol type="a"> 
            <li>Hospitalización<p>En caso de que el Beneficiario requiera hospitalización por algún padecimiento o intervención quirúrgica programada, deberá llevar la Carta Autorización de <b>EMPODERA SALUD</b> amparando los gastos. De no ser así el Beneficiario se compromete a pagar la cuenta directamente a “<b><?php echo $nombreComercial; ?></b>”.</li>
            <li>Urgencias<p>“<b><?php echo $nombreComercial; ?></b>” se compromete a prestar el servicio, y <b>EMPODERA SALUD</b> deberá notificar vía telefónica el ingreso del Beneficiario, proporcionando sus datos generales y enviar la Carta Autorización previo al egreso del Beneficiario o en un periodo máximo de 12 (doce) horas después del ingreso. En caso de no haber sido notificado el ingreso del Beneficiario o emitido la Carta Autorización, el Beneficiario se compromete a pagar la cuenta directamente a “<b><?php echo $nombreComercial; ?></b>”.</li>
</ol>
<b>OCTAVA. ATENCIÓN.- “<?php echo $nombreComercial; ?></b>” se compromete y obliga a prestar los servicios médicos hospitalarios todos los días del año durante las veinticuatro horas, a través de su cuerpo médico e informar a EMPODERA SALUD la evolución clínica, detalle de gastos y reportes de estudios realizados cada 24 horas al equipo médico designado por EMPODERA SALUD (<b>Anexo 4</b>) o antes de 24 horas si el estado de salud representa un riesgo de gasto catastrófico o pronostico malo para la vida y la función.<br><br>
<b>NOVENA. HOSPITALIZACIÓN</b>. - En cuanto a la prestación de los servicios de hospitalización, “<b><?php echo $nombreComercial; ?></b>” se compromete y obliga en caso de hospitalización a:<br><br>
<ol type="A"> 
            <li>Prestar los servicios en habitación estándar<p></li>
            <li>Proporcionar habitaciones de categoría superior (suites) con el mismo costo que los cuartos estándar, cuando en el momento de la hospitalización no exista disponibilidad de habitación estándar. “<b><?php echo $nombreComercial; ?></b>” reubicará al Beneficiario en las siguientes 24 (veinticuatro) horas cuando ello sea posible y no afecte la salud de este.</li>
</ol>
<b>DÉCIMA. TRASLADOS NECESARIOS.- “<?php echo $nombreComercial; ?>”</b> se compromete y <b>EMPODERA SALUD</b> acepta, a enviar al Beneficiario que así lo requiera, a otra institución de salud en donde se proporcione algún servicio que sea necesario y que no pueda ser proporcionado en “<b><?php echo $nombreComercial; ?></b>”  siendo a cargo y por cuenta de “<b><?php echo $nombreComercial; ?></b>” los gastos que se originen por el traslado y los Servicios que se presten serán cubiertos por <b>EMPODERA SALUD</b> (siempre y cuando sean garantizados en los términos del presente Contrato, de lo contrario, serán pagados directamente por el Beneficiario).<br><br>
<b>DÉCIMA PRIMERA. ARCHIVO CLÍNICO. - “<?php echo $nombreComercial; ?>”</b> será responsable de integrar y mantener al corriente el archivo clínico formado por los expedientes médicos de cada uno de los Beneficiarios conservándolos por un período de cuanto menos 5 (cinco) años.<br><br>
“<b><?php echo $nombreComercial; ?></b>” deberá tratar a todos los Beneficiarios con respeto, y no diferenciará o discriminará por razones de sexo, raza, color, edad, religión, discapacidad, estado civil u orientación sexual.<br><br>

<b>DÉCIMA SEGUNDA. PAGO. - EMPODERA SALUD</b> se obliga a realizar la coordinación necesaria para efectuar el pago total de la factura(as) por parte del <b>EMPODERA SALUD o SU CLIENTE</b> (anexo 6) correspondiente a los de los Servicios prestados a sus Beneficiarios dentro de los 30 (treinta) días naturales siguientes a la presentación de la factura la cual corresponderá exclusivamente a los montos indicados en la <b>Carta Autorización Final</b> (Anexo 3) obtenida previo al egreso de paciente por parte de “<b><?php echo $nombreComercial; ?></b>”  y EMPODERA SALUD deberá gestionar y enviar inmediatamente el comprobante de la transferencia para aplicar el pago.<br><br>

En caso de atraso en el pago de las facturas, “<b><?php echo $nombreComercial; ?></b>”  podrá dejar de prestar los servicios. Las PARTES designan a los funcionarios enlistados en el <b>Anexo 5</b> como matriz de escalonamiento de pago de facturas.<br><br>

Los pagos de las facturas se deberán hacer por transferencia bancaria a la cuenta número ________________ del Banco ________________, Sucursal ________________, CLABE ________________, a nombre de "________________" de _____________.<br><br>

<b>DÉCIMA TERCERA. OTROS SEVICIOS</b>. - Cuando algún Beneficiario requiera otro tipo de servicios diferentes a los convenidos con <b>EMPODERA SALUD</b>, como servicio de restaurante, florería, llamadas de larga distancia y todo aquello que no esté establecido en el presente Contrato, será cubierto directamente por el Beneficiario.<br><br>

<b>DÉCIMA CUARTA. CONSENTIMIENTO</b>. - Ambas <b>PARTES</b> podrán en todo tiempo por conducto de sus respectivos representantes legales, hacer las observaciones que estimen pertinentes para el mejor cumplimiento del Contrato, obligándose a atender las observaciones que hicieren, y en caso de que tuvieran razones de carácter técnico, legal o contable para no hacerlo, deberán expresarlas mediante comunicación escrita para que se resuelva, en definitiva.<br><br>

<b>DÉCIMA QUINTA. PROPIEDAD INTELECTUAL</b>. - Ninguna de las <b>PARTES</b> podrá utilizar los nombres, logotipos, marcas comerciales, nombres de los empleados, símbolos o cualquier otro signo distintivo en actividades de mercadeo, periódicos o cualquier otra publicación sin el previo consentimiento de la otra parte.<br><br>

“<b><?php echo $nombreComercial; ?></b>” permitirá que el logotipo y el nombre del Hospital, sean utilizados por <b>EMPODERA SALUD</b> únicamente como referencia a efecto de que los Beneficiarios tengan conocimiento de que pueden atenderse en “<b><?php echo $nombreComercial; ?></b>”.<br><br>

<b>DÉCIMA SEXTA. CONFIDENCIALIDAD</b>. - Las <b>PARTES</b> reconocen que la información, documentos, conocimientos, manuales, productos o servicios a los que tengan acceso en virtud de este Contrato, son propiedad exclusiva de la parte que los originó y se obligan a mantener la más absoluta confidencialidad, comprometiéndose, a no revelarlos o hacerlos accesibles a terceros bajo ninguna forma o procedimiento.<br><br>

Cada una de las <b>PARTES</b> tratará con confidencialidad la información propiedad de la otra parte y en confianza no usará ni divulgará dicha información a persona alguna sin autorización previa por escrito de la otra, excepto cuando la ley lo requiera y excepto cuando sea requerido para cumplir con los derechos y obligaciones bajo este Contrato. Las <b>PARTES</b> tratarán como secreto estricto toda la información relacionada directamente o indirectamente, a este Contrato y los asuntos aquí descritos, y no divulgará dichos términos a persona alguna, sin el consentimiento previo por escrito de la otra, excepto cuando la ley lo requiera. Esta provisión no prohíbe la comunicación necesaria o apropiada para suministrar los servicios de cuidados de salud o comunicaciones acerca de la cobertura. Esta provisión perdurará aún después de haberse terminado este Contrato.<br><br>

<b>DÉCIMA SÉPTIMA. RELACION LABORAL</b>. - El personal que contraten las <b>PARTES</b> para el cumplimiento de sus obligaciones, no tendrá relación laboral alguna con la contraparte, ni tampoco se considerarán agentes o comisionistas de esta última. Por tanto, las PARTES serán las únicas responsables del cumplimiento de las obligaciones en materia laboral para con su personal, comprometiéndose a sacar en paz y a salvo a la otra parte contra cualquier reclamación que pudiesen fincar en su contra.<br><br>

<b>DÉCIMA OCTAVA. RESCISIÓN</b>. - Será causa de rescisión del presente Contrato, sin necesidad de declaración judicial previa, el incumplimiento de cualquiera de las obligaciones contraídas por las <b>PARTES</b>, reservándose la parte afectada, el derecho para reclamar el pago total de daños y perjuicios procedentes.<br><br>

<b>DÉCIMA NOVENA. TRANSMISIÓN DE DERECHOS</b>. - Las <b>PARTES</b> no podrán afectar, ceder o transferir los derechos y obligaciones que a su favor y a su cargo se deriven de este Contrato, salvo acuerdo previo, expreso y por escrito.<br><br>

<b>VIGÉSIMA. NOTIFICACIONES</b>. - Toda notificación o comunicación entre las <b>PARTES</b> bajo este Contrato deberá hacerse por escrito y entregarse personalmente a los domicilios enunciados en las declaraciones del presente instrumento o por correo certificado con acuse de recibo a las direcciones electrónica que para tales efectos designes las <b>PARTES</b>. Toda notificación se entenderá que surtirá efectos al día siguiente de su recepción en los domicilios aquí consignados, por lo que cualquier cambio de domicilio deberá ser notificado por escrito de forma inmediata a la otra parte.<br><br>

<b>VIGÉSIMA PRIMERA. MODIFICACIONES</b>. - Las <b>PARTES</b> convienen que cualquier modificación al presente Contrato requerirá de la aprobación mutua y por escrito de las <b>PARTES</b>.<br><br>

<b>VIGÉSIMA SEGUNDA. TOTALIDAD DE ACUERDOS</b>. - El presente Contrato representa la totalidad del acuerdo al que han llegado las <b>PARTES</b> con relación al objeto de este; por lo tanto, su sola suscripción deja sin efectos cualquier otro contrato, acuerdo o negociación alguna que las <b>PARTES</b> hayan celebrado o realizado con relación al objeto del presente instrumento.<br><br>

<b>VIGÉSIMA TERCERA. FUERZA MAYOR</b>. - Las <b>PARTES</b> no serán responsables por cualquier incumplimiento o retraso en el cumplimiento de los términos de este Contrato, cuando dicho incumplimiento o retraso sea debido a fuerza mayor. El término “fuerza mayor” como se utiliza en este Contrato, incluirá sin limitación, caso fortuito, epidemias, maremotos, explosiones, incendios, relámpagos, terremotos, huracanes, guerras, revueltas, disturbios civiles, huelgas, alteraciones improcedentes, actos de cualquier gobierno, ya sea federal, municipal u otro, o de cualquier agencia gubernamental, o acción judicial o cualquier otro evento que sea impredecible, repentino, insuperable y fuera del control de las <b>PARTES</b>.<br><br>

<b>VIGÉSIMA CUARTA. VICIOS OCULTOS</b>.- Si cualquiera de las disposiciones contenidas en el presente o cualquier parte de las mismas se considerará como invalida, ilegal o no exigible en cualquier aspecto bajo cualquier ley aplicable, la validez, legalidad y exigibilidad de las demás disposiciones o parte de las mismas contenidas en el presente no será afectada o alterada, y en estos términos y condiciones se considerará como si la invalidez, ilegalidad o no exigibilidad de las disposiciones o parte de las mismas nunca hubieran estado contenidas en el presente.<br><br>

<b>VIGÉSIMA QUINTA. INDEMNIZACIONES</b>. – Ambas <b>PARTES</b> pactan en indemnizar y sacar a la otra en paz y a salvo, en caso de cualquier demanda, acción, pérdida, costo, responsabilidad o gasto que sea resultado de cualquier incumplimiento en los términos y condiciones del presente instrumento y que sea generado indistintamente por cualquier acto negligente o intencional de alguno de los directores, empleados, agentes o subcontratistas.<br><br>

<b>VIGÉSIMA SEXTA. COMPETENCIA</b>.- Las <b>PARTES</b> expresamente convienen en someterse a la jurisdicción de las Leyes y Tribunales de la Ciudad de México y renuncia a cualquier objeción que hayan tenido en momento alguno en cuanto a establecer el lugar de cualquier demanda, acción o procedimiento entablado en un foro inconveniente; asimismo, al derecho de oponerse, con respecto a tales demandas, acciones o procedimientos, que dichos tribunales no tengan jurisdicción sobre las PARTES.<br><br>

El presente Contrato se firma por duplicado en la Ciudad de México el día _____ de ___________ de 2021<br><br><br>

<table width="600px" align="center">
    <tr>
        <td width="300px" align="center">
            <b><?php echo $nombreLegal; ?></b>
        </td>
        <td width="300px" align="center">
            <b>ADMINISTRADORA DE SERVICIOS DE EMPODERA, S.A.P.I. DE C.V.</b>
        </td>
    </tr>
    <tr>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalProvee; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalEmpodera; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
    </tr>
</table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<center><b>ANEXO 1_SERVICIOS DE SALUD_DETALLE</b></center>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<table width="600px" align="center">
    <tr>
        <td width="300px" align="center">
            <b><?php echo $nombreLegal; ?></b>
        </td>
        <td width="300px" align="center">
            <b>ADMINISTRADORA DE SERVICIOS DE EMPODERA, S.A.P.I. DE C.V.</b>
        </td>
    </tr>
    <tr>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalProvee; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalEmpodera; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
    </tr>
</table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center><b>ANEXO 2<br>CONTACTOS</b></center>
<br><br><br><br>
<table width="900px" align="center" border="1">
    <tr>
        <td width="300px" align="center" style="background-color:#336BFF">
            <font color="white">NOMBRE</font>
        </td>
        <td width="300px" align="center" style="background-color:#336BFF">
            <font color="white">TELEFONO</font>
        </td>
        <td width="300px" align="center" style="background-color:#336BFF">
            <font color="white">CORREO ELECTRÓNICO</font>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td> &nbsp;</td>
        <td>&nbsp; </td>
    </tr>
    <tr>
        <td>&nbsp;  </td>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
    </tr>
    <tr>
        <td>&nbsp;  </td>
        <td>&nbsp; </td>
        <td> &nbsp;</td>
    </tr>
</table>
<br><br><br><br><br><br>
<center><b>EMPODERA SALUD</b></center>
<br><br>
<table width="900px" align="center" border="1">
    <tr>
        <td align="center" style="background-color:#336BFF" >
            <font color="white">NOMBRE</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">TELEFONO</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">CORREO ELECTRÓNICO</font>
        </td>
    </tr>
    <tr height="50px">
        <td>&nbsp;</td>
        <td>&nbsp; </td>
        <td>&nbsp;</td>
    </tr>
    <tr height="50px">
        <td>&nbsp; </td>
        <td>&nbsp; </td>
        <td> </td>
    </tr>
    <tr height="50px">
        <td>&nbsp; </td>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
    </tr>
</table><br><br>
Las <b>PARTES</b> reconocen que en ningún momento deberán considerarse a los Contactos como apoderados o representantes legales de las <b>PARTES</b>, razón por la que los actos que realicen fuera de lo permitido en los alcances del presente contrato, no vinculará de forma alguna a las <b>PARTES</b>.<br><br>

El presente Anexo se firma por duplicado en la Ciudad de México el día ____ de ____________ de 2021.<br><br>
<table width="600px" align="center">
    <tr>
        <td width="300px" align="center">
            <b><?php echo $nombreLegal; ?></b>
        </td>
        <td width="300px" align="center">
            <b>ADMINISTRADORA DE SERVICIOS DE EMPODERA, S.A.P.I. DE C.V.</b>
        </td>
    </tr>
    <tr>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalProvee; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalEmpodera; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
    </tr>
</table>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center><b>ANEXO 3<br>CARTA DE AUTORIZACIÓN PREELIMINAR</b></center>
<br><br>
<center><b>POR DEFINIR EL DISEÑO</b></center>
<br><br>
<center><b>CARTA DE AUTORIZACIÓN FINAL</b></center>
<br><br>
<center><b>POR DEFINIR EL DISEÑO</b></center>
<br><br><br><br><br><br>
El presente Anexo se firma por duplicado en la Ciudad de México el día ____ de ____________ de 2021.<br><br>
<table width="600px" align="center">
    <tr>
        <td width="300px" align="center">
            <b><?php echo $nombreLegal; ?></b>
        </td>
        <td width="300px" align="center">
            <b>ADMINISTRADORA DE SERVICIOS DE EMPODERA, S.A.P.I. DE C.V.</b>
        </td>
    </tr>
    <tr>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalProvee; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalEmpodera; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
    </tr>
</table>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center><b>ANEXO 4<br>LISTA DE FUNCIONARIOS Y MEDICOS POR EMPODERA SALUD</b></center><br><br><br><br>
<table width="900px" align="center" border="1">
    <tr>
        <td align="center" style="background-color:#336BFF" >
            <font color="white">NOMBRE</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">TELEFONO</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">CORREO ELECTRÓNICO</font>
        </td>
    </tr>
    <tr height="50px">
        <td>Médico Dictaminador</td>
        <td>5541602780 opción 2</td>
        <td>&nbsp;</td>
    </tr>
    <tr height="50px">
        <td>Médico Dictaminador</td>
        <td>5541602780 opción 3</td>
        <td> </td>
    </tr>
    <tr height="50px">
        <td>Coordinador de Redes</td>
        <td>5525108759 </td>
        <td>&nbsp; </td>
    </tr>
</table><br><br>
<b>EMPODERA SALUD</b> deberá de informar de inmediato a ________________ cualquier cambio en la lista de sus funcionarios autorizados, por escrito o a través de correo electrónico certificado.<br><br><br><br><br>

El presente Anexo se firma por duplicado en la Ciudad de México el día ____ de ____________ de 2021.<br><br><br><br>
<table width="600px" align="center">
    <tr>
        <td width="300px" align="center">
            <b><?php echo $nombreLegal; ?></b>
        </td>
        <td width="300px" align="center">
            <b>ADMINISTRADORA DE SERVICIOS DE EMPODERA, S.A.P.I. DE C.V.</b>
        </td>
    </tr>
    <tr>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalProvee; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalEmpodera; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
    </tr>
</table>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<center><b>ANEXO 5<br>ESCALONAMIENTO PAGO FACTURAS</b></center><br><br><br><br>
<center>- - - - - - - - - - -</center><br><br>
<table width="900px" align="center" border="1">
    <tr>
        <td align="center" style="background-color:#336BFF" >
            <font color="white">NOMBRE</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">TELEFONO</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">CORREO ELECTRÓNICO</font>
        </td>
    </tr>
    <tr height="50px">
        <td>&nbsp;</td>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
    </tr>
    <tr height="50px">
        <td>&nbsp; </td>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
    </tr>
</table><br><br>
<center><b>EMPODERA SALUD</b></center><br><br>
<table width="900px" align="center" border="1">
    <tr>
        <td align="center" style="background-color:#336BFF" >
            <font color="white">NOMBRE</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">TELEFONO</font>
        </td>
        <td align="center" style="background-color:#336BFF">
            <font color="white">CORREO ELECTRÓNICO</font>
        </td>
    </tr>
    <tr height="50px">
        <td>Coordinador de facturación y pagos</td>
        <td>5541602780 opción 2</td>
        <td>&nbsp;</td>
    </tr>
    <tr height="50px">
        <td>&nbsp; </td>
        <td>&nbsp; </td>
        <td> </td>
    </tr>
    <tr height="50px">
        <td>&nbsp; </td>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
    </tr>
    <tr height="50px">
        <td>&nbsp; </td>
        <td>&nbsp; </td>
        <td>&nbsp; </td>
    </tr>
</table><br><br>
Las <b>PARTES</b> reconocen que en ningún momento deberán considerarse a los Contactos como apoderados o representantes legales de las PARTES, razón por la que los actos que realicen fuera de lo permitido en los alcances del presente contrato, no vinculará de forma alguna a las <b>PARTES</b>.<br><br>
El presente Anexo se firma por duplicado en la Ciudad de México el día ___ de ______________ de 2021.<br><br>
<table width="600px" align="center">
    <tr>
        <td width="300px" align="center">
            <b><?php echo $nombreLegal; ?></b>
        </td>
        <td width="300px" align="center">
            <b>ADMINISTRADORA DE SERVICIOS DE EMPODERA, S.A.P.I. DE C.V.</b>
        </td>
    </tr>
    <tr>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalProvee; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
        <td width="300px" align="center">
            <br><br><br><b><b><?php echo $repLegalEmpodera; ?></b><br>REPRESENTANTE LEGAL</b>
        </td>
    </tr>
</table>

</body>
</html>

