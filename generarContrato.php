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
CONTRATO DE PRESTACI??N DE SERVICIOS M??DICOS PROFESIONALES en adelante como el ???Contrato???, que celebran por una parte <b><?php echo $nombreLegal; ?></b>, en su car??cter como prestador, representada legalmente en este acto por ___(REPRESENTANTE LEGAL PROVEEDOR)_________, en lo sucesivo ???<b><?php echo $nombreComercial; ?></b>??? y por la otra parte ADMINISTRADORA DE SERVICIOS DE SALUD EMPODERA, S.A.P.I. DE C.V., en su car??cter de cliente, representada legalmente en este acto por __(REPRESENTANTE LEGAL EMPODERA SALUD)_, en lo sucesivo la ???EMPODERA SALUD???, y conjuntamente como las ???PARTES??? al tenor de las siguientes declaraciones y cl??usulas:
<br><br>
<b><center>DECLARACIONES</center></b>
<ol type="I"> 
    <li>Declara ???<b><?php echo $nombreComercial; ?></b>???, que,
        <ol type="a"> 
            <li>Es una sociedad debidamente constituida conforme a las leyes de los Estados Unidos Mexicanos, lo que acredita con la escritura p??blica n??mero _____________________de fecha _____________________, otorgada ante la fe del Licenciado _____________________, titular de la Notar??a P??blica No______ de Municipio o Delegaci??n, Entidad Federativa.
            <li>Dentro de su objeto social se encuentra la operaci??n y administraci??n SERVICIOS DE SALUD detallados en el Anexo 1.
            <li>Para una mejor comunicaci??n designa los contactos enlistados en el Anexo 2 del presente instrumento.
            <li>Su Registro Federal de Contribuyentes es el <b><?php echo $rfcCedula; ?></b>.
            <li>Es su deseo celebrar el presente Contrato con <b>EMPODERA SALUD</b>, a efectos de prestar los servicios m??dicos en la forma y t??rminos contenidos en el mismo.
        </ol>
<br><li>Declara <b>EMPODERA SALUD</b> que,
        <ol type="a"> 
            <li>Es una sociedad debidamente constituida conforme conforme a las leyes de los Estados Unidos Mexicanos, como consta en la escritura p??blica n??mero 13,734 de fecha 15 de julio del 2020, pasada ante la fe del Licenciado Alfredo Dom??nguez Casas, titular de la Notar??a P??blica No. 74 de la Ciudad de M??xico.
            <li>Requiere de los servicios de atenci??n de salud que presta _____________________ detallados en el anexo 1 para sus agremiados, en lo sucesivo los ???Beneficiarios??? y responder?? por todos los gastos que se originen por la prestaci??n de los servicios objeto del presente Contrato.  
            <li>Para una mejor comunicaci??n designa los contactos enlistados en el Anexo 2 del presente instrumento.
            <li>Para efectos del presente contrato su domicilio se encuentra ubicado en la calle 5 de mayo No. 29 1 Nezahualc??yotl y Fco. I Madero Barrio Santa Crucita. C.P. 16070 Xochimilco, Ciudad de M??xico.
            <li>Su clave de Registro Federal de Contribuyentes es ASS2007299N8
        </ol>
</ol>
<br>
Las <b>PARTES</b> declaran que las manifestaciones expresadas en el presente cap??tulo son exactas, verdaderas y que no se ha omitido dato alguno que se requiera manifestar o informar; por tanto, est??n de acuerdo en sujetar su compromiso a la forma, t??rminos y condiciones insertos en las siguientes:
<br><br>
<b><center>CL??USULAS</center></b><br>
<b>PRIMERA. OBJETO</b>.- ???<b><?php echo $nombreComercial; ?></b>??? se compromete a proporcionar atenci??n m??dica hospitalaria (enunciativamente mas no limitativamente servicios como urgencias, hospitalizaci??n, cirug??a de estancia corta y estudios auxiliares de diagn??stico) en adelante los ???Servicios???, para los Beneficiarios, de conformidad con los t??rminos y condiciones de este Contrato, sus Anexos y las pol??ticas de operaci??n del ???<b><?php echo $nombreComercial; ?></b>???.
<br><br>
<b>SEGUNDA. LUGAR</b>.- ???<b><?php echo $nombreComercial; ?></b>??? se compromete a prestar los servicios materia del presente Contrato en (<?php echo $tipoVialidad ?> <?php echo $nombreVialidad ?>, <?php echo $noExterior ?>, <?php echo $colonia ?>, <?php echo $nombreMun?>, <?php echo $nombreEstado ?>, <?php echo $cp ?>)<br><br>

???<b><?php echo $nombreComercial; ?></b>???  proporcionar?? los servicios objeto del presente Contrato, en la misma forma, calidad y atenci??n que los presta o pudiera prestar a cualquier otro paciente particular y en t??rminos del reglamento de la Ley General de Salud en materia de prestaci??n de servicios de atenci??n m??dica<br><br>

<b>TERCERA. PRECIOS</b>.- El costo de los servicios m??dicos objeto de este Contrato ser?? conforme a la lista de precios vigentes de ???Nombre comercial del proveedor???, misma que se actualizar?? anualmente cada 01 de enero del a??o subsecuente a la suscripci??n del presente instrumento y durante la vigencia del mismo, lo anterior de acuerdo a las pol??ticas de incremento de costos de ???<b><?php echo $nombreComercial; ?></b>???; asimismo,  esta ??ltima deber?? notificar con por lo menos 15 (quince) d??as naturales dicha actualizaci??n para que EMPODERA SALUD realice los ajustes operativos necesarios.<br><br>

???<b><?php echo $nombreComercial; ?></b>??? se reserva el derecho de incrementar el costo de alg??n servicio en particular en cualquier momento, derivado de alg??n hecho extraordinario, mismo que se le notificar?? por escrito a EMPODERA SALUD y surtir?? efectos a los 15 (quince) d??as naturales posteriores a la notificaci??n.<br><br>

<b>CUARTA. VIGENCIA</b>. - La vigencia del presente Contrato ser?? del ???<b><?php echo $fechaInicioOperaciones; ?></b>??? al ???<b><?php echo $nuevafechaOperaciones; ?></b>??? con renovaci??n autom??tica por el mismo periodo al t??rmino de este plazo. No obstante, cualquiera de las PARTES podr?? darlo por terminado anticipadamente sin responsabilidad alguna, siempre y cuando medie aviso por escrito con 30 (treinta) d??as naturales de anticipaci??n, y saldando todas y cada una de las obligaciones ya contra??das. Dicha terminaci??n no deber?? afectar cualesquier obligaciones asumidas previamente y al tiempo de dicha terminaci??n.<br><br>

Para evitar cualquier duda, la terminaci??n no afectar?? el cuidado continuado de cualquier Beneficiario que est?? recibiendo servicios de emergencia y/o especializados bajo este Contrato, los cuales el Beneficiario requiera que sean continuados, y las PARTES acordaron previo a la terminaci??n de este Contrato.<br><br>

<b>QUINTA. ADMISI??N. - EMPODERA SALUD</b> se obliga a elaborar y entregar a sus Beneficiarios un instructivo donde se indiquen los lineamientos referentes a los servicios convenidos en el presente Contrato, procedimientos de ingreso al hospital y deber??n sujetarse a los reglamentos internos de ???<b><?php echo $nombreComercial; ?></b>???.<br><br>

Dentro de ese instructivo se informar?? claramente a los Beneficiarios que a su ingreso a ???<b><?php echo $nombreComercial; ?></b>??? deber??n exhibir la <b>Carta Autorizaci??n Preliminar</b> emitida por <b>EMPODERA SALUD</b> como se establece en el Anexo 3  y debidamente firmada por alg??n funcionario autorizado de <b>EMPODERA SALUD</b>, mismos que aparecen en el <b>Anexo 4</b>; los Beneficiarios deber??n sujetarse a los reglamentos internos de ???<b><?php echo $nombreComercial; ?></b>??? en su defecto pagar a este ??ltimo todos los servicios o conceptos que no sean cubiertos o incluidos <b>Carta Autorizaci??n final</b> emitida por <b>EMPODERA SALUD</b> como se establece en el <b>Anexo 3</b><br><br>

Ser?? condici??n para que ???<b><?php echo $nombreComercial; ?></b>??? cumpla frente a <b>EMPODERA SALUD</b> respecto a la obligaci??n de prestar los Servicios, el que los Beneficiario cuenten con el instructivo de referencia y cumplan con los requisitos antes se??alados.<br><br>

<b>SEXTA. REQUISITO DE ADMISI??N Y EGRESO</b>. - Como consideraci??n de la aceptaci??n de ???<b><?php echo $nombreComercial; ?></b>???  de prestar los servicios m??dicos objeto de este Contrato sin el requisito de dep??sitos, <b>EMPODERA SALUD</b> se compromete a entregar a sus Beneficiarios o a ???<b><?php echo $nombreComercial; ?>??? Carta Autorizaci??n Preliminar</b> emitida por EMPODERA SALUD amparando la totalidad o fracci??n especifica de los gastos originados por el Beneficiario derivado de la prestaci??n de los Servicios realizados, y debidamente firmada por su representante legal, en la cual se establecer?? de forma enunciativa y no limitativa lo siguiente:<br><br>

<ol>
  <li>El nombre del Beneficiario.</li>
  <li>El concepto o diagnostico materia del padecimiento motivo de la autorizaci??n.</li>
  <li>La cobertura de los gastos a cargo de <b>EMPODERA SALUD</b>.</li>
  <li>Los montos a cargo del <b>BENEFICIARIO</b>.</li>
</ol>

La <b>Carta Autorizaci??n Final</b> deber?? ser obtenida <b>PREVIO AL EGRESO</b> hospitalario o t??rmino de la atenci??n m??dica y en ella se estipular??n el detalle final de la cobertura de gastos con cargo a <b>EMPODERA SALUD</b> y aquellos con cargo al BENEFICIARIO y se precisar??n los datos de facturaci??n.<br><br>

<b>S??PTIMA. PROCEDIMIENTO</b>. - El procedimiento a seguir para llevar a cabo la prestaci??n de servicios hospitalarios ser??:
<ol type="a"> 
            <li>Hospitalizaci??n<p>En caso de que el Beneficiario requiera hospitalizaci??n por alg??n padecimiento o intervenci??n quir??rgica programada, deber?? llevar la Carta Autorizaci??n de <b>EMPODERA SALUD</b> amparando los gastos. De no ser as?? el Beneficiario se compromete a pagar la cuenta directamente a ???<b><?php echo $nombreComercial; ?></b>???.</li>
            <li>Urgencias<p>???<b><?php echo $nombreComercial; ?></b>??? se compromete a prestar el servicio, y <b>EMPODERA SALUD</b> deber?? notificar v??a telef??nica el ingreso del Beneficiario, proporcionando sus datos generales y enviar la Carta Autorizaci??n previo al egreso del Beneficiario o en un periodo m??ximo de 12 (doce) horas despu??s del ingreso. En caso de no haber sido notificado el ingreso del Beneficiario o emitido la Carta Autorizaci??n, el Beneficiario se compromete a pagar la cuenta directamente a ???<b><?php echo $nombreComercial; ?></b>???.</li>
</ol>
<b>OCTAVA. ATENCI??N.- ???<?php echo $nombreComercial; ?></b>??? se compromete y obliga a prestar los servicios m??dicos hospitalarios todos los d??as del a??o durante las veinticuatro horas, a trav??s de su cuerpo m??dico e informar a EMPODERA SALUD la evoluci??n cl??nica, detalle de gastos y reportes de estudios realizados cada 24 horas al equipo m??dico designado por EMPODERA SALUD (<b>Anexo 4</b>) o antes de 24 horas si el estado de salud representa un riesgo de gasto catastr??fico o pronostico malo para la vida y la funci??n.<br><br>
<b>NOVENA. HOSPITALIZACI??N</b>. - En cuanto a la prestaci??n de los servicios de hospitalizaci??n, ???<b><?php echo $nombreComercial; ?></b>??? se compromete y obliga en caso de hospitalizaci??n a:<br><br>
<ol type="A"> 
            <li>Prestar los servicios en habitaci??n est??ndar<p></li>
            <li>Proporcionar habitaciones de categor??a superior (suites) con el mismo costo que los cuartos est??ndar, cuando en el momento de la hospitalizaci??n no exista disponibilidad de habitaci??n est??ndar. ???<b><?php echo $nombreComercial; ?></b>??? reubicar?? al Beneficiario en las siguientes 24 (veinticuatro) horas cuando ello sea posible y no afecte la salud de este.</li>
</ol>
<b>D??CIMA. TRASLADOS NECESARIOS.- ???<?php echo $nombreComercial; ?>???</b> se compromete y <b>EMPODERA SALUD</b> acepta, a enviar al Beneficiario que as?? lo requiera, a otra instituci??n de salud en donde se proporcione alg??n servicio que sea necesario y que no pueda ser proporcionado en ???<b><?php echo $nombreComercial; ?></b>???  siendo a cargo y por cuenta de ???<b><?php echo $nombreComercial; ?></b>??? los gastos que se originen por el traslado y los Servicios que se presten ser??n cubiertos por <b>EMPODERA SALUD</b> (siempre y cuando sean garantizados en los t??rminos del presente Contrato, de lo contrario, ser??n pagados directamente por el Beneficiario).<br><br>
<b>D??CIMA PRIMERA. ARCHIVO CL??NICO. - ???<?php echo $nombreComercial; ?>???</b> ser?? responsable de integrar y mantener al corriente el archivo cl??nico formado por los expedientes m??dicos de cada uno de los Beneficiarios conserv??ndolos por un per??odo de cuanto menos 5 (cinco) a??os.<br><br>
???<b><?php echo $nombreComercial; ?></b>??? deber?? tratar a todos los Beneficiarios con respeto, y no diferenciar?? o discriminar?? por razones de sexo, raza, color, edad, religi??n, discapacidad, estado civil u orientaci??n sexual.<br><br>

<b>D??CIMA SEGUNDA. PAGO. - EMPODERA SALUD</b> se obliga a realizar la coordinaci??n necesaria para efectuar el pago total de la factura(as) por parte del <b>EMPODERA SALUD o SU CLIENTE</b> (anexo 6) correspondiente a los de los Servicios prestados a sus Beneficiarios dentro de los 30 (treinta) d??as naturales siguientes a la presentaci??n de la factura la cual corresponder?? exclusivamente a los montos indicados en la <b>Carta Autorizaci??n Final</b> (Anexo 3) obtenida previo al egreso de paciente por parte de ???<b><?php echo $nombreComercial; ?></b>???  y EMPODERA SALUD deber?? gestionar y enviar inmediatamente el comprobante de la transferencia para aplicar el pago.<br><br>

En caso de atraso en el pago de las facturas, ???<b><?php echo $nombreComercial; ?></b>???  podr?? dejar de prestar los servicios. Las PARTES designan a los funcionarios enlistados en el <b>Anexo 5</b> como matriz de escalonamiento de pago de facturas.<br><br>

Los pagos de las facturas se deber??n hacer por transferencia bancaria a la cuenta n??mero ________________ del Banco ________________, Sucursal ________________, CLABE ________________, a nombre de "________________" de _____________.<br><br>

<b>D??CIMA TERCERA. OTROS SEVICIOS</b>. - Cuando alg??n Beneficiario requiera otro tipo de servicios diferentes a los convenidos con <b>EMPODERA SALUD</b>, como servicio de restaurante, florer??a, llamadas de larga distancia y todo aquello que no est?? establecido en el presente Contrato, ser?? cubierto directamente por el Beneficiario.<br><br>

<b>D??CIMA CUARTA. CONSENTIMIENTO</b>. - Ambas <b>PARTES</b> podr??n en todo tiempo por conducto de sus respectivos representantes legales, hacer las observaciones que estimen pertinentes para el mejor cumplimiento del Contrato, oblig??ndose a atender las observaciones que hicieren, y en caso de que tuvieran razones de car??cter t??cnico, legal o contable para no hacerlo, deber??n expresarlas mediante comunicaci??n escrita para que se resuelva, en definitiva.<br><br>

<b>D??CIMA QUINTA. PROPIEDAD INTELECTUAL</b>. - Ninguna de las <b>PARTES</b> podr?? utilizar los nombres, logotipos, marcas comerciales, nombres de los empleados, s??mbolos o cualquier otro signo distintivo en actividades de mercadeo, peri??dicos o cualquier otra publicaci??n sin el previo consentimiento de la otra parte.<br><br>

???<b><?php echo $nombreComercial; ?></b>??? permitir?? que el logotipo y el nombre del Hospital, sean utilizados por <b>EMPODERA SALUD</b> ??nicamente como referencia a efecto de que los Beneficiarios tengan conocimiento de que pueden atenderse en ???<b><?php echo $nombreComercial; ?></b>???.<br><br>

<b>D??CIMA SEXTA. CONFIDENCIALIDAD</b>. - Las <b>PARTES</b> reconocen que la informaci??n, documentos, conocimientos, manuales, productos o servicios a los que tengan acceso en virtud de este Contrato, son propiedad exclusiva de la parte que los origin?? y se obligan a mantener la m??s absoluta confidencialidad, comprometi??ndose, a no revelarlos o hacerlos accesibles a terceros bajo ninguna forma o procedimiento.<br><br>

Cada una de las <b>PARTES</b> tratar?? con confidencialidad la informaci??n propiedad de la otra parte y en confianza no usar?? ni divulgar?? dicha informaci??n a persona alguna sin autorizaci??n previa por escrito de la otra, excepto cuando la ley lo requiera y excepto cuando sea requerido para cumplir con los derechos y obligaciones bajo este Contrato. Las <b>PARTES</b> tratar??n como secreto estricto toda la informaci??n relacionada directamente o indirectamente, a este Contrato y los asuntos aqu?? descritos, y no divulgar?? dichos t??rminos a persona alguna, sin el consentimiento previo por escrito de la otra, excepto cuando la ley lo requiera. Esta provisi??n no proh??be la comunicaci??n necesaria o apropiada para suministrar los servicios de cuidados de salud o comunicaciones acerca de la cobertura. Esta provisi??n perdurar?? a??n despu??s de haberse terminado este Contrato.<br><br>

<b>D??CIMA S??PTIMA. RELACION LABORAL</b>. - El personal que contraten las <b>PARTES</b> para el cumplimiento de sus obligaciones, no tendr?? relaci??n laboral alguna con la contraparte, ni tampoco se considerar??n agentes o comisionistas de esta ??ltima. Por tanto, las PARTES ser??n las ??nicas responsables del cumplimiento de las obligaciones en materia laboral para con su personal, comprometi??ndose a sacar en paz y a salvo a la otra parte contra cualquier reclamaci??n que pudiesen fincar en su contra.<br><br>

<b>D??CIMA OCTAVA. RESCISI??N</b>. - Ser?? causa de rescisi??n del presente Contrato, sin necesidad de declaraci??n judicial previa, el incumplimiento de cualquiera de las obligaciones contra??das por las <b>PARTES</b>, reserv??ndose la parte afectada, el derecho para reclamar el pago total de da??os y perjuicios procedentes.<br><br>

<b>D??CIMA NOVENA. TRANSMISI??N DE DERECHOS</b>. - Las <b>PARTES</b> no podr??n afectar, ceder o transferir los derechos y obligaciones que a su favor y a su cargo se deriven de este Contrato, salvo acuerdo previo, expreso y por escrito.<br><br>

<b>VIG??SIMA. NOTIFICACIONES</b>. - Toda notificaci??n o comunicaci??n entre las <b>PARTES</b> bajo este Contrato deber?? hacerse por escrito y entregarse personalmente a los domicilios enunciados en las declaraciones del presente instrumento o por correo certificado con acuse de recibo a las direcciones electr??nica que para tales efectos designes las <b>PARTES</b>. Toda notificaci??n se entender?? que surtir?? efectos al d??a siguiente de su recepci??n en los domicilios aqu?? consignados, por lo que cualquier cambio de domicilio deber?? ser notificado por escrito de forma inmediata a la otra parte.<br><br>

<b>VIG??SIMA PRIMERA. MODIFICACIONES</b>. - Las <b>PARTES</b> convienen que cualquier modificaci??n al presente Contrato requerir?? de la aprobaci??n mutua y por escrito de las <b>PARTES</b>.<br><br>

<b>VIG??SIMA SEGUNDA. TOTALIDAD DE ACUERDOS</b>. - El presente Contrato representa la totalidad del acuerdo al que han llegado las <b>PARTES</b> con relaci??n al objeto de este; por lo tanto, su sola suscripci??n deja sin efectos cualquier otro contrato, acuerdo o negociaci??n alguna que las <b>PARTES</b> hayan celebrado o realizado con relaci??n al objeto del presente instrumento.<br><br>

<b>VIG??SIMA TERCERA. FUERZA MAYOR</b>. - Las <b>PARTES</b> no ser??n responsables por cualquier incumplimiento o retraso en el cumplimiento de los t??rminos de este Contrato, cuando dicho incumplimiento o retraso sea debido a fuerza mayor. El t??rmino ???fuerza mayor??? como se utiliza en este Contrato, incluir?? sin limitaci??n, caso fortuito, epidemias, maremotos, explosiones, incendios, rel??mpagos, terremotos, huracanes, guerras, revueltas, disturbios civiles, huelgas, alteraciones improcedentes, actos de cualquier gobierno, ya sea federal, municipal u otro, o de cualquier agencia gubernamental, o acci??n judicial o cualquier otro evento que sea impredecible, repentino, insuperable y fuera del control de las <b>PARTES</b>.<br><br>

<b>VIG??SIMA CUARTA. VICIOS OCULTOS</b>.- Si cualquiera de las disposiciones contenidas en el presente o cualquier parte de las mismas se considerar?? como invalida, ilegal o no exigible en cualquier aspecto bajo cualquier ley aplicable, la validez, legalidad y exigibilidad de las dem??s disposiciones o parte de las mismas contenidas en el presente no ser?? afectada o alterada, y en estos t??rminos y condiciones se considerar?? como si la invalidez, ilegalidad o no exigibilidad de las disposiciones o parte de las mismas nunca hubieran estado contenidas en el presente.<br><br>

<b>VIG??SIMA QUINTA. INDEMNIZACIONES</b>. ??? Ambas <b>PARTES</b> pactan en indemnizar y sacar a la otra en paz y a salvo, en caso de cualquier demanda, acci??n, p??rdida, costo, responsabilidad o gasto que sea resultado de cualquier incumplimiento en los t??rminos y condiciones del presente instrumento y que sea generado indistintamente por cualquier acto negligente o intencional de alguno de los directores, empleados, agentes o subcontratistas.<br><br>

<b>VIG??SIMA SEXTA. COMPETENCIA</b>.- Las <b>PARTES</b> expresamente convienen en someterse a la jurisdicci??n de las Leyes y Tribunales de la Ciudad de M??xico y renuncia a cualquier objeci??n que hayan tenido en momento alguno en cuanto a establecer el lugar de cualquier demanda, acci??n o procedimiento entablado en un foro inconveniente; asimismo, al derecho de oponerse, con respecto a tales demandas, acciones o procedimientos, que dichos tribunales no tengan jurisdicci??n sobre las PARTES.<br><br>

El presente Contrato se firma por duplicado en la Ciudad de M??xico el d??a _____ de ___________ de 2021<br><br><br>

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
            <font color="white">CORREO ELECTR??NICO</font>
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
            <font color="white">CORREO ELECTR??NICO</font>
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
Las <b>PARTES</b> reconocen que en ning??n momento deber??n considerarse a los Contactos como apoderados o representantes legales de las <b>PARTES</b>, raz??n por la que los actos que realicen fuera de lo permitido en los alcances del presente contrato, no vincular?? de forma alguna a las <b>PARTES</b>.<br><br>

El presente Anexo se firma por duplicado en la Ciudad de M??xico el d??a ____ de ____________ de 2021.<br><br>
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
<center><b>ANEXO 3<br>CARTA DE AUTORIZACI??N PREELIMINAR</b></center>
<br><br>
<center><b>POR DEFINIR EL DISE??O</b></center>
<br><br>
<center><b>CARTA DE AUTORIZACI??N FINAL</b></center>
<br><br>
<center><b>POR DEFINIR EL DISE??O</b></center>
<br><br><br><br><br><br>
El presente Anexo se firma por duplicado en la Ciudad de M??xico el d??a ____ de ____________ de 2021.<br><br>
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
            <font color="white">CORREO ELECTR??NICO</font>
        </td>
    </tr>
    <tr height="50px">
        <td>M??dico Dictaminador</td>
        <td>5541602780 opci??n 2</td>
        <td>&nbsp;</td>
    </tr>
    <tr height="50px">
        <td>M??dico Dictaminador</td>
        <td>5541602780 opci??n 3</td>
        <td> </td>
    </tr>
    <tr height="50px">
        <td>Coordinador de Redes</td>
        <td>5525108759 </td>
        <td>&nbsp; </td>
    </tr>
</table><br><br>
<b>EMPODERA SALUD</b> deber?? de informar de inmediato a ________________ cualquier cambio en la lista de sus funcionarios autorizados, por escrito o a trav??s de correo electr??nico certificado.<br><br><br><br><br>

El presente Anexo se firma por duplicado en la Ciudad de M??xico el d??a ____ de ____________ de 2021.<br><br><br><br>
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
            <font color="white">CORREO ELECTR??NICO</font>
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
            <font color="white">CORREO ELECTR??NICO</font>
        </td>
    </tr>
    <tr height="50px">
        <td>Coordinador de facturaci??n y pagos</td>
        <td>5541602780 opci??n 2</td>
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
Las <b>PARTES</b> reconocen que en ning??n momento deber??n considerarse a los Contactos como apoderados o representantes legales de las PARTES, raz??n por la que los actos que realicen fuera de lo permitido en los alcances del presente contrato, no vincular?? de forma alguna a las <b>PARTES</b>.<br><br>
El presente Anexo se firma por duplicado en la Ciudad de M??xico el d??a ___ de ______________ de 2021.<br><br>
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

