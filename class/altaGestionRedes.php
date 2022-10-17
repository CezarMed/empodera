<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaGestion_class {
function accionesGestion() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaGestionRedes', $datosCmb)) {
         $resp= $this->altaGestion();
    }
    if (array_key_exists('actualizaGestionRedes', $datosCmb)) {
         $resp= $this->actualizaGestion();
    }        
}

// funcion para dar de alta registro
function altaGestion() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
$regimen=$arrayDatos['tipoRegimen'];
$tipoRegistro=$arrayDatos['tipoRegistro'];
$rfc=$arrayDatos['rfcCedula'];
$resultado = substr("$rfc",0, 3); // otengo solo las 3 primeras letras del RFC
$tipoSucursal=$arrayDatos['tipoSucursal'];
if ($tipoSucursal=='') {$tipoSucursal="SS";}
//para las letreas del estado
$entidadFederativa=$arrayDatos['entidadFederativa'];
if ($entidadFederativa=='') {$abrevEstado="XX";}
if ($entidadFederativa!='') {
$query = 'SELECT abrevEstado from estados where clave='.$entidadFederativa;
$res = mysqli_query($con,$query);
$extraido= mysqli_fetch_array($res);
$abrevEstado=$extraido['abrevEstado']; // obtengo el codigo del estado
}
//acaba el estado

//inicia el municipio
if ($entidadFederativa=='') { $nombreFinalNum="Y00";}
if ($municipioDelegacion!='') {
$municipioDelegacion=$arrayDatos['municipioDelegacion'];
$query = 'SELECT clave,nombre from municipios where id='.$municipioDelegacion;
$res = mysqli_query($con,$query);
$extraido2= mysqli_fetch_array($res);
$claveMun=$extraido2['clave']; // obtengo la clave del municipio
$nombreMun=$extraido2['nombre'];
$nombreFinalNum = substr("$nombreMun",0, 1); // obtengo la ultima del municipio
}
//acaba el municipio

$noSucursal=$arrayDatos['noSucursal'];
if ($noSucursal=='') { $noSucursal="9999";}

$modoAtencion=$arrayDatos['modoAtencion'];
if ($modoAtencion=='') { $modoAtencion="X";}

$hoy=date('Y-m-d H:i:s');

$noProveedorNew=$regimen.$resultado.$tipoSucursal.$abrevEstado.$nombreFinalNum.$claveMun.$noSucursal.$modoAtencion;
//valido el registro NOPROVEEDOR que no sea duplicado
$municipioDelegacion=$arrayDatos['municipioDelegacion'];

//consulto para saber si existe o no
$query2 = "SELECT noProveedor from registros where noProveedor like '$noProveedorNew%' ORDER BY idRegistro DESC LIMIT 1";
$res2 = mysqli_query($con,$query2);
$extraido22= mysqli_fetch_array($res2);
$noProveedorBD=$extraido22['noProveedor'];

$queryrfc = "SELECT count(*) totalRegistros from registros where rfcCedula='$rfc'";
$resrfc = mysqli_query($con,$queryrfc);
$extraidorrfc= mysqli_fetch_array($resrfc);
$totalRegistros=$extraidorrfc['totalRegistros'];

if ($totalRegistros>=1 and $tipoRegistro==1) { ?>
        <script type="text/javascript">
            window.location = "gestionRedes?do=5&rfc=<?php echo $rfc ?>";
        </script>
<?php  }

if ($noProveedorBD!='') {
$nz=substr("$noProveedorBD",-1);
$s = $nz;
for ($n=0; $n<1; $n++) {
    $letra = ++$s;
    }
} else {
    $letra = 'A';
}

// genero el nuevo $noProveedor con la letra siguiente o bien solo A
$noProveedor=$regimen.$resultado.$tipoSucursal.$abrevEstado.$nombreFinalNum.$claveMun.$noSucursal.$modoAtencion.$letra;

// creo la insercion del registro
$query="INSERT INTO registros (tipoRegimen,rfcCedula,idBanco,cuentaBancaria,cuentaClabe,noProveedor,rfcRepresentante,nombreComercial,nombreLegal,tipoSucursal,situacionProveedor,situacionContrato,modoAtencion,noSucursal,fechaInicioOperaciones,fechaUltimoCambio,entidadFederativa,municipioDelegacion,colonia,tipoVialidad,nombreVialidad,noExterior,noInterior,codigoPostal,email,emailCor,emailDir,telefonoOpe,telefonoCor,telefonoDir,administradorLocal,ejecutivoCuenta,tipoAtencion,fechaAltaRed,tipoRegistro,estatus,idUSuario,fechaHoraAgrego)
        values 
        ('" . $arrayDatos['tipoRegimen'] ."','" . $arrayDatos['rfcCedula'] ."','" . $arrayDatos['idBanco'] ."','" . $arrayDatos['cuentaBancaria'] ."','" . $arrayDatos['cuentaClabe'] ."','$noProveedor','" . $arrayDatos['rfcRepresentante'] ."','" . strtoupper($arrayDatos['nombreComercial']) ."','" . strtoupper($arrayDatos['nombreLegal']) ."','" . $arrayDatos['tipoSucursal'] ."','" . $arrayDatos['situacionProveedor'] ."','" . $arrayDatos['situacionContrato'] ."','" . $arrayDatos['modoAtencion'] ."','" . $arrayDatos['noSucursal'] ."','" . $arrayDatos['fechaInicioOperaciones'] ."','" . $arrayDatos['fechaUltimoCambio'] ."','" . $arrayDatos['entidadFederativa'] ."','" . $arrayDatos['municipioDelegacion'] ."','" . $arrayDatos['colonia'] ."','" . $arrayDatos['tipoVialidad'] ."','" . $arrayDatos['nombreVialidad'] ."','" . $arrayDatos['noExterior'] ."','" . $arrayDatos['noInterior'] ."','" . $arrayDatos['codigoPostal'] ."','" . $arrayDatos['email'] ."','" . $arrayDatos['emailCor'] ."','" . $arrayDatos['emailDir'] ."','" . $arrayDatos['telefonoOpe'] ."','" . $arrayDatos['telefonoCor'] ."','" . $arrayDatos['telefonoDir'] ."','" . $arrayDatos['administradorLocal'] ."','" . $arrayDatos['ejecutivoCuenta'] ."','" . $elecciones ."','" . $arrayDatos['fechaAltaRed'] ."',".$tipoRegistro.",1,".$idUsuario.",'" . $hoy ."')";
		 $crea=mysqli_query($con,$query);

            // consulto el idRegistro agregado
            $queryServicio="SELECT * FROM registros ORDER BY idRegistro DESC LIMIT 1";
                $res=mysqli_query($con,$queryServicio);
                $extraido=mysqli_fetch_array($res);
                $idRegistro=$extraido['idRegistro'];

            // agrego el tipo de atencion
            $number = count($_POST["tipoAtencionValor"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["tipoAtencionValor"][$i]!= ''))
            {   
                $sql1 = "INSERT INTO registrostipoatencion (idRegistro, idAtencion,estatus) VALUES (".$idRegistro.", ".$_POST["tipoAtencionValor"][$i].", ".$_POST["tipoAtencion"][$i].")";
            mysqli_query($con, $sql1);
            }
            }
            }

         if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "gestionRedes?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
            window.location="gestionRedes?do=1&folio=<?php echo $noProveedor; ?>";
        </script>
        <?php } 
        // termina funcion
}


// funcion para actualizar registro
function actualizaGestion() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$hoy=date('Y-m-d H:i:s');
$idRegistro=$arrayDatos['idRegistro'];
$idUsuaio=$_SESSION['idUsuario'];
$regimen=$arrayDatos['tipoRegimen'];
$rfc=$arrayDatos['rfcCedula'];
$resultado = substr("$rfc",0, 3); // otengo solo las 3 primeras letras del RFC
$tipoSucursal=$arrayDatos['tipoSucursal'];
if ($tipoSucursal=='') {$tipoSucursal="SS";}
//para las letreas del estado
$entidadFederativa=$arrayDatos['entidadFederativa'];
if ($entidadFederativa=='') {$abrevEstado="XX";}
if ($entidadFederativa!='') {
$query = 'SELECT abrevEstado from estados where clave='.$entidadFederativa;
$res = mysqli_query($con,$query);
$extraido= mysqli_fetch_array($res);
$abrevEstado=$extraido['abrevEstado']; // obtengo el codigo del estado
}
//acaba el estado

//inicia el municipio
if ($entidadFederativa=='') { $nombreFinalNum="Y00";}
if ($municipioDelegacion!='') {
$municipioDelegacion=$arrayDatos['municipioDelegacion'];
$query = 'SELECT clave,nombre from municipios where id='.$municipioDelegacion;
$res = mysqli_query($con,$query);
$extraido2= mysqli_fetch_array($res);
$claveMun=$extraido2['clave']; // obtengo la clave del municipio
$nombreMun=$extraido2['nombre'];
$nombreFinalNum = substr("$nombreMun",0, 1); // obtengo la ultima del municipio
}
//acaba el municipio

$noSucursal=$arrayDatos['noSucursal'];
if ($noSucursal=='') { $noSucursal="9999";}

$modoAtencion=$arrayDatos['modoAtencion'];
if ($modoAtencion=='') { $modoAtencion="X";}

$hoy=date('Y-m-d H:i:s');

$noProveedorNew=$regimen.$resultado.$tipoSucursal.$abrevEstado.$nombreFinalNum.$claveMun.$noSucursal.$modoAtencion;
//valido el registro NOPROVEEDOR que no sea duplicado
$municipioDelegacion=$arrayDatos['municipioDelegacion'];

//consulto para saber si existe o no
$query2 = "SELECT noProveedor from registros where noProveedor like '$noProveedorNew%' ORDER BY idRegistro DESC LIMIT 1";
$res2 = mysqli_query($con,$query2);
$extraido22= mysqli_fetch_array($res2);
$noProveedorBD=$extraido22['noProveedor'];

if ($noProveedorBD!='') {
$nz=substr("$noProveedorBD",-1);
$s = $nz;
for ($n=0; $n<1; $n++) {
    $letra = ++$s;
    }
} else {
    $letra = 'A';
}

// genero el nuebo $noProveedor con la letra siguiente o bien solo A
$noProveedor=$regimen.$resultado.$tipoSucursal.$abrevEstado.$nombreFinalNum.$claveMun.$noSucursal.$modoAtencion.$letra;

// creo la insercion del registro
echo $query="UPDATE registros SET tipoRegimen='" . $arrayDatos['tipoRegimen'] ."', rfcCedula='" . $arrayDatos['rfcCedula'] ."', idBanco='" . $arrayDatos['idBanco'] ."', cuentaBancaria='" . $arrayDatos['cuentaBancaria'] ."', cuentaClabe='" . $arrayDatos['cuentaClabe'] ."', noProveedor='" . $noProveedor ."s', rfcRepresentante='" . $arrayDatos['rfcRepresentante'] ."', nombreComercial='" . $arrayDatos['nombreComercial'] ."', nombreLegal='" . $arrayDatos['nombreLegal'] ."', tipoSucursal='" . $arrayDatos['tipoSucursal'] ."', situacionProveedor='" . $arrayDatos['situacionProveedor'] ."', situacionContrato='" . $arrayDatos['situacionContrato'] ."', modoAtencion='" . $arrayDatos['modoAtencion'] ."', noSucursal='" . $arrayDatos['noSucursal'] ."', fechaInicioOperaciones='" . $arrayDatos['fechaInicioOperaciones'] ."', fechaUltimoCambio='" . $arrayDatos['fechaUltimoCambio'] ."', entidadFederativa='" . $arrayDatos['entidadFederativa'] ."', municipioDelegacion='" . $arrayDatos['municipioDelegacion'] ."', colonia='" . $arrayDatos['colonia'] ."', tipoVialidad='" . $arrayDatos['tipoVialidad'] ."', nombreVialidad='" . $arrayDatos['nombreVialidad'] ."', noExterior='" . $arrayDatos['noExterior'] ."', noInterior='" . $arrayDatos['noInterior'] ."', codigoPostal='" . $arrayDatos['codigoPostal'] ."', email='" . $arrayDatos['email'] ."', emailCor='" . $arrayDatos['emailCor'] ."', emailDir='" . $arrayDatos['emailDir'] ."', telefonoOpe='" . $arrayDatos['telefonoOpe'] ."', telefonoCor='" . $arrayDatos['telefonoCor'] ."', telefonoDir='" . $arrayDatos['telefonoDir'] ."', administradorLocal='" . $arrayDatos['administradorLocal'] ."', ejecutivoCuenta='" . $arrayDatos['ejecutivoCuenta'] ."', fechaAltaRed='" . $arrayDatos['fechaAltaRed'] ."' where idRegistro=" . $idRegistro ."";
         $crea=mysqli_query($con,$query);

            $number = count($_POST["idTipoAtencion"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["idTipoAtencion"][$i]!= ''))
            {   
                $sql1 = "UPDATE registrostipoatencion SET estatus=".$_POST["tipoAtencion"][$i]." where idRegistroAtencion=".$_POST["idTipoAtencion"][$i]."";
            mysqli_query($con, $sql1);
            }
            }
            }

         if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "editarRegistroRedes?do=2";
            
        </script> 
        <?php } else {
        $queryUpdate="INSERT INTO movimientosregistros (idRegistro,idUsuario,tipoMovimiento,fechaMovimiento)
        values 
        ($idRegistro,$idUsuaio,'ACTUALIZAR','" . $hoy ."')";
         $actualizar=mysqli_query($con,$queryUpdate); 
         ?>
        <script type="text/javascript">
              window.location = "editarRegistroRedes?do=1&id=<?php echo $idRegistro; ?>&folio=<?php echo $noProveedor; ?>";
        </script>
        <?php } 
        // termina funcion
}

function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('tipoRegimen', $_POST)) {
                $datos_getpost['tipoRegimen'] = $_POST['tipoRegimen'];
            }
            if (array_key_exists('tipoRegistro', $_POST)) {
                $datos_getpost['tipoRegistro'] = $_POST['tipoRegistro'];
            }
            if (array_key_exists('altaGestionRedes', $_POST)) {
                $datos_getpost['altaGestionRedes'] = $_POST['altaGestionRedes'];
            }
            if (array_key_exists('idBanco', $_POST)) {
                $datos_getpost['idBanco'] =  $_POST['idBanco'];
            }
            if (array_key_exists('rfcCedula', $_POST)) {
                $datos_getpost['rfcCedula'] = $_POST['rfcCedula'];
            }
            if (array_key_exists('cuentaBancaria', $_POST)) {
                $datos_getpost['cuentaBancaria'] =  $_POST['cuentaBancaria'];
            }
            if (array_key_exists('cuentaClabe', $_POST)) {
                $datos_getpost['cuentaClabe'] =  $_POST['cuentaClabe'];
            }
            if (array_key_exists('rfcRepresentante', $_POST)) {
                $datos_getpost['rfcRepresentante'] =  $_POST['rfcRepresentante'];
            }
            if (array_key_exists('nombreComercial', $_POST)) {
                $datos_getpost['nombreComercial'] =  $_POST['nombreComercial'];
            }
            if (array_key_exists('nombreLegal', $_POST)) {
                $datos_getpost['nombreLegal'] =  $_POST['nombreLegal'];
            }
            if (array_key_exists('tipoSucursal', $_POST)) {
                $datos_getpost['tipoSucursal'] =  $_POST['tipoSucursal'];
            }
            if (array_key_exists('situacionProveedor', $_POST)) {
                $datos_getpost['situacionProveedor'] =  $_POST['situacionProveedor'];
            }
            if (array_key_exists('situacionContrato', $_POST)) {
                $datos_getpost['situacionContrato'] =  $_POST['situacionContrato'];
            }
            if (array_key_exists('modoAtencion', $_POST)) {
                $datos_getpost['modoAtencion'] =  $_POST['modoAtencion'];
            }
            if (array_key_exists('noSucursal', $_POST)) {
                $datos_getpost['noSucursal'] =  $_POST['noSucursal'];
            }
            if (array_key_exists('fechaInicioOperaciones', $_POST)) {
                $datos_getpost['fechaInicioOperaciones'] =  $_POST['fechaInicioOperaciones'];
            }
            if (array_key_exists('fechaUltimoCambio', $_POST)) {
                $datos_getpost['fechaUltimoCambio'] =  $_POST['fechaUltimoCambio'];
            }
            if (array_key_exists('entidadFederativa', $_POST)) {
                $datos_getpost['entidadFederativa'] =  $_POST['entidadFederativa'];
            }
            if (array_key_exists('municipioDelegacion', $_POST)) {
                $datos_getpost['municipioDelegacion'] =  $_POST['municipioDelegacion'];
            }
            if (array_key_exists('colonia', $_POST)) {
                $datos_getpost['colonia'] =  $_POST['colonia'];
            }
            if (array_key_exists('tipoVialidad', $_POST)) {
                $datos_getpost['tipoVialidad'] =  $_POST['tipoVialidad'];
            }
            if (array_key_exists('nombreVialidad', $_POST)) {
                $datos_getpost['nombreVialidad'] =  $_POST['nombreVialidad'];
            }
            if (array_key_exists('noExterior', $_POST)) {
                $datos_getpost['noExterior'] =  $_POST['noExterior'];
            }
            if (array_key_exists('noInterior', $_POST)) {
                $datos_getpost['noInterior'] =  $_POST['noInterior'];
            }
            if (array_key_exists('codigoPostal', $_POST)) {
                $datos_getpost['codigoPostal'] =  $_POST['codigoPostal'];
            }
            if (array_key_exists('email', $_POST)) {
                $datos_getpost['email'] =  $_POST['email'];
            }
            if (array_key_exists('emailCor', $_POST)) {
                $datos_getpost['emailCor'] =  $_POST['emailCor'];
            }
            if (array_key_exists('emailDir', $_POST)) {
                $datos_getpost['emailDir'] =  $_POST['emailDir'];
            }
            if (array_key_exists('telefonoOpe', $_POST)) {
                $datos_getpost['telefonoOpe'] =  $_POST['telefonoOpe'];
            }
            if (array_key_exists('telefonoDir', $_POST)) {
                $datos_getpost['telefonoDir'] =  $_POST['telefonoDir'];
            }
            if (array_key_exists('telefonoCor', $_POST)) {
                $datos_getpost['telefonoCor'] =  $_POST['telefonoCor'];
            }
            if (array_key_exists('administradorLocal', $_POST)) {
                $datos_getpost['administradorLocal'] =  $_POST['administradorLocal'];
            }
            if (array_key_exists('ejecutivoCuenta', $_POST)) {
                $datos_getpost['ejecutivoCuenta'] =  $_POST['ejecutivoCuenta'];
            }
            if (array_key_exists('fechaAltaRed', $_POST)) {
                $datos_getpost['fechaAltaRed'] =  $_POST['fechaAltaRed'];
            }
            if (array_key_exists('idRegistro', $_POST)) {
                $datos_getpost['idRegistro'] =  $_POST['idRegistro'];
            }
            if (array_key_exists('tipoAtencion', $_POST)) {
                $datos_getpost['tipoAtencion'] =  $_POST['tipoAtencion'];
            }
            
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>