<?php
date_default_timezone_set ('America/Mexico_City');
@session_start();
require_once ('conexion.php');
class AltaCliente_class {

function accionesCliente() {
    //arreglo
    $datosCmb = $this->GETPOST();
    //llamar las funciones 
    if (array_key_exists('altaCliente', $datosCmb)) {
         $resp= $this->altaCliente();
    }
    if (array_key_exists('editaCliente', $datosCmb)) {
         $resp= $this->editaCliente();
    }
}

// funcion para dar de alta registro
function altaCliente() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
// print_r($_POST);
function generarCodigo($longitud) {
$key = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
$max = strlen($pattern)-1;
for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
return $key;
}
$codigo=generarCodigo(8);

$query="INSERT INTO clientes (codigoCliente,nombreCliente,situacionCliente,entidadFederativa,municipioDelegacion,direccionCompleta,codigoPostal,idUsuarioAgrego,fechaAlta,estatus)
        values 
        ('" . $codigo ."','" . $arrayDatos['nombreCliente'] ."'," . $arrayDatos['situacionCliente'] ."," . $arrayDatos['entidadFederativa'] ."," . $arrayDatos['municipioDelegacion'] .",'" . $arrayDatos['direccionCompleta'] ."','" . $arrayDatos['codigoPostal'] ."',". $idUsuario .",'" . $hoy ."',1)";
		    $crea=mysqli_query($con,$query);

            // obtengo id de cliente agregado            
            $queryM = "SELECT idCliente from clientes where codigoCliente='$codigo'";
            $result = mysqli_query($con,$queryM);
            $extraido= mysqli_fetch_array($result);
            $idCliente=$extraido['idCliente'];

            // agrego los numeros adicionales y email
            $number = count($_POST["telefono"]);
            if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["telefono"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sqlTelefonos = "INSERT INTO telefonosclientes (idCliente,  telefono, email, estatus) VALUES(".$idCliente.",'".$_POST["telefono"][$i]."','".$_POST["email"][$i]."',1)";
                    mysqli_query($con, $sqlTelefonos);
            }
            }
            }
            

            // inserto los gru´pos y subgrupos
            $number = count($_POST["montoautorizadocliente"]);
            if($number>=1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["montoautorizadocliente"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO montosclientes (idCliente, nombreAcuerdo, subgrupo, montoautorizadocliente, contribucion, copago, estatus) VALUES(".$idCliente.",'".$_POST["programa"][$i]."','".$_POST["subgrupo"][$i]."','".$_POST["montoautorizadocliente"][$i]."','".$_POST["contribucion"][$i]."','".$_POST["copago"][$i]."',1)";
                mysqli_query($con, $sql1);
            }
            }
            }




            $query="INSERT INTO datosfacturacioncliente (idCliente, razonSocial, rfc, direccion, cp, entidadFederativa, municipioDelegacion, regimen)
        values 
        ('" . $idCliente ."', '" . $arrayDatos['razonSocial'] ."', '" . $arrayDatos['rfc'] ."', '" . $arrayDatos['direccionCompleta2'] ."', '" . $arrayDatos['codigoPostal2'] ."', " . $arrayDatos['entidadFederativa2'] .", " . $arrayDatos['municipioDelegacion2'] .",  '" . $arrayDatos['tipoRegimen'] ."')";
            $crea=mysqli_query($con,$query);

        if (!$crea) { ?>
        <script type="text/javascript">
           window.location = "altaCliente?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
           window.location="altaCliente?do=1&folioCliente=<?php echo $codigo ?>";
        </script>
        <?php }
}


// funcion para dar de alta registro
function editaCliente() {
$con=conexion();
$arrayDatos = $this->GETPOST();
// creo el numero de proveedor
$idUsuario=$_SESSION['idUsuario'];
$hoy=date('Y-m-d H:i:s');
// print_r($_POST);
$idCliente=$arrayDatos['idCliente'];

// si cambia el nombre del cliente
if($arrayDatos['nombreCliente']!=$arrayDatos['nombreClienteAnt']){
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL NOMBRE DE ".$arrayDatos['nombreClienteAnt']." A ".$arrayDatos['nombreCliente']."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}     
// si cambia el estatus
if($arrayDatos['situacionCliente']!=$arrayDatos['situacionClienteAnt']){
if ($arrayDatos['situacionCliente']==1){$estatus='ACTIVO';} else {$estatus='INACTIVO';} 
if ($arrayDatos['situacionClienteAnt']==1){$estatusAnt='ACTIVO';} else {$estatusAnt='INACTIVO';}    
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL ESTATUS DE ".$estatusAnt." A ".$estatus."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}  
// si cambia el estado de la republica
if($arrayDatos['entidadFederativa']!=$arrayDatos['entidadFederativaAnt']){
$queryM = "SELECT * from estados where clave='".$arrayDatos['entidadFederativa']."'";
$result = mysqli_query($con,$queryM);
$extraido= mysqli_fetch_array($result);
$nombreEstado=$extraido['nombreEstado']; 
$queryM = "SELECT * from estados where idEstado=".$arrayDatos['entidadFederativaAnt']."";
$result = mysqli_query($con,$queryM);
$extraido= mysqli_fetch_array($result);
$nombreEstadoAnt=$extraido['nombreEstado']; 
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL ESTADO DE ".$nombreEstadoAnt." A ".$nombreEstado."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}
// si cambia el municipio
if($arrayDatos['municipioDelegacion']!=$arrayDatos['municipioDelegacionAnt']){
$queryM = "SELECT * from municipios where id='".$arrayDatos['municipioDelegacion']."'";
$result = mysqli_query($con,$queryM);
$extraido= mysqli_fetch_array($result);
$nombreMunicipio=$extraido['nombre']; 
$queryM = "SELECT * from municipios where id=".$arrayDatos['municipioDelegacionAnt']."";
$result = mysqli_query($con,$queryM);
$extraido= mysqli_fetch_array($result);
$nombreMunicipioAnt=$extraido['nombre']; 
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL MUNICIPIO DE ".$nombreMunicipioAnt." A ".$nombreMunicipio."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}       
// si cambia la direccion
if($arrayDatos['direccionCompleta']!=$arrayDatos['direccionCompletaAnt']){
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA LA DIRECCION ANTERIOR ".$arrayDatos['direccionCompletaAnt']." POR ".$arrayDatos['direccionCompleta']."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
} 
// si cambia el codigo postal
if($arrayDatos['codigoPostal']!=$arrayDatos['codigoPostalAnt']){
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL CODIGO POSTAL ANTERIOR ".$arrayDatos['codigoPostalAnt']." POR ".$arrayDatos['codigoPostal']."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
} 

/* SI SE MODIFICAN LOS DATOS DE TELEFONO Y EMAIL */
$number = count($_POST["idTelefono"]);
if($number>=1)
  {
    for($i=0; $i<$number; $i++)
       {
         if(trim($_POST["idTelefono"][$i]!= ''))
           {
               // Actualizo los telefonos y emails
    $sqltelefonos = "UPDATE telefonosclientes SET telefono='".$_POST["telefonox"][$i]."', email='".$_POST["emailx"][$i]."' WHERE idTelefono=".$_POST["idTelefono"][$i]." ";
    mysqli_query($con, $sqltelefonos);
           }
       }
  }

// agrego los numeros adicionales y email
$number = count($_POST["telefono"]);
if($number >= 1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["telefono"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sqlTelefonosAd = "INSERT INTO telefonosclientes (idCliente,  telefono, email, estatus) VALUES(".$idCliente.",'".$_POST["telefono"][$i]."','".$_POST["email"][$i]."',1)";
                    mysqli_query($con, $sqlTelefonosAd);
            }
            }
            }



/* AQUI INICIAN LOS DATOS DE LA FACTURACION */ 
// si cambia la razon social
if($arrayDatos['razonSocial']!=$arrayDatos['razonSocialAnt']){
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA LA RAZON SOCIAL ".$arrayDatos['razonSocialAnt']." POR ".$arrayDatos['razonSocial']."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}
// si cambia el RFC
if($arrayDatos['rfc']!=$arrayDatos['rfcAnt']) {
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL RFC ".$arrayDatos['rfcAnt']." POR ".$arrayDatos['rfc']."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}
// si cambia el estado de la republica en facturacion
if($arrayDatos['entidadFederativa2']!=$arrayDatos['entidadFederativa2Ant']){
$queryM = "SELECT * from estados where clave='".$arrayDatos['entidadFederativa2']."'";
$result = mysqli_query($con,$queryM);
$extraido= mysqli_fetch_array($result);
$nombreEstado2=$extraido['nombreEstado']; 
$queryM = "SELECT * from estados where idEstado=".$arrayDatos['entidadFederativa2Ant']."";
$result = mysqli_query($con,$queryM);
$extraido= mysqli_fetch_array($result);
$nombreEstadoAnt2=$extraido['nombreEstado']; 
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL ESTADO DE FACTURACION DE ".$nombreEstadoAnt2." A ".$nombreEstado2."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}
// si cambia el municipio del facturacion
if($arrayDatos['municipioDelegacion2']!=$arrayDatos['municipioDelegacion2Ant']){
$queryM = "SELECT * from municipios where id='".$arrayDatos['municipioDelegacion2']."'";
$result = mysqli_query($con,$queryM);
$extraido= mysqli_fetch_array($result);
$nombreMunicipio2=$extraido['nombre']; 
$queryM = "SELECT * from municipios where id=".$arrayDatos['municipioDelegacion2Ant']."";
$result = mysqli_query($con,$queryM);
$extraido2= mysqli_fetch_array($result);
$nombreMunicipioAnt2=$extraido2['nombre']; 
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL MUNICIPIO DE ".$nombreMunicipioAnt2." A ".$nombreMunicipio2."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
} 
// si cambia la direccion de facturacion
if($arrayDatos['direccionCompleta2']!=$arrayDatos['direccionCompleta2Ant']) {
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA LA DIRECCION DE FACTURACION ".$arrayDatos['direccionCompleta2Ant']." POR ".$arrayDatos['direccionCompleta2']."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
}
// si cambia el codigo postal de la facturacion
if($arrayDatos['codigoPostal2']!=$arrayDatos['codigoPostal2Ant']){
$SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE CAMBIA EL CODIGO POSTAL DE FACTURACION ANTERIOR ".$arrayDatos['codigoPostal2Ant']." POR ".$arrayDatos['codigoPostal2']."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
} 



 $update="UPDATE clientes set nombreCliente='".$arrayDatos['nombreCliente']."', situacionCliente=".$arrayDatos['situacionCliente'].", entidadFederativa=".$arrayDatos['entidadFederativa'].", municipioDelegacion=".$arrayDatos['municipioDelegacion'].", direccionCompleta='".$arrayDatos['direccionCompleta']."', codigoPostal='".$arrayDatos['codigoPostal']."', telefonoCliente='".$arrayDatos['telefonoCliente']."', emailCliente='".$arrayDatos['emailCliente']."' where idCliente=".$arrayDatos['idCliente']."";
 $crea=mysqli_query($con,$update);

/* Actualizo los datos de facturacion */
$update="UPDATE datosfacturacioncliente set razonSocial='".$arrayDatos['razonSocial']."', rfc='".$arrayDatos['rfc']."', direccion='".$arrayDatos['direccionCompleta2']."', cp='".$arrayDatos['codigoPostal2']."', entidadFederativa=".$arrayDatos['entidadFederativa2'].", municipioDelegacion=".$arrayDatos['municipioDelegacion2']." where idCliente=".$arrayDatos['idCliente']."";
mysqli_query($con,$update);

/* MODIFICO LOS GRUPOS Y SUBGRUPOS */
$number = count($_POST["idMontoCliente"]);
if($number>=1)
  {
    for($i=0; $i<$number; $i++)
       {
         if(trim($_POST["idMontoCliente"][$i]!= ''))
           {
               // Actualizo los telefonos y emails
    $sqltelefonos = "UPDATE montosclientes SET nombreAcuerdo='".$_POST["programaant"][$i]."', subgrupo='".$_POST["subgrupoant"][$i]."', montoautorizadocliente='".$_POST["montoautorizadoclienteant"][$i]."', contribucion='".$_POST["contribucionant"][$i]."', copago='".$_POST["copagoant"][$i]."' WHERE idMontoCliente=".$_POST["idMontoCliente"][$i]." ";
    mysqli_query($con, $sqltelefonos);
           }
       }
  }



            // inserto los grupos y subgrupos
            $number = count($_POST["montoautorizadocliente"]);
            if($number>=1)
            {
            for($i=0; $i<$number; $i++)
            {
            if(trim($_POST["montoautorizadocliente"][$i]!= ''))
            {
                // Insertamos la informacion enviada por el formulario
                $sql1 = "INSERT INTO montosclientes (idCliente, nombreAcuerdo, subgrupo, montoautorizadocliente, contribucion, copago, estatus) VALUES(".$idCliente.",'".$_POST["programa"][$i]."','".$_POST["subgrupo"][$i]."','".$_POST["montoautorizadocliente"][$i]."','".$_POST["contribucion"][$i]."','".$_POST["copago"][$i]."',1)";
                mysqli_query($con, $sql1);

                $SqlAjuste="INSERT INTO movimientosclientes (idCliente,idUsuario,tipoMovimiento,fechaMovimiento) values (".$idCliente.", ".$idUsuario.", 'SE AGREGO EL PROGRAMA ".$_POST["programa"][$i]." Y EL SUB GRUPO ".$_POST["subgrupo"][$i]."','".$hoy."')";
mysqli_query($con,$SqlAjuste); 
            }
            }
            }

        if (!$crea) { ?>
        <script type="text/javascript">
            window.location = "editarDatosCliente?do=2";
        </script> 
        <?php } else { ?>
        <script type="text/javascript">
             window.location="editarDatosCliente?do=1&idCliente=<?php echo $arrayDatos['idCliente'] ?>";
        </script>
        <?php }
}





function GETPOST() {
        $datos_getpost = array();
        if ($_POST) {
            if (array_key_exists('altaCliente', $_POST)) {
                $datos_getpost['altaCliente'] = $_POST['altaCliente'];
            }
            if (array_key_exists('editaCliente', $_POST)) {
                $datos_getpost['editaCliente'] = $_POST['editaCliente'];
            }
            if (array_key_exists('idCliente', $_POST)) {
                $datos_getpost['idCliente'] = $_POST['idCliente'];
            }
            if (array_key_exists('nombreCliente', $_POST)) {
                $datos_getpost['nombreCliente'] = $_POST['nombreCliente'];
            }
            if (array_key_exists('nombreClienteAnt', $_POST)) {
                $datos_getpost['nombreClienteAnt'] = $_POST['nombreClienteAnt'];
            }
            if (array_key_exists('situacionCliente', $_POST)) {
                $datos_getpost['situacionCliente'] = $_POST['situacionCliente'];
            }
            if (array_key_exists('situacionClienteAnt', $_POST)) {
                $datos_getpost['situacionClienteAnt'] = $_POST['situacionClienteAnt'];
            }
            if (array_key_exists('entidadFederativa', $_POST)) {
                $datos_getpost['entidadFederativa'] = $_POST['entidadFederativa'];
            }
            if (array_key_exists('entidadFederativaAnt', $_POST)) {
                $datos_getpost['entidadFederativaAnt'] = $_POST['entidadFederativaAnt'];
            }
            if (array_key_exists('municipioDelegacion', $_POST)) {
                $datos_getpost['municipioDelegacion'] = $_POST['municipioDelegacion'];
            }
            if (array_key_exists('municipioDelegacionAnt', $_POST)) {
                $datos_getpost['municipioDelegacionAnt'] = $_POST['municipioDelegacionAnt'];
            }         
            if (array_key_exists('direccionCompleta', $_POST)) {
                $datos_getpost['direccionCompleta'] = $_POST['direccionCompleta'];
            }
            if (array_key_exists('direccionCompletaAnt', $_POST)) {
                $datos_getpost['direccionCompletaAnt'] = $_POST['direccionCompletaAnt'];
            }
            if (array_key_exists('codigoPostal', $_POST)) {
                $datos_getpost['codigoPostal'] = $_POST['codigoPostal'];
            }
            if (array_key_exists('codigoPostalAnt', $_POST)) {
                $datos_getpost['codigoPostalAnt'] = $_POST['codigoPostalAnt'];
            }
            if (array_key_exists('telefonoCliente', $_POST)) {
                $datos_getpost['telefonoCliente'] = $_POST['telefonoCliente'];
            }
            if (array_key_exists('telefonoClienteAnt', $_POST)) {
                $datos_getpost['telefonoClienteAnt'] = $_POST['telefonoClienteAnt'];
            }
            if (array_key_exists('emailCliente', $_POST)) {
                $datos_getpost['emailCliente'] = $_POST['emailCliente'];
            }
            if (array_key_exists('emailClienteAnt', $_POST)) {
                $datos_getpost['emailClienteAnt'] = $_POST['emailClienteAnt'];
            }

            // datos de facturacio
            if (array_key_exists('razonSocial', $_POST)) {
                $datos_getpost['razonSocial'] = $_POST['razonSocial'];
            }
            if (array_key_exists('razonSocialAnt', $_POST)) {
                $datos_getpost['razonSocialAnt'] = $_POST['razonSocialAnt'];
            }
            if (array_key_exists('rfc', $_POST)) {
                $datos_getpost['rfc'] = $_POST['rfc'];
            }
            if (array_key_exists('rfcAnt', $_POST)) {
                $datos_getpost['rfcAnt'] = $_POST['rfcAnt'];
            }
            if (array_key_exists('direccionCompleta2', $_POST)) {
                $datos_getpost['direccionCompleta2'] = $_POST['direccionCompleta2'];
            }
            if (array_key_exists('direccionCompleta2Ant', $_POST)) {
                $datos_getpost['direccionCompleta2Ant'] = $_POST['direccionCompleta2Ant'];
            }
            if (array_key_exists('codigoPostal2', $_POST)) {
                $datos_getpost['codigoPostal2'] = $_POST['codigoPostal2'];
            }
            if (array_key_exists('codigoPostal2Ant', $_POST)) {
                $datos_getpost['codigoPostal2Ant'] = $_POST['codigoPostal2Ant'];
            }
            if (array_key_exists('entidadFederativa2', $_POST)) {
                $datos_getpost['entidadFederativa2'] = $_POST['entidadFederativa2'];
            }
            if (array_key_exists('entidadFederativa2Ant', $_POST)) {
                $datos_getpost['entidadFederativa2Ant'] = $_POST['entidadFederativa2Ant'];
            }
            if (array_key_exists('municipioDelegacion2', $_POST)) {
                $datos_getpost['municipioDelegacion2'] = $_POST['municipioDelegacion2'];
            }
            if (array_key_exists('municipioDelegacion2Ant', $_POST)) {
                $datos_getpost['municipioDelegacion2Ant'] = $_POST['municipioDelegacion2Ant'];
            }            
            if (array_key_exists('tipoRegimen', $_POST)) {
                $datos_getpost['tipoRegimen'] = $_POST['tipoRegimen'];
            }
            if (array_key_exists('tipoRegimenAnt', $_POST)) {
                $datos_getpost['tipoRegimenAnt'] = $_POST['tipoRegimenAnt'];
            }
            
        } else if ($_GET) {
            
        }
        return $datos_getpost;
}
}
?>