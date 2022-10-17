<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaNotaMedicas_class {

function accionesNotaMedica() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaNotaMedica', $datosCmb)) {
         $resp= $this->altaNotaMedica();
    }
    if (array_key_exists('altaNotaPreoperatoria', $datosCmb)) {
         $resp= $this->altaNotaPreoperatoria();
    }
    if (array_key_exists('altaNotaAdmin', $datosCmb)) {
         $resp= $this->altaNotaAdmin();
    }
}

// funcion para dar de alta registro
function altaNotaMedica() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d');
$ahora=date('H:i:s');
$hoyTime=date('Y-m-d H:i:s');
$nombreBeneficiario=$arrayDatos['nombreSolicitante'];
$costonota=$arrayDatos['costonota'];
$costonota=str_replace( ',', '', $costonota );
$costonota=str_replace( '$', '', $costonota );
if ($costonota==''){$costonota=0;}

// genero el codigo
function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);

// creo la insercion de los datos de la nota
$query="INSERT INTO notasmedicas (codigoNota,tipoComunicacion,nombrecomunica,motivoatencion,idServicio,idBeneficiario,fechaElaboracion,horaElbaora,edad,sexo,peso,talla,tension,frecuenciacar,frecuenciares,temperatura,resumen,exploracionfis,resultadoestudios,diagnostico,planestudios,pronostico,nombredr,especialidad,cedula,costonota,idUsuario,estatus)
        values 
        ('". $codigoP ."','" . $arrayDatos['tipoComunicacion'] ."','" . $arrayDatos['nombrecomunica'] ."','" . $arrayDatos['motivoatencion'] ."'," . $arrayDatos['idServicio'] ."," . $arrayDatos['idBeneficiario'] .",'" . $hoy ."','" . $ahora ."'," . $arrayDatos['edad'] .",'" . $arrayDatos['sexo'] ."','" . $arrayDatos['peso'] ."','" . $arrayDatos['talla'] ."','" . $arrayDatos['tension'] ."','" . $arrayDatos['frecuenciacar'] ."','" . $arrayDatos['frecuenciares'] ."','" . $arrayDatos['temperatura'] ."','" . $arrayDatos['resumen'] ."','" . $arrayDatos['exploracionfis'] ."','" . $arrayDatos['resultadoestudios'] ."','" . $arrayDatos['diagnostico'] ."','" . $arrayDatos['planestudios'] ."','" . $arrayDatos['pronostico'] ."','" . $arrayDatos['nombredr'] ."','" . $arrayDatos['especialidad'] ."','" . $arrayDatos['cedula'] ."','" . $costonota ."'," . $idUsuario .",1)";
$crea=mysqli_query($con,$query);


// obtenbgo el folio del servicio
$idServicio=$arrayDatos['idServicio'];
$query="SELECT * FROM servicios where idServicio=$idServicio";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$folioServicio=$registro['folioEmpodera'];

// subo y creo el campo archivoXML
$archivo = $_FILES['archivo'];
if ($archivo!=''){
$nombreArchivo=$folioServicio.'-'.$arrayDatos['concepto'].'-biblioteca-'.$codigoP;
$codigo=$archivo['name'];
$url121 ='documentosempodera/servicios/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/servicios/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url121);
// agrego el documento si es que se tiene
$query="INSERT INTO serviciosdocumentos (idServicio,concepto,archivo,idSubio,fechaSubida,estatus)
        values 
        ('" . $arrayDatos['idServicio'] ."','" . $arrayDatos['concepto'] ."','" . $url121 ."',". $idUsuario .",'" . $hoyTime ."',1)";
 mysqli_query($con,$query);
 } else {
    $url121='';
 }


}
        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "detalleDeServicio?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="detalleDeServicio?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>
        <?php }
}



function altaNotaPreoperatoria() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d');
$ahora=date('H:i:s');
$hoyTime=date('Y-m-d H:i:s');
$nombreBeneficiario=$arrayDatos['nombreSolicitante'];

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);

$honorarios=$arrayDatos['honorarios'];
$honorarios = str_replace( ',', '', $honorarios );
$honorarios = str_replace( '$', '', $honorarios );

$cirujano=$arrayDatos['cirujano'];
$cirujano = str_replace( ',', '', $cirujano );
$cirujano = str_replace( '$', '', $cirujano );

$anesteciologo=$arrayDatos['anesteciologo'];
$anesteciologo = str_replace( ',', '', $anesteciologo );
$anesteciologo = str_replace( '$', '', $anesteciologo );

$ayudante=$arrayDatos['ayudante'];
$ayudante = str_replace( ',', '', $ayudante );
$ayudante = str_replace( '$', '', $ayudante );

$enfermeria=$arrayDatos['enfermeria'];
$enfermeria = str_replace( ',', '', $enfermeria );
$enfermeria = str_replace( '$', '', $enfermeria );

$ayudante2=$arrayDatos['ayudante2'];
$ayudante2 = str_replace( ',', '', $ayudante2 );
$ayudante2 = str_replace( '$', '', $ayudante2 );

$query="INSERT INTO notaspreoperatorias (codigoNota, tipoComunicacion, nombrecomunica, motivoatencion, idServicio, idBeneficiario, fechaElaboracion, horaElbaora, fechaCirugia, horaCirugia, diagnostico, planqui, riesgoqui, cuidados, fechaEstudio, horaEstudio, estudiosolicitado, problemaclinico, incidentesaccidentes, cptAsignado, nombrecirujano, nombreanestesiologo, nombreayudante, nombreenfermeria, nombreayudante2, honorarios, cirujano, anestesiologo, ayudante, enfermeria, ayudante2, idUsuario, estatus)
        values 
        ('". $codigoP ."','" . $arrayDatos['tipoComunicacion'] ."','" . $arrayDatos['nombrecomunica'] ."','" . $arrayDatos['motivoatencion'] ."'," . $arrayDatos['idServicio'] ."," . $arrayDatos['idBeneficiario'] .",'" . $hoy ."','" . $ahora ."','" . $arrayDatos['fechaCirugia'] ."','" . $arrayDatos['horaCirugia'] ."','" . $arrayDatos['diagnostico'] ."','" . $arrayDatos['planqui'] ."','" . $arrayDatos['riesgoqui'] ."','" . $arrayDatos['cuidados'] ."','" . $arrayDatos['fechaEstudio'] ."','" . $arrayDatos['horaEstudio'] ."','" . $arrayDatos['estudiosolicitado'] ."','" . $arrayDatos['problemaclinico'] ."','" . $arrayDatos['incidentesaccidentes'] ."','" . $arrayDatos['cambiaCPt'] ."', '" . $arrayDatos['nombrecirujano'] ."', '". $arrayDatos['nombreanesteciologo']."', '". $arrayDatos['nombreayudante']."', '". $arrayDatos['nombreenfermeria']."', '". $arrayDatos['nombreayudante2']."', '" . $honorarios ."', '" . $cirujano ."', '". $anesteciologo."', '". $ayudante."', '". $enfermeria."', '". $ayudante2."', " . $idUsuario .",1)";
            $crea=mysqli_query($con,$query);

// obtenbgo el folio del servicio
$idServicio=$arrayDatos['idServicio'];
$query="SELECT * FROM servicios where idServicio=$idServicio";
$res = mysqli_query($con,$query);
$registro = mysqli_fetch_array($res);
$folioServicio=$registro['folioEmpodera'];

// subo y creo el campo archivoXML
$archivo = $_FILES['archivo'];
if ($archivo!=''){
$nombreArchivo=$folioServicio.'-'.$arrayDatos['concepto'].'-biblioteca-'.$codigoP;
$codigo=$archivo['name'];
$url121 ='documentosempodera/servicios/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url121 ='documentosempodera/servicios/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url121);
 } else {
    $url121='';
 }

$query="INSERT INTO serviciosdocumentos (idServicio,concepto,archivo,idSubio,fechaSubida,estatus)
        values 
        ('" . $arrayDatos['idServicio'] ."','" . $arrayDatos['concepto'] ."','" . $url121 ."',". $idUsuario .",'" . $hoyTime ."',1)";
 mysqli_query($con,$query);
}

        if (!$crea) { ?>
        <script type="text/javascript">
           window.location = "detalleDeServicio?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
           window.location="detalleDeServicio?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>
        <?php }
}


function altaNotaAdmin() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');

$query="INSERT INTO notasadministrativas (idServicio,idBeneficiario,nota,importancia,fechaAlta,idUsuario,estatus)
        values 
        (" . $arrayDatos['idServicio'] ."," . $arrayDatos['idBeneficiario'] .",'" . $arrayDatos['contenidonota'] ."','" . $arrayDatos['importancianota'] ."','" . $hoy ."'," . $idUsuario .",1)";
            $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "detalleDeServicio?do=2&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="detalleDeServicio?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>
        <?php }
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaNotaMedica', $_POST)) {
                $datos_getpost['altaNotaMedica'] = $_POST['altaNotaMedica'];
            }
            if (array_key_exists('tipoComunicacion', $_POST)) {
                $datos_getpost['tipoComunicacion'] = $_POST['tipoComunicacion'];
            }
            if (array_key_exists('nombrecomunica', $_POST)) {
                $datos_getpost['nombrecomunica'] = $_POST['nombrecomunica'];
            }
            if (array_key_exists('motivoatencion', $_POST)) {
                $datos_getpost['motivoatencion'] = $_POST['motivoatencion'];
            }
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] = $_POST['idBeneficiario'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('edad', $_POST)) {
                $datos_getpost['edad'] = $_POST['edad'];
            }
            if (array_key_exists('sexo', $_POST)) {
                $datos_getpost['sexo'] = $_POST['sexo'];
            }
            if (array_key_exists('peso', $_POST)) {
                $datos_getpost['peso'] = $_POST['peso'];
            }
            if (array_key_exists('talla', $_POST)) {
                $datos_getpost['talla'] = $_POST['talla'];
            }
            if (array_key_exists('tension', $_POST)) {
                $datos_getpost['tension'] = $_POST['tension'];
            }
            if (array_key_exists('frecuenciacar', $_POST)) {
                $datos_getpost['frecuenciacar'] = $_POST['frecuenciacar'];
            }
            if (array_key_exists('frecuenciares', $_POST)) {
                $datos_getpost['frecuenciares'] = $_POST['frecuenciares'];
            }
            if (array_key_exists('temperatura', $_POST)) {
                $datos_getpost['temperatura'] = $_POST['temperatura'];
            }
            if (array_key_exists('resumen', $_POST)) {
                $datos_getpost['resumen'] = $_POST['resumen'];
            }
            if (array_key_exists('exploracionfis', $_POST)) {
                $datos_getpost['exploracionfis'] = $_POST['exploracionfis'];
            }
            if (array_key_exists('resultadoestudios', $_POST)) {
                $datos_getpost['resultadoestudios'] = $_POST['resultadoestudios'];
            }
            if (array_key_exists('diagnostico', $_POST)) {
                $datos_getpost['diagnostico'] = $_POST['diagnostico'];
            }
            if (array_key_exists('planestudios', $_POST)) {
                $datos_getpost['planestudios'] = $_POST['planestudios'];
            }
            if (array_key_exists('pronostico', $_POST)) {
                $datos_getpost['pronostico'] = $_POST['pronostico'];
            }
            if (array_key_exists('nombredr', $_POST)) {
                $datos_getpost['nombredr'] = $_POST['nombredr'];
            }
            if (array_key_exists('especialidad', $_POST)) {
                $datos_getpost['especialidad'] = $_POST['especialidad'];
            }
            if (array_key_exists('cedula', $_POST)) {
                $datos_getpost['cedula'] = $_POST['cedula'];
            }
            if (array_key_exists('costonota', $_POST)) {
                $datos_getpost['costonota'] = $_POST['costonota'];
            }
            if (array_key_exists('concepto', $_POST)) {
                $datos_getpost['concepto'] = $_POST['concepto'];
            }


            // aqui inicia la nota preoperatoria
            if (array_key_exists('altaNotaPreoperatoria', $_POST)) {
                $datos_getpost['altaNotaPreoperatoria'] = $_POST['altaNotaPreoperatoria'];
            }
            if (array_key_exists('fechaCirugia', $_POST)) {
                $datos_getpost['fechaCirugia'] = $_POST['fechaCirugia'];
            }
            if (array_key_exists('horaCirugia', $_POST)) {
                $datos_getpost['horaCirugia'] = $_POST['horaCirugia'];
            }
            if (array_key_exists('planqui', $_POST)) {
                $datos_getpost['planqui'] = $_POST['planqui'];
            }
            if (array_key_exists('riesgoqui', $_POST)) {
                $datos_getpost['riesgoqui'] = $_POST['riesgoqui'];
            }
            if (array_key_exists('cuidados', $_POST)) {
                $datos_getpost['cuidados'] = $_POST['cuidados'];
            }
            if (array_key_exists('fechaEstudio', $_POST)) {
                $datos_getpost['fechaEstudio'] = $_POST['fechaEstudio'];
            }
            if (array_key_exists('horaEstudio', $_POST)) {
                $datos_getpost['horaEstudio'] = $_POST['horaEstudio'];
            }
            if (array_key_exists('estudiosolicitado', $_POST)) {
                $datos_getpost['estudiosolicitado'] = $_POST['estudiosolicitado'];
            }
            if (array_key_exists('problemaclinico', $_POST)) {
                $datos_getpost['problemaclinico'] = $_POST['problemaclinico'];
            }
            if (array_key_exists('incidentesaccidentes', $_POST)) {
                $datos_getpost['incidentesaccidentes'] = $_POST['incidentesaccidentes'];
            }
            if (array_key_exists('honorarios', $_POST)) {
                $datos_getpost['honorarios'] = $_POST['honorarios'];
            }
            if (array_key_exists('cirujano', $_POST)) {
                $datos_getpost['cirujano'] = $_POST['cirujano'];
            }
            if (array_key_exists('anesteciologo', $_POST)) {
                $datos_getpost['anesteciologo'] = $_POST['anesteciologo'];
            }
            if (array_key_exists('ayudante', $_POST)) {
                $datos_getpost['ayudante'] = $_POST['ayudante'];
            }
            if (array_key_exists('enfermeria', $_POST)) {
                $datos_getpost['enfermeria'] = $_POST['enfermeria'];
            }
            if (array_key_exists('ayudante2', $_POST)) {
                $datos_getpost['ayudante2'] = $_POST['ayudante2'];
            }
            if (array_key_exists('nombrecirujano', $_POST)) {
                $datos_getpost['nombrecirujano'] = $_POST['nombrecirujano'];
            }
            if (array_key_exists('nombreanesteciologo', $_POST)) {
                $datos_getpost['nombreanesteciologo'] = $_POST['nombreanesteciologo'];
            }
            if (array_key_exists('nombreayudante', $_POST)) {
                $datos_getpost['nombreayudante'] = $_POST['nombreayudante'];
            }
            if (array_key_exists('nombreenfermeria', $_POST)) {
                $datos_getpost['nombreenfermeria'] = $_POST['nombreenfermeria'];
            }
            if (array_key_exists('nombreayudante2', $_POST)) {
                $datos_getpost['nombreayudante2'] = $_POST['nombreayudante2'];
            }
            if (array_key_exists('cambiaCPt', $_POST)) {
                $datos_getpost['cambiaCPt'] = $_POST['cambiaCPt'];
            }


            // aqui inicia la nota administrativa
            if (array_key_exists('altaNotaAdmin', $_POST)) {
                $datos_getpost['altaNotaAdmin'] = $_POST['altaNotaAdmin'];
            }
            if (array_key_exists('contenidonota', $_POST)) {
                $datos_getpost['contenidonota'] = $_POST['contenidonota'];
            }
            if (array_key_exists('importancianota', $_POST)) {
                $datos_getpost['importancianota'] = $_POST['importancianota'];
            }
                      
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>