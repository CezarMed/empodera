<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaMedicamentos_class {

function accionesMedicamentos() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaMedicamentos', $datosCmb)) {
         $resp= $this->altaMedicamentos();
    }
    if (array_key_exists('actualizaMedicamentos', $datosCmb)) {
         $resp= $this->actualizaMedicamentos();
    }
}



// funcion para dar de alta registro
function altaMedicamentos() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$nombreBeneficiario=$arrayDatos['nombreSolicitante'];
$idServicio=$arrayDatos['idServicio'];

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);

$datos= $_POST['confrimaciondatos'];
$elecciones = implode(",", $datos);


$query="INSERT INTO solicitudmedicamentos (foliosolicitud,idBeneficiario,idServicio,fechaSolicitud,entidadFederativa,municipioDelegacion,calle,noExteriorInterior,colonia,codigoPostal,telefonoBeneficiario,nombreRecibe,telefonoRecibe,referencias,recetaArchivo,confrimaciondatos,idUsuario,fechaCargo,estatus)
        values 
        ('". $codigoP ."'," . $arrayDatos['idBeneficiario'] ."," . $arrayDatos['idServicio'] .",'" . $arrayDatos['fechaSolicitud'] ."'," . $arrayDatos['entidadFederativa'] ."," . $arrayDatos['municipioDelegacion'] .",'" . $arrayDatos['calle'] ."','" . $arrayDatos['noExteriorInterior'] ."','" . $arrayDatos['colonia'] ."','" . $arrayDatos['codigoPostal'] ."','" . $arrayDatos['telefonoBeneficiario'] ."','" . $arrayDatos['nombreRecibe'] ."','" . $arrayDatos['telefonoRecibe'] ."','" . $arrayDatos['referencias'] ."','".$url12."','".$elecciones."',". $idUsuario .",'" . $hoy ."',1)";
            $crea=mysqli_query($con,$query);

            //obtengo id de minuta agregada
            $queryM = "SELECT idSolicitudMedicamentos from solicitudmedicamentos where foliosolicitud='$codigoP' LIMIT 1";
            $result = mysqli_query($con,$queryM);
            $extraido= mysqli_fetch_array($result);
            $idSolicitudMedicamentoNew=$extraido['idSolicitudMedicamentos'];

            //actualizo el estatus del servicio
            $queryActualizaServicio = "UPDATE servicios SET estatus=6 where idServicio=$idServicio";
            mysqli_query($con,$queryActualizaServicio);

            $conteo = count($_FILES["archivo"]["name"]);
            $size = sizeof($emptyArray);
            for ($i=0; $i < $conteo; $i++) {
                $ubicacionTemporal = $_FILES["archivo"]["tmp_name"][$i];
                $nombreArchivo=$_FILES["archivo"]["name"][$i];
                $url12 ='documentosempodera/recetas/recetamedicamentos-'.$codigoP.'-'.$nombreBeneficiario.'-'.$nombreArchivo;
                move_uploaded_file($ubicacionTemporal, $url12);
                if ($ubicacionTemporal!='') {
                $insertarNota="INSERT INTO archivosrecetasmedicamentos (idSolicitudMedicamento,archivo,fechaSubia,estatus) VALUES (".$idSolicitudMedicamentoNew.",'".$url12."','".$hoy."',1)";
                $crea2=mysqli_query($con,$insertarNota);
            }
            }

            
            $number = count($_POST["nombre"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["nombre"][$i]!= ''))
            {
                $listamedicamentos.='';
                $medicamento=$_POST["nombre"][$i];
                $gramaje=$_POST["gramaje"][$i];
                $presentacion=$_POST["presentacion"][$i];
                $cantidad=$_POST["cantidad"][$i];
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO medicamentossolicitados (idSolicitudMedicamento, medicamento, gramaje, presentacion, cantidad, fechaTermina, estatus) VALUES(".$idSolicitudMedicamentoNew.",'".$_POST["nombre"][$i]."','".$_POST["gramaje"][$i]."','".$_POST["presentacion"][$i]."','".$_POST["cantidad"][$i]."','".$_POST["fechaTermina"][$i]."',1)";
                    mysqli_query($con, $sql1);
                    $listamedicamentos.=$medicamento." - ".$gramaje." - ".$presentacion." - ".$cantidad." || ";

            }
            }
            }


        // creo la nota de solicitud de medicamentos
            $insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'SE SOLICITAN MEDICAMENTOS: ".strtoupper($listamedicamentos)."','".$hoy."',1)";
            mysqli_query($con,$insertarNota);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "detalleDeServicio?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
             window.location="detalleDeServicio?do=1&idBeneficiario=<?php echo $arrayDatos['idBeneficiario'] ?>&idServicio=<?php echo $arrayDatos['idServicio'] ?>";
        </script>
        <?php }
}


// funcion para editar la solicitud de medicamentos
function actualizaMedicamentos() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$nombreBeneficiario=$arrayDatos['nombreSolicitante'];
$idServicio=$arrayDatos['idServicio'];
$idSolicitudMedicamentoNew=$arrayDatos["idSolicitudMedicamentos"];

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);

$archivo = $_FILES['archivo'];
$nombreArchivo=$nombreBeneficiario.'-recetamedicamentosNew-'.$codigoP;
$codigo=$archivo['name'];
$url12 ='documentosempodera/recetas/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url12 ='documentosempodera/recetas/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url12);
$sqlfILE = "UPDATE solicitudmedicamentos SET recetaArchivo='".$url12."' where idSolicitudMedicamentos=".$arrayDatos["idSolicitudMedicamentos"]."";
mysqli_query($con, $sqlfILE);
 } else {
    $url12='';
 }

// actualizo los datos de solicitud de medicamentos
                    $sql1 = "UPDATE solicitudmedicamentos SET entidadFederativa='".$arrayDatos["entidadFederativa"]."', municipioDelegacion='".$arrayDatos["municipioDelegacion"]."', calle='".$arrayDatos["calle"]."', noExteriorInterior='".$arrayDatos["noExteriorInterior"]."', colonia='".$arrayDatos["colonia"]."', codigoPostal='".$arrayDatos["codigoPostal"]."', telefonoBeneficiario='".$arrayDatos["telefonoBeneficiario"]."', nombreRecibe='".$arrayDatos["nombreRecibe"]."', telefonoRecibe='".$arrayDatos["telefonoRecibe"]."', referencias='".$arrayDatos["referencias"]."' where idSolicitudMedicamentos=".$arrayDatos["idSolicitudMedicamentos"]."";
                    $crea=mysqli_query($con, $sql1);


            $number = count($_POST["nombre"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["nombre"][$i]!= ''))
            {
                // actualizo los medicamentos originales
                    $sql11="UPDATE medicamentossolicitados SET medicamento='".$_POST["nombre"][$i]."', gramaje='".$_POST["gramaje"][$i]."', presentacion='".$_POST["presentacion"][$i]."', cantidad='".$_POST["cantidad"][$i]."', fechaTermina='".$_POST["fechaTermina"][$i]."', estatus=".$_POST["activoR"][$i]."
                    where idMedicamento=".$_POST["idMedicamento"][$i]."";
                    $crea=mysqli_query($con, $sql11);
            }
            }
            }

            $numberNew = count($_POST["nombreNew"]);
            if($numberNew >= 1)
            {
            for($i=0; $i<$numberNew; $i++)
            {
            if(trim($_POST["nombreNew"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO medicamentossolicitados (idSolicitudMedicamento, medicamento, gramaje, presentacion, cantidad, fechaTermina, estatus) VALUES(".$idSolicitudMedicamentoNew.",'".$_POST["nombreNew"][$i]."','".$_POST["gramajeNew"][$i]."','".$_POST["presentacionNew"][$i]."','".$_POST["cantidadNew"][$i]."','".$_POST["fechaTerminaNew"][$i]."',1)";
                    mysqli_query($con, $sql1);
            }
            }
            }

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "editarSolicitudMedicamentos?do=2&idSolicitudMedicamentos=<?php echo $arrayDatos['idSolicitudMedicamentos'] ?>";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="editarSolicitudMedicamentos?do=1&idSolicitudMedicamentos=<?php echo $arrayDatos['idSolicitudMedicamentos'] ?>";
        </script>
        <?php }
}


function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaMedicamentos', $_POST)) {
                $datos_getpost['altaMedicamentos'] = $_POST['altaMedicamentos'];
            }
            if (array_key_exists('actualizaMedicamentos', $_POST)) {
                $datos_getpost['actualizaMedicamentos'] = $_POST['actualizaMedicamentos'];
            }
            
            
            if (array_key_exists('idBeneficiario', $_POST)) {
                $datos_getpost['idBeneficiario'] = $_POST['idBeneficiario'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('nombreSolicitante', $_POST)) {
                $datos_getpost['nombreSolicitante'] = $_POST['nombreSolicitante'];
            }
            if (array_key_exists('fechaSolicitud', $_POST)) {
                $datos_getpost['fechaSolicitud'] = $_POST['fechaSolicitud'];
            }
            if (array_key_exists('entidadFederativa', $_POST)) {
                $datos_getpost['entidadFederativa'] = $_POST['entidadFederativa'];
            }
            if (array_key_exists('municipioDelegacion', $_POST)) {
                $datos_getpost['municipioDelegacion'] = $_POST['municipioDelegacion'];
            }
            if (array_key_exists('calle', $_POST)) {
                $datos_getpost['calle'] = $_POST['calle'];
            }
            if (array_key_exists('noExteriorInterior', $_POST)) {
                $datos_getpost['noExteriorInterior'] = $_POST['noExteriorInterior'];
            }
            if (array_key_exists('colonia', $_POST)) {
                $datos_getpost['colonia'] = $_POST['colonia'];
            }
            if (array_key_exists('codigoPostal', $_POST)) {
                $datos_getpost['codigoPostal'] = $_POST['codigoPostal'];
            }
            if (array_key_exists('telefonoBeneficiario', $_POST)) {
                $datos_getpost['telefonoBeneficiario'] = $_POST['telefonoBeneficiario'];
            }
            if (array_key_exists('nombreRecibe', $_POST)) {
                $datos_getpost['nombreRecibe'] = $_POST['nombreRecibe'];
            }
            if (array_key_exists('telefonoRecibe', $_POST)) {
                $datos_getpost['telefonoRecibe'] = $_POST['telefonoRecibe'];
            }
            if (array_key_exists('referencias', $_POST)) {
                $datos_getpost['referencias'] = $_POST['referencias'];
            }
            if (array_key_exists('idSolicitudMedicamentos', $_POST)) {
                $datos_getpost['idSolicitudMedicamentos'] = $_POST['idSolicitudMedicamentos'];
            }
                      
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>