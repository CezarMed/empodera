<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class respondeCotizacion_class {

function accionesCotizacion() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('responderCotizacion', $datosCmb)) {
         $resp= $this->responderCotizacion();
    }
    if (array_key_exists('responderCotizacionEmpodera', $datosCmb)) {
         $resp= $this->responderCotizacionEmpodera();
    }
}

// funcion para actualizar los datos de cotizacion
function responderCotizacion() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$proveedor=$arrayDatos['proveedor'];

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);

$archivo = $_FILES['archivo'];
$nombreArchivo='-SOL-COT-'.$arrayDatos['idCotizacion'].'-cotizacionrespuesta-'.$codigoP;
$codigo=$archivo['name'];
$url12 ='documentosempodera/cotizacionesproveedor/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url12 ='documentosempodera/cotizacionesproveedor/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url12);
 } else {
    $url12='';
 }

$idServicio=$arrayDatos['idServicio'];
// actualizo la solicitud de cotizacion y cambio estatus de cotizacion
$query="UPDATE solicitudcotizaciones SET fechaRespuesta='".$arrayDatos['fechaRespuesta']."', fechaEntrega='".$arrayDatos['fechaEntrega']."', comentariosProveedor='".$arrayDatos['comentariosProveedor']."', archivoCotizacion='".$url12."', estatus=2 where idCotizacion=".$arrayDatos['idCotizacion']."";
$crea=mysqli_query($con,$query);

// creo la consulta para conocer el nombre del proveedor
$sql1 = "SELECT r.nombreComercial 
FROM solicitudcotizaciones sc
INNER JOIN registros r ON r.idRegistro=sc.idProveedor
where sc.idCotizacion=".$arrayDatos['idCotizacion']."";
$res=mysqli_query($con, $sql1);
$registros=mysqli_fetch_array($res);
$nombreComercial=$registros['nombreComercial'];

// cambio estatus de servicio
$actualizaMontoServicio = "UPDATE servicios SET estatus=12 where idServicio=$idServicio";
$resactualizamontoservicio=mysqli_query($con, $actualizaMontoServicio);

            $number = count($_POST["nombre"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["nombre"][$i]!= ''))
            {
                $listamedicamentos.='';
                $monto=$_POST["costo"][$i];
                $monto = str_replace( ',', '', $monto );
                $monto = str_replace( '$', '', $monto );
                $monto2=$_POST["costototal"][$i];
                $monto2 = str_replace( ',', '', $monto2 );
                $monto2 = str_replace( '$', '', $monto2 );
                $existencias=$_POST["existencias"][$i];
                // Actualizamos el precio y la fecha de los medicamentos del proveedor
                // $sql1 = "UPDATE solicitudcotizacionesmedicamentos SET costo='".$_POST["costo"][$i]."', costototal='".$_POST['costototal'][$i]."', existencias='".$_POST['existencias'][$i]."', estatus=2 where idMedicamentoSolicitud=".$_POST["idMedicamentoSolicitud"][$i]."";
                // mysqli_query($con, $sql1);

                $queryMed="SELECT * from medicamentossolicitados where idMedicamento=". $_POST["idMedicamento"][$i]." ";
                $resMed=mysqli_query($con,$queryMed);
                $extraidoMed=mysqli_fetch_array($resMed);
                $medicamento=$extraidoMed['medicamento'];                

                // agrego los costos de los medicamentos a la cotizacion del proveedor
                $sql12 = "INSERT INTO solicitudcotizacionesmedicamentos (idCotizacion,idProductoSolicitud,costo,costototal,existencias,estatus) values (".$arrayDatos['idCotizacion'].",".$_POST['idMedicamento'][$i].",'".$monto."','".$monto2."','".$_POST['existencias'][$i]."',1)";
                mysqli_query($con, $sql12);
                $listamedicamentos.=$medicamento." - $".$monto." - $".$monto2." - ".$existencias." || ";

            }
            }
            }

//agrego nota automatica de respuesta
$insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'PROVEEDOR ".$nombreComercial." RESPONDE COTIZACION: ".strtoupper($listamedicamentos)."','".$hoy."',1)";
mysqli_query($con,$insertarNota);

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "reporteSolicitudCotizaciones?do=2";
        </script> 
        <?php } else { 
            if ($proveedor=='no'){
            ?>
        <script type="text/javascript">
             window.location="reporteSolicitudCotizacionesEmpodera?do=1";
        </script>
        <?php } else { ?>
            <script type="text/javascript">
             window.location="reporteSolicitudCotizaciones?do=1";
        </script>
        <?php } }
}




// funcion para actualizar los datos de cotizacion Extemporanea
function responderCotizacionExt() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
$proveedor=$arrayDatos['proveedor'];

function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigoP=generarCodigo(8);


$archivo = $_FILES['archivo'];
$nombreArchivo='-SOL-COT-'.$arrayDatos['idCotizacion'].'-cotizacionrespuesta-'.$codigoP;
$codigo=$archivo['name'];
$url12 ='documentosempodera/cotizacionesproveedor/'.$archivo['name'];
$extension = end(explode(".", $_FILES['archivo']['name']));
if ($extension!='') {
$url12 ='documentosempodera/cotizacionesproveedor/'.$nombreArchivo.'.'.$extension;
move_uploaded_file($archivo['tmp_name'], $url12);
 } else {
    $url12='';
 }

$idServicio=$arrayDatos['idServicio'];
// actualizo la solicitud de cotizacion y cambio estatus de cotizacion
$query="UPDATE solicitudcotizaciones SET fechaRespuesta='".$arrayDatos['fechaRespuesta']."', fechaEntrega='".$arrayDatos['fechaEntrega']."', comentariosProveedor='".$arrayDatos['comentariosProveedor']."', archivoCotizacion='".$url12."', estatus=15 where idCotizacion=".$arrayDatos['idCotizacion']."";
$crea=mysqli_query($con,$query);

// creo la consulta para conocer el nombre del proveedor
$sql1 = "SELECT r.nombreComercial 
FROM solicitudcotizaciones sc
INNER JOIN registros r ON r.idRegistro=sc.idProveedor
where sc.idCotizacion=".$arrayDatos['idCotizacion']."";
$res=mysqli_query($con, $sql1);
$registros=mysqli_fetch_array($res);
$nombreComercial=$registros['nombreComercial'];

//agrego nota automatica de respuesta
$insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'PROVEEDOR ".$nombreComercial." RESPONDE COTIZACION EXTEMPORANEA','".$hoy."',1)";
mysqli_query($con,$insertarNota);

            $number = count($_POST["nombre"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["nombre"][$i]!= ''))
            {
                $monto=$_POST["costo"][$i];
                $monto = str_replace( ',', '', $monto );
                $monto = str_replace( '$', '', $monto );
                $monto2=$_POST["costototal"][$i];
                $monto2 = str_replace( ',', '', $monto2 );
                $monto2 = str_replace( '$', '', $monto2 );

                // se agregan los costos de los medicamentos del proveedor
                $sql12 = "INSERT INTO solicitudcotizacionesmedicamentos (idCotizacion,idProductoSolicitud,costo,costototal,existencias,estatus) values (".$arrayDatos['idCotizacion'].",".$_POST['idMedicamento'][$i].",'".$monto."','".$monto2."','".$_POST['existencias'][$i]."',1)";
                mysqli_query($con, $sql12);

            }
            }
            }

        if (!$crea) { ?>
        <script type="text/javascript">
             window.location = "reporteSolicitudCotizaciones?do=2";
        </script> 
        <?php } else { 
            if ($proveedor=='no'){
            ?>
        <script type="text/javascript">
             window.location="reporteSolicitudCotizacionesEmpodera?do=1";
        </script>
        <?php } else { ?>
            <script type="text/javascript">
             window.location="reporteSolicitudCotizaciones?do=1";
        </script>
        <?php } }
}





// funcion para actualizar los datos de cotizacion por parte de Empodera
function responderCotizacionEmpodera() {
$con=conexion();
$arrayDatos = $this->GETPOST();
$idUsuario=$_SESSION['idUsuario'];
// print_r($_POST);
$hoy=date('Y-m-d H:i:s');

$idServicio=$arrayDatos['idServicio'];
//actualizo el estatus del servicio
$queryActualizaServicio = "UPDATE servicios SET estatus=8 where idServicio=$idServicio";
mysqli_query($con,$queryActualizaServicio);

            // actualizo cuales fueron los medicamentos elegidos
            $number = count($_POST["activar"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["activar"][$i]!= ''))
            { 
                $sql1 = "UPDATE solicitudcotizacionesmedicamentos SET elegido=1, estatus=3 where idMedicamentoSolicitud=".$_POST["activar"][$i]."";
               $crea= mysqli_query($con, $sql1);
            }
            }
            }

            // actualizo las solicitudes de cotizacion y tambien las solicitud de medicamentos a estatus3
            $number2 = count($_POST["idCotizacion"]);
            if($number2 >= 1)
            {
            for($i=0; $i<$number2; $i++)
            {
            if(trim($_POST["idCotizacion"][$i]!= ''))
            { 
                /*$sql1 = "UPDATE solicitudcotizacionesmedicamentos SET estatus=3 where idCotizacion=".$_POST["idCotizacion"][$i]."";
                mysqli_query($con, $sql1);*/
                $sql11 = "UPDATE solicitudcotizaciones SET fechaEleccion='".$hoy."', eleccionPor='".$_POST["tipoeleccion"][$i]."', idUsuarioEligio=".$idUsuario.", estatus=3  where idCotizacion=".$_POST["idCotizacion"][$i]."";
                mysqli_query($con, $sql11);
                $sql12 = "UPDATE solicitudmedicamentos SET estatus=3  where idSolicitudMedicamentos=".$arrayDatos['idSolicitudMedicamentos']."";
                mysqli_query($con, $sql12);
            }
            }
            }

        // pasos para generar la asignacion del servicio de medicamentos en tabla servicioscerradosproveedor
        $array=$_POST["activar"];
        if ($_POST["activar"]!=''){
        $separado = implode(',', $array);
        $sql11 = "SELECT s.folioEmpodera, sc.idProveedor,  sum(scm.costototal) total, sm.idServicio, sm.idBeneficiario FROM solicitudcotizacionesmedicamentos scm
                   INNER JOIN solicitudcotizaciones sc ON sc.idCotizacion=scm.idCotizacion
                   inner join solicitudmedicamentos sm ON sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                   inner join servicios s ON s.idServicio=sm.idServicio
                   where scm.idMedicamentoSolicitud in (".$separado.") GROUP BY sc.idProveedor order by total DESC";
        $ress=mysqli_query($con, $sql11);
        $registros1=mysqli_fetch_array($ress);
        $idProveedor=$registros1['idProveedor'];
        $servicioprincipal=$registros1['idServicio'];
        $idServicio=$registros1['idServicio'];
        $folioServicio=$registros1['folioEmpodera'];
        $idServiciop=$registros1['idServicio'];
        $idBeneficiario=$registros1['idBeneficiario'];
        $montoservicio=$registros1['total'];
        $mensaje='MEDICAMENTOS PRINCIPALES';
        
        $siglas="EMP-";
        // obtengo el rfc del proveedor
        $query="SELECT * FROM registros where idRegistro=$idProveedor";
        $res = mysqli_query($con,$query);
        $registro = mysqli_fetch_array($res);
        $rfcCedula=$registro['rfcCedula'];
        $nombreComercial=$registro['nombreComercial'];
        $siglasProveedor=substr($rfcCedula,0,3);
        $folioUnico=$siglas.''.$folioServicio.'-'.$siglasProveedor;

        // creo la nota de solicitud de medicamentos
        $insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta,estatus) VALUES (".$idServicio.",".$idUsuario.",'SE ASIGNA PROVEEDOR AL SERVICIO // ".$nombreComercial."','".$hoy."',1)";
        mysqli_query($con,$insertarNota);

        // inserto el proveedor al servicio
        $sql1 = "INSERT INTO servicioscerradosproveedor (folioCierre, idServicio, idBeneficiario, fechaAsignacion, fechaServicio, proveedorname, contenidonota, idUsuario, fechaRegistro, estatus) 
        VALUES
        ('".$folioUnico."',".$idServicio.",".$idBeneficiario.",'".$hoy."','".$hoy."',".$idProveedor.",'".$mensaje."',".$idUsuario.",'".$hoy."',1)";
        $crea=mysqli_query($con, $sql1);

        // creo la orden de compra
        $query23="INSERT INTO ordenesdecompra (idServicio, idBeneficiario, idProveedor,fechaAlta, estatus)
        values 
        ( ".$idServicio.", ".$idBeneficiario.", ".$idProveedor." , '" . $hoy ."', 1)";
        $creados=mysqli_query($con,$query23);

        // creo consulta para elegir el proveedor principal
        $sql11 = "SELECT sc.idProveedor,  sum(scm.costototal) total2, sm.idServicio, sm.idBeneficiario FROM solicitudcotizacionesmedicamentos scm
                   INNER JOIN solicitudcotizaciones sc ON sc.idCotizacion=scm.idCotizacion
                   inner join solicitudmedicamentos sm ON sm.idSolicitudMedicamentos=sc.idSolicitudMedicamentos
                   where scm.idMedicamentoSolicitud in (".$separado.") and sc.idProveedor!=$idProveedor GROUP BY sc.idProveedor order by total2 DESC";
        $ress=mysqli_query($con, $sql11);
        $registros1=mysqli_fetch_array($ress);
        $idProveedor2=$registros1['idProveedor'];
        $montoservicio2=$registros1['total2'];

        // ACTUALIZO EL MONTO PARA EL SERVICIO PRINCIPAL
        $actualizaMontoServicio = "UPDATE servicios SET monto=$montoservicio where idServicio=$idServicio";
        $resactualizamontoservicio=mysqli_query($con, $actualizaMontoServicio);
        }
        
        // consulto el servicio para obtener los folios
        $sqlServicio = "SELECT * FROM servicios where idServicio=$idServicio";
        $resservicio=mysqli_query($con, $sqlServicio);
        $registrosServicios=mysqli_fetch_array($resservicio);
        $folioEmpodera=$registrosServicios['folioEmpodera'];
        $folioServicio=$registrosServicios['folioServicio'];
        $idCuenta=$registrosServicios['idCuenta'];

        // creo el folioEmpodera del servicio nuevo
        $queryM = "SELECT * from servicios ORDER BY idServicio DESC";
        $result = mysqli_query($con,$queryM);
        $extraido= mysqli_fetch_array($result);
        $idServicio=$extraido['idServicio'];        
        $idServicio=$idServicio+1;
        if ($idServicio>=0 && $idServicio<=9) {$ceros='00000';}
        if ($idServicio>=10 && $idServicio<=99) {$ceros='0000';}
        if ($idServicio>=100 && $idServicio<=999) {$ceros='000';} 
        if ($idServicio>=1000 && $idServicio<=9999) {$ceros='00';}
        if ($idServicio>=10000 && $idServicio<=99999) {$ceros='0';} 
        $ano=date('Y');
        $anonumeros=substr($ano,2, 2);
        $folioEmpoderaReg=$anonumeros.''.$ceros.''.$idServicio;

        // creo el nuevo servicio complementario
        echo $queryServic="INSERT INTO servicios (folioServicio, idCuenta,folioEmpodera, idBeneficiario, servicio, observaciones, monto, fechaAlta, idUsuario, servicioprincipal,  estatus)
        values 
        ('" . $folioServicio ."'," . $idCuenta .",'" . $folioEmpoderaReg ."'," . $idBeneficiario .",'MEDICAMENTOS','SERVICIO COMPLEMENTARIO DEL FOLIO ".$folioEmpodera." '," . $montoservicio2 .",'" . $hoy ."',". $idUsuario .",". $idServiciop .",1)";
        $creaServicio=mysqli_query($con,$queryServic);        

        // consulto el servicio agregado para ingresarlo despues al proveedor
        $queryM = "SELECT * from servicios ORDER BY idServicio DESC";
        $result = mysqli_query($con,$queryM);
        $extraido= mysqli_fetch_array($result);
        $idServicio2=$extraido['idServicio'];
        $folioEmpoderaCierre=$extraido['folioEmpodera'];
        // creo el folio unico de cierre
        // $folioServicio=$folioServicio;
        $siglas="EMP-";
        // obtengo el rfc del proveedor
        $query="SELECT * FROM registros where idRegistro=$idProveedor2";
        $res = mysqli_query($con,$query);
        $registro = mysqli_fetch_array($res);
        $rfcCedula=$registro['rfcCedula'];
        $nombreComercial2=$registro['nombreComercial'];
        $siglasProveedor=substr($rfcCedula,0,3);
        // Creo el folio unico del servicio para carta
        $folioUnico=$siglas.''.$folioEmpoderaCierre.'-'.$siglasProveedor;
        if ($nombreComercial2!='') {
        $insertarNota="INSERT INTO notasautomaticas (idServicio,idUsuario,nota,fechaAlta) VALUES (".$idServicio.",".$idUsuario.",'SE ASIGNA PROVEEDOR AL SERVICIO // ".$nombreComercial2."','".$hoy."')";
        mysqli_query($con,$insertarNota);
        }
        // asigno el proveedor al servicio complememtario
        $mensaje2='MEDICAMENTOS COMPLEMENTARIOS';
        $sql11 = "INSERT INTO servicioscerradosproveedor (folioCierre, idServicio, idBeneficiario, fechaAsignacion, fechaServicio, proveedorname, contenidonota, idUsuario, fechaRegistro, estatus) 
        VALUES
        ('".$folioUnico."',".$idServicio2.",".$idBeneficiario.",'".$hoy."','".$hoy."',".$idProveedor2.",'".$mensaje2."',".$idUsuario.",'".$hoy."',1)";
        $creaServicio2=mysqli_query($con, $sql11);


        // aqui inicia el proceso de recotizacion
        $number1 = count($_POST["recotizar"]);
        if ($number1 >= 1) {

        // creo el nuevo servicio complementario
        $queryServic="INSERT INTO servicios (folioServicio,idCuenta, folioEmpodera, idBeneficiario, servicio, observaciones, monto, fechaAlta, idUsuario, servicioprincipal,  estatus)
        values 
        ('" . $folioServicio ."'," . $idCuenta .",'" . $folioEmpoderaReg ."'," . $idBeneficiario .",'MEDICAMENTOS','SERVICIO PARA RECOTIZAR EL FOLIO ".$folioEmpodera." ',0,'" . $hoy ."',". $idUsuario .",". $idServiciop .",1)";
        $creaServicio=mysqli_query($con,$queryServic);
        
        // consulto el servicio agregado para ingresarlo despues a la solicitud de medicamentos
        $queryM = "SELECT * from servicios ORDER BY idServicio DESC LIMIT 1";
        $result = mysqli_query($con,$queryM);
        $extraido= mysqli_fetch_array($result);
        $idServicio2=$extraido['idServicio'];

     // consulto los datos para ingresa la solicitud de medicamentos nueva
        $queryM = "SELECT ms.medicamento, ms.gramaje, ms.presentacion, ms.cantidad, ms.fechaTermina, sm.entidadFederativa, sm.municipioDelegacion, sm.calle, sm.noExteriorInterior, sm.colonia, sm.codigoPostal, sm.telefonoBeneficiario, sm.nombreRecibe, sm.telefonoRecibe, sm.referencias, sm.recetaArchivo, sm.confrimaciondatos, sm.idUsuario, sm.folioSolicitud
        from medicamentossolicitados ms 
        INNER JOIN solicitudmedicamentos sm ON sm.idSolicitudMedicamentos=ms.idSolicitudMedicamento
        where sm.idServicio=".$servicioprincipal."";
        $result = mysqli_query($con,$queryM);
        $extraido= mysqli_fetch_array($result);
        $medicamento=$extraido['medicamento'];
        $gramaje=$extraido['gramaje'];
        $presentacion=$extraido['presentacion'];
        $cantidad=$extraido['cantidad'];
        $fechaTermina=$extraido['fechaTermina'];

        $queryDatos="INSERT INTO solicitudmedicamentos (folioSolicitud, idBeneficiario, idServicio, fechaSolicitud, entidadFederativa, municipioDelegacion, calle, noExteriorInterior, colonia, codigoPostal, telefonoBeneficiario, nombreRecibe, telefonoRecibe, referencias, recetaArchivo, confrimaciondatos, idUsuario, fechaCargo, estatus)
        values 
        ('".$extraido['folioSolicitud']."', " . $idBeneficiario ."," . $idServicio2 .",'" . $hoy ."', ".$extraido['entidadFederativa'].", ".$extraido['municipioDelegacion'].",'".$extraido['calle']."', '".$extraido['noExteriorInterior']."', '".$extraido['colonia']."', '".$extraido['codigoPostal']."', '".$extraido['telefonoBeneficiario']."', '".$extraido['nombreRecibe']."', '".$extraido['telefonoRecibe']."', '".$extraido['referencias']."', '".$extraido['recetaArchivo']."', '".$extraido['confrimaciondatos']."', ".$extraido['idUsuario'].", '" . $hoy ."', 1)";
           $creaSolicitud=mysqli_query($con,$queryDatos);

        // consulto la ultima solicitud agregada
        $queryM = "SELECT * from solicitudmedicamentos ORDER BY idSolicitudMedicamentos DESC LIMIT 1";
        $result = mysqli_query($con,$queryM);
        $extraido= mysqli_fetch_array($result);
        $idSolicitudMedicamentos11=$extraido['idSolicitudMedicamentos'];

        

            for($i=0; $i<$number1; $i++)
            {
            if($_POST["recotizar"][$i]!='')
            { 
        $queryM = "SELECT ms.medicamento, ms.gramaje, ms.presentacion, ms.cantidad, ms.fechaTermina, sm.entidadFederativa, sm.municipioDelegacion, sm.calle, sm.noExteriorInterior, sm.colonia, sm.codigoPostal, sm.telefonoBeneficiario, sm.nombreRecibe, sm.telefonoRecibe, sm.referencias, sm.recetaArchivo, sm.confrimaciondatos, sm.idUsuario, sm.folioSolicitud
        from medicamentossolicitados ms 
        INNER JOIN solicitudmedicamentos sm ON sm.idSolicitudMedicamentos=ms.idSolicitudMedicamento
        where ms.idMedicamento=".$_POST["recotizar"][$i]."";
        $result = mysqli_query($con,$queryM);
        $extraido= mysqli_fetch_array($result);
        $medicamento=$extraido['medicamento'];
        $gramaje=$extraido['gramaje'];
        $presentacion=$extraido['presentacion'];
        $cantidad=$extraido['cantidad'];
        $fechaTermina=$extraido['fechaTermina'];

        $queryMedicinas="INSERT INTO medicamentossolicitados (idSolicitudMedicamento, medicamento, gramaje, presentacion, cantidad, fechaTermina, estatus)
        values 
        (" . $idSolicitudMedicamentos11 .", '" . $medicamento ."', '" . $gramaje ."', '" . $presentacion ."', '" . $cantidad ."', '" . $fechaTermina ."', 1)";
           $creasss=mysqli_query($con,$queryMedicinas);

            }
            }

            }

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "reporteCotizacionesPorBeneficiario?do=2";
        </script> 
        <?php } else { 
            if (!$creasss) {
            ?>
            <script type="text/javascript">
            window.location="reporteCotizacionesPorBeneficiario?do=3";                 
            </script>
            <?php } else { ?>
            <script type="text/javascript">
            window.location="solicitudMedicamentosCotizacion?id=<?php echo $idSolicitudMedicamentos11 ?>";
            </script>
            
            <?php } }
}


function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('responderCotizacion', $_POST)) {
                $datos_getpost['responderCotizacion'] = $_POST['responderCotizacion'];
            }
            
            if (array_key_exists('fechaRespuesta', $_POST)) {
                $datos_getpost['fechaRespuesta'] = $_POST['fechaRespuesta'];
            }
            if (array_key_exists('idCotizacion', $_POST)) {
                $datos_getpost['idCotizacion'] = $_POST['idCotizacion'];
            }
            if (array_key_exists('idServicio', $_POST)) {
                $datos_getpost['idServicio'] = $_POST['idServicio'];
            }
            if (array_key_exists('fechaEntrega', $_POST)) {
                $datos_getpost['fechaEntrega'] = $_POST['fechaEntrega'];
            }
            if (array_key_exists('comentariosProveedor', $_POST)) {
                $datos_getpost['comentariosProveedor'] = $_POST['comentariosProveedor'];
            }
            if (array_key_exists('idSolicitudMedicamentos', $_POST)) {
                $datos_getpost['idSolicitudMedicamentos'] = $_POST['idSolicitudMedicamentos'];
            }
            if (array_key_exists('proveedor', $_POST)) {
                $datos_getpost['proveedor'] = $_POST['proveedor'];
            }
                      
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>